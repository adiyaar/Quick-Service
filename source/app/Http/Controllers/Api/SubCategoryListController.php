<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class SubCategoryListController extends Controller
{
    public function sub_category(Request $request)
    {
        $category_id=$request->category_id;
        
    	$scratch = DB::table('sub_category')
    	            ->where('category_id',$category_id)
    				->get();


    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'Sub Category List', 'data'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
    
        public function child_category(Request $request)
    {
        $category_id=$request->sub_category_id;
    	$scratch = DB::table('sub_child_category')
    	->where('sub_category_id',$category_id)
    				->get();

    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'Child Category List', 'data'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
    
    
     public function subchildcategory(Request $request)
    {   
        $category_id=$request->category_id;
        $category = DB::table('sub_category')
                   ->select('category_id', 'sub_category_name','sub_category_img')
                   ->where('sub_category.category_id', $category_id)
        		   ->get();
        if(count($category)>0)	{	   
         foreach($category as $categorys)
            {
            $product = DB::table('sub_child_category')
                   ->where('sub_child_category.category_id',$categorys->category_id)
        		   ->get();
        	 	 
        	 	 
        	 $data[]=array('category_id'=>$categorys->category_id , 'sub_category_name'=>$categorys->sub_category_name ,'sub_category'=>$categorys->sub_category_img, 'data' =>$product); 	   
            }
           
          
        
        if(count($data)>0){
           
        	
        	$message2 = array('status'=>'1', 'message'=>'data found', 'data'=>$data);
        	return $message2;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
        	return $message;
        }
        }
        else{
            $message = array('status'=>'2', 'message'=>'No Sub Categories Found', 'data'=>[]);
        	return $message;
            
        }
    }
    
}