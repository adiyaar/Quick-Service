<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class BlogController extends Controller
{
    public function blog(Request $request)
    {
        $service_id=$request->service_id;
    	$scratch = DB::table('service_blog')
    	                ->join('services','service_blog.service_id','services.service_id')
    	                ->select('service_blog.blog_heading','service_blog.points','services.service_name','services.service_img')
    	                ->where('service_blog.service_id',$service_id)
            			->get();

    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'Blogs', 'data'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
}