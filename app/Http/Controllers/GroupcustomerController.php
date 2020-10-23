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

class GroupcustomerController extends Controller
{
    public function index(){
		return view('groupcustomer/index');
	}
	
	public function datatable(){
		$groupcustomer = DB::table('groupcustomer')->get();
		
		$sQuery	= Datatables::of($groupcustomer);
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function create(){
		return view('groupcustomer/create');
	}
	
	public function store(Request $request){
		$data = [
			'groupcustomer_text'		=> $request->input('name'),
			'groupcustomer_status'		=> $request->input('status'),
			'groupcustomer_comment'		=> !empty($request->input('note'))?$request->input('note'):'',
			'created_at'				=> new DateTime(),
			'updated_at'				=> new DateTime(),
		];
		// dd($data);
		DB::table('groupcustomer')->insert($data);
		Session::flash('alert-insert','insert');
		return redirect('groupcustomer');
	}
	
	public function edit($id){
		$groupcustomer 	= DB::table('groupcustomer')->where('groupcustomer_id',$id)->first();
		return view('groupcustomer/update',['groupcustomer' => $groupcustomer]);
	}
	
	public function update(Request $request){
		$data = [
			'groupcustomer_text'		=> $request->input('name'),
			'groupcustomer_status'		=> $request->input('status'),
			'groupcustomer_comment'		=> !empty($request->input('note'))?$request->input('note'):'',
			'updated_at'				=> new DateTime(),
		];
		DB::table('groupcustomer')->where('groupcustomer_id',$request->input('id'))->update($data);
		Session::flash('alert-update','update');
		return redirect('groupcustomer');
	}
	
	
	public function destroy($id){
		DB::table('groupcustomer')->where('groupcustomer_id',$id)->delete();
		
		Session::flash('alert-delete','delete');
		return redirect('groupcustomer');
	}
}
