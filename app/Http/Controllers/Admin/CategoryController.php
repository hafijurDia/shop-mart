<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Category;
use Illuminate\Support\Str;
use Image;
use File;
use DataTables;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //all category showing method
    public function index()
    {
    	//query builder
    	//$data=DB::table('categories')->get();

    	//eloquent orm
    	$data=Category::all();

    	return view('admin.category.category.index',compact('data'));
   
    	
    }

    //category input
    public function store(Request $request)
    {
    	$validated = $request->validate([
        'category_name' => 'required|unique:categories|max:55',
		'icon' => 'required',
    	]);
    	//query builder
    	// $data =array();
    	// $data['category_name'] = $request->category_name;
    	// $data['category_slug'] = Str::slug($request->category_name, '-');
    	// DB::table('categories')->insert($data);

    	//Eloquant  ORM
    	$slug=Str::slug($request->category_name, '-');
          $photo=$request->icon;
          $photoname=$slug.'.'.$photo->getClientOriginalExtension();
          Image::make($photo)->resize(32,32)->save('public/files/category/'.$photoname);  //image intervention
        	//Eloquent ORM
        	Category::insert([
        		'category_name'=> $request->category_name,
        		'category_slug'=> $slug,
                'home_page'=> $request->home_page,
                'cat_icon'=> 'public/files/category/'.$photoname,
        	]);

    	$notification=array('messege' => 'Category Inserted!', 'alert-type' => 'success');
    	return redirect()->back()->with($notification);

    }

 //edit method
 public function edit($id)
 {
     // $data=DB::table('categories')->where('id',$id)->first();
     $data=Category::findorfail($id);
     return view('admin.category.category.edit',compact('data'));
     //return response()->json($data);
 }



    //Update Method
    public function update(Request $request)
	{

		$slug=Str::slug($request->category_name, '-');
        $data=array();
        $data['category_name']=$request->category_name;
        $data['category_slug']=$slug;
        $data['home_page']=$request->home_page;
        if ($request->cat_icon) {
              if (File::exists($request->oldcat_icon)) {
                     unlink($request->oldcat_icon);
                }
               
                $photo=$request->cat_icon;
                $photoname=$slug.'.'.$photo->getClientOriginalExtension();
                Image::make($photo)->resize(32,32)->save('public/files/category/'.$photoname);; 
              $data['cat_icon']='public/files/category/'.$photoname; 
              DB::table('categories')->where('id',$request->id)->update($data); 
              $notification=array('messege' => 'Category Update!', 'alert-type' => 'success');
              return redirect()->back()->with($notification);
        }else{
          $data['cat_icon']=$request->oldcat_icon;   
          DB::table('categories')->where('id',$request->id)->update($data); 
          $notification=array('messege' => 'Category Update!', 'alert-type' => 'success');
          return redirect()->back()->with($notification);
        }

    }

    //delete category
    public function destroy($id)
    {
    	//query builder
    	// DB::table('categories')->where('id',$id)->delete();
    	

        //Eloquant  ORM
        $category = Category::find($id);
        $category->delete();
        $notification=array('message' => 'Category Deleted Successfully', 'alert-type'=>'success' );
        return redirect()->back()->with($notification);

    }


	//get child category 
	public function GetChildCategory($id)
	{
		$data = DB::table('childcategories')->where('subcategory_id',$id)->get();
		return response()->json($data);
	}
}
