<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class MembershipPriceListController extends Controller
{
    public function membership()
    {
    	$scratch = DB::table('membership_plan')
    				->get();

    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'Plan List', 'data'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
}