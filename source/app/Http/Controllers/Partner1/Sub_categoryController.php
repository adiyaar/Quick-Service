<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class Sub_categoryController extends Controller
{
    public function sub_category(Request $request)
        {
          $admin_email=Session::get('admin');
          
          $sub_category = DB::table('category')
                        ->get();
          $category = DB::table('sub_category')
                        ->leftjoin('category','sub_category.category_id','=','category.category_id')
                        ->paginate(20);
       
        return view('admin.category.sub_category.sub_category_list',compact("admin_email","category","sub_category"));
    }
    
    
    public function add_sub_category(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
          $admin_email=Session::get('admin');
          
          $category = DB::table('category')
                    // ->leftjoin('category','sub_category.category_id','=','category.category_id')
                    ->get();
          $sub_category = DB::table('sub_category')
                        ->get();
       
        return view('admin.category.sub_category.sub_category_add',compact("admin_email","category","sub_category"));
    }
    
  
    public function addnewsubcategory(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
                $category_id=$request->sub_category_id;
                 $category= DB::table('sub_category')
                         ->select('sub_category_name')
                          ->where('sub_category_id',$category_id)
                         ->first();
    
         $category_name=$request->category_name;
         $category_list=$request->category_list;

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

                    $insert = DB::table('sub_category')
                    ->insert(['sub_category_name'=>$category_name,'sub_category_img'=>$image,'category_id'=>$category_list]);
     
                        return redirect()->back()->withErrors('Added Successfully');

    }
    public function header_content(Request $request)
        {
            
          $admin_email=Session::get('admin');
         
       
        return view('admin.category.sub_category.filesubcategory',compact("admin_email"));
    }
    
    public function filesubcategory(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
          $admin_email=Session::get('admin');
          $sub_category_id = $request->sub_category_id;
          $category = DB::table('sub_category')
                            ->where('sub_category_id',$sub_category_id)
                             ->first();
          $head = DB::table('sub_category_header_content')
                 ->get();
         return view('admin.category.sub_category.filesubcategory',compact("admin_email","category","sub_category_id","head"));
    }
  
    public function filenewsubcategory(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
             $this->validate(
            $request,
                [
                    'header_content' => 'required',
                    'header_question' => 'required',
                ],
                [
                    'header_content.required' => 'Enter Header Content.',
                    'header_question.required' => 'Enter Header Question.',
                ]
        );
                $sub_category_id=$request->sub_category_id;
                $header_content=$request->header_content;
                $header_subcontent=$request->header_subcontent;
                $header_subcontent=json_encode($header_subcontent);
                $header_question=$request->header_question;
                
                var_dump($header_subcontent);
                 
                    $insert = DB::table('sub_category_header_content')
                    ->insert(['sub_category_id'=>$sub_category_id,'sub_category_header_main_content'=>$header_content,'sub_category_header_sub_content'=>$header_subcontent,'sub_category_child_header_question'=>$header_question]);
     
                        return redirect()->back()->withErrors('Added Successfully');

    }
     public function deleteheadercontent(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
        
       $id=$request->id;

        $getfile=DB::table('sub_category_header_content')
                ->where('id',$id)
                ->first();

    	$delete=DB::table('sub_category_header_content')->where('id',$request->id)->delete();
        if($delete){
             return redirect()->back()->withErrors('delete successfully');
        }
        else{
        	return redirect()->back()->withErrors('Something Wents Wrong');
        }

    }
    public function editsubcategory(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
            $sub_category_id=$request->sub_category_id;
            
            $tbl_category=DB::table('category')
    	                       ->get();
    	        
    	    $sub_category= DB::table('sub_category')
    	 		                ->where('sub_category_id',$sub_category_id)
    	 		                ->first();
    	 		                
        return view('admin.category.sub_category.sub_category_edit',compact("sub_category","tbl_category"));
    }
    
    public function updatesubcategory(Request $request)
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
        $sub_category_id=$request->sub_category_id;
        $category_list=$request->category_list;
        $category_name=$request->category_name;
        $old_reward_image=$request->old_image;

        $getBanner = DB::table('sub_category')
                        ->where('sub_category_id', $sub_category_id)
                        ->first();

        $image = $getBanner->sub_category_img; 

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
            $reward_image = $getBanner->sub_category_img;
        }

        $updateBanner = DB::table('sub_category')
                            ->where('sub_category_id', $sub_category_id)
                            ->update([
                                'category_id'=>$category_list,
                                'sub_category_name'=>$category_name,
                                'sub_category_img'=>$reward_image,
                                
                            ]);
        
        if($updateBanner){
            return redirect()->back()->withErrors('Updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
    
    
     public function deletesubcategory(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
       $sub_category_id=$request->sub_category_id;

        $getfile=DB::table('sub_category')
                ->where('sub_category_id',$sub_category_id)
                ->first();

    	$delete=DB::table('sub_category')->where('sub_category_id',$request->sub_category_id)->delete();
        if($delete){
             return redirect()->back()->withErrors('delete successfully');
        }
        else{
        	return redirect()->back()->withErrors('Something Wents Wrong');
        }

    }
    public function sub_category_about(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
          $admin_email=Session::get('admin');
          $sub_category_id = $request->sub_category_id;
          $category = DB::table('sub_category')
                            ->where('sub_category_id',$sub_category_id)
                             ->first();
          $about = DB::table('sub_category_about')
                 ->get();
                //  var_dump($about);
         return view('admin.category.sub_category.sub_category_about',compact("admin_email","category","sub_category_id","about"));
    }
      public function newsub_category_about(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
             $this->validate(
            $request,
                [
                    'description_title' => 'required',
                    'description' => 'required',
                ],
                [
                    'description_title.required' => 'Enter Description Title.',
                    'description.required' => 'Enter Description.',
                ]
        );
                $sub_category_id=$request->sub_category_id;
                $description_title=$request->description_title;
                $description=$request->description;
                 
                    $insert = DB::table('sub_category_about')
                    ->insert(['sub_category_id'=>$sub_category_id,'sub_category_about_title'=>$description_title,'sub_category_about_desc'=>$description]);
     
                        return redirect()->back()->withErrors('Added Successfully');

    }
    public function editabout(Request $request)
        {
            // return redirect()->back()->withErrors('this function is disabled for demo.');
          $admin_email=Session::get('admin');
          $id = $request->id;
          $about = DB::table('sub_category_about')
                            ->where('id',$id)
                             ->first(); 
          return view('admin.category.sub_category.editabout',compact("admin_email","about"));
       
    }
    
    public function updateabout(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
        $id = $request->id;
        $sub_category_id=$request->sub_category_id;
        $description_title=$request->description_title;
        $description=$request->description;

        $updateabout = DB::table('sub_category_about')
                            ->where('id', $id)
                            ->Update([
                                'sub_category_id'=>$sub_category_id,
                                'sub_category_about_title'=>$description_title,
                                'sub_category_about_desc'=>$description
                                
                            ]);                 
        
        if($updateabout){
            return redirect()->back()->withErrors('Updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
    public function deleteabout(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
       $id=$request->id;

       $about=DB::table('sub_category_about')
                ->where('id',$id)
                ->first();

    	$delete=DB::table('sub_category_about')->where('id',$id)->delete();
        if($delete){
             return redirect()->back()->withErrors('delete successfully');
        }
        else{
        	return redirect()->back()->withErrors('Something Wents Wrong');
        }

    }

}