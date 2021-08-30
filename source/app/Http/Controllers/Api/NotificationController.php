<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class NotificationController extends Controller
{
	public function notification(Request $request)
	{
		$user_id = $request->user_id;

		$notification = DB::table('tbl_notification')
						->where('user_id', $user_id)
						->orderBy('id', 'DESC')
						->get();

		if(count($notification)>0){
    		$message = array('status'=>'1', 'message'=>'users notification', 'data'=>$notification);
        	return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'something wrong', 'data'=>[]);
        	return $message;
    	}					
	}

	public function notificationCount(Request $request)
	{
		$user_id = $request->user_id;

		$notification = DB::table('tbl_notification')
						->where('user_id', $user_id)
						->where('is_seen', '0')
						->get();

		if(count($notification)>0){
    		$message = array('status'=>'1', 'message'=>'users notification', 'data'=>count($notification));
        	return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'something wrong', 'data'=>[]);
        	return $message;
    	}
	}

    public function notificationSeen(Request $request)
    {
    	// $user_id = $request->user_id;
    	$id = $request->id;

    	$notificationSeen = DB::table('tbl_notification')
    						->where('id', $id)
    						->update([
    							'is_seen'=>'1'
    						]);

    	if($notificationSeen){
    		$message = array('status'=>'1', 'message'=>'notification seen', 'data'=>[]);
        	return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'something wrong', 'data'=>[]);
        	return $message;
    	}
    }

    public function checkUpdate(Request $request)
    {
        $getVersion = DB::table('tbl_web_setting')
                        ->where('id', '11')
                        ->select('value')
                        ->first();
                        
        $message = array('status'=>'1', 'message'=>'version', 'data'=>$getVersion);
        return $message;
    }
}
