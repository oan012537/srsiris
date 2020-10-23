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

class SubcategoryController extends Controller
{
	public function index(){
		$category 		= DB::table('category')->get();
		$subcategory	= DB::table('subcategory')->join('category', 'subcategory.sub_ref', '=', 'category.category_id')->get();
		return view('subcategory/index',['subcategory' => $subcategory,'category' => $category]);
	}
	
	
	public function store(Request $request){
		$data = array(
			'sub_ref'			=> $request->input('category'),
			'sub_name'			=> $request->input('subcategory'),
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		);
		
		DB::table('subcategory')->insert($data);
		Session::flash('alert-insert','insert');
		return redirect('subcategory');
	}
	
	public function edit(Request $request){
		$category 		= DB::table('category')->get();
		$results 		= DB::table('subcategory')->where('sub_id',$request->input('id'))->first();
		return Response::json(['results' => $results,'category' => $category]);
	}
	
	public function update(Request $request){
		$data = array(
			'sub_ref'			=> $request->input('category'),
			'sub_name'			=> $request->input('subcategoryedit'),
			'updated_at'		=> new DateTime(),
		);
		
		DB::table('subcategory')->where('sub_id',$request->input('subcategoryidedit'))->update($data);
		Session::flash('alert-update','update');
		return redirect('subcategory');
	}
	
	public function destroy($id){
		DB::table('subcategory')->where('sub_id',$id)->delete();
		Session::flash('alert-delete','delete');
		return redirect('subcategory');
	}
}
