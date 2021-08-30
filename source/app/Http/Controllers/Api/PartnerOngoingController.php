<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class PartnerOngoingController extends Controller
{
    public function partnerongoing(Request $request)
    {
        $user_id=$request->partner_id;
    	$booking = DB::table('booking')
                        ->leftjoin('booking_details','booking.booking_id','=','booking_details.booking_id')
                        ->leftjoin('services','booking_details.service_id','=','services.service_id')
                        ->join('tbl_user','booking.id','=','tbl_user.id')
                        ->leftjoin('addons_booking','booking.booking_id','=','addons_booking.booking_id')
                        ->leftjoin('add_ons_des','addons_booking.des_id','=','add_ons_des.des_id')
                        ->select('add_ons_des.add_on_price','tbl_user.user_name','services.service_name','tbl_user.user_phone','booking.booking_id','booking.booking_date','booking.time_slot','booking.confirmed_on','booking.payment_mode','booking.price','booking.booking_status',DB::raw("SUM('addons_booking.add_on_price') as sum"))
                        ->groupBy('add_ons_des.add_on_price','tbl_user.user_phone','tbl_user.user_name','services.service_name','booking.booking_id','booking.booking_date','booking.time_slot','booking.confirmed_on','booking.payment_mode','booking.price','booking.booking_status')
                        ->where('booking.id', $user_id)
                        ->get();
    	if(count($booking)>0){
    		$message = array('status'=>'1', 'message'=>'Booking', 'data'=>$booking);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }

}