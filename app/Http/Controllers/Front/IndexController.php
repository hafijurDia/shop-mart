<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use DB;


class IndexController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->reflash();
        $category = Category::orderBy('category_name','ASC')->get();
        $brand = DB::table('brands')->inRandomOrder()->limit(12)->get();
        //query
        // $bannerproduct = DB::table('products')->where('slider_product',1)->latest()->first();
        //eloqaunt
        $bannerproduct = Product::where('status',1)->where('slider_product',1)->latest()->first();
        $featuredproduct = Product::where('status',1)->where('featured',1)->orderBy('id','DESC')->limit(16)->get();
        $todaydeal = Product::where('status',1)->where('today_deal',1)->orderBy('id','DESC')->limit(6)->get();
        $popularproduct = Product::where('status',1)->where('featured',1)->orderBy('product_view','DESC')->limit(16)->get();
        $randomproduct = Product::where('status',1)->inRandomOrder()->limit(16)->get();
        $trendyproduct = Product::where('status',1)->where('trendy',1)->orderBy('id','DESC')->limit(9)->get();
        $websiteeeview = DB::table('wbreviews')->where('status',1)->orderBy('id','DESC')->limit(6)->get();
        //home category
        $home_category = DB::table('categories')->where('home_page',1)->orderBy('category_name','ASC')->get();
        return view('frontend.index',compact('category','bannerproduct','featuredproduct','popularproduct','trendyproduct','home_category','brand','randomproduct','todaydeal','websiteeeview'));
    }

    public function productdetails($slug)
    {
        $product = Product::where('slug',$slug)->first();
            Product::where('slug',$slug)->increment('product_view');
        $category = Category::orderBy('category_name','ASC')->get();
        $related_product = DB::table('products')->where('subcategory_id',$product->subcategory_id)->orderBy('id','DESC')->take(10)->get();
        $product_review = ProductReview::where('product_id',$product->id)->orderBy('id','DESC')->take(6)->get();
        //$product = DB::table('products')->where('slug',$slug)->first();
        return view('frontend.product.product_details',compact('product','category','related_product','product_review'));
        
    }

    //product quick view
    public function productQuickView($id)
    {
        $product = Product::where('id',$id)->first();
        return view('frontend.product.quick_view',compact('product'));

    }

    //categorywise product
    public function categorywiseProduct($id)
    {
        $categorypage=DB::table('categories')->where('id',$id)->first();
        $subcategory = DB::table('subcategories')->where('category_id',$id)->get();
        $brand = DB::table('brands')->get();
        $product = DB::table('products')->where('category_id',$id)->paginate();
        return view('frontend.product.category_products',compact('subcategory','brand','product','categorypage'));

    }

    //subcategorywise product
    public function SubcategoryWiseProduct($id)
    {
        $subcategory=DB::table('subcategories')->where('id',$id)->first();
        $childcategories=DB::table('childcategories')->where('subcategory_id',$id)->get();
        $brand=DB::table('brands')->get();
        $product=DB::table('products')->where('subcategory_id',$id)->paginate(60);
        $random_product=Product::where('status',1)->inRandomOrder()->limit(16)->get();
        return view('frontend.product.subcategory_product',compact('childcategories','brand','product','random_product','subcategory'));
    }

    //childcategory product
    public function ChildcategoryWiseProduct($id)
    {
        $childcategory=DB::table('childcategories')->where('id',$id)->first();
        $categories=DB::table('categories')->get();
        $brand=DB::table('brands')->get();
        $product=DB::table('products')->where('childcategory_id',$id)->paginate(60);
        $random_product=Product::where('status',1)->inRandomOrder()->limit(16)->get();
        return view('frontend.product.childcategory_product',compact('categories','brand','product','random_product','childcategory'));
    }

    //brandwise product
    public function BrandWiseProduct($id)
    {
        $brands=DB::table('brands')->where('id',$id)->first();
        $categories=DB::table('categories')->get();
        $brands=DB::table('brands')->get();
        $products=DB::table('products')->where('brand_id',$id)->paginate(60);
        $random_product=Product::where('status',1)->inRandomOrder()->limit(16)->get();
        return view('frontend.product.brandwise_product',compact('categories','brands','products','random_product','brands'));
    }

    //view footer custom page
    public function viewPage($page_slug)
    {
        $page = DB::table('pages')->where('page_slug',$page_slug)->first();
        return view('frontend.page',compact('page'));
    }

    //newsletter
     public function storeNewsletter(Request $request)
    {
        $email = $request->email;
        $check = Db::table('newsletters')->where('email',$email)->first();
        if ($check) {
           return response()->json('Email Already Exist');
        }else{
            $data = array();
            $data['email'] = $request->email;
            DB::table('newsletters')->insert($data);
            return response()->json('Thanks for subscribing us!');
        }
    }
    
}
