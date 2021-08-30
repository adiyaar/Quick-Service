<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class ReedemController extends Controller
{
public function reedem(Request $request)
    {
                    $admin_email=Session::get('admin');
                    $reward_image= DB::table('reward_image')
                                ->get();
                 return view('admin.reedem.reedemlist',compact("admin_email","reward_image"));
    }
    
     public function Addreedem(Request $request)
        {
             $admin_email=Session::get('admin');
             $reward_image= DB::table('reward_image')
                             ->get();
             return view('admin.reedem.addreedem',compact("admin_email","reward_image"));
        }
     public function AddNewreedem(Request $request)
        {
                $id=$request->id;
                 $reward_image= DB::table('reward_image')
                              ->select('reward_text')
                              ->where('id',$id)
                                ->first();
    
                $scratch_card=$request->scratch_card;
                $sub_text=$request->sub_text;
                $min_coin=$request->min_coin;
                $max_coin=$request->max_coin;
                $bonus_min_coins=$request->bonus_min_coin;
                $bonus_max_coins=$request->bonus_max_coin;
                
                if($min_coin>$max_coin)
                {
                    return redirect()->back()->withErrors("Min. Coins value must be lesser than Max. Coins");
                }
                if($bonus_min_coins>$bonus_max_coins)
                {
                    return redirect()->back()->withErrors("Min. Coins value must be lesser than Max. Coins");
                }
        
                    $this->validate(
                        $request,
                            [
                                
                                'scratch_card'=>'required',
                                'sub_text'=>'required',
                                'reward_image'=>'required',
                                'min_coin'=>'required',
                                'max_coin'=>'required',
                                'bonus_min_coin'=>'required',
                                'bonus_max_coin'=>'required',
                            ],
                            [
                                
                                'scratch_card.required'=>'Enter Scratch Card Text',
                                'sub_text.required'=>'Enter Scratch Card Sub Text',
                                'reward_image.required'=>'Image field cannot be empty',
                                'min_coin.required'=>"Min. coin field can't be empty",
                                'max_coin.required'=>"Min. coin field can't be empty",
                                'bonus_min_coin.required'=>"Min. coin field can't be empty",
                                 'bonus_min_coin.required'=>"Min. coin field can't be empty",
                            ] );
                    
                            
                    if($request->hasFile('reward_image')){
                        $reward_image = $request->reward_image;
                        $fileName = date('dmyhisa').'-'.$reward_image->getClientOriginalName();
                        $fileName = str_replace(" ", "-", $fileName);
                        $reward_image->move('images/store/eventbanner/', $fileName);
                        $reward_image = 'images/store/eventbanner/'.$fileName;
                    }
                    else{
                        $reward_image = 'N/A';
                    }

                    $insert = DB::table('reward_image')
                             ->insert(['reward_text'=>$scratch_card,'reward_sub_text'=>$sub_text,'max_coins'=>$max_coin, 'reward_img'=>$reward_image,'min_coins'=>$min_coin,'bonus_min_coin'=>$bonus_min_coins,'bonus_max_coin'=>$bonus_max_coins]);
     
                     return redirect()->back()->withErrors("Today's Reward Added Successfully");

        }
    
    public function deletereedem(Request $request)
        {
                        $id=$request->id;
                        
                        $getfile=DB::table('reward_image')
                        ->where('id',$id)
                        ->first();

                $reward_img=$getfile->reward_img;
                
            	$delete=DB::table('reward_image')->where('id',$request->id)->delete();
                if($delete)
                {
                
                    if(file_exists($reward_img)){
                        unlink($reward_img);
                }
         
                 return redirect()->back()->withErrors('delete successfully');

                 }
                else
                {
                   return redirect()->back()->withErrors('unsuccessfull delete'); 
                }

        }
    public function reedemedit(Request $request)
        {
                $id=$request->id;
                $admin_email=Session::get('admin');
                $reward_image= DB::table('reward_image')
            	 		  ->where('id',$id)
            	 		  ->first();
               return view('admin.reedem.reedemedit',compact("admin_email","reward_image"));
         }
    public function reedemupdate(Request $request)
         {
    
                $scratch_card=$request->scratch_card;
                $sub_text=$request->sub_text;
                $min_coin=$request->min_coin;
                $max_coin=$request->max_coin;
                $old_reward_image=$request->old_reward_image;
                $bonus_min_coins=$request->bonus_min_coin;
                $bonus_max_coins=$request->bonus_max_coin;
                  
          
                if($min_coin>$max_coin)
                    {
                        return redirect()->back()->withErrors("Min. Coins value must be lesser than Max. Coins");
                    }
                     if( $bonus_min_coins>$bonus_max_coins)
                    {
                        return redirect()->back()->withErrors("Min. Coins value must be lesser than Max. Coins");
                    }
        
                $this->validate(
                    $request,
                        [
                            
                       'scratch_card'=>'required',
                            'sub_text'=>'required',
                        ],
                        [
                            
                          'scratch_card.required'=>'Enter Scratch Card Text',
                            'sub_text.required'=>'Enter Scratch Card Sub Text',
                        ] );
                 $id=$request->id;
                 $getImage = DB::table('reward_image')
                             ->where('id',$id)
                            ->first();

                  $image = $getImage->reward_img; 
                
               if($request->hasFile('reward_image')!=''){
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
                    $reward_image = $old_reward_image;
                     }

                        $insert = DB::table('reward_image')
                          ->where('id', $id)
                          ->update(['reward_text'=>$scratch_card,'reward_sub_text'=>$sub_text,'max_coins'=>$max_coin, 'reward_img'=>$reward_image,'min_coins'=>$min_coin,'bonus_min_coin'=>$bonus_min_coins,'bonus_max_coin'=>$bonus_max_coins]);
     
                    return redirect()->back()->withErrors('Update Successfully');

          }
	
    
}