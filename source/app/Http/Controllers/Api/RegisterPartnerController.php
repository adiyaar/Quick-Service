<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class RegisterPartnerController extends Controller
{
     public function partner_reg(Request $request)
    {
        
        $partner_name=$request->partner_name;
        $partner_phone=$request->partner_phone;
        $partner_email=$request->partner_email;
        $partner_profesion=$request->partner_profesion;
        $partner_password=$request->partner_password;
        $partner_image=$request->partner_image;
        $address=$request->partner_add;
        $addres = str_replace(" ", "+", $address);
        $address1 = str_replace("-", "+", $addres);
        $city=$request->city_id;
        $category_id=$request->category_id;
        $device_id=$request->device_id;
        $delivery_range=$request->delivery_range;
        $sub_cat_id=$request->sub_cat_id;
        $sub_child_cat_id =$request->sub_child_cat_id;
        
        
        $google_map = DB::table('gmap_key')
                    ->first(); 
                    $map =   $google_map->map_key;  
                
        
        
        
        $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address1."&key=".$map));
        
        
         $lat = $response->results[0]->geometry->location->lat;
         $lng = $response->results[0]->geometry->location->lng;
        
        
        
        
        // $category = DB::table('sub_child_category')
        //                     ->get();
        
    	$scratch = DB::table('partner')
                    ->insertGetId([
                        'partner_name'=>$partner_name,
                        'partner_phone'=>$partner_phone,
                        'partner_email'=>$partner_email,
                        'partner_profesion'=>$partner_profesion,
                        'partner_password'=>$partner_password,
                        'category_id'=>$category_id,
                        'partner_image'=>$partner_image,
                        'address'=>$address,
                        'city__id'=>$city,
                        'lat'=>$lat,
                        'device_id'=>$device_id,
                        'add_city_stat'=>0,
                        'lng'=>$lng,
                        'range'=>$delivery_range,
                        'sub_cat_id'=>$sub_cat_id,
                        'child_cat_id'=>$sub_child_cat_id
                        
                        ]);
    				

    	if($scratch){
    	    
    	     $user = DB::table('partner')
                        ->where('partner_phone', $partner_phone)
                        ->first();
    	    
    		$message = array('status'=>'1', 'message'=>'Register Sucessfully', 'data'=>$user);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
    
    public function partner_profile_update(Request $request)
    {
        
        $partner_name=$request->partner_name;
        $partner_profesion=$request->partner_profesion;
        $delivery_range=$request->delivery_range;
        $partner_id=$request->partner_id;
        
          if($request->user_profile){
                    $user_profile = $request->user_profile;
                    $user_profile = str_replace('data:image/png;base64,', '', $user_profile);
                    $fileName = date('dmyHis').'user_profile'.'.'.'png';
                    $fileName = str_replace(" ", "-", $fileName);
                    $pth = str_replace("source/", "",public_path());
                    \File::put($pth. '/images/user/profile/' . $fileName, base64_decode($user_profile));
                    $user_profile ='/public/images/user/profile/'.$fileName;
                }
                
            
            else{
                    $old_image = DB::table('partner')
                                ->where('partner_id',$partner_id)
                                ->first();
                        $user_profile =   $old_image->partner_image;    
            
            }
        
    	$scratch = DB::table('partner')
    	            ->where('partner_id',$partner_id)
                    ->update([
                        'partner_name'=>$partner_name,
                        'partner_profesion'=>$partner_profesion,
                        'partner_image'=>$user_profile,
                         'range'=>$delivery_range]);
    				
        
    	if($scratch){
    	    
    	     $user = DB::table('partner')
                        ->where('partner_id', $partner_id)
                        ->first();
    	    
    		$message = array('status'=>'1', 'message'=>'Register Sucessfully', 'data'=>$user);
            return $message;
    	}
        
    	else{
    		$message = array('status'=>'0', 'message'=>'Something Went Wrong', 'data'=>[]);
            return $message;
        	}
    
}

   public function partner_pass_otp(Request $request)
    {
        $user_phone = $request->partner_phone;
        $user_phone = str_replace("+91","", $user_phone);
        $user_phone = ltrim($user_phone, "0");
        $checkUser = DB::table('partner')
                        ->where('partner_phone', $user_phone)
                        ->first();

        if($checkUser){
                $getOtpOption = DB::table('tbl_web_setting')
                                ->where('id', '12')
                                ->where('value', '1')
                                ->first();
                                
                if($getOtpOption){
                    $getAuthKeys = DB::table('tbl_msg_key')
                                    ->where('id', '1')
                                    ->first();
                                    
                    // send SMS
                    $chars = "0123456789";
                        $otpval = "";
                        for ($i = 0; $i < 4; $i++){
                          $otpval .= $chars[mt_rand(0, strlen($chars)-1)];
                        }
    
                    $getAuthKey = $getAuthKeys->mag_auth_key;
                    $getSenderId = $getAuthKeys->mag_sender_id;
                    $getInvitationMsg = "Your verification code is"; 
    
                    $authKey = $getAuthKey;
                    $mobileNumber = $user_phone;
                    $senderId = $getSenderId;
                    $message = $getInvitationMsg." ".$otpval;
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
                    if(curl_errno($ch)){
                        // return redirect()->back()->withErrors('Something Wents Wrong');
                    }
    
                    curl_close($ch);
                }
                else{
                    $otpval = "1234";
                }
                
                $updateOtp = DB::table('partner')
                                ->where('partner_phone', $user_phone)
                                ->update([
                                    'otp_value'=>$otpval,
                                ]);

                if($updateOtp){
                    $user = DB::table('partner')
                           ->where('partner_phone', $user_phone)
                            ->first();

                    $message = array('status'=>'1', 'message'=>'otp send successfully', 'data'=>$user);
                    return $message;
                }
                else{
                    $message = array('status'=>'0', 'message'=>'something wents wrong', 'data'=>[]);
                    return $message;
                }
        }
         else{
                $message = array('status'=>'2', 'message'=>'user not registered', 'data'=>$checkUser);
                return $message;
            }
    }


    public function verify_otp_pass(Request $request)
    {
        $user_phone = $request->partner_phone;
        
        $otp_value = $request->otp_value;

        $getUser = DB::table('partner')
                        ->where('partner_phone', $user_phone)
                        ->first();

        if($otp_value == $getUser->otp_value){
            $updateUser = DB::table('partner')
                            ->where('partner_phone', $user_phone)
                            ->update(['otp_value'=>null,'otp_status'=>1]);

            $user = DB::table('partner')
                        ->where('partner_phone', $user_phone)
                        ->first();

            $message = array('status'=>'1', 'message'=>'OTP verification successfully', 'data'=>$user);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'wrong otp', 'data'=>[]);
            return $message;
        }
    }


   public function update_partner_pass(Request $request)
    {
        $user_phone = $request->partner_phone;
       
        $password = $request->password;
                        
        $updateUser = DB::table('partner')
                            ->where('partner_phone', $user_phone)
                            ->update(['partner_password'=>$password]);                
                
         if($updateUser){
            $message = array('status'=>'1', 'message'=>'Password Updated ! login now');
            return $message;
        } else{
            $message = array('status'=>'0', 'message'=>'something wents wrong ! try again');
            return $message;
        }        

}


}