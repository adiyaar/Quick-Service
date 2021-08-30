<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class LowerBannerController extends Controller
{
    public function lowerbannerlist(Request $request)
        {
          
          $sub_category = DB::table('lower_banner')
                        ->get();

       
        // return view('admin.banner.lowerbanner.addlowerbanner',compact("sub_category"));
    }
    
    
    public function lowerbanner(Request $request)
        {
            // return redirect()->back()->withErrors('this function is disabled for demo.');
                 
    $sub_category = DB::table('lower_banner')
                        ->get();
       
        return view('admin.banner.lowerbanner.addlowerbanner',compact("sub_category"));
    }
    
  
    public function addlowerbanner(Request $request)
        {
            // return redirect()->back()->withErrors('this function is disabled for demo.');
                $banner_id=$request->banner_id;
              
         $service_name=$request->service_name;
         $service_des=$request->service_des;
        //  $service_price=$request->service_price;
        //  $sub_category_list=$request->sub_category_list;
        //  $category_list=$request->category_list;

        $this->validate(
            $request,
                [
                    'service_name'=>'required',
                    'service_des'=>'required',
                    'image'=>'required',
                    
                ],
                [
                    
                    'service_name.required'=>'Service name cannot be empty',
                    'service_des.required'=>'Description cannot be empty',
                    'image.required'=>'Image cannot be empty',
                    
                ]
        );
        
        if($request->hasFile('image')){
            $image = $request->image;
            $fileName = date('dmyhisa').'-'.$image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $image->move('images/store/eventbanner/', $fileName);
            $image = 'images/store/eventbanner/'.$fileName;
        }
        else{
            $image = 'N/A';
        }

                    $insert = DB::table('lower_banner')
                    ->insert(['heading'=>$service_name,'description'=>$service_des,'image'=>$image]);
     
                        return redirect()->back()->withErrors('Added Successfully');

    }
    
    public function editservice(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
            $service_id=$request->service_id;
            
            $partner =DB::table('partner')
    	                       ->get();

            $services = DB::table('services')
                        ->where('service_id',$service_id)
                        ->first();
            $sub_child_category = DB::table('sub_child_category')
                                ->leftjoin('sub_category','sub_child_category.sub_category_id','=','sub_category.sub_category_id')
                                 ->leftjoin('category','sub_category.category_id','=','category.category_id')
                                    ->get();
    	 		                
        return view('admin.services.editservice',compact("partner","services","sub_child_category"));
    }
    
    public function updateservice(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
            $this->validate(
            $request,
                [
                    'service_name'=>'required',
                    'service_des'=>'required',
                    'service_price'=>'required',
                    'old_image'=>'required',
                    
                ],
                [
                    
                    'service_name.required'=>'Service name cannot be empty',
                    'service_des.required'=>'Description cannot be empty',
                    'service_price.required'=>'Price cannot be empty',
                    'old_image.required'=>'Image cannot be empty',
                    
                ]
        );
        $service_id=$request->service_id;
        $subcat_name=$request->subcat_name;
        $service_name=$request->service_name;
        $service_price=$request->service_price;
        $service_des=$request->service_des;
        $old_reward_image=$request->old_image;

        $getBanner = DB::table('services')
                        ->where('service_id', $service_id)
                        ->first();

        $image = $getBanner->service_img; 

        if($request->hasFile('reward_image')){
            if(file_exists($image)){
                unlink($image);
            }
            $reward_image = $request->reward_image;
            $fileName = date('dmyhisa').'-'.$reward_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $reward_image->move('images/store/eventbanner/', $fileName);
            $reward_image = 'images/store/eventbanner/'.$fileName;
        }
        else{
            $reward_image = $getBanner->service_img;
        }

        $updateBanner = DB::table('services')
                            ->where('service_id', $service_id)
                            ->update([
                                'child_category_id'=>$subcat_name,
                                'service_img'=>$reward_image,
                                'service_price'=>$service_price,
                                'service_description'=>$service_des,
                                'service_name'=>$service_name
                                
                            ]);
        
        if($updateBanner){
            return redirect()->back()->withErrors('Updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
    
        public function deleteservice(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
        
       $service_id=$request->service_id;

        $getfile=DB::table('services')
                ->where('service_id',$service_id)
                ->first();

    	$delete=DB::table('services')->where('service_id',$request->service_id)->delete();
    	
    	
        if($delete)
        {
    
        return redirect()->back()->withErrors('delete successfully');

        }
        else
        {
           return redirect()->back()->withErrors('unsuccessfull delete'); 
        }

    }
        
    
    


}