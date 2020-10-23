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
use Gloudemans\Shoppingcart\Facades\Cart;
use Auth;

class PosController extends Controller
{
	public function index(){
		$product 	= DB::table('product')->where('product_recommended',1)->get();
		$categorys 	= DB::table('category')->get();
		
		$data = [];
		if($product){
			foreach($product as $rs){
				$stock = DB::table('product_stock')->where('product_id',$rs->product_id)->where('product_qty','>',0)->orderBy('stock_id','asc')->first();
				if($stock){
					$data[] = [
						'productid'			=> $rs->product_id,
						'productname'		=> $rs->product_name,
						'productprice'		=> $stock->product_sale,
						'productpicture'	=> $rs->product_picture,
					];
				}
			}
		}
		return view('pos/index',['data' => $data,'categorys' => $categorys]);
	}
	
	public function querycarts(Request $request){
		$value = [];
		foreach(Cart::content() as $key => $ar){
			$value[] = [ 
				'rowid'		=> $ar->rowId,
				'id'		=> $ar->id,
				'name'		=> $ar->name,
				'price'		=> $ar->price,
				'qty'		=> $ar->qty,
				'code'		=> $ar->options['code'],
				'picture'	=> $ar->options['picture'],
			];
		}
		$totals = [
			'subtotal'	=> Cart::subtotal(),
			'tax'		=> Cart::tax(),
			'total'		=> Cart::total(),
		];
		
		return response()->json(['value' => $value,'totals' => $totals]);
	}
	
	public function posbarcode(Request $request){
		$product = DB::table('product')->where('product_code',$request->input('barcode'))->first();
		if($product){
			$stock = DB::table('product_stock')->where('product_id',$product->product_id)->where('product_qty','>',0)->orderBy('stock_id','asc')->first();
			if($stock){
				Cart::add(['id' => $product->product_id, 'name' => $product->product_name, 'qty' => 1, 'price' => $stock->product_sale, 'options' => ['code' => $product->product_code,'picture' => $product->product_picture,'unit' => $product->product_unit]]);
			}
		}
		
		$value = [];
		foreach(Cart::content() as $key => $ar){
			$value[] = [ 
				'rowid'		=> $ar->rowId,
				'id'		=> $ar->id,
				'name'		=> $ar->name,
				'price'		=> $ar->price,
				'qty'		=> $ar->qty,
				'code'		=> $ar->options['code'],
				'picture'	=> $ar->options['picture'],
			];
		}
		
		$totals = [
			'subtotal'	=> Cart::subtotal(),
			'tax'		=> Cart::tax(),
			'total'		=> Cart::total(),
		];
		
		return response()->json(['value' => $value,'totals' => $totals]);
	}
	
	public function addcart(Request $request){
		$product = DB::table('product')->where('product_id',$request->input('productid'))->first();
		if($product){
			$stock = DB::table('product_stock')->where('product_id',$product->product_id)->where('product_qty','>',0)->orderBy('stock_id','asc')->first();
			if($stock){
				Cart::add(['id' => $product->product_id, 'name' => $product->product_name, 'qty' => 1, 'price' => $stock->product_sale, 'options' => ['code' => $product->product_code,'picture' => $product->product_picture,'unit' => $product->product_unit]]);
			}
		}
		
		$value = [];
		foreach(Cart::content() as $key => $ar){
			$value[] = [ 
				'rowid'		=> $ar->rowId,
				'id'		=> $ar->id,
				'name'		=> $ar->name,
				'price'		=> $ar->price,
				'qty'		=> $ar->qty,
				'code'		=> $ar->options['code'],
				'picture'	=> $ar->options['picture'],
			];
		}
		
		$totals = [
			'subtotal'	=> Cart::subtotal(),
			'tax'		=> Cart::tax(),
			'total'		=> Cart::total(),
		];
		
		return response()->json(['value' => $value,'totals' => $totals]);
	}
	
	public function updatecarts(Request $request){
		$value = [];
		Cart::update($request->input('rowId'), $request->input('qty'));
		foreach(Cart::content() as $key => $ar){
			$value[] = [ 
				'rowid'		=> $ar->rowId,
				'id'		=> $ar->id,
				'name'		=> $ar->name,
				'price'		=> $ar->price,
				'qty'		=> $ar->qty,
				'code'		=> $ar->options['code'],
				'picture'	=> $ar->options['picture'],
			];
		}
		$totals = [
			'subtotal'	=> Cart::subtotal(),
			'tax'		=> Cart::tax(),
			'total'		=> Cart::total(),
		];
		
		return response()->json(['value' => $value,'totals' => $totals]);
	}
	
	public function delcarts(Request $request){
		$value = [];
		Cart::remove($request->input('rowId'));
		foreach(Cart::content() as $key => $ar){
			$value[] = [ 
				'rowid'		=> $ar->rowId,
				'id'		=> $ar->id,
				'name'		=> $ar->name,
				'price'		=> $ar->price,
				'qty'		=> $ar->qty,
				'code'		=> $ar->options['code'],
				'picture'	=> $ar->options['picture'],
			];
		}
		$totals = [
			'subtotal'	=> Cart::subtotal(),
			'tax'		=> Cart::tax(),
			'total'		=> Cart::total(),
		];
		
		return response()->json(['value' => $value,'totals' => $totals]);
	}
	
	public function poscategory(Request $request){
		
		if($request->input('cateid') == 0){
			$product 	= DB::table('product')->where('product_recommended',1)->get();
		}else{
			$product 	= DB::table('product')->where('product_category',$request->input('cateid'))->get();
		}
		
		
		$data = [];
		if($product){
			foreach($product as $rs){
				$stock = DB::table('product_stock')->where('product_id',$rs->product_id)->where('product_qty','>',0)->orderBy('stock_id','asc')->first();
				if($stock){
					$data[] = [
						'productid'			=> $rs->product_id,
						'productname'		=> $rs->product_name,
						'productprice'		=> number_format($stock->product_sale,2),
						'productpicture'	=> $rs->product_picture,
					];
				}
			}
		}
		
		return Response::json($data);
	}
	
	public function poskeyword(Request $request){
		
		$product 	= DB::table('product')->where('product_name','like','%'.$request->input('keyword').'%')->get();
		
		$data = [];
		if($product){
			foreach($product as $rs){
				$stock = DB::table('product_stock')->where('product_id',$rs->product_id)->where('product_qty','>',0)->orderBy('stock_id','asc')->first();
				if($stock){
					$data[] = [
						'productid'			=> $rs->product_id,
						'productname'		=> $rs->product_name,
						'productprice'		=> number_format($stock->product_sale,2),
						'productpicture'	=> $rs->product_picture,
					];
				}
			}
		}
		
		return Response::json($data);
	}
	
	public function pospayment(){
		$dateY	 	= date('Y');
		$dateM 		= date('m');
		$dateD 		= date('d');
		$cutdate 	= substr($dateY,2,2);
		$strdate 	= $cutdate.$dateM.$dateD;
		$invoice	= DB::table('export')->where('export_inv','like',$strdate."%")->orderBy('export_id','desc')->first();
		
		if(!empty($invoice)){
			$str = $invoice->export_inv;
			$sub = substr($str,6,3)+1;
			$cut = substr($str,0,6);
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
			'export_inv'			=> $inv,
			'export_date'			=> date('Y-m-d'),
			'export_empid'			=> Auth::user()->id,
			'export_empname'		=> Auth::user()->name,
			'export_customerid'		=> 1,
			'export_customername'	=> 'เงินสด',
			'export_total'			=> Cart::subtotal(2,'.',''),
			'export_discount'		=> 0,
			'export_discountsum'	=> 0,
			'export_lastbill'		=> 0,
			'export_vat'			=> '7',
			'export_vatsum'			=> Cart::tax(2,'.',''),
			'export_totalall'		=> Cart::total(2,'.',''),
			'export_totalpayment'	=> Cart::total(2,'.',''),
			'export_status'			=> 1,
			'created_at'			=> new DateTime(),
			'updated_at'			=> new DateTime(),
		];
		DB::table('export')->insert($data);
		$lastid = DB::table('export')->latest()->first();	
		
		foreach(Cart::content() as $row){
			$product 			= DB::table('product')->where('product_id',$row->id)->first();
			$processproduct 	= DB::table('processingunit')->where('unit_productid',$product->product_id)->where('unit_unitfirst',$row->options->unit)->first();
			$qstock 			= DB::table('product_stock')->where('product_id',$product->product_id)->where('product_sale',$row->price)->first();
			
			$unitminus 			= $processproduct->unit_total*$row->qty;
			$unitsum			= $product->product_qty - $unitminus;
			$unitsumstock		= $qstock->product_qty - $unitminus;
			
			//Update stock
			$pro 				= DB::table('product')->where('product_id',$product->product_id)->update(['product_qty' => $unitsum,'updated_at' => new DateTime()]);
			$stock 				= DB::table('product_stock')->where('product_id',$product->product_id)->where('stock_id',$row->price)->update(['product_qty' => $unitsumstock,'updated_at' => new DateTime()]); 
			
			$detail = array(
				'order_ref'				=>$lastid->export_id,
				'order_productid'		=>$row->id,
				'order_price'			=>$row->price,
				'order_capital'			=>$row->price,
				'order_qty'				=>$row->qty,
				'order_total'			=>$row->price*$row->qty,
				'order_status'			=>1,
				'created_at'			=>new DateTime(),
				'updated_at'			=>new DateTime()
			);
			
			DB::table('orders')->insert($detail);
		}
		Cart::destroy();
		Session::flash('alert-insert','insert');
		return redirect('pos');
	}
	
	public function postreset(){
		Cart::destroy();
		return redirect('pos');
	}
}
