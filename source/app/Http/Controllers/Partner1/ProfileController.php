<?php

namespace App\Http\Controllers\partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Hash;
use Session;

class ProfileController extends Controller
{


    public function partnerloggout(Request $request)
    {
    	Session::forget('index');

		return redirect()->route('adminLogin')->withErrors("logged out.");
    }
}
