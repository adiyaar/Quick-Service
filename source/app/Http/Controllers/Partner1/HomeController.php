<?php

namespace App\Http\Controllers\partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $title = "index";
        
    	return view('partner.index',compact("title"));
    }
}
