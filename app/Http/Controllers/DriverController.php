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
use App\driver;
use Carbon\Carbon;

class DriverController extends Controller
{
    public function index(){
		return view('driver/index');
	}
	
	public function datatable(){
		$driver = driver::orderBy('driver_id','asc')->get();
		$sQuery	= Datatables::of($driver);
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function viewcreate(){
        return view('driver/create');
    }
    
    public function viewupdate($id){
        $data = driver::where('driver_id',$id)->first();
        return view('driver/update')->with('data',$data);
    }
    
    public function subpage($id){
        return view('driver/product')->with('driver_id',$id);
    }
    
    public function createdata(Request $request){
        $save = new driver;
        $save->driver_name          = $request->input('name');
        $save->driver_address       = $request->input('address');
        $save->driver_tel           = $request->input('tel');
        $save->driver_email         = $request->input('email');
        $save->driver_tax           = $request->input('tax');
        $save->driver_date          = $request->input('bdate');
        $save->driver_age           = $request->input('age');
        $save->driver_in            = $request->input('datein');
        $save->driver_carname       = $request->input('carname');
        $save->driver_cartext       = $request->input('cartext');
        $save->save();
        savelog('14','เพิ่มข้อมูลพนักงานขับรถชื่อ '.$request->input('name'));
        Session::flash('alert-insert','insert');
		return redirect('driver');
    }
    
    public function updatedata(Request $request){
        $age = Carbon::parse($request->input('bdate'))->age;
        $driver = driver::find($request->input('id'));
        $save = driver::where('driver_id',$request->input('id'))->update([
            'driver_name'          => $request->input('name'),
            'driver_address'       => $request->input('address'),
            'driver_tel'           => $request->input('tel'),
            'driver_email'         => $request->input('email'),
            'driver_tax'           => $request->input('tax'),
            'driver_date'          => $request->input('bdate'),
            'driver_age'           => $age,
            'driver_in'            => $request->input('datein'),
            'driver_status'        => $request->input('status'),
            'driver_carname'       => $request->input('carname'),
            'driver_cartext'       => $request->input('cartext')
        ]);

        savelog('14','แก้ไขข้อมูลพนักงานขับรถชื่อลำดับที่'.$driver->driver_id.' จากชื่อ '.$driver->driver_name.' เป็นชื่อ '.$request->input('name'));
        Session::flash('alert-update','update');
		return redirect('driver');
    }
    
    public function deldata($id){
        if(!empty($id)){
            $driver = driver::find($id);
            driver::where('driver_id',$id)->update(['driver_status'=>'0']);
            savelog('14','ยกเลิกข้อมูลพนักงานขับรถชื่อลำดับที่ '.$driver->driver_id.' ชื่อ '.$driver->driver_name);
            Session::flash('alert-delete','delete');
        }
		return redirect('driver');
    }
}
