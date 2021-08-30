<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CouponController extends Controller
{
    public function coupon()
    {
       $date = date('Y-m-d');
    	$scratch = DB::table('coupon')
    	            ->whereDate('end_date','>',$date)
    	            ->orderBy("cart_value", "DESC")
    				->get();

    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'Coupon List', 'data'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
    
  public function coupon_cart_list(Request $request)
    {  
       $total_amount =$request->total_amount;
       
        $redeem_points = DB::table('coupon')
            ->where('cart_value','<=',$total_amount)
              ->orderBy("cart_value", "DESC")
              ->get();
    
         if(count($redeem_points)>0){
            $message = array('status'=>'1', 'message'=>'Coupon List', 'data'=>$redeem_points);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'Something Went Wrong', 'data'=>[]);
            return $message;
        }
    }
     public function coupon_applied(Request $request)
    {  
       $total_amount =$request->total_amount;
       $coupon_id =$request->coupon_id;
        $redeem_points = DB::table('coupon')
            ->where('coupon_id',$coupon_id)
             ->select('coupon_discount','type')
              ->first();
              $amount=$redeem_points->coupon_discount;
              $type=$redeem_points->type;
              
              if($type=='percentage')
              {
              $new_price = ($amount/100) * $total_amount; 
              $final_price = $total_amount-$new_price;
    
            $message = array('status'=>'1', 'message'=>'Coupon Applied Sucessfully', 'data'=>$final_price);
            return $message;
            }
        else{
             $final_price = $total_amount-$amount;
            $message = array('status'=>'1', 'message'=>'Coupon Applied Sucessfully', 'data'=>$final_price);
            return $message;
        }
    }
}