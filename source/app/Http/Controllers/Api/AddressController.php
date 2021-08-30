<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class AddressController  extends Controller
{
    public function address(Request $request)
    {
            $user_id = $request->user_id;
            $user_phone = $request->user_phone;
            $user_name = $request->user_name;
            $city_name = $request->city_name;
            $area_name = $request->area_name;
            $house_no = $request->house_no;
            $street = $request->street;
            $state = $request->state;
            $pin = $request->pin;
            $address = $house_no .",".  $street .",".  $area_name .",".  $city_name .",".  $state .",". $pin; 
            $addres = str_replace(" ", "+", $address);
            $address1 = str_replace("-", "+", $addres);
            
            $map = DB::table('gmap_key')
                        ->first();
        

        $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address1."&key=".$map->map_key));

       // $location = json_encode(array("lat"=>$response->results[0]->geometry->location->lat, "lng"=>$response->results[0]->geometry->location->lng));
        
        
        // return var_dump($response);
         $lat = $response->results[0]->geometry->location->lat;
         $lng = $response->results[0]->geometry->location->lng;
    	    $insertaddress = DB::table('user_address')
    						->insert([
    							'user_id'=>$user_id,
    							'city_name'=>$city_name,
    							'area_name'=>$area_name,
    							'user_phone'=>$user_phone,
    							'user_name'=>$user_name,
    							'address'=>$address,
    							'lat' => $lat,
    							'lng' => $lng
                            ]);
                            
          if($insertaddress){
                $message = array('status'=>'1', 'message'=>'Address Inserted');
                return $message;
                            }		
          else{
                 $message = array('status'=>'0', 'message'=>'something went wrong');
	            return $message;
    	}
      }
      
      
      public function editaddress(Request $request)
    {
        
            $user_id = $request->user_id;
            $user_phone = $request->user_phone;
            $user_name = $request->user_name;
            $address_id = $request->address_id;
            $city_name = $request->city_name;
            $area_name = $request->area_name;
            $house_no = $request->house_no;
            $street = $request->street;
            $state = $request->state;
            $pin = $request->pin;

            $address = $house_no .",".  $street .",".  $area_name .",".  $city_name .",".  $state .",". $pin; 
            $addres = str_replace(" ", "+", $address);
            $address1 = str_replace("-", "+", $addres);
        

        $map = DB::table('gmap_key')
                        ->first();
        

        $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address1."&key=".$map->map_key));

       // $location = json_encode(array("lat"=>$response->results[0]->geometry->location->lat, "lng"=>$response->results[0]->geometry->location->lng));
        
         $lat = $response->results[0]->geometry->location->lat;
         $lng = $response->results[0]->geometry->location->lng;
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
      
    public function showaddress(Request $request)
    {
            $user_id = $request->user_id;
           
            $address = DB::table('user_address')
                 ->get();
            if($address){
                $message = array('status'=>'1', 'message'=>'data found', 'data'=>$address);
                return $message;
                            }   
           else{
                 $message = array('status'=>'0', 'message'=>'data not found');
              return $message;
      }
    }
    
    
    public function DeleteUserAddress(Request $request)
    {
        $address_id=$request->address_id;
        $dalete = DB::table('user_address')->where('address_id',$address_id)->delete();
        
        if($dalete)
        {
            $message = array('status'=>'1', 'message'=>'Address Delete Successfully');
        }
        else
        {
            $message = array('status'=>'0', 'message'=>'Something Wents Wrong');
        }
        return $message;
    }
      
    }
