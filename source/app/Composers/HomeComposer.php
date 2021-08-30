<?php 

namespace App\Composers;

use DB;
use Session;
use Hash;

class HomeComposer
{

    public function compose($view)
    {
        if(Session::has('bamaAdmin')){
        	$admin_email = Session::get('bamaAdmin');

        	$admin = DB::table('tbl_admin')
        				->where('email', $admin_email)
        				->first();

        	$web = DB::table('tbl_web_setting')
        			->get();

            //Add your variables
        
             $view->with('admin_name', $admin->username)
                  ->with('admin_image', $admin->image)
                  ->with('app_image', $web[0]->value)
                  ->with('app_name', $web[1]->value);
        }
    }
}