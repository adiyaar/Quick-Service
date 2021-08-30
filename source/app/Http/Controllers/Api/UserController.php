<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class UserController extends Controller
{
public function signUp(Request $request)
    {
        $user_phone = $request->user_phone;
       
        $user_name = $request->user_name;
        $referral_code = $request->referral_code;
        $password = $request->password;
        $device_id = $request->device_id;
        $city_id = $request->city_id;
        $email = $request->user_email;
        // $address = $request->address;
        $created_at = Carbon::now();
        $updated_at = Carbon::now();
         $startingg = strtoupper(substr($user_name, 0, 3));
         $chars ="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                    $referral_code1 = "";
                    for ($i = 0; $i < 5; $i++){
                       $referral_code1 .= $chars[mt_rand(0, strlen($chars)-1)];
                    }
        if($request->referral_code){
            $getReferredUser = DB::table('tbl_user')
                                ->where('referral_code', $referral_code)
                                ->get();

            if(count($getReferredUser) == 0){
                $message = array('status'=>'0', 'message'=>'wrong referral code', 'data'=>[]);
                return $message;
            }
        }
        
        $city = DB::table('partner_city')
                    ->where('city_id',$city_id)
                    ->first();

        $checkUser = DB::table('tbl_user')
                        ->where('user_phone', $user_phone)
                        ->first();

        if($checkUser){
            if($checkUser->status==0){
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
                
                $updateOtp = DB::table('tbl_user')
                                ->where('user_phone', $user_phone)
                                ->update([
                                    'otp_value'=>$otpval,
                                ]);

                if($updateOtp){
                    $user = DB::table('tbl_user')
                            ->where('user_phone', $user_phone)
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
                $message = array('status'=>'0', 'message'=>'user already registered', 'data'=>$checkUser);
                return $message;
            }
        }
        else{
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

            $date = date('d-m-Y');

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
                $user_profile = "N/A";
            }


            $insertUser = DB::table('tbl_user')
                            ->insertGetId([
                                'user_phone'=>$user_phone,
                                'user_name'=>$user_name,
                                'user_image'=>$user_profile,
                                'device_id'=>$device_id,
                                'password'=>$password,
                                'otp_value'=>$otpval,
                                'referral_code'=>$startingg.$referral_code,
                                'created_at'=>$created_at,
                                'updated_at'=>$updated_at,
                                'user_email'=>$email,
                                'city_id'=>$city_id
                            ]);
                            
                            // foreach($address as $add)
                            // {
                            
                            // $address = DB::table('address')
                            // ->insert([
                            //     'user_id'=>$insertUser,
                            //     'address'=>$add,
                            //     ]);
                            // }

            if($insertUser > 0){

                if($request->referral_code){
                    $getReferredUser = DB::table('tbl_user')
                                        ->where('referral_code', $referral_code)
                                        ->first();

                    if($getReferredUser){
                        $insertReferral = DB::table('tbl_referral')
                                            ->insert([
                                                'user_id'=>$insertUser,
                                                'referral_by'=>$getReferredUser->id,
                                                'created_at'=>$created_at,
                                            ]);
                                            
                                            
                    
                    
                    
                    
                     // assign scratch card on referral to new user and old user
            $getScratchCard = DB::table('tbl_scratch_card')
                                ->where('id', '9')
                                ->first();

            $scratch_card_offers = json_decode($getScratchCard->scratch_card_offers);
            $earning = rand($scratch_card_offers->min, $scratch_card_offers->max);
            $earningBonus = rand($scratch_card_offers->min, $scratch_card_offers->max);

            $earn = "You've won ₹ ".$earning; // for new user
            $earnBonus = "You've won ₹ ".$earningBonus; // for old user

            $created_at = Carbon::now();

          
               $getReferredUser = DB::table('tbl_user')
                                ->where('referral_code', $referral_code)
                                ->first();

                if($getReferredUser){

                    $countReferral = DB::table('tbl_referral')
                                        ->where('referral_by', $getReferredUser->id)
                                        ->get();

                    if(count($countReferral) <= 20){
                        // for old user
                        $insertScratchCard = DB::table('tbl_user_scratch_card')
                                            ->insert([
                                                'user_id'=>$getReferredUser->id,
                                                'scratch_id'=>'9',
                                                'scratch_type'=>'reward',
                                                'scratch_for'=>'referral reward',
                                                'earning'=>$earn,
                                                'created_at'=>$created_at,
                                            ]);

                        // for new user
                        $insertReferralBonus = DB::table('tbl_user_scratch_card')
                                            ->insert([
                                                'user_id'=>$insertUser,
                                                'scratch_id'=>'9',
                                                'scratch_type'=>'reward',
                                                'scratch_for'=>'referral reward',
                                                'earning'=>$earnBonus,
                                                'created_at'=>$created_at,
                                            ]);
                    }
                }
                                            
                    }
                    else{
                        $message = array('status'=>'0', 'message'=>'wrong referral code', 'data'=>[]);
                        return $message;
                    }
                }

                $user = DB::table('tbl_user')
                        ->join('partner_city','tbl_user.city_id','=','partner_city.city_id')
                        ->select('tbl_user.user_name','tbl_user.user_email','tbl_user.user_phone','tbl_user.user_image','tbl_user.id','partner_city.city_name','tbl_user.city_id','tbl_user.device_id')
                        ->where('user_phone', $user_phone)
                        ->first();

                $message = array('status'=>'1', 'message'=>'otp send successfully', 'data'=>$user);
                return $message;
            }
            else{
                $message = array('status'=>'0', 'message'=>'something wents wrong', 'data'=>[]);
                return $message;
            }
        }
    }

    public function verifyOtp(Request $request)
    {
        $user_phone = $request->user_phone;
        
        $otp_value = $request->otp_value;

        $getUser = DB::table('tbl_user')
                        ->where('user_phone', $user_phone)
                        ->first();

        if($otp_value == $getUser->otp_value){
            $updateUser = DB::table('tbl_user')
                            ->where('user_phone', $user_phone)
                            ->update(['otp_value'=>null, 'status'=>1]);

            $user = DB::table('tbl_user')
                        ->where('user_phone', $user_phone)
                        ->first();

            $message = array('status'=>'1', 'message'=>'registered successfully', 'data'=>$user);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'wrong otp', 'data'=>[]);
            return $message;
        }
    }

    public function updateSociety(Request $request)
    {
        $user_phone = $request->user_phone;
        $society_id = "1";

        // $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        // $code = "";
        // for ($i = 0; $i < 4; $i++){
        //     $code .= $chars[mt_rand(0, strlen($chars)-1)];
        // }

        // $referral_code = $code;

        $getUser = DB::table('tbl_user')
                        ->where('user_phone', $user_phone)
                        ->first();

        $userName = $getUser->user_name;
        $result = strtoupper(substr($userName, 0, 4));

        $referral_code = $result;

        if($getUser){
            $updateUser = DB::table('tbl_user')
                            ->where('user_phone', $user_phone)
                            ->update([
                                'society_id'=>$society_id,
                                'referral_code'=>$referral_code."".$getUser->id,
                            ]);

            $user = DB::table('tbl_user')
                        ->where('user_phone', $user_phone)
                        ->first();

            // assign scratch card for registration
            $getScratchCard = DB::table('tbl_scratch_card')
                                ->where('id', '5')
                                ->first();

            $scratch_card_offers = json_decode($getScratchCard->scratch_card_offers);
            $earning = rand($scratch_card_offers->min, $scratch_card_offers->max);

            $earn = "You've won ₹ ".$earning;

            $created_at = Carbon::now();

            // check society
            $getSociety = $getScratchCard->scratch_card_society_id;

            if($getSociety == 'all'){
                $insertScratchCard = DB::table('tbl_user_scratch_card')
                                    ->insert([
                                        'user_id'=>$user->id,
                                        'scratch_id'=>'5',
                                        'scratch_type'=>'reward',
                                        'scratch_for'=>'registration reward',
                                        'earning'=>$earn,
                                        'created_at'=>$created_at,
                                    ]);
            }


            // assign scratch card on referral to new user and old user
            $getScratchCard = DB::table('tbl_scratch_card')
                                ->where('id', '9')
                                ->first();

            $scratch_card_offers = json_decode($getScratchCard->scratch_card_offers);
            $earning = rand($scratch_card_offers->min, $scratch_card_offers->max);
            $earningBonus = rand($scratch_card_offers->min, $scratch_card_offers->max);

            $earn = "You've won ₹ ".$earning; // for new user
            $earnBonus = "You've won ₹ ".$earningBonus; // for old user

            $created_at = Carbon::now();

            // check society
            $getSociety = $getScratchCard->scratch_card_society_id;

            if($getSociety == 'all'){
                $referredByUser = DB::table('tbl_referral')
                                    ->where('user_id', $user->id)
                                    ->first();

                if($referredByUser){

                    $countReferral = DB::table('tbl_referral')
                                        ->where('referral_by', $referredByUser->referral_by)
                                        ->get();

                    if(count($countReferral) <= 10){
                        // for old user
                        $insertScratchCard = DB::table('tbl_user_scratch_card')
                                            ->insert([
                                                'user_id'=>$referredByUser->referral_by,
                                                'scratch_id'=>'9',
                                                'scratch_type'=>'reward',
                                                'scratch_for'=>'referral reward',
                                                'earning'=>$earn,
                                                'created_at'=>$created_at,
                                            ]);

                        // for new user
                        $insertReferralBonus = DB::table('tbl_user_scratch_card')
                                            ->insert([
                                                'user_id'=>$user->id,
                                                'scratch_id'=>'9',
                                                'scratch_type'=>'reward',
                                                'scratch_for'=>'referral reward',
                                                'earning'=>$earnBonus,
                                                'created_at'=>$created_at,
                                            ]);
                    }
                }
            }

            // for all custom scratch card
            $getAllScratchCard = DB::table('tbl_scratch_card')
                                    ->where('is_default', '0')
                                    ->get();

            if(count($getAllScratchCard)>0){
                foreach ($getAllScratchCard as $getAllScratchCards) {
                    if($getAllScratchCards->scratch_card_type == 'reward'){
                        $scratch_card_offers = json_decode($getAllScratchCards->scratch_card_offers);
                        $earning = rand($scratch_card_offers->min, $scratch_card_offers->max);
                        $earning = "You've won ₹ ".$earning;
                    }
                    else{
                        $scratch_card_offers = json_decode($getAllScratchCards->scratch_card_offers);
                        $earning = $scratch_card_offers->coupan;
                    }

                    // check society
                    $getSociety = $getAllScratchCards->scratch_card_society_id;

                    if($getSociety == 'all'){
                        $insertCustomReward = DB::table('tbl_user_scratch_card')
                                                ->insert([
                                                    'user_id'=>$user->id,
                                                    'scratch_id'=>$getAllScratchCards->id,
                                                    'scratch_type'=>$getAllScratchCards->scratch_card_type,
                                                    'scratch_for'=>$getAllScratchCards->scratch_card_name,
                                                    'earning'=>$earning,
                                                    'created_at'=>$created_at,
                                                ]);
                    }
                    else{
                        // check society
                        $getSociety = json_decode($getAllScratchCards->scratch_card_society_id);

                        if(in_array($society_id, $getSociety)){
                            $insertCustomReward = DB::table('tbl_user_scratch_card')
                                                    ->insert([
                                                        'user_id'=>$user->id,
                                                        'scratch_id'=>$getAllScratchCards->id,
                                                        'scratch_type'=>$getAllScratchCards->scratch_card_type,
                                                        'scratch_for'=>$getAllScratchCards->scratch_card_name,
                                                        'earning'=>$earning,
                                                        'created_at'=>$created_at,
                                                    ]);
                        }
                    }
                }
            }

            $message = array('status'=>'1', 'message'=>'society updated successfully', 'data'=>$user);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'something wents wrong', 'data'=>[]);
            return $message;
        }
    }

    public function login(Request $request)
    {
        $user_phone = $request->user_phone;
        
        $device_id = $request->device_id;
       $password = $request->password;
        $checkUser = DB::table('tbl_user')
                        ->join('partner_city','tbl_user.city_id','=','partner_city.city_id')
                        ->select('tbl_user.user_name','tbl_user.user_email','tbl_user.user_phone','tbl_user.user_image','tbl_user.id','partner_city.city_name','tbl_user.city_id','tbl_user.device_id','tbl_user.password','tbl_user.status','tbl_user.society_id')
                        ->where('user_phone', $user_phone)
                        ->first();
        
        if($checkUser){
            $password1 = $checkUser->password;
            $status = $checkUser->status;

            if($status == 0){
                $message = array('status'=>'0', 'message'=>'you are not registered', 'data'=>[]);
                return $message;
            }
            else{
                if($status == 2){
                    $message = array('status'=>'0', 'message'=>'your account has been blocked', 'data'=>[]);
                    return $message;
                }
                else{
                    if($checkUser->society_id == null){
                        $message = array('status'=>'2', 'message'=>'select your society', 'data'=>[]);
                        return $message;
                    }
                    else{
                        if($password==$password1){
                        $updateDeviceId = DB::table('tbl_user')
                                        ->where('user_phone', $user_phone)
                                        ->where('password', $password)
                                        ->update(['device_id'=>$device_id]);
                        $message = array('status'=>'1', 'message'=>'login successfully', 'data'=>$checkUser);
                        return $message;
                    }
                    else{
                        $message = array('status'=>'3', 'message'=>'wrong password', 'data'=>$checkUser);
                        return $message;
                    }
                    
                    }
                }
            }
        }
        else{
            $message = array('status'=>'0', 'message'=>'you are not registered', 'data'=>[]);
            return $message;
        }
    }



   public function otpforpass(Request $request)
    {
        $user_phone = $request->user_phone;
       
        $checkUser = DB::table('tbl_user')
                        ->where('user_phone', $user_phone)
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
                
                $updateOtp = DB::table('tbl_user')
                                ->where('user_phone', $user_phone)
                                ->update([
                                    'otp_value'=>$otpval,
                                ]);

                if($updateOtp){
                    $user = DB::table('tbl_user')
                            ->where('user_phone', $user_phone)
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



    public function verifyOtpforpass(Request $request)
    {
        $user_phone = $request->user_phone;
        
        $otp_value = $request->otp_value;

        $getUser = DB::table('tbl_user')
                        ->where('user_phone', $user_phone)
                        ->first();

        if($otp_value == $getUser->otp_value){
            $updateUser = DB::table('tbl_user')
                            ->where('user_phone', $user_phone)
                            ->update(['otp_value'=>null, 'status'=>1]);

            $user = DB::table('tbl_user')
                        ->where('user_phone', $user_phone)
                        ->first();

            $message = array('status'=>'1', 'message'=>'OTP verification successfully', 'data'=>$user);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'wrong otp', 'data'=>[]);
            return $message;
        }
    }


   public function updateusrpass(Request $request)
    {
        $user_phone = $request->user_phone;
       
        $password = $request->password;
                        
        $updateUser = DB::table('tbl_user')
                            ->where('user_phone', $user_phone)
                            ->update(['password'=>$password]);                
                
         if($updateUser){
            $message = array('status'=>'1', 'message'=>'Password Updated ! login now');
            return $message;
        } else{
            $message = array('status'=>'0', 'message'=>'something wents wrong ! try again');
            return $message;
        }        

}

    public function userProfile(Request $request)
    {
        $id = $request->user_id;
        
        
        $userProfile = DB::table('tbl_user')
                        ->where('id', $id)
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
    
    public function otpOnOff(){
        $otpOnOff = DB::table('tbl_web_setting')
                    ->where('id', '12')
                    ->where('value', '1')
                    ->first();
                    
        if($otpOnOff){
            $message = array('status'=>'1', 'message'=>'On', 'data'=>"1");
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'Off', 'data'=>'0');
            return $message;
        }
    }
    
        public function profileupdate(Request $request)
    {
        $id = $request->id;
        
        
        $user_name = $request->user_name;
        $user_email = $request->user_email;
        $city_id = $request->city_id;
        
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
                    $old_image = DB::table('tbl_user')
                                ->where('id',$id)
                                ->first();
                        $user_profile =   $old_image->user_image;    
            }
        
    	$scratch = DB::table('tbl_user')
    	            ->where('id',$id)
                    ->update([
                        'user_name'=>$user_name,
                        'user_email'=>$user_email,
                        'user_image'=>$user_profile,
                        'city_id'=>$city_id
                            ]);
    				

    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'Updated Sucessfully', 'data'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Please change atleast one field', 'data'=>[]);
            return $message;
        	}
    }
    

    
}
