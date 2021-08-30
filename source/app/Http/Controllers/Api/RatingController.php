<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class RatingController extends Controller
{
 public function showenquiry(Request $request)
    {
         $service_id= $request->service_id;
        $user_id = $request->id;
        $enquiry = DB::table('tbl_Enquiry')
                 ->where('id',$user_id)
                ->where('service_id',$service_id)
                ->get();
    
    if(count($enquiry)>0)   { 
            $message = array('status'=>'1', 'message'=>'your enquiry is', 'data'=>$enquiry);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'no enquiries');
            return $message;
        }
    }  
 public function enquiry(Request $request)
    {
    
        $service_id= $request->service_id;
        $user_id = $request->id;
        $services = DB::table('services')
              ->select('service_name')
              ->where('service_id', $service_id)
              ->first();
        $service_name= $services->service_name; 
        $user = DB::table('tbl_user')
              ->select('user_name')
              ->where('id', $user_id)
              ->first();
        $user_name= $user->user_name;
        $message = $request->message;
        $created_at = Carbon::now();
   
   
        $insertEnquiry= DB::table('tbl_Enquiry')
                    ->insert(['service_id'=>$service_id,
                    'id'=> $user_id,
                    'service_name'=>$service_name,
                    'user_name'=> $user_name,
                    'message'=> $message,
                    'created_at'=>$created_at]);
      
      
      if($insertEnquiry)   { 
            $message = array('status'=>'1', 'message'=>'Enquiry Raised Successfully');
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'Something went wrong');
            return $message;
        }   
       }
       
 public function showrating(Request $request)
    {
         $service_id= $request->service_id;
        $user_id = $request->id;
        $enquiry = DB::table('tbl_rating')
                 ->where('id',$user_id)
                ->where('service_id',$service_id)
                ->get();
    
    if(count($enquiry)>0)   { 
            $message = array('status'=>'1', 'message'=>'Your Pervious Rating', 'data'=>$enquiry);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'no enquiries');
            return $message;
        }
    }  
 public function rating(Request $request)
    {
    
        $service_id= $request->service_id;
        $user_id = $request->id;
        $review_head = $request->review_head;
        $review_desc = $request->review_desc;
        $rating = $request->rating;
        $services = DB::table('services')
              ->select('service_name')
              ->where('service_id', $service_id)
              ->first();
        $service_name= $services->service_name; 
        $user = DB::table('tbl_user')
              ->select('user_name')
              ->where('id', $user_id)
              ->first();
        $user_name= $user->user_name;
        $created_at = Carbon::now();
   
   
        $insertEnquiry= DB::table('tbl_rating')
                    ->insert(['service_id'=>$service_id,
                    'id'=> $user_id,
                    'service_name'=>$service_name,
                    'user_name'=> $user_name,
                    'rating'=> $rating,
                    'review_head'=>$review_head,
                    'review_desc'=>$review_desc]);
      
      
      if($insertEnquiry)   { 
            $message = array('status'=>'1', 'message'=>'Thanks for valuable feedback');
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'Something went wrong');
            return $message;
        }   
       }  
       
 public function totalrating(Request $request)
    {
        $enquiry = DB::table('tbl_rating')
                ->get();
            $rating =  DB::table('tbl_rating')
                    ->avg('rating');
        $count =   count($enquiry); 
            $new = round($count, 1);
    
    if(count($enquiry)>0)   { 
            $message = array('status'=>'1', 'message'=>'Total Rivews', 'data'=>$rating);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'no enquiries');
            return $message;
        }
    } 
    
     public function ratinglist(Request $request)
    {
        $enquiry = DB::table('tbl_rating')
                    ->join('tbl_user','tbl_rating.id','=','tbl_user.id')
                //   ->orderBy('id', 'DESC')
                   ->select('tbl_rating.service_name','tbl_rating.review_head','tbl_rating.review_desc','tbl_rating.user_name','tbl_rating.rating','tbl_user.user_image')
                   ->get();
            
    
    if($enquiry)   { 
            $message = array('status'=>'1', 'message'=>'Total Rivews', 'data'=>$enquiry);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'no enquiries');
            return $message;
        }
    } 
}