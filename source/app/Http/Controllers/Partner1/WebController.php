<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class WebController extends Controller
{
    public function adminWebLogo(Request $request)
    {
    	$title = "Logo";

    	$adminWebLogo = DB::table('tbl_web_setting')
    					->where('id', '1')
    					->first();		

    	return view('admin.web.logo', compact("adminWebLogo", "title"));
    }

    public function adminUpdateWebLogo(Request $request)
    {
       return redirect()->back()->withErrors('this function is disabled for demo.');
        
    	$this->validate(
    		$request,
    		[
    			'app_logo' => 'required|mimes:jpeg,png,jpg|max:400',
    		],
    		[
    			'app_logo.required' => 'Choose Image...',
    		]
    	);

    	$checkLogo = DB::table('tbl_web_setting')
    				->where('id', '1')
    				->first();

    	$image = $checkLogo->value;

    	if($request->hasFile('app_logo')){
    		if(file_exists($image)){
               unlink($image);
            }
            $app_logo = $request->app_logo;
            $fileName = date('dmyhisa').'-'.$app_logo->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $app_logo->move('images/logo/', $fileName);
            $app_logo = 'images/logo/'.$fileName;
        }
        else{
            $app_logo = $checkLogo->value;
        }

        $updateAdminWebLogo = DB::table('tbl_web_setting')
        						->where('id', '1')
        						->update(['value'=>$app_logo]);

        if($updateAdminWebLogo){
        	return redirect()->back()->withErrors('Logo Updated Successfully');
        }
        else{
        	return redirect()->back()->withErrors('Something Wents Wrong');
        }
    }

    public function adminWebName(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
    	$title = "App Name";
    	
    	$adminWebName = DB::table('tbl_web_setting')
    					->where('id', '2')
    					->first();		

    	return view('admin.web.name', compact("adminWebName", "title"));
    }

    public function adminUpdateWebName(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
        
    	$this->validate(
    		$request,
    		[
    			'app_name' => 'required',
    		],
    		[
    			'app_name.required' => 'Enter app name...',
    		]
    	);

    	$app_name = $request->app_name;

    	$adminUpdateWebName = DB::table('tbl_web_setting')
        						->where('id', '2')
        						->update(['value'=>$app_name]);

        if($adminUpdateWebName){
        	return redirect()->back()->withErrors('Name Updated Successfully');
        }
        else{
        	return redirect()->back()->withErrors('Something Wents Wrong');
        }
    }

    public function adminAppUpdate(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
        $title = "App Version";
        
        $adminAppUpdate = DB::table('tbl_web_setting')
                        ->where('id', '11')
                        ->first();      

        return view('admin.web.version', compact("adminAppUpdate", "title"));
    }
    
    public function adminUpdateAppUpdate(Request $request)
    {
       return redirect()->back()->withErrors('this function is disabled for demo.');
        
        $this->validate(
            $request,
            [
                'app_version' => 'required',
            ],
            [
                'app_version.required' => 'Enter app version...',
            ]
        );

        $app_version = $request->app_version;

        $adminUpdateAppUpdate = DB::table('tbl_web_setting')
                                ->where('id', '11')
                                ->update(['value'=>$app_version]);

        if($adminUpdateAppUpdate){
            $updateAlert = DB::table('tbl_user')
                            ->update([
                                'is_app_updated'=>'0'
                            ]);

            $getDevice = DB::table('tbl_user')
                            ->where('device_id', '!=', null)
                            ->select('device_id')
                            ->groupBy('device_id')
                            ->get();

            if(count($getDevice) != 0){
                foreach ($getDevice as $getDevices) {
                    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
                    $token = $getDevices->device_id;;
                    

                    $notification = [
                        'title' => 'Update App',
                        'body' => 'New Version comes update your app',
                        'sound' => true,
                    ];
                    
                    $extraNotificationData = ["message" => $notification];

                    $fcmNotification = [
                        //'registration_ids' => $tokenList, //multple token array
                        'to'        => $token, //single token
                        'notification' => $notification,
                        'data' => $extraNotificationData,
                    ];

                    $headers = [
                        'Authorization: key=AAAAaPSNf40:APA91bFykKk_EkXSj96gI16irTaNXpDr3Ho33yV4o-RyeWkPO85LnA6i34R6o3D2s-OOXIOuqBjCcHq-w4w9-mEAoIOrHTP6zHAI_kpDZ1-_sPGoRt9Q-8EdizMoRiwWkrQ4s6QWoUin',
                        'Content-Type: application/json'
                    ];

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$fcmUrl);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
                    $result = curl_exec($ch);
                    curl_close($ch);
                }

                $results = json_decode($result);
            }

            return redirect()->back()->withErrors('Version Updated Successfully');
        }
        else{
            return redirect()->back()->withErrors('Something Wents Wrong');
        }
    }

    public function adminWebDescription(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
    	$title = "Description";
    	$admin_email = Session::get('mlm-admin');

    	$web = DB::table('tbl_web_setting')
    			->get();

    	$admin = DB::table('tbl_admin')
    				->where('admin_email', $admin_email)
    				->first();

    	$adminWebDescription = DB::table('tbl_web_setting')
		    					->where('id', '3')
		    					->first();		

    	return view('admin.web.adminWebDescription', compact("title", "web", "admin", "adminWebDescription"));
    }

    public function updateAdminWebDescription(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
        
    	$this->validate(
    		$request,
    		[
    			'description' => 'required',
    		],
    		[
    			'description.required' => 'Enter Description...',
    		]
    	);

    	$id = $request->id;
    	$description = $request->description;

    	$updateAdminWebDescription = DB::table('tbl_web_setting')
	        						->where('id', $id)
	        						->update(['value'=>$description]);

        if($updateAdminWebDescription){
        	return redirect()->back()->withErrors('Description Updated Successfully');
        }
        else{
        	return redirect()->back()->withErrors('Something Wents Wrong');
        }
    }

    public function adminWebPrivacy(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
    	$title = "Privacy Policy";
    	$admin_email = Session::get('mlm-admin');

    	$web = DB::table('tbl_web_setting')
    			->get();

    	$admin = DB::table('tbl_admin')
    				->where('admin_email', $admin_email)
    				->first();

    	$adminWebPrivacy = DB::table('tbl_web_setting')
	    					->where('id', '4')
	    					->first();		

    	return view('admin.web.adminWebPrivacy', compact("title", "web", "admin", "adminWebPrivacy"));
    }

    public function updateAdminWebPrivacy(Request $request)
    {
       return redirect()->back()->withErrors('this function is disabled for demo.');
        
    	$this->validate(
    		$request,
    		[
    			'privacy' => 'required',
    		],
    		[
    			'privacy.required' => 'Enter Privacy...',
    		]
    	);

    	$id = $request->id;
    	$privacy = $request->privacy;

    	$updateAdminWebPrivacy = DB::table('tbl_web_setting')
	        						->where('id', $id)
	        						->update(['value'=>$privacy]);

        if($updateAdminWebPrivacy){
        	return redirect()->back()->withErrors('Privacy Updated Successfully');
        }
        else{
        	return redirect()->back()->withErrors('Something Wents Wrong');
        }
    }

    public function adminAdmob(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
        $title = "Admob";

        $adminAdmob = DB::table('tbl_admob')
                        ->where('id', '1')
                        ->first();      

        return view('admin.web.admob', compact("adminAdmob", "title"));
    }

    public function adminUpdateAdmob(Request $request)
    {
       return redirect()->back()->withErrors('this function is disabled for demo.');
        
        $this->validate(
            $request,
            [
                'app_id' => 'required',
                'banner_unit_id' => 'required',
                'interstitial_unit_id' => 'required',
            ],
            [
                'app_id.required' => 'Enter app id...',
                'banner_unit_id.required' => 'Enter banner unit id...',
                'interstitial_unit_id.required' => 'Enter interstitial unit id...',
            ]
        );

        $app_id = $request->app_id;
        $banner_unit_id = $request->banner_unit_id;
        $interstitial_unit_id = $request->interstitial_unit_id;
        $reward_unit_id = $request->reward_unit_id;
        $updated_at = Carbon::now();

        $adminUpdateAdmob = DB::table('tbl_admob')
                                ->where('id', '1')
                                ->update([
                                    'app_id'=>$app_id,
                                    'banner_unit_id'=>$banner_unit_id,
                                    'interstitial_unit_id'=>$interstitial_unit_id,
                                    'reward_unit_id'=>$reward_unit_id,
                                    'updated_at'=>$updated_at,
                                ]);

        if($adminUpdateAdmob){
            return redirect()->back()->withErrors('admob Updated Successfully');
        }
        else{
            return redirect()->back()->withErrors('Something Wents Wrong');
        }
    }
    
    public function adminFcm(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
        $title = "FCM";

        $adminFcm = DB::table('tbl_fcm')
                        ->where('id', '1')
                        ->first();      

        return view('admin.web.fcm', compact("adminFcm", "title"));
    }
    
     public function adminUpdateFcm(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
        
        $this->validate(
            $request,
            [
                'server_key' => 'required',
                'sender_id' => 'required',
            ],
            [
                'server_key.required' => 'Enter server key...',
                'sender_id.required' => 'Enter sender id...',
            ]
        );

        $server_key = $request->server_key;
        $sender_id = $request->sender_id;;
        $updated_at = Carbon::now();

        $adminUpdateFcm = DB::table('tbl_fcm')
                                ->where('id', '1')
                                ->update([
                                    'server_key'=>$server_key,
                                    'sender_id'=>$sender_id,
                                    'updated_at'=>$updated_at,
                                ]);

        if($adminUpdateFcm){
            return redirect()->back()->withErrors('FCM Updated Successfully');
        }
        else{
            return redirect()->back()->withErrors('Something Wents Wrong');
        }
    }
    
    public function adminOtp(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
        $title = "OTP";

        $adminOtp = DB::table('tbl_web_setting')
                        ->where('id', '12')
                        ->first();
                        
        $adminMsgKey = DB::table('tbl_msg_key')
                                ->where('id', '1')
                                ->first();

        return view('admin.web.otp', compact("adminOtp", "title", "adminMsgKey"));
    }
    
     public function adminUpdateOtp(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
        
        $this->validate(
            $request,
            [
                'otp_option' => 'required',
                ''
            ],
            [
                'otp_option.required' => 'Select Otp Option...',
            ]
        );
        
        if($request->otp_option == 1){
            $this->validate(
                $request,
                [
                    'mag_auth_key' => 'required',
                    'mag_sender_id' => 'required',
                ],
                [
                    'mag_auth_key.required' => 'Enter mag auth key...',
                    'mag_sender_id.required' => 'Enter mag sender id...',
                ]
            );
        }

        $otp_option = $request->otp_option;
        $mag_auth_key = $request->mag_auth_key;
        $mag_sender_id = $request->mag_sender_id;
        $updated_at = Carbon::now();

        $adminUpdateMsgKey = DB::table('tbl_msg_key')
                                ->where('id', '1')
                                ->update([
                                    'mag_auth_key'=>$mag_auth_key,
                                    'mag_sender_id'=>$mag_sender_id,
                                    'updated_at'=>$updated_at,
                                ]);
                        
        $adminUpdateOtpOption = DB::table('tbl_web_setting')
                                    ->where('id', '12')
                                    ->update([
                                        'value'=>$otp_option,
                                    ]);

        if($adminUpdateMsgKey){
            return redirect()->back()->withErrors('Updated Successfully');
        }
        else{
            return redirect()->back()->withErrors('Something Wents Wrong');
        }
    }
}
