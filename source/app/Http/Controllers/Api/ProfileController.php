<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class AddressController  extends Controller
{
    
      public function editaddress(Request $request)
    {
        
            $user_id = $request->user_id;

    	    $insertaddress = DB::table('user_address')
    	                   ->where('address_id',$address_id)
    						->update([
    							'user_id'=>$user_id,
    						    'city_name'=>$city_name,
    						    'user_name'=>$user_name,
    						    'user_phone'=>$user_phone,
    							'area_name'=>$area_name,
    							'address'=>$address,
    							'lat' => $lat,
    							'lng' => $lng
                            ]);
                            
           if($insertaddress){
                $message = array('status'=>'1', 'message'=>'Address updated');
                return $message;
                            }		
           else{
                 $message = array('status'=>'0', 'message'=>'something went wrong');
	            return $message;
    	}
      } 
      

    

      
    }
