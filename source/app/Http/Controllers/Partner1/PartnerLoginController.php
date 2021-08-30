<?php

namespace App\Http\Controllers\partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;

class PartnerLoginController extends Controller
{
  public function partnerlogin(Request $request)
  {
    if(Session::has('index')){
        return redirect()->route('index');    
    }
    
    $logo = DB::table('tbl_web_setting')
                ->where('id', '1')
                ->first();
                
  	return view('partner.login', compact('logo'));
  }

  public function partnerlogincheck(Request $request)
  {	
  	$email = $request->email;
    $password = $request->password;

    $adminLoginCheck = DB::table('partner')
                      ->where('partner_email',$email)
            			    ->first();
    $password1 =   $adminLoginCheck->partner_password;		    

    if($adminLoginCheck){
      if ($password==$password1) {
        Session::put('index', $adminLoginCheck->partner_email);
        
          $about = DB::table('booking')
                        ->get();
        
        return redirect()->route('index');
      }
      else{
        return redirect()->route('adminLogin')->withErrors('Wrong Password');
      }
    }
    else{
      return redirect()->route('adminLogin')->withErrors('Email/Password Wrong');
    }
  }
}
