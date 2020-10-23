<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\area;
use Session;
use Response;
use DB;
class AreaController extends Controller
{
	public function index(){
		$area = area::all();
		$dataaccount	= DB::table('setheadbill_account')->get();
		return view('area.index',['area'=>$area,'dataaccount'=>$dataaccount]);
	}

	public function store(Request $request){
		$area = new area;
		$area->area_name = $request->area;
		$area->area_accountid = $request->accountarea;
		$area->save();
		savelog('16','เพิ่มข้อมูลพื้นที่ '.$request->input('area'));
		Session::flash('alert-insert','insert');
		return redirect('area');
	}

	public function edit(Request $request){
		$results = area::find($request->id);
		return Response::json($results);
	}
	
	public function update(Request $request){
		$area = area::find($request->areaidedit);
		savelog('16','แก้ไขข้อมูลพื้นที่ลำดับที่ '.$area->area_id.' จากชื่อ '.$area->area_name.' เป็นชื่อ '.$request->input('areaedit'));
		$area->area_name = $request->areaedit;
		$area->area_accountid = $request->accountareaedit;
		$area->save();

		Session::flash('alert-update','update');
		return redirect('area');
	}

	public function destroy($id){
		$area = area::find($id);
		savelog('16','ลบข้อมูลพื้นที่ลำดับที่ '.$area->area_id.' ชื่อ '.$area->area_name);
		$area->delete();
		Session::flash('alert-delete','delete');
		return redirect('area');
	}
}
