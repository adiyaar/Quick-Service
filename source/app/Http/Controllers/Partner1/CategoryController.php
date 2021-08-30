<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function categorylist(Request $request)
        {
          $admin_email=Session::get('admin');
          
          $category = DB::table('category')
                        ->get();
       
        return view('admin.category.indexcategory',compact("admin_email","category"));
    }
    
    public function addcategory(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
          $admin_email=Session::get('admin');
          
          $category = DB::table('category')
                        ->get();
       
        return view('admin.category.addcategory',compact("admin_email","category"));
    }
    
    public function addnewcategory(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
                $category_id=$request->category_id;
                 $category= DB::table('category')
                         ->select('category_name')
                          ->where('category_id',$category_id)
                         ->first();
    
         $category_name=$request->category_name;

        $this->validate(
            $request,
                [
                    
                    'category_name'=>'required',
                    'image'=>'required',
                ],
                [
                    
                    'category_name.required'=>'Category Name Required',
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

                    $insert = DB::table('category')
                    ->insert(['category_name'=>$category_name,'category_image'=>$image]);
     
                        return redirect()->back()->withErrors('Added Successfully');

    }
    
    public function editcategory(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
            $category_id=$request->category_id;
                 $category= DB::table('category')
                          ->where('category_id',$category_id)
                         ->first();
       
        return view('admin.category.editcategory',compact("category"));
    }
    
    public function updatecategory(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
            $this->validate(
            $request,
                [
                    
                    'category_name'=>'required',
                    'old_image'=>'required',
                ],
                [
                    
                    'category_name.required'=>'Category Name Required',
                    'old_image.required'=>'Image Required',
                ]
        );
        $category_id=$request->category_id;
        $category_name=$request->category_name;                                   
        $old_reward_image=$request->old_image;

        $getBanner = DB::table('category')
                        ->where('category_id', $category_id)
                        ->first();

        $image = $getBanner->category_image; 

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
            $reward_image = $getBanner->category_image;
        }

        $updateBanner = DB::table('category')
                            ->where('category_id', $category_id)
                            ->update([
                                'category_name'=>$category_name,
                                'category_image'=>$reward_image,
                                
                            ]);
        
        if($updateBanner){
            return redirect()->back()->withErrors('Category updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
    
    public function deletecategory(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
        
       $category_id=$request->category_id;

        $getfile=DB::table('category')
                ->where('category_id',$category_id)
                ->first();

    	$delete=DB::table('category')->where('category_id',$request->category_id)->delete();
            	DB::table('sub_category')->where('category_id',$request->category_id)->delete();
                DB::table('sub_child_category')->where('category_id',$request->category_id)->delete();
    	
    	
        if($delete)
        {
    
        return redirect()->back()->withErrors('Delete successfully');

        }
        else
        {
          return redirect()->back()->withErrors('unsuccessfull delete'); 
        }
        
        // if($delete){
        //   return redirect()->route('categorylist')->withErrors(['Delete Sucessfully']);
        // }
        // else{
        // 	return redirect()->back()->withErrors('Something Wents Wrong');
        // }

    }
    
    
        public function categorypoint(Request $request)
          {
            //   return redirect()->back()->withErrors('this function is disabled for demo.');
          $admin_email=Session::get('admin');
          $category_id=$request->category_id;
          $category = DB::table('category')
                        ->where('category_id',$category_id)
                        ->first();
          $point = DB::table('sub_category_points')
                  ->where('category_id',$category_id)
                    ->get();
        return view('admin.category.category_point',compact("admin_email","category_id","category","point"));
    }
    
       public function updatepoint(Request $request)
        {
            // return redirect()->back()->withErrors('this function is disabled for demo.');
            // return redirect()->back()->withErrors('this function is disabled for demo.');
             $this->validate(
            $request,
                [
                    'heading' => 'required',
                ],
                [
                    'heading.required' => 'Enter Heading.',
                ]
        );
                $category_id=$request->category_id;
                $heading=$request->heading;
                $point=$request->point;
                $point=json_encode($point);
                    $insert = DB::table('sub_category_points')
                    ->insert(['category_id'=>$category_id,'heading'=>$heading,'point'=>$point]);
     
                        return redirect()->back()->withErrors('Added Successfully');

    }
        public function deletepoint(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
       $points=$request->points;
       $point=DB::table('sub_category_points')
                ->where('points',$points)
                ->first();

    	$delete=DB::table('sub_category_points')->where('points',$points)->delete();
        if($delete){
             return redirect()->back()->withErrors('delete successfully');
        }
        else{
        	return redirect()->back()->withErrors('Something Wents Wrong');
        }

    }
    
    


}