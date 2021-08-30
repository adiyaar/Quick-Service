<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class PartnerBookingController extends Controller
{
    public function bookinglistpartner(Request $request)
    {
    	$booking = DB::table('booking')
    	                ->join('tbl_user','tbl_user.id','=','booking.id')
    	                ->select('tbl_user.user_name','booking.time_slot','booking.coins','booking.user_address','booking.user_phone','booking.confirmed_on','booking.booking_id','booking.lat','booking.lng')
    	                ->where('booking_status',0)
    	                ->orderBy('booking.booking_date', 'DESC')
                        ->get();
    	if(count($booking)>0){
    		$message = array('status'=>'1', 'message'=>'Booking List', 'data'=>$booking);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Whoops, No Booking', 'data'=>[]);
            return $message;
        	}
    }
    
    public function onbookingclick(Request $request)
    {
        $booking_id = $request->booking_id;
    	$booking = DB::table('booking')
    	                 ->join('tbl_user','tbl_user.id','=','booking.id')
    	                ->where('booking.booking_id',$booking_id)
                        ->get();
                        
                  
    	 if(count($booking)>0){
      foreach($booking as $completeds){
      $order = DB::table('booking_details')
            ->join ('services', 'booking_details.service_id', '=', 'services.service_id')
                  ->select('services.service_name','services.service_description')
                  ->where('booking_details.booking_id',$completeds->booking_id)
                  ->groupBy('services.service_name','services.service_description')
                  ->get();
                  
        
        $data[]=array('user_name'=>$completeds->user_name,'time_slot'=>$completeds->time_slot, 'confirmed_on'=>$completeds->confirmed_on, 'coins'=>$completeds->coins,'payment_mode'=>$completeds->payment_mode,'data'=>$order); 
        }
        }
        else{
            $data[]=array('data'=>'No Detail Found');
        }
        return $data;  
    }
    
    public function partnerbuybooking(Request $request)
    {
        $booking_id = $request->booking_id;
        $partner_id=$request->partner_id;
    	$booking = DB::table('booking')
    	            ->where('booking_id',$booking_id)
                        ->first();
        $booking_price= $booking->coins;
        
        $partner = DB::table('partner')
                        ->where('partner_id',$partner_id)
                        ->first();
        $partner_coins = $partner->coins;
        
        if($booking_price<=$partner_coins)
        {
                      
              $booking2 = DB::table('booking')
                        ->where('booking_id',$booking_id)
                        ->update([
                            'booking_status'=>1,
                            'partner_id'=>$partner_id 
                       ]); 
                if($booking2)
                {
                    $partner_update_coin = $partner_coins-$booking_price;
            
                    $partner1 = DB::table('partner')
                        ->where('partner_id',$partner_id)
                        ->update
                        (['coins'=>$partner_update_coin 
                        ]);
                    
                    
                     $message = array('status'=>'1', 'message'=>'Booking Buy Sucessfully', 'data'=>$booking);
                     return $message;
                }
               
        }
    	else{
    		$message = array('status'=>'0', 'message'=>'Insufficient Coins', 'data'=>[]);
            return $message;
        	}
    }
    
    public function partnerbookinghistory(Request $request)
    {
        $partner_id=$request->partner_id;
    	$booking = DB::table('booking')
    	                    ->join('tbl_user','tbl_user.id','=','booking.id')
    	                ->select('tbl_user.user_name','booking.time_slot','booking.coins','booking.user_address','booking.user_phone','booking.confirmed_on','booking.booking_id','booking.unique_code')
    	                ->where('partner_id',$partner_id)
    	                ->where('booking_status',3)
                        ->get();
    	if(count($booking)>0){
    		$message = array('status'=>'1', 'message'=>'Booking History', 'data'=>$booking);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Whoops, No Booking', 'data'=>[]);
            return $message;
        	}
    }
    
    public function partnerstartbooking(Request $request)
    {
        $partner_id=$request->partner_id;
        $booking_id = $request->booking_id;
        $code= $request->code;
    	$booking = DB::table('booking')
    	               // ->where('partner_id',$partner_id)
    	                ->where('booking_id',$booking_id)
                        ->first();
        $booking_code =   $booking->unique_code;
        $user_id =$booking->id;
        
        if($booking_code == $code)
        {
            
            $booking1 = DB::table('booking')
    	                ->where('booking_id',$booking_id)
    	                ->update([
                            'booking_status'=>4,
                 
                       ]);
                       
        $message = array('status'=>'3', 'message'=>'Services started', 'data'=>$booking1);
            return $message;
        }
        
    	else{
    		$message = array('status'=>'0', 'message'=>'Whoops, Please enter valid code', 'data'=>[]);
            return $message;
        	}
    }
    
    public function partnermarkedcompleted(Request $request)
    {
        $partner_id=$request->partner_id;
        $booking_id = $request->booking_id;
        // $user_id = $request->booking_id;
        // $code= $request->code;
    	$booking = DB::table('booking')
    	                ->where('partner_id',$partner_id)
    	                ->where('booking_id',$booking_id)
                        ->first();
        // $booking_code =   $booking->unique_code;
        // $user_id =$booking->id;
        
            
            $booking1 = DB::table('booking')
    	                ->where('booking_id',$booking_id)
    	                ->update([
                            'booking_status'=>3,
                 
                       ]);
                       
        if($booking1)   {            
                       
        $message = array('status'=>'3', 'message'=>'Booking Completed', 'data'=>$booking1);
            return $message;
        }
        
    	else{
    		$message = array('status'=>'0', 'message'=>'Whoops, Something Went Wrong', 'data'=>[]);
            return $message;
        	}
    }
    
    public function booking_list_for_partner(Request $request)
    {
    	$partner_id = $request->partner_id;
       
       
       $partner = DB::table('partner')
                ->where('partner_id',$partner_id)
                ->first();
        $lat =    $partner->lat;
        $lng =    $partner->lng;
        $range =    $partner->range;
        $child_cat_id = $partner->child_cat_id;
      
       $nearbystore = DB::table('booking')
                    ->join('tbl_user','tbl_user.id','=','booking.id')
                    ->join('sub_child_category','booking.child_category_id','=','sub_child_category.child_category_id')
                    ->select('tbl_user.user_name','booking.time_slot','booking.coins','booking.user_address','booking.user_phone','booking.confirmed_on','booking.booking_id','booking.lat','booking.lng',DB::raw("6371 * acos(cos(radians(".$lat . ")) 
                    * cos(radians(booking.lat)) 
                    * cos(radians(booking.lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(booking.lat))) AS distance"))
                    ->orderBy('distance')
                     ->where('booking_status',0)
                      ->where('sub_child_category.child_category_id',$child_cat_id)
    	                ->orderBy('booking.booking_date', 'DESC')
                  ->get();
                  
    	  $storelist = NULL;
        foreach($nearbystore as $store)
        {
            
            if($range > $store->distance){
                $storelist[] = $store; 
            }
        }
        
    if ($storelist != NULL){
            $message = array('status'=>'1', 'message'=>'NearBy Store', 'data'=>$storelist);
            
            return $message;
           
        }
        
        
        else{
             $message = array('status'=>'0', 'message'=>'We are Coming Soon', 'data'=>[]);
            return $message;

        }
    }
    
    
    
}