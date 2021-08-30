<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class LeadBuyController extends Controller
{
    public function leadpurchase(Request $request)
    {
        $partner_accept_booking = Carbon::now();
         $booking_id=$request->booking_id;
         $partner_id=$request->partner_id;
       
        
            $booking= DB::table('booking')
                                ->where('booking_id',$booking_id)
                                ->first();
                                 $booking_coin =  $booking->coins;   
                                 
                                 
            $partner= DB::table('partner')
                                ->where('partner_id',$partner)
                                ->first();
                                 $partner_coin =  $partner->coins;                      
        
                      if($partner_coin <= $booking_coin)  
    
                        {
                          $message = array('status'=>'1', 'message'=>'You Need more coins to buy this lead','data'=>$membership_user);
                            return $message; 
                        }else
                        {
                            $message = array('status'=>'1', 'message'=>'Need to Buy','data'=>[]);
                            return $message; 
                        }

}
    
}