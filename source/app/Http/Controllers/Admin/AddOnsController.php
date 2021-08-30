<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class AddOnsController extends Controller
{
    public function add_onslist(Request $request)
        {
          $admin_email=Session::get('admin');
          
          $category = DB::table('sub_child_category')
                         ->get();
          
          $add_ons = DB::table('add_ons')
                        ->join('sub_child_category','add_ons.child_category_id','=','sub_child_category.child_category_id')
                        ->get();
       
        return view('admin.add_ons.add_onlist',compact("admin_email","category","add_ons"));
    }
    
    
    public function add_ons(Request $request)
        {
   
          $admin_email=Session::get('admin');
          
          $category = DB::table('sub_child_category')
                         ->get();
          
          $add_ons = DB::table('add_ons')
                        ->get();
       
        return view('admin.add_ons.add_ons_add',compact("admin_email","category","add_ons"));
    }
    
    public function new_add_ons(Request $request)
        {
 
          $admin_email=Session::get('admin');
            
                 $add_on_id=$request->add_on_id;
                 $add_ons= DB::table('add_ons')
                         ->select('add_on_title')
                          ->where('add_on_id',$add_on_id)
                         ->first();
                         
        $add_more=$request->box;
        $price=$request->price;
        $child_category_list=$request->child_category_list;
        $add_title=$request->add_title;
        
        

        $insertAO = DB::table('add_ons')
                    ->insertGetId(['add_on_title'=>'null','child_category_id'=>$child_category_list]);
                    
        $count_box=count($add_more);
        for($i=0;$i<$count_box;$i++)
        {
            // echo "<br> Values ".$i." => ".$add_more[$i]."/".$price[$i];
            $ins0ert = DB::table('add_ons_des')
            ->insertGetId(['add_on_des'=>$add_more[$i],'add_on_price'=>$price[$i],'child_category_id'=>$child_category_list,'add_on_id'=>$insertAO]);
        }
                    

            
     
         return redirect()->back()->withErrors('Added Successfully');
  
    }
    
    public function editadd_ons(Request $request)
        {
           
            $add_on_id=$request->add_on_id;
            
            $services=DB::table('sub_child_category')
    	                       ->get();
    	    $add_ons_des=DB::table('add_ons_des')
    	                ->where('add_ons_des.add_on_id',$add_on_id)
    	                       ->get();
    	        
    	    $add= DB::table('add_ons')
    	                    ->leftjoin('add_ons_des','add_ons.add_on_id','=','add_ons_des.add_on_id')
    	 		             ->where('add_ons.add_on_id',$add_on_id)
    	 		             ->first();
    	 		                
        return view('admin.add_ons.add_ons_edit',compact("services","add","add_ons_des"));
    }
    
     public function updateadd_ons(Request $request)
        {
        
        $add_on_id=$request->add_on_id;
        $service_list=$request->service_list;
        $add_title=$request->add_title;
        $add_more=$request->box;
        $box=$request->price;


        
          $count_box=count($add_more);
        for($i=0;$i<$count_box;$i++)
        {
            // echo "<br> Values ".$i." => ".$add_more[$i]."/".$price[$i];
            $ins0ert = DB::table('add_ons_des')
            ->insertGetId(['add_on_des'=>$add_more[$i],'add_on_price'=>$box[$i],'add_on_id'=>$add_on_id]);
        }                  

                            
                            
        
        if($ins0ert){
            return redirect()->back()->withErrors('Add successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

     public function deleteaddons(Request $request)
        {
        
       $des_id=$request->des_id;

        $getfile=DB::table('add_ons_des')
                ->where('des_id',$des_id)
                ->first();

    	$delete=DB::table('add_ons_des')->where('des_id',$request->des_id)->delete();

        if($delete)
        {
    
        return redirect()->back()->withErrors('delete successfully');

        }
        else
        {
           return redirect()->back()->withErrors('unsuccessfull delete'); 
        }

    }
       
     public function addmultiple(Request $request)
        {
      
          $admin_email=Session::get('admin');
            
                 $des_id=$request->des_id;
                 $add_on_id=$request->add_on_id;
                 $add_ons= DB::table('add_ons_des')
                         ->select('add_on_id')
                          ->where('des_id',$des_id)
                         ->first();
                         
        $add_more=$request->box;
        $service_list=$request->service_list;
        $add_title=$request->add_title;
        

         $insertAO = DB::table('add_ons')
         ->where('add_on_id',$add_on_id)
         ->update(['add_on_title'=>$add_title,'service_id'=>$service_list]);
                    
                    
        foreach($add_more as $more)
        {
         if($add_more=="NULL") {           
          $insert = DB::table('add_ons_des')
           ->insert(['add_on_des'=>$more,'add_on_id'=>$add_on_id]);
         }
    }
     
                        return redirect()->back()->withErrors('Added Successfully');
        
        
        
       
        
    } 
        public function deletetitle(Request $request)
        {
    
       $add_on_id=$request->add_on_id;

        $getfile=DB::table('add_ons')
                ->where('add_on_id',$add_on_id)
                ->first();

    	$delete=DB::table('add_ons')
    	            ->where('add_on_id',$add_on_id)
    	             ->delete();

        if($delete)
        {
    
        return redirect()->back()->withErrors('Delete successfully');

        }
        else
        {
           return redirect()->back()->withErrors('unsuccessfull delete'); 
        }

    }
    
    


}