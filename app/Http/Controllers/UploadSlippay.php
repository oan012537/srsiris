<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Session;
use Response;
use Datatables;
use Auth;
use App\selling;


class UploadSlippay extends Controller
{
    public function index(){
    	$customer = DB::table('customer')->get();
    	return view('uploadslippay.index',['startdate'=>date("Y-m-d"),'lastdate'=>date("Y-m-d"),'customer'=>$customer]);
    }
    public function datatables(){
		// $selling = DB::table('selling');
		$selling = DB::table('ci_payment')->leftjoin('export','ci_payment.order_no','export.export_inv')->where('export.export_status_online','รอการชำระเงิน');
		// if(Auth::user()->position > 2 && Auth::user()->position != 5){
  //   		$selling->where('selling_empid',Auth::id());
  //   	}
		if($noorder = request('noorder')){
			$selling->where('export_inv','like','%'.$noorder.'%');
		}
		$datestart = request('datestart');
		$dateend = request('dateend');
		if($datestart != '' && $dateend != ''){
			// $datestart = explode('/',$datestart);
			// $datestarts = $datestart[2].'-'.$datestart[1].'-'.$datestart[0];
			// $dateend = explode('/',$dateend);
			// $dateends = $dateend[2].'-'.$dateend[1].'-'.$dateend[0];

			$selling->whereBetween('payment_datetime',[$datestart,$dateend]);
		}
		$customername = request('customer');
		if($customername != ''){
			$selling->where('export_customerid','like',$customername.'%');
		}

		$selling = $selling->groupby('export_inv');
		$sQuery	= Datatables::of($selling);
		return $sQuery->escapeColumns([])->make(true);
	}
	public function approve($id){
		$order = DB::table('ci_payment')->leftjoin('export','export.export_inv','ci_payment.order_no')->where('payment_id',$id)->first();
		$export = DB::table('export')->where('export_id',$order->export_id)->first();
    	
    	
		$dateY	 	= date('Y');
		$dateM 		= date('m');
		$dateD 		= date('d');
		$cutdate 	= substr($dateY,2,2);
		$strdate 	= 'S'.$cutdate.$dateM.$dateD;
		$invoice	= DB::table('selling')->where('selling_inv','like',$strdate."%")->orderBy('selling_id','desc')->first();
		if(!empty($invoice)){
			$str = $invoice->selling_inv;
			$sub = substr($str,7,3)+1;
			$cut = substr($str,1,6);
			$inv = $cut.sprintf("%03d",$sub);
		}else{
			$dateY = date('Y');
			$dateM = date('m');
			$dateD = date('d');
			$cutdate = substr($dateY,2,2);
			$strdate = $cutdate.$dateM.$dateD.sprintf("%03d",1);
			$inv = $strdate;
		}

		$data = [
			'payment_method'		=> 'Bank Transfer',
			'selling_ref'			=> $export->export_id,
			'selling_inv'			=> 'S'.$inv,
			'selling_date'			=> date("Y-m-d"),
			'selling_empid'			=> Auth::user()->id,
			'selling_empname'		=> Auth::user()->name,
			'selling_customerid'	=> $export->export_customerid,
			'selling_customername'	=> $export->export_customername,
			'selling_note'			=> $export->export_note,
			'selling_total'			=> $export->export_total,
			'selling_discount'		=> $export->export_discount,
			'selling_discountsum'	=> $export->export_discountsum,
			'selling_lastbill'		=> !empty($export->export_lastbill)?$export->export_lastbill:0,
			'selling_vat'			=> $export->export_vat,
			'selling_vatsum'		=> $export->export_vatsum,
			'selling_typepay'		=> 'Online',
			'selling_noaccount'		=> '',
			'selling_totalall'		=> $export->export_totalall,
			'selling_totalpayment'	=> $export->export_totalpayment,
			'selling_status'		=> '1',
			'selling_statusprint' => '0',
			'created_at'			=> new DateTime(),
			'updated_at'			=> new DateTime(),
		];
		// dd($data);
 
		DB::table('selling')->insert($data);
		$lastid = DB::table('selling')->latest()->first();

		$sumtotalprice = 0;
		$order = DB::table('orders')->where('order_ref',$export->export_id)->get();
		$status = 1;
		$balance = 0;

		DB::table('orders')->where('order_ref',$export->export_id)->update(['order_balance'=>$balance,'order_status'=>$status,'updated_at'=> new DateTime()]);
		foreach ($order as $value) {
			$product 			= DB::table('product')->where('product_id',$value->order_productid)->first();

			// $processproduct 	= DB::table('processingunit')->where('unit_productid',$product->product_id);
			// if($value->order_typeunit == '1'){
			// 	$processproduct = $processproduct->where('unit_unitfirst',$value->order_unit)->first();
			// }else{
			// 	$processproduct = $processproduct->where('unit_unitsec',$value->order_unit)->first();
			// }
			$qstock 			= DB::table('product_stock')->where('product_id',$product->product_id)->where('product_qty','>',0)->first();
			// if(empty( $processproduct)){
			// 	$unit_total = 1;
			// }else{
			// 	$unit_total = $processproduct->unit_total;
			// }
			// if($value->order_typeunit == '1'){
			// 	$unitminus 			= $unit_total*$request->input('productqty')[$key];
			// }else{
			// 	$unitminus 			= $request->input('productqty')[$key];
			// }
			
			$unitsum			= $product->product_qty - $value->order_qty;
			$unitsumstock		= (!empty($qstock)?$qstock->product_qty:0) - $value->order_qty;
			// Update stock  ลูกค้ายังไม่ต้องการให้อัพเดทคลัง
			$pro 				= DB::table('product')->where('product_id',$product->product_id)->update(['product_qty' => $unitsum,'updated_at' => new DateTime()]);
			$stock 				= DB::table('product_stock')->where('product_id',$product->product_id)->where('product_sale',$value->order_price)->update(['product_qty' => $unitsumstock,'updated_at' => new DateTime()]); 
			// Update stock

			$detail = array(
				'sellingdetail_ref'				=>$lastid->selling_id,
				'sellingdetail_sellingref'		=>$export->export_id,
				'sellingdetail_productid'		=>$value->order_productid,
				'sellingdetail_price'			=>$value->order_price,
				'sellingdetail_typeunit'		=>$value->order_typeunit,
				'sellingdetail_unit'			=>$value->order_unit,
				'sellingdetail_capital'			=>$value->order_capital,
				'sellingdetail_qty'				=>$value->order_qty,
				'sellingdetail_count'			=>0,
				'sellingdetail_total'			=>$value->order_total,
				'sellingdetail_status'			=>'1', //ตอนแรกตั้งไว้เป็น1
				'created_at'					=>new DateTime(),
				'updated_at'					=>new DateTime()
			);
			DB::table('selling_detail')->insert($detail);
			$sumtotalprice += $value->order_total;
		}
			
		$sellingedittotal = selling::find($lastid->selling_id);
		$sellingedittotal->selling_total = $sumtotalprice;
		$sellingedittotal->selling_totalall = $sumtotalprice;
		$sellingedittotal->selling_totalpayment = $sumtotalprice;
		$sellingedittotal->save();
		
    	DB::table('export')->where('export_id',$export->export_id)->update(['export_status_online'=>'ชำระเงินแล้ว','export_status'=>'1','updated_at'=> new DateTime()]);

    	savelog('9','อัพเดทและส่งข้อมูลออเดอร์ไปส่วนการขาย ออเดอร์ลำดับที่ '.$export->export_id .'เป็นการขายลำดับที่ '.$lastid->selling_id.' ของลูกค้า '.$export->export_customername);
    	// dd($export);
		Session::flash('alert-insert','insert');
		// return redirect('export');
	}
}
