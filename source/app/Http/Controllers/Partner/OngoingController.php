<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Hash;
use Session;

class OngoingController extends Controller
{
    public function ongoingpartner(Request $request)
    {
        $title = "index";
      $partner_id = Session::get('bamaPartner');
        
        $ongoing = DB::table('booking')
                    ->join('tbl_user','booking.id','=','tbl_user.id')
                    ->where('partner_id',$partner_id)
                    ->get();
                echo var_dump($ongoing);
        
        // return view('web.layout.ongoing',compact('partner_id','ongoing'));
    }
    
    
  
    

}
