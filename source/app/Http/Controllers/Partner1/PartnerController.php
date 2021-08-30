<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class PartnerController extends Controller
{
    public function partner(Request $request)
        {
          $admin_email=Session::get('admin');
          
          $category = DB::table('category')
                        ->get();
          $partner = DB::table('partner')
                       ->leftjoin('partner_bank','partner.partner_id','=','partner_bank.partner_id')
                        ->leftjoin('services','partner.category_id','=','services.child_category_id')
                        ->leftjoin('partner_documentation','partner.partner_id','=','partner_documentation.partner_id')
                        ->select('partner.partner_name','partner.partner_phone','services.service_name','partner.status','partner.partner_id','partner_bank.holder_name','partner_documentation.identify_proof')
                        ->paginate(10);
                       
    	    
        return view('admin.partner.partnerindex',compact("admin_email","partner","category"));
    }
    
    
    public function add_partner(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
          $admin_email=Session::get('admin');
          
          $category = DB::table('sub_child_category')
                        ->join('sub_category','sub_child_category.category_id','=','sub_category.category_id')
                        ->join('category','sub_category.category_id','=','category.category_id')
                        ->get();
             $partner_city = DB::table('partner_city')
                        ->get();            
                        
          $partner = DB::table('partner')
                        ->get();
       
        return view('admin.partner.addpartner',compact("admin_email","category","partner","partner_city"));
    }
    
  
    public function addnewpartner(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
                $partner_id=$request->partner_id;
                 $partner= DB::table('partner')
                         ->select('partner_name')
                          ->where('partner_id',$partner_id)
                         ->first();
    
         
         $category_list=$request->category_list;
         $partner_name=$request->partner_name;
         $partner_phone=$request->partner_phone;
         $partner_email=$request->partner_email;
         $partner_prof=$request->partner_prof;
         $partner_pass=$request->partner_pass;
         $identify_proof=$request->identify_proof;
         $voter_card_number=$request->voter_card_number;
         $gender=$request->gender;
         $d_o_b=$request->d_o_b;
         $c_o=$request->c_o;
         $permanent_add=$request->permanent_add;
         $cites=$request->cites;
         $address=$request->partner_add;
         $addres = str_replace(" ", "+", $address);
        $address1 = str_replace("-", "+", $addres);
        
        $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address1."&key=AIzaSyDq6a7_3mqLmO1mcnxJMkehXRdvfk1lB1E"));
        
         $lat = $response->results[0]->geometry->location->lat;
         $lng = $response->results[0]->geometry->location->lng;
         

        $this->validate(
            $request,
                [
                    
                    'partner_name'=>'required',
                    'partner_phone'=>'required',
                    'partner_email'=>'required',
                    'partner_prof'=>'required',
                    'partner_pass'=>'required',
                    'image'=>'required',
                    'partner_add'=>'required',
                    'identify_proof'=>'required',
                    'front'=>'required',
                    'back'=>'required',
                    'voter_card_number'=>'required',
                    'gender'=>'required',
                    'd_o_b'=>'required',
                    'c_o'=>'required',
                    'permanent_add'=>'required',
                    
                ],
                [
                    
                    'partner_name.required'=>'Partner Name Required',
                    'partner_phone.required'=>'Partner phone Required',
                    'partner_email.required'=>'Partner Email Required',
                    'partner_prof.required'=>'Partner Prof. Required',
                    'partner_pass.required'=>'Partner password Required',
                    'partner_add.required'=>'Partner Address Required',
                    'image.required'=>'Image Required',
                    'partner_add.required'=>'Current Address Required',
                    'front.required'=>'Front Identity Picture Required',
                    'back.required'=>'Back Identity Picture Required',
                    'voter_card_number.required'=>'Voter Card Number Required',
                    'gender.required'=>'Gender Required',
                    'd_o_b.required'=>'Date of Birth Required',
                    'c_o.required'=>'Care of Required',
                    'permanent_add.required'=>'Permanent Address Required',
                    
                ]
        );
        
        if($request->hasFile('image')){
            $image = $request->image;
            $fileName = date('dmyhisa').'-'.$image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $image->move('images/store/eventbanner/', $fileName);
            $image = 'images/store/eventbanner/'.$fileName;
        }
        else{
            $image = 'N/A';
        }
                if($request->hasFile('front')){
            $image1 = $request->front;
            $fileName = date('dmyhisa').'-'.$image1->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $image1->move('document/images/', $fileName);
            $image1 = 'document/images/'.$fileName;
        }
        else{
            $image1 = 'N/A';
        }
                if($request->hasFile('back')){
            $image2 = $request->back;
            $fileName = date('dmyhisa').'-'.$image2->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $image2->move('document/images/', $fileName);
            $image2 = 'document/images/'.$fileName;
        }
        else{
            $image2 = 'N/A';
        }

                    $insert = DB::table('partner')
                    ->insertGetId(['partner_name'=>$partner_name,'partner_phone'=>$partner_phone,'partner_email'=>$partner_email,'partner_profesion'=>$partner_prof,'partner_password'=>$partner_pass,'category_id'=>$category_list,'partner_image'=>$image,'address'=>$address,'city__id'=>$cites,'lat'=>$lat,'lng'=>$lng]);
                    
                    $scratch = DB::table('partner_documentation')
    	           ->insert([
    	               'identify_proof'=>$identify_proof,
    	               'voter_card_number'=>$voter_card_number,
    	               'gender'=>$gender,
    	               'd_o_b'=>$d_o_b,
    	               'c_o'=>$c_o,
    	               'permanent_add'=>$permanent_add,
    	               'partner_id'=>$insert,
    	               'front_image'=>$image1,
    	               'back_image'=>$image2
    	               ]);
                    
     
                        return redirect()->back()->withErrors('Added Successfully');

    }
    
    public function partneredit(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
            $partner_id=$request->partner_id;
            
            $category=DB::table('partner_city')
    	                       ->get();
    	        
    	    $partner= DB::table('partner')
    	 		                ->where('partner_id',$partner_id)
    	 		                ->first();
    	 		                
    	 	$sub_child_category = DB::table('sub_child_category')
                                ->leftjoin('sub_category','sub_child_category.sub_category_id','=','sub_category.sub_category_id')
                                 ->leftjoin('category','sub_category.category_id','=','category.category_id')
                                    ->get();	                
    	 		                
        return view('admin.partner.editpartner',compact("partner","category","sub_child_category"));
    }
    
    public function updatepartner(Request $request)
        {
            return redirect()->back()->withErrors('this function is disabled for demo.');
            $this->validate(
            $request,
                [
                    
                    'partner_name'=>'required',
                    'partner_phone'=>'required',
                    'partner_email'=>'required',
                    'partner_prof'=>'required',
                    'partner_pass'=>'required',
                    'image'=>'required',
                    'partner_add'=>'required',
                    'identify_proof'=>'required',
                    'front'=>'required',
                    'back'=>'required',
                    'voter_card_number'=>'required',
                    'gender'=>'required',
                    'd_o_b'=>'required',
                    'c_o'=>'required',
                    'permanent_add'=>'required',
                    
                ],
                [
                    
                    'partner_name.required'=>'Partner Name Required',
                    'partner_phone.required'=>'Partner phone Required',
                    'partner_email.required'=>'Partner Email Required',
                    'partner_prof.required'=>'Partner Prof. Required',
                    'partner_pass.required'=>'Partner password Required',
                    'partner_add.required'=>'Partner Address Required',
                    'image.required'=>'Image Required',
                    'partner_add.required'=>'Current Address Required',
                    'front.required'=>'Front Identity Picture Required',
                    'back.required'=>'Back Identity Picture Required',
                    'voter_card_number.required'=>'Voter Card Number Required',
                    'gender.required'=>'Gender Required',
                    'd_o_b.required'=>'Date of Birth Required',
                    'c_o.required'=>'Care of Required',
                    'permanent_add.required'=>'Permanent Address Required',
                    
                ]
        );
        $partner_id=$request->partner_id;
        $category_list=$request->category_list;
        $partner_name=$request->partner_name;
        $partner_phone=$request->partner_phone;
        $partner_email=$request->partner_email;
        $partner_prof=$request->partner_prof;
        $partner_pass=$request->partner_pass;
        $old_reward_image=$request->old_image;
        $partner_add=$request->partner_add;
        $city_list=$request->city_list;
        

        $getBanner = DB::table('partner')
                        ->where('partner_id', $partner_id)
                        ->first();

        $image = $getBanner->partner_image; 

        if($request->hasFile('reward_image')){
            if(file_exists($image)){
                unlink($image);
            }
            $reward_image = $request->reward_image;
            $fileName = date('dmyhisa').'-'.$reward_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $reward_image->move('images/store/eventbanner/', $fileName);
            $reward_image = 'images/store/eventbanner/'.$fileName;
        }
        else{
            $reward_image = $getBanner->partner_image;
        }

        $updateBanner = DB::table('partner')
                            ->where('partner_id', $partner_id)
                            ->update([
                                'category_id'=>$category_list,
                                'partner_name'=>$partner_name,
                                'partner_phone'=>$partner_phone,
                                'partner_email'=>$partner_email,
                                'partner_profesion'=>$partner_prof,
                                'partner_password'=>$partner_pass,
                                'partner_image'=>$reward_image,
                                'address'=>$partner_add,
                                'city__id'=>$city_list
                                
                            ]);
        
        if($updateBanner){
            return redirect()->back()->withErrors('Updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
    
    public function confirmpartnerstatus(Request $request)
        {
        return redirect()->back()->withErrors('this function is disabled for demo.');
        $status = $request->status;
        $partner_id = $request->partner_id;
        
        $confirmdeliverystatus = DB::table('partner')->where('partner_id', $partner_id)->update(['status'=>1]);
        
        if($confirmdeliverystatus){
            return redirect()->back()->withErrors('Confirmed Successfully');
        }
        else{
            return redirect()->back()->withErrors('Something wrong');
        }
    }
    
    public function rejectedpartnerstatus(Request $request)
        {
        // return redirect()->back()->withErrors('this function is disabled for demo.');
        $status = $request->status;
        $partner_id = $request->partner_id;
        
        $confirmdeliverystatus = DB::table('partner')->where('partner_id', $partner_id)->update(['status'=>2]);
        
        if($confirmdeliverystatus){
            return redirect()->back()->withErrors('Rejected');
        }
        else{
            return redirect()->back()->withErrors('Something wrong');
        }
    }
    
    
    public function details(Request $request)
        {
            // return redirect()->back()->withErrors('this function is disabled for demo.');
            $partner_doc_id=$request->partner_id;
            
    	        
    	    $partner= DB::table('partner_documentation')
    	                        ->join('partner','partner_documentation.partner_id','=','partner.partner_id')
    	                       // ->join('partner','partner_gst.partner_id','=','partner.partner_id')
    	 		                ->where('partner_documentation.partner_id',$partner_doc_id)
    	 		                ->first();
    	 		                // var_dump($partner1);
    	 		               
    	 		                
        return view('admin.partner.partnerdocumentation',compact("partner"));
    }  
    
        public function bankdetails(Request $request)
        {
            
            $partner_doc_id=$request->partner_id;
            
    	        
    	    $partners= DB::table('partner_bank')
    	                        ->join('partner','partner_bank.partner_id','=','partner.partner_id')
    	                        ->leftjoin('partner_gst','partner.partner_id','=','partner_gst.partner_id')
    	 		                ->where('partner_bank.partner_id',$partner_doc_id)
    	 		                
    	 		                ->first();
    	 		                // var_dump($partner1);
    	 		               
    	 		                
        return view('admin.partner.partnerdetails',compact("partners"));
    } 
    public function deletepartner(Request $request)
    {
        return redirect()->back()->withErrors('this function is disabled for demo.');
        $partner_id=$request->partner_id;

    	$delete=DB::table('partner')->where('partner_id',$partner_id)->delete();
    	
    	
        if($delete)
        {
    
        return redirect()->back()->withErrors('delete successfully');

        }
        else
        {
           return redirect()->back()->withErrors('unsuccessfull delete'); 
        }

    }


}