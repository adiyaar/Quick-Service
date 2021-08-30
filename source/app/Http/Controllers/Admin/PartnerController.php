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
          
         
          $partner = DB::table('partner')
                        ->leftjoin('partner_city','partner.city__id','=','partner_city.city_id')
                      ->leftjoin('partner_bank','partner.partner_id','=','partner_bank.partner_id')
                        ->leftjoin('partner_documentation','partner.partner_id','=','partner_documentation.partner_id')
                        ->select('partner.partner_name','partner.partner_phone','partner.status','partner.partner_id','partner_city.city_name','partner_bank.holder_name','partner_documentation.identify_proof')
                        ->groupBy('partner.partner_name','partner.partner_phone','partner.status','partner.partner_id','partner_city.city_name','partner_bank.holder_name','partner_documentation.identify_proof')
                        
                        ->paginate(10);
                       
    	    
        return view('admin.partner.partnerindex',compact("admin_email","partner"));
    }
        
    
    public function add_partner(Request $request)
        {
          
          $admin_email=Session::get('admin');
          
          $category = DB::table('category')
                        ->get();
             $partner_city = DB::table('partner_city')
                        ->get();            
                        
          $partner = DB::table('partner')
                        ->get();
       
        return view('admin.partner.addpartner',compact("admin_email","category","partner","partner_city"));
    }
    
     public function subcate($id)
    {
        $admin_email=Session::get('admin');

        $data=  DB::table('sub_category')
        ->where('category_id',$id)
        ->get()->tojson();
        return $data;
    }
     public function childcate($id)
    {
        $admin_email=Session::get('admin');

        $data=  DB::table('sub_child_category')
        ->where('sub_category_id',$id)
        ->get()->tojson();
        return $data;
    }
    
  
    public function addnewpartner(Request $request)
        {
        
            $partner1= DB::table('gmap_key')
                    ->first();
            $map= $partner1->map_key;
            
            
                $partner_id=$request->partner_id;
                 $partner= DB::table('partner')
                         ->select('partner_name')
                          ->where('partner_id',$partner_id)
                         ->first();
    
         
         $category_list=$request->category_id;
         $sub_cat_list=$request->subcat_name;
         $child_name=$request->child_category_id;
         $partner_name=$request->partner_name;
         $partner_phone=$request->partner_phone;
         $partner_email=$request->partner_email;
         $partner_prof=$request->partner_prof;
         $partner_pass=$request->partner_pass;
         $identify_proof=$request->identify_proof;
         $voter_card_number=$request->voter_card_number;
         $gender=$request->gender;
         $range=$request->range;
         $d_o_b=$request->d_o_b;
         $c_o=$request->c_o;
         $permanent_add=$request->permanent_add;
         $cites=$request->cites;
         $address=$request->partner_add;
         $addres = str_replace(" ", "+", $address);
        $address1 = str_replace("-", "+", $addres);
        
        $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address1."&key=$map"));
        
         $lat = $response->results[0]->geometry->location->lat;
         $lng = $response->results[0]->geometry->location->lng;
         

        $this->validate(
            $request,
                [
                    
                    'partner_name'=>'required',
                    'partner_phone'=>'required',
                    'partner_email'=>'required',
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
                    'range'=>'required',
                    
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
                    'range.required'=>'range Required',
                    
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
                    ->insertGetId(['partner_name'=>$partner_name,'partner_phone'=>$partner_phone,'partner_email'=>$partner_email,'partner_profesion'=>$partner_prof,'partner_password'=>$partner_pass,'category_id'=>$category_list,'partner_image'=>$image,'address'=>$address,'city__id'=>$cites,'lat'=>$lat,'lng'=>$lng,'range'=>$range,'sub_cat_id'=>$sub_cat_list,'child_cat_id'=>$child_name]);
                    
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
     
            $partner_id=$request->partner_id;
            
            $category=DB::table('partner_city')
    	                       ->get();
    	        
    	    $partner= DB::table('partner')
    	 		                ->where('partner_id',$partner_id)
    	 		                ->first();
    	 		                
    	 	$sub_child_category = DB::table('category')
                                    ->get();
                $sub_category = DB::table('sub_category')
                                    ->get();                                
                $sub_child =  DB::table('sub_child_category')
    	 		              ->get();
    	 		              
        return view('admin.partner.editpartner',compact("partner","category","sub_child_category","sub_category","sub_child"));
    }
    
    public function updatepartner(Request $request)
        {
             
            $partner1= DB::table('gmap_key')
                    ->first();
            $map= $partner1->map_key;
           
            
        $partner_id=$request->partner_id;
        $category_list=$request->category_list;
        $sub_cat_list=$request->sub_cat_list;
        $partner_name=$request->partner_name;
        $partner_phone=$request->partner_phone;
        $partner_email=$request->partner_email;
        $partner_prof=$request->partner_prof;
        $partner_pass=$request->partner_pass;
        $old_reward_image=$request->old_image;
        $partner_add=$request->partner_add;
        $city_list=$request->city_list;
        $range=$request->range;
        

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
                                'city__id'=>$city_list,
                                'range'=>$range,
                                'sub_cat_id'=>$sub_cat_list
                                
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
            
            $partner_doc_id=$request->partner_id;
            
    	        
    	    $partner= DB::table('partner_documentation')
    	                        ->join('partner','partner_documentation.partner_id','=','partner.partner_id')
    	                       
    	 		                ->where('partner_documentation.partner_id',$partner_doc_id)
    	 		                ->first();
    	 		              
    	 		               
    	 		                
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