<?php

use App\Models\General;
use App\Models\Media;
use App\Models\Country;
use App\Models\Cart;
use App\Models\WishList;
use App\Models\Post;
use App\Models\PostExtra;
use App\Models\Attribute;
use Carbon\Carbon;


function general(){
  return General::settings();
}

function websiteTitle($title=null){
  
  $hasTitle =$title?' - ':'';
  $text =general()->title;
  $text1=general()->subtitle;
  $text2=$text&&$text1?' - ':'';
  if($title){
    return $title.$hasTitle.$text;
  }else{
    return $text.$text2.$text1;
  }
  
}

function isMobileDevice() {
  return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
, (string) request()->userAgent());
}

function adminTheme(){
  $theme=general()->adminTheme.'.';
  if(isMobileDevice()){
    $theme=general()->adminTheme.'.';
  }
  return $theme;
}

function welcomeTheme(){
  $theme=general()->theme.'.';
  if(isMobileDevice()){
    $theme=general()->theme.'.';
  }
  return $theme;
}

function assetLink(){
  return 'public/'.general()->theme;
}

function assetLinkAdmin(){
  return 'public/'.general()->adminTheme;
}

function geoData($type=null,$parent=null,$id=null){

  $data =Country::orderBy('name')->select(['id','type','parent_id','name']);
  if($type){
    $data =$data->where('type',$type);
  }

  if($parent){
    $data =$data->where('parent_id',$parent);
  }

  if($id){
    $data =$data->find($id);
  }else{
    $data =$data->get();
  }
  
  return $data;
}

function bn2enNumber ($number){
  $search_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
  $replace_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
  $en_number = str_replace($search_array, $replace_array, $number);

  return $en_number;
}

function en2bnNumber ($number){
  $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
  $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
  $en_number = str_replace($search_array, $replace_array, $number);

  return $en_number;
}

function en2bnMonth($month){
  $search_array= array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October","November","December","Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct","Nov","Dec","01", "02", "03", "04", "05", "06", "07", "08", "09", "10","11","12");
  $replace_array= array("জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগষ্ট", "সেপ্টেম্বর", "অক্টোবর","নভেম্বর","ডিসেম্বর","জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগষ্ট", "সেপ্টেম্বর", "অক্টোবর","নভেম্বর","ডিসেম্বর","জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগষ্ট", "সেপ্টেম্বর", "অক্টোবর","নভেম্বর","ডিসেম্বর");
  $en_number = str_replace($search_array, $replace_array, $month);
  return $en_number;
}

function priceFormat($amount=0)
{
  $formatAmount ='';
  $formatAmount = number_format($amount,general()->currency_decimal);
  return $formatAmount;
}

function priceFullFormat($amount=0)
{
  $formatAmount ='';
  $amountFormat = number_format($amount,general()->currency_decimal);
  if(general()->currency_position==0){
    $formatAmount = general()->currency.' '.$amountFormat;
  }else{
     $formatAmount = $amountFormat.' '.general()->currency;
  }
  return $formatAmount;
}

/**
 * Where admin copies (orders, contact/enquiry forms) go: Settings > Mail >
 * "Admin Mails" (comma or new-line separated), or the "Mail From Address".
 */
function adminMailRecipients(){
  $list = preg_split('/[\s,;]+/', (string) general()->admin_mails, -1, PREG_SPLIT_NO_EMPTY);
  $list = array_values(array_unique(array_filter($list, fn ($e) => filter_var($e, FILTER_VALIDATE_EMAIL))));
  if(!$list && filter_var(general()->mail_from_address, FILTER_VALIDATE_EMAIL)){
    $list = [general()->mail_from_address];
  }
  return $list;
}

/**
 * Send a mail using the Settings > Mail configuration. $toEmail may be one
 * address or a list. Returns true/false; failures are written to the log
 * (storage/logs/laravel.log) so a wrong mail setting can be diagnosed.
 * With $throw = true the exception is re-thrown (used by "Send Test Mail").
 */
function sendMail($toEmail,$toName,$subject,$datas,$template,$attachments=null,$throw=false){

  $to = array_values(array_filter((array) $toEmail, fn ($e) => filter_var($e, FILTER_VALIDATE_EMAIL)));
  if(!$to){
    return false;
  }
  if(!filter_var(general()->mail_from_address, FILTER_VALIDATE_EMAIL)){
    \Illuminate\Support\Facades\Log::warning('Mail not sent: "Mail From Address" is not set in Settings > Mail.', ['subject' => $subject]);
    if($throw){ throw new RuntimeException('"Mail From Address" is not set.'); }
    return false;
  }

  try {
    Mail::send($template,compact('datas'), function ($message) use ($to,$toName,$subject,$attachments) {
        $message->from(general()->mail_from_address, general()->mail_from_name ?: general()->title);
        if(count($to) === 1){
          $message->to($to[0], $toName);
        }else{
          $message->to($to);
        }
        $message->subject($subject);

        if($attachments){
            // Attachments
            foreach ($attachments as $attachment) {
                $message->attach($attachment['path'], [
                    'as' => $attachment['name'],
                    'mime' => $attachment['mime'],
                ]);
            }
        }
    });

     return true;
  } catch (\Throwable $ex) {
      \Illuminate\Support\Facades\Log::warning('Mail not sent: '.$ex->getMessage(), ['subject' => $subject, 'to' => $to]);
      if($throw){ throw $ex; }
      return false;
  }

}

function sendSMS($to,$msg){
  $userId = general()->sms_username;
  $pass = general()->sms_password;
  $masking = general()->sms_senderid;
  if(general()->sms_type=='Non Masking'){
  $url =general()->sms_url_nonmasking; 
  return "{$url}?username={$userId}&password={$pass}&number={$to}&message={$msg}";
  }else{
  $url =general()->sms_url_masking;
  return "{$url}?username={$userId}&password={$pass}&number={$to}&message={$msg}&senderid={$masking}";
  }
}

function slider($location=null){
  return Attribute::latest()->where('type',1)->where('status','active')->where('location',$location)->first();
}

function gallery($location=null){
  return Attribute::latest()->where('type',4)->where('status','active')->where('location',$location)->first();
}

function menu($location=null){
  // Layouts call menu() several times per page; load each menu once, with its
  // items and their links eager-loaded instead of one query per item.
  static $menus = [];
  $key = (string) $location;
  if(!array_key_exists($key, $menus)){
    $links = ['pagelink','blogCtglink','productCtglink'];
    $with = [];
    foreach($links as $l){
      $with[] = 'subMenus.'.$l;
      $with[] = 'subMenus.subMenus.'.$l;
    }
    $menus[$key] = Attribute::latest()->where('type',8)->where('status','active')->where('location',$location)
      ->with($with)
      ->first();
  }
  return $menus[$key];
}

function page($id=null){
  return Post::where('type',0)->find($id);
}

function pageTemplate($template=null){
  return Post::where('type',0)->where('template',$template)->first();
}




/**
 * Uploaded files are stored under public/, so never accept anything that a
 * web server could execute. Aborts with 422 for disallowed files.
 */
function assertSafeUpload($file){
  $allowed = ['png','jpg','jpeg','gif','webp','svg','ico','bmp','pdf','doc','docx','xls','xlsx','csv','txt','zip','rar','mp4','webm','mov','wmv','mp3'];
  $ext = strtolower((string) $file->getClientOriginalExtension());
  $name = strtolower((string) $file->getClientOriginalName());

  if(!$file->isValid() || !in_array($ext, $allowed, true) || preg_match('/\.(php\d?|phtml|phar|pht|shtml|cgi|pl|py|sh|htaccess|exe|js|html?)(\.|$)/', $name)){
    abort(422, 'This file type is not allowed.');
  }

  // Content must not be a script disguised with an allowed extension.
  $mime = strtolower((string) $file->getMimeType());
  if(str_contains($mime, 'php') || str_contains($mime, 'x-sh') || str_contains($mime, 'javascript') || $mime === 'text/html'){
    abort(422, 'This file type is not allowed.');
  }

  return $ext;
}

function uploadFile($file,$src,$srcType,$fileUse,$author=null,$fileStatus=true){
  assertSafeUpload($file);


  if($fileStatus){
      $media = Media::where('src_type',$srcType)->where('use_Of_file',$fileUse)->where('src_id',$src)->first();
  }else{
      $media = null;
  }

  if(!$media){
    $media =new Media();
    }else{
      if(File::exists($media->file_url)){
            File::delete($media->file_url);
        }
        if(File::exists($media->file_url_sm)){
            File::delete($media->file_url_sm);
        }
        if(File::exists($media->file_url_md)){
            File::delete($media->file_url_md);
        }
        if(File::exists($media->file_url_lg)){
            File::delete($media->file_url_lg);
        }
    }
    
    $name = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
    $fullname = basename($file->getClientOriginalName());
    $ext =$file->getClientOriginalExtension();
    $size =$file->getSize();
    $mimeType = $file->getMimeType();

    $year =carbon::now()->format('Y');
    $month =carbon::now()->format('M');
    $folder = $month.'-'.$year;

    $img =time().'.'.uniqid().'.'.$file->getClientOriginalExtension();
    $path ="medies/".$folder;
    $fullpath ="public/medies/".$folder.'/'.$img;
    $media->src_type=$srcType;
    $media->use_Of_file=$fileUse;
    $media->src_id=$src;
    $media->file_name=Str::limit($fullname,250);
    $media->alt_text=Str::limit($name,250);
    $media->file_rename=Str::limit($img,100);
    $media->file_size=$size;
    $media->mine_type=$mimeType;
    if($ext=='png' || $ext=='jpeg' || $ext=='svg' || $ext=='gif' || $ext=='jpg' || $ext=='webp'){
      $media->file_type=1;
      }elseif($ext=='pdf'){
      $media->file_type=2;
      }elseif($ext=='docx'){
      $media->file_type=3;
      }elseif($ext=='zip' || $ext=='rar'){
      $media->file_type=4;
      }elseif($ext=='mp4' || $ext=='webm' || $ext=='mov' || $ext=='wmv'){
      $media->file_type=5;
      }elseif($ext=='mp3'){
      $media->file_type=6;
    }
    $file->move(public_path($path), $img);
    $media->file_url =$fullpath;
    $media->file_path =$path;
    $media->addedby_id=$author;
    $media->save();

    return $media;

}


