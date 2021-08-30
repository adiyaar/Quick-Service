<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class RatingController extends Controller
{
    public function ratinglist(Request $request)
       {
        $admin_email=Session::get('admin');
        $tbl_rating= DB::table('tbl_rating')
                         ->get();
                return view('admin.Rating.ratinglist',compact("admin_email","tbl_rating"));
       }

   public function enquirylist(Request $request)
       {
        $admin_email=Session::get('admin');
        $tbl_Enquiry= DB::table('tbl_Enquiry')
                        ->leftjoin('tbl_user','tbl_Enquiry.id','=','tbl_user.id')
                         ->get();
                return view('admin.Rating.enquirylist',compact("admin_email","tbl_Enquiry"));
       }
       
       
   public function deleterating(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
        
       $rating_id=$request->rating_id;

        $getfile=DB::table('tbl_rating')
                ->where('rating_id',$rating_id)
                ->first();

    	$delete=DB::table('tbl_rating')->where('rating_id',$request->rating_id)->delete();

        if($delete)
        {
    
        return redirect()->back()->withErrors('Delete successfully');

        }
        else
        {
           return redirect()->back()->withErrors('unsuccessfull delete'); 
        }

    }
    
      public function deleterenquiry(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
        
       $enq_id=$request->enq_id;

        $getfile=DB::table('tbl_Enquiry')
                ->where('enq_id',$enq_id)
                ->first();

    	$delete=DB::table('tbl_Enquiry')->where('enq_id',$request->enq_id)->delete();

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