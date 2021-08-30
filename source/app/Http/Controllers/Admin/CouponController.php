<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;

class CouponController extends Controller
{
    public function coupon(Request $request)
    {
        $admin_email=Session::get('admin');
        $coupon= DB::table('coupon')
                ->get();
        return view('admin.coupon.coupon',compact("admin_email","coupon"));
    }
    
     public function Addcoupon(Request $request)
    {
        
        $admin_email=Session::get('admin');
        $tbl_category= DB::table('category')
                ->get();
         return view('admin.coupon.addcoupon',compact("admin_email","tbl_category"));
    }
    
    
    public function AddNewcoupon(Request $request)
    {
       
       
        $category_name=$request->category_name;

        
         $tbl_category = DB::table('category')
              ->select('category_name')
              ->where('category_id',$category_name)
                ->first();
                
        $cat = $tbl_category->category_name;
        $startingg = strtoupper(substr($cat, 0, 3));
        $coupon_name=$request->coupon_name;
         $chars ="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                    $coupon_code = "";
                    for ($i = 0; $i < 5; $i++){
                       $coupon_code .= $chars[mt_rand(0, strlen($chars)-1)];
                    }
        $coupon_image=$request->coupon_image;
        $begin_date=$request->begin_date;
        $end_date=$request->end_date;
        $coupon_description =$request->coupon_description;
        $cart_value =$request->cart_value;
        $max_uses =$request->max_uses;
        $coupon_discount =$request->coupon_discount;
        $discount = str_replace("%",'', $coupon_discount);
        $coupon_type=$request->coupon_type;
        $date = date('d-m-Y');
        $created_at=date('d-m-Y h:i a');
       
        $coupon_image = $request->coupon_image;
        $fileName = date('dmyhisa').'-'.$coupon_image->getClientOriginalName();
        $fileName = str_replace(" ", "-", $fileName);
        $coupon_image->move('images/store/eventbanner/'.$date.'/', $fileName);
        $coupon_image = 'images/store/eventbanner/'.$date.'/'.$fileName;


        $insert = DB::table('coupon')
                  ->insert(['category_id'=>$category_name,'coupon_name'=>$coupon_name,'coupon_discount'=>$discount,'coupon_code'=>$startingg.$coupon_code,'begin_date'=>$begin_date,'coupon_image'=>$coupon_image,'end_date'=>$end_date,'description'=>$coupon_description,'cart_value'=>$cart_value,'created_at'=>$created_at,"type"=>$coupon_type]);
     
     return redirect()->back()->withErrors('successfully');

    }
    
    public function Editcoupon(Request $request)
    {
    
       $coupon_id=$request->id;
    	 $admin_email=Session::get('admin');
    	 $tbl_category=DB::table('category')
    	        ->get();
    	 $coupon= DB::table('coupon')
    	 		  ->where('coupon_id',$coupon_id)
    	 		  ->first();
    	 return view('admin.coupon.EditCoupon',compact("admin_email","coupon","coupon_id","tbl_category"));


    }
    public function Updatecoupon(Request $request)
    {
   
         $chars ="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                    $coupon_code = "";
                    for ($i = 0; $i < 5; $i++){
                       $coupon_code .= $chars[mt_rand(0, strlen($chars)-1)];
                    }
        
        $coupon_name=$request->coupon_name;
         $coupon_id=$request->id;
        $category_name=$request->category_name;
        $tbl_category = DB::table('category')
              ->select('category_name')
              ->where('category_id',$category_name)
                ->first();
                
        $cat = $tbl_category->category_name;
        $startingg = strtoupper(substr($cat, 0, 3));
        $old_coupon_image=$request->old_coupon_image;
        $begin_date=$request->begin_date;
        $end_date=$request->end_date;
        $coupon_description =$request->coupon_description;
        $cart_value =$request->cart_value;
        $coupon_discount =$request->coupon_discount;
        $coupon_type=$request->coupon_type;
        $date = date('d-m-Y');
        $updated_at = date("d-m-y h:i a");
        $date=date('d-m-y');

        $this->validate(
            $request,
                [
                    
                    'category_name'=>'required',
                    'coupon_image' => 'mimes:jpeg,png,jpg|max:400',
                    'old_coupon_image'=>'required',
                ],
                [
                    
                    'category_name.required'=>'Enter your name',
                    'old_coupon_image.required' => 'choose picture.',
                ]
        );

        $getImage = DB::table('coupon')
                     ->where('coupon_id',$coupon_id)
                    ->first();

        $image = $getImage->coupon_image;  

        if($request->hasFile('coupon_image')){
             if(file_exists($image)){
                unlink($image);
            }
            $coupon_image = $request->coupon_image;
            $fileName = date('dmyhisa').'-'.$coupon_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $coupon_image->move('images/store/eventbanner/'.$date.'/', $fileName);
            $coupon_image = 'images/store/eventbanner/'.$date.'/'.$fileName;
        }
        else{
            $coupon_image = $old_coupon_image;
        }

        $update = DB::table('coupon')
                 ->where('coupon_id', $coupon_id)
                 ->update(['category_id'=>$category_name,'coupon_name'=>$coupon_name,'coupon_discount'=>$coupon_discount,'coupon_code'=>$startingg.$coupon_code,'begin_date'=>$begin_date,'coupon_image'=>$coupon_image,'end_date'=>$end_date,'description'=>$coupon_description,'cart_value'=>$cart_value,'updated_at'=>$updated_at,"type"=>$coupon_type]);

        if($update){

             

            return redirect()->back()->withErrors(' updated successfully');
        }
        else{
            return redirect()->back()->withErrors("something wents wrong.");
        }
    }
  public function deletecoupon(Request $request)
    {
   
        
        $coupon_id=$request->id;

        $getfile=DB::table('coupon')
                ->where('coupon_id',$coupon_id)
                ->first();

        $coupon_image=$getfile->coupon_image;

    	$delete=DB::table('coupon')->where('coupon_id',$request->id)->delete();
        if($delete)
        {
        
            if(file_exists($coupon_image)){
                unlink($coupon_image);
            }
         
        return redirect()->back()->withErrors('delete successfully');

        }
        else
        {
           return redirect()->back()->withErrors('unsuccessfull delete'); 
        }

    }
	
    
}
