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
use PDF;
use Excel;

class ReportorderController extends Controller
{
	//ปเลี่ยนข้อมูลการwhere สถานะจาก where('order_status','') เป็น wherein('export_status',[0,7])
	public function index(){
		$data = DB::table('supplier')->get();
		return view('report/reportorder',['data' => $data]);
	}
	
	public function search(Request $request){
		$strstart = '';
		$strend = '';
		if($request->input('start')){
			$start 		= explode('/',$request->input('start'));
			$strstart 	= $start[2]."-".$start[1]."-".$start[0];
		}

		if($request->input('end')){
			$end 		= explode('/',$request->input('end'));
			$strend 	= $end[2]."-".$end[1]."-".$end[0];
			$enddate 	= date('Y-m-d',strtotime($strend . "+1 days"));
		}
		
		
		$sale 	= DB::table('export')->leftjoin('orders','order_ref','export_id')->leftjoin('product','product_id','order_productid')->leftjoin('sub_import_product','sub_import_product.product_id','orders.order_productid')->leftjoin('import_product','import_product.imp_id','sub_import_product.imp_id')->select(DB::raw('export.*,product.*,orders.*'));
		if($strstart != '' && $strend != ''){
			$sale = $sale->whereBetween('export_date',[$strstart,$strend]);
		}else if($strstart != '' && $strend == ''){
			$strend = date("Y-m-d");
			$sale = $sale->whereBetween('export_date',[$strstart,$strend]);
		}
		if($request->input('namesupplier')){
			$sale = $sale->where('supplier_id',$request->input('namesupplier'));
		}
		if($request->input('producttype')){
			$sale = $sale->where('product_type',$request->input('producttype'));
		}
		$sale = $sale->wherein('export_status',[0,7])->wherein('order_status',['',3])->groupBy('order_productid')->get();
		// 
		// 
		$results = [];
		$sumtotal = 0;
		$sumsale = 0;
		if($sale){
			foreach($sale as $rs){
				// $sumbig 	= DB::table('export')->leftjoin('orders','order_ref','export_id')->leftjoin('product','product_id','order_productid')->select(DB::raw('SUM(order_qty) as total_qty,SUM(order_total) as total_total,SUM(order_price) as total_price'))->where('order_typeunit','1')->where('order_productid',$rs->order_productid)->whereBetween('export_date',[$strstart,$strend])->first();
				// $sumsmall 	= DB::table('export')->leftjoin('orders','order_ref','export_id')->leftjoin('product','product_id','order_productid')->select(DB::raw('SUM(order_qty) as total_qty,SUM(order_total) as total_total,SUM(order_price) as total_price'))->where('order_typeunit','2')->where('order_productid',$rs->order_productid)->whereBetween('export_date',[$strstart,$strend])->first();
				$sumbig 	= DB::table('export')->leftjoin('orders','order_ref','export_id')->leftjoin('product','product_id','order_productid')->select(DB::raw('SUM(order_qty) as total_qty,SUM(order_total) as total_total,SUM(order_price) as total_price'))->where('order_typeunit','1')->where('order_productid',$rs->order_productid);
				$sumsmall 	= DB::table('export')->leftjoin('orders','order_ref','export_id')->leftjoin('product','product_id','order_productid')->select(DB::raw('SUM(order_qty) as total_qty,SUM(order_total) as total_total,SUM(order_price) as total_price'))->where('order_typeunit','2')->where('order_productid',$rs->order_productid);

				if($strstart != '' && $strend != ''){
					$sumbig = $sumbig->whereBetween('export_date',[$strstart,$strend]);
					$sumsmall = $sumsmall->whereBetween('export_date',[$strstart,$strend]);
				}else if($strstart != '' && $strend == ''){
					$strend = date("Y-m-d");
					$sumbig = $sumbig->whereBetween('export_date',[$strstart,$strend]);
					$sumsmall = $sumsmall->whereBetween('export_date',[$strstart,$strend]);
				}
				$sumbig = $sumbig->wherein('export_status',[0,7])->wherein('order_status',['',3])->first();
				$sumsmall = $sumsmall->wherein('export_status',[0,7])->wherein('order_status',['',3])->first();

				$sumsale += $rs->export_totalpayment;
				$sumtotal 	+= $rs->order_total;
				$supplier 	= DB::table('sub_import_product')->leftjoin('import_product','import_product.imp_id','sub_import_product.imp_id')->leftjoin('supplier','supplier.supplier_id','import_product.supplier_id')->where('product_id',$rs->order_productid)->groupBy('supplier.supplier_id')->get();
				$suppliername = [];
				$suppliertel = [];
				if(count($supplier)>0){
					$suppliername = $supplier;
					$suppliertel = $supplier;
				}
				$bigunit = $sumbig->total_qty;
				$smallunit = $sumsmall->total_qty;
				$unitbigname ='';
				$unitsmallname ='';
				if($rs->order_unit != ''){
					
					$unitdata 	= DB::table('processingunit')->leftjoin('unit','unit.unit_id','=','processingunit.unit_unitfirst')->leftjoin('unitsub','unitsub.unitsub_id','=','processingunit.unit_unitsec')->where('unit_productid',$rs->product_id)->first();
					if(count($unitdata) > 0){
						// if($rs->order_typeunit == '1'){
							// $bigunit += $rs->order_qty;
							$unitbigname = ' ( '.$unitdata->unit_name.' ) ';
						// }else{
							// $smallunit += $rs->order_qty;
							$unitsmallname = ' ( '.$unitdata->unitsub_name.' ) ';
						// }
					}else{
						$unit 		= DB::table('unit')->where('unit_id',$rs->product_unit)->first();
						if(count($unit) > 0){
							$unitbigname = ' ( '.$unit->unit_name.' ) ';
							$unitsmallname = '';
						}
					}


				}				
				if($rs->product_type == '2'){
					$typeproduct = "สินค้าผลิตเอง";
				}else{
					$typeproduct = "สินค้าซื้อเข้ามา";
				}

				$results[] = [
					'code'		=> $rs->product_code,
					'name'		=> $rs->product_name,
					'typeproduct'		=> $typeproduct,
					'supplier_name'		=> $suppliername,
					'supplier_tel'		=> $suppliertel,
					// 'unit'		=> $unitname,
					'price'		=> number_format($rs->order_price,2),
					// 'capital'	=> number_format($rs->order_capital,2),
					'bigunit'		=> number_format($bigunit).$unitbigname,
					'smallunit'		=> number_format($smallunit).$unitsmallname,
					'total'		=> number_format($rs->order_total,2),
					'product_qty'		=> number_format($rs->product_qty,2),
				];
			}
		}
		$total[] = ['sumtotal' => number_format($sumtotal,2),'sumsale' => number_format($sumsale,2),'totals' => number_format($sumsale-$sumtotal,2)];
		return Response::json(['results' => $results,'total' => $total]);
	}

	public function exportexcel($starts,$ends,$producttype,$namesupplier){
		if(strlen($starts) > 2){
			$strstart = $starts;
		}else{
			$strstart = '';
		}
		if(strlen($ends) > 2){
			$strend = $ends;
		}else{
			$strend = '';
		}
		// if($starts){
		// 	$start 		= explode('/',$starts);
		// 	$strstart 	= $start[2]."-".$start[1]."-".$start[0];
		// }

		// if($ends){
		// 	$end 		= explode('/',$ends);
		// 	$strend 	= $end[2]."-".$end[1]."-".$end[0];
		// 	$enddate 	= date('Y-m-d',strtotime($strend . "+1 days"));
		// }
		
		$setting	= DB::table('setting')->first();
		$sale 	= DB::table('export')->leftjoin('orders','order_ref','export_id')->leftjoin('product','product_id','order_productid')->leftjoin('sub_import_product','sub_import_product.product_id','orders.order_productid')->leftjoin('import_product','import_product.imp_id','sub_import_product.imp_id');
		if($strstart != '' && $strend != ''){
			$sale = $sale->whereBetween('export_date',[$strstart,$strend]);
		}else if($strstart != '' && $strend == ''){
			$strend = date("Y-m-d");
			$sale = $sale->whereBetween('export_date',[$strstart,$strend]);
		}
		if($producttype != '-'){
			$sale = $sale->where('product_type',$producttype);
		}
		if($namesupplier != '-'){
			$sale = $sale->where('supplier_id',$namesupplier);
		}
		$sale = $sale->wherein('export_status',[0,7])->wherein('order_status',['',3])->groupBy('order_productid')->get();

		$results = [];
		$sumtotal = 0;
		$sumsale = 0;
		
		$data = [];
		if($sale){
			foreach($sale as $rs){
				$sumbig 	= DB::table('export')->leftjoin('orders','order_ref','export_id')->leftjoin('product','product_id','order_productid')->select(DB::raw('SUM(order_qty) as total_qty,SUM(order_total) as total_total,SUM(order_price) as total_price'))->where('order_typeunit','1')->where('order_productid',$rs->order_productid);
				$sumsmall 	= DB::table('export')->leftjoin('orders','order_ref','export_id')->leftjoin('product','product_id','order_productid')->select(DB::raw('SUM(order_qty) as total_qty,SUM(order_total) as total_total,SUM(order_price) as total_price'))->where('order_typeunit','2')->where('order_productid',$rs->order_productid);

				if($strstart != '' && $strend != ''){
					$sumbig = $sumbig->whereBetween('export_date',[$strstart,$strend]);
					$sumsmall = $sumsmall->whereBetween('export_date',[$strstart,$strend]);
				}else if($strstart != '' && $strend == ''){
					$strend = date("Y-m-d");
					$sumbig = $sumbig->whereBetween('export_date',[$strstart,$strend]);
					$sumsmall = $sumsmall->whereBetween('export_date',[$strstart,$strend]);
				}
				$sumbig = $sumbig->wherein('export_status',[0,7])->wherein('order_status',['',3])->first();
				$sumsmall = $sumsmall->wherein('export_status',[0,7])->wherein('order_status',['',3])->first();

				$sumsale += $rs->export_totalpayment;
				$sumtotal 	+= $rs->order_total;
				$supplier 	= DB::table('sub_import_product')->leftjoin('import_product','import_product.imp_id','sub_import_product.imp_id')->leftjoin('supplier','supplier.supplier_id','import_product.supplier_id')->where('product_id',$rs->order_productid)->groupBy('supplier.supplier_id')->get();
				$suppliername = [];
				$suppliertel = [];
				if(count($supplier)>0){
					$suppliername = $supplier;
					$suppliertel = $supplier;
				}
				$bigunit = $sumbig->total_qty;
				$smallunit = $sumsmall->total_qty;
				$unitbigname ='';
				$unitsmallname ='';
				if($rs->order_unit != ''){
					
					$unitdata 	= DB::table('processingunit')->leftjoin('unit','unit.unit_id','=','processingunit.unit_unitfirst')->leftjoin('unitsub','unitsub.unitsub_id','=','processingunit.unit_unitsec')->where('unit_productid',$rs->product_id)->first();
					if(count($unitdata) > 0){
						$unitbigname = ' ( '.$unitdata->unit_name.' ) ';
						$unitsmallname = ' ( '.$unitdata->unitsub_name.' ) ';
					}else{
						$unit 		= DB::table('unit')->where('unit_id',$rs->product_unit)->first();
						if(count($unit) > 0){
							$unitbigname = ' ( '.$unit->unit_name.' ) ';
							$unitsmallname = '';
						}
					}


				}
				if($rs->product_type == '2'){
					$typeproduct = "สินค้าผลิตเอง";
				}else{
					$typeproduct = "สินค้าซื้อเข้ามา";
				}
				$results[] = [
					'code'		=> $rs->product_code,
					'name'		=> $rs->product_name,
					'typeproduct'		=> $typeproduct,
					'supplier_name'		=> $suppliername,
					'supplier_tel'		=> $suppliertel,
					// 'unit'		=> $unitname,
					'price'		=> number_format($rs->order_price,2),
					// 'capital'	=> number_format($rs->order_capital,2),
					'bigunit'		=> number_format($bigunit).$unitbigname,
					'smallunit'		=> number_format($smallunit).$unitsmallname,
					'total'		=> number_format($rs->order_total,2),
					'product_qty'		=> number_format($rs->product_qty,2),
				];
			}
		}
		$date = [
			'start'		=> $starts,
			'end'		=> $ends
		];
		$file = storage_path('template/exportorder.xlsx');
		Excel::load($file, function($doc) use($setting,$results,$date) {
			$sheet = $doc->setActiveSheetIndex(0);
			$row = 7;
			$sheet->setCellValue('A3',$setting->set_name);
			$sheet->setCellValue('A4',$setting->set_address);
			$sheet->setCellValue('A5','เบอร์โทร  Fax -');
			$sheet->setCellValue('E3','วันที่ปัจจุบัน  '.date('d/m/Y'));
			$sheet->setCellValue('E4','วันที่สืบค้น  '.date('d/m/Y',strtotime($date['start'])).' - '.date('d/m/Y',strtotime($date['end'])));
			
			$num = 1;
			if(count($results) > 0){
				foreach($results as $rs){
					$suppliername = '';
					$suppliertel = '';
					
					foreach($rs['supplier_name'] as $key2 => $item2){
						// dd($item2->supplier_name);
						if($item2->supplier_name){
							$suppliername .= $item2->supplier_name;
							$suppliertel .= $item2->supplier_tel;
							// dd($suppliername);
							if($key2 != count($rs['supplier_name'])-1){
								$suppliername += ' , ';
								$suppliertel += ' , ';
							}
						}
					}
					// dd($suppliername);
					$sheet->setCellValue('A'.$row.'',$num);
					$sheet->setCellValue('B'.$row.'',$rs['code']);
					$sheet->setCellValue('C'.$row.'',$rs['name']);
					$sheet->setCellValue('D'.$row.'',$rs['typeproduct']);
					$sheet->setCellValue('E'.$row.'',$suppliername);
					$sheet->setCellValue('F'.$row.'',$suppliertel);
					$sheet->setCellValue('G'.$row.'',$rs['bigunit']);
					$sheet->setCellValue('H'.$row.'',$rs['smallunit']);
					$sheet->setCellValue('I'.$row.'','');
					$sheet->setCellValue('J'.$row.'','');
					$sheet->setCellValue('k'.$row.'',$rs['product_qty']);
					$num++;
					$row++;
				}

				if($row%37 != 0){
					$count = $row;
					for($x=$row%37;$x <= 37;$x++){
						$sheet->setCellValue('A'.$count.'','');
						$sheet->setCellValue('B'.$count.'','');
						$sheet->setCellValue('C'.$count.'','');
						$sheet->setCellValue('D'.$count.'','');
						$sheet->setCellValue('E'.$count.'','');
						$sheet->setCellValue('F'.$count.'','');
						$sheet->setCellValue('G'.$count.'','');
						$sheet->setCellValue('H'.$count.'','');
						$sheet->setCellValue('I'.$count.'','');
						$sheet->setCellValue('J'.$count.'','');
						$sheet->setCellValue('k'.$count.'','');
						$count++;
					}
				}
			}
			savelog('12','ออกรายงานออเดอร์เป็นไฟล์ Excel ');
			
			
		})->download('xlsx');
	}
	
	public function reportpdf(Request $request){
        $strstart = '';
		$strend = '';
		if($request->input('datestart')){
			$start 		= explode('/',$request->input('datestart'));
			$strstart 	= $start[2]."-".$start[1]."-".$start[0];
		}

		if($request->input('dateend')){
			$end 		= explode('/',$request->input('dateend'));
			$strend 	= $end[2]."-".$end[1]."-".$end[0];
			$enddate 	= date('Y-m-d',strtotime($strend . "+1 days"));
		}
		
		
		$sale 	= DB::table('export')->leftjoin('orders','order_ref','export_id')->leftjoin('product','product_id','order_productid')->leftjoin('sub_import_product','sub_import_product.product_id','orders.order_productid')->leftjoin('import_product','import_product.imp_id','sub_import_product.imp_id');
		if($strstart != '' && $strend != ''){
			$sale = $sale->whereBetween('export_date',[$strstart,$strend]);
		}else if($strstart != '' && $strend == ''){
			$strend = date("Y-m-d");
			$sale = $sale->whereBetween('export_date',[$strstart,$strend]);
		}
		if($request->input('namesupplier')){
			$sale = $sale->where('supplier_id',$request->input('namesupplier'));
		}
		if($request->input('producttype')){
			$sale = $sale->where('product_type',$request->input('producttype'));
			if($request->input('producttype') == '2'){
				$showtype = "สินค้าผลิตเอง";
			}else{
				$showtype = "สินค้าซื้อเข้ามา";
			}
		}else{
			$showtype = 'สินค้าผลิตเอง , สินค้าซื้อเข้ามา';
		}
		$sale = $sale->wherein('export_status',[0,7])->wherein('order_status',['',3])->groupBy('order_productid')->get();
		// 
		// 
		$results = [];
		$sumtotal = 0;
		$sumsale = 0;
		if($sale){
			foreach($sale as $rs){
				// $sumbig 	= DB::table('export')->leftjoin('orders','order_ref','export_id')->leftjoin('product','product_id','order_productid')->select(DB::raw('SUM(order_qty) as total_qty,SUM(order_total) as total_total,SUM(order_price) as total_price'))->where('order_typeunit','1')->where('order_productid',$rs->order_productid)->whereBetween('export_date',[$strstart,$strend])->first();
				// $sumsmall 	= DB::table('export')->leftjoin('orders','order_ref','export_id')->leftjoin('product','product_id','order_productid')->select(DB::raw('SUM(order_qty) as total_qty,SUM(order_total) as total_total,SUM(order_price) as total_price'))->where('order_typeunit','2')->where('order_productid',$rs->order_productid)->whereBetween('export_date',[$strstart,$strend])->first();
				$sumbig 	= DB::table('export')->leftjoin('orders','order_ref','export_id')->leftjoin('product','product_id','order_productid')->select(DB::raw('SUM(order_qty) as total_qty,SUM(order_total) as total_total,SUM(order_price) as total_price'))->where('order_typeunit','1')->where('order_productid',$rs->order_productid);
				$sumsmall 	= DB::table('export')->leftjoin('orders','order_ref','export_id')->leftjoin('product','product_id','order_productid')->select(DB::raw('SUM(order_qty) as total_qty,SUM(order_total) as total_total,SUM(order_price) as total_price'))->where('order_typeunit','2')->where('order_productid',$rs->order_productid);

				if($strstart != '' && $strend != ''){
					$sumbig = $sumbig->whereBetween('export_date',[$strstart,$strend]);
					$sumsmall = $sumsmall->whereBetween('export_date',[$strstart,$strend]);
				}else if($strstart != '' && $strend == ''){
					$strend = date("Y-m-d");
					$sumbig = $sumbig->whereBetween('export_date',[$strstart,$strend]);
					$sumsmall = $sumsmall->whereBetween('export_date',[$strstart,$strend]);
				}
				$sumbig = $sumbig->wherein('export_status',[0,7])->wherein('order_status',['',3])->first();
				$sumsmall = $sumsmall->wherein('export_status',[0,7])->wherein('order_status',['',3])->first();

				$sumsale += $rs->export_totalpayment;
				$sumtotal 	+= $rs->order_total;
				$supplier 	= DB::table('sub_import_product')->leftjoin('import_product','import_product.imp_id','sub_import_product.imp_id')->leftjoin('supplier','supplier.supplier_id','import_product.supplier_id')->where('product_id',$rs->order_productid)->groupBy('supplier.supplier_id')->get();
				$suppliername = [];
				$suppliertel = [];
				if(count($supplier)>0){
					$suppliername = $supplier;
					$suppliertel = $supplier;
				}
				$bigunit = $sumbig->total_qty;
				$smallunit = $sumsmall->total_qty;
				$unitbigname ='';
				$unitsmallname ='';
				if($rs->order_unit != ''){
					
					$unitdata 	= DB::table('processingunit')->leftjoin('unit','unit.unit_id','=','processingunit.unit_unitfirst')->leftjoin('unitsub','unitsub.unitsub_id','=','processingunit.unit_unitsec')->where('unit_productid',$rs->product_id)->first();
					if(count($unitdata) > 0){
						// if($rs->order_typeunit == '1'){
							// $bigunit += $rs->order_qty;
							$unitbigname = ' ( '.$unitdata->unit_name.' ) ';
						// }else{
							// $smallunit += $rs->order_qty;
							$unitsmallname = ' ( '.$unitdata->unitsub_name.' ) ';
						// }
					}else{
						$unit 		= DB::table('unit')->where('unit_id',$rs->product_unit)->first();
						if(count($unit) > 0){
							$unitbigname = ' ( '.$unit->unit_name.' ) ';
							$unitsmallname = '';
						}
					}


				}				
				if($rs->product_type == '2'){
					$typeproduct = "สินค้าผลิตเอง";
				}else{
					$typeproduct = "สินค้าซื้อเข้ามา";
				}
				$results[] = [
					'code'		=> $rs->product_code,
					'date'		=> $rs->export_date,
					'name'		=> $rs->product_name,
					'typeproduct'		=> $typeproduct,
					'supplier_name'		=> $suppliername,
					'supplier_tel'		=> $suppliertel,
					// 'unit'		=> $unitname,
					'price'		=> number_format($rs->order_price,2),
					// 'capital'	=> number_format($rs->order_capital,2),
					'bigunit'		=> number_format($bigunit).$unitbigname,
					'smallunit'		=> number_format($smallunit).$unitsmallname,
					'total'		=> number_format($rs->order_total,2),
					'product_qty'		=> number_format($rs->product_qty,2),
				];
			}
		}
		$total[] = ['sumtotal' => number_format($sumtotal,2),'sumsale' => number_format($sumsale,2),'totals' => number_format($sumsale-$sumtotal,2)];

        $pdf = PDF::loadView('reportpdf/reportpdforder',['results' => $results,'total' => $total,'datestart'=>$request->input('datestart'),'dateend'=>$request->input('dateend'),'showtype'=>$showtype],[],['orientation' => 'L', 'format' => 'A4-L']);
        savelog('12','ออกรายงานออเดอร์เป็นไฟล์ PDF ');
        return $pdf->stream();
	}
}
