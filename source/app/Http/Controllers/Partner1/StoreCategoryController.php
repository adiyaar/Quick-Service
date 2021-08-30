<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;

class StoreCategoryController extends Controller
{
    
   public function Category(Request $request)
    {
        $admin_email=Session::get('admin');
         $tbl_store_category= DB::table('tbl_store_category')
                ->get();
        return view('admin.store.category.indexcategory',compact("admin_email","tbl_store_category"));
      
    }
      public function Addcategory(Request $request)
    {
        $admin_email=Session::get('admin');
        $tbl_store_category= DB::table('tbl_store_category')
                ->get();
        return view('admin.store.category.addcategory',compact("admin_email","tbl_store_category"));
    }
          public function AddNewcategory(Request $request)
    {
            $this->validate(
            $request,
                [
                    'category_name' => 'required',
                    'category_image' => 'required',
                ],
                [
                    'category_name.required' => 'Enter Category name.',
                    'category_image.required' => 'Enter Category Image.',
                ]
        );
    
        $category_name=$request->category_name;
        $category_image=$request->category_image;
         $date =date('d-m-Y');
        
        if($request->hasFile('category_image')){
            $category_image = $request->category_image;
            $fileName = date('dmyhisa').'-'.$category_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $category_image->move('storeimg/category/'.$date.'/',$fileName);
            $category_image = 'storeimg/category/'.$date.'/'.$fileName;
        }
        else{
            $category_image = 'N/A';
        }

        $insert = DB::table('tbl_store_category')
                  ->insert(['name'=>$category_name,'cat_image'=>$category_image]);
     
     return redirect()->back()->withErrors('successfully');

    }
     public function Editcategory(Request $request)
    {
    	
       $id=$request->id;
    	 $admin_email=Session::get('admin');
    	 $tbl_store_category=DB::table('tbl_store_category')
    	       ->where('id', $id)
    	        ->first();
    	 return view('admin.store.category.editcategory',compact("admin_email","tbl_store_category","id"));
    }
  public function Updatecategory(Request $request)
{
       $id=$request->id;
         $category_name=$request->category_name;
        
        $date = date('d-m-y');
                $this->validate(
            $request,
                [
                    'category_name' => 'required',
                  
                ],
                [
                    'category_name.required' => 'Enter Category name.',
                    
                ]
        );
        $old_category_image = $request->old_category_image;
       

        if($request->hasFile('category_image')){
            $category_image = $request->category_image;
            $fileName = date('dmyhisa').'-'.$category_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $category_image->move('storeimg/category/'.$date.'/', $fileName);
            $category_image = 'storeimg/category/'.$date.'/'.$fileName;
        }
        else{
            $category_image = $old_category_image;
        }
     $update = DB::table('tbl_store_category')
                 ->where('id',$id)
                 ->update(['name'=>$category_name,'cat_image'=>$category_image]);

        if($update){

             

            return redirect()->back()->withErrors(' updated successfully');
        }
        else{
            return redirect()->back()->withErrors("something wents wrong.");
        }
    }
     public function Deletecategory(Request $request)
    {
       
        
        $id=$request->id;

        $tbl_store_category=DB::table('tbl_store_category')
                ->where('id',$id)
                ->first();

    	$delete=DB::table('tbl_store_category')->where('id',$request->id)->delete();
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
