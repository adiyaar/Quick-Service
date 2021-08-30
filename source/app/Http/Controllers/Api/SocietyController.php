<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class SocietyController extends Controller
{
    public function society()
    {
    	$society = DB::table('tbl_society')
    				->get();

    	if($society){
    		$message = array('status'=>'1', 'message'=>'society list', 'data'=>$society);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
    	}
    }
    
    
}
