<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CurrencyController extends Controller
{
    public function currency1(Request $request)
    {
        // $currency_id =$request->currency_id;
    	$scratch = DB::table('currency')
    				->first();

    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'Currency List', 'currency'=>$scratch->currency_symbol);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'No data found', 'data'=>[]);
            return $message;
        	}
    }
}