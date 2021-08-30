<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ComplaintController extends Controller
{
    public function complaint()
    {
    	$scratch = DB::table('complaint_raise')
    				->get();

    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'Complaint List', 'data'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
}