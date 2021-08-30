<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class AddonsController extends Controller
{
    public function addons(Request $request)
    {
        $child_category_id =$request->child_category_id;
    	$scratch = DB::table('add_ons')
    	                ->join('sub_child_category','add_ons.child_category_id','=','sub_child_category.child_category_id')
    	                ->join('add_ons_des','add_ons.add_on_id','=','add_ons_des.add_on_id')
    	                ->where('add_ons.child_category_id',$child_category_id)
    	                ->select('sub_child_category.child_name','add_ons_des.add_on_des','add_ons_des.add_on_price','add_ons_des.des_id')
            			->get();

    	if(count($scratch)>0){
    		$message = array('status'=>'1', 'message'=>'What include in the Package ?', 'data'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
}