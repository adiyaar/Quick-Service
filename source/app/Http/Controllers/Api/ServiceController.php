<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ServiceController extends Controller
{
    public function service(Request $request)
    {
       
    	$lat = $request->lat;
    	$lng = $request->lng;
        $child_category_id = $request->child_category_id;
        
    
    	

        $distance = DB::table("partner")
        ->join('services', 'partner.partner_id', '=', 'services.partner_id')
     
      ->select("services.service_name","services.service_price","services.mrp","services.time","services.service_price","services.service_img","services.service_description","services.service_id","partner.range"
        ,DB::raw("6371 * acos(cos(radians(".$lat . ")) 
        * cos(radians(partner.lat)) 
        * cos(radians(partner.lng) - radians(" . $lng . ")) 
        + sin(radians(" .$lat. ")) 
        * sin(radians(lat))) AS distance"))
        ->orderBy('distance')
        ->where('services.child_category_id', $child_category_id)
        ->get();
     $storelist = NULL;
        foreach($distance as $store)
        {
            if($store->range > $store->distance){
                $storelist[] = $store; 
            }
        }
        
    if ($storelist != NULL){
            $message = array('status'=>'1', 'message'=>'NearBy Store', 'data'=>$storelist);
            return $message;
           
        }
        
        
        else{
             $message = array('status'=>'0', 'message'=>'We are Coming Soon', 'data'=>[]);
            return $message;

        }
        
         
    }
    



    
        public function popularservice(Request $request)
    {
    
    $lat = $request->lat;
    	$lng = $request->lng;
        
        $distance = DB::table("partner")
        ->join('services', 'partner.partner_id', '=', 'services.partner_id')
         
   ->select("services.service_name","services.service_price","services.service_price","services.service_img","services.service_description","services.service_id","partner.range","services.child_category_id"
        ,DB::raw("6371 * acos(cos(radians(".$lat . ")) 
        * cos(radians(lat)) 
        * cos(radians(lng) - radians(" . $lng . ")) 
        + sin(radians(" .$lat. ")) 
        * sin(radians(lat))) AS distance"))
        ->orderBy('distance')
        ->get();
        $storelist = NULL;
        foreach($distance as $store)
        {
            if($store->range > $store->distance){
                $storelist[] = $store; 
            }
        }
        
    if ($storelist != NULL){
            $message = array('status'=>'1', 'message'=>'NearBy Store', 'data'=>$storelist);
            return $message;
           
        }
        
        
        else{
             $message = array('status'=>'0', 'message'=>'We are Coming Soon', 'data'=>[]);
            return $message;

        }
        
         
    }
    
}
