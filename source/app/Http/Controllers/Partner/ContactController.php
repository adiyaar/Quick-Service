<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Hash;
use Session;

class ContactController extends Controller
{
    public function partnerenquiry(Request $request)
    {
      $title = "index";
      $partner_id = Session::get('bamaPartner');
    
      $booking = DB::table('booking')
             ->where('partner_id',$partner_id)
             ->where('booking_status',1)
             ->get();
      $users = DB::table('tbl_user')
              ->get();   
      $partner = DB::table('partner')
               ->where('partner_id',$partner_id)
               ->first();  
             
      return view('web.layout.contact',compact('partner_id','booking','users','partner'));
        
   
    }
    
     public function contact(Request $request)
    {
      $title = "index";
      $partner_id = Session::get('bamaPartner');
       $name = $request->name;  
       $email = $request->email;
       $number = $request->number;
       $profession = $request->profession;
       $message= $request->message;
       $created_at = Carbon::now();        
      
     
         	$insert = DB::table('partner_enquiry')
    	                   ->insert([
                                'name'=>$name,
                                'email'=>$email,
                                'number'=>$number,
                                'proffesion'=>$profession,
                                'message'=>$message,
                                'created_at'=>$created_at,
                                'partner_id'=>$partner_id,
                               
                            ]);
        
            if($insert){
                return redirect()->route('partnerenquiry');
            }
            else{
                return redirect()->back()->withErrors("Something wents wrong");
            }  
      
   
    }
  
    public function term(Request $request)
    {
      $title = "index";
      $partner_id = Session::get('bamaPartner');
    
      $booking = DB::table('booking')
             ->where('partner_id',$partner_id)
             ->where('booking_status',1)
             ->get();
      $users = DB::table('tbl_user')
              ->get();   
      $partner = DB::table('partner')
               ->where('partner_id',$partner_id)
               ->first();  
     $termcondition = DB::table('termcondition')
               ->first();      
      return view('web.layout.term',compact('partner_id','booking','users','partner'));
        
   
    }
   
}
