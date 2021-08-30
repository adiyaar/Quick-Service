<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class TotalcoinsController extends Controller
{
    public function coins(request $request)
    {
        $user_id =$request->id;
    	$tbl_user = DB::table('tbl_user')
    	            ->select('user_reward')
    	            ->where('id',$user_id)
    				->get();

    	if($tbl_user){
    		$message = array('status'=>'1', 'message'=>'Total Coins', 'data'=>$tbl_user);
        	return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'No Coins', 'data'=>[]);
        	return $message;
    	}
    }
}
