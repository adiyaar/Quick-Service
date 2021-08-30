<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class BuyCoinsController extends Controller
{
    public function purchasecoins(Request $request)
    {
        $recharge_date = Carbon::now();
         $plan_id=$request->plan_id;
         $partner_id=$request->partner_id;
         $status = $request->status;
        // $start_date = date('d-m-Y');
        
            $membership_plan= DB::table('membership_plan')
                                ->where('plan_id',$plan_id)
                                ->first();
                                
                                $coins = $membership_plan->coins;
                                $price = $membership_plan->coin_price;
        
            $partner1 = DB::table('partner')
                            ->where('partner_id',$partner_id)
                            ->first();
                            
                            $old_coins = $partner1->coins;


                 $membership_user = DB::table('recharge_partner')
                ->insert([
                     'partner_id'=>$partner_id,
                     'plan_id'=>$plan_id,
                     'coins'=>$coins,
                     'price'=>$price,
                     'status'=>$status,
                     'recharge_date'=>$recharge_date,
                        ]); 
                        
                     if($membership_user)
                        {
                            if($status=="success"){
                                
                                $update_coins = $old_coins+$coins;
                                $partner = DB::table('partner')
                                ->where('partner_id',$partner_id)
                                 ->update([
                                   'coins'=>$update_coins,
                                     ]); 
                                
                            }
                          $message = array('status'=>'1', 'message'=>'Recharge Sucessfully','data'=>$membership_user);
                            return $message; 
                        }else
                        {
                            $message = array('status'=>'0', 'message'=>'Something went Wrong','data'=>[]);
                            return $message; 
                        }

}
    
}