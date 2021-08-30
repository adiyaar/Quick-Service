<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class RaffleController extends Controller
{
    public function raffle(Request $request)
    {
             $admin_email=Session::get('admin');
             $raffle_card= DB::table('category')
                         ->get();
                return view('admin.raffles.rafflelist',compact("admin_email","raffle_card"));
    }
        public function raffleadd(Request $request)
    {
                 $admin_email=Session::get('admin');
                 $raffle_card= DB::table('category')
                            ->get();
        return view('admin.raffles.addraffles',compact("admin_email","raffle_card"));
    }
          public function addnewraffle(Request $request)
    {
                $id=$request->category_id;
                 $raffle_card= DB::table('category')
                         ->select('category_name')
                          ->where('category_id',$id)
                         ->first();
    
         $raffle_card=$request->raffle_card;
         $start_time=$request->start_time;
         
        
        $this->validate(
            $request,
                [
                    
                    'raffle_card'=>'required',
                    
                    'reward_image'=>'required',
                ],
                [
                    
                    'raffle_card.required'=>'Enter Raffle Card Text',
                    'reward_image.required'=>'Image field cannot be empty',
                    
                ]
        );
        
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

                    $insert = DB::table('category_image')
                    ->insert(['category_name'=>$raffle_card,'category_image'=>$reward_image]);
     
                        return redirect()->back()->withErrors('Added Successfully');

    }
    
    
    public function deleteraffle(Request $request)
    {
        
                $id=$request->id;
                $getfile=DB::table('raffle_card')
                            ->where('id',$id)
                            ->first();

                 $reward_image=$getfile->raffle_img;

            	$delete=DB::table('raffle_card')->where('id',$request->id)->delete();
                if($delete)
                {
                
                    if(file_exists($reward_image)){
                        unlink($reward_image);
                 }
         
                 return redirect()->back()->withErrors('Delete successfully');

        }
        else
        {
           return redirect()->back()->withErrors('unsuccessfull delete'); 
        }

    }
    public function raffleedit(Request $request)
    {
                    $id=$request->id;
                    $admin_email=Session::get('admin');
                    $raffle_card= DB::table('raffle_card')
                	 		  ->where('id',$id)
                	 		  ->first();
           return view('admin.raffles.raffleedit',compact("admin_email","raffle_card"));
    }
     public function raffleupdate(Request $request)
        {
    
            $raffle_card=$request->raffle_card;
            $start_time=$request->start_time;
            $end_time=$request->end_time;
            $entry_coin=$request->entry_coin;
            $old_reward_image=$request->old_reward_image;
            $trade_url=$request->trade_url;
            $min_coins=$request->min_coins;
            $max_coins=$request->max_coins;
         
          if($min_coins>$max_coins)
        {
            return redirect()->back()->withErrors("Min. Coins value must be lesser than Max. Coins");
        }
            
        //     $this->validate(
        //         $request,
        //             [
                    
        //             'raffle_card'=>'required',
        //             'start_time'=>'required',
        //             'end_time'=>'required',
        //             'entry_coin'=>'required',
                    
        //         ],
        //         [
                    
        //             'raffle_card.required'=>'Enter Raffle Card Text',
        //             'start_time.required'=>'Start time cannot be empty',
        //             'reward_image.required'=>'Image field cannot be empty',
        //             'end_time.required'=>'End time cannot be empty',
                 
        //         ]
        // );
                 $id=$request->id;
                 $getImage = DB::table('raffle_card')
                             ->where('id',$id)
                            ->first();

                 $image = $getImage->raffle_img; 
        
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

                    $insert = DB::table('raffle_card')
                             ->where('id', $id)
                    ->update(['card_name'=>$raffle_card,'start_time'=>$start_time,'end_time'=>$end_time, 'raffle_img'=>$reward_image,'entry_coin'=>$entry_coin,'trade_url'=>$trade_url,'min_coins'=>$min_coins,'max_coins'=>$max_coins]);
     
                     return redirect()->back()->withErrors('Update Successfully');

    }
	

    
}