<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;
use Auth;
use DB;
use Session;
use App\Models\Product;
use App\Models\Category;

class CartController extends Controller
{

    //
    public function addToCartQV(Request $request)
    {
        //3 way to queary
        // $product = DB::table('products')->where('id',$request->id)->fisrt();
        // $product = Product::where('id',$request->id)->fisrt();
        $product = Product::find($request->id);
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $request->qty,
            'price' => $request->price,
            'weight' => '1',
            'options' => ['size'=>$request->size,'color'=>$request->color,'thumbnail'=>$product->thumbnail],
        ]);

        return response()->json("Product Added in Cart!");
    }

    public function allCart()
    {
        $data  = array();
        $data['cart_qty'] = Cart::count();
        $data['cart_total'] = Cart::total();
        return response()->json($data);
    }

    //wishlist
	public function addWishList($id)
	{
        if (Auth::check()) {
            $check = DB::table('wishlists')->where('product_id',$id)->where('user_id',Auth::id())->first();
            if($check) {
                $notification=array('message' => 'You have already listed it on your wishlist iteam', 'alert-type'=>'error' );
                return redirect()->back()->with($notification);
            }else{
                $data = array();
                $data['product_id'] = $id;
                $data['user_id'] = Auth::id();
                $data['date'] = date('d, F Y');
                DB::table('wishlists')->insert($data);
                $notification=array('message' => 'Product added in wishlist', 'alert-type'=>'success' );
                return redirect()->back()->with($notification);
            }
        }
        $notification=array('message' => 'Login Your Account!', 'alert-type'=>'error' );
        return redirect()->back()->with($notification);

    }

    //mycart
    public function myCart()
    {
        $content = Cart::content();
        $category = Category::orderBy('category_name','ASC')->get();
        return view('frontend.cart.cart',compact('content','category'));
    }

    //remove cart item
    public function RemoveProduct($rowId)
    {
        Cart::remove($rowId);
        return response()->json('Success!');
        
    }

    //update cart item
    public function updateQty($rowId,$qty)
    {
        
        Cart::update($rowId, ['qty' => $qty]); // Will update the name
        return response()->json('Successfully Updated');
    }

    //update color item
    public function updateColor($rowId,$color)
    {
        $product = Cart::get($rowId);
        $thumbnail = $product->options->thumbnail;
        $size = $product->options->size;
        Cart::update($rowId, ['options' => ['color' => $color,'thumbnail'=> $thumbnail,'size'=>$size]]); // Will update the name
        return response()->json('Successfully Updated');
    }

      //update size item
      public function updateSize($rowId,$size)
      {
          $product = Cart::get($rowId);
          $thumbnail = $product->options->thumbnail;
          $color = $product->options->color;
          Cart::update($rowId, ['options' => ['size' => $size,'thumbnail'=> $thumbnail,'color'=>$color]]); // Will update the name
          return response()->json('Successfully Updated');
      }

      //cart item clear
      public function cartEmpty(Request $request)
      {
        Cart::destroy();
        
        $notification=array('message' => 'Cart item now clear', 'alert-type'=>'success' );
        return redirect()->to('/')->with($notification);
      }
      
      //Wishlist details page
       public function wishlist()
      {
          if (Auth::check()) {
            $category = Category::orderBy('category_name','ASC')->get();
              $whishlist = DB::table('wishlists')->leftJoin('products','wishlists.product_id','products.id')->select('products.name','products.thumbnail','products.slug','wishlists.*')->where('wishlists.user_id',Auth::id())->get();
              return view('frontend.cart.wishlist',compact('whishlist','category'));
          }
          $notification=array('message' => 'At first login Your Account!', 'alert-type'=>'error' );
            return redirect()->back()->with($notification);
      }

      //clear wishlist
      public function clearWishlist()
      {
          DB::table('wishlists')->where('user_id',Auth::id())->delete();
          $notification=array('message' => 'Wishlist items now clear', 'alert-type'=>'success' );
        return redirect()->to('/')->with($notification);
      }

      //single wishlist item delete
      public function deleteWishlist($id)
      {
        DB::table('wishlists')->where('id',$id)->delete();
        $notification=array('message' => 'Wishlist Deleted', 'alert-type'=>'success' );
      return redirect()->back()->with($notification);
      }

      //checkout
     
		
}
