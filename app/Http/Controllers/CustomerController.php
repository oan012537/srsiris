<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Session;
use Response;
use Datatables;
use File;
use App\area;
use Auth;
use Redirect;
use Folklore\Image\Facades\Image;

class CustomerController extends Controller
{
    public function index(){
		return view('customer/index');
	}
	
	public function datatable(){
		$customer = DB::table('customer')->where('customer_type','1');
		if(Auth::user()->position > 2){
    		$customer->where('customer_group',Auth::user()->groupsell);
    	}
    	// $customer = $customer->get();
		$sQuery	= Datatables::of($customer)
		->addColumn('address',function($data){
			$address = '';
			if($data->customer_address1 != ''){
				$address .= 'บ้านเลขที่ - ซอย '.$data->customer_address1;
			}
			if($data->customer_address2 != ''){
				$address .= ' ถนน '.$data->customer_address2;
			}
			if($data->customer_address3 != ''){
				$address .= ' แขวง / ตำบล '.$data->customer_address3;
			}
			if($data->customer_address4 != ''){
				$address .= ' เขต / อำเภอ '.$data->customer_address4;
			}
			if($data->customer_address5 != ''){
				$address .= ' จังหวัด '.$data->customer_address5;
			}
			if($data->customer_address6 != ''){
				$address .= ' รหัสไปรษณย์ '.$data->customer_address6;
			}
			return $address;
		});
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function create(){
		$provinces = DB::table('provinces')->get();
		$deliverytype = DB::table('deliverytype')->get();
		$area = area::all();
		// dd($area);
		return view('customer/create',['provinces'=>$provinces,'deliverytype'=>$deliverytype,'area'=>$area]);
	}
	
	public function store(Request $request){
        $imgcover1 = '';
		$imgcover2 = '';
		$imgcover3 = '';
		// dd($request);
		if($request->hasFile('imageuser')){
			$files = $request->file('imageuser');
			$filename 	= $files->getClientOriginalName();
			$extension 	= $files->getClientOriginalExtension();
			$size		= $files->getSize();
			$imgcover2 	= date('His').$filename;
			$destinationPath = base_path()."/assets/images/customer/";
			$files->move($destinationPath, $imgcover2);
			
		}
		if($request->hasFile('imagesignature')){
			$files = $request->file('imagesignature');
			$filename 	= $files->getClientOriginalName();
			$extension 	= $files->getClientOriginalExtension();
			$size		= $files->getSize();
			$imgcover3 	= date('His').$filename;
			$destinationPath = base_path()."/assets/images/customer/";
			$files->move($destinationPath, $imgcover3);
			
		}
		$data = [
			'customer_idtax'		=> !empty($request->input('idtax'))?$request->input('idtax'):'',
			'customer_name'			=> $request->input('name'),
			'customer_tel'			=> !empty($request->input('tel'))?$request->input('tel'):'',
			'customer_telhome'		=> !empty($request->input('telhome'))?$request->input('telhome'):'',
			'customer_email'		=> !empty($request->input('email'))?$request->input('email'):'',
			'customer_credit'		=> !empty($request->input('credit'))?$request->input('credit'):'',
			'customer_creditmoney'	=> !empty($request->input('creditmoney'))?$request->input('creditmoney'):'',
			'customer_note'			=> !empty($request->input('note'))?$request->input('note'):'',
			'customer_group'		=> !empty($request->input('groupcustomer'))?$request->input('groupcustomer'):'',
            'location'              => !empty($request->input('location'))?$request->input('location'):'',
            'lat'                   => !empty($request->input('lat'))?$request->input('lat'):'',
            'lng'                   => !empty($request->input('lng'))?$request->input('lng'):'',
            'customer_rate'         => !empty($request->input('rate'))?$request->input('rate'):'',
            'customer_rateshiping'  => !empty($request->input('rateshiping'))?$request->input('rateshiping'):'',
            'customer_address1'     => !empty($request->input('address1'))?$request->input('address1'):'',
            'customer_address2'     => !empty($request->input('address2'))?$request->input('address2'):'',
            'customer_address3'     => !empty($request->input('address3'))?$request->input('address3'):'',
            'customer_address4'     => !empty($request->input('address4'))?$request->input('address4'):'',
            'customer_address5'     => !empty($request->input('address5'))?$request->input('address5'):'',
            'customer_address6'     => !empty($request->input('address6'))?$request->input('address6'):'',
            'customer_imageuser'     => $imgcover2,
            'customer_imageshop'     => $imgcover1,
            'customer_imagesignature'=> $imgcover3,
            'customer_typedelivery'  => !empty($request->input('typedelivery'))?$request->input('typedelivery'):'',
			'created_at'			=> new DateTime(),
			'updated_at'			=> new DateTime(),
		];
		// dd($data);
		DB::table('customer')->insert($data);
		$lastcusid 	= DB::table('customer')->latest()->first();
		$customerid = $lastcusid->customer_id;
		foreach ($_POST['destination'] as $destination) {
			$datadestination = [
				'destination_customerid'	=> $customerid,
				'destination_name'			=> $destination,
				'destination_status'		=> '0',
				'created_at'				=> new DateTime(),
				'updated_at'				=> new DateTime(),
			];
			DB::table('customer_destination')->insert($datadestination);
		}
		if(!empty($request->uploadimage)){
			$file = explode(',',$request->uploadimage);
			foreach($file as $filemove){
				File::move(base_path("/assets/images/customer/shop/add/".$filemove), base_path("/assets/images/customer/shop/".$filemove));
				$datashop = [
						'imageshopcustomer_customerid'	=> $customerid,
						'imageshopcustomer_name'		=> $filemove,
						'craete_at'						=> new DateTime(),
						'update_at'						=> new DateTime()
					];
					DB::table('imageshop_customer')->insert($datashop);
			}
		}else{
			if($request->hasFile('imageshop')){
				$files_ = $request->file('imageshop');
				foreach ($files_ as $value) {
					$files = $value;
					$filename 	= $files->getClientOriginalName();
					$extension 	= $files->getClientOriginalExtension();
					$size		= $files->getSize();
					$imgcover1 	= date('His').$filename;
					$destinationPath = base_path()."/assets/images/customer/shop/";
					$files->move($destinationPath, $imgcover1);
					$datashop = [
						'imageshopcustomer_customerid'	=> $customerid,
						'imageshopcustomer_name'		=> $imgcover1,
						'craete_at'						=> new DateTime(),
						'update_at'						=> new DateTime()
					];
					DB::table('imageshop_customer')->insert($datashop);
				}
			}
		}
		savelog('3','เพิ่มข้อมูลลูกค้าชื่อ'.$request->input('name'));
		Session::flash('alert-insert','insert');
		return redirect('customer');
	}
	
	public function edit($id){
		$customer 	= DB::table('customer')->where('customer_id',$id)->first();
		$area = area::all();
		$shopimage 	= DB::table('imageshop_customer')->where('imageshopcustomer_customerid',$id)->get();
		$destination 	= DB::table('customer_destination')->where('destination_customerid',$id)->get();
		$deliverytype = DB::table('deliverytype')->get();
		return view('customer/update',['customer' => $customer,'shopimage' => $shopimage,'area'=>$area,'destination'=>$destination,'deliverytype'=>$deliverytype]);
	}
	
	public function update(Request $request){
		
		$imgcover1 = '';
		$imgcover2 = '';
		$imgcover3 = '';
		// dd($request);
		// if($request->hasFile('imageshop')){
		// 	$files = $request->file('imageshop');
		// 	$filename 	= $files->getClientOriginalName();
		// 	$extension 	= $files->getClientOriginalExtension();
		// 	$size		= $files->getSize();
		// 	$imgcover1 	= date('His').$filename;
		// 	$destinationPath = base_path()."/assets/images/customer/";
		// 	$files->move($destinationPath, $imgcover1);
		// }
		$customer = DB::table('customer')->where('customer_id',$request->input('updateid'))->first();
		if($request->hasFile('imageuser')){
			$files = $request->file('imageuser');
			$filename 	= $files->getClientOriginalName();
			$extension 	= $files->getClientOriginalExtension();
			$size		= $files->getSize();
			$imgcover2 	= date('His').$filename;
			$destinationPath = base_path()."/assets/images/customer/";
			$files->move($destinationPath, $imgcover2);
			
		}
		if($request->hasFile('imagesignature')){
			$files = $request->file('imagesignature');
			$filename 	= $files->getClientOriginalName();
			$extension 	= $files->getClientOriginalExtension();
			$size		= $files->getSize();
			$imgcover3 	= date('His').$filename;
			$destinationPath = base_path()."/assets/images/customer/";
			$files->move($destinationPath, $imgcover3);
			
		}
		// echo $imgcover1;
		$data = [
			'customer_idtax'		=> !empty($request->input('idtax'))?$request->input('idtax'):'',
			'customer_name'			=> $request->input('name'),
			'customer_tel'			=> $request->input('tel'),
			'customer_telhome'		=> !empty($request->input('telhome'))?$request->input('telhome'):'',
			'customer_email'		=> $request->input('email'),
			'customer_credit'		=> $request->input('credit'),
			'customer_creditmoney'	=> $request->input('creditmoney'),
			'customer_note'			=> !empty($request->input('note'))?$request->input('note'):'',
			'customer_group'		=> $request->input('groupcustomer'),
            'location'              => $request->input('location'),
            'lat'                   => $request->input('lat'),
            'lng'                   => $request->input('lng'),
			'customer_rate'         => $request->input('rate'),
            'customer_rateshiping'  => $request->input('rateshiping'),
            'customer_address1'     => $request->input('address1'),
            'customer_address2'     => $request->input('address2'),
            'customer_address3'     => $request->input('address3'),
            'customer_address4'     => $request->input('address4'),
            'customer_address5'     => $request->input('address5'),
            'customer_address6'     => $request->input('address6'),
            'customer_imageuser'     => $imgcover2,
            'customer_imageshop'     => $imgcover1,
            'customer_imagesignature'=> $imgcover3,
            'customer_vat'     		=> $request->input('vat'),
            'customer_typedelivery'  => !empty($request->input('typedelivery'))?$request->input('typedelivery'):'',
			'updated_at'			=> new DateTime(),
		];
		// dd($data);
		DB::table('customer')->where('customer_id',$request->input('updateid'))->update($data);
		foreach ($_POST['destination'] as $key => $destination) {
			if($_POST['destinationid'][$key] != ''){
				$datadestination = [
					'destination_name'			=> $destination,
					'updated_at'				=> new DateTime(),
				];
				DB::table('customer_destination')->where('destination_id',$request->input('destinationid')[$key])->update($datadestination);
			}else{
				$datadestination = [
					'destination_customerid'	=> $request->input('updateid'),
					'destination_name'			=> $destination,
					'destination_status'		=> '0',
					'created_at'				=> new DateTime(),
					'updated_at'				=> new DateTime(),
				];
				DB::table('customer_destination')->insert($datadestination);
			}
			
		}
		//ทำฟังก์ชันอัพโหลดแล้วเลยปิดตรงนี้
		// if($request->hasFile('imageshop')){
		// 	$files_ = $request->file('imageshop');
		// 	foreach ($files_ as $value) {
		// 		$files = $value;
		// 		$filename 	= $files->getClientOriginalName();
		// 		$extension 	= $files->getClientOriginalExtension();
		// 		$size		= $files->getSize();
		// 		$imgcover1 	= date('His').$filename;
		// 		$destinationPath = base_path()."/assets/images/customer/shop/";
		// 		$files->move($destinationPath, $imgcover1);
		// 		$datashop = [
		// 			'imageshopcustomer_customerid'	=> $request->input('updateid'),
		// 			'imageshopcustomer_name'		=> $imgcover1,
		// 			'craete_at'						=> new DateTime(),
		// 			'update_at'						=> new DateTime()
		// 		];
		// 		DB::table('imageshop_customer')->insert($datashop);
		// 	}
		// }
		savelog('3','แก้ไขข้อมูลลูกค้าลำดับที่'.$customer->customer_id.' จากชื่อ '.$customer->customer_name.' เป็นชื่อ '.$request->input('name'));
		Session::flash('alert-update','update');
		return redirect('customer');
	}
	
	
	public function destroy($id){
		$customer = DB::table('customer')->where('customer_id',$id)->first();
		DB::table('customer')->where('customer_id',$id)->delete();
		savelog('3','ลบข้อมูลลูกค้าลำดับที่ '.$customer->customer_id.' ชื่อ '.$customer->customer_name);
		Session::flash('alert-delete','delete');
		return redirect('customer');
	}

	public function datagroupcustomer(){
		$groupcustomer = DB::table('groupcustomer')->where('groupcustomer_status','1')->get();
		return Response::json($groupcustomer);
	}

	public function amphures(Request $request){
		$amphures = DB::table('amphures')->where('province_id',$request->id)->get();
		return Response::json($amphures);
	}
	public function districts(Request $request){
		$districts = DB::table('districts')->where('amphure_id',$request->id)->get();
		return Response::json($districts);
	}
	public function zidcode(Request $request){
		$districts = DB::table('districts')->where('id',$request->id)->first();
		return Response::json($districts->zip_code);
	}
	public function deleteimage($imageid){
		$data = DB::table('imageshop_customer')->where('imageshopcustomer_id',$imageid)->first();
		if(!empty($data)){
			DB::table('imageshop_customer')->where('imageshopcustomer_id',$imageid)->delete();
			unlink("assets/images/customer/shop/".$data->imageshopcustomer_name);
			echo "Y";
		}else{
			echo "X";
		}
		
	}
	public function fileupload(Request $request){
	    if($request->hasFile('imageshop')){
			$files_ = $request->file('imageshop');
			foreach ($files_ as $value) {
				$files = $value;
				$filename 	= $files->getClientOriginalName();
				$extension 	= $files->getClientOriginalExtension();
				$size		= $files->getSize();
				$imgcover1 	= date('His').$filename;
				$destinationPath = base_path()."/assets/images/customer/shop/";
				$files->move($destinationPath, $imgcover1);
				$datashop = [
					'imageshopcustomer_customerid'	=> $request->input('updateid'),
					'imageshopcustomer_name'		=> $imgcover1,
					'craete_at'						=> new DateTime(),
					'update_at'						=> new DateTime()
				];
				DB::table('imageshop_customer')->insert($datashop);
			}
			return response()->json(['uploaded' => 'SUCCESS']);
		}else{
			return response()->json(['uploaded' => 'ERROR']);
		}
		
	}
	public function fileuploadadd(Request $request){
	    if($request->hasFile('imageshop')){
			$files_ = $request->file('imageshop');
			foreach ($files_ as $value) {
				$files = $value;
				$filename 	= $files->getClientOriginalName();
				$extension 	= $files->getClientOriginalExtension();
				$size		= $files->getSize();
				$imgcover1 	= date('His').$filename;
				$destinationPath = base_path()."/assets/images/customer/shop/add";
				$files->move($destinationPath, $imgcover1);
			}
			return response()->json($imgcover1);
		}else{
			return response()->json(['uploaded' => 'ERROR']);
		}
		
	}
}
