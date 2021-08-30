<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function booking(Request $request)
    {
        $user_id=$request->id;
    	$booking = DB::table('booking')
                        ->join('booking_details','booking.booking_id','=','booking_details.booking_id')
                        ->leftjoin('sub_child_category','services.child_category_id','=','sub_child_category.child_category_id')
                        ->select('sub_child_category.child_name','booking.time_slot','booking.payment_mode','booking.confirmed_on','booking.user_address','booking.user_phone','booking.unique_code')
                        ->groupBy('sub_child_category.child_name','booking.time_slot','booking.payment_mode','booking.confirmed_on','booking.user_address','booking.user_phone','booking.unique_code')
                        ->where('id', $user_id)
                        ->where('booking_status',3)
                        ->get();
    	if(count($booking)>0){
    		$message = array('status'=>'3', 'message'=>'Booking History', 'data'=>$booking);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Whoops, No projects', 'data'=>[]);
            return $message;
        	}
    }
    public function bookingadded(Request $request)
    {
        $data= $request->demo_array;
        $data_array = json_decode($data);
        $data1= $request->demo_array1;
        $data_array1 = json_decode($data1);
        $id= $request->id;
        $coupon_id =$request->coupon_id;
         $updated_price= $request->price;
        $address_id = $request->address_id;
         $confirmed_on = $request->confirmed_on;
       $ar= DB::table('user_address')
            ->select('address','lat','lng')
            ->where('address_id', $address_id)
            ->first();
        $address = $ar->address;
        $lat = $ar->lat;
        $lng = $ar->lng;
        
         $usr = DB::table('tbl_user')
                ->select('user_name','user_phone')
                ->where('id', $id)
                ->first(); 
        $user_name = $usr->user_name;
        $user_phone = $usr->user_phone;
        $current_date = date('d-m-Y');
        $time_slot=$request->time_slot;
        $payment_mode=$request->payment_mode;
        $confirmed_on= $request->confirmed_on;
        $price2=0;
        $price3=0;
   
    foreach ($data_array as $h){
        $service_id = $h->service_id;
        $service_qty = $h->service_qty;
        $name= DB::table('services')
            ->select('service_name','service_price','child_category_id')
            ->where('service_id', $service_id)
            ->first();
            
        $service_price = $name->service_price; 
        $s_name[] = $name->service_name;
        $ser_name = implode(',',$s_name);
        $price2+= $service_price*$service_qty;  
        $cat = $name->service_name;
         $child_cat_id = $name->child_category_id;
            }  
     if($data1){ 
     foreach ($data_array1 as $h){
        $addon_id = $h->addon_id;
            
        $add = DB::table('add_ons_des')
            ->select('add_on_des','add_on_price')
            ->where('des_id', $addon_id)
            ->first();  
        $addon_price = $add->add_on_price;
        $addprice = $addon_price;
        $a_name[] = $add->add_on_des;
        $ad_name = implode(',',$a_name);    
        $price3+= $addon_price;
        $total_price = $price3+$price2;
       }     
        }
        else{
            $total_price =$price2;
        }   
        $user = DB::table('tbl_user')
                ->where('id', $id)
                ->first();
        $user_name = $user->user_name;
        $email = $user->user_email;
        $startingg = strtoupper(substr($cat, 0, 3));
        $coupon_name=$request->$user_name;
        $chars ="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $coupon_code = "";
        for ($i = 0; $i < 4; $i++){
               $coupon_code .= $chars[mt_rand(0, strlen($chars)-1)];
               }
          $booking_coins = DB::table('booking_coins') 
                            ->first();
            $new_coin = $booking_coins->coin_value;              
                    
         $coins = ($total_price/100) * $new_coin;  
  if($coupon_id == NULL)
            {
                $insert = DB::table('booking')
                  ->insertGetId(['id'=>$id,
                        'user_address'=>$address,
                        'booking_date'=>$current_date,
                        'time_slot'=> $time_slot,
                        'confirmed_on'=> $confirmed_on,
                        'payment_mode'=>$payment_mode,
                        'price'=>$updated_price,
                        'unique_code'=>$coupon_code,
                        'user_phone'=>$user_phone,
                        'booking_status'=>0,
                        'coins'=>$coins,
                        'lat'=>$lat,
                        'lng'=>$lng,
                        'child_category_id'=>$child_cat_id
                        ]);
     
        if($insert){
                 $data22= DB::table('booking')
                        ->where('booking_id',$insert)
                        ->first();
                
                     // start sms
                         $sms_api_key=  DB::table('tbl_msg_key')
                              ->select('mag_auth_key', 'mag_sender_id','booking_msg')
                              ->first();
                      $api_key = $sms_api_key->mag_auth_key;
                      $sender_id = $sms_api_key->mag_sender_id;
                      $book = $sms_api_key->booking_msg;
                      $discount = str_replace("&name",$user_name, $book);
                      $discount1 = str_replace("&price",$total_price, $discount);
                      $discount2 = str_replace("&date",$confirmed_on, $discount1);
                  
                      $getAuthKey = $api_key;
                        $getSenderId = $sender_id;
                        $getInvitationMsg = $discount2;
        
                        $authKey = $getAuthKey;
                      // $mobileNumber1 = 8859593839;
                        $senderId = $getSenderId;
                        $message1 = $getInvitationMsg;
                        $route = "4";
                        $postData = array(
                            'authkey' => $authKey,
                            'mobiles' => $user_phone,
                            'message' => $message1,
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

                curl_close($ch);
                
                
                    // end sms
                     /////send mail

                
                    
                     $to = $email;
                    
                    $head = "MIME-Version: 1.0\r\n";
                    $head .= "Content-type: text/plain; charset=iso-8859-1\r\n";
                    $head .= "X-Priority: 3\r\n";
                    $head .= "X-Mailer: PHP". phpversion() ."\r\n"; 
                    $email=  DB::table('tbl_email')
                      ->select('email_subject', 'email_body','head')
                      ->first();
                      $subject = $email->email_subject;
                      $body = $email->email_body;
                      $head1 = $email->head;
                      $discount = str_replace("&name",$user_name, $body);
                      $discount1 = str_replace("&price",$total_price, $discount);
                      $discount2 = str_replace("&date",$confirmed_on, $discount1);
                    
                    // Always set content-type when sending HTML email
                    
                    // More headers
                    
                      $head .= "From:".$head1;
                       $message = $discount2;
                     
                    // ...and away we go Subject!
                    $retval = mail($to,$subject,$message,$head);
               
                 ////end send mail
               //send notification  
               
               $message = "You have a new lead from ".$user_name;
        
        $date = date('d-m-Y');


        $userDetails = DB::table('partner')
                     ->get();

        foreach ($userDetails as $userDetail) {
            $token[] = $userDetail->device_id;
        }

        $created_at = Carbon::now();

        if(count($userDetails) == 0){
            $message = array('status'=>'0', 'message'=>'App User not found' );
            return $message; 
        }

       
         $server_key = DB::table('tbl_fcm')
                     ->first();
                     
        $getFcmKey = $server_key->sender_id;
        
            $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
            $notification = [
                'title' => 'New Lead',
                'body' => $message,
                'sound' => "default"
            ];
            
            $extraNotificationData = ["message" => $notification];

           
            
            
            $fcmNotification = [
                // 'to' => "cANOD_M3-HY:APA91bGyXY9SNeESWBvDAXLd9BwTidIeoe0FwOYPRv7VUkTl4s0-OXYulpNtmtjD-f79i1Q8IC4P2DBqer2aVcKm5D9FeF-4twn7fM156NZ4LVGfDbCh5s8LB2PHl_KBOBoYscysiTOT", //single token
                'registration_ids' => $token, //multple token array
                'notification' => $notification,
                'data' => $extraNotificationData,
            ];

        $headers = [
                'Authorization: key='.$getFcmKey,
                'Content-Type: application/json'
            ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        $results = json_decode($result);
        // var_dump($results);
                    
              //end send notification      
                    
                    
                     foreach ($data_array as $h){
        $service_id = $h->service_id;
        $service_qty = $h->service_qty;
        $name= DB::table('services')
            ->select('service_name','service_price')
            ->where('service_id', $service_id)
            ->first();
            
        $service_price = $name->service_price;
        $ser_price = $service_price * $service_qty;
        $s_name[] = $name->service_name;
        $ser_name = implode(',',$s_name);
        $price2+= $service_price*$service_qty;  
        $cat = $name->service_name;
        DB::table('booking_details')
        ->insertGetId(['booking_id'=>$insert,
                    'service_id'=>$service_id,
                    'type'=>'service',
                    'qty'=> $service_qty,
                    'price'=> $ser_price,
                    ]);
            }  
     if($data1){ 
     foreach ($data_array1 as $h){
        $addon_id = $h->addon_id;
            
        $add = DB::table('add_ons_des')
            ->select('add_on_des','add_on_price')
            ->where('des_id', $addon_id)
            ->first();  
        $addon_price = $add->add_on_price;
        $addprice = $addon_price;
        $a_name[] = $add->add_on_des;
        $ad_name = implode(',',$a_name);    
        $price3+= $addon_price;
        $total_price = $price3+$price2;
         DB::table('booking_details')
            ->insertGetId(['booking_id'=>$insert,
                        'service_id'=>$addon_id,
                        'type'=>'addon',
                        'qty'=> '1',
                        'price'=> $addprice,
                        ]); 
       }     
        }
        else{
            $total_price =$price2;
        }   

    $data33 = DB::table('booking_details')
              ->join('services','booking_details.service_id','=','services.service_id')
              ->where('booking_details.booking_id', $insert)
              ->where('booking_details.type','service')
              ->get();
        
 $message = array('status'=>'1', 'message'=>'Booking Sucessfully', 'data'=>$data22 ,'services'=>$data33);
            return $message;

            }
            else{
               $message = array('status'=>'0', 'message'=>'Something went wrong' );
            return $message;  
            }
            }
else{
     $coupon = DB::table('coupon')
                    ->where('coupon_id',$coupon_id)
                    ->first();
          $discount =  $coupon->coupon_discount;
          $cart_value =  $coupon->cart_value;
          if($total_price>= $cart_value)   
          
        {
              $new_price = ($total_price/100) * $discount;  
              $update_price = $total_price-$new_price;
            $insert = DB::table('booking')
                  ->insertGetId(['id'=>$id,
                        'user_address'=>$address,
                        'booking_date'=>$current_date,
                        'time_slot'=> $time_slot,
                        'confirmed_on'=> $confirmed_on,
                        'payment_mode'=>$payment_mode,
                        'price'=>$updated_price,
                        'unique_code'=>$coupon_code,
                        'user_phone'=>$user_phone,
                        'booking_status'=>0,
                        'coins'=>$coins,
                        'lat'=>$lat,
                        'lng'=>$lng,
                        'child_category_id'=>$child_cat_id
                        ]);
     
        if($insert){
                   $data22= DB::table('booking')
                        ->where('booking_id',$insert)
                        ->first();
        
             // start sms
                 $sms_api_key=  DB::table('tbl_msg_key')
                      ->select('mag_auth_key', 'mag_sender_id','booking_msg')
                      ->first();
              $api_key = $sms_api_key->mag_auth_key;
              $sender_id = $sms_api_key->mag_sender_id;
               $book = $sms_api_key->booking_msg;
                      $discount = str_replace("&name",$user_name, $book);
                      $discount1 = str_replace("&price",$total_price, $discount);
                      $discount2 = str_replace("&date",$confirmed_on, $discount1);
              $getAuthKey = $api_key;
                $getSenderId = $sender_id;
              $getInvitationMsg = $discount2 ;

                $authKey = $getAuthKey;
              // $mobileNumber1 = 8859593839;
                $senderId = $getSenderId;
                $message1 = $getInvitationMsg;
                $route = "4";
                $postData = array(
                    'authkey' => $authKey,
                    'mobiles' => $user_phone,
                    'message' => $message1,
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

                curl_close($ch);
                
                
                    // end sms
                    
                    /////send mail

                
                    
                     $to = $email;
                    
                    $head = "MIME-Version: 1.0\r\n";
                    $head .= "Content-type: text/plain; charset=iso-8859-1\r\n";
                    $head .= "X-Priority: 3\r\n";
                    $head .= "X-Mailer: PHP". phpversion() ."\r\n"; 
                    $email=  DB::table('tbl_email')
                      ->select('email_subject', 'email_body')
                      ->first();
                      $subject = $email->email_subject;
                      $body = $email->email_body;
                      $discount = str_replace("&name",$user_name, $body);
                      $discount1 = str_replace("&price",$total_price, $discount);
                      $discount2 = str_replace("&date",$confirmed_on, $discount1);
                    
                    // Always set content-type when sending HTML email
                    
                    // More headers
                    
                      $head .= "From: GOSUBSCRIBE \r\n";
                       $message = $discount2;
                     
                    // ...and away we go Subject!
                    $retval = mail($to,$subject,$body,$head);
               
                 ////end send mail
                    
                //send notification
                
                $message = "You have a new lead from ".$user_name;
        
        $date = date('d-m-Y');


        $userDetails = DB::table('partner')
                     ->get();

        foreach ($userDetails as $userDetail) {
            $token[] = $userDetail->device_id;
        }

        $created_at = Carbon::now();

        if(count($userDetails) == 0){
           $message = array('status'=>'0', 'message'=>'App User not found' );
            return $message; 
        }

       
         $server_key = DB::table('tbl_fcm')
                     ->first();
                     
        $getFcmKey = $server_key->sender_id;
        
            $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
            $notification = [
                'title' => New Lead,
                'body' => $message,
                'sound' => "default"
            ];
            
            $extraNotificationData = ["message" => $notification];

           
            
            
            $fcmNotification = [
                // 'to' => "cANOD_M3-HY:APA91bGyXY9SNeESWBvDAXLd9BwTidIeoe0FwOYPRv7VUkTl4s0-OXYulpNtmtjD-f79i1Q8IC4P2DBqer2aVcKm5D9FeF-4twn7fM156NZ4LVGfDbCh5s8LB2PHl_KBOBoYscysiTOT", //single token
                'registration_ids' => $token, //multple token array
                'notification' => $notification,
                'data' => $extraNotificationData,
            ];

        $headers = [
                'Authorization: key='.$getFcmKey,
                'Content-Type: application/json'
            ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        $results = json_decode($result);
        // var_dump($results);
                    
            foreach ($data_array as $h){
        $service_id = $h->service_id;
        $service_qty = $h->service_qty;
        $name= DB::table('services')
            ->select('service_name','service_price')
            ->where('service_id', $service_id)
            ->first();
            
        $service_price = $name->service_price; 
        $serprice = $service_price * $service_qty;
        $s_name[] = $name->service_name;
        $ser_name = implode(',',$s_name);
        $price2+= $service_price*$service_qty;  
        $cat = $name->service_name;
        DB::table('booking_details')
        ->insertGetId(['booking_id'=>$insert,
                    'service_id'=>$service_id,
                    'type'=>'service',
                    'qty'=> $service_qty,
                    'price'=> $serprice,
                    ]);
            }  
     if($data1){ 
     foreach ($data_array1 as $h){
        $addon_id = $h->addon_id;
            
        $add = DB::table('add_ons_des')
            ->select('add_on_des','add_on_price')
            ->where('des_id', $addon_id)
            ->first();  
        $addon_price = $add->add_on_price;
        $addprice = $addon_price;
        $a_name[] = $add->add_on_des;
        $ad_name = implode(',',$a_name);    
        $price3+= $addon_price;
        $total_price = $price3+$price2;
         DB::table('booking_details')
            ->insertGetId(['booking_id'=>$insert,
                        'service_id'=>$addon_id,
                        'type'=>'addon',
                        'qty'=> '1',
                        'price'=> $addprice,
                        ]); 
       }     
        }
        else{
            $total_price =$price2;
        }   
          $data33 = DB::table('booking_details')
              ->join('services','booking_details.service_id','=','services.service_id')
              ->where('booking_details.booking_id', $insert)
              ->where('booking_details.type','service')
              ->get();
            $message = array('status'=>'1', 'message'=>'Booking Sucessfully', 'data'=>$data22, 'services'=>$data33);
            return $message;
        }
          }
        else{
            
            
            
            
            
            $message = array('status'=>'0', 'message'=>'Unable to processing request', 'data'=>[]);
            return $message;
        }
     }
    }
    
    public function reschedule(Request $request)
    {
        $booking_id=$request->booking_id;
        $date = $request->date;
        $time_slot = $request->time_slot;
         
        
    	$booking = DB::table('booking')
                        ->where('booking_id', $booking_id)
                        ->update([
                            'confirmed_on'=>$date,
                            'time_slot'=>$time_slot
                            
                            ]);
               
                         $booking1 = DB::table('booking')
                            ->join('tbl_user','booking.id','tbl_user.id')
                            ->where('booking_id',$booking_id)
                            ->first(); 
                            $name = $booking1->user_name;
                            $user_phone = $booking1->user_phone;
                            $email = $booking1->user_email;
                            
              // start sms
                 $sms_api_key=  DB::table('tbl_msg_key')
                      ->select('mag_auth_key', 'mag_sender_id','booking_msg')
                      ->first();
              $api_key = $sms_api_key->mag_auth_key;
              $sender_id = $sms_api_key->mag_sender_id;
               $book = $sms_api_key->booking_msg;
                      $discount = str_replace("&name",$user_name, $book);
                      $discount1 = str_replace("&price",$total_price, $discount);
                      $discount2 = str_replace("&date",$confirmed_on, $discount1);
              $getAuthKey = $api_key;
                $getSenderId = $sender_id;
              $getInvitationMsg = $discount2 ;

                $authKey = $getAuthKey;
              // $mobileNumber1 = 8859593839;
                $senderId = $getSenderId;
                $message1 = $getInvitationMsg;
                $route = "4";
                $postData = array(
                    'authkey' => $authKey,
                    'mobiles' => $user_phone,
                    'message' => $message1,
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

                curl_close($ch);
                
                
                    // end sms 
                    
                    
                       
    	if($booking){
    		$message = array('status'=>'1', 'message'=>'Rescheduled Sucessfully', 'data'=>$booking);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Sorry, we are unable to processing your request', 'data'=>[]);
            return $message;
        	}
    }
    
    
}