<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function adminNotification(Request $request)
    {
        $title = "Send Notification";


        return view('admin.notification.index',compact("title"));
    }

    public function adminNotificationSend(Request $request)
    {
      
        $this->validate(
            $request,
                [
                    'notification_title' => 'required',
                    'notification_text' => 'required',
                    'notify_image' => 'required|mimes:jpeg,png,jpg|max:400',
                ],
                [
                    'notification_title.required' => 'Enter notification title.',
                    'notification_text.required' => 'Enter notification text.',
                    'notify_image.required' => 'Choose notification image.',
                ]
        );

        $notification_title = $request->notification_title;
        $notification_text = $request->notification_text;
        
        $date = date('d-m-Y');

        if($request->hasFile('notify_image')){
            $notify_image = $request->notify_image;
            $fileName = date('dmyhisa').'-'.$notify_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $notify_image->move('images/notification/'.$date.'/', $fileName);
            $notify_image = url('/').'/images/notification/'.$date.'/'.$fileName;
        }
        else{
            $notify_image = "N/A";
        }


            $getUser = DB::table('tbl_user')
                        ->get();

              $getDevice = DB::table('tbl_user')
                        ->where('device_id', '!=', null)
                        ->select('device_id')
                        ->groupBy('device_id')
                        ->get();
        

        $created_at = Carbon::now();

        if(count($getDevice) == 0){
            return redirect()->back()->withErrors('something wents wrong');
        }

        
        $getFcm = DB::table('tbl_fcm')
                    ->where('id', '1')
                    ->first();
                    
        $getFcmKey = $getFcm->server_key;
        
        foreach ($getDevice as $getDevices) {
            $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
            $token = $getDevices->device_id;;
            

            $notification = [
                'title' => $notification_title,
                'body' => $notification_text,
                'image' => $notify_image,
                'sound' => true,
            ];
            
            $extraNotificationData = ["message" => $notification, 'image' => $notify_image,];

            $fcmNotification = [
                //'registration_ids' => $tokenList, //multple token array
                'to'        => $token, //single token
                'notification' => $notification,
                'data' => $extraNotificationData,
                'image' => $notify_image,
            ];

            $headers = [
                'Authorization: key='.$getFcmKey,
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
         foreach ($getUser as $getUsers) {
            $insertNotification = DB::table('tbl_notification')
                                    ->insert([
                                        'user_id'=>$getUsers->id,
                                        'title'=>$notification_title,
                                        'description'=>$notification_text,
                                        'image'=>$notify_image,
                                        'created_at'=>$created_at,
                                    ]);
        }
        return redirect()->back()->withSuccess('notification send successfully');
    }
}