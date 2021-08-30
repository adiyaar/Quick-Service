<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class SearchController extends Controller
{
 
    public function searchingFor(Request $request)
    {
        $keyword = $request->keyword;
        // $category_id = $request->category_id;

        $searchclass = DB::table('category')
                      ->leftjoin('sub_category', 'category.category_id', '=', 'sub_category.category_id')
                      ->leftjoin('sub_child_category', 'category.category_id', '=', 'sub_child_category.category_id')
                    //   ->where('category_id' , $category_id)
                      ->where('category.category_name', 'like', $keyword.'%')
                    ->orWhere('sub_category.sub_category_name', 'like', $keyword.'%')
                    ->orWhere('sub_child_category.child_name', 'like', $keyword.'%')
                    // ->orWhere('menu.menu_name', 'like', $searchingfor.'%')
                      ->get();
        if(count($searchclass)>0)   { 
            $message = array('status'=>'1', 'message'=>'data found', 'data'=>$searchclass);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        }

        return $message;
    }
}
