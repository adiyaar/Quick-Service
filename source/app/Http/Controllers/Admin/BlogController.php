<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function bloglist(Request $request)
        {
          $admin_email=Session::get('admin');
          
          $category = DB::table('services')
                         ->get();
          
          $add_ons = DB::table('service_blog')
                        ->join('services','service_blog.service_id','=','services.service_id')
                        ->get();
       
        return view('admin.blog.bloglist',compact("admin_email","category","add_ons"));
    }
    
    
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
      
             $this->validate(
            $request,
                [
                    
                    'service_list'=>'required',
                    
                ],
                [
                    
                    'service_list.required'=>'Category Name Required',
                ]
        );
          $admin_email=Session::get('admin');
            
                 $blog_id=$request->blog_id;
                 $service_blog= DB::table('service_blog')
                         ->select('blog_heading')
                          ->where('blog_id',$blog_id)
                         ->first();
                         
        $add_more=$request->box;
        $add_more1=json_encode($add_more);
        $service_list=$request->service_list;
        $add_title=$request->add_title;
        

         $insertAO = DB::table('service_blog')
                    ->insertGetId(['blog_heading'=>$add_title,'service_id'=>$service_list,'points'=>$add_more1]);
                    
                    
        foreach($add_more as $more)
        {
          $insert = DB::table('blog_points')
           ->insert(['blog_point'=>$more,'blog_id'=>$insertAO]);
        }
            
     
                        return redirect()->back()->withErrors('Added Successfully');
        
        
        
       
        
    }
    
    public function editblog(Request $request)
        {
     
            $blog_id=$request->blog_id;
            
            $services=DB::table('services')
    	                       ->get();
    	    $add_ons_des=DB::table('blog_points')
    	                ->where('blog_id',$blog_id)
    	                       ->get();
    	        
    	    $add= DB::table('service_blog')
    	                    ->leftjoin('blog_points','service_blog.blog_id','=','blog_points.blog_id')
    	 		             ->where('service_blog.blog_id',$blog_id)
    	 		             ->first();
    	 		                
        return view('admin.blog.editblog',compact("services","add","add_ons_des"));
    }
   
       
     public function updateblog(Request $request)
        {
       
          $admin_email=Session::get('admin');
            
                 $blog_point_id=$request->blog_point_id;
                 $blog_id=$request->blog_id;
                 $add_ons= DB::table('blog_points')
                         ->select('blog_id')
                          ->where('blog_point_id',$blog_point_id)
                         ->first();
                         
        $add_more=$request->box;
        $service_list=$request->service_list;
        $add_title=$request->add_title;
        

         $insertAO = DB::table('service_blog')
         ->where('blog_id',$blog_id)
         ->update(['blog_heading'=>$add_title,'service_id'=>$service_list]);
                    
                    
        foreach($add_more as $more)
        {
                    
          $insert = DB::table('blog_points')
           ->insert(['blog_point'=>$more,'blog_id'=>$blog_id]);
        }
     
                        return redirect()->back()->withErrors('Added Successfully');
        
    } 
    
    public function deleteblogpoint(Request $request)
        {
       
        
       $blog_point_id=$request->blog_point_id;

        $getfile=DB::table('blog_points')
                ->where('blog_point_id',$blog_point_id)
                ->first();

    	$delete=DB::table('blog_points')->where('blog_point_id',$request->blog_point_id)->delete();

        if($delete)
        {
    
        return redirect()->back()->withErrors('delete successfully');

        }
        else
        {
           return redirect()->back()->withErrors('unsuccessfull delete'); 
        }

    }
    public function deleteblog(Request $request)
        {
           
      
       $blog_id=$request->blog_id;

    	$delete=DB::table('service_blog')->where('blog_id',$blog_id)->delete();

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