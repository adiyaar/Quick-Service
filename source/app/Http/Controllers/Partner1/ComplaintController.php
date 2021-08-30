<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class ComplaintController extends Controller
{
    public function complaintlist (Request $request)
        {
        $admin_email=Session::get('admin');
       $complaint_raise= DB::table('complaint_raise')
                ->get();
         return view('admin.complaints.complaintlist',compact("admin_email","complaint_raise"));

    }
    
     public function complaint(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
        $admin_email=Session::get('admin');
        $complaint_raise= DB::table('complaint_raise')
                ->get();
         return view('admin.complaints.addcomplaint',compact("admin_email","complaint_raise"));
    }
   
    public function addcomplaint(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
        $this->validate(
            $request,
                [
                    
                    'heading'=>'required',
                    'points'=>'required',
                ],
                [
                    
                    'heading.required'=>'Complaint Heading Required',
                    'points.required'=>'Add more fields Required',
                ]
        );
        $complaint_id=$request->complaint_id;
        $heading=$request->heading;
        $points=$request->points;
        
         $complaint_raise = DB::table('complaint_raise')
              ->select('complaint_point')
              ->where('complaint_id',$complaint_id)
                ->first();

      
        $insert = DB::table('complaint_raise')
                  ->insert(['complaint_point'=>$points,'complaint_head'=>$heading]);
     
     return redirect()->back()->withErrors('Added Successfully');

    }
    public function editcomplaint(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
    	
       $complaint_id=$request->complaint_id;
    	 $admin_email=Session::get('admin');
   
    	 $complaint_raise= DB::table('complaint_raise')
    	 		  ->where('complaint_id',$complaint_id)
    	 		  ->first();
    	 return view('admin.complaints.editcomplaint',compact("admin_email","complaint_raise"));


    }
    public function updatecomplaint(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
        $complaint_id=$request->complaint_id;
        $heading=$request->heading;
        $points=$request->points;
       


        $update = DB::table('complaint_raise')
                 ->where('complaint_id', $complaint_id)
                 ->update(['complaint_point'=>$points,'complaint_head'=>$heading]);

        if($update){

             

            return redirect()->back()->withErrors(' updated successfully');
        }
        else{
            return redirect()->back()->withErrors("something wents wrong.");
        }
    }
    public function deletecomplaint(Request $request)
        {
        return redirect()->back()->withErrors('this function is disabled for demo.');
       $complaint_id=$request->complaint_id;

        $getfile=DB::table('complaint_raise')
                ->where('complaint_id',$complaint_id)
                ->first();

    	$delete=DB::table('complaint_raise')->where('complaint_id',$request->complaint_id)->delete();
    	
    	
        if($delete)
        {
    
        return redirect()->back()->withErrors('Deleted successfully');

        }
        else
        {
           return redirect()->back()->withErrors('unsuccessfull delete'); 
        }

    }
	
    
}
