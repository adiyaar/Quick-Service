<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class OngoingBookingController extends Controller
{
    public function ongoing(Request $request)
    {
        $user_id=$request->id;
        $current_date = Carbon::now();
        $date = date('Y-m-d');
        
        $ongoing = DB::table('booking')
                    ->where('id',$user_id)
                    ->whereDate('confirmed_on','>=',$date)
                    ->Where('booking_status','!=','2')
                    ->Where('booking_status','!=','3')
                    ->get();
        if(count($ongoing)>0)   { 
          foreach ($ongoing as $ongoings){
              $services = DB::table('booking_details')
                         ->leftjoin('services','booking_details.service_id','=','services.service_id')
                         ->where('booking_details.booking_id',$ongoings->booking_id)
                         ->where('type', 'service')
                         ->get();
            $newservice='';
            foreach($services as $sv)
            {
                $newservice.=''.$sv->service_name;
            }
                         
          
                         
            	$data[] = array( 'confirmed_on'=>$ongoings->confirmed_on, 'time_slot'=>$ongoings->time_slot, 'price'=>$ongoings->price, 'booking_date'=>$ongoings->booking_date,'services'=>$newservice,'booking_id'=>$ongoings->booking_id,'unique_code'=>$ongoings->unique_code);
                         
          } 
          $data=array('status'=>'1','message'=>'ongoing bookings list','data'=>$data); 
          
        }else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        }
        return $data;
        
    }
    
        public function history(Request $request)
    {
        $user_id=$request->id;
        $current_date = Carbon::now();
        $date = date('Y-m-d');
        
        $ongoing = DB::table('booking')
                    ->where('id',$user_id)
                    ->Where('booking_status','!=','4')
                    ->Where('booking_status','!=','0')
                    ->Where('booking_status','!=','1')
                    ->get();
        if(count($ongoing)>0)   { 
          foreach ($ongoing as $ongoings){
              $services = DB::table('booking_details')
                         ->leftjoin('services','booking_details.service_id','=','services.service_id')
                         ->where('booking_details.booking_id',$ongoings->booking_id)
                         ->where('type', 'service')
                         ->get();
            $newservice='';
            foreach($services as $sv)
            {
                $newservice.=''.$sv->service_name;
            }
                         
          
                         
            	$data[] = array( 'confirmed_on'=>$ongoings->confirmed_on, 'time_slot'=>$ongoings->time_slot, 'price'=>$ongoings->price, 'booking_date'=>$ongoings->booking_date,'services'=>$newservice,'booking_id'=>$ongoings->booking_id,'unique_code'=>$ongoings->unique_code,'booking_status'=>$ongoings->booking_status);
                         
          } 
          $data=array('status'=>'1','message'=>'User Booking History','data'=>$data); 
          
        }else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        }
        return $data;
        
    }
    
     public function leadboughthistory(Request $request)
    {
        $partner_id=$request->partner_id;
        $current_date = Carbon::now();
        $date = date('Y-m-d');
        
        $ongoing = DB::table('booking')
                    ->where('partner_id',$partner_id)
                     ->join('tbl_user','booking.id','=','tbl_user.id')
                    ->get();
        if(count($ongoing)>0)   { 
          foreach ($ongoing as $ongoings){
              $services = DB::table('booking')
                         ->join('partner','booking.partner_id','=','partner.partner_id')
                         
                         ->where('booking.partner_id',$ongoings->partner_id)
                         ->get();
                         
                         
            	$data[] = array('confirmed_on'=>$ongoings->confirmed_on, 'time_slot'=>$ongoings->time_slot, 'price'=>$ongoings->price,'coins'=>$ongoings->coins, 'booking_date'=>$ongoings->booking_date,'booking_id'=>$ongoings->booking_id,'booking_status'=>$ongoings->booking_status,'user_name'=>$ongoings->user_name);
                 
                         
          }   
           $data=array('status'=>'1','message'=>'Lead bought History found','data'=>$data); 
        }else{
            $data[]=array('status'=>'0','message'=>'Oops, No Project found');
        }
        return $data;
        
    }
    
}