<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PartnerBankController extends Controller
{
    public function bank (request $request)
    {
        $partner_id=$request->partner_id;
        $holder_name=$request->holder_name;
        $acc_no=$request->acc_no;
        $cnf_no=$request->cnf_no;
        $ifsc_code=$request->ifsc_code;

        
        
                         if($request->front_image){
                    $front_image = $request->front_image;
                    $front_image = str_replace('data:image/png;base64,', '', $front_image);
                    $fileName = date('dmyHis').'user_profile'.'.'.'png';
                    $fileName = str_replace(" ", "-", $fileName);
                    $pth = str_replace("source/", "",public_path());
                    \File::put($pth. '/images/user/profile/' . $fileName, base64_decode($front_image));
                    $front_image ='/public/images/user/profile/'.$fileName;
                }
                
            
            else{
                $front_image = "N/A";
            }
        
        if($acc_no == $cnf_no )
        {
        
    	$scratch = DB::table('partner_bank')
    	           ->insert([
    	               'partner_id'=>$partner_id,
    	               'holder_name'=>$holder_name,
    	               'acc_no'=>$cnf_no,
    	               'ifsc_code'=>$ifsc_code,
    	               'image'=>$front_image
    	               ]);
    	               
    	   	$message = array('status'=>'1', 'message'=>'Added Sucessfully', 'data'=>$scratch);
            return $message;
    	               
        }
    	else{
    		$message = array('status'=>'0', 'message'=>"Account Number didn't match", 'data'=>[]);
            return $message;
        	}
    }

    public function banklisting(Request $request)
    {
        $partner_id = $request->partner_id;
    	$booking = DB::table('partner_bank')
    	               ->where('partner_id',$partner_id)
                        ->get();
    	if(count($booking)>0){
    		$message = array('status'=>'1', 'message'=>'Booking List', 'data'=>$booking);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Whoops, No Booking', 'data'=>[]);
            return $message;
        	}
    }
    
    public function bankupdate(request $request)
    {
        $partner_id=$request->partner_id;
        $holder_name=$request->holder_name;
        $acc_no=$request->acc_no;
        $cnf_no=$request->cnf_no;
        $ifsc_code=$request->ifsc_code;
        
        
        
        
        if($request->front_image){
                    $front_image = $request->front_image;
                    $front_image = str_replace('data:image/png;base64,', '', $front_image);
                    $fileName = date('dmyHis').'user_profile'.'.'.'png';
                    $fileName = str_replace(" ", "-", $fileName);
                    $pth = str_replace("source/", "",public_path());
                    \File::put($pth. '/images/user/profile/' . $fileName, base64_decode($front_image));
                    $front_image ='/public/images/user/profile/'.$fileName;
                }
                
            
            else{
                $front_image = "N/A";
            }
        
        if($acc_no == $cnf_no )
        {
        
    	$scratch = DB::table('partner_bank')
    	           ->where('partner_id',$partner_id)
    	           ->update([
    	               'partner_id'=>$partner_id,
    	               'holder_name'=>$holder_name,
    	               'acc_no'=>$cnf_no,
    	               'ifsc_code'=>$ifsc_code,
    	               'image'=>$front_image
    	               ]);
    	               
    	   	$message = array('status'=>'1', 'message'=>'Updated Sucessfully', 'data'=>$scratch);
            return $message;
    	               
        }
    	else{
    		$message = array('status'=>'0', 'message'=>"Account Number didn't match", 'data'=>[]);
            return $message;
        	}
    }
}