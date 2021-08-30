<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class leaderController extends Controller
{
    public function leader(Request $request)
    {
          $admin_email=Session::get('admin');
        $tbl_user= DB::table('tbl_user')
                    ->orderBy('user_reward','DESC')
                     ->paginate(20);
        return view('admin.leaderboard.leaderlist',compact("admin_email","tbl_user"));
    }
    public function leaderdelete(Request $request){
   
      
         $id=$request->id;

        $getfile=DB::table('tbl_user')
                ->where('id',$id)
                ->first();

    	$delete=DB::table('tbl_user')->where('id',$request->id)->delete();
        if($delete){
         
        return redirect()->back()->withErrors('Delete successfully');

        }
        else
        {
           return redirect()->back()->withErrors('unsuccessfull delete'); 
        }

    }
    
}