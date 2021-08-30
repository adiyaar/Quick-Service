<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class ChildCategoryController extends Controller
{
    public function child_category(Request $request)
        {
          $admin_email=Session::get('admin');
          
          $sub_category = DB::table('category')
                        ->get();
          $category = DB::table('sub_category')
                        ->get();
          $sub_child_category = DB::table('sub_child_category')
                        ->join('sub_category','sub_child_category.sub_category_id','=','sub_category.sub_category_id')
                        ->join('category','sub_child_category.category_id','=','category.category_id')
                        
                        ->paginate(20);
       
        return view('admin.category.sub_child_category.child_category_index',compact("admin_email","category","sub_category","sub_child_category"));
    }
    
    
    public function add_child_category(Request $request)
        {
       
          $admin_email=Session::get('admin');

          $sub_category = DB::table('sub_category')
                        ->join('category','sub_category.category_id','=','category.category_id')
                        ->get();
                        
          $sub_child_category = DB::table('sub_child_category')
                        ->get();
       
        return view('admin.category.sub_child_category.child_category_add',compact("admin_email","sub_category","sub_child_category"));
    }
    
  
    public function new_child_category(Request $request)
        {
       
                $child_category_id=$request->child_category_id;
                 $category= DB::table('sub_child_category')
                         ->select('child_name')
                          ->where('child_category_id',$child_category_id)
                         ->first();
    
         
       
         $sub_category_list=$request->sub_category_list;
         $cat = DB::table('sub_category')
              ->where('sub_category_id',$sub_category_list)
              ->first();
        $cat_id= $cat->category_id;     
         $child_category_name=$request->child_category_name;

        $this->validate(
            $request,
                [
                    
                    'child_category_name'=>'required',
                    'image'=>'required',
                ],
                [
                    
                    'child_category_name.required'=>'Category Name Required',
                    'image.required'=>'Image Required',
                ]
        );
        
        if($request->hasFile('image')){
            $image = $request->image;
            $fileName = date('dmyhisa').'-'.$image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $image->move('images/store/eventbanner/', $fileName);
            $image = 'images/store/eventbanner/'.$fileName;
        }
        else{
            $image = 'N/A';
        }

                    $insert = DB::table('sub_child_category')
                    ->insert(['sub_category_id'=>$sub_category_list,'category_id'=>$cat_id,'child_name'=>$child_category_name,'child_img'=>$image]);
     
                        return redirect()->back()->withErrors('Added Successfully');

    }
    
    public function editchildcategory(Request $request)
        {
           
            $child_category_id=$request->child_category_id;

    	 		                
    	 	$sub_child_category= DB::table('sub_child_category')
    	 		                ->where('child_category_id',$child_category_id)
    	 		                ->first();
    	 	$sub_category = DB::table('sub_category')
    	 	                ->leftjoin('category','sub_category.category_id','=','category.category_id')
    	 	                ->get();
    	 		                
    	 		                
    return view('admin.category.sub_child_category.sub_child_category_edit',compact("sub_child_category","sub_category"));
    }
    
    public function updatechildcategory(Request $request)
    {
       
        $child_category_id=$request->child_category_id;
        
        $sub_category_id=$request->subcat_name;
        $category_name=$request->category_name;
        $old_reward_image=$request->old_image;

        $getBanner = DB::table('sub_child_category')
                        ->where('child_category_id', $child_category_id)
                        ->first();

        $image = $getBanner->child_img; 

        if($request->hasFile('reward_image')){
            if(file_exists($image)){
                unlink($image);
            }
            $reward_image = $request->reward_image;
            $fileName = date('dmyhisa').'-'.$reward_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $reward_image->move('images/store/eventbanner/', $fileName);
            $reward_image = 'images/store/eventbanner/'.$fileName;
        }
        else{
            $reward_image = $getBanner->child_img;
        }

        $updateBanner = DB::table('sub_child_category')
                            ->where('child_category_id', $child_category_id)
                            ->update([
                                'sub_category_id'=>$sub_category_id,
                                'child_name'=>$category_name,
                                'child_img'=>$reward_image,
                            ]);
        
        if($updateBanner){
            return redirect()->back()->withErrors('Updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
public function deletechildcategory(Request $request)
    {
         
       $child_category_id=$request->child_category_id;

        $getfile=DB::table('sub_child_category')
                ->where('child_category_id',$child_category_id)
                ->first();

    	$delete=DB::table('sub_child_category')->where('child_category_id',$request->child_category_id)->delete();
    	
    	
        if($delete)
        {
    
        return redirect()->back()->withErrors('delete successfully');

        }
        else
        {
           return redirect()->back()->withErrors('unsuccessfull delete'); 
        }

    }
    public function searchcategory(Request $request)
    {
    
        $entered_name = $request->entered_name;
         $category = DB::table('sub_category')
                        ->get();

        $searchclass = DB::table('sub_child_category')
                        ->join('sub_category','sub_child_category.sub_category_id','=','sub_category.sub_category_id')
                        ->where('child_name', 'like', $entered_name.'%')
                        ->orwhere('sub_category_name', 'like', $entered_name.'%')
                        
                        ->get();

        return $searchclass;
    }
    
    


}