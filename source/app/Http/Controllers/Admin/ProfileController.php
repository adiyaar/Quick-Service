<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Hash;
use Session;

class ProfileController extends Controller
{
    public function adminProfile(Request $request)
    {
        $title = "Profile";
        
        $admin_email = Session::get('bamaAdmin');
        
        $getAdmin = DB::table('tbl_admin')
                    ->where('email', $admin_email)
                    ->first();
        
        $app = DB::table('tbl_app')
                ->get();
        
    	return view('admin.profile.index', compact('getAdmin', 'app', "title"));
    }

    public function adminChangeProfile(Request $request)
    {
     
    
        
        
        
    	$this->validate(
	    	$request,
	    		[
	    			'username' => 'required',
	    			'email' => 'required',
	    			'image' => 'mimes:jpeg,png,jpg|max:400',
	    		],
	    		[
	    			'username.required' => 'Enter current password.',
	    			'email.required' => 'Enter new password.',
	    			'image.required' => 'choose profile picture.',
	    		]
	    );

        $id = $request->id;
	    $username = $request->username;
	    $email = $request->email;
	    $updated_at = Carbon::now();

	    $date = date('d-m-Y');

	    $getImage = DB::table('tbl_admin')
	                    ->where('id', $id)
	                    ->first();

        $oldimage = $getImage->image;  

	    if($request->hasFile('image')){
        	 if(file_exists($oldimage)){
                unlink($oldimage);
            }
            $image = $request->image;
            $fileName = date('dmyhisa').'-'.$image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $image->move('images/admin/profile/'.$date.'/', $fileName);
            $image = 'images/admin/profile/'.$date.'/'.$fileName;
        }
        else{
            $image = $getImage->image;
        }

	    $adminChangeProfile = DB::table('tbl_admin')
	    						->where('id', $id)
	    						->update(['username'=>$username, 'email'=>$email, 'image'=>$image, 'updated_at'=>$updated_at]);

	    if($adminChangeProfile){
	    	$getAdmin = DB::table('tbl_admin')
	                    ->where('id', $id)
	                    ->first();

	        Session::put('bamaAdmin', $getAdmin->email);

        	return redirect()->back()->withErrors('profile updated successfully');
	    }
	    else{
	    	return redirect()->back()->withErrors("something wents wrong.");
	    }
    }
    
    public function adminPassword(Request $request)
    {
   
        $title = "Password";
    	$admin_email = Session::get('bamaAdmin');

    	$getAdmin = DB::table('tbl_admin')
                    ->where('email', $admin_email)
                    ->first();
                    
        $app = DB::table('tbl_app')
                ->get();

    	return view('admin.profile.password', compact('getAdmin', 'app', "title"));
    }

    public function adminChangePassword(Request $request)
    {
      
        
        
    	$this->validate(
	    	$request,
	    		[
	    			'current_password' => 'required',
	    			'new_password' => 'required',
	    		],
	    		[
	    			'current_password.required' => 'Enter current password.',
	    			'new_password.required' => 'Enter new password.',
	    		]
	    );

    	$id = $request->id;
	    $current_password = $request->current_password;

	    $getAdmin = DB::table('tbl_admin')
	    			->where('id', $id)
	    			->first();

	    if(Hash::check($current_password, $getAdmin->password)){
	    	$new_password = Hash::make($request->new_password);
	    	$updated_at = Carbon::now();

	    	$adminChangePassword = DB::table('tbl_admin')
		    						->where('id', $id)
		    						->update(['password'=>$new_password, 'updated_at'=>$updated_at]);

		   	if($adminChangePassword){
		   		Session::forget('bamaAdmin');

		   		return redirect()->route('adminLogin')->withErrors("password changed! login again.");
		   	}
		   	else{
		   		return redirect()->back()->withErrors("something wents wrong.");
		   	}
	    }
	    else{
	    	return redirect()->back()->withErrors("current password does not match.");
	    }
    }

    public function adminlogout(Request $request)
    {
    	Session::forget('bamaAdmin');

		return redirect()->route('adminLogin')->withErrors("logged out.");
    }
}
