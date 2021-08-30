<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class NewsFeedController extends Controller
{
    public function societyNotice(Request $request)
    {
    	$user_id = $request->user_id;

    	$getUserSociety = DB::table('tbl_user')
    						->where('id', $user_id)
    						->first();

    	$userSocietyId = $getUserSociety->society_id;

    	$societyNotice = DB::table('tbl_news_feed')
    						->where('feed_society_id', 'all')
    						->orWhere('feed_society_id', 'like', '%"'.$userSocietyId.'"%')
    						->get();

    	if(count($societyNotice)>0){
    		$message = array('status'=>'1', 'message'=>'notice list', 'data'=>$societyNotice);
        	return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
        	return $message;
    	}
    }
}
