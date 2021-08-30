<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;

class TimeSlotController extends Controller
{
        public function timeslot(Request $request)
        {
            // return redirect()->back()->withErrors('this function is disabled for demo.');
            $coins_id=$request->coins_id;
            
            $faq_category=DB::table('time_interval')
                         ->first();
       
        return view('admin.booking_time_slot',compact("faq_category"));
    }
    
    public function timeslotupdate(Request $request)
        {
            // return redirect()->back()->withErrors('this function is disabled for demo.');
        // $coins_id=$request->coins_id;
        $plan_week=$request->plan_week;
        $plan_price=$request->plan_price;
        $duration=$request->duration;
        
        

    
             $update = DB::table('time_interval')
                            ->update([
                                'start_time'=>$plan_week,
                                'EndTime'=>$plan_price,
                                'Duration'=>$duration
                            ]);

     
        if($update){
            return redirect()->back()->withErrors('Updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Same value you have inserted");
        }
    }
}
