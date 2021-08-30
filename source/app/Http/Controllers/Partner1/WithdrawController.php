<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class WithdrawController extends Controller
{
    public function adminWithdrawRequest(Request $request)
    {
    	$title = "Withdraw Request";
        
    	$adminWithdrawRequest = DB::table('tbl_redeem_request')
    								->join('tbl_user', 'tbl_user.id', '=', 'tbl_redeem_request.user_id')
    								->select('tbl_redeem_request.*', 'tbl_user.user_name as user_name')
    								->orderBy('id', 'DESC')
    			        			->get();

        return view('admin.withdraw.index',compact("adminWithdrawRequest", "title"));
    }

    public function adminWithdrawRequestApprove(Request $request)
    {
        return redirect()->back();
        
    	$id = $request->id;

    	$adminWithdrawRequestApprove = DB::table('tbl_redeem_request')
    									->where('id', $id)
    									->update([
    										'status'=>'1'
    									]);

    	if($adminWithdrawRequestApprove){
            return redirect()->back()->withErrors('Payment Done');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
}
