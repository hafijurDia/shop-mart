<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ColorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //color page method
    public function index()
    {
    	$data = DB::table('colors')->get();
    	return view('admin.category.color.index',compact('data'));
    }

    //data insert method
    public function store(Request $request)
    {
    	//Query builder
    	$validated = $request->validate([
        'color_name' => 'required|unique:colors|max:55',
    	]);

    	$data = array();
    	$data['color_name'] = $request->color_name;
    	$data['color_code'] = $request->color_code;

    	DB::table('colors')->insert($data);
    	$notification=array('message' => 'Color Inserted Successfully', 'alert-type'=>'success' );
        return redirect()->back()->with($notification);
    }

     public function destroy($id)
    {
    	//query builder
    	DB::table('colors')->where('id',$id)->delete();
        $notification=array('message' => 'Colors Deleted Successfully', 'alert-type'=>'success' );
        return redirect()->back()->with($notification);

    }

    //edit color
    public function edit($id)
    {
    	//query builder
    	$data = DB::table('colors')->where('id',$id)->first();
        return view('admin.category.color.edit',compact('data'));
    	

    }

    //color update method()
    public function colorUpdate(Request $request,$id)
    {
    
		$data = array();
    	$data['color_name'] = $request->color_name;
    	$data['color_code'] = $request->color_code;

		DB::table('colors')->where('id',$id)->update($data);
		$notification=array('message' => 'Color Successfully Updated', 'alert-type'=>'success' );
    	return redirect()->back()->with($notification);

    }
}
