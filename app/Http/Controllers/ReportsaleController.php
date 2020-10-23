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

class ReportsaleController  extends Controller
{
    public function index(){
		return view('report/sale');
	}
	
	public function reportdatasale(Request $request){
		$start 		= explode('/',$request->input('start'));
		$strstart 	= $start[2]."-".$start[1]."-".$start[0];
		$end 		= explode('/',$request->input('end'));
		$strend 	= $end[2]."-".$end[1]."-".$end[0];
		$enddate 	= date('Y-m-d',strtotime($strend . "+1 days"));
		
		$sale 	= DB::table('export')->whereBetween('export_date',[$strstart,$enddate])->where('export_customername','like','%'.$request->input('customer').'%')->get();
		// where('export_status',1)->
		$results = [];
		$sumtotal = 0;
		$sumsale = 0;
		if($sale){
			foreach($sale as $rs){
				$sumsale += $rs->export_totalpayment;
				$order = DB::table('orders')->where('order_ref',$rs->export_id)->get();
				if($order){
					foreach($order as $ar){
						$sumtotal 	+= $ar->order_total;
						$product 	= DB::table('product')->where('product_id',$ar->order_productid)->first();
						$unit 		= DB::table('unit')->where('unit_id',$product->product_unit)->first();
						$stock 		= DB::table('product_stock')->where('product_id',$ar->order_productid)->where('product_sale',$ar->order_price)->first();
						
						$results[] = [
							'inv'		=> $rs->export_inv,
							'date'		=> date('d/m/Y',strtotime($rs->export_date)),
							'code'		=> $product->product_code,
							'name'		=> $product->product_name,
							'unit'		=> $unit->unit_name,
							'price'		=> number_format($ar->order_price,2),
							'capital'	=> number_format($ar->order_capital,2),
							'qty'		=> number_format($ar->order_qty),
							'total'		=> number_format($ar->order_total,2),
						];
					}
				}
			}
		}
		$total[] = ['sumtotal' => number_format($sumtotal,2),'sumsale' => number_format($sumsale,2),'totals' => number_format($sumsale-$sumtotal,2)];
		return Response::json(['results' => $results,'total' => $total]);
	}
	
	public function salepdf(Request $request){
		$start 		= explode('/',$request->input('datestart'));
		$strstart 	= $start[2]."-".$start[1]."-".$start[0];
		$end 		= explode('/',$request->input('dateend'));
		$strend 	= $end[2]."-".$end[1]."-".$end[0];
		$enddate 	= date('Y-m-d',strtotime($strend . "+1 days"));
		
		$exp 		= DB::table('exp')->whereBetween('exp_date',[$strstart,$enddate])->get();
		$setting	= DB::table('setting')->first();
		
		$data = [];
		if($exp){
			foreach($exp as $rs){
				$subexp = DB::table('subexp')->where('subexp_ref',$rs->exp_id)->get();
				if($subexp){
					foreach($subexp as $ar){
						$product 	= DB::table('product')->where('product_id',$ar->subexp_productid)->first();
						$unit 		= DB::table('unit')->where('unit_id',$product->product_unit)->first();
						$stock 		= DB::table('product_stock')->where('stock_id',$ar->subexp_stock)->first();
						
						if($ar->subexp_status == 0){
							$status = 'หาย';
						}elseif($ar->subexp_status == 1){
							$status = 'ชำรุด';
						}elseif($ar->subexp_status == 2){
							$status = 'หมดอายุ';
						}
						
												
						$data[$rs->exp_inv][] = [
							'inv'		=> $rs->exp_inv,
							'date'		=> date('d/m/Y',strtotime($rs->exp_date)),
							'code'		=> $product->product_code,
							'name'		=> $product->product_name,
							'unit'		=> $unit->unit_name,
							'lot'		=> number_format($stock->product_sale,2),
							'qty'		=> number_format($ar->subexp_qty),
							'status'	=> $status,
						];
					}
				}
			}
		}
		$date = [
			'start'		=> $request->input('datestart'),
			'end'		=> $request->input('dateend'),
		];
						
		$pdf = PDF::loadView('report.reportexport',['data' => $data,'setting' => $setting,'date' => $date],[],['title' => 'รายงานสินค้านำออก','format'=>'A4']);
	    return $pdf->stream();
	}
	
	public function saleexcel($starts,$ends){
		$start 		= explode('-',$starts);
		$strstart 	= $start[2]."-".$start[1]."-".$start[0];
		$end 		= explode('-',$ends);
		$strend 	= $end[2]."-".$end[1]."-".$end[0];
		$enddate 	= date('Y-m-d',strtotime($strend . "+1 days"));
		
		$exp 		= DB::table('exp')->whereBetween('exp_date',[$strstart,$enddate])->get();
		$setting	= DB::table('setting')->first();
		
		$data = [];
		if($exp){
			foreach($exp as $rs){
				$subexp = DB::table('subexp')->where('subexp_ref',$rs->exp_id)->get();
				if($subexp){
					foreach($subexp as $ar){
						$product 	= DB::table('product')->where('product_id',$ar->subexp_productid)->first();
						$unit 		= DB::table('unit')->where('unit_id',$product->product_unit)->first();
						$stock 		= DB::table('product_stock')->where('stock_id',$ar->subexp_stock)->first();
						
						if($ar->subexp_status == 0){
							$status = 'หาย';
						}elseif($ar->subexp_status == 1){
							$status = 'ชำรุด';
						}elseif($ar->subexp_status == 2){
							$status = 'หมดอายุ';
						}
						
												
						$data[] = [
							'inv'		=> $rs->exp_inv,
							'date'		=> date('d/m/Y',strtotime($rs->exp_date)),
							'code'		=> $product->product_code,
							'name'		=> $product->product_name,
							'unit'		=> $unit->unit_name,
							'lot'		=> number_format($stock->product_sale,2),
							'qty'		=> number_format($ar->subexp_qty),
							'status'	=> $status,
						];
					}
				}
			}
		}
		$date = [
			'start'		=> $starts,
			'end'		=> $ends
		];
		
		$file = storage_path('template/export.xlsx');
		Excel::load($file, function($doc) use($setting,$data,$date) {
			$sheet = $doc->setActiveSheetIndex(0);
			$row = 7;
			$sheet->setCellValue('A3',$setting->set_name);
			$sheet->setCellValue('A4',$setting->set_address);
			$sheet->setCellValue('A5','เบอร์โทร  Fax -');
			$sheet->setCellValue('D3',date('d/m/Y'));
			$sheet->setCellValue('D4','วันที่สืบค้น  '.$date['start'].' - '.$date['end']);
			
			$num = 1;
			if(count($data) > 0){
				foreach($data as $rs){
					$sheet->setCellValue('A'.$row.'',$num);
					$sheet->setCellValue('B'.$row.'',$rs['date']);
					$sheet->setCellValue('C'.$row.'',$rs['inv']);
					$sheet->setCellValue('D'.$row.'',$rs['name']);
					$sheet->setCellValue('E'.$row.'',$rs['qty'].'  '.$rs['unit']);
					$sheet->setCellValue('F'.$row.'',$rs['status']);
					$num++;
					$row++;
				}
			}
			
		})->download('xlsx');
	}
}
