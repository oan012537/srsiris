<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\position;
use App\permission;
use DB;
use DateTime;
use Session;
use Response;
use Datatables;
use File;
use Auth;
class PermissionController extends Controller
{
    public function index(){
    	return redirect()->back();
		// $category	= DB::table('category')->get();
		// return view('category/index',['category' => $category]);
	}

	public function permission($id){
		$position = position::find($id);
		$permission = permission::leftjoin('menu','permission_menu_id','menu_id')->where('permission_position_id',$id)->get();
		$data = DB::table('menu')->get();
		return view('permission/index',['position'=>$position,'permission'=>$permission,'menu'=>$data]);
	}
	
	
	public function store(Request $request){
		$data = permission::where('permission_position_id',$request->positionid)->where('permission_menu_id',$request->permission)->first();
		if(count($data) == 0){
			$permission = new permission;
			$permission->permission_position_id = $request->positionid ;
			$permission->permission_menu_id = $request->permission ;
			$permission->save();
		}
		Session::flash('alert-insert','insert');
		return redirect('permission/'.$request->positionid);
	}
	
	public function destroy($id){
		$permission = permission::find($id);
		$permission->delete();
		Session::flash('alert-delete','delete');
		return redirect()->back();
	}
}
