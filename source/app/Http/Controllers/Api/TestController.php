<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class TestController extends Controller
{
   
    public function city_services(Request $request)
    {
    
        $city_id = $request->city_id;
    	$child_category_id = $request->child_category_id;
        
        $services = DB::table('services')
                    ->where('partner_id',$city_id)
                    ->where('child_category_id',$child_category_id)
                    ->get();
                    
        	if(count($services)>0){
    		$message = array('status'=>'1', 'message'=>'Services in your City', 'data'=>$services);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}            
        
    
        
         
    }
    
     public function popular_city_services(Request $request)
    {
    
        $city_id = $request->city_id;
        
        $services = DB::table('services')
                    ->where('partner_id',$city_id)
                    ->get();
                    
        	if(count($services)>0){
    		$message = array('status'=>'1', 'message'=>'Popular Services ', 'data'=>$services);
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
        
        $services = DB::table('hygine_price')
                    ->where('child_category_id',$child_category_id)
                    ->get();
                    
        	if(count($services)>0){
    		$message = array('status'=>'1', 'message'=>'Hygine Price', 'data'=>$services);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}            
        
    
        
         
    }
    
}
