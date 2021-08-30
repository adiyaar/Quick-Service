<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Hash;
use Carbon\Carbon;

class LeadsPreviewController extends Controller
{
    public function leadlisting(Request $request)
        {
          $booking = DB::table('booking')
                        ->get();
        return view('partner.new',compact("booking"));
    }
    
     public function leaddescription(Request $request)
        {
          $booking_id =$request->booking_id;
          $booking = DB::table('booking')
                        ->where('booking_id',$booking_id)
                        ->first();
        return view('partner.lead_preview',compact("booking"));
    }
    
        
     public function leadpreview(Request $request)
        {
         $booking_id =$request->booking_id;
          $partner_id = Session::get('bamaPartner');
        //  dd($booking_id);
          $booking = DB::table('booking')
                        ->join('booking_details','booking_details.booking_id','=','booking.booking_id')
                        ->join('services','services.service_id','=','booking_details.service_id')
                        ->join('tbl_user','tbl_user.id','=','booking.id')
                        ->where('booking.booking_id',$booking_id)
                        ->first();
            
    //   dd($partner_id);
   
     $partner = DB::table('partner')
                        ->where('partner_id',$partner_id)
                        ->first();               
                       
        return view('web.layout.lead_preview',compact("booking",'partner'));
    }
    
  public function buylead(Request $request)
        {
         $booking_id =$request->booking_id;
         $partner_id = Session::get('bamaPartner');
        
         $booking = DB::table('booking')
                        ->where('booking_id',$booking_id)
                        ->first();
         $partner = DB::table('partner')
                        ->where('partner_id',$partner_id)
                        ->first(); 
         if($booking->coins<=$partner->coins)
         {
            $newcoins= $partner->coins-$booking->coins;
          $update = DB::table('booking')
         ->where('booking_id',$booking_id)
         ->update(['partner_id'=>$partner_id,'booking_status'=>1]);
         
          $update = DB::table('partner')
         ->where('partner_id',$partner_id)
         ->update(['coins'=>$newcoins]);
             return redirect()->route('successbuylead',$booking->booking_id);
         }
         else
         {
           return redirect()->route('leadpreview',[$booking->booking_id])->withErrors('You have not enough credits to buy this lead');   
         }
    }
    
  public function successbuylead(Request $request)
        {
            $booking_id =$request->booking_id;
            $bookings = DB::table('booking')
                ->join('tbl_user','tbl_user.id','=','booking.id')
                ->where('booking.booking_id',$booking_id)
                ->first();
            $partner_id = Session::get('bamaPartner');
            $booking = DB::table('booking')
                            ->get();
            $users = DB::table('tbl_user')
                            ->get();   
            $partner = DB::table('partner')
                            ->where('partner_id',$partner_id)
                            ->first();    
        return view('web.layout.success',compact("bookings",'booking','users','partner'));
       }

}