<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class FinanceController extends Controller
{

      public function pay_req(Request $request)
    {
         $title = "Withdraw Request";
    $admin_email=Session::get('admin');
    	 $admin= DB::table('tbl_admin')
    	 		   ->where('email',$admin_email)
    	 		   ->first();
        
         $total_earnings=DB::table('payout_requests')
                            ->join('partner', 'payout_requests.partner_id', '=', 'partner.partner_id')
                            ->join('booking', 'payout_requests.booking_id', '=', 'booking.booking_id')
                           ->select('partner.partner_name', 'partner.partner_phone','payout_requests.*')
                           ->get();
                        
    	return view('admin.partner.payoutRequest', compact('title',"admin","total_earnings"));
    }
    
    
    
     public function pay_reqdate(Request $request)
    {
   
    $admin_email=Session::get('admin');
    	 $admin= DB::table('tbl_admin')
    	 		   ->where('email',$admin_email)
    	 		   ->first();
    	 $show = $request->show;	
    	 $start_date =$request->start_date;
    	  $end_date =$request->end_date;
    	   $title = "Partner Withdraw Request (".$start_date." to " .$end_date.")";
         $total_earnings=DB::table('payout_requests')
                            ->join('partner', 'payout_requests.partner_id', '=', 'partner.partner_id')
                            ->join('booking', 'payout_requests.booking_id', '=', 'booking.booking_id')
                           ->select('partner.partner_name', 'partner.partner_phone','payout_requests.*')
                           ->where('payout_requests.request_date','>=',$start_date)
                           ->where('payout_requests.request_date','<',$end_date)
                           ->get();
       
    	return view('admin.partner.payoutRequestdate', compact('title',"admin","total_earnings"));
    }
    
    
     public function partner_pay(Request $request)
    {
        $req_id = $request->req_id;
        
        $st = DB::table('payout_requests')
            ->where('req_id',$req_id) 
            ->first();
        $store_id=$st->partner_id;
        $amt = $st->booking_price;
        $check = DB::table('partner_earning')
                ->where('partner_id',$store_id)
                ->first();
        $check2 = DB::table('partner')
                ->where('partner_id',$store_id)
                ->first();        
        $store_phone =  $check2->partner_phone;
        
        if($check){
        $new_amount = $check->total_paid + $amt;    
        $update = DB::table('partner_earning')
                ->where('partner_id',$store_id)
                ->update(['total_paid'=>$new_amount,
                'last_paid'=>$amt]);
        }
        else{
         $update = DB::table('partner_earning')
                ->insert(['partner_id'=>$store_id,'total_paid'=>$amt, 'last_paid'=>$amt]);   
        }
        $update =  DB::table('payout_requests')
                 ->where('req_id', $req_id)
                ->update(['complete'=>1]);
        if($update){
      
             return redirect()->back()->withSuccess('Amount of '.$amt.' marked paid successfully.');
        }
        else{
             return redirect()->back()->withErrors('Something Wents Wrong');
        }
    }   
    
    
     
     public function approve(Request $request)
    {
        $req_id = $request->req_id;
        
        $st = DB::table('payout_requests')
                 ->where('req_id', $req_id)
                ->update(['complete'=>2]);
       
        if($st){
      
             return redirect()->back()->withSuccess('Withdrawal request accepted.');
        }
        else{
             return redirect()->back()->withErrors('Something Wents Wrong');
        }
    }   
    
    
     
    public function reject(Request $request)
    {
        $req_id = $request->req_id;
        
        $st = DB::table('payout_requests')
                 ->where('req_id', $req_id)
                ->delete();
       
        if($st){
      
             return redirect()->back()->withSuccess('Withdrawal request rejected.');
        }
        else{
             return redirect()->back()->withErrors('Something Wents Wrong');
        }
    }   
       
       
       
}
