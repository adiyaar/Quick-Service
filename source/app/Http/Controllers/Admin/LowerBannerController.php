<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class LowerBannerController  extends Controller
{
    public function lowerbannerindex(Request $request)
    {
        $title = "Banner";
        
        $adminBanner = DB::table('lower_banner')
                 ->get();

    	return view('admin.banner.lowerbanner.lowerbannerindex',compact("adminBanner", "title"));
    }

    public function lowerbanner(Request $request)
    {
   
        $title = "Add Banner";
        
        $child_category = DB::table('sub_child_category')
                        ->get();
        
    	return view('admin.banner.lowerbanner.addlowerbanner', compact("title","child_category"));
    }

    public function addlownerbanner(Request $request)
    {
      
        $this->validate(
            $request,
                [
                    'banner_name' => 'required',
                    'banner_image' => 'required|mimes:jpeg,png,jpg|max:400',
                ],
                [
                    'banner_name.required' => 'Enter banner name.',
                    'banner_image.required' => 'Choose banner image.',
                ]
        );

    	$banner_name = $request->banner_name;
    	
        $created_at = Carbon::now();
    	$updated_at = Carbon::now();

        if($request->hasFile('banner_image')){
            $banner_image = $request->banner_image;
            $fileName = date('dmyhisa').'-'.$banner_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $banner_image->move('images/banner/', $fileName);
            $banner_image = 'images/banner/'.$fileName;
        }
        else{
            $banner_image = 'N/A';
        }

    	$insertBanner = DB::table('lower_banner')
    	                   ->insert([
                                'heading'=>$banner_name,
                                'banner_image'=>$banner_image,
                            
                            ]);
        
        if($insertBanner){
            return redirect()->back()->withErrors('banner added successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function editlowerbanner(Request $request)
    {
   
        $title = "Edit Banner";
        
        $id = $request->banner_id;

        $adminEditBanner = DB::table('lower_banner')
                            ->where('banner_id', $id)
                            ->first();
        $child_category = DB::table('sub_child_category')
                        ->get();                             

        return view('admin.banner.lowerbanner.editlowerbanner', compact('adminEditBanner', "title","child_category"));
    }

    public function updatelowerbaneer(Request $request)
    {

        
        $this->validate(
            $request,
                [
                    'banner_name' => 'required',
                    'banner_image' => 'mimes:jpeg,png,jpg|max:400',
                ],
                [
                    'banner_name.required' => 'Enter banner name.',
                    'banner_image.required' => 'Choose banner image.',
                ]
        );

        $id = $request->banner_id;
        $banner_name = $request->banner_name;
        
        $updated_at = Carbon::now();

        $getBanner = DB::table('lower_banner')
                        ->where('banner_id', $id)
                        ->first();

        $image = $getBanner->banner_image; 

        if($request->hasFile('banner_image')){
            if(file_exists($image)){
                unlink($image);
            }
            $banner_image = $request->banner_image;
            $fileName = date('dmyhisa').'-'.$banner_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $banner_image->move('images/banner/', $fileName);
            $banner_image = 'images/banner/'.$fileName;
        }
        else{
            $banner_image = $getBanner->banner_image;
        }

        $updateBanner = DB::table('lower_banner')
                            ->where('banner_id', $id)
                            ->update([
                                'heading'=>$banner_name,
                                'banner_image'=>$banner_image,
                                
                            ]);
        
        if($updateBanner){
            return redirect()->back()->withErrors('banner updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function deletelowerbanner(Request $request)
    {
       

        
        $id = $request->banner_id;

        $getBanner = DB::table('lower_banner')
                        ->where('banner_id', $id)
                        ->first();

        $image = $getBanner->banner_image;

        $adminDeleteBanner = DB::table('lower_banner')
                                ->where('banner_id', $id)
                                ->delete();

        if($adminDeleteBanner){
            if(file_exists($image)){
                unlink($image);
            }
            return redirect()->back()->withErrors('banner deleted successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
}
