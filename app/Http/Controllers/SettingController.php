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

class SettingController extends Controller
{
    public function index(){
		$setting	= DB::table('setting')->where('set_id',1)->first();
		return view('setting/index',['setting' => $setting]);
	}
	
	public function store(Request $request){
		$res = DB::table('setting')->where('set_id',1)->first();
		$img = $res->set_logo;
		if($request->hasFile('fileupload')){
			File::delete('assets/images/setting/'.$res->set_logo.'');
			$files = $request->file('fileupload');
			$filename 	= $files->getClientOriginalName();
			$extension 	= $files->getClientOriginalExtension();
			$size		= $files->getSize();
			$img .= date('His').$filename;
			$destinationPath = base_path()."/assets/images/setting/";
			$files->move($destinationPath, $img);
			
		}
		
		$data = array(
			'set_name'			=> $request->input('compname'),
			'set_address'		=> $request->input('compaddr'),
			'set_nav'			=> $request->input('color'),
			'set_navfont'		=> $request->input('colorfont'),
			'set_menu'			=> $request->input('colormenu'),
			'set_logo'			=> $img,
			'set_price'			=> $request->input('setprice'),
			'set_price1'		=> $request->input('setprice1'),
			'set_price2'		=> $request->input('setprice2'),
			'set_price3'		=> $request->input('setprice3'),
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		);
		savelog('20','แก้ไขข้อมูลตั้งค่า');
		DB::table('setting')->where('set_id',1)->update($data);
		Session::flash('alert-update','update');
		return redirect('setting');
	}
}
