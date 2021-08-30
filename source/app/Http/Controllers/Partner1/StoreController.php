<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class StoreController extends Controller
{
    public function adminStoreBanner(Request $request)
    {
        $title = "Store Banner";
        
        $adminStoreBanner = DB::table('tbl_store_banner')
                            ->get();

        return view('admin.store.banner.index',compact("adminStoreBanner", "title"));
    }

    public function adminStoreBannerAdd(Request $request)
    {
        $title = "Add Store Banner";
        
        return view('admin.store.banner.add', compact("title"));
    }

    public function adminStoreBannerAddNew(Request $request)
    {
        
        
        $this->validate(
            $request,
                [
                    'banner_name' => 'required',
                    'banner_link' => 'required',
                    'banner_image' => 'required|mimes:jpeg,png,jpg',
                ],
                [
                    'banner_name.required' => 'Enter banner name.',
                    'banner_link.required' => 'Enter banner link.',
                    'banner_image.required' => 'Choose banner image.',
                ]
        );

        $banner_name = $request->banner_name;
        $banner_link = $request->banner_link;
        $created_at = Carbon::now();
        $updated_at = Carbon::now();

        if($request->hasFile('banner_image')){
            $banner_image = $request->banner_image;
            $fileName = date('dmyhisa').'-'.$banner_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $banner_image->move('images/store/banner/', $fileName);
            $banner_image = 'images/store/banner/'.$fileName;
        }
        else{
            $banner_image = 'N/A';
        }

        $insertBanner = DB::table('tbl_store_banner')
                           ->insert([
                                'banner_name'=>$banner_name,
                                'banner_image'=>$banner_image,
                                'banner_link'=>$banner_link,
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

    public function adminStoreBannerEdit(Request $request)
    {
        $title = "Edit Banner";
        
        $id = $request->id;

        $adminStoreBannerEdit = DB::table('tbl_store_banner')
                            ->where('id', $id)
                            ->first();

        return view('admin.store.banner.edit', compact('adminStoreBannerEdit', "title"));
    }

    public function adminStoreBannerUpdate(Request $request)
    {
       
        
        $this->validate(
            $request,
                [
                    'banner_name' => 'required',
                    'banner_link' => 'required',
                    'banner_image' => 'mimes:jpeg,png,jpg',
                ],
                [
                    'banner_name.required' => 'Enter banner name.',
                    'banner_link.required' => 'Enter banner link.',
                    'banner_image.required' => 'Choose banner image.',
                ]
        );

        $id = $request->id;
        $banner_name = $request->banner_name;
        $banner_link = $request->banner_link;
        $updated_at = Carbon::now();

        $getBanner = DB::table('tbl_store_banner')
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

        $updateBanner = DB::table('tbl_store_banner')
                            ->where('id', $id)
                            ->update([
                                'banner_name'=>$banner_name,
                                'banner_image'=>$banner_image,
                                'banner_link'=>$banner_link,
                                'updated_at'=>$updated_at,
                            ]);
        
        if($updateBanner){
            return redirect()->back()->withErrors('banner updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function adminStoreBannerDelete(Request $request)
    {
        
        
        $id = $request->id;

        $getBanner = DB::table('tbl_store_banner')
                        ->where('id', $id)
                        ->first();

        $image = $getBanner->banner_image;

        $adminStoreBannerDelete = DB::table('tbl_store_banner')
                                ->where('id', $id)
                                ->delete();

        if($adminStoreBannerDelete){
            if(file_exists($image)){
                unlink($image);
            }
            return redirect()->back()->withErrors('banner deleted successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function adminStore(Request $request)
    {
        $title = "Store";
        
        $adminStore = DB::table('tbl_store')
                            ->get();

        return view('admin.store.index',compact("adminStore", "title"));
    }

    public function adminStoreAdd(Request $request)
    {
        $title = "Add Store";
        
        return view('admin.store.add', compact("title"));
    }

    public function adminStoreAddNew(Request $request)
    {
        
        
        $this->validate(
            $request,
                [
                    'store_name' => 'required',
                    'store_phone' => 'required',
                    'store_address' => 'required',
                    'store_images' => 'required',
                ],
                [
                    'store_name.required' => 'Enter Store name.',
                    'store_phone.required' => 'Enter Store phone.',
                    'store_address.required' => 'Enter Store address.',
                    'store_images.required' => 'Choose Store image.',
                ]
        );

        $store_society_id = 'all';

        $store_name = $request->store_name;
        $store_phone = $request->store_phone;
        $store_address = $request->store_address;
        $created_at = Carbon::now();
        $updated_at = Carbon::now();

        $storeName = str_replace(" ", "-", $store_name);
        $date = date('d-m-Y');

        if($request->hasFile('store_images')){
            $store_images = $request->store_images;
            $store_all_images = array();
            // return var_dump($store_images);
            foreach ($store_images as $store_image) {
                $fileName = date('dmyhisa').'-'.$store_image->getClientOriginalName();
                $fileName = str_replace(" ", "-", $fileName);
                $store_image->move('images/store/'.$storeName.'/', $fileName);
                $store_all_images[] = 'images/store/'.$storeName.'/'.$fileName;
            }

            $store_all_images = json_encode($store_all_images);
        }
        else{
            $store_all_images = 'N/A';
        }
        
        $address = str_replace(" ", "+", $store_address);
        $address = str_replace("-", "+", $address);

        // $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&key=AIzaSyBJmIVMpiUZjBJDm215kvtREs41aUMcGdo"));

        // $location = json_encode(array("lat"=>$response->results[0]->geometry->location->lat, "lng"=>$response->results[0]->geometry->location->lng));
        
        $location = json_encode(array("lat"=>'28.636457', "lng"=>'73.5657829'));

        $insertBanner = DB::table('tbl_store')
                           ->insert([
                                'store_name'=>$store_name,
                                'store_phone'=>$store_phone,
                                'store_address'=>$store_address,
                                'store_images'=>$store_all_images,
                                'store_society_id'=>$store_society_id,
                                'location'=>$location,
                                'created_at'=>$created_at,
                                'updated_at'=>$updated_at,
                            ]);
        
        if($insertBanner){
            return redirect()->back()->withErrors('Store added successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function adminStoreEdit(Request $request)
    {
        $title = "Edit Store";
        $id = $request->id;

        $adminStoreEdit = DB::table('tbl_store')
                            ->where('id', $id)
                            ->first();
        
        return view('admin.store.edit', compact("title", "adminStoreEdit"));
    }

    public function adminStoreUpdate(Request $request)
    {
        
        
        $this->validate(
            $request,
                [
                    'store_name' => 'required',
                    'store_phone' => 'required',
                    'store_address' => 'required',
                ],
                [
                    'store_name.required' => 'Enter Store name.',
                    'store_phone.required' => 'Enter Store phone.',
                    'store_address.required' => 'Enter Store address.',
                ]
        );

        $store_society_id = 'all';

        $id = $request->id;
        $store_name = $request->store_name;
        $store_phone = $request->store_phone;
        $store_address = $request->store_address;
        $updated_at = Carbon::now();

        $getStore = DB::table('tbl_store')
                        ->where('id', $id)
                        ->first();

        $storeName = str_replace(" ", "-", $store_name);
        $date = date('d-m-Y');

        if($request->hasFile('store_images')){
            $store_images = $request->store_images;
            $store_all_images = array();
            // return var_dump($store_images);
            foreach ($store_images as $store_image) {
                $fileName = date('dmyhisa').'-'.$store_image->getClientOriginalName();
                $fileName = str_replace(" ", "-", $fileName);
                $store_image->move('images/store/'.$storeName.'/', $fileName);
                $store_all_images[] = 'images/store/'.$storeName.'/'.$fileName;
            }

            $store_all_images = json_encode($store_all_images);
        }
        else{
            $store_all_images = $getStore->store_images;
        }
        
        $address = str_replace(" ", "+", $store_address);
        $address = str_replace("-", "+", $address);

        // $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&key=AIzaSyBJmIVMpiUZjBJDm215kvtREs41aUMcGdo"));

        // $location = json_encode(array("lat"=>$response->results[0]->geometry->location->lat, "lng"=>$response->results[0]->geometry->location->lng));
        $location = json_encode(array("lat"=>'28.636457', "lng"=>'73.5657829'));

        $insertBanner = DB::table('tbl_store')
                           ->where('id', $id)
                           ->update([
                                'store_name'=>$store_name,
                                'store_phone'=>$store_phone,
                                'store_address'=>$store_address,
                                'store_images'=>$store_all_images,
                                'store_society_id'=>$store_society_id,
                                'location'=>$location,
                                'updated_at'=>$updated_at,
                            ]);
        
        if($insertBanner){
            return redirect()->back()->withErrors('Store updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
    
    public function adminStoreDelete(Request $request)
    {
        return redirect()->back();
        
        $id = $request->id;

        $getStore = DB::table('tbl_store')
                        ->where('id', $id)
                        ->first();

        $folder = "images/store/".str_replace(" ", "-", $getStore->store_name);

        $files = glob($folder.'/*');

        $adminDeleteBanner = DB::table('tbl_store')
                                ->where('id', $id)
                                ->delete();

        if($adminDeleteBanner){
            foreach($files as $file) { 
                if(is_file($file)){
                    // Delete the given file 
                    unlink($file);  
                }
            }
            // rmdir($folder);
            return redirect()->back()->withErrors('store deleted successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
    
}
