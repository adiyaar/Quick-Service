<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class LeaderboardController extends Controller
{
    public function leaderboard(request $request)
    {
    	$tbl_user = DB::table('tbl_user')
    	           ->select('user_name', 'user_reward')
    	            ->orderBy('user_reward','DESC')
    				->get();

    	if($tbl_user){
    		$message = array('status'=>'1', 'message'=>'User details', 'data'=>$tbl_user);
        	return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'No details', 'data'=>[]);
        	return $message;
    	}
    }
}
