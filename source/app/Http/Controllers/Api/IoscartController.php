<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class IoscartController extends Controller
{
   public function add_to_cart(Request $request)
    {   
        $current = Carbon::now();
        $user_id= $request->user_id;
        $qty = $request->qty;
        $service_id = $request->service_id;

        $created_at = Carbon::now();
    
       $name= DB::table('services')
            ->select('service_name','service_price')
            ->where('service_id', $service_id)
            ->first();
            
        $service_price = $name->service_price; 
        $price2 = $service_price*$qty;  
        $ser_name= $name->service_name;
         $check = DB::table('booking_cart')
            ->where('user_id',$user_id)
            ->where('service_id',$service_id)
            ->first();
     if(!$check){

        $insert = DB::table('booking_cart')
                ->insert([
                        'service_id'=>$service_id,
                        'service_qty'=>$qty,
                        'user_id'=>$user_id,
                        'price'=>$price2
                        ]);
      
     }
     else{
          $del = DB::table('booking_cart')
            ->where('user_id',$user_id)
            ->where('service_id',$service_id)
            ->delete();
     
       $insert = DB::table('booking_cart')
                ->insert([
                        'service_id'=>$service_id,
                        'service_qty'=>$qty,
                        'user_id'=>$user_id,
                        'price'=>$price2
                        ]);
         
     }

   
 
  if($insert){
      $del = DB::table('booking_cart')
            ->where('user_id',$user_id)
            ->where('service_qty', 0)
            ->delete();
      $sum =  DB::table('booking_cart')
            ->where('user_id',$user_id)
            ->select(DB::raw('SUM(price) as sum'))
            ->first();
            
            
      $checkitems = DB::table('booking_cart')
            ->join('services','booking_cart.service_id','=','services.service_id')
            ->where('booking_cart.user_id',$user_id)
            ->get();
            
     if(count($checkitems)==0)  {
         $checkitems = [];
     }    
     
     if(!$sum)  {
         $sump= 0;
     }   
     else{
         $sump = $sum->sum;
     }
      
      
        	$message = array('status'=>'1', 'message'=>'Added to cart', 'total_price'=>$sump, 'cart_items'=>$checkitems);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'insertion failed', 'data'=>[]);
        	return $message;
        }
       
 }
 
 
 public function addon_to_cart(Request $request)
    {   
        $current = Carbon::now();
        $user_id= $request->user_id;
        $addon_id = $request->addon_id;
        $qty = $request->qty;
        $created_at = Carbon::now();
    
       $name= DB::table('add_ons_des')
            ->where('des_id', $addon_id)
            ->first();
            
        $addon_price = $name->add_on_price; 
       
         $check = DB::table('cart_addons')
            ->where('user_id',$user_id)
            ->where('addon_id',$addon_id)
            ->first();
     if(!$check){

        $insert = DB::table('cart_addons')
                ->insert([
                        'addon_id'=>$addon_id,
                        'user_id'=>$user_id,
                        'price'=>$addon_price,
                        'qty'=>$qty
                        ]);
      
     }
     else{
          $del = DB::table('cart_addons')
            ->where('user_id',$user_id)
            ->where('addon_id',$addon_id)
            ->delete();
     
       $insert = DB::table('cart_addons')
                ->insert([
                        'addon_id'=>$addon_id,
                        'user_id'=>$user_id,
                        'price'=>$addon_price,
                        'qty'=>$qty
                        ]);
         
     }

   
 
  if($insert){
      $del = DB::table('cart_addons')
            ->where('user_id',$user_id)
            ->where('qty', 0)
            ->delete();
      $sum =  DB::table('cart_addons')
            ->where('user_id',$user_id)
            ->select(DB::raw('SUM(price) as sum'))
            ->first();
            
            
      $checkitems = DB::table('cart_addons')
            ->join('add_ons_des','cart_addons.addon_id','=','add_ons_des.des_id')
            ->where('cart_addons.user_id',$user_id)
            ->get();
            
     if(count($checkitems)==0)  {
         $checkitems = [];
     }    
     
     if(!$sum)  {
         $sump= 0;
     }   
     else{
         $sump = $sum->sum;
     }
      
      
        	$message = array('status'=>'1', 'message'=>'Addons to cart successfully', 'addons_price'=>$sump, 'cart_addons'=>$checkitems);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'insertion failed', 'data'=>[]);
        	return $message;
        }
       
 }
 
  public function place_order(Request $request)
    {   
        $current = Carbon::now();
         $id= $request->id;
 
        $data=DB::table('booking_cart')
            ->where('user_id',$id)
              ->get();
        $data_array = json_decode($data);
        $data1=DB::table('cart_addons')
            ->where('user_id',$id)
              ->get();    ;
        $data_array1 = json_decode($data1);
        
        $coupon_id =$request->coupon_id;
        $address_id = $request->address_id;
         $confirmed_on = $request->confirmed_on;
        $ar= DB::table('user_address')
            ->select('address')
            ->where('address_id', $address_id)
            ->first();
        $address = $ar->address;
        
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
            ->select('service_name','service_price')
            ->where('service_id', $service_id)
            ->first();
            
        $service_price = $name->service_price; 
        $s_name[] = $name->service_name;
        $ser_name = implode(',',$s_name);
        $price2+= $service_price*$service_qty;  
        $cat = $name->service_name;
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
                        'price'=>$total_price,
                        'unique_code'=>$coupon_code,
                        'user_phone'=>$user_phone,
                        'booking_status'=>0,
                        'coins'=>$coins
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
                     ->where('device_id', '!=', NULL)
                     ->get();

        foreach ($userDetails as $userDetail) {
            $token[] = $userDetail->device_id;
        }

        $created_at = Carbon::now();

        if(count($userDetails) == 0){
            return redirect()->back()->withErrors('app user not found');
        }

       
         $server_key = DB::table('tbl_fcm')
                     ->first();
                     
        $getFcmKey = $server_key->server_key;
        
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
              
   $del = DB::table('booking_cart')
            ->where('user_id',$id)
            ->delete(); 
    
     $del2 = DB::table('cart_addons')
            ->where('user_id',$id)
            ->delete();            
              
        
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
                        'price'=>$update_price,
                        'unique_code'=>$coupon_code,
                        'user_phone'=>$user_phone,
                        'booking_status'=>0,
                        'coins'=>$coins
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
                     ->where('device_id', '!=', NULL)
                     ->get();

        foreach ($userDetails as $userDetail) {
            $token[] = $userDetail->device_id;
        }

        $created_at = Carbon::now();

        if(count($userDetails) == 0){
            return redirect()->back()->withErrors('app user not found');
        }

       
         $server_key = DB::table('tbl_fcm')
                     ->first();
                     
        $getFcmKey = $server_key->server_key;
        
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
              
         $del = DB::table('booking_cart')
            ->where('user_id',$id)
            ->delete(); 
    
         $del2 = DB::table('cart_addons')
            ->where('user_id',$id)
            ->delete();       
              
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
 
   public function show_cart(Request $request)
    { 
        $user_id= $request->user_id;
        $cart_items = DB::table('booking_cart')
                    ->where('user_id',$user_id)
                    ->get();
     
                        
        if(count($cart_items)>0){
              $cart_addons1 =  DB::table('cart_addons')
                    ->where('user_id',$user_id)
                    ->get();
              if(count($cart_addons1)>0){ 
                  $cart_addons[]=$cart_addons1;
              }else{
                  $cart_addons = array();
              }
             $sum = DB::table('booking_cart')
            ->where('user_id',$user_id)
            ->select(DB::raw('SUM(price) as sum'))
            ->first();
            
            $sum2 = DB::table('cart_addons')
            ->where('user_id',$user_id)
            ->select(DB::raw('SUM(price) as sum2'))
            ->first();
            
            $total = $sum->sum +$sum2->sum2;
            $message = array('status'=>'1', 'message'=>'cart_items','total_price'=>$total, 'services'=>$cart_items , 'cart_addons'=> $cart_addons );
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'insertion failed', 'data'=>[]);
        	return $message;
        }
        }
 
}