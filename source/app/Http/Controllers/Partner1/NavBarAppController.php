<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class NavBarAppController extends Controller
{
    public function adminNavBarApp(Request $request)
    {
        $title = "Navbar App";
        
    	$adminNavBarApp = DB::table('tbl_navbar_app')
    			         ->get();

    	return view('admin.navbar.index', compact('adminNavBarApp', "title"));
    }

    public function adminAddNavBarApp(Request $request)
    {
        $title = "Add Navbar App";
        
    	$app = DB::table('tbl_app')
                ->get();

        return view('admin.navbar.add', compact('app', "title"));
    }

    public function adminAddNewNavBarApp(Request $request)
    {
        return redirect()->back();
        
    	$this->validate(
            $request,
                [
                    'navbar_app_name' => 'required',
                    'navbar_app_icon' => 'required|mimes:jpeg,png,jpg|max:400',
                    'navbar_app' => 'required',
                ],
                [
                    'navbar_app_name.required' => 'Enter navbar app name.',
                    'navbar_app_icon.required' => 'Choose navbar app icon.',
                    'navbar_app.required' => 'select navbar app.',
                ]
        );

        $navbar_app_name = $request->navbar_app_name;
        $navbar_app = json_encode($request->navbar_app);
        $created_at = Carbon::now();
        $updated_at = Carbon::now();

        $date=date('d-m-Y');

        if($request->hasFile('navbar_app_icon')){
            $navbar_app_icon = $request->navbar_app_icon;
            $fileName = date('dmyhisa').'-'.$navbar_app_icon->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $navbar_app_icon->move('images/navbar/'.$date.'/', $fileName);
            $navbar_app_icon = 'images/navbar/'.$date.'/'.$fileName;
        }
        else{
            $navbar_app_icon = 'N/A';
        }

        $insertNavbar = DB::table('tbl_navbar_app')
                            ->insert([
                                'navbar_app_name'=>$navbar_app_name,
                                'navbar_app_icon'=>$navbar_app_icon,
                                'navbar_app'=>$navbar_app,
                                'created_at'=>$created_at,
                                'updated_at'=>$updated_at
                            ]);
        
        if($insertNavbar){
            return redirect()->back()->withErrors('navbar app added successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function adminEditNavBarApp(Request $request)
    {
        $title = "Edit Navbar App";
        
    	$id = $request->id;

    	$navbar = DB::table('tbl_navbar_app')
        	          ->where('id', $id)
        			  ->first();

        $app = DB::table('tbl_app')
                ->get();

        return view('admin.navbar.edit',compact("navbar", "app", "title"));
    }

    public function adminUpdateNavBarApp(Request $request)
    {
        return redirect()->back();
        
    	$this->validate(
            $request,
                [
                    'navbar_app_name' => 'required',
                    'navbar_app_icon' => 'mimes:jpeg,png,jpg|max:400',
                    'navbar_app' => 'required',
                ],
                [
                    'navbar_app_name.required' => 'Enter navbar app name.',
                    'navbar_app_icon.required' => 'Choose navbar app icon.',
                    'navbar_app.required' => 'select navbar app.',
                ]
        );

    	$id = $request->id;
        $navbar_app_name = $request->navbar_app_name;
        $navbar_app = json_encode($request->navbar_app);
        $updated_at = Carbon::now();

        $getApp = DB::table('tbl_navbar_app')
        				->where('id', $id)
        				->first();

        $image = $getApp->navbar_app_icon;

        $date=date('d-m-Y');

        if($request->hasFile('navbar_app_icon')){
        	if(file_exists($image)){
        		unlink($image);
        	}
            $navbar_app_icon = $request->navbar_app_icon;
            $fileName = date('dmyhisa').'-'.$navbar_app_icon->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $navbar_app_icon->move('images/navbar/'.$date.'/', $fileName);
            $navbar_app_icon = 'images/navbar/'.$date.'/'.$fileName;
        }
        else{
            $navbar_app_icon = $getApp->navbar_app_icon;
        }

        $updateNavbar = DB::table('tbl_navbar_app')
        					->where('id', $id)
                            ->update([
                                'navbar_app_name'=>$navbar_app_name,
                                'navbar_app_icon'=>$navbar_app_icon,
                                'navbar_app'=>$navbar_app,
                                'updated_at'=>$updated_at
                            ]);
        
        if($updateNavbar){
            return redirect()->back()->withErrors('navbar app updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function adminNavBarAppDelete(Request $request)
    {
        return redirect()->back();
        
        $id = $request->id;

        $getNavBarApp = DB::table('tbl_navbar_app')
                        ->where('id', $id)
                        ->first();

        $image = $getNavBarApp->navbar_app_icon;

        $deleteNavBarApp = DB::table('tbl_navbar_app')
                                ->where('id', $id)
                                ->delete();

        if($deleteNavBarApp){
            if(file_exists($image)){
                unlink($image);
            }
            return redirect()->back()->withErrors('Navbar app deleted successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
}
