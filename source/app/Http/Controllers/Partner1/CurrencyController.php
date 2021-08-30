<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class FaqController extends Controller
{

     public function editfaq(Request $request)
        {
        return redirect()->back()->withErrors('this function is disabled for demo.');
          $currency_id=$request->currency_id;
          
          $faq_category = DB::table('currency')
                        ->get();

       
        return view('admin.faq.editlistfaq',compact("admin_email","faq_category","faq_ans","add"));
    }
    
    public function updatefaq(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
        $faq_desc_id=$request->faq_desc_id;
        $faq_list=$request->faq_list;
        $category_name=$request->category_name;
        $ans=$request->price;
        
        

        
        foreach($ans as $aner )
        {
             $update = DB::table('faq_ans')
                            ->insert([
                                'faq_ans'=>$aner,
                                'faq_cat_id'=>$faq_list,
                                'faq_desc_id'=>$faq_desc_id
                            ]);
        }

     
        if($update){
            return redirect()->back()->withErrors('Add successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
    
    public function deletefaqans(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
        
       $faq_ans_id=$request->faq_ans_id;

        $getfile=DB::table('faq_ans')
                ->where('faq_ans_id',$faq_ans_id)
                ->first();

    	$delete=DB::table('faq_ans')->where('faq_ans_id',$request->faq_ans_id)->delete();

        if($delete)
        {
    
        return redirect()->back()->withErrors('delete successfully');

        }
        else
        {
           return redirect()->back()->withErrors('unsuccessfull delete'); 
        }

    }
    
    public function deletefaqcategory(Request $request)
        {
        return redirect()->back()->withErrors('this function is disabled for demo.');
       $faq_cat_id=$request->faq_cat_id;

        $getfile=DB::table('faq_category')
                ->where('faq_cat_id',$faq_cat_id)
                ->first();

    	$delete=DB::table('faq_category')->where('faq_cat_id',$request->faq_cat_id)->delete();
    	        DB::table('faq_desc')->where('faq_cat_id',$request->faq_cat_id)->delete();
    	        DB::table('faq_ans')->where('faq_cat_id',$request->faq_cat_id)->delete();

        if($delete)
        {
    
        return redirect()->back()->withErrors('delete successfully');

        }
        else
        {
           return redirect()->back()->withErrors('unsuccessfull delete'); 
        }

    }
    
    
    public function faqcategorylist(Request $request)
        {
            // return redirect()->back()->withErrors('this function is disabled for demo.');
          $admin_email=Session::get('admin');
          
          $category = DB::table('faq_category')
                        ->get();

        return view('admin.faq.faq_category_list',compact("admin_email","category"));
    }

    
    public function addfaq(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
          $admin_email=Session::get('admin');
          
          $faq_category = DB::table('faq_category')
                        ->get();
       
        return view('admin.faq.addfaq',compact("admin_email","faq_category"));
    }
    
    public function addnewfaqcategory(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
            $this->validate(
            $request,
                [
                    
                    'category_name'=>'required',
                ],
                [
                    
                    'category_name.required'=>'Category Name Required',
                ]
        );
          $admin_email=Session::get('admin');
          
          $category_name=$request->category_name;
          
           $insert1 = DB::table('faq_category')
            ->insert(['faq_category'=>$category_name]);
            
            return redirect()->back()->withErrors('Added Successfully');
          
    }
    
    public function deletefaqlist(Request $request)
        {
        return redirect()->back()->withErrors('this function is disabled for demo.');
       $faq_desc_id=$request->faq_desc_id;

        $getfile=DB::table('faq_desc')
                ->where('faq_desc_id',$faq_desc_id)
                ->first();

    	$delete=DB::table('faq_desc')->where('faq_desc_id',$request->faq_desc_id)->delete();
    	        DB::table('faq_ans')->where('faq_desc_id',$request->faq_desc_id)->delete();

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