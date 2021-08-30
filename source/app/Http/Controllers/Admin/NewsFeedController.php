<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class NewsFeedController extends Controller
{
    public function adminNewsFeed(Request $request)
    {
        $title = "Notice";
        
        $adminNewsFeed = DB::table('tbl_news_feed')
                            ->get();

        $result = array();
        $i = 0;

        foreach ($adminNewsFeed as $adminNewsFeeds) {
            array_push($result, $adminNewsFeeds);

            if($adminNewsFeeds->posted_by == 'admin'){
                $result[$i]->posted_by = 'admin';
            }
            else{
                $getSocietyAdmin = DB::table('tbl_society_admin')
                                    ->where('society_id', $adminNewsFeeds->posted_by)
                                    ->first();

                $getSociety = DB::table('tbl_society')
                                ->where('id', $adminNewsFeeds->posted_by)
                                ->first();

                $result[$i]->posted_by = $getSocietyAdmin->admin_name." (".$getSociety->society_name.")";
            }

            $i++;
        }

        return view('admin.feed.index',compact("adminNewsFeed", "title"));
    }

    public function adminNewsFeedAdd(Request $request)
    {
        $title = "Add Notice";

        return view('admin.feed.add', compact("title"));
    }

    public function adminNewsFeedAddNew(Request $request)
    {
       
        
        if($request->society_id == '' && $request->allSociety == ''){
            $this->validate(
                $request,
                    [
                        'society_id' => 'required',
                        'allSociety' => 'required',
                    ],
                    [
                        'society_id.required' => 'select society.',
                        'allSociety.required' => 'select society.',
                    ]
            );
        }

        $this->validate(
            $request,
                [
                    'feed_heading' => 'required',
                    'feed_description' => 'required',
                ],
                [
                    'feed_heading.required' => 'enter Notice heading.',
                    'feed_description.required' => 'enter Notice description.',
                ]
        );

        if($request->society_id == ''){
            $feed_society_id = 'all';
        }
        else{
            $feed_society_id = json_encode($request->society_id);
        }

        $feed_heading = $request->feed_heading;
        $feed_description = $request->feed_description;
        $posted_by = 'admin';
        $created_at = Carbon::now();
        $updated_at = Carbon::now();

        $insertNewsFeed = DB::table('tbl_news_feed')
                            ->insert([
                                'feed_heading'=>$feed_heading,
                                'feed_description'=>$feed_description,
                                'feed_society_id'=>$feed_society_id,
                                'posted_by'=>$posted_by,
                                'created_at'=>$created_at,
                                'updated_at'=>$updated_at
                            ]);
        
        if($insertNewsFeed){
            return redirect()->back()->withErrors('Notice added successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function adminNewsFeedEdit(Request $request)
    {
        $title = "Edit Notice";
        $id = $request->id;

        $adminNewsFeedEdit = DB::table('tbl_news_feed')
                                ->where('id', $id)
                                ->first();

        return view('admin.feed.edit', compact("title", "adminNewsFeedEdit"));
    }

    public function adminNewsFeedUpdate(Request $request)
    {
        
        
        if($request->society_id == '' && $request->allSociety == ''){
            $this->validate(
                $request,
                    [
                        'society_id' => 'required',
                        'allSociety' => 'required',
                    ],
                    [
                        'society_id.required' => 'select society.',
                        'allSociety.required' => 'select society.',
                    ]
            );
        }

        $this->validate(
            $request,
                [
                    'feed_heading' => 'required',
                    'feed_description' => 'required',
                ],
                [
                    'feed_heading.required' => 'enter Notice heading.',
                    'feed_description.required' => 'enter Notice description.',
                ]
        );

        if($request->society_id == ''){
            $feed_society_id = 'all';
        }
        else{
            $feed_society_id = json_encode($request->society_id);
        }

        $id = $request->id;
        $feed_heading = $request->feed_heading;
        $feed_description = $request->feed_description;
        $created_at = Carbon::now();

        $insertNewsFeed = DB::table('tbl_news_feed')
                            ->where('id', $id)
                            ->update([
                                'feed_heading'=>$feed_heading,
                                'feed_description'=>$feed_description,
                                'feed_society_id'=>$feed_society_id,
                                'created_at'=>$created_at,
                            ]);
        
        if($insertNewsFeed){
            return redirect()->back()->withErrors('Notice updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }

    public function adminNewsFeedDelete(Request $request)
    {
        
        
        $id = $request->id;

        $adminNewsFeedDelete = DB::table('tbl_news_feed')
                                    ->where('id', $id)
                                    ->delete();

        if($adminNewsFeedDelete){
            return redirect()->back()->withErrors('Notice deleted successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
}
