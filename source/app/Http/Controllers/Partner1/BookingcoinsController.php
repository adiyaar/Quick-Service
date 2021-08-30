<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class BookingcoinsController extends Controller
{
    public function coinsgenerated(Request $request)
        {
            // return redirect()->back()->withErrors('this function is disabled for demo.');
            $coins_id=$request->coins_id;
            
            $faq_category=DB::table('booking_coins')
                        // ->where('coins_id',$coins_id)
                         ->first();
       
        return view('admin.booking_coin',compact("faq_category"));
    }
    
    public function coinsupdate(Request $request)
        {
            // return redirect()->back()->withErrors('this function is disabled for demo.');
        // $coins_id=$request->coins_id;
        $percentage=$request->percentage;
        $discount = str_replace("%",'', $percentage);
        
        

    
             $update = DB::table('booking_coins')
                            ->update([
                                'coin_value'=>$discount,
                            ]);

     
        if($update){
            return redirect()->back()->withErrors('Updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Same value you have inserted");
        }
    }
    

    


}