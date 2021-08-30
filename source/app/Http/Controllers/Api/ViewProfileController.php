<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class ViewProfileController extends Controller
{
    public function userprofileview(Request $request)
    {
        $booking_id = $request->booking_id;
        
        $booking = DB::table('booking')
                    ->join('tbl_user','booking.id','tbl_user.id')
                    ->where('booking_id',$booking_id)
                    ->first();
      
    }
}