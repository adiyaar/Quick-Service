<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class WithdrawController extends Controller
{
public function withdrawreq(Request $request)
  {
      $booking_id=$request->booking_id;
      $partner_id=$request->partner_id;
      
      $check =  DB::table('payout_requests')
                ->where('booking_id', $booking_id)
                ->first();
      $booking = DB::table('booking')
                ->join('tbl_user','booking.id','tbl_user.id')
                ->where('booking.booking_id',$booking_id)
                ->first();
                
                
        $part = DB::table('partner')
            ->where('partner_id',$partner_id)
            ->first();       
        $booking_coins =   $booking->coins;
        $price =   $booking->price;
        $upi = $part->upi;
       
        $user_phone =   $booking->user_phone;
        $email =   $booking->user_email;
        $name = $booking->user_name;
        $req_date =date('Y-m-d');
        $date =$booking->confirmed_on;
        if($check){
            $message = array('status'=>'0', 'message'=>'Withdraw Request Already Sent');
                    return $message;
        }
        else{
         if($upi == null){
            	$message = array('status'=>'2', 'message'=>'Please enter UPI/Paypal ID first for payment');
                    return $message;
        }else{
        $insert = DB::table('payout_requests')
                ->insert(['partner_id'=>$partner_id,
                'booking_id' => $booking_id,'booking_price'=>$price, 'request_date'=>$req_date, 'booking_date'=>$date, 'booking_coins'=>$booking_coins,'upi'=>$upi]);
        
           if($insert){
            		$message = array('status'=>'1', 'message'=>'Withdrawal request sent sucessfully');
                    return $message;
        	}
        	else{
        	    	$message = array('status'=>'0', 'message'=>'Try again later');
                    return $message;
        	}
      
        } 
        }
  }
  
  
 public function complete_order(Request $request)
  {
       $partner_id=$request->partner_id;

    	$booking = DB::table('booking')
    	                    ->join('tbl_user','tbl_user.id','=','booking.id')
    	                    ->leftJoin('payout_requests', 'booking.booking_id','=','payout_requests.booking_id')
    	                ->select('tbl_user.user_name','booking.time_slot','booking.coins','booking.user_address','booking.user_phone','booking.confirmed_on','booking.booking_id','booking.unique_code','payout_requests.req_id','payout_requests.complete')
    	                ->groupBy('tbl_user.user_name','booking.time_slot','booking.coins','booking.user_address','booking.user_phone','booking.confirmed_on','booking.booking_id','booking.unique_code','payout_requests.req_id','payout_requests.complete')
    	                ->where('booking.partner_id',$partner_id)
    	                ->where('booking.booking_status',3)
                        ->get();
                    
        if(count($booking)>0){
            foreach($booking as $books){
                 if($books->complete != NULL){
                  $complete = $books->complete;
                  }elseif($books->complete == 3){
                   $complete = "0"; 
                  }else{
                   $complete = "0"; 
                  }
                  
                 $data[] = array(
                  'user_name' => $books->user_name,
                  'time_slot' => $books->time_slot,
                  'coins'=> $books->coins,
                  'user_address'=> $books->user_address,
                  'user_phone'=>$books->user_phone,
                  'confirmed_on'=> $books->confirmed_on,
                  'unique_code'=>$books->unique_code,
                  'booking_id' =>$books->booking_id,
                  'req_id'=>$books->req_id,
                  'complete' =>$complete,
                 );
            }
          
          $message = array('status'=>'1', 'message'=>'Complete Order List', 'data'=>$data);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Error Occured', 'data'=>[]);
            return $message;
        	}
            
      
  }
  
  
  public function admin_paid(Request $request)
  {
       $partner_id=$request->partner_id;
      $booking = DB::table('partner_earning')
                ->where('partner_id',$partner_id)
                ->first();
                    
        if($booking){
          
          $message = array('status'=>'1', 'message'=>'Admin total paid and last paid', 'data'=>$booking);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Error Occured', 'data'=>[]);
            return $message;
        	}
            
      
  }
  
    public function updateupi(Request $request)
    {
        $upi = $request->upi;
        $partner_id =$request->partner_id;
        $update = DB::table('partner')
                 ->where('partner_id',$partner_id)
                 ->update(['upi'=>$upi]);
                 
        	if($update){
    		$message = array('status'=>'1', 'message'=>'Updated Sucessfully');
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'please try again later');
            return $message;
        	}         
                 
    }
    
}