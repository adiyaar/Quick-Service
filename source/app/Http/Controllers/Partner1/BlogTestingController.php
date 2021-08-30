<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class BlogController extends Controller
{

    
    public function addblog(Request $request)
        {
          $admin_email=Session::get('admin');
          
          $services = DB::table('services')
                         ->get();
          
          $service_blog = DB::table('service_blog')
                        ->get();
       
        return view('admin.blog.addblog',compact("admin_email","services","service_blog"));
    }
    
    public function addnewblog(Request $request)
        {
          $admin_email=Session::get('admin');
            
                 $blog_id=$request->blog_id;
                 $service_blog= DB::table('service_blog')
                         ->select('blog_heading')
                          ->where('blog_id',$blog_id)
                         ->first();
                         
        $add_more=$request->box;
        $service_list=$request->service_list;
        $add_title=$request->add_title;
        

         $insertAO = DB::table('service_blog')
                    ->insertGetId(['blog_heading'=>$add_title,'service_id'=>$service_list]);
                    
                    
        foreach($add_more as $more)
        {
          $insert = DB::table('blog_points')
           ->insert(['blog_point'=>$more,'blog_id'=>$insertAO]);
        }
            
     
                        return redirect()->back()->withErrors('Added Successfully');
        
        
        
       
        
    }


}