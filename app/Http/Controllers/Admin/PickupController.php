<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;

class PickupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //data read method
    public function index(Request $request)
    {
        if ($request->ajax()) {
    		$data = DB::table('pickpoints')->latest()->get();
    			return DataTables::of($data)
    					->addIndexColumn()
    					->addColumn('action',function($row){

    						$actionbtn = '<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#editModel"><i class="fas fa-edit"></i></a>
                    	<a href="'.route('pickpoint.delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete_pickpoint"><i class="fas fa-trash"></i></a>';

                    	return $actionbtn;
    					})

    					->rawColumns(['action'])
    					->make(true);

    	}
    	
    	return view('admin.pickup-point.index');
    }

    //store coupon method
    public function store(Request $request)
    {
        //another way of data insert way
        $data = array(
            'pickup_point_name' => $request->pickup_point_name,
            'pickup_point_address' => $request->pickup_point_address,
            'pickup_point_phone' => $request->pickup_point_phone,
            'pickup_point_phone_two' => $request->pickup_point_phone_two,
        );
        DB::table('pickpoints')->insert($data);
        return response()->json('Pickup Point Stored!');
    }

    //edit method
    public function edit($id)
    {
    	//query builder
    	$data = DB::table('pickpoints')->where('id',$id)->first();

    	return view('admin.pickup-point.edit',compact('data'));
    }

    //store coupon method
    public function update(Request $request)
    {
        //another way of data insert way
        $data = array(
            'pickup_point_name' => $request->pickup_point_name,
            'pickup_point_address' => $request->pickup_point_address,
            'pickup_point_phone' => $request->pickup_point_phone,
            'pickup_point_phone_two' => $request->pickup_point_phone_two,
        );
        DB::table('pickpoints')->where('id',$request->id)->update($data);
        return response()->json('Pickup Point Update!');
    }


    //delete warehouse
    public function destroy($id)
    {
    	//query builder
    	DB::table('pickpoints')->where('id',$id)->delete();
        return response()->json('Pickup Point Deleted!');

       

    }

}
