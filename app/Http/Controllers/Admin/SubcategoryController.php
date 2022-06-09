<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //index data for read data
    public function index(){
    	$data=DB::table('subcategories')->leftJoin('categories','subcategories.category_id','categories.id')->select('subcategories.*','categories.category_name')->get();
    	//Eloquent ORM
    	$category = Category::all();

    	// //query builder
    	// $category = DB::table('categories')-get();

    	return view('admin.category.subcategory.index',compact('data','category'));
    }

    //category input
    public function store(Request $request)
    {
    	$validated = $request->validate([
        'subcategory_name' => 'required|max:55',
    	]);

    	//query builder
    	// $data =array();
    	// $data['category_id'] = $request->category_id;
    	// $data['subcategory_name'] = $request->subcategory_name;
    	// $data['subcat_slug'] = Str::slug($request->subcategory_name, '-');
    	// DB::table('subcategories')->insert($data);


    	//Eloquant  ORM
    	Subcategory::insert([

    		'category_id' => $request->category_id,
    		'subcategory_name' => $request->subcategory_name,
    		'subcat_slug' => Str::slug($request->subcategory_name, '-')

    	]);
    	$notification=array('message' => 'Sub-Category Inserted Successfully', 'alert-type'=>'success' );
        return redirect()->back()->with($notification);
    }

     //edit method
    public function edit($id)
    {
    	//query builder
    	// $data = DB::table('subcategories')->where('id',$id)->first();
    	// $category = DB::table('categories')->get();

    	//Eloquant  ORM
    	$data = Subcategory::find($id);
    	$category = Category::all();
    	
    	return view('admin.category.subcategory.edit',compact('data','category'));
    }


    //Update Method
    public function update(Request $request){

    	//Query builder
    	$validated = $request->validate([
        'subcategory_name' => 'required|max:55',
    	]);

    	
    	//query builder
    	
    	// $data =array();
    	// $data['category_id'] = $request->category_id;
    	// $data['subcategory_name'] = $request->subcategory_name;
    	// $data['subcategory_slug'] = Str::slug($request->subcategory_name, '-');
    	// DB::table('subcategories')->where('id',$id)->update($data);


    	//Eloquent ORM
    	$subcategory = Subcategory::where('id',$request->id)->first();
    	$subcategory->update([
    		'category_id' => $request->category_id,
    		'subcategory_name' => $request->subcategory_name,
    		'subcat_slug' => Str::slug($request->subcategory_name, '-')
    		]);


    	$notification=array('message' => 'Sub-category Updated Successfully', 'alert-type'=>'success' );
        return redirect()->back()->with($notification);

    }


    //delete category
    public function destroy($id)
    {
    	//query builder
    	// DB::table('subcategories')->where('id',$id)->delete();
    	

        //Eloquant  ORM
        $subcategory = SubCategory::find($id);
        $subcategory->delete();
        $notification=array('message' => 'Sub-category Deleted Successfully', 'alert-type'=>'success' );
        return redirect()->back()->with($notification);

    }
}
