<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;
class WarehouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if ($request->ajax()) {
    		$data = DB::table('warehouses')->latest()->get();


    			return DataTables::of($data)
    					->addIndexColumn()
    					->addColumn('action',function($row){

    						$actionbtn = '<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#editModel"><i class="fas fa-edit"></i></a>
                    	<a href="'.route('warehouse.delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i></a>';

                    	return $actionbtn;
    					})

    					->rawColumns(['action'])
    					->make(true);

    	}
    	
    	return view('admin.category.warehouse.index');
    }


	//store method
	public function store(Request $request)
	{
		//Query builder
    	$validated = $request->validate([
			'warehouse_name' => 'required|unique:warehouses|max:55',
			]);

			$data = array();
			$data['warehouse_name'] = $request->warehouse_name;
			$data['warehouse_address'] = $request->warehouse_address;
			$data['warehouse_phone'] = $request->warehouse_phone;
			DB::table('warehouses')->insert($data);

    		$notification=array('message' => 'Warehouse Added', 'alert-type'=>'success' );
        	return redirect()->back()->with($notification);
			
	}
	//delete warehouse
    public function destroy($id)
    {
    	//query builder
    	$data = DB::table('warehouses')->where('id',$id)->first();
    	DB::table('warehouses')->where('id',$id)->delete();

        $notification=array('message' => 'Warehouse Removed', 'alert-type'=>'success' );
        return redirect()->back()->with($notification);

    }
	//edit method
    public function edit($id)
    {
    	//query builder
    	$data = DB::table('warehouses')->where('id',$id)->first();

    	return view('admin.category.warehouse.edit',compact('data'));
    }
	
	//update method
	public function update(Request $request,$id)
	{
		//Query builder
			$data = array();
			$data['warehouse_name'] = $request->warehouse_name;
			$data['warehouse_address'] = $request->warehouse_address;
			$data['warehouse_phone'] = $request->warehouse_phone;

			DB::table('warehouses')->where('id',$id)->update($data);
    		$notification=array('message' => 'Warehouse Updated', 'alert-type'=>'success' );
        	return redirect()->back()->with($notification);
			
	}
}
