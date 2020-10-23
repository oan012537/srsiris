<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\position;
use DB;
use DateTime;
use Session;
use Response;
use Datatables;
use File;
class PositionController extends Controller
{
    public function index(){
		$position	= position::all();
		return view('position/index',['position' => $position]);
	}
	
	
	public function store(Request $request){
		$position	= new position;
		$position->position_name =  $request->name;
		$position->save();
		Session::flash('alert-insert','insert');
		return redirect('position');
	}
	
	public function edit(Request $request){
		$position	= position::find($request->id);
		// $results = DB::table('position')->where('category_id',$request->input('id'))->first();
		return Response::json($position);
	}
	
	public function update(Request $request){
		
		$position	= position::find($request->id);
		$position->position_name = $request->name;
		$position->save();
		Session::flash('alert-update','update');
		return redirect('position');
	}

	public function cancel($id){
		$position	= position::find($id);
		$position->status = '0';
		$position->save();
		Session::flash('alert-update','update');
		return redirect('position');
	}
	
	public function destroy($id){
		$position	= position::find($id);
		$position->delete();
		Session::flash('alert-delete','delete');
		return redirect('position');
	}

	
}
