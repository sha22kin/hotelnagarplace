<?php

namespace App\Http\Controllers\Customer;

use Auth;
use Hash;
use Session;
use Response;
use Cookie;
use Str;
use File;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Country;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Media;
use App\Models\General;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderReturnItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    
      

    public function dashboard(Request $request){
        $user =Auth::user();
        
        return view(welcomeTheme().'customer.dashboard',compact('user'));
    }

    public function profile(Request $r){
        $user =Auth::user();
        
        
        if($r->isMethod('post')){
            $check = $r->validate([
                'name' => 'required|max:100',
                'email' => 'required|max:100|unique:users,email,'.$user->id,
                'mobile' => 'nullable|max:20|unique:users,mobile,'.$user->id,
                'district' => 'nullable|numeric',
                'city' => 'nullable|numeric',
                'postal_code' => 'nullable|max:20',
                'address' => 'nullable|max:200',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $user->name =$r->name;
            $user->mobile =$r->mobile;
            $user->email =$r->email;
            $user->company_name =$r->company;
            $user->district =$r->prefecture;
            $user->city_name =$r->city;
            $user->address_line1 =$r->address;
            $user->postal_code =$r->postal_code;
            
            ///////Image Upload Start////////////
            if($r->hasFile('image')){
                $file =$r->image;
                $src  =$user->id;
                $srcType  =6;
                $fileUse  =1;
                $author=$user->id;
                uploadFile($file,$src,$srcType,$fileUse,$author);
            }
            ///////Image Upload End////////////
            $user->save();
            Session::flash('success','Your Are Successfully Done');
            return redirect()->back();
        }
      return view(welcomeTheme().'customer.profile',compact('user'));
    }
    

    public function changePassword(Request $r){
        $user = Auth::user();
        if($r->isMethod('post')){
            $check = $r->validate([
                'current_password' => 'required|string|min:8',
                'password' => 'required|string|min:8|confirmed|different:current_password',
            ]);

            if(Hash::check($r->current_password, $user->password)){
                $user->password=Hash::make($r->password);
                $user->save();
                Session()->flash('success','Your Are Successfully Done');
                return redirect()->back();
            }else{
                Session()->flash('error','Current Password Are Not Match');
                return redirect()->back();
            }

        }

      return view(welcomeTheme().'customer.changePassword');
    }

















    



}
