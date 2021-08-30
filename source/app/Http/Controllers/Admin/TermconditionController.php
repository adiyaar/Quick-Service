<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class TermconditionController extends Controller
{
    public function termcondition(Request $request)
        {
          $admin_email=Session::get('admin');
          $term = DB::table('termcondition')
                        ->get();
       
        return view('admin.termcondition.index',compact("admin_email","term"));
    }
    
    
    public function addtermcondition(Request $request)
        {
            // return redirect()->back()->withErrors('This function is disabled for demo.');  
          $admin_email=Session::get('admin');
        return view('admin.termcondition.addtermcondition',compact("admin_email"));
    }
    
  
    public function newtermcondition(Request $request)
        {
            // return redirect()->back()->withErrors('This function is disabled for demo.');  
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
                    $insert = DB::table('termcondition')
                    ->insert(['termcondition'=>$termcondition]);
     
                        return redirect()->back()->withErrors('Added Successfully');

    }
    public function termconditionedit(Request $request)
        {
            // return redirect()->back()->withErrors('This function is disabled for demo.');  
          $admin_email=Session::get('admin');
          $id = $request->id;
          $term = DB::table('termcondition')
                            ->where('id',$id)
                             ->first(); 
          return view('admin.termcondition.termconditionedit',compact("admin_email","term"));
       
    }
    
    public function termconditionupdate(Request $request)
        {
            // return redirect()->back()->withErrors('This function is disabled for demo.');  
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

        $term = DB::table('termcondition')
                        ->where('id', $id)
                        ->first();
        $termconditionupdate = DB::table('termcondition')
                            ->where('id', $id)
                            ->update([
                                'id'=>$id,
                                'termcondition'=>$termcondition,
                                
                            ]);
        
        if($termconditionupdate){
            return redirect()->back()->withErrors('Updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
    
        public function termconditiondelete(Request $request)
    {
        // return redirect()->back()->withErrors('This function is disabled for demo.');  
        $id=$request->id;

        $termcondition=DB::table('termcondition')
                ->where('id',$id)
                ->first();

    	$delete=DB::table('termcondition')->where('id',$request->id)->delete();
    	
    	
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