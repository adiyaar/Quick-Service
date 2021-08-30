<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class HygineController extends Controller
{
    public function hyginelist(Request $request)
        {
          $admin_email=Session::get('admin');
          
          $hygine = DB::table('hygine_price')
                        ->join('sub_child_category','hygine_price.child_category_id','=','sub_child_category.child_category_id')
                        ->get();
                  
       
        return view('admin.hygine.hyginelist',compact("admin_email","hygine"));
    }
    
    public function addhygine(Request $request)
        {
     
          $admin_email=Session::get('admin');
          
          $child_category = DB::table('sub_child_category')
                        ->get();                
                            
       
        return view('admin.hygine.addhygine',compact("admin_email","child_category"));
    }
    
    public function addnewhygine(Request $request)
        {
     
             
    
         $price=$request->price;
         $child_category_id=$request->child_category_id;
         
       

                    $insert = DB::table('hygine_price')
                    ->insert(['child_category_id'=>$child_category_id,
                               'price'=>$price,
                                  ]);
                  if($insert){
            return redirect()->back()->withErrors('Added successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }

    }
    
    public function edithygine(Request $request)
        {
       
            $id=$request->id;
                 $category1= DB::table('hygine_price')
                          ->where('price_id',$id)
                         ->first();
                $child_category = DB::table('sub_child_category')
                                        ->get();
       
        return view('admin.hygine.edithygine',compact("category1","child_category"));
    }
    
    public function updatehygine(Request $request)
        {
            
           
        $id=$request->id;
        $price=$request->price; 
        $child_category_id= $request->child_category_id;
    

       

        $updateBanner = DB::table('hygine_price')
                            ->where('price_id', $id)
                            ->update([
                                'child_category_id'=>$child_category_id,
                                'price'=>$price,
                               ]);
        
        if($updateBanner){
            return redirect()->back()->withErrors(' Updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
    
    public function deletehygine(Request $request)
    {
      
       $id=$request->id;

        $getfile=DB::table('hygine_price')
                ->where('price_id',$id)
                ->first();

    	$delete=DB::table('hygine_price')->
    	where('price_id',$id)
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