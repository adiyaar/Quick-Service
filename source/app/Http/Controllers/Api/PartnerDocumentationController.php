<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class PartnerDocumentationController extends Controller
{
    public function documentation(request $request)
    {
        $partner_id=$request->partner_id;
        $identify_proof=$request->identify_proof;
        $voter_card_number=$request->voter_card_number;
        $gender=$request->gender;
        $d_o_b=$request->d_o_b;
        $c_o=$request->c_o;
        $permanent_add=$request->permanent_add;
        $gst_name=$request->gst_name;
        $gst_number=$request->gst_number;
        
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
                             if($request->back_image){
                    $back_image = $request->back_image;
                    $back_image = str_replace('data:image/png;base64,', '', $back_image);
                    $fileName = date('dmyHis').'user_profile'.'.'.'png';
                    $fileName = str_replace(" ", "-", $fileName);
                    $pth = str_replace("source/", "",public_path());
                    \File::put($pth. '/images/user/profile/' . $fileName, base64_decode($back_image));
                    $back_image ='/public/images/user/profile/'.$fileName;
                }
                
            
            else{
                $back_image = "N/A";
            }
        
    	$scratch = DB::table('partner_documentation')
    	           ->insert([
    	               'identify_proof'=>$identify_proof,
    	               'voter_card_number'=>$voter_card_number,
    	               'gender'=>$gender,
    	               'd_o_b'=>$d_o_b,
    	               'c_o'=>$c_o,
    	               'permanent_add'=>$permanent_add,
    	               'partner_id'=>$partner_id,
    	               'front_image'=>$front_image,
    	               'back_image'=>$back_image,
    	               
    	               ]);
    	               
    	 $insert =DB::table('partner_gst')
    	           ->insert([
    	               'gst_name'=>$gst_name,
    	               'gst_no'=>$gst_number,
    	               'partner_id'=>$partner_id,
    	               
    	               ]);
    				

    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'Document Added Sucessfully', 'data'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
    
    public function documentationlist(request $request)
    {
        $partner_id=$request->partner_id;
        
    	$scratch = DB::table('partner_documentation')
    	           ->where('partner_id',$partner_id)
    	           ->get();
    				

    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'Document Update Sucessfully', 'data'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
    
    public function documentationupdate(request $request)
    {
        $partner_id=$request->partner_id;
        $identify_proof=$request->identify_proof;
        $voter_card_number=$request->voter_card_number;
        $gender=$request->gender;
        $d_o_b=$request->d_o_b;
        $c_o=$request->c_o;
        $permanent_add=$request->permanent_add;
        $gst_name=$request->gst_name;
        $gst_number=$request->gst_number;
        
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
                            if($request->back_image){
                    $back_image = $request->back_image;
                    $back_image = str_replace('data:image/png;base64,', '', $back_image);
                    $fileName = date('dmyHis').'user_profile'.'.'.'png';
                    $fileName = str_replace(" ", "-", $fileName);
                    $pth = str_replace("source/", "",public_path());
                    \File::put($pth. '/images/user/profile/' . $fileName, base64_decode($back_image));
                    $back_image ='/public/images/user/profile/'.$fileName;
                }
                
            
            else{
                $back_image = "N/A";
            }
        
    	$scratch = DB::table('partner_documentation')
    	              ->where('partner_id',$partner_id)  
    	           ->update([
    	               'identify_proof'=>$identify_proof,
    	               'voter_card_number'=>$voter_card_number,
    	               'gender'=>$gender,
    	               'd_o_b'=>$d_o_b,
    	               'c_o'=>$c_o,
    	               'permanent_add'=>$permanent_add,
    	               'partner_id'=>$partner_id,
    	               'front_image'=>$front_image,
    	               'back_image'=>$back_image,
    	               
    	               ]);
    	               
    	 $insert =DB::table('partner_gst')
    	           ->where('partner_id',$partner_id)  
    	           ->update([
    	               'gst_name'=>$gst_name,
    	               'gst_no'=>$gst_number,
    	               'partner_id'=>$partner_id,
    	               
    	               ]);
    				

    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'Document Updated Sucessfully', 'data'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
    public function rechargehistory(request $request)
    {
        $partner_id=$request->partner_id;
        
    	$scratch = DB::table('recharge_partner')
    	           ->where('partner_id',$partner_id)
    	            ->orderBy('recharge_date','DESC')
    	            ->limit(5)
    	           ->get();
    				

    	if(count($scratch)>0){
    		$message = array('status'=>'1', 'message'=>'Recharge History', 'data'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
    
    public function rechargeplan(request $request)
    {
        
    	$scratch = DB::table('membership_plan')
    	           ->get();
    				

    	if($scratch){
    		$message = array('status'=>'1', 'message'=>'Plans For Coins Purchase', 'data'=>$scratch);
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        	}
    }
    
    public function rechargevalueinsert(request $request)
    {
        $created_at = Carbon::Now();
        $plan_id =$request->plan_id;
        $partner_id =$request->partner_id;
        $coins =$request->coins;
        $price =$request->price;
        $status =$request->status;
    	$scratch = DB::table('recharge_partner')
    	            ->insert([
    	                       'plan_id'=>$plan_id,
    	                       'partner_id'=>$partner_id,
    	                       'coins'=>$coins,
    	                       'price'=>$price,
    	                       'status'=>$status,
    	                       'recharge_date'=>$created_at,
    	                       ]);
    	           
    				

    	if($status=='success'){
    	    
    	        $partner = DB::table('partner')
    	                    ->where('partner_id',$partner_id)
    	                    ->first();
    	           $old_coins =  $partner-> coins;      
    	    
    	    $update = DB::table('partner')
    	                ->where('partner_id',$partner_id)
    	               ->update(['coins'=>$coins+$old_coins,
    	                   
    	                   ]);
    	    
    		$message = array('status'=>'1', 'message'=>'Inserted');
            return $message;
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Failed');
            return $message;
        	}
    }
}