<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Hash;
use Session;

class BankDetailController extends Controller
{
    public function bankdetail(Request $request)
    {
      $title = "index";
      $partner_id = Session::get('bamaPartner');
    
      $booking = DB::table('booking')
             ->where('partner_id',$partner_id)
             ->where('booking_status',1)
             ->get();
      $users = DB::table('tbl_user')
              ->get();   
      $partner = DB::table('partner')
               ->where('partner_id',$partner_id)
               ->first();  
      $partner_gst = DB::table('partner_gst')
               ->where('partner_id',$partner_id)
               ->first();
              
      $partner_bank = DB::table('partner_bank')
               ->where('partner_id',$partner_id)
               ->first();  
      $partner_documentation = DB::table('partner_documentation')
               ->where('partner_id',$partner_id)
               ->first();          
      return view('web.layout.account',compact('partner_id','booking','users','partner','partner_gst','partner_bank','partner_documentation'));
        
   
    }
    
     public function addgst(Request $request)
    {
      $title = "index";
      $partner_id = Session::get('bamaPartner');
       $gst_no = $request->gst_no;  
       $gst_name = $request->gst_name;
               
      $partner_gst = DB::table('partner_gst')
               ->where('partner_id',$partner_id)
               ->first(); 
       if($partner_gst)
       {
               $updategst = DB::table('partner_gst')
                            ->where('partner_id', $partner_id)
                            ->update([
                                'gst_no'=>$gst_no,
                                'gst_name'=>$gst_name,
                            ]);
           if($updategst)
           {
            return redirect()->route('bankdetail');
            }
          else
          {
            return redirect()->back()->withErrors("Something wents wrong");
          }                  
       }
       else
       {
         	$insert = DB::table('partner_gst')
    	                   ->insert([
                                'gst_no'=>$gst_no,
                                'gst_name'=>$gst_name,
                                'partner_id'=>$partner_id,
                               
                            ]);
        
            if($insert){
                return redirect()->route('bankdetail');
            }
            else{
                return redirect()->back()->withErrors("Something wents wrong");
            }  
       }
   
    }
  
    public function addpancard(Request $request)
    {
      $title = "index";
      $partner_id = Session::get('bamaPartner');
      $pancard = $request->pancard;  
      $voter = $request->voter;
      $gender = $request->gender;  
      $dob = $request->dob;  
      $co = $request->co;  
               
      $partner_documentation = DB::table('partner_documentation')
               ->where('partner_id',$partner_id)
               ->first(); 
       if($partner_documentation)
       {
               $update = DB::table('partner_documentation')
                            ->where('partner_id', $partner_id)
                            ->update([
                                'identify_proof'=>$pancard,
                                'voter_card_number'=>$voter,
                                'gender'=>$gender,
                                'd_o_b'=>$dob,
                                'c_o'=>$co,
                                'front_image'=>'N/A',
                                'back_image'=>'N/A',
                                'permanent_add'=>'N/A',
                            ]);
           if($update)
           {
            return redirect()->route('bankdetail');
            }
          else
          {
            return redirect()->back()->withErrors("Something wents wrong");
          }                  
       }
       else
       {
         	$insert = DB::table('partner_documentation')
    	                   ->insert([
                                'identify_proof'=>$pancard,
                                'voter_card_number'=>$voter,
                                'gender'=>$gender,
                                'd_o_b'=>$dob,
                                'c_o'=>$co,
                                'front_image'=>'N/A',
                                'back_image'=>'N/A',
                                'permanent_add'=>'N/A',
                                'partner_id'=>$partner_id,
                               
                            ]);
        
            if($insert){
                return redirect()->route('bankdetail');
            }
            else{
                return redirect()->back()->withErrors("Something wents wrong");
            }  
       }
   
    }
    public function addbankdetail(Request $request)
    {
      $title = "index";
      $partner_id = Session::get('bamaPartner');
      $acc_name = $request->acc_name;  
      $acc_no = $request->acc_no;
      $ifsc = $request->ifsc;  
    //   dd($acc_name); 
    //   dd($acc_no); 
    //   dd($ifsc); 
               
       $partner_bank = DB::table('partner_bank')
               ->where('partner_id',$partner_id)
               ->first();  
      if($partner_bank)
      {
              $update = DB::table('partner_bank')
                            ->where('partner_id', $partner_id)
                            ->update([
                                'acc_no'=>$acc_no,
                                'ifsc_code'=>$ifsc,
                                'holder_name'=>$acc_name,
                                'image'=>'N/A',
                               
                            ]);
          if($update)
          {
            return redirect()->route('bankdetail');
            }
          else
          {
            return redirect()->back()->withErrors("Something wents wrong");
          }                  
      }
      else
      {
         	$insert = DB::table('partner_bank')
    	                   ->insert([
                                'acc_no'=>$acc_no,
                                'ifsc_code'=>$ifsc,
                                'holder_name'=>$acc_name,
                                'image'=>'N/A',
                                'partner_id'=>$partner_id,
                               
                            ]);
        
            if($insert){
                return redirect()->route('bankdetail');
            }
            else{
                return redirect()->back()->withErrors("Something wents wrong");
            }  
      }
   
    }
}
