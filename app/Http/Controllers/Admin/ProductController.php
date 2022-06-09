<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Auth;
use Image;
use File;
use DataTables;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Childcategory;
use App\Models\Brand;
use App\Models\Pickuppoint;
use App\Models\Warehouse;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $imageurl = 'public/files/product';

            $product = "";

            $query = DB::table('products')->leftJoin('categories','products.category_id','categories.id')
            ->leftJoin('subcategories','products.subcategory_id','subcategories.id')
            ->leftJoin('brands','products.brand_id','brands.id');

            if ($request->category_id) {
                $query->where('products.category_id',$request->category_id);
            }
            if ($request->brand_id) {
                $query->where('products.brand_id',$request->brand_id);
            }
            if ($request->warehouse) {
                $query->where('products.warehouse',$request->warehouse);
            }
            if ($request->status == 0) {
                $query->where('products.status',0);
            }
            if ($request->status == 1) {
                $query->where('products.status',1);
            }
            
            $product = $query->select('products.*','categories.category_name','subcategories.subcategory_name','brands.brand_name')
            ->get();

    		// $data = Product::latest()->get();
    			return DataTables::of($product)
    					->addIndexColumn()
                        ->editColumn('thumbnail',function($row) use($imageurl){
                            return '<img src="'.$imageurl.'/'.$row->thumbnail.'" height="30" width="30">';
                        })
    					// ->editColumn('category_name',function($row){
                        //     return $row->category->category_name;
                        // })
                        // ->editColumn('subcategory_name',function($row){
                        //     return $row->subcategory->subcategory_name;
                        // })
                        // ->editColumn('brand_name',function($row){
                        //     return $row->brand->brand_name;
                        // })
                        ->editColumn('featured',function($row){
                            if ($row->featured == 1) {
                                return '<a href="#" data-id="'.$row->id.'" class="deactive_featured"><i class="fas fa-thumbs-down text-danger"></i></a> <span class="badge badge-success">Active</span>';
                            }else{
                                return '<a href="#"  data-id="'.$row->id.'" class="active_featured"><i class="fas fa-thumbs-up text-success"></i></a> <span class="badge badge-danger">Deactive</span>';
                            }
                        })
                        ->editColumn('today_deal',function($row){
                            if ($row->today_deal == 1) {
                                return '<a href="#" data-id="'.$row->id.'" class="deactive_today_Deal"><i class="fas fa-thumbs-down text-danger"></i></a> <span class="badge badge-success">Active</span>';
                            }else{
                                return '<a href="#" data-id="'.$row->id.'" class="active_today_Deal"><i class="fas fa-thumbs-up text-success" ></i></a> <span class="badge badge-danger">Deactive</span>';
                            }
                        })
                        ->editColumn('status',function($row){
                            if ($row->status == 1) {
                                return '<a href="#" data-id="'.$row->id.'" class="deactive_status"><i class="fas fa-thumbs-down text-danger" ></i></a> <span class="badge badge-success">Active</span>';
                            }else{
                                return '<a href="#" data-id="'.$row->id.'" class="active_status"><i class="fas fa-thumbs-up text-success" ></i></a> <span class="badge badge-danger">Deactive</span>';
                            }
                        })
    					->addColumn('action',function($row){
    					$actionbtn = '<a href="'.route('product.edit',[$row->id]).'" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="#" class="btn btn-primary btn-sm edit"><i class="fas fa-eye"></i></a>
                    	<a href="'.route('product.delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete_product"><i class="fas fa-trash"></i></a>';

                    	return $actionbtn;
    					})

    					->rawColumns(['action','category_name','subcategory_name','brand_name','thumbnail','featured','today_deal','status'])
    					->make(true);

    	}
        $category = DB::table('categories')->get();
        $brand = DB::table('brands')->get();
        $warehouse = DB::table('warehouses')->get();

    	
    	return view('admin.product.index',compact('category','brand','warehouse'));

    }

    //not featured
    public function notfeatured($id)
    {
       $data = DB::table('products')->where('id',$id)->update(['featured'=>0]);
        return response()->json('Product not fetured');
    }
    //featured
    public function activefeatured($id)
    {
       $data = DB::table('products')->where('id',$id)->update(['featured'=>1]);
        return response()->json('Product fetured');
    }
    //not today deal 
    public function nottodaydeal($id)
    {
       $data = DB::table('products')->where('id',$id)->update(['today_deal'=>0]);
        return response()->json('Product removed from today deal ');
    }
    //Today deal
    public function activetodaydeal($id)
    {
       $data = DB::table('products')->where('id',$id)->update(['today_deal'=>1]);
        return response()->json('Product now in today deal');
    }
     //deactive product 
     public function notactive($id)
     {
        $data = DB::table('products')->where('id',$id)->update(['status'=>0]);
         return response()->json('Product status deactive');
     }
     //active product
     public function active($id)
     {
        $data = DB::table('products')->where('id',$id)->update(['status'=>1]);
         return response()->json('Product status active');
     }

    //product create method
    public function create()
    {
        $category = DB::table('categories')->get();  //Category::all();
        $brand = DB::table('brands')->get();  //Category::all();
        $pickuppoint = DB::table('pickpoints')->get();  //Category::all();
        $warehouse = DB::table('warehouses')->get();  //Category::all();

        return view('admin.product.create',compact('category','brand','pickuppoint','warehouse'));
    }

    //product store method()
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'code' => 'required|unique:products|max:55',
            'subcategory_id' => 'required',
            'brand_id' => 'required',
            'unit' => 'required',
            'color' => 'required',
            'selling_price' => 'required',
            'description' => 'required',
            ]);

        //subcategory call for category id
        $subcategory = DB::table('subcategories')->where('id',$request->subcategory_id)->first();
        $slug = Str::slug($request->name, '-');
       
        $data = array();
        $data['name'] = $request->name;
        $data['slug'] = Str::slug($request->name, '-');
        $data['category_id'] = $subcategory->category_id;
        $data['subcategory_id'] = $request->subcategory_id;
        $data['childcategory_id'] = $request->childcategory_id;
        $data['brand_id'] = $request->brand_id;
        $data['pickup_point_id'] = $request->pickup_point_id;
        $data['code'] = $request->code;
        $data['color'] = $request->color;
        $data['size'] = $request->size;
        $data['unit'] = $request->unit;
        $data['tags'] = $request->tags;
        $data['video'] = $request->video;
        $data['purchase_price'] = $request->purchase_price;
        $data['selling_price'] = $request->selling_price;
        $data['discount_price'] = $request->discount_price;
        $data['stock_quantity'] = $request->stock_quantity;
        $data['warehouse'] = $request->warehouse;
        $data['description'] = $request->description;
        $data['featured'] = $request->featured;
        $data['today_deal'] = $request->today_deal;
        $data['status'] = $request->status; 
        $data['trendy'] = $request->trendy; 
        $data['slider_product'] = $request->slider_product; 
        $data['cash_on_delivery'] = $request->cash_on_delivery; 
        $data['admin_id'] = Auth::id(); 
        $data['date'] = date('d-m-y'); 
        $data['month'] = date('F'); 

        //single thumbnail
        if ($request->thumbnail) {
            //working with image
            $thumbnail = $request->thumbnail;
            $thumbname = $slug.'.'.$thumbnail->getClientOriginalExtension();
            // $photo->move('public/files/brand',$photoname);  //without intervention
            Image::make($thumbnail)->resize(600,600)->save('public/files/product/'.$thumbname); //image with intervention
            $data['thumbnail'] = $thumbname;
        }

        //multiple images
        $images = array();
        if ($request->hasFile('images')) {
            foreach($request->file('images') as $key => $image){
                $imagename = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                Image::make($image)->resize(600,600)->save('public/files/product/'.$imagename); 
                array_push( $images,$imagename);
            }
            $data['images'] = json_encode($images);
        }

        DB::table('products')->insert($data);
        $notification=array('message' => 'Product Inserted Successfully', 'alert-type'=>'success' );
        return redirect()->back()->with($notification);
        
    }


    //edit product
    public function editprodduct($id)
    {
        $product = DB::table('products')->where('id',$id)->first();
        $warehouse = DB::table('products')->where('id',$id)->first();
        $category = Category::all();
        $subcategory = Subcategory::all();
        $childcategory=Childcategory::all();
        $brand = Brand::all();
        $pickuppoint = Pickuppoint::all();
        $warehouse = Warehouse::all();
        
        

        return view('admin.product.edit',compact('product','category','subcategory','childcategory','brand','pickuppoint','warehouse'));
    }

    //delete warehouse
    public function destroy($id)
    {
    	//query builder
    	DB::table('products')->where('id',$id)->delete();
        return response()->json('Product Deleted!');
    }
}
