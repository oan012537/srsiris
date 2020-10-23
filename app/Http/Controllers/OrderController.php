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

class OrderController  extends Controller
{
    public function index(){
		return view('order/index');
	}
	
	public function datatable(){
		$export = DB::table('exp')->get();
		
		$sQuery	= Datatables::of($export)
		->editColumn('updated_at',function($data){
			return date('d/m/Y',strtotime($data->updated_at));
		})
		->editColumn('exp_date',function($data){
			return date('d/m/Y',strtotime($data->exp_date));
		});
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function create(){
		$dateY	 	= date('Y');
		$dateM 		= date('m');
		$dateD 		= date('d');
		$cutdate 	= substr($dateY,2,2);
		$strdate 	= 'Ex'.$cutdate.$dateM.$dateD;
		$invoice	= DB::table('exp')->where('exp_inv','like',$strdate."%")->orderBy('exp_id','desc')->first();
		return view('order/create',['invoice' => $invoice]);
	}
	
	public function store(Request $request){
		if($request->input('vat') == 0){
			$vat = '0';
		}else if($request->input('vat') == 1){
			$vat = '7';
		}else if($request->input('vat') == 2){
			$vat = '-7';
		}
		
		$date = explode('/',$request->input('docdate'));
		$data = [
			'exp_inv'			=> $request->input('invoice'),
			'exp_date'			=> $date[2].'-'.$date[1].'-'.$date[0],
			'exp_emp'			=> $request->input('empsaleid'),
			'exp_status'		=> $request->input('status'),
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		];
		DB::table('exp')->insert($data);
		$lastid = DB::table('exp')->latest()->first();	
		
		if($request->input('productid')){
			foreach($request->input('productid') as $key => $row){
				$product 			= DB::table('product')->where('product_id',$request->input('productid')[$key])->first();
				$processproduct 	= DB::table('processingunit')->where('unit_productid',$product->product_id)->where('unit_unitfirst',$product->product_unit)->first();
				$qstock 			= DB::table('product_stock')->where('stock_id',$request->input('productprice')[$key])->first();
				
				$unitminus 			= $processproduct->unit_total*$request->input('productqty')[$key];
				$unitsum			= $product->product_qty - $unitminus;
				$unitsumstock		= $qstock->product_qty - $unitminus;
				
				//Update stock
				$pro 				= DB::table('product')->where('product_id',$product->product_id)->update(['product_qty' => $unitsum,'updated_at' => new DateTime()]);
				$stock 				= DB::table('product_stock')->where('product_id',$product->product_id)->where('stock_id',$request->input('productprice')[$key])->update(['product_qty' => $unitsumstock,'updated_at' => new DateTime()]); 
				
				$detail = array(
					'subexp_ref'			=>$lastid->exp_id,
					'subexp_productid'		=>$request->input('productid')[$key],
					'subexp_qty'			=>$request->input('productqty')[$key],
					'subexp_stock'			=>$request->input('productprice')[$key],
					'subexp_status'			=>$request->input('status'),
					'created_at'			=>new DateTime(), 
					'updated_at'			=>new DateTime()
				);
				
				DB::table('subexp')->insert($detail);
			}
		}
		
		Session::flash('alert-insert','insert');
		return redirect('exp');
	}
	
	public function enterbarcodeex(Request $request){
		$product = DB::table('product')->join('unit', 'product.product_unit', '=', 'unit.unit_id')->where('product_code',$request->input('barcode'))->first();
		
		$stock = DB::table('product_stock')->where('product_id',$product->product_id)->get();
		$stocks = '';
		if($stock){
			foreach($stock as $rs){
				$stocks .= '<option value="'.$rs->stock_id.'">'.$rs->product_sale.'</option>';
			}
		}
			
		$results[] = [
			'id'			=>$product->product_id,
			'code'			=>$product->product_code,
			'name'			=>$product->product_name,
			'unit'			=>$product->unit_name,
			'price'			=>$stocks,
		];
		return Response::json(['results' => $results]);
	}
	
	public function changqtyproduct(Request $request){
		Cart::update($request->input('id'), $request->input('qty'));
		$results = 1;
		return Response::json($results);
	}
	
	public function deldatapro(Request $request){
		Cart::remove($request->input('rowid'));
		
		$total 		= str_replace(',','',Cart::total());
		$tax 		=  str_replace(',','',Cart::tax());
		$totals 	= $total - $tax;
		$sumres 	= ['totals'		=>$totals];
		$results 	= [];
		foreach(Cart::content() as $row){
			$stock = DB::table('product_stock')->where('product_id',$row->id)->get();
			$stocks = '';
			if($stock){
				foreach($stock as $rs){
					$stocks .= '<option value="'.$rs->product_sale.'">'.$rs->product_sale.'</option>';
				}
			}
			
			$results[] = [
				'id'			=>$row->id,
				'rowid'			=>$row->rowId,
				'code'			=>$row->options->code,
				'name'			=>$row->name,
				'price'			=>$stocks,
				'qty'			=>$row->qty,
				'total'			=>$row->price*$row->qty,
				'unit'			=>$row->options->unit,
				'cate'			=>$row->options->cate,
				'subcate'		=>$row->options->subcate,
				'picture'		=>$row->options->picture,
			];
		}
		return Response::json(['results' => $results,'sumres' => $sumres]);
	}
	
	public function destroy($id){
		DB::table('export')->where('export_id',$id)->delete();
		DB::table('orders')->where('order_ref',$id)->delete();
		
		Session::flash('alert-delete','delete');
		return redirect('export');
	}

	public function showordernotproduct(){
		return view('alertorderproduct.not.index');
	}

	public function datatableordernotproduct(){
		$data = DB::table('alertordernoproduct')->leftjoin('orders','orders.order_id','alertordernoproduct.alertordernoproduct_orderid')->leftjoin('export','export.export_id','orders.order_ref')->leftjoin('product','product.product_id','orders.order_productid')->select(DB::raw('*,alertordernoproduct.update_at as updatedata'))->where('alertordernoproduct_status','!=','1');
		if(Auth::user()->position == '3'){
    		$data = $data->where('product_category',Auth::user()->groupcategory);
    	}
		$sQuery	= Datatables::of($data)
		->editColumn('updatedata',function($data){
			return date('d/m H:i',strtotime($data->updatedata));
		})
		->addColumn('unitname',function($data){
			if($data->order_typeunit == '1'){
				$unit = DB::table('unit')->where('unit_id',$data->order_unit)->first();
	            return $unit->unit_name;
			}else{
				$unit = DB::table('unitsub')->where('unitsub_id',$data->order_unit)->first();
	            return $unit->unitsub_name;
			}
		});
		// ->editColumn('export_inv',function($data){
		// 	return '<a href="export/checkdatapay/'.$data->export_id.'">'.$data->export_inv.'</a>';
		// });
		return $sQuery->escapeColumns([])->make(true);
	}

	public function approve($id){
		$data = [
			'alertordernoproduct_status'	=> '2',
			'alertordernoproduct_userupdate'=> Auth::user()->name
		];
		DB::table('alertordernoproduct')->where('alertordernoproduct_id',$id)->update($data);
		Session::flash('alert-insert','insert');
		return redirect('detailorderhnotproduct');

	}
}
