<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Session;
use Response;
use Datatables;
use File;
use Folklore\Image\Facades\Image;
use App\supplier;

class SupplierController extends Controller
{
    public function index(){
		return view('supplier/index');
	}
	
	public function datatable(){
		$supplier = supplier::orderBy('supplier_name','asc')->get();
		
		$sQuery	= Datatables::of($supplier);
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function viewcreate(){
        return view('supplier/create');
    }
    
    public function viewupdate($id){
        $data = supplier::where('supplier_id',$id)->first();
        return view('supplier/update')->with('data',$data);
    }
    
    public function subpage($id){
        return view('supplier/product')->with('supplier_id',$id);
    }
    
    public function createdata(Request $request){
        $save = new supplier;
        $save->supplier_name            = $request->input('name');
        $save->supplier_tel             = $request->input('tel');
        $save->supplier_email           = $request->input('email');
        $save->supplier_tax             = $request->input('tax');
        $save->location                 = $request->input('location');
        $save->lat                      = $request->input('lat');
        $save->lng                      = $request->input('lng');
        $save->save();
        savelog('10','เพิ่มข้อมูลซัพพลายเออร์ชื่อ '.$request->input('name'));
        Session::flash('alert-insert','insert');
		return redirect('supplier');
    }
    
    public function updatedata(Request $request){
        $supplier = supplier::find($request->input('id'));
        savelog('10','แก้ไขข้อมูลซัพพลายเออร์ลำดับที่ '.$supplier->supplier_id.' จากชื่อ '.$supplier->supplier_name.' เป็นชื่อ '.$request->input('name'));
        $save = supplier::where('supplier_id',$request->input('id'))->update([
            'supplier_name'            => $request->input('name'),
            'supplier_tel'             => $request->input('tel'),
            'supplier_email'           => $request->input('email'),
            'supplier_tax'             => $request->input('tax'),
            'location'                 => $request->input('location'),
            'lat'                      => $request->input('lat'),
            'lng'                      => $request->input('lng')
        ]);
        
        Session::flash('alert-update','update');
		return redirect('supplier');
    }
    
    public function deldata($id){
        if(!empty($id)){
            $supplier = supplier::find($id);
            savelog('10','ลบข้อมูลซัพพลายเออร์ลำดับที่'.$supplier->supplier_id.' ชื่อ '.$supplier->supplier_name);

            // supplier::where('supplier_id',$id)->delete();
            $supplier->delete();
            Session::flash('alert-delete','delete');
        }
		return redirect('supplier');
    }
}
