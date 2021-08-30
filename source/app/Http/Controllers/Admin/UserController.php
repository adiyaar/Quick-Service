<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class UserController extends Controller
{
    public function adminUser(Request $request)
    {
        $title = "User";
        
        $adminUser = DB::table('tbl_user')
                        ->orderBy('id', 'DESC')
                        ->paginate(20);

        return view('admin.user.index',compact("adminUser", "title"));
    }

    public function adminAddUser(Request $request)
    {
    //  return redirect()->back()->withErrors('This function is disabled for demo.');  
        $title = "Add User";
        
        $user = DB::table('tbl_user')
                ->get();

        return view('admin.user.add', compact('user', "title"));
    }

    public function adminAddUserNew(Request $request)
    {
     
        // return redirect()->back()->withErrors('This function is disabled for demo.');  
        $this->validate(
            $request,
                [
                    'user_name' => 'required',
                    'user_phone' => 'required',
                ],
                [
                    'user_name.required' => 'Enter user name.',
                    'user_phone.required' => 'Enter user phone.',
                ]
        );

        $user_name = $request->user_name;
        $user_phone = $request->user_phone;
        $created_at = Carbon::now();
        $updated_at = Carbon::now();

        $checkUser = DB::table('tbl_user')
                        ->where('user_phone', $user_phone)
                        ->get();

        if(count($checkUser)){
            return redirect()->back()->withErrors('user already exist');
        }

        $insertUser = DB::table('tbl_user')
                            ->insert([
                                'user_name'=>$user_name,
                                'user_phone'=>$user_phone,
                                'created_at'=>$created_at,
                                'updated_at'=>$updated_at
                            ]);
        
        if($insertUser){
            return redirect()->back()->withErrors('user added successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function adminEditUser(Request $request)
    {
    //  return redirect()->back()->withErrors('This function is disabled for demo.');     
        $id = $request->id;

        $title = "Edit User";
        
        $user = DB::table('tbl_user')
                ->where('id', $id)
                ->first();

        return view('admin.user.edit', compact('user', "title"));
    }

    public function adminUpdateUser(Request $request)
    {
    //   return redirect()->back()->withErrors('This function is disabled for demo.');  
        
        $this->validate(
            $request,
                [
                    'user_name' => 'required',
                    'user_phone' => 'required',
                ],
                [
                    'user_name.required' => 'Enter user name.',
                    'user_phone.required' => 'Enter user phone.',
                ]
        );

        $id = $request->id;
        $user_name = $request->user_name;
        $user_phone = $request->user_phone;
        $created_at = Carbon::now();
        $updated_at = Carbon::now();

        $checkUser = DB::table('tbl_user')
                        ->where('id', '!=', $id)
                        ->where('user_phone', $user_phone)
                        ->get();

        if(count($checkUser)){
            return redirect()->back()->withErrors('user already exist');
        }

        $updateUser = DB::table('tbl_user')
                            ->where('id', $id)
                            ->update([
                                'user_name'=>$user_name,
                                'user_phone'=>$user_phone,
                                'created_at'=>$created_at,
                                'updated_at'=>$updated_at
                            ]);
        
        if($updateUser){
            return redirect()->back()->withErrors('user updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function adminDeleteUser(Request $request)
    {
       
        // return redirect()->back()->withErrors('This function is disabled for demo.');  
        $id = $request->id;

        $deleteUser = DB::table('tbl_user')
                        ->where('id', $id)
                        ->delete();

        if($deleteUser){
            return redirect()->back()->withErrors('user deleted successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }           
    }

    public function adminUserStatus(Request $request)
    {
    //   return redirect()->back()->withErrors('This function is disabled for demo.');  
        $id = $request->user_id;
        $val = $request->val;

        if($val == 1){
            $status = 0;
        }
        else{
            $status = 1;
        }

        $adminUserStatus = DB::table('tbl_user')
                            ->where('id', $id)
                            ->update([
                                'status'=>$status,
                            ]);

        return '1';
    }
    public function searchsubject(Request $request)
    {
    //   return redirect()->back()->withErrors('This function is disabled for demo.');  
        $entered_name = $request->entered_name;

        $searchclass = DB::table('tbl_user')
                        ->where('user_name', 'like', $entered_name.'%')
                        ->orwhere('user_phone', 'like', $entered_name.'%')
                        
                        ->get();

        return $searchclass;
    }
}
