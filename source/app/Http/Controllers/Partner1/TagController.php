<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class TagController extends Controller
{
    public function indexTag (Request $request)
    {
        $admin_email=Session::get('admin');
        $tag= DB::table('tbl_tags')
             ->join('tbl_store_category','tbl_store_category.id','=', 'tbl_tags.tag_category_id')
               ->get();
               
        return view('admin.tags.indexTag',compact("admin_email","tag"));
    }
    
     public function Addtag(Request $request)
    {
        $admin_email=Session::get('admin');
        $tbl_store_category= DB::table('tbl_store_category')
                ->get();
         return view('admin.tags.addtag',compact("admin_email","tbl_store_category"));
    }
    
    
        public function AddNewtag(Request $request)
    {
        
        $category_name=$request->category_name;
       $tag_name=$request->tag_name;
       $tag_date = Carbon::now();
        
         $tbl_store_category = DB::table('tbl_store_category')
              ->select('name')
              ->where('id',$category_name)
                ->first();

        $coupon_name=$request->tag_name;
      
        $insert = DB::table('tbl_tags')
                  ->insert(['tag_category_id'=>$category_name,'tag_name'=>$tag_name,'tag_date'=>$tag_date]);
     
     return redirect()->back()->withErrors('successfully');

    }
    public function Edittag(Request $request)
    {
    	
       $tag_id=$request->id;
    	 $admin_email=Session::get('admin');
    	 $tbl_store_category=DB::table('tbl_store_category')
    	        ->get();
    	 $tbl_tags= DB::table('tbl_tags')
    	 		  ->where('tag_id',$tag_id)
    	 		  ->first();
    	 return view('admin.tags.editTag',compact("admin_email","tbl_tags","tag_id","tbl_store_category"));


    }
    public function Updatetag(Request $request)
{
        $category_name=$request->category_name;
        $tag_name=$request->tag_name;
        $tag_id=$request->id;
       


        $update = DB::table('tbl_tags')
                 ->where('tag_id', $tag_id)
                 ->update(['tag_category_id'=>$category_name,'tag_name'=>$tag_name]);

        if($update){

             

            return redirect()->back()->withErrors(' updated successfully');
        }
        else{
            return redirect()->back()->withErrors("something wents wrong.");
        }
    }
    public function deletetag(Request $request)
    {
        
       $tag_id=$request->id;

        $getfile=DB::table('tbl_tags')
                ->where('tag_id',$tag_id)
                ->first();

    	$delete=DB::table('tbl_tags')->where('tag_id',$request->id)->delete();
    	
    	
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
