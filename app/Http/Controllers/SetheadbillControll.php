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

class SetheadbillControll extends Controller
{
    public function index(){
		$setting	= DB::table('setheadbill')->where('setheadbill_id',1)->first();
		$dataaccount	= DB::table('setheadbill_account')->get();
		return view('setheaderbill/index',['setting' => $setting,'dataaccounts'=>$dataaccount]);

	}
	
	public function store(Request $request){
		$res = DB::table('setheadbill')->where('setheadbill_id',1)->first();
		$imgraw = $res->setheadbill_logoraw;
		if($request->hasFile('fileuploadraw')){
			File::delete('assets/images/setting/'.$res->setheadbill_logoraw.'');
			$files = $request->file('fileuploadraw');
			$filename 	= $files->getClientOriginalName();
			$extension 	= $files->getClientOriginalExtension();
			$size		= $files->getSize();
			$imgraw = date('His').$filename;
			$destinationPath = base_path()."/assets/images/setting/";
			$files->move($destinationPath, $imgraw);
			
		}
		$img = $res->setheadbill_logo;
		if($request->hasFile('fileupload')){
			File::delete('assets/images/setting/'.$res->setheadbill_logo.'');
			$files = $request->file('fileupload');
			$filename 	= $files->getClientOriginalName();
			$extension 	= $files->getClientOriginalExtension();
			$size		= $files->getSize();
			$img = date('His').$filename;
			$destinationPath = base_path()."/assets/images/setting/";
			$files->move($destinationPath, $img);
			
		}
		// dd($_POST['dataaccount']);
		// dd($_POST['dataaccountid']);
		foreach ($_POST['dataaccount'] as $key => $value) {
			if($_POST['dataaccountid'][$key] != ''){
				$data = array(
					'setheadbillaccount_name'	=> $value,
					'updated_at'				=> new DateTime(),
				);
				DB::table('setheadbill_account')->where('setheadbillaccount_id',$_POST['dataaccountid'][$key])->update($data);
			}else{
				$data = array(
					'setheadbillaccount_name'	=> $value,
					'created_at'				=> new DateTime(),
					'updated_at'				=> new DateTime(),
				);
				DB::table('setheadbill_account')->insert($data);
			}
			
		}
		

		$data = array(
			'setheadbill_title'			=> $request->input('title'),
			'setheadbill_address_th'	=> $request->input('addressth'),
			'setheadbill_address_en'	=> $request->input('addresseh'),
			'setheadbill_web'			=> $request->input('web'),
			'setheadbill_email'			=> $request->input('email'),
			'setheadbill_tel'			=> $request->input('tel'),
			'setheadbill_fax'			=> $request->input('fax'),
			'setheadbill_selectaccount'	=> $_POST['dataaccount'][$request->input('selectaccount')-1],
			'setheadbill_logo'			=> $img,
			'setheadbill_logoraw'		=> $imgraw,
			'setheadbill_textlogo'		=> $request->input('textlogo'),
			'created_at'				=> new DateTime(),
			'updated_at'				=> new DateTime(),
		);
		// dd($data);
		// $setheadbill = DB::table('setheadbill')->where('setheadbill_id',1)->first();
		savelog('18','แก้ไขข้อมูลตั้งค่าหัวบิล');

		DB::table('setheadbill')->where('setheadbill_id',1)->update($data);
		Session::flash('alert-update','update');
		return redirect('setheaderbill');
	}
}
