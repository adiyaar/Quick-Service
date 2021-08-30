<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Hash;
use Session;

class CreditHistoryController extends Controller
{
    public function credithistory(Request $request)
    {
        $title = "index";
      $partner_id = Session::get('bamaPartner');
    //   dd($partner_id);
    $booking = DB::table('booking')
             ->where('partner_id',$partner_id)
             ->where('booking_status',1)
             ->get();
    $users = DB::table('tbl_user')
                        ->get();   
     $partner = DB::table('partner')
                        ->where('partner_id',$partner_id)
                        ->first();  
                        
      return view('web.layout.credit_history',compact('partner_id','booking','users','partner'));
        
   
    }
    
    
  
    
}
