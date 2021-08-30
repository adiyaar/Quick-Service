<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class Term_ConditionController extends Controller
{
    public function terms_condition(Request $request)
    {
    	$scratch = DB::table('termcondition')
    	               
            			->first();

    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'Terms & Conditions', 'data'=>$scratch->termcondition);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'oops, SOmething Went Wrong', 'data'=>[]);
            return $message;
        	}
    }
    
    
     public function about_us(Request $request)
    {
    	$scratch = DB::table('aboutus')
    	               
            			->first();

    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'About Rapid', 'data'=>$scratch->description);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'oops, SOmething Went Wrong', 'data'=>[]);
            return $message;
        	}
    }
}