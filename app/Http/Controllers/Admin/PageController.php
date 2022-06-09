<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //index method
    public function index()
    {
    	$data = DB::table('pages')->latest()->get();
    	return view('admin.setting.page.index',compact('data'));
    }

    // page create method
    public function create()
    {
    	return view('admin.setting.page.create');
    }

    // page store method
    public function store(Request $request)
    {
    	$data=array();
		$data['page_position'] = $request->page_position;
		$data['page_name'] = $request->page_name;
		$data['page_title'] = $request->page_title;
		$data['page_slug'] = Str::slug($request->page_name, '-');
		$data['page_description'] = $request->page_description;
		DB::table('pages')->insert($data);

    	$notification=array('message' => 'Page Create Successfully', 'alert-type'=>'success' );
        return redirect()->back()->with($notification);

    }

    //delete page
    public function destroy($id)
    {
    	//query builder
    	DB::table('pages')->where('id',$id)->delete();
        $notification=array('message' => 'Page Deleted Successfully', 'alert-type'=>'success' );
        return redirect()->back()->with($notification);

    }

    //edit page
    public function edit($id)
    {
    	//query builder
    	$data = DB::table('pages')->where('id',$id)->first();
        return view('admin.setting.page.edit',compact('data'));
    	

    }

    //update function
    public function colorupdate(Request $request,$id)
    {
    	$data=array();
		$data['page_position'] = $request->page_position;
		$data['page_name'] = $request->page_name;
		$data['page_title'] = $request->page_title;
		$data['page_slug'] = Str::slug($request->page_name, '-');
		$data['page_description'] = $request->page_description;
		DB::table('pages')->where('id',$id)->update($data);

        $notification=array('message' => 'Page updated Successfully', 'alert-type'=>'success' );
        return redirect()->back()->with($notification);
    }
}
