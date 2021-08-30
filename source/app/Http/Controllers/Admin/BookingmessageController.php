<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class BookingmessageController extends Controller
{

    public function messageedit(Request $request)
        {
          
          $admin_email=Session::get('admin');
          $term = DB::table('tbl_msg_key')

                             ->first(); 
          return view('admin.booking_message.mesage',compact("admin_email","term"));
       
    }
    
 public function messageupdate(Request $request)
        {
       
        $booking=$request->booking;
        $reschedule=$request->reschedule;
        $cancelled=$request->cancelled;
        
        

    
             $update = DB::table('tbl_msg_key')
                            ->update([
                                'booking_msg'=>$booking,
                                'rescheduled_msg'=>$reschedule,
                                'cancel_msg'=>$cancelled
                            ]);

     
        if($update){
            return redirect()->back()->withErrors('Updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Same value you have inserted");
        }
    }
    
    public function mailedit(Request $request)
        {
           
          $admin_email=Session::get('admin');
          $term = DB::table('tbl_email')

                             ->first(); 
          return view('admin.booking_message.mail',compact("admin_email","term"));
       
    }
    
 public function mailupdate(Request $request)
        {
      
        $booking_body=$request->booking_body;
        $booking_subject=$request->booking_subject;
        $cancel_body=$request->cancel_body;
        $cancel_subject=$request->cancel_subject;
        $from=$request->from;
       
             $update = DB::table('tbl_email')
                            ->update([
                                'email_subject'=>$booking_subject,
                                'email_body'=>$booking_body,
                                'subject_cancel'=>$cancel_subject,
                                'body_cancel'=>$cancel_body,
                                'head'=>$from
                            ]);

     
        if($update){
            return redirect()->back()->withErrors('Updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Same value you have inserted");
        }
    }
        
    
    


}