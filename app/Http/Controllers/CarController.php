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
use App\car;

class CarController extends Controller
{
    public function index(){
		return view('car/index');
	}
	
	public function datatable(){
		$car = car::orderBy('car_id','asc')->get();
		$sQuery	= Datatables::of($car);
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function viewcreate(){
        return view('car/create');
    }
    
    public function viewupdate($id){
        $data = car::where('car_id',$id)->first();
        return view('car/update')->with('data',$data);
    }
    
    public function subpage($id){
        return view('car/product')->with('supplier_id',$id);
    }
    
    public function createdata(Request $request){
        $save = new car;
        $save->car_text            = $request->input('text');
        $save->save();
        savelog('15','เพิ่มข้อมูลรถยนต์ '.$request->input('text'));
        Session::flash('alert-insert','insert');
		return redirect('car');
    }
    
    public function updatedata(Request $request){
        $car = car::find($request->input('id'));
        $save = car::where('car_id',$request->input('id'))->update([
            'car_text'            => $request->input('text'),
            'car_status'          => $request->input('status')
        ]);
        savelog('15','แก้ไขข้อมูลพนักงานขับรถชื่อลำดับที่'.$car->car_id.' จากชื่อ '.$car->car_text.' เป็นชื่อ '.$request->input('text'));
        Session::flash('alert-update','update');
		return redirect('car');
    }
    
    public function deldata($id){
        if(!empty($id)){
            $car = car::find($id);
            car::where('car_id',$id)->update(['car_status'=>'0']);
            savelog('15','ยกเลิกข้อมูลพนักงานขับรถชื่อลำดับที่ '.$car->car_id.' ชื่อ '.$car->car_text);
            Session::flash('alert-delete','delete');
        }
		return redirect('car');
    }
}
