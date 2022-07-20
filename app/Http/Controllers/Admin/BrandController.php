<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;
use DB;
use Image;
use File;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //read data method
    public function index(Request $request)
    {
    	if ($request->ajax()) {
    		$data = DB::table('brands')->get();


    			return DataTables::of($data)
    					->addIndexColumn()
    					->addColumn('action',function($row){
    						$actionbtn = '<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#editModel"><i class="fas fa-edit"></i></a>
                    	<a href="'.route('brand.delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i></a>';

                    	return $actionbtn;
    					})

    					->rawColumns(['action'])
    					->make(true);

    	}
    	
    	return view('admin.category.brand.index');
    }

    //data insert method
    public function store(Request $request)
    {
    	//Query builder
    	$validated = $request->validate([
        'brand_name' => 'required|unique:brands|max:55',
    	]);

    	$slug = Str::slug($request->brand_name, '-');
    	$data = array();
    	$data['brand_name'] = $request->brand_name;
    	$data['brand_slug'] = Str::slug($request->brand_name, '-');
		$data['front_page'] = $request->front_page;
    	//working with image
    	$photo = $request->brand_logo;
    	$photoname = $slug.'.'.$photo->getClientOriginalExtension();
    	// $photo->move('public/files/brand',$photoname);  //without intervention
    	Image::make($photo)->resize(240,120)->save('public/files/brand/'.$photoname); //image with intervention
    	$data['brand_logo'] = 'public/files/brand/'.$photoname;

    	DB::table('brands')->insert($data);

    	$notification=array('message' => 'Brand Inserted Successfully', 'alert-type'=>'success' );
        return redirect()->back()->with($notification);
    }

     //delete childcategory
    public function destroy($id)
    {
    	//query builder
    	$data = DB::table('brands')->where('id',$id)->first();
    	$image = $data->brand_logo;
    	if (File::exists($image)) {
    		unlink($image);
    	}
    	DB::table('brands')->where('id',$id)->delete();

        $notification=array('message' => 'Brand Deleted Successfully', 'alert-type'=>'success' );
        return redirect()->back()->with($notification);

    }

    //edit method
    public function edit($id)
    {
    	//query builder
    	$data = DB::table('brands')->where('id',$id)->first();

    	return view('admin.category.brand.edit',compact('data'));
    }

    //data upate method
    public function update(Request $request)
    {
    	//Query builder
    	$slug = Str::slug($request->brand_name, '-');
    	$data = array();
    	$data['brand_name'] = $request->brand_name;
    	$data['brand_slug'] = Str::slug($request->brand_name, '-');
		$data['front_page'] = $request->front_page;
    	if ($request->brand_logo) {
    		if (File::exists($request->old_logo)) {
    			unlink($request->old_logo);
    	}
    		//working with image
	    	$photo = $request->brand_logo;
	    	$photoname = $slug.'.'.$photo->getClientOriginalExtension();
	    	// $photo->move('public/files/brand',$photoname);  //without intervention
	    	Image::make($photo)->resize(240,120)->save('public/files/brand/'.$photoname); //image with intervention
	    	$data['brand_logo'] = 'public/files/brand/'.$photoname;

	    	DB::table('brands')->where('id',$request->id)->update($data);

	    	$notification=array('message' => 'Brand Inserted Successfully', 'alert-type'=>'success' );
        	return redirect()->back()->with($notification);
    	}else{
    		$data['brand_logo'] = $request->old_logo;

	    	DB::table('brands')->where('id',$request->id)->update($data);
	    	
	    	$notification=array('message' => 'Brand Inserted Successfully', 'alert-type'=>'success' );
        	return redirect()->back()->with($notification);
    	}
    	
    }

}
