<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class BannerController  extends Controller
{
    public function adminBanner(Request $request)
    {
        $title = "Banner";
        
        $adminBanner = DB::table('tbl_banner')
                 ->get();

    	return view('admin.banner.index',compact("adminBanner", "title"));
    }

    public function adminAddBanner(Request $request)
    {
        // return redirect()->back()->withErrors('this function is disabled for demo.');
        $title = "Add Banner";
        
    	return view('admin.banner.add', compact("title"));
    }

    public function adminAddNewBanner(Request $request)
    {
        // return redirect()->back()->withErrors('this function is disabled for demo.');
        
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

    	$insertBanner = DB::table('tbl_banner')
    	                   ->insert([
                                'banner_name'=>$banner_name,
                                'banner_image'=>$banner_image,
                                'created_at'=>$created_at,
                                'updated_at'=>$updated_at,
                            ]);
        
        if($insertBanner){
            return redirect()->back()->withErrors('banner added successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function adminEditBanner(Request $request)
    {
        // return redirect()->back()->withErrors('this function is disabled for demo.');
        $title = "Edit Banner";
        
        $id = $request->id;

        $adminEditBanner = DB::table('tbl_banner')
                            ->where('id', $id)
                            ->first();

        return view('admin.banner.edit', compact('adminEditBanner', "title"));
    }

    public function adminUpdateBanner(Request $request)
    {
    // return redirect()->back()->withErrors('this function is disabled for demo.');
        
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

        $id = $request->id;
        $banner_name = $request->banner_name;
        $updated_at = Carbon::now();

        $getBanner = DB::table('tbl_banner')
                        ->where('id', $id)
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

        $updateBanner = DB::table('tbl_banner')
                            ->where('id', $id)
                            ->update([
                                'banner_name'=>$banner_name,
                                'banner_image'=>$banner_image,
                                'updated_at'=>$updated_at,
                            ]);
        
        if($updateBanner){
            return redirect()->back()->withErrors('banner updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function adminDeleteBanner(Request $request)
    {
        // return redirect()->back()->withErrors('this function is disabled for demo.');

        
        $id = $request->id;

        $getBanner = DB::table('tbl_banner')
                        ->where('id', $id)
                        ->first();

        $image = $getBanner->banner_image;

        $adminDeleteBanner = DB::table('tbl_banner')
                                ->where('id', $id)
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
