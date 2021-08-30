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
            
            $coins_id=$request->coins_id;
            
            $faq_category=DB::table('booking_coins')
                        
                         ->first();
       
        return view('admin.booking_coin',compact("faq_category"));
    }
    
    public function coinsupdate(Request $request)
        {
       
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