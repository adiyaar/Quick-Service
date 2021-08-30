<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class CityController extends Controller
{
    public function citylist(Request $request)
        {
          $admin_email=Session::get('admin');
          
          $category = DB::table('partner_city')
                        ->get();
       
        return view('admin.city.citylist',compact("admin_email","category"));
    }
    
    public function addcity(Request $request)
        {
     
          $admin_email=Session::get('admin');
          
          $category = DB::table('partner_city')
                        ->get();
         $partner= DB::table('gmap_key')
                    ->first();   
         $map =    $partner->map_key;        
       
        return view('admin.city.addcity',compact("admin_email","category","partner","map"));
    }
    
    public function addnewcity(Request $request)
        {
     
                $partner1= DB::table('gmap_key')
                    ->first();
            $map= $partner1->map_key;
     
                $city_id=$request->city_id;
                 $category= DB::table('partner_city')
                         ->select('city_name')
                          ->where('city_id',$city_id)
                         ->first();
    
         $category_name=$request->category_name;
         
         $addres = str_replace(" ", "+", $category_name);
        $address1 = str_replace("-", "+", $addres);
        
        $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address1."&key=$map"));
        
         $lat = $response->results[0]->geometry->location->lat;
         $lng = $response->results[0]->geometry->location->lng;

        $this->validate(
            $request,
                [
                    
                    'category_name'=>'required',
                    
                ],
                [
                    
                    'category_name.required'=>'City Name Required',
                    
                ]
        );
       

                    $insert = DB::table('partner_city')
                    ->insert(['city_name'=>$category_name,
                               'lat'=>$lat,
                               'lng'=>$lng]);
     
                        return redirect()->back()->withErrors('Added Successfully');

    }
    
    public function editcity(Request $request)
        {
            $partner1= DB::table('gmap_key')
                    ->first();
            $map= $partner1->map_key;
       
            $city_id=$request->city_id;
                 $category= DB::table('partner_city')
                          ->where('city_id',$city_id)
                         ->first();
       
        return view('admin.city.editcity',compact("category","partner1"));
    }
    
    public function updatecity(Request $request)
        {
                 
         $partner1= DB::table('gmap_key')
         ->first();
 $map= $partner1->map_key;
            
            $this->validate(
            $request,
                [
                    
                    'category_name'=>'required',
                    
                ],
                [
                    
                    'category_name.required'=>'City Name Required',
                    
                ]
        );
        $city_id=$request->city_id;
        $category_name=$request->category_name;    
        
         $addres = str_replace(" ", "+", $category_name);
        $address1 = str_replace("-", "+", $addres);
        
        $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address1."&key=$map"));
        
         $lat = $response->results[0]->geometry->location->lat;
         $lng = $response->results[0]->geometry->location->lng;


  
        $updateBanner = DB::table('partner_city')
                            ->where('city_id', $city_id)
                            ->update([
                                'city_name'=>$category_name,
                                'lat'=>$lat,
                               'lng'=>$lng]);
        
        if($updateBanner){
            return redirect()->back()->withErrors('City updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
    
    public function deletecity(Request $request)
    {
      
       $city_id=$request->city_id;

        $getfile=DB::table('partner_city')
                ->where('city_id',$city_id)
                ->first();

    	$delete=DB::table('partner_city')->where('city_id',$request->city_id)->delete();
            	
    	
        if($delete)
        {
    
        return redirect()->back()->withErrors('Delete successfully');

        }
        else
        {
          return redirect()->back()->withErrors('unsuccessfull delete'); 
        }
 

    }
    

    
    


}