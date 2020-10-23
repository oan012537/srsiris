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

class UnitController extends Controller
{
    public function index(){
		$unit	= DB::table('unit')->get();
		return view('unit/index',['unit' => $unit]);
	}
	
	public function store(Request $request){
		$data = array(
			'unit_name'		=> $request->input('unit'),
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		);
		
		DB::table('unit')->insert($data);
		$data2 = array(
			'unitsub_name'	=> $request->input('unit'),
			'created_at'	=> new DateTime(),
			'updated_at'	=> new DateTime(),
		);
		DB::table('unitsub')->insert($data2);
		$unit = DB::table('unit')->get();
		$unitsub = DB::table('unitsub')->get();
		savelog('17','เพิ่มข้อมูลหน่วย '.$request->input('unit'));
		Session::flash('alert-insert','insert');
		return redirect('unit');
	}
	
	public function edit(Request $request){
		$results = DB::table('unit')->where('unit_id',$request->input('id'))->first();
		return Response::json($results);
	}
	
	public function update(Request $request){
		$data = array(
			'unit_name'		=> $request->input('unitedit'),
			'updated_at'		=> new DateTime(),
		);
		$unit = DB::table('unit')->where('unit_id',$request->input('unitidedit'))->first();
		savelog('17','แก้ไขข้อมูลหน่วยลำดับที่ '.$unit->unit_id.' จากชื่อ '.$unit->unit_name.' เป็นชื่อ '.$request->input('unitedit'));
		DB::table('unit')->where('unit_id',$request->input('unitidedit'))->update($data);
		Session::flash('alert-update','update');
		return redirect('unit');
	}
	
	public function queryunit(Request $request){
		$unit = DB::table('unit')->get();
		return Response::json($unit);
	}
	
	public function destroy($id){
		$unit = DB::table('unit')->where('unit_id',$id)->first();
		savelog('17','ลบข้อมูลหน่วยลำดับที่ '.$unit->unit_id.' ชื่อ '.$unit->unit_name);
		DB::table('unit')->where('unit_id',$id)->delete();
		Session::flash('alert-delete','delete');
		return redirect('unit');
	}
}
