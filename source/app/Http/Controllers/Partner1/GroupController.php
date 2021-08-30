<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class GroupController extends Controller
{
    public function adminGroup(Request $request)
    {
        $title = "Group";
        
    	$adminGroup = DB::table('tbl_group')
    			         ->get();

        return view('admin.group.index',compact("adminGroup", "title"));
    }

    public function adminAddGroup(Request $request)
    {
        $title = "Add Group";
        
        $app = DB::table('tbl_app')
                ->get();

        return view('admin.group.add', compact('app', "title"));
    }

    public function adminAddNewGroup(Request $request)
    {
        return redirect()->back();
        
        $this->validate(
            $request,
                [
                    'group_name' => 'required',
                    'group_image' => 'required|mimes:jpeg,png,jpg|max:400',
                    'group_app' => 'required',
                ],
                [
                    'group_name.required' => 'Enter group name.',
                    'group_image.required' => 'Choose group icon.',
                    'group_app.required' => 'select group app.',
                ]
        );

        $group_name = $request->group_name;
        $group_app = json_encode($request->group_app);
        $created_at = Carbon::now();
        $updated_at = Carbon::now();

        $date = date('d-m-Y');

        if($request->hasFile('group_image')){
            $group_image = $request->group_image;
            $fileName = date('dmyhisa').'-'.$group_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $group_image->move('images/group/'.$date.'/', $fileName);
            $group_image = 'images/group/'.$date.'/'.$fileName;
        }
        else{
            $group_image = 'N/A';
        }

        $insertGroup = DB::table('tbl_group')
                            ->insert([
                                'group_name'=>$group_name,
                                'group_image'=>$group_image,
                                'group_app'=>$group_app,
                                'created_at'=>$created_at,
                                'updated_at'=>$updated_at
                            ]);
        
        if($insertGroup){
            return redirect()->back()->withErrors('group added successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function adminEditGroup(Request $request)
    {
        $title = "Edit Group";
        
    	$id = $request->id;

    	$group = DB::table('tbl_group')
        	          ->where('id', $id)
        			  ->first();

        $app = DB::table('tbl_app')
                ->get();

        return view('admin.group.edit',compact("group", "app", "title"));
    }

    public function adminUpdateGroup(Request $request)
    {
        return redirect()->back();
        
        $this->validate(
            $request,
                [
                    'group_name' => 'required',
                    'group_image' => 'mimes:jpeg,png,jpg|max:400',
                    'group_app' => 'required',
                ],
                [
                    'group_name.required' => 'Enter group name.',
                    'group_image.required' => 'Choose group icon.',
                    'group_app.required' => 'select group app.',
                ]
        );

    	$id = $request->id;
        $group_name = $request->group_name;
        $group_app = json_encode($request->group_app);
        $updated_at = Carbon::now();
        $date = date('d-m-Y');

        $getGroup = DB::table('tbl_group')
                    ->where('id',$id)
                    ->first();

        $image = $getGroup->group_image;

        if($request->hasFile('group_image')){
            if(file_exists($image)){
                unlink($image);
            }
            $group_image = $request->group_image;
            $fileName = date('dmyhisa').'-'.$group_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $group_image->move('images/group/'.$date.'/', $fileName);
            $group_image = 'images/group/'.$date.'/'.$fileName;
        }
        else{
            $group_image = $getGroup->group_image;
        }
        
        $updateGroup = DB::table('tbl_group')
                            ->where('id', $id)
                            ->update([
                                'group_name'=>$group_name,
                                'group_image'=>$group_image,
                                'group_app'=>$group_app,
                                'updated_at'=>$updated_at
                            ]);
        
        if($updateGroup){
            return redirect()->back()->withErrors('group updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function adminGroupDelete(Request $request)
    {
        return redirect()->back();
        
        $id = $request->id;

        $getGroupApp = DB::table('tbl_group')
                        ->where('id', $id)
                        ->first();

        $image = $getGroupApp->group_image;

        $deleteGroupApp = DB::table('tbl_group')
                                ->where('id', $id)
                                ->delete();

        if($deleteGroupApp){
            if(file_exists($image)){
                unlink($image);
            }
            return redirect()->back()->withErrors('Group app deleted successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
}
