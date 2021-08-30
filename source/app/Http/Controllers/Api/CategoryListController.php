<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CategoryListController extends Controller
{
    public function category()
    {
    	$scratch = DB::table('category')
    				->get();

    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'Category List', 'data'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
}