<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class AdmobController extends Controller
{
    public function admob()
    {
    	$admob = DB::table('tbl_admob')
    				->where('id', '1')
    				->first();

    	if($admob){
    		$message = array('status'=>'1', 'message'=>'admob keys', 'data'=>$admob);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
    	}
    }
}
