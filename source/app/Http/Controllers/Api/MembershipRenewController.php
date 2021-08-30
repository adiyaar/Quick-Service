<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class MembershipRenewController extends Controller
{
    public function renew(Request $request)
    {
        $id=$request->user_id;
    	$membership_user = DB::table('membership_user')
    	                ->where('user_id',$id)
    				    ->first();
    				    $user_id=$id;
    				    $plan_id=$membership_user->plan_id;
    				    $start_date=$membership_user->start_date;
    				    $end_date=$membership_user->end_date;
    				    $updated_at = Carbon::now();
    				    
    				    $insert= DB::table('previous_user_membership_table')
    				            ->insert(['user_id'=>$user_id,'plan_id'=>$plan_id,'start_date'=>$start_date,'end_date'=>$end_date,'created_at'=>$updated_at]);
    				            
    				           

                	if(strtotime($start_date)>= strtotime($end_date))
    	        {
    	    	             
                                
                                 $plan_id=$request->plan_id;
                                  $start_date1 = date('d-m-Y');
                                $membership_plan= DB::table('membership_plan')
                                ->where('plan_id',$plan_id)
                                ->first();
                         $end_date1 = date('d-m-Y', strtotime($start_date1.' + '.$membership_plan->plan_days.' days'));
                         
                         $start_date1 = date('d-m-Y');
    	                          $update= DB::table('membership_user')
    				                    ->where('user_id',$id)
    				                    ->update([
    				                        'plan_id'=>$plan_id,
    				                        'start_date'=>$start_date1,
    				                        'end_date'=>$end_date1
    				                        ]);
    				                         $message = array('status'=>'0', 'message'=>'Plan Renew', 'data'=>[]);
                                 return $message;
    	
            	}
    	else{
    		$message = array('status'=>'1', 'message'=>'Plan Active', 'data'=>[]);
            return $message;
        	}
    }
}