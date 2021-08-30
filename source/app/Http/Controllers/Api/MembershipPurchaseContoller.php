<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class MembershipPurchaseContoller extends Controller
{
    public function purchase(Request $request)
    {
        $created_at = Carbon::now();
         $plan_id=$request->plan_id;
         $user_id=$request->user_id;
        $start_date = date('d-m-Y');
        
            $membership_plan= DB::table('membership_plan')
                                ->where('plan_id',$plan_id)
                                ->first();
        
                        $end_date = date('d-m-Y', strtotime($start_date.' + '.$membership_plan->plan_days.' days'));
        


                 $membership_user = DB::table('membership_user')
                ->insert([
                     'user_id'=>$user_id,
                     'plan_id'=>$plan_id,
                     'created_at'=>$created_at,
                     'start_date'=>$start_date,
                     'end_date'=>$end_date,
                        ]); 
                        
                        if($membership_user)
                        {
                          $message = array('status'=>'1', 'message'=>'Plan Puchase','data'=>$membership_user);
                            return $message; 
                        }else
                        {
                            $message = array('status'=>'1', 'message'=>'Need to Buy','data'=>[]);
                            return $message; 
                        }

}
    
}