<?php

namespace App\Http\Controllers\Welcome;

use Image;
use Auth;
use Hash;
use Str;
use Session;
use Carbon\Carbon;
use App\Models\Country;
use App\Models\Post;
use App\Models\Media;
use App\Models\PostExtra;
use App\Models\User;
use App\Models\Attribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class WelcomeController extends Controller
{
  
    public function index(Request $r){
      // Hotel Nagar Palace theme: the home page content (Pages > "Home",
      // template "Front Page") and the "Front Page Slider" come from the admin.
      $page =pageTemplate('Front Page');
      return view('hotel.index', compact('page'));
    }

	public function geo_filter($id){

      $datas=Country::where('parent_id',$id)->get();

      $geoData =View('geofilter',compact('datas'))->render();

       return Response()->json([
              'success' => true,
              'geoData' => $geoData,
            ]);
    }
    
    public function imageView2(Request $r,$template=null,$image=null){
        // Clamp sizes so a request cannot make the server allocate huge images.
        $weight = is_numeric($r->w) ? max(1, min(2500, (int) $r->w)) : null;
        $height = is_numeric($r->h) ? max(1, min(2500, (int) $r->h)) : null;

        $filePath='public/medies/noimage.jpg';
        $file=null;

        if($image){
            $file =Media::where('file_rename',$image)->select(['file_url'])->first();
            if($file){
                $filePath = $file->file_url;
            }
        }

        if($template=='s-profile' && !($image && $image!='profile.png' && $file)){
            $filePath ='public/medies/profile.png';
        }

        $source = base_path($filePath);
        $mediaRoot = realpath(base_path('public/medies'));
        $real = realpath($source);
        if(!$real || !$mediaRoot || !str_starts_with($real, $mediaRoot) || !is_file($real)){
            $real = base_path('public/medies/noimage.jpg');
        }

        $resizeTemplates = ['sm-resize', 'resize', 'brand-fit'];
        $doResize = in_array($template, $resizeTemplates, true) && $weight && $height;
        $headers = ['Cache-Control' => 'public, max-age=2592000, immutable'];

        if(!$doResize){
            return response()->file($real, $headers);
        }

        // Resized copies are cached on disk; resizing on every hit was slow.
        $ext = strtolower(pathinfo($real, PATHINFO_EXTENSION)) ?: 'jpg';
        $cacheDir = storage_path('framework/cache/images');
        $cacheFile = $cacheDir.'/'.md5($real.'|'.filemtime($real).'|'.$template.'|'.$weight.'|'.$height).'.'.$ext;

        if(!is_file($cacheFile)){
            if(!is_dir($cacheDir)){
                @mkdir($cacheDir, 0755, true);
            }
            $mImage = Image::make($real);
            $mImage = $template == 'brand-fit' ? $mImage->fit($weight,$height) : $mImage->resize($weight,$height);
            $mImage->save($cacheFile, 85);
        }

        return response()->file($cacheFile, $headers);
    }
    
    
    public function siteMapXml(Request $r){
        
      $pages = Post::latest()->where('type',0)->where('status','active')
        ->where(fn ($q) => $q->whereNull('template')->orWhereNotIn('template', ['Front Page','Latest Products','All Brands','Offer Products','Product Request']))
        ->select(['slug','updated_at','status','fetured'])->limit(200)->get();
      $posts = Post::latest()->where('type',1)->where('status','active')->select(['slug','updated_at','status'])->limit(500)->get();
      
      return response()->view('siteMap',compact('pages','posts'))->header('Content-Type', 'text/xml');
    }
    
    public function language($lang=null){
      if($lang){
          Session::put('lang',$lang);
      }else{
          Session::put('lang','en');
      }
      return redirect()->back();
    }






    public function blogCategory($slug){
      $category =Attribute::latest()->where('type',6)->where('slug',$slug)->first();
      if(!$category){
        return abort('404');
      }

      $posts = $category->activePosts()->latest()
      ->select(['id','name','slug','short_description','addedby_id','created_at'])
      ->paginate(10);

      return view(welcomeTheme().'blogs.categoryPosts',compact('category','posts'));
    }

    public function blogTag($slug){
      $tag =Attribute::latest()->where('type',7)->where('slug',$slug)->first();
      if(!$tag){
        return abort('404');
      }

      $posts = Post::whereHas('tagPosts',function($q) use($tag){
        $q->where('reff_id',$tag->id);
      })
      ->where(function($qq){
        $qq->where('status','active');
      })
      ->select(['id','name','slug','short_description','addedby_id','created_at'])
      ->whereDate('created_at','<=',date('Y-m-d'))
      ->paginate(10);

      return view(welcomeTheme().'blogs.tagPosts',compact('tag','posts'));
    }

    public function blogAuthor($id,$slug){
      $author =User::find($id);
      if(!$author){
        return abort('404');
      }
      $posts =$author->posts()->latest()->where('type',1)->where('status','active')
      ->select(['id','name','slug','short_description','addedby_id','created_at'])
      ->whereDate('created_at','<=',date('Y-m-d'))
      ->paginate(10);
      return view(welcomeTheme().'blogs.authorPosts',compact('author','posts'));

    }

    public function blogView($slug){
      $post =Post::where('type',1)->where('slug',$slug)->first();
      if(!$post){
        return abort('404');
      }
      $relatedPosts =$post->relatedPosts()->limit(4)->select(['id','name','slug','short_description','addedby_id','created_at'])->get();
      $comments =$post->postComments()->where('status','active')->select(['id','name','content','created_at'])->paginate(10);
      return view(welcomeTheme().'blogs.blogView',compact('post','relatedPosts','comments'));

    }

    public function blogSearch(Request $r){
      $check = $r->validate([
          'search' => 'required|max:100',
      ]);
      
      $posts =Post::latest()->where('type',1)->where('status','active')
      ->where(function($q) use ($r) {
        if($r->search){
          $q->where('name','LIKE','%'.$r->search.'%');
        }

      })
      ->select(['id','name','slug','short_description','addedby_id','created_at'])
      ->whereDate('created_at','<=',date('Y-m-d'))
      ->paginate(10)->appends([
        'search'=>$r->search,
      ]);

      return view(welcomeTheme().'blogs.blogSearch',compact('posts','r'));

    }

    public function blogComments(Request $r,$slug){
      $post =Post::where('type',1)->where('slug',$slug)->first();
      if(!$post){
        return abort('404');
      }

      $check = $r->validate([
          'name' => 'required|max:100',
          'email' => 'required|max:100',
          'website' => 'required|max:100',
          'comment' => 'required|max:1000',
      ]);

      $comments =new Review();

      if(Auth::check()){
      $comments->addedby_id=Auth::id();
      }
      $comments->src_id=$post->id;
      $comments->type=1;
      $comments->name=$r->name;
      $comments->email=$r->email;
      $comments->website=$r->website;
      $comments->content=$r->comment;
      $comments->save();

      Session()->flash('success','Your Comments successfully Submitted.');

      return back();


    }

    public function pageView($slug){
      $page =Post::latest()->where('type',0)->where('slug',$slug)->where('status','active')->first();
      if(!$page){
        return abort('404');
      }

      // Templates of the removed e-commerce part (shop, brands, offers, product request).
      if(in_array($page->template, ['Latest Products','All Brands','Offer Products','Product Request'], true)){
        return abort('404');
      }

      //Font Home Page
      if($page->template=='Front Page'){
        return redirect()->route('index');
      }

      // Hotel Nagar Palace theme pages
      if($page->template=='gallery'){
        return view('hotel.gallery',compact('page'));
      }
      if($page->template=='Book Now'){
        return view('hotel.bookNow',compact('page'));
      }
      if($page->template=='Rooms'){
        return view('hotel.rooms',compact('page'));
      }
      if($page->template=='Services'){
        return view('hotel.services',compact('page'));
      }
      if(in_array($page->template, [null, '', 'About Us', 'Service'], true)){
        return view('hotel.page',compact('page'));
      }

      //Contact Us Page
      if($page->template=='Contact Us'){
        return view(welcomeTheme().'pages.contactUs',compact('page'));
      }

      //Get A Quote Page
      if($page->template=='Get A Quote'){
        return view(welcomeTheme().'pages.getAQuote',compact('page'));
      }

      //Latest Blog Page
      if($page->template=='Latest Blog'){
        $posts = Post::latest()->where('type',1)->where('status','active')
        ->select(['id','name','slug','short_description','addedby_id','created_at'])
        ->whereDate('created_at','<=',date('Y-m-d'))
        ->paginate(10);
        return view(welcomeTheme().'blogs.latestBlogs',compact('posts','page'));
      }

      return view('hotel.page',compact('page'));

    }

    // "Book Now" page form: mail the booking request to Settings > Mail > Admin Mails.
    public function bookingMail(Request $r){
        $r->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|max:30',
            'package' => 'nullable|max:200',
            'date_start' => 'nullable|max:50',
            'date_end' => 'nullable|max:50',
            'message' => 'nullable|max:1000',
        ]);

        $package = $r->package && $r->package !== 'Select Package' ? $r->package : 'Not selected';
        $details = 'Package: '.$package."\n"
            .'Booking Date Start: '.($r->date_start ?: 'N/A')."\n"
            .'Booking Date End: '.($r->date_end ?: 'N/A');
        $datas = ['r' => [
            'name' => $r->name,
            'email' => $r->email,
            'mobile' => $r->phone,
            'subject' => 'Booking request - '.$package,
            'message' => $details.($r->message ? "\n\n".$r->message : ''),
        ]];

        $sent = general()->mail_status
            && sendMail(adminMailRecipients(), general()->mail_from_name, 'Booking request - '.$r->name, $datas, 'mails.ContactMail');

        if(!$sent){
            $phone = general()->mobile ? ' Please call us: '.general()->mobile : '';
            Session()->flash('error', 'Sorry, your booking request could not be sent right now.'.$phone);
            return back()->withInput();
        }

        return back()->with('booking_sent', true);
    }

    public function contactMail(Request $r){
        // return $r;
          $check = $r->validate([
              'name' => 'required|max:100',
              'email' => 'required|max:100',
              'mobile' => 'nullable|max:100',
              'subject' => 'nullable|max:100',
              'message' => 'nullable|max:500',
          ]);

        if(general()->mail_status && general()->mail_from_address){
            //Mail Data
            $datas =array('r'=>$r);
            $template ='mails.ContactMail';
            $toEmail =adminMailRecipients();
            $toName =general()->mail_from_name;
            $subject ='Contact Mail Form '.general()->title;
        
            sendMail($toEmail,$toName,$subject,$datas,$template);
        }

      Session()->flash('success','Your Form send successfully done. We are response as soon as possible.');
      return back();
    }




    public function subscribe(Request $r){

      if(filter_var($r->email, FILTER_VALIDATE_EMAIL)){
        $subscribe =PostExtra::latest()->where('type',1)->where('name',$r->email)->first();

        if(!$subscribe){
          
            $subscribe =new PostExtra();
            $subscribe->type=1;
            $subscribe->name=$r->email;
            $subscribe->save();
          $status=true;
          $message ='<b>Success:</b> You Are Successfully Subsribe.';
        }else{
          $status=true;
          $message ='<b>Note:</b> You Are Already Subsribe.Thank You.';
        }


      }else{
        $status=false;
        $message ='<b>Error:</b> Email Are Not validated';
      }

      if(request()->ajax()){
        
        return Response()->json([
                'success' => $status,
                'message' => $message,
              ]);
      }

      Session()->flash($status?'success':'error',$message);
      return redirect()->back();

    }





}
