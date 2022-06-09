<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Cart;
use DB;
use Session;

class CheckoutController extends Controller
{


    public function checkout(Request $request)
    {
        
        if (!Auth::check()) {
            $notification=array('message' => 'Login Your Account!', 'alert-type'=>'error' );
            return redirect()->back()->with($notification);
        }
        $content = Cart::content();
        return view('frontend.cart.checkout',compact('content'));
    }

    //coupon apply
    public function couponApply(Request $request)
    {
        
        $check = DB::table('coupons')->where('coupon_code',$request->coupon)->first();
        if ($check) {
           
            if (date('Y-m-d', strtotime(date('Y-m-d'))) <= date('Y-m-d', strtotime($check->valid_date))) {
                session::put('coupon',[
                   'name'=>$check->coupon_code,
                   'discount'=>$check->coupon_amount,
                   'after_discount'=>str_replace(',', '', Cart::subtotal())-$check->coupon_amount,
                ]);

               $notification=array('message' => 'Coupon applied!', 'alert-type'=>'success' );
                return redirect()->back()->with($notification);
                
            }else{
                $notification=array('message' => 'Expired coupon code!', 'alert-type'=>'error' );
                return redirect()->back()->with($notification);
            }
        }else{
            $notification=array('message' => 'Coupon code invalid!', 'alert-type'=>'error' );
            return redirect()->back()->with($notification);
        }
    }

    //remove coupon 
    public function couponRemove()
    {
        session::forget('coupon');

        $notification=array('message' => 'Coupon removed successfully!', 'alert-type'=>'success' );
        return redirect()->back()->with($notification);
    }
}
