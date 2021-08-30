<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class AboutController extends Controller
{
    public function aboutus(Request $request)
        {
          $admin_email=Session::get('admin');
          $about = DB::table('booking')
                        ->get();
       
        return view('admin.index',compact("admin_email","about"));
    }
    
    
    public function addaboutus(Request $request)
        {
          $admin_email=Session::get('admin');
        return view('admin.aboutus.addaboutus',compact("admin_email"));
    }
    
  
    public function newaboutus(Request $request)
        {
             $this->validate(
            $request,
                [
                    'heading' => 'required',
                    'description' => 'required',
                    'investor_heading' => 'required',
                    'image' => 'required',
                ],
                [
                    'heading.required' => 'Enter Heading.',
                    'description.required' => 'Enter Description.',
                    'investor_heading.required' => 'Enter Investor Heading.',
                    'image.required' => 'Upload Investor Image.',
                ]
        );
                    $heading=$request->heading;
                    $description=$request->description;
                    $investor_heading=$request->investor_heading;
                    if($request->hasFile('image')){
            $image = $request->image;
            $fileName = date('dmyhisa').'-'.$image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $image->move('images/store/eventbanner/', $fileName);
            $image = 'images/store/eventbanner/'.$fileName;
        }
        else{
            $image = 'N/A';
        }
                    $insert = DB::table('aboutus')
                    ->insert(['heading'=>$heading,
                              'description'=>$description,
                              'investor_heading'=>$investor_heading,
                              'image'=>$image,
                             ]);
     
                        return redirect()->back()->withErrors('Added Successfully');

    }
    public function editaboutus(Request $request)
        {
          $admin_email=Session::get('admin');
          $id = $request->id;
          $about = DB::table('aboutus')
                            ->where('id',$id)
                             ->first(); 
          return view('admin.aboutus.editaboutus',compact("admin_email","about"));
       
    }
    
    public function updateaboutus(Request $request)
        {

             $this->validate(
            $request,
                [
                    'heading' => 'required',
                    'description' => 'required',
                    'investor_heading' => 'required',
                    'image' => 'required',
                ],
                [
                    'heading.required' => 'Enter Heading.',
                    'description.required' => 'Enter Description.',
                    'investor_heading.required' => 'Enter Investor Heading.',
                    'image.required' => 'Upload Investor Image.',
                ]
        );
        $id = $request->id;
        $heading=$request->heading;
        $description=$request->description;
        $investor_heading=$request->investor_heading;
        $image=$request->image;

        if($request->hasFile('image')){
            if(file_exists($image)){
                unlink($image);
            }
            $image = $request->image;
            $fileName = date('dmyhisa').'-'.$image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $image->move('images/store/eventbanner/', $fileName);
            $image = 'images/store/eventbanner/'.$fileName;
        }
        else{
            $image = $image;
        }
        $about = DB::table('aboutus')
                            ->where('id', $id)
                            ->update([
                                'id'=>$id,
                                'heading'=>$heading,
                                  'description'=>$description,
                                  'investor_heading'=>$investor_heading,
                                  'image'=>$image,
                                
                            ]);
        
        if($about){
            return redirect()->back()->withErrors('Updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
    }
    
        public function deleteaboutus(Request $request)
    {
        
        $id=$request->id;

        $about=DB::table('aboutus')
                ->where('id',$id)
                ->first();

    	$delete=DB::table('aboutus')->where('id',$request->id)->delete();
    	
    	
        if($delete)
        {
    
        return redirect()->back()->withErrors('delete successfully');

        }
        else
        {
           return redirect()->back()->withErrors('unsuccessfull delete'); 
        }

    }
        
    
    


}