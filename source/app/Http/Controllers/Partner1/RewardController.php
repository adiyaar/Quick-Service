<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;

class RewardController extends Controller
{
    public function Editreward(Request $request)
    {
       $id=$request->id;
       $admin_email=Session::get('admin');
    	 $tbl_rewards= DB::table('tbl_rewards')
    	 		  ->where('id',1)
    	 		   ->first();
    	 return view('admin.reward.editreward',compact("admin_email","tbl_rewards","id"));


    }
    public function Updatereward(Request $request)
{
       $id=$request->id;
        $signup_reward=$request->signup_reward;
        $login_reward=$request->login_reward;
        
                $this->validate(
            $request,
                [
                    'signup_reward' => 'required',
                    'login_reward' => 'required',
                ],
                [
                    'signup_reward.required' => 'Enter Reward Values',
                    'login_reward.required' => 'Enter login reward Values.',
                ]
        );
       


        $update = DB::table('tbl_rewards')
                 ->where('id', 1)
                 ->update(['signup_reward'=>$signup_reward,'login_reward'=>$login_reward]);

        if($update){

             

            return redirect()->back()->withErrors(' Reward updated successfully');
        }
        else{
            return redirect()->back()->withErrors("something wents wrong.");
        }
    }
    
    
}
