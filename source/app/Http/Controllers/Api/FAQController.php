<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class FAQController extends Controller
{
public function faqlist(Request $request)
    {
         $category = DB::table('faq_category')
                        ->get();
        //   $faq_desc = DB::table('faq_desc')
        //             ->leftjoin('faq_category','faq_desc.faq_cat_id','=','faq_category.faq_cat_id')
        //             ->leftjoin('faq_ans','faq_desc.faq_desc_id','=','faq_ans.faq_desc_id')
        //             ->get();
    
    if(count($category)>0)   { 
            $message = array('status'=>'1', 'message'=>'FAQ List', 'data'=>$category);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'No List Found');
            return $message;
        }
    }  
    
    public function faqdesc(Request $request)
    {
        $faq_cat_id  = $request->faq_cat_id;
         $faq_desc = DB::table('faq_desc')
                        ->where('faq_cat_id',$faq_cat_id)
                        ->get();
        //   $faq_desc = DB::table('faq_desc')
        //             ->leftjoin('faq_category','faq_desc.faq_cat_id','=','faq_category.faq_cat_id')
        //             ->leftjoin('faq_ans','faq_desc.faq_desc_id','=','faq_ans.faq_desc_id')
        //             ->get();
    
    if(count($faq_desc)>0)   { 
            $message = array('status'=>'1', 'message'=>'FAQ List', 'data'=>$faq_desc);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'No List Found');
            return $message;
        }
    }
    
        public function faq_ans(Request $request)
    {
        $faq_cat_id  = $request->faq_cat_id;
         $faq_ans = DB::table('faq_ans')
                        ->where('faq_cat_id',$faq_cat_id)
                        ->get();
        //   $faq_desc = DB::table('faq_desc')
        //             ->leftjoin('faq_category','faq_desc.faq_cat_id','=','faq_category.faq_cat_id')
        //             ->leftjoin('faq_ans','faq_desc.faq_desc_id','=','faq_ans.faq_desc_id')
        //             ->get();
    
    if(count($faq_ans)>0)   { 
            $message = array('status'=>'1', 'message'=>'FAQ List', 'data'=>$faq_ans);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'No List Found');
            return $message;
        }
    }
     
}