<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class AppController extends Controller
{
    public function adminApp(Request $request)
    {
        $title = "Apps";
        
    	$adminApp = DB::table('tbl_app')
    				->get();

    	return view('admin.app.index', compact("adminApp", "title"));
    }

    public function adminAddApp(Request $request)
    {
        $title = "Add Apps";
        
    	return view('admin.app.add', compact("title"));
    }

    public function adminAddNewApp(Request $request)
    {
        return redirect()->back();
        
    	$this->validate(
	    	$request,
	    		[
	    			'app_name' => 'required',
                    'app_link' => 'required',
	    			'app_logo' => 'required|mimes:jpeg,png,jpg|max:400',
	    		],
	    		[
	    			'app_name.required' => 'Enter app name.',
                    'app_link.required' => 'Enter app link.',
	    			'app_logo.required' => 'Choose app logo.',
	    		]
	    );

        $app = $request->except('_token', 'app_logo');
        $created_at = Carbon::now();
        $updated_at = Carbon::now();

        if($request->hasFile('app_logo')){
            $app_logo = $request->app_logo;
            $fileName = date('dmyhisa').'-'.$app_logo->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $app_logo->move('images/app/', $fileName);
            $app_logo = 'images/app/'.$fileName;
        }
        else{
            $app_logo = 'N/A';
        }

        $insertApp = DB::table('tbl_app')
                        ->insert($app + [
                            'app_logo'=>$app_logo,
                            'created_at'=>$created_at,
                            'updated_at'=>$updated_at,
                        ]);

        if($insertApp){
            return redirect()->back()->withErrors('App added successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function adminEditApp(Request $request)
    {
        $title = "Edit App";
        
        $id = $request->id;

        $getApp = DB::table('tbl_app')
                    ->where('id', $id)
                    ->first();

        return view('admin.app.edit', compact('getApp', "title"));
    }

    public function adminUpdateApp(Request $request)
    {
        return redirect()->back();
        
        $this->validate(
            $request,
                [
                    'app_name' => 'required',
                    'app_link' => 'required',
                    'app_logo' => 'mimes:jpeg,png,jpg|max:400',
                ],
                [
                    'app_name.required' => 'Enter app name.',
                    'app_link.required' => 'Enter app link.',
                    'app_logo.required' => 'Choose app logo.',
                ]
        );

        $id = $request->id;
        $app = $request->except('_token', 'app_logo');
        $updated_at = Carbon::now();

        $getLogo = DB::table('tbl_app')
                        ->where('id', $id)
                        ->first();

        $logo = $getLogo->app_logo;

        if($request->hasFile('app_logo')){
            if(file_exists($logo)){
                unlink($logo);
            }
            $app_logo = $request->app_logo;
            $fileName = date('dmyhisa').'-'.$app_logo->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $app_logo->move('images/app/', $fileName);
            $app_logo = 'images/app/'.$fileName;
        }
        else{
            $app_logo = $getLogo->app_logo;
        }

        $updateApp = DB::table('tbl_app')
                        ->where('id', $id)
                        ->update($app + [
                            'app_logo'=>$app_logo,
                            'updated_at'=>$updated_at,
                        ]);

        if($updateApp){
            return redirect()->back()->withErrors('App updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
    
    public function adminDeleteApp(Request $request)
    {
        return redirect()->back();
        
        $id = $request->id;
        
        // check for top apps
        $checkTopApp = DB::table('tbl_top_app')
                        ->where('app_id', $id)
                        ->get();
        if(count($checkTopApp)>0){
            return redirect()->back()->withErrors("first delete app from top app section");
        }
        
        // check for nav bar apps
        $checkNavBarApp = DB::table('tbl_navbar_app')
                            ->where('navbar_app', 'Like', '"'.$id.'"')
                            ->get();
        if(count($checkNavBarApp)>0){
            return redirect()->back()->withErrors("first delete app from nav bar app section");
        }
        
        // check for category apps
        $checkCategoryApp = DB::table('tbl_category')
                            ->where('category_app', 'Like', '"'.$id.'"')
                            ->get();
        if(count($checkCategoryApp)>0){
            return redirect()->back()->withErrors("first delete app from category app section");
        }
        
        // check for group apps
        $checkGroupApp = DB::table('tbl_group')
                        ->where('group_app', 'Like', '"'.$id.'"')
                        ->get();
        if(count($checkGroupApp)>0){
            return redirect()->back()->withErrors("first delete app from group app section");
        }
    
        $getLogo = DB::table('tbl_app')
                        ->where('id', $id)
                        ->first();

        $logo = $getLogo->app_logo;
        
        $adminDeleteApp = DB::table('tbl_app')
                            ->where('id', $id)
                            ->delete();
        
        if($adminDeleteApp){
            if(file_exists($logo)){
                unlink($logo);
            }
            return redirect()->back()->withErrors('app Deleted successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
}
