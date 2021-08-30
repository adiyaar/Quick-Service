<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PartnerController extends Controller
{
    
    public function partnerlogin(Request $request)
    {
        $partner_phone = $request->partner_phone;
        $password = $request->partner_password;
        $device_id = $request->device_id;
        $checkUser = DB::table('partner')
                        ->where('partner_phone', $partner_phone)
                        ->first();
       
        
        if($checkUser){
            $status = $checkUser->status;
             $password1 = $checkUser->partner_password;
            if($status == 0){
                $message = array('status'=>'0', 'message'=>'Account is Under Verification', 'data'=>[]);
                return $message;
            }
            else{
                if($status == 2){
                    $message = array('status'=>'0', 'message'=>'Your Account Rejected', 'data'=>[]);
                    return $message;
                }
                
                    else{
                        if($password==$password1){
                        $updateDeviceId = DB::table('partner')
                                        ->where('partner_phone', $partner_phone)
                                        ->where('partner_password', $password)
                                        ->update(['device_id'=>$device_id]);
                        $message = array('status'=>'1', 'message'=>'login successfully', 'data'=>$checkUser);
                        return $message;
                    }
                    else{
                        $message = array('status'=>'3', 'message'=>'Wrong Details', 'data'=>$checkUser);
                        return $message;
                    }
                    
                }
            }
        }
        else{
            $message = array('status'=>'0', 'message'=>'Your Details is not Registered', 'data'=>[]);
            return $message;
        }
    }
    
    public function partnerProfile(Request $request)
    {
        $partner_id = $request->partner_id;

        $userProfile = DB::table('partner')
                        ->where('partner_id', $partner_id)
                        ->first();
        if($userProfile){
            $message = array('status'=>'1', 'message'=>'Profile Details', 'data'=>$userProfile);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'something wrong', 'data'=>[]);
            return $message;
        }
    }
    
       public function profileupdatepassword(Request $request)
    {
        $partner_phone = $request->partner_phone;
        $password = $request->partner_password;
                        
        $updateUser = DB::table('partner')
                            ->where('partner_phone', $partner_phone)
                            ->update(['partner_password'=>$password]);                
                
         if($updateUser){
            $message = array('status'=>'1', 'message'=>'Password Updated ! login now');
            return $message;
        } else{
            $message = array('status'=>'0', 'message'=>'something wents wrong ! try again');
            return $message;
        }        

}
    
        public function citylist(Request $request)
    {
        
        $city = DB::table('partner_city')
                    ->get();
                    
                            
        if($city){
                $message = array('status'=>'1', 'message'=>'City List', 'data'=>$city);
                return $message;
                            }   
           else{
                 $message = array('status'=>'0', 'message'=>'Not Found');
              return $message;
      }                    
    }
    
     public function category(Request $request)
    {
        
        $city = DB::table('category')
                    ->get();
                    
        if(count($city)>0){
                $message = array('status'=>'1', 'message'=>'Category List', 'data'=>$city);
                return $message;
                            }   
           else{
                 $message = array('status'=>'0', 'message'=>'No Category Found');
              return $message;
      }                    
    } 
    
    public function child_category_list(Request $request)
    {
        $category_id = $request->category_id;
        $city = DB::table('sub_category')
                    ->where('category_id',$category_id)
                    ->get();
                    
        if(count($city)>0){
                $message = array('status'=>'1', 'message'=>'Category List', 'data'=>$city);
                return $message;
                            }   
           else{
                 $message = array('status'=>'0', 'message'=>'No Category Found');
              return $message;
      }                    
    } 
    
    
     public function sub_child_cat_list(Request $request)
    {
       
        $category_id=$request->sub_cat_id;
        
    	$scratch = DB::table('sub_child_category')
    	            ->where('sub_category_id',$category_id)
                        ->get();
    				

    	if(count($scratch)>0){
    	   
    	    
    		$message = array('status'=>'1', 'message'=>'Category list','sub_category'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
    
        public function partnercoins(Request $request)
    {
        $partner_id = $request->partner_id;

        $userProfile = DB::table('partner')
                        ->where('partner_id', $partner_id)
                        ->select('coins','range')
                        ->first();
        if($userProfile){
            $message = array('status'=>'1', 'message'=>'Partner Coins', 'data'=>$userProfile);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'something wrong', 'data'=>[]);
            return $message;
        }
    }
    
    public function otp_for_number(Request $request)
    {
        $user_phone = $request->user_phone;
        $user_id = $request->user_id;
     

                                
                
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
                
                // else{
                //     $otpval = "1234";
                // }
                
                $updateOtp = DB::table('tbl_user')
                                ->where('id', $user_id)
                                ->update([
                                    'otp_value'=>$otpval,
                                ]);

                if($updateOtp){
                    $user = DB::table('tbl_user')
                            ->where('id', $user_id)
                            ->first();

                    $message = array('status'=>'1', 'message'=>'otp send successfully', 'data'=>$user);
                    return $message;
                }
                else{
                    $message = array('status'=>'0', 'message'=>'something wents wrong', 'data'=>[]);
                    return $message;
                }
        
    }

     public function verify_otp_for_new_number(Request $request)
    {
        $user_id = $request->user_id;
        $new_number = $request->new_number;
        
        $otp_value = $request->otp_value;

        $getUser = DB::table('tbl_user')
                        ->where('id', $user_id)
                        ->first();

        if($otp_value == $getUser->otp_value){
            $updateUser = DB::table('tbl_user')
                            ->where('id', $user_id)
                            ->update(['otp_value'=>null,
                                        'user_phone'=>$user_phone
                                         ]);

            $user = DB::table('tbl_user')
                        ->where('user_phone', $user_phone)
                        ->first();

            $message = array('status'=>'1', 'message'=>'Number Updated', 'data'=>$user);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'wrong otp', 'data'=>[]);
            return $message;
        }
    }
    
    public function partner_profile_update(Request $request)
    {
        $partner_id = $request->partner_id;

        $userProfile = DB::table('partner')
                        ->where('partner_id', $partner_id)
                        ->first();
        if($userProfile){
            $message = array('status'=>'1', 'message'=>'Profile Details', 'data'=>$userProfile);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'something wrong', 'data'=>[]);
            return $message;
        }
    }
}