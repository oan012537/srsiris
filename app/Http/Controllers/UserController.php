<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\position;
use App\area;
use DB;
use DateTime;
use Session;
use Response;
use Datatables;
use File;
use Folklore\Image\Facades\Image;
use PDF;

class UserController extends Controller
{
    public function index(){
      $data = DB::table('position')->get(); // จำนวนrowที่ดึงต่อหน้า
		return view('users/index',['data' => $data]);
	}

	public function create(){
		$data = position::all();
		$area = area::all();
		$category = DB::table('category')->get();
		$dataaccount	= DB::table('setheadbill_account')->get();
		return view('users/create',['data' => $data,'area' => $area,'categorys' => $category,'dataaccount' => $dataaccount]);
	}
	public function datatable(){
		// $users = new admin;
		$users = DB::table('users');
		$name = request('name');
		if($name != ''){
			$users->where('name',$name);
		}
		// $lastname = request('lastname');
		// if($lastname != ''){
		// 	$users->where('selling_customerid','like',$lastname.'%');
		// }
		$staus = request('staus');
		if($staus != ''){
			$users->where('status',$staus);
		}
		$position = request('position');
		if($position != ''){
			$users->where('position',$position);
		}

		$users = $users->get();
		// dd($users);
		$sQuery	= Datatables::of($users);
		return $sQuery->escapeColumns([])->make(true);
	}

	public function store(Request $request){
		$imgcover = '';
		if($request->hasFile('image')){
			$files = $request->file('image');
			$filename 	= $files->getClientOriginalName();
			$extension 	= $files->getClientOriginalExtension();
			$size		= $files->getSize();
			$imgcover 	= date('His').$filename;
			$destinationPath = base_path()."/assets/images/user/";
			$files->move($destinationPath, $imgcover);
		}
		$users = new User;
		$users->name = $request->input('name');
		$users->position = $request->input('position');
		if(!empty($request->groupcategory)){
			$users->groupcategory = $request->input('groupcategory');
		}
		if(!empty($request->groupcustomer)){
			$users->groupsell = $request->input('groupcustomer');
		}
		$users->email = $request->input('email');
		$users->phone = $request->input('tel');
		$users->actionadd = $request->input('actionadd');
		$users->actionedit = $request->input('actionedit');
		$users->actiondelete = $request->input('actiondelete');
		$users->accountforsell = $request->input('accountarea');
		$users->password = bcrypt($request->input('password'));
		$users->remember_token = $request->input('_token');
		$users->image = $imgcover;
		$users->save();
		savelog('21','เพิ่มบัญชีผู้ใช้งานชื่อ '.$request->input('name'));
	    Session::flash('alert-insert','insert');

	    return redirect('users');
	}

	public function del($id){
		$data = User::find($id);
		$data->status = 0;
		savelog('21','ลบบัญชีผู้ใช้งานชื่อ '.$data->name);
		$data->save();
		// DB::table('users')->where('id',$id)->delete();
		return redirect('users');
	}

	public function edit($id){
		$data = User::find($id);
		$position = position::all();
		$area = area::all();
		$category = DB::table('category')->get();
		$dataaccount	= DB::table('setheadbill_account')->get();
		return view('users/update',['data'=>$data,'position'=>$position,'area' => $area,'categorys' => $category,'dataaccount' => $dataaccount]);
	}

	public function update(Request $request){
		$imgcover = '';
		if($request->hasFile('image')){
			$files = $request->file('image');
			$filename 	= $files->getClientOriginalName();
			$extension 	= $files->getClientOriginalExtension();
			$size		= $files->getSize();
			$imgcover 	= date('His').$filename;
			$destinationPath = base_path()."/assets/images/user/";
			$files->move($destinationPath, $imgcover);
		}
		
		$users = User::find($request->input('id'));
		savelog('21','แก้บัญชีผู้ใช้งานชื่อ '.$users->name.' เป็น '.$request->input('name'));
		$users->name = $request->input('name');
		$users->position = $request->input('position');
		if(!empty($request->groupcategory)){
			$users->groupcategory = $request->input('groupcategory');
		}
		if(!empty($request->groupcustomer)){
			$users->groupsell = $request->input('groupcustomer');
		}
		$users->email = $request->input('email');
		$users->phone = $request->input('tel');
		$users->actionadd = $request->input('actionadd');
		$users->actionedit = $request->input('actionedit');
		$users->actiondelete = $request->input('actiondelete');
		$users->accountforsell = $request->input('accountarea');
		$users->password = bcrypt($request->input('password'));
		$users->remember_token = $request->input('_token');
		$users->image = $imgcover;
		$users->save();

		Session::flash('alert-update','update');

		return redirect('users');
	}


	public function queryperiod(Request $request){
		$payment = DB::table('billpayment')->where('bill_ref',$request->input('id'))->get();
		return Response::json($payment);
	}
}
