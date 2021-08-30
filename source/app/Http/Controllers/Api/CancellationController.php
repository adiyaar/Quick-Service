<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class CancellationController extends Controller
{
public function cancellation(Request $request)
  {
      $booking_id=$request->booking_id;
      $booking_status=2;
      $cancel_reason =$request->cancel_reason;
      
      $booking = DB::table('booking')
                ->join('tbl_user','booking.id','tbl_user.id')
                ->where('booking_id',$booking_id)
                ->first();
        $partner_id =   $booking->partner_id;
        $booking_coins =   $booking->coins;
        $price =   $booking->price;
        $user_phone =   $booking->user_phone;
        $email =   $booking->user_email;
        $name = $booking->user_name;
        $price =$booking->price;
        $date =$booking->confirmed_on;
        
        if($partner_id == NULL)
      {
          
          $update = DB::table('booking')
                        ->where('booking_id', $booking_id)
                        ->update(['booking_status'=>$booking_status,
                        'cancel_date'=>Carbon::Now()]);
                        
            $cancel = DB::table('booking_cancel_list')
                            ->insert([
                                'cancel_reason'=>$cancel_reason,
                                'booking_id'=>$booking_id
                                ]);
                        
                                     // start sms
                 $sms_api_key=  DB::table('tbl_msg_key')
                      ->select('mag_auth_key', 'mag_sender_id','cancel_msg','cancel_msg')
                      ->first();
              $api_key = $sms_api_key->mag_auth_key;
              $sender_id = $sms_api_key->mag_sender_id;
              $cancel = $sms_api_key->cancel_msg;
              $discount = str_replace("&name",$name, $cancel);
              $discount1 = str_replace("&price",$price, $discount);
              $discount2 = str_replace("&time",$date, $discount1);
              $getAuthKey = $api_key;
                $getSenderId = $sender_id;
                $getInvitationMsg = $discount2; 

                $authKey = $getAuthKey;
              // $mobileNumber1 = 8859593839;
                $senderId = "UBCORN";
                $route = "4";
                $postData = array(
                            'apikey' => "6ZlHdXMHcdFF17Av",
                            'number' => $user_phone,
                            'message' => $getInvitationMsg,
                            'senderid' => $senderId,
                            'route' => $route
                        );
        
                        $url="http://sdgmapi.in/V2/http-api.php";
        
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
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
                      ->select('subject_cancel', 'body_cancel','head')
                      ->first();
                      $subject = $email->subject_cancel;
                      $body = $email->body_cancel;
                      $head1 = $email->head;
                      $discount = str_replace("&name",$name, $body);
                      $discount1 = str_replace("&price",$price, $discount);
                      $discount2 = str_replace("&date",$date, $discount1);
                    
                    // Always set content-type when sending HTML email
                    
                    // More headers
                    
                      $head .= "From:".$head1;
                       $message = $discount2;
                     
                    // ...and away we go Subject!
                    $retval = mail($to,$subject,$message,$head);
               
                 ////end send mail

                        
                    
              
              $message = array('status'=>'1', 'message'=>'Cancelled Sucessfully', 'data'=>$update);
                return $message;
    
      }
    	else
    	    {
    	        
    	        $update = DB::table('booking')
                        ->where('booking_id', $booking_id)
                        ->update(['booking_status'=>$booking_status,
                        'cancel_date'=>Carbon::Now()]);
                        
                        
                $cancel = DB::table('booking_cancel_list')
                            ->insert([
                                'cancel_reason'=>$cancel_reason,
                                'booking_id'=>$booking_id
                                ]);        
                        
                                     // start sms
                 $sms_api_key=  DB::table('tbl_msg_key')
                      ->select('mag_auth_key', 'mag_sender_id')
                      ->first();
                            $api_key = $sms_api_key->mag_auth_key;
              $sender_id = $sms_api_key->mag_sender_id;
              $cancel = $sms_api_key->cancel_msg;
               $discount = str_replace("&name",$name, $cancel);
              $discount1 = str_replace("&price",$price, $discount);
              $discount2 = str_replace("&time",$date, $discount1);
              $getAuthKey = $api_key;
                $getSenderId = $sender_id;
                $getInvitationMsg = "Hi".$cancel .$price."."; 

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
                      ->select('subject_cancel', 'body_cancel','head')
                      ->first();
                      $subject = $email->subject_cancel;
                      $body = $email->body_cancel;
                      $head1 = $email->head;
                      $discount = str_replace("&name",$name, $body);
                      $discount1 = str_replace("&price",$price, $discount);
                      $discount2 = str_replace("&date",$date, $discount1);
                    
                    // Always set content-type when sending HTML email
                    
                    // More headers
                    
                      $head .= "From:".$head1;
                       $message = $discount2;
                     
                    // ...and away we go Subject!
                    $retval = mail($to,$subject,$message,$head);
               
                 ////end send mail

    	        
    	   $partner = DB::table('partner')
    	            ->where('partner_id',$partner_id)
    	            ->first();
    	            $partner_coins = $partner->coins;
    	            
    	            $update_coins = $partner_coins + $booking_coins;
    	            
    	   $partner1 = DB::table('partner') 
    	            ->where('partner_id',$partner_id)
    	            ->update([
    	                'coins'=>$update_coins
    	                ]);
            		$message = array('status'=>'0', 'message'=>'Cancelled Sucessfully', 'data'=>$partner1);
                    return $message;
        	}
      
            
      
  }
  
  
  public function cancelreasonlist(Request $request)
  {
      $booking = DB::table('cancellation_list')

                    ->get();
                    
        if($booking){
          
          $message = array('status'=>'1', 'message'=>'Cancel Reason List', 'data'=>$booking);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Error Occured', 'data'=>[]);
            return $message;
        	}
            
      
  }
    
}