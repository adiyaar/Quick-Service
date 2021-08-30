<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Hash;
use Session;

class PartnerLoginController extends Controller
{
  public function partnerLogin(Request $request)
  {
    if(Session::has('bamaPartner')){
        return redirect()->route('index');    
    }
    
    $logo = DB::table('tbl_web_setting')
                ->where('id', '1')
                ->first();
                
//   	return view('web.layout.app', compact('logo'));
   	return view('web.login.login', compact('logo'));
  	 //	return view('web.layout.lead_preview', compact('logo'));
  }

  public function partnerLoginCheck(Request $request)
  {	
  	$email = $request->email;
    $password = $request->password;

    $adminLoginCheck = DB::table('partner')
                      ->where('partner_email',$email)
            			    ->first();
    $password1 =   $adminLoginCheck->partner_password;		    

    if($adminLoginCheck){
      if ($password==$password1) {
        Session::put('bamaPartner', $adminLoginCheck->partner_id);
       
       
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
  
  public function partnerSignUp(Request $request)
  {
      
      $category = DB::table('category')
                    ->get();
                    
      $city = DB::table('partner_city')
                    ->get();                
      
      $this->validate(
            $request,
                [
                    
                    'partner_name'=>'required',
                    'partner_email'=>'required',
                    'partner_number'=>'required',
                    'profession'=>'required',
                ],
                [
                    
                    'partner_name.required'=>'Name Required',
                    'partner_email.required'=>'E-mail Required',
                    'partner_number.required'=>'Phone Number Required',
                    'profession.required'=>'Profession Required',
                ]
        );
            $partner_name = $request->partner_name;
            $partner_email = $request->partner_email;
            $partner_number = $request->partner_number;
            $profession = $request->profession;
            $partner_password = $request->partner_password;
            $category = $request->category;
            $city = $request->city;
            $Partner_add = $request->Partner_add;
            
            
             $insert = DB::table('partner')
                    ->insert([
                        'partner_name'=>$partner_name,
                        'partner_phone'=>$partner_number,
                        'partner_email'=>$partner_email,
                        'partner_profesion'=>$profession,
                        'partner_password'=>$partner_password,
                        'category_id'=>$category,
                        'city__id'=>$city,
                        'address'=>$Partner_add
                        ]);
        return view('partner.index',compact("category","partner_city"));
  }
  

 
   public function partnerSignUp1(Request $request)
    {
         $name=$request->name;
         $phone=$request->phone;
         $email=$request->email;
         $profession=$request->profession;
         $category_id=$request->category_id;
         $location_city=$request->location_city;
         $partner_address=$request->partner_address;
         $partner_password="1234";
  
        
    if($name == '' || $phone == '' || $email == '' || $profession == '' || $category_id == '' || $location_city == '' || $partner_address == '')
    {
         $msg = json_encode (array('st'=>1,'msg'=>'fill all field','name'=>$name,'phone'=>$phone,'email'=>$email,'profession'=>$profession,'category_id'=>$category_id,'location_city'=>$location_city,'partner_address'=>$partner_address));
    }
    elseif(strlen($phone) != 10)
    {
         $msg = json_encode (array('st'=>2,'msg'=>'Number Should be 10 Digits'));
    }
    else
    {
               
       $partner= DB::table('partner')
                ->where('partner_email',$email)
                ->where('partner_phone',$phone)
                ->get();   
       if(count($partner)>0)
       {
         $msg = json_encode (array('st'=>3,'email'=>$email,'phone'=>$phone,'msg'=>'Email & Phone Already Exist'));   
       }
       else
       {
               //for api_key
           $msg91 = DB::table('tbl_msg_key')
                   ->first(); 
           $api_key=$msg91->mag_auth_key;
           $sender_id=$msg91->mag_sender_id;
           if($api_key==0)
           {
             	$chars = "0123456789";
            $otpval = "";
            for ($i = 0; $i < 4; $i++){
                $otpval .= $chars[mt_rand(0, strlen($chars)-1)];
            }
            $getInvitationMsg = "Your Urbanclap OTP is:".$otpval.".\nNote:Please DO NOT SHARE this OTP with anyone.";
            
            $authKey = $api_key;
            $mobileNumber = $phone;
            $senderId = $sender_id;
            $message = $getInvitationMsg;
            $route = "4";
            $postData = array(
                'authkey' => $authKey,
                'mobiles' => $mobileNumber,
                'message' => $message,
                'sender' => $senderId,
                'route' => $route
            );
			
           $url="https://control.msg91.com/api/sendhttp.php";

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postData
                //,CURLOPT_FOLLOWLOCATION => true
            ));


            //Ignore SSL certificate verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            //get response
            $output = curl_exec($ch);
            if(curl_errno($ch))
            {
            // return redirect()->back()->withErrors('Something Wents Wrong');
            }
  
           }
		
          $insert = DB::table('partner')
                    ->insert([
                        'partner_name'=>$name,
                        'partner_phone'=>$phone,
                        'partner_email'=>$email,
                        'partner_profesion'=>$profession,
                        'partner_password'=>$partner_password,
                        'category_id'=>$category_id,
                        'city__id'=>$location_city,
                        'address'=>$partner_address,
                        'otp_value'=>1234,
                        'otp_status'=>0
                        ]);  
           if ($insert)
            {
                 $msg = json_encode (array('st'=>4, 'phone'=>$phone,'message'=>'OTP Sent for Reg.'));
            }
            else{
                 $msg = json_encode (array('st'=>5, 'message'=>'Something Wrong in Reg.'));
            }
       }
   
    }
    return  $msg;                       	
    	
    }
  public function varifyotp(Request $request)
         
    {
        $phone=$request->phone;
        return view('web.login.otp', compact('phone'));
    }
  public function checkotp(Request $request)
    {
        $otp=$request->otp;
        $phone=$request->phone;
         $partner= DB::table('partner')
                ->where('partner_phone',$phone)
                ->first();
         if($partner->partner_id!="" && $partner->otp_value==$otp)
       { 
          $update = DB::table('partner')
         ->where('partner_id',$partner->partner_id)
         ->update(['otp_status'=>1]);
         
          Session::put('bamaPartner', $partner->partner_id);
          return redirect()->route('index');
       
       }
     else
         {
             return redirect()->back()->withErrors('Wrong OTP');
         }
    }
    public function homeforcheck(Request $request)
    
    {
        
         
    }
    public function details(Request $request)
    {
        return view('partner.details');
    }
}
