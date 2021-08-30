<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class HomeBannerController extends Controller
{
    public function banner()
    {
    	$scratch = DB::table('tbl_banner')
    				->get();

    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'Home Banner', 'data'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
    
        public function lowebanner()
    {
    	$scratch = DB::table('lower_banner')
    				->get();

    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'Lower banner', 'data'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
    
          public function hygine_price(Request $request)
    {
         $child_category_id = $request->child_category_id;
    	$scratch = DB::table('hygine_price')
    	            ->where('child_category_id',$child_category_id)
    				->first();

    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'Lower banner', 'data'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
}