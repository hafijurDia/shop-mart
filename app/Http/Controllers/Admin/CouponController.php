<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // coupon read method
    public function index(Request $request)
    {
        if ($request->ajax()) {
    		$data = DB::table('coupons')->latest()->get();
    			return DataTables::of($data)
    					->addIndexColumn()
    					->addColumn('action',function($row){

    						$actionbtn = '<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#editModel"><i class="fas fa-edit"></i></a>
                    	<a href="'.route('coupon.delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete_coupn"><i class="fas fa-trash"></i></a>';

                    	return $actionbtn;
    					})

    					->rawColumns(['action'])
    					->make(true);

    	}
    	
    	return view('admin.offer.coupon.index');
    }

    //store coupon method
    public function store(Request $request)
    {
        //another way of data insert way
        $data = array(
            'coupon_code' => $request->coupon_code,
            'type' => $request->type,
            'coupon_amount' => $request->coupon_amount,
            'valid_date' => $request->valid_date,
            'status' => $request->status,
        );
        DB::table('coupons')->insert($data);
        return response()->json('Coupon Stored!');
    }

    //edit method
    public function edit($id)
    {
    	//query builder
    	$data = DB::table('coupons')->where('id',$id)->first();

    	return view('admin.offer.coupon.edit',compact('data'));
    }

    //store coupon method
    public function update(Request $request)
    {
        //another way of data insert way
        $data = array(
            'coupon_code' => $request->coupon_code,
            'type' => $request->type,
            'coupon_amount' => $request->coupon_amount,
            'valid_date' => $request->valid_date,
            'status' => $request->status,
        );
        DB::table('coupons')->where('id',$request->id)->update($data);
        return response()->json('Coupon Update!');
    }

    //delete warehouse
    public function destroy($id)
    {
    	//query builder
    	
    	DB::table('coupons')->where('id',$id)->delete();
        return response()->json('Coupon Deleted!');

       

    }
}
