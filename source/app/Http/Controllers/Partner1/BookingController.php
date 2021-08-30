<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function bookinglist(Request $request)
        {
          $admin_email=Session::get('admin');
          
          $booking = DB::table('booking')
                    ->join('tbl_user','booking.id','=','tbl_user.id')
                    ->leftjoin('partner','booking.partner_id','=','partner.partner_id')
                    ->select('booking.price','booking.payment_mode','booking.booking_status','tbl_user.user_name','tbl_user.user_phone','booking.confirmed_on','booking.booking_date','partner.partner_name')
                     ->paginate(20);

        return view('admin.booking.booking',compact("admin_email","booking"));
    }
    
     public function cancelationlist(Request $request)
        {
          $admin_email=Session::get('admin');
          
          $booking = DB::table('booking')
                    ->join('tbl_user','booking.id','=','tbl_user.id')
                    ->where('booking_status','2')
                    ->paginate(20);

        return view('admin.booking.cancelation',compact("admin_email","booking"));
    }

    


}