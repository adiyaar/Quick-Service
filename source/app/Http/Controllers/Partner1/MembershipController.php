<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;

class MembershipController extends Controller
{
    
    public function membershiplist(Request $request)
    {
        $admin_email=Session::get('admin');
        $membership_plan= DB::table('membership_plan')
                            ->get();
        return view('admin.membership.membershiplist',compact("admin_email","membership_plan"));
    }
    public function membershipadd(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
        $admin_email=Session::get('admin');
        $membership_plan= DB::table('membership_plan')
                            ->get();
        return view('admin.membership.membershipadd',compact("admin_email",'membership_plan'));    
        
    }
    
     public function membershipnewadd(Request $request)
     {
         return redirect()->back()->withErrors('this function is disabled for demo.');
         $plan_week=$request->plan_week;
         $plan_price=$request->plan_price;
        //  $plan_days=$request->days;
         
         $this->validate(
            $request,
                [
                    
                    'plan_week'=>'required',
                    'plan_price'=>'required',
                   
                ],
                [
                    
                    'plan_week.required'=>'Enter Coins',
                    'plan_price.required'=>"Enter Coin Price",
                   
                    
                ] );
         
         $insert= DB::table('membership_plan')
                        ->insert(['coins'=>$plan_week,'coin_price'=>$plan_price]);
                         return redirect()->back()->withErrors('Add Successfully');
         
                        }
     
     public function membershipedit(Request $request)
     {
         return redirect()->back()->withErrors('this function is disabled for demo.');
             $plan_id=$request->plan_id;
              $admin_email=Session::get('admin');
              $membership_plan= DB::table('membership_plan')
                                ->where('plan_id',$plan_id)
                                ->first();
              return view('admin.membership.membershipedit',compact("admin_email",'membership_plan'));  
     }
     public function membershipupdate(Request $request)
     { 
         return redirect()->back()->withErrors('this function is disabled for demo.');
         $this->validate(
            $request,
                [
                    
                    'plan_week'=>'required',
                    'plan_price'=>'required',
                   
                ],
                [
                    
                    'plan_week.required'=>'Enter Coins',
                    'plan_price.required'=>"Enter Coin Price",
                   
                    
                ] );
                 $plan_week=$request->plan_week;
                 $plan_price=$request->plan_price;
                 $plan_id=$request->id;
                //  $plan_days=$request->days;
         
            $update= DB::table('membership_plan')
                    ->where('plan_id',$plan_id)
                    ->update(['coins'=>$plan_week,'coin_price'=>$plan_price]);
                    
                if($update){

                     return redirect()->back()->withErrors(' updated successfully');
                         }
                 else{
            return redirect()->back()->withErrors("something wents wrong.");
                        }
     }
     public function membershipdelete(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
                    $plan_id=$request->plan_id;
            
                    $membership_plan= DB::table('membership_plan')
                            ->where('plan_id',$plan_id)
                            ->first();
            
                	$delete=DB::table('membership_plan')->where('plan_id',$request->plan_id)->delete();
                    if($delete)
                    {
                     
                    return redirect()->back()->withErrors('delete successfully');
            
                    }
                    else
                    {
                       return redirect()->back()->withErrors('unsuccessfull delete'); 
                    }
    }

         
     
    
}
