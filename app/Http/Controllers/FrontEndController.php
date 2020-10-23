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
use App\supplier;
use App\product;
use App\imports;
use App\subimports;
use App\processingunit;
use App\stock;
use App\selling;
use App\logscanboxputtingcar;

class FrontEndController extends Controller
{
	public function checkstock(){
		return view('frontend/checkstock');
	}
	
	// public function index(){
	// 	$product 	= DB::table('category')->get();
	// 	return view('frontend/index',['data' => $product]);
	// }

	public function scanbill(Request $request){
		// $data = DB::table('selling')->where('selling_id',$request->scanbill)->get();
		$selling = new selling;
		$data = $selling::leftjoin('selling_detail','sellingdetail_ref','selling_id')->leftjoin('product','sellingdetail_productid','product_id')->where('selling_inv',$request->scanbill)->get();
		if(count($data) > 0){
			return view('frontend/scanbarcodeproduct',['data'=>$data,'id'=>$data[0]->selling_id]);
		}else{
			return redirect()->back();
		}
		
	}

	public function checkproductinbox($idbox){
		// $data = DB::table('selling')->where('selling_id',$request->scanbill)->get();
		// dd($idbox);
		$data = DB::table('box')->leftjoin('product','box_product','product_id')->where('box_tax',$idbox)->get();
		if(count($data) > 0){
			return view('frontend/scanbarcodeproductinbox',['data'=>$data]);
		}else{
			return redirect()->back();
		}
		
	}


	public function scanbarcode(Request $request){
		$data = selling::leftjoin('selling_detail','sellingdetail_ref','selling_id')->leftjoin('product','sellingdetail_productid','product_id')->where('product_barcode',$request->scanbarcode)->where('selling_id',$request->id)->first();
		$count = 0;
		$id = '';
		$qty = 0;
		if(!empty($data)){
			$count = count($data);
			$id = $data->product_id;
			$qty = $data->sellingdetail_qty;
		}
		$datax = [
			'count' =>$count,
			'id' =>$id,
			'qty' =>$qty,
		];
		return Response::json($datax);
	}


	public function checkboxbeforeputtingcar(){
		return view('frontend/checkboxbeforeputtingcar');
	}

	public function scanbillfortranfer(Request $request){

		$data = DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->leftjoin('selling','selling_id','sub_order')->where('trans_invoice',$request->scanbill)->get();
		dd();
		// $data = DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->leftjoin('selling','selling_id','sub_order')->leftjoin('box','selling_inv','box_orderinv')->where('trans_invoice',$request->scanbill)->get();
		// dd($data);
		if(count($data) > 0){
			return view('frontend/dataforbilltranfer',['data'=>$data,'id'=>$request->scanbill]);
		}else{
			return redirect()->back();
		}
		
	}

	public function scanwaitboxputtingcar(Request $request){
		// dd($request);
		$data = DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->leftjoin('selling','selling_id','sub_order')->where('selling_inv',$request->scanbarcode)->where('trans_invoice',$request->id)->first();
		$count = 0;
		$id = '';
		$qty = 0;
		if(!empty($data)){
			$count = 1;
			$id = $request->scanbarcode;
			// $qty = $data->sellingdetail_qty;
		}
		$datax = [
			'check' =>$count,
			'id' =>$id,
			// 'qty' =>$qty,
		];
		return Response::json($datax);
	}

	

	public function scanboxbillputtingcar(){
		// dd('สแกนเปิดบิลเอาของขึ้นรถ');
		return view('frontend/scanboxbillputtingcar');
	}

	public function scancheckputtingcar(Request $request){
		$data = DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->leftjoin('selling','selling_id','sub_order')->where('trans_invoice',$request->scanbill)->get();
		// $data = DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->leftjoin('selling','selling_id','sub_order')->leftjoin('box','selling_inv','box_orderinv')->where('trans_invoice',$request->scanbill)->get();
		// dd($data);
		if(count($data) > 0){
			return view('frontend/scanboxputtingcar',['data'=>$data,'id'=>$request->scanbill]);
		}else{
			return redirect()->back();
		}
	}

	public function scanboxputtingcar(Request $request){
		// dd('ขั้นสแกนของขึ้นรถต้องมีเก็บlogสแกนกล่องที่ไม่อยู่ในบิลด้วย ถ้าซ้ำเก็บครั้งเดียว');
		// dd($request->id);
		$logscanboxputtingcar = new logscanboxputtingcar;
		$check = $logscanboxputtingcar::where('scanboxputtingcar_tax',$request->scanbarcode)->where('scanboxputtingcar_ref',$request->id)->where('scanboxputtingcar_date',date("Y-m-d"))->first();
		if(!empty($check)){
			$check->scanboxputtingcar_count = $check->scanboxputtingcar_count+1;
			$check->save();
		}else{
			$logscanboxputtingcar->scanboxputtingcar_date = date("Y-m-d");
			$logscanboxputtingcar->scanboxputtingcar_ref = $request->id;
			$logscanboxputtingcar->scanboxputtingcar_tax = $request->scanbarcode;
			$logscanboxputtingcar->scanboxputtingcar_count = ($logscanboxputtingcar->scanboxputtingcar_count||0)+1;
			$logscanboxputtingcar->scanboxputtingcar_user = Auth::id();
			$logscanboxputtingcar->save();
		}
		$data = DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->leftjoin('selling','selling_id','sub_order')->where('selling_inv',$request->scanbarcode)->where('trans_invoice',$request->id)->first();
		$count = 0;
		$id = '';
		$qty = 0;
		if(!empty($data)){
			$count = 1;
			$id = $request->scanbarcode;
		}
		$datax = [
			'check' =>$count,
			'id' =>$id,
		];
		return Response::json($datax);
	}



}

?>