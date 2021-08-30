<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class AboutController extends Controller
{
    public function aboutus(Request $request)
        {
          $admin_email=Session::get('admin');
          $term = DB::table('aboutus')
                        ->get();
       
        return view('admin.aboutus.index',compact("admin_email","term"));
    }
    
    
    public function addaboutus(Request $request)
        {
          
          $admin_email=Session::get('admin');
        return view('admin.aboutus.addaboutus',compact("admin_email"));
    }
    
  
    public function newaboutus(Request $request)
        {
           
             $this->validate(
            $request,
                [
                    'termcondition' => 'required',
                ],
                [
                    'termcondition.required' => 'Enter Terms and Conditions.',
                ]
        );
                    $termcondition=$request->termcondition;
                    $insert = DB::table('aboutus')
                    ->insert(['description'=>$termcondition]);
     
                        return redirect()->back()->withErrors('Added Successfully');

    }
    public function editaboutus(Request $request)
        {
           
          $admin_email=Session::get('admin');
          $id = $request->id;
          $term = DB::table('aboutus')
                            ->where('id',$id)
                             ->first(); 
          return view('admin.aboutus.editaboutus',compact("admin_email","term"));
       
    }
    
    public function updateaboutus(Request $request)
        {
          
            $this->validate(
            $request,
                [
                    'termcondition' => 'required',
                ],
                [
                    'termcondition.required' => 'Enter Terms and Conditions Name.',
                ]
        );
        $id = $request->id;
        $termcondition=$request->termcondition;

        $term = DB::table('aboutus')
                        ->where('id', $id)
                        ->first();
        $termconditionupdate = DB::table('aboutus')
                            ->where('id', $id)
                            ->update([
                                'id'=>$id,
                                'description'=>$termcondition,
                                
                            ]);
        
        if($termconditionupdate){
            return redirect()->back()->withErrors('Updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
    
        public function deleteaboutus(Request $request)
    {
       
        $id=$request->id;

        $termcondition=DB::table('aboutus')
                ->where('id',$id)
                ->first();

    	$delete=DB::table('aboutus')->where('id',$request->id)->delete();
    	
    	
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