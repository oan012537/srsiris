<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Session;
use Response;
use Datatables;
use File;
use Auth;
use Folklore\Image\Facades\Image;

class CategoryController extends Controller
{
	public function index(){
		$category	= DB::table('category')->get();
		return view('category/index',['category' => $category]);
	}
	
	
	public function store(Request $request){
		$data = array(
			'category_code'		=> $request->input('codecategory'),
			'category_name'		=> $request->input('category'),
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		);
		savelog('13','เพิ่มข้อมูลหมวดสินค้าชื่อ '.$request->input('category'));
		// $savelog = $this->savelog('เพิ่มข้อมูลหมวดสินค้า');
		DB::table('category')->insert($data);
		Session::flash('alert-insert','insert');
		return redirect('category');
	}
	
	public function edit(Request $request){
		$results = DB::table('category')->where('category_id',$request->input('id'))->first();
		return Response::json($results);
	}
	
	public function update(Request $request){
		$category = DB::table('category')->where('category_id',$request->input('categoryidedit'))->first();
		$data = array(
			'category_code'		=> $request->input('codecategoryedit'),
			'category_name'		=> $request->input('categoryedit'),
			'updated_at'		=> new DateTime(),
		);
		savelog('13','แก้ไขข้อมูลหมวดสินค้าลำดับที่'.$category->category_id.' จากชื่อ '.$category->category_name.' เป็นชื่อ '.$request->input('categoryedit'));
		DB::table('category')->where('category_id',$request->input('categoryidedit'))->update($data);
		Session::flash('alert-update','update');
		return redirect('category');
	}
	
	public function destroy($id){
		$category = DB::table('category')->where('category_id',$id)->first();
		DB::table('category')->where('category_id',$id)->delete();
		savelog('13','ลบข้อมูลหมวดสินค้าลำดับที่ '.$category->category_id.' ชื่อ '.$category->category_name);
		Session::flash('alert-delete','delete');
		return redirect('category');
	}
}
