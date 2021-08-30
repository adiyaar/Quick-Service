<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class HomeController extends Controller
{
    public function adminHome(Request $request)
    {
        $title = "Home";

        $app = DB::table('category')
        		->get();

        $category = DB::table('booking')
        			->get();

        $group = DB::table('partner')
        			->get();

        $user = DB::table('tbl_user')
        			->get();
        			
        $date = date('Y-m-d');

        $day1 = DB::table('tbl_user')
                    ->where('created_at', 'Like', $date.'%')
                    ->get();
        $day11 = date('D', strtotime($date));
        
        $day2 = DB::table('tbl_user')
                    ->where('created_at', 'Like', date("Y-m-d",strtotime($date." -1 day")).'%')
                    ->get();
        $day22 = date('D', strtotime($date." -1 day"));
        
        $day3 = DB::table('tbl_user')
                    ->where('created_at', 'Like', date("Y-m-d",strtotime($date." -2 day")).'%')
                    ->get();
        $day33 = date('D', strtotime($date." -2 day"));
        
        $day4 = DB::table('tbl_user')
                    ->where('created_at', 'Like', date("Y-m-d",strtotime($date." -3 day")).'%')
                    ->get();
        $day44 = date('D', strtotime($date." -3 day"));
        
        $day5 = DB::table('tbl_user')
                    ->where('created_at', 'Like', date("Y-m-d",strtotime($date." -4 day")).'%')
                    ->get();
        $day55 = date('D', strtotime($date." -4 day"));
        
        $day6 = DB::table('tbl_user')
                    ->where('created_at', 'Like', date("Y-m-d",strtotime($date." -5 day")).'%')
                    ->get();
        $day66 = date('D', strtotime($date." -5 day"));
        
        $day7 = DB::table('tbl_user')
                    ->where('created_at', 'Like', date("Y-m-d",strtotime($date." -6 day")).'%')
                    ->get();
        $day77 = date('D', strtotime($date." -6 day"));
        
    	return view('admin.home.main', compact('title', "app", "category", "group", "user", "day1", "day11", "day2", "day22", "day3", "day33", "day4", "day44", "day5", "day55", "day6", "day66", "day7", "day77"));
    }
}
