<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Hash;
use Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $title = "index";
      $partner_id = Session::get('bamaPartner');
    //   dd($partner_id);
    $booking = DB::table('booking')
                        ->get();
    $users = DB::table('tbl_user')
                        ->get();   
     $partner = DB::table('partner')
                        ->where('partner_id',$partner_id)
                        ->first();  
                        
      return view('web.layout.app',compact('partner_id','booking','users','partner'));
        
   
    }
    
    
  
    
}
