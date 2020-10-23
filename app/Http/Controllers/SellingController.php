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
use PDF;
use Mail;
use PHPMailer;
use \Milon\Barcode\DNS2D;
use Redirect;
use App\selling;
use App\sellingdetail;
use Auth;
use App\percendiscount;
class SellingController extends Controller
{
    public function index(){
    	// if(Auth::user()->position == 1){
    	// 	selling_empid
    	// }
    	$discount = percendiscount::all();
    	$customer = DB::table('customer')->get();
		return view('selling/index',['customer'=>$customer,'discount'=>$discount]);
	}
	
	public function datatable(){
		$dataserch = request('search')['value'];
		// $selling = DB::table('selling');
		$selling = DB::table('selling')->leftjoin('selling_detail','selling_detail.sellingdetail_ref','selling.selling_id')->leftjoin('product','product.product_id','selling_detail.sellingdetail_productid')->select('selling.*');
		if(Auth::user()->position > 2 && Auth::user()->position != 5){
    		$selling->where('selling_empid',Auth::id());
    	}
    	if($keyword = request('keyword')){
			if(!empty($keyword)){
				$keywords = explode(',',$keyword);
				if(count($keywords)>1){
					foreach ($keywords as $key => $values) {
						if($key == 0){
							$selling->whereRaw("(product_name LIKE '%".$values."%' )");
						}else{
							$selling->orwhereRaw("(product_name LIKE '%".$values."%' )");
						}
					}
				}else{
					$selling->where('product_name','LIKE','%'.$keyword.'%');
				}
				
			}
		}
		if($noorder = request('noorder')){
			$selling->where('selling_inv','like','%'.$noorder.'%');
		}
		$datestart = request('datestart');
		$dateend = request('dateend');
		if($datestart != '' && $dateend != ''){
			$datestart = explode('/',$datestart);
			$datestarts = $datestart[2].'-'.$datestart[1].'-'.$datestart[0];
			$dateend = explode('/',$dateend);
			$dateends = $dateend[2].'-'.$dateend[1].'-'.$dateend[0];

			$selling->whereBetween('selling_date',[$datestarts,$dateends]);
		}
		$customername = request('customername');
		if($customername != ''){
			$selling->where('selling_customerid','like',$customername.'%');
		}
		$staus = request('staus');
		if($staus != ''){
			$selling->where('selling_status','like',$staus.'%');
		}
		// dd($noorder);
		$selling = $selling->groupby('selling_id');
		$sQuery	= Datatables::of($selling)
		->filter(function ($query) use ($dataserch){
			$explodesearch = explode(',',$dataserch);
			// dd(count($explodesearch));
			foreach ($explodesearch as $value) {
				if($value != ''){
					$query->orwhere(function($querys) use ($value){
						$querys->where('selling_inv','like','%'.$value.'%')
						->orwhere('selling_date','like','%'.$value.'%')
						->orwhere('selling_customername','like','%'.$value.'%')
						->orwhere('selling_totalpayment','like','%'.$value.'%');
					});
				}
			}
		})
		->editColumn('selling_totalpayment',function($data){
			return empty($data->selling_totalpayment)?'-':number_format($data->selling_totalpayment,2);
		})
		->editColumn('updated_at',function($data){
			return date('d/m/Y',strtotime($data->updated_at));
		})
		->editColumn('created_at',function($data){
			return date('Y-m-d',strtotime($data->selling_date));
		})
		->editColumn('selling_date',function($data){
			return date('d/m/Y',strtotime($data->selling_date));
		})
		->editColumn('selling_inv',function($data){
			if($data->selling_status != '3' && $data->selling_status != ''){
				return '<a href="packing/'.$data->selling_inv.'">'.$data->selling_inv.'</a>';
			}else{
				return $data->selling_inv;
			}
			
		});
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function showorders(){
		$order = DB::table('selling')->where('selling_status',4)->get();
		$sQuery	= Datatables::of($order)
		->editColumn('selling_totalpayment',function($data){
			return number_format($data->export_totalpayment,2);
		})
		->editColumn('export_date',function($data){
			return date('d/m/Y',strtotime($data->export_date));
		});
		return $sQuery->escapeColumns([])->make(true);
	}
	public function searchexport(Request $request){
		$data 	= DB::table('selling')->leftJoin('selling','selling.selling_ref','=','selling.selling_id')->where('selling_id',$request->input('id'))->get();
		return Response::json($data);
	}
	public function searchproduct(Request $request){
		$customer 	= DB::table('customer')->where('customer_id',$request->input('cusid'))->first();
		// $product = DB::table('product')->join('unit', 'product.product_unit', '=', 'unit.unit_id')->where('product_id',$request->input('id'))->first();
		$data = DB::table('orders')->leftJoin('product', 'product.product_id', '=', 'orders.order_productid')->leftJoin('unit', 'product.product_unit', '=', 'unit.unit_id')->where('order_ref',$request->input('ref'))->get();
		// dd($product);
		// if($customer->customer_rate == 1){
		// 	$price = $product->product_wholesale;
		// }else if($customer->customer_rate == 2){
		// 	$price = $product->product_wholesale2;
		// }else if($customer->customer_rate == 3){
		// 	$price = $product->product_wholesale3;
		// }
		if(!empty($data)){
			foreach ($data as $product) {
				$results[] = [
					'orderid'		=>$product->order_id,
					'id'			=>$product->product_id,
					'code'			=>$product->product_code,
					'name'			=>$product->product_name,
					// 'price'			=>$price,
					'price'			=>$product->order_price,
					'unit'			=>$product->unit_name,
					'qty'			=>$product->order_qty,
					'total'			=>$product->order_total,
					'cate'			=>$product->product_category,
					'subcate'		=>$product->product_subcategory,
					'picture'		=>$product->product_picture,
				];
			}
		}
		return Response::json($results);
	}
	public function create(){
		$dateY	 	= date('Y');
		$dateM 		= date('m');
		$dateD 		= date('d');
		$cutdate 	= substr($dateY,2,2);
		$strdate 	= $cutdate.$dateM.$dateD;
		$invoice	= DB::table('export')->where('export_inv','like',$strdate."%")->orderBy('export_id','desc')->first();
		return view('selling/create',['invoice' => $invoice]);
	}
	
	public function store(Request $request){
		dd($request);
		if($request->input('vat') == 0){
			$vat = '0';
		}else if($request->input('vat') == 1){
			$vat = '7';
		}else if($request->input('vat') == 2){
			$vat = '-7';
		}

		$invoice	= DB::table('selling')->where('selling_inv','like',$request->input('invoice')."%")->orderBy('selling_id','desc')->first();
		if(empty($invoice)){
			$idexport_inv =  $request->input('invoice');
		}else{
			$str = $invoice->export_inv;
			$sub = substr($str,6,3)+1;
			$cut = substr($str,0,6);
			$idexport_inv = $cut.sprintf("%03d",$sub);
		}

		$date = explode('/',$request->input('docdate'));
		$data = [
			'selling_inv'			=> $idexport_inv,
			'selling_date'			=> $date[2].'-'.$date[1].'-'.$date[0],
			'selling_empid'			=> $request->input('empsaleid'),
			'selling_empname'		=> $request->input('empsalename'),
			'selling_customerid'	=> $request->input('customerid'),
			'selling_customername'	=> $request->input('customername'),
			'selling_note'			=> $request->input('note'),
			'selling_total'			=> $request->input('sumtotal'),
			'selling_discount'		=> $request->input('discount'),
			'selling_discountsum'	=> $request->input('sumdiscount'),
			'selling_lastbill'		=> !empty($request->input('discountlastbill'))?$request->input('discountlastbill'):0,
			'selling_vat'			=> $vat,
			'selling_vatsum'			=> $request->input('sumvat'),
			'selling_totalall'		=> $request->input('sumpayment'),
			'selling_totalpayment'	=> $request->input('sumtotalall'),
			'selling_status'			=> 1,
			'created_at'			=> new DateTime(),
			'updated_at'			=> new DateTime(),
		];

		DB::table('selling')->insert($data);
		$lastid = DB::table('selling')->latest()->first();
		if($request->input('order')){
			foreach($request->input('order') as $key => $row){
				$product 			= DB::table('export')->where('export_id',$request->input('order')[$key])->first();
				// $updateexport 		= DB::table('export')->where('export_id',$product->input('order')[$key])->update(['export_status' => '','updated_at' => new DateTime()]);
				$detail = array(
					'sellingdetail_sellingid' 	=>$lastid->export_id,
					'sellingdetail_order'		=>$request->input('order')[$key],
					'created_at'				=>new DateTime(),
					'updated_at'				=>new DateTime()
				);
				// DB::table('selling_detail')->insert($detail);
			}
		}
		// if($request->input('productid')){
		// 	foreach($request->input('productid') as $key => $row){
		// 		$product 			= DB::table('product')->where('product_id',$request->input('productid')[$key])->first();
				
		// 		$processproduct 	= DB::table('processingunit')->where('unit_productid',$product->product_id)->where('unit_unitfirst',$product->product_unit)->first();
		// 		$qstock 			= DB::table('product_stock')->where('product_id',$product->product_id)->where('product_qty','>',0)->first();
		// 		$unitminus 			= $processproduct->unit_total*$request->input('productqty')[$key];
		// 		$unitsum			= $product->product_qty - $unitminus;
		// 		$unitsumstock		= $qstock->product_qty - $unitminus;
				
		// 		//Update stock
		// 		$pro 				= DB::table('product')->where('product_id',$product->product_id)->update(['product_qty' => $unitsum,'updated_at' => new DateTime()]);
		// 		$stock 				= DB::table('product_stock')->where('product_id',$product->product_id)->where('stock_id',$request->input('productprice')[$key])->update(['product_qty' => $unitsumstock,'updated_at' => new DateTime()]); 
				
		// 		$detail = array(
		// 			'order_ref'				=>$lastid->export_id,
		// 			'order_productid'		=>$request->input('productid')[$key],
		// 			'order_price'			=>$request->input('productprice')[$key],
		// 			// 'order_capital'			=>$qstock->product_capital,
		// 			'order_capital'			=>$product->product_buy,
		// 			'order_qty'				=>$request->input('productqty')[$key],
		// 			'order_total'			=>$request->input('totalpro')[$key],
		// 			'order_status'			=>1,
		// 			'created_at'			=>new DateTime(),
		// 			'updated_at'			=>new DateTime()
		// 		);
				
		// 		DB::table('orders')->insert($detail);
		// 	}
		// }
		// $selling = DB::table('selling')->where('selling_id',$id)->first();
		savelog('5','เพิ่มข้อมูลขาย'.' ของลูกค้า '.$request->input('customername'));

		Session::flash('alert-insert','insert');
		return redirect('selling');
	}
		
	public function destroy($id){
		// DB::table('export')->where('export_id',$id)->delete();
		// DB::table('orders')->where('order_ref',$id)->delete();
		$selling = DB::table('selling')->where('selling_id',$id)->first();
		savelog('5','ลบข้อมูลขายลำดับที่ '.$selling->selling_id .' ของลูกค้า '.$selling->selling_customername);
		DB::table('export')->where('order_ref',$id)->update(['export_status' => 3]);
		Session::flash('alert-update','update');
		// Session::flash('alert-delete','delete');
		return redirect('export');
	}
	public function edit($id){
		$selling 	= DB::table('selling')->where('selling_id',$id)->first();
		$customer 	= DB::table('customer')->where('customer_id',$selling->selling_customerid)->first();
		$order	= DB::table('selling_detail')->where('sellingdetail_ref',$selling->selling_id)->get();
		if($order){
			foreach($order as $key => $rs){
				$product = DB::table('product')->where('product_id',$rs->sellingdetail_productid)->first();
				$unit = DB::table('unit')->where('unit_id',$product->product_unit)->first();
				$orderproduct	= DB::table('orders')->where('order_id',$rs->sellingdetail_sellingref)->where('order_productid',$rs->sellingdetail_productid)->first();
				if($rs->sellingdetail_typeunit){
					if($rs->sellingdetail_typeunit == '1'){
	                    $unit = DB::table('unit')->where('unit_id',$rs->sellingdetail_unit)->first();
	                    $unitname = $unit->unit_name;
	                }elseif($rs->sellingdetail_typeunit == '2'){
	                    $unit = DB::table('unitsub')->where('unitsub_id',$rs->sellingdetail_unit)->first();
	                    $unitname = $unit->unitsub_name;
	                }
	            }else{
	            	if($orderproduct->order_typeunit == '1'){
	                    $unit = DB::table('unit')->where('unit_id',$orderproduct->order_unit)->first();
	                    $unitname = $unit->unit_name;
	                }elseif($orderproduct->order_typeunit == '2'){
	                    $unit = DB::table('unitsub')->where('unitsub_id',$orderproduct->order_unit)->first();
	                    $unitname = $unit->unitsub_name;
	                }
	            }
                $balance = 0;
                if(!empty($orderproduct)){
                	$balance = $orderproduct->order_balance;
                }
				// dd($unit);
				$order[$key]->product_id = $product->product_id;
				$order[$key]->product_code = $product->product_code;
				$order[$key]->product_name = $product->product_name;
				$order[$key]->product_detail = $product->product_detail;
				// $order[$key]->unit_name  = $unit->unit_name;
				$order[$key]->unit_name  = $unitname;
				$order[$key]->balance  = $balance;
			}
		}
		return view('selling/update',['customer' => $customer,'selling' => $selling,'order' => $order]);
	}
	public function update(Request $request){
		if($request->input('vat') == 0){
			$vat = '0';
		}else if($request->input('vat') == 1){
			$vat = '7';
		}else if($request->input('vat') == 2){
			$vat = '-7';
		}
		$datadate = explode('/',$request->input('docdate'));
		if(count($datadate) > 1){
			$date = $datadate[2].'-'.$datadate[1].'-'.$datadate[0];
		}else{
			$date = $request->input('docdate');
		}
		$data = [
			'selling_inv'			=> $request->input('invoice'),
			'selling_date'			=> $date,
			'selling_empid'			=> $request->input('empsaleid'),
			'selling_empname'		=> $request->input('empsalename'),
			'selling_customerid'	=> $request->input('customerid'),
			'selling_customername'	=> $request->input('customername'),
			'selling_note'			=> $request->input('note'),
			'selling_total'			=> $request->input('sumtotal'),
			'selling_discount'		=> $request->input('discount'),
			'selling_discountsum'	=> $request->input('sumdiscount'),
			'selling_lastbill'		=> !empty($request->input('discountlastbill'))?$request->input('discountlastbill'):0,
			'selling_vat'			=> $vat,
			'selling_vatsum'		=> $request->input('sumvat'),
			'selling_totalall'		=> $request->input('sumpayment'),
			'selling_totalpayment'	=> $request->input('sumtotalall'),
			'selling_status'		=> $request->input('status'),
			'created_at'			=> new DateTime(),
			'updated_at'			=> new DateTime(),
		];
		// dd($data);
		DB::table('selling')->where('selling_id',$request->input('sellingid'))->update($data);
		$count = 0;
		$arrayremoveqty = []; //2020/08/06
		if($request->input('productid')){
			foreach($request->input('productid') as $key => $row){
				// dd($request->input('sellingdetailid')[$count]);
				$orders 			= DB::table('selling_detail')->where('sellingdetail_productid',$request->input('productid')[$key])->where('sellingdetail_ref',$request->input('sellingid'))->first();
				// dd($orders);
				// if($request->input('sellingdetailid')[$count]){
				// 	$orders 			= DB::table('selling_detail')->where('sellingdetail_productid',$request->input('productid')[$key])->where('sellingdetail_ref',$request->input('sellingid'))->first();
				// 	$count++;
				// }else{
				// 	dd($request->input('sellingdetailid'));
				// }
				
				$product 			= DB::table('product')->where('product_id',$request->input('productid')[$key])->first();
				
				// dd($orders);
				if(empty($orders)){
					// echo 'ไม่ซ้ำ';
					// $processproduct 	= DB::table('processingunit')->where('unit_productid',$product->product_id)->where('unit_unitfirst',$product->product_unit)->first();
					// $qstock 			= DB::table('product_stock')->where('product_id',$product->product_id)->where('product_qty','>',0)->first();

					// $unitminus 			= $processproduct->unit_total*$request->input('productqty')[$key];
					// $unitsum			= $product->product_qty - $unitminus;
					// $unitsumstock		= $qstock->product_qty - $unitminus;

					$order 			= DB::table('selling')->leftjoin('orders','orders.order_ref','selling.selling_ref')->where('order_productid',$request->input('productid')[$key])->where('selling_id',$request->input('sellingid'))->first();
					dd($order);
					$detail = array(
						'sellingdetail_ref'				=>$request->input('sellingid'),
						'sellingdetail_sellingref'		=>$order->order_id,
						'sellingdetail_productid'		=>$request->input('productid')[$key],
						'sellingdetail_price'			=>$request->input('productprice')[$key],
						'sellingdetail_qty'				=>$request->input('productqty')[$key],
						'sellingdetail_total'			=>$request->input('totalpro')[$key],
						'sellingdetail_status'			=>'1', //ตอนแรกตั้งไว้เป็น1
						'created_at'					=>new DateTime(),
						'updated_at'					=>new DateTime()
					);
					$idorder = $order->order_id;
					// echo $idorder.'<br>';
					dd($detail);
					DB::table('selling_detail')->insert($detail);
				}else{
					$order 				= DB::table('orders')->where('order_id',$orders->sellingdetail_sellingref)->first();
					// echo "ซ้ำ";
					// $qstock 			= DB::table('product_stock')->where('product_id',$request->input('productid')[$key])->where('product_qty','>',0)->first();
					array_push($arrayremoveqty,$orders->sellingdetail_qty-$request->input('productid')[$key]);  //2020/08/06
					$detail = array(
						// 'sellingdetail_ref'				=>$request->input('sellingid'),
						// 'sellingdetail_sellingref'		=>$request->input('check')[$key],
						'sellingdetail_productid'		=>$request->input('productid')[$key],
						'sellingdetail_price'			=>$request->input('productprice')[$key],
						'sellingdetail_qty'				=>$request->input('productqty')[$key],
						'sellingdetail_total'			=>$request->input('totalpro')[$key],
						'sellingdetail_status'			=>'1', //ตอนแรกตั้งไว้เป็น1
						'created_at'					=>new DateTime(),
						'updated_at'					=>new DateTime()
					);
					$idorder = $orders->sellingdetail_sellingref;
					// dd($detail);
					DB::table('selling_detail')->where('sellingdetail_id',$orders->sellingdetail_id)->update($detail);
					// echo $idorder.'<br>';
				}
				// dd($orders);
				$calqty = $request->input('productqty')[$key] - $request->input('oldqty')[$key];
				// echo $request->input('productqty')[$key].'<br>';
				// echo $request->input('oldqty')[$key].'<br>';
				// echo $request->input('balance')[$key].'<br>';
				// echo $calqty.'<br>';
				if($calqty < $request->input('balance')[$key]){
					$restore = (-1)*$calqty + $order->order_balance;
				}else if($calqty == $request->input('balance')[$key]){
					$restore = 0;
				}else{
					$restore = $order->order_balance - ($request->input('balance')[$key] - $calqty);
				}
				$redata = [
					'order_balance'	=> $restore,
				];
				// dd($redata);
				// DB::table('orders')->where('order_id',$idorder)->update($redata);
			}
		}
		// dd();
		$orders = DB::table('selling_detail')->where('sellingdetail_ref',$request->input('sellingid'))->get();
		$arraynot = []; //2020/08/06
		foreach($orders as $key => $row){
			if (!in_array($row->sellingdetail_productid, $request->input('productid'))){

				array_push($arraynot, $row->sellingdetail_id); //2020/08/06

				// DB::table('selling_detail')->where('sellingdetail_ref',$request->input('sellingid'))->where('order_productid',$row->order_productid)->delete();
				$ordersdata = DB::table('orders')->where('order_id',$row->sellingdetail_sellingref)->first();
				$restores = $ordersdata->order_balance + $row->sellingdetail_qty;
				$redatas = [
					'order_balance'	=> $restores,
				];
				
				// DB::table('orders')->where('order_id',$row->sellingdetail_sellingref)->update($redatas);
				// DB::table('selling_detail')->where('sellingdetail_id',$row->sellingdetail_id)->delete();
			}
		}

    	$this->sellingtoexport($request->input('sellingid'),$request->input('productid'),$request->input('productprice'),$request->input('productqty'),$request->input('totalpro'),$arraynot,$request->input('sellingdetailid'),$arrayremoveqty);  //2020/08/06

		$selling = DB::table('selling')->where('selling_id',$request->input('sellingid'))->first();
		savelog('5','แก้ไขข้อมูลขายลำดับที่ '.$selling->selling_id .' ของลูกค้า '.$selling->selling_customername);

		Session::flash('alert-update','update');
		return redirect('selling');
	}

	public function bill($id){
		$data = DB::table('selling')->leftJoin('selling_detail','selling.selling_id','selling_detail.sellingdetail_ref')->leftJoin('product','product.product_id','selling_detail.sellingdetail_productid')->leftJoin('customer','customer.customer_id','selling.selling_customerid')->leftJoin('orders','orders.order_id','selling_detail.sellingdetail_sellingref')->leftJoin('unit','unit.unit_id','orders.order_unit')->where('selling_id',$id)->get();
		// dd($data[0]->selling_empid);
		$accountbill = DB::table('area')->leftjoin('setheadbill_account','area_accountid','setheadbillaccount_id')->where('area_id',$data[0]->customer_group)->first();
		$settingbill	= DB::table('setheadbill')->where('setheadbill_id',1)->first();
		// dd($accountbill);
		// $accountbill = [];
		// if($datauser->area_accountid != ''){
		// 	$accountbill	= DB::table('setheadbill_account')->where('setheadbillaccount_id',$datauser->area_accountid)->first();
		// }
       
        $comment = DB::table('export')->leftJoin('selling','selling.selling_ref','export.export_id')->where('selling_id',$id)->first();
        $d = new DNS2D();
        $d->setStorPath(__DIR__."/cache/");

        $genbarcode = $d->getBarcodePNG($data[0]->selling_inv, "QRCODE");
        $dataarray = [];
        $count = 0;
        foreach($data as $key => $item){
        	if($key%10 == 0){
        		$count++;
        	}
        	$dataunit = DB::table('processingunit')->leftjoin('unit','unit.unit_id','processingunit.unit_unitfirst')->leftjoin('unitsub','unitsub.unitsub_id','processingunit.unit_unitsec')->where('unit_productid',$item->sellingdetail_productid)->first();
        	if(count($dataunit) > 0){
        		if($item->order_typeunit == '1'){
        			$item->unit_name = $dataunit->unit_name;
        		}else if($item->order_typeunit == '2'){
        			$item->unit_name = $dataunit->unitsub_name;
        		}
        	}
        	$dataarray[$count][] = $item;
        }
        
        // dd($dataarray);
        // echo '<img src="data:image/png;base64,' . $d->getBarcodePNG("OE1906-00004", "QRCODE") . '" alt="barcode"   />';
        // exit();
        // $qrcode = QrCode::size(500)->format('png')->generate($data[0]->export_inv);
        if(!empty($data)){ 
            $pdf = PDF::loadView('selling/createpdf2',['settingbill' => $settingbill,'data' => $data,'barcode' => $genbarcode,'comment' => $comment->export_note,'dateorder' => $comment->export_date,'dataarray'=>$dataarray,'accountbill'=>$accountbill]);
            return $pdf->stream();
        }else{
        	dd($data);
        }
    }

    public function bill_($id){
       $data = DB::table('export')->leftJoin('orders','export.export_id','orders.order_ref')->leftJoin('product','product.product_id','orders.order_productid')->leftJoin('customer','customer.customer_id','export.export_customerid')->where('export_id',$id)->get();
        if(!empty($data)){ 
            $pdf = PDF::loadView('export/createpdf',['data' => $data]);
            $pdf->save(public_path('pdffile/pdf'.$data[0]->export_id.'.pdf'));
            return  'pdffile/pdf'.$data[0]->export_id.'.pdf';
        }
    }

    public function email($id){
    	// $mail = DB::table('export')->where('export_id','11')->first();
    	// $file = $this->bill_($id);
    	$data = DB::table('export')->leftJoin('orders','export.export_id','orders.order_ref')->leftJoin('product','product.product_id','orders.order_productid')->leftJoin('customer','customer.customer_id','export.export_customerid')->where('export_id',$id)->get();
    	$pdf = PDF::loadView('export/createpdf',['data' => $data]);
        $subject = 'test';
        $email = $data[0]->customer_email;
        $content = 'Panuwat Mumthong';
        // dd($file);
        Mail::send('export.mail_order', ['content' => $data], function ($m) use($email,$subject,$pdf){
        	$m->from('oan032537@gmail.com', 'Oatsimum');
        	$m->to($email)->subject($subject);
        	$m->attachData($pdf->output(),'pdffile.pdf');
        });
        if (Mail::failures()) {
    		return Response::json('x');
    	}else{
    		return Response::json('y');
    	}
    }

    public function checkpay($id){
    	$data = DB::table('export')->where('export_customerid',$id)->get();
    	$customer = DB::table('customer')->where('customer_id',$id)->first();
    	$recheck = true;
    	$notpay = 0;
    	foreach ($data as $key => $value) {
    		if($value->export_status != 0){

    			$d1 = date("Y-m-d",strtotime($value->export_date));
    			$d2 = date("Y-m-d");
    			$date1=date_create($d1);
				$date2=date_create($d2);
				$diff=date_diff($date1,$date2);
				$day = $diff->format("%a");
    			if($day > $customer->customer_credit){
    				// $recheck = false;
    				$notpay = $notpay + $value->export_totalpayment;
    			}
    		}
    	}
    	if($notpay > $customer->customer_creditmoney){
    		$recheck = false;
    	}else{
    		$recheck = true;
    	}
    	return Response::json($recheck);
    }
    public function getdatapay(Request $request){
    	$data = DB::table('selling')->leftjoin('customer','customer_id','selling_customerid')->where('selling_id',$request->id)->first();
    	// $customer = DB::table('customer')->where('customer_id',$data->selling_customerid)->first();
    	// $orders = DB::table('selling_detail')->leftJoin('product','sellingdetail_productid','product_id')->where('sellingdetail_ref',$request->id)->get();
    	// dd($orders);
    	return Response::json($data);
    }
    public function calmoney(Request $request){
    	if($request->input('vat') == 0){
			$vat = '0';
		}else if($request->input('vat') == 1){
			$vat = '7';
		}else if($request->input('vat') == 2){
			$vat = '-7';
		}

		// $date = explode('/',$request->input('docdate'));
		$data = [
			'selling_discount'		=> $request->input('discount'),
			'selling_discountsum'	=> $request->input('sumdiscount'),
			'selling_lastbill'		=> !empty($request->input('discountlastbill'))?$request->input('discountlastbill'):0,
			'selling_commentlastbill'	=> !empty($request->input('notediscountlastbill'))?$request->input('notediscountlastbill'):'',
			'selling_vat'			=> $vat,
			'selling_vatsum'		=> $request->input('sumvat'),
			'selling_typepay'		=> $request->input('payment'),
			'selling_noaccount'		=> !empty($request->input('noauccount'))?$request->input('noauccount'):'',
			'selling_totalall'		=> $request->input('sumpayment'),
			'selling_totalpayment'	=> $request->input('sumtotalall'),
			'selling_status'		=> '1',
			'selling_statusprint'	=> '1',
			'updated_at'			=> new DateTime(),
		];
		DB::table('selling')->where('selling_id',$request->selling_id)->update($data);
		$selling = DB::table('selling')->where('selling_id',$request->selling_id)->first();
		savelog('5','คำนวณเงินข้อมูลขายลำดับที่ '.$selling->selling_id .' ของลูกค้า '.$selling->selling_customername);
		$this->bill($request->selling_id); //ใช้งานอีกฟังก์ชัน
		
    }
    public function cancel($id){
    	$data = [
			'selling_status'		=> '3',
			'updated_at'			=> new DateTime()
		];
		$selling = DB::table('selling')->where('selling_id',$id)->first();
		savelog('5','ยกเลิกข้อมูลขายลำดับที่ '.$selling->selling_id .' ของลูกค้า '.$selling->selling_customername);
    	DB::table('selling')->where('selling_id',$id)->update($data);
		Session::flash('alert-update','update');
		// Session::flash('alert-cancel','cancel');
		return redirect('selling');
    }

    public function getdatafile(Request $required){
    	// $data = DB::table('billingnote')->leftjoin('billingnotedata','billingnote.billingnote_id','billingnotedata.billingnotedata_billingnoteid')->leftjoin('billingnoteimage','billingnote.billingnote_id','billingnoteimage.billingnoteimage_billingnoteid')->where('billingnotedata_exportid',$required->id)->get();  //เอาข้อมูลมาหมดของบิล
    	// $data = DB::table('sellingfile')->where('sellingfile_sellingref',$required->id)->get();
    	$data = DB::table('upfiletransportforselling')->where('upfiletransportforselling_sellingid',$required->id)->get();
    	return Response::json($data);
    }

    public function showorderlastorder(){ //แก้ใหม่
    	// Session::forget('alertlastorder');
    	$checks = Session::get('alertlastorder');
    	// Session::put('alertlastorder', 'Y', 60);
    	// dd($checks);
    	$data = [];
    	if($checks == '' || $checks == null){
    		Session::put('alertlastorder', 'Y', 0.01);
    		// $selling = selling::where('selling_status','0')->get();
    		$selling = selling::where('selling_status','0')->whereRaw('selling_date < date_add(curdate(), interval -1 day)')->get();  //เอาวันที่น้อยกว่าวันที่ปัจจุบัน
    		$data['selling'] = $selling;
	    	// $today = strtotime(date("Y-m-d").'-3 days');
	    	// dd($selling);
	    	// foreach ($selling as $value) {
	    	// 	$date = strtotime($value->selling_date);
	    	// 	if($today > $date){
	    	// 		$date = $value->selling_date." >>> ".date("Y-m-d",$today);
	    	// 		$data[] = $value;
	    	// 	}
	    	// }
	    	// $value = Session::has('alertlastorder');
    	}else{
    		$data['selling'] = [];
    	}

    	// $data['orderalert'] = [];
    	$order = DB::table('alertordernoproduct')->leftjoin('orders','order_id','alertordernoproduct_orderid')->leftjoin('export','order_ref','export_id')->leftjoin('product','product_id','order_productid')->where('alertordernoproduct_status','0')->where('export_status','!=','3');
    	if(Auth::user()->position == '3'){
    		$order = $order->where('product_category',Auth::user()->groupcategory);
    	}
    	$order = $order->get();
    	$data['orderalert'] = $order;

    	$uploadslip = DB::table('ci_payment')->leftjoin('export','ci_payment.order_no','export.export_inv')->where('export.export_status_online','รอการชำระเงิน')->get();
    	$data['uploadslip'] = $uploadslip;
    	// foreach ($order as $value) {
    		
    	// }

    	// dd($checks);
    	return Response::json($data);

    }

    public function restore($id){
    	$selling 	= DB::table('selling')->where('selling_id',$id)->first();
		$customer 	= DB::table('customer')->where('customer_id',$selling->selling_customerid)->first();
		$order	= DB::table('selling_detail')->where('sellingdetail_ref',$selling->selling_id)->get();
		if($order){
			foreach($order as $key => $rs){
				$product = DB::table('product')->where('product_id',$rs->sellingdetail_productid)->first();
				$unit = DB::table('unit')->where('unit_id',$product->product_unit)->first();
				$orderproduct	= DB::table('orders')->where('order_id',$rs->sellingdetail_sellingref)->where('order_productid',$rs->sellingdetail_productid)->first();
				// dd($unit);
				$order[$key]->product_id = $product->product_id;
				$order[$key]->product_code = $product->product_code;
				$order[$key]->product_name = $product->product_name;
				$order[$key]->product_detail = $product->product_detail;
				$order[$key]->unit_name  = $unit->unit_name;
				$order[$key]->balance  = $orderproduct->order_balance;
			}
		}
		return view('selling/restore',['customer' => $customer,'selling' => $selling,'order' => $order]);
    }

    public function saverestore(Request $request){
		$selling = selling::find($request->sellingid);

		$selling->selling_total = $request->input('sumtotal');
		$selling->selling_discount = $request->input('discount');
		$selling->selling_discountsum = $request->input('sumdiscount');
		$selling->selling_lastbill = $request->input('sumvat');
		// $selling->selling_vat = $request->input('sumtotal');
		// $selling->selling_vatsum = $request->input('sumtotal');
		$selling->selling_totalall = $request->input('sumpayment');
		$selling->selling_totalpayment = $request->input('sumtotalall');
		$selling->save();
		savelog('5','คืนสินค้าข้อมูลขายลำดับที่ '.$selling->selling_id .' ของลูกค้า '.$selling->selling_customername);
		// dd();
		$count = 0;
		if($request->input('sellingdetailid')){
			foreach($request->input('sellingdetailid') as $key => $row){
				$sellingdetail = sellingdetail::find($request->input('sellingdetailid')[$key]);
				
				$sellingdetail->sellingdetail_qty = $request->input('productqty')[$key];
				$sellingdetail->sellingdetail_total = $request->input('totalpro')[$key];
				$sellingdetail->save();

				$product_stock = DB::table('product')->where('product_id',$sellingdetail->sellingdetail_productid)->first();
				// dd($product_stock);
				DB::table('product')->where('product_id',$sellingdetail->sellingdetail_productid)->update(['product_qty' => $product_stock->product_qty + $request->input('restore')[$key] ]);
				
				// $restore = $product_stock->product_qty + $request->input('restore')[$key];
				// $calqty = $request->input('productqty')[$key] - $request->input('restore')[$key];

				// if($calqty < $request->input('balance')[$key]){
				// 	$restore = (-1)*$calqty + $order->order_balance;
				// }else if($calqty == $request->input('balance')[$key]){
				// 	$restore = 0;
				// }else{
				// 	$restore = $order->order_balance - ($request->input('balance')[$key] - $calqty);
				// }
				$redata = [
					'order_balance'	=> $request->input('balance')[$key],
				];
				savelog('5','คืนสินค้าข้อมูลขายลำดับที่ '.$selling->selling_id .' ของลูกค้า '.$selling->selling_customername.' ชื่อสินค้า '.$product_stock->product_name.' จำนวนสินค้าที่คืน '.$request->input('restore')[$key]);
				DB::table('orders')->where('order_id',$sellingdetail->sellingdetail_sellingref)->update($redata);
			}
		}
		// dd();
		// $orders = DB::table('selling_detail')->where('sellingdetail_ref',$request->input('sellingid'))->get();
		// foreach($orders as $key => $row){
		// 	if (!in_array($row->sellingdetail_productid, $request->input('productid'))){
		// 		$ordersdata = DB::table('orders')->where('order_id',$row->sellingdetail_sellingref)->first();
		// 		$restores = $ordersdata->order_balance + $row->sellingdetail_qty;
		// 		$redatas = [
		// 			'order_balance'	=> $restores,
		// 		];
				
		// 		DB::table('orders')->where('order_id',$row->sellingdetail_sellingref)->update($redatas);
		// 		DB::table('selling_detail')->where('sellingdetail_id',$row->sellingdetail_id)->delete();
		// 	}
		// }
		
		Session::flash('alert-update','update');
		return redirect('selling');
	}

	public function getdestination(Request $request){
		$data = DB::table('customer_destination')->where('destination_customerid',$request->customerid)->get();
		$subtran = DB::table('sub_tran')->where('sub_order',$request->id)->where('sub_status','1')->first();
		$json = [];
		$json['data'] = $data;
		$json['tran'] = $subtran;
		// dd($json);
		return Response::json($json);
	}

	public function printbillselling(Request $request){
		$selling = selling::find($request->selling_id);
		$selling->selling_statusprint = $selling->selling_statusprint + 1;
		$selling->selling_commentprint = $selling->commentprintselling;
		$selling->save();
		$this->bill($request->selling_id); //ใช้งานอีกฟังก์ชัน
	}

	public function editcancel($id){
		$selling = selling::find($id);
		savelog('5','แก้ไขการยกเลิกข้อมูลขายลำดับที่ '.$selling->selling_id .' ของลูกค้า '.$selling->selling_customername);

		$selling->selling_status = '';
		$selling->save();
		Session::flash('alert-update','update');
		return redirect('selling');
    }

    public function sellingtoexport($sellingid,$product,$productprice,$productqty,$totalpro,$arraynot,$sellingdetailid,$arrayremoveqty){   //2020/08/06
    	
    	$selling = DB::table('selling')->where('selling_id',$sellingid)->first();
    	$dateY = date('Y');
		$dateM = date('m');
		$dateD = date('d');
		$cutdate = substr($dateY,2,2);
		$strdate = $cutdate.$dateM.$dateD.sprintf("%04d",1);
    	$invoice	= DB::table('export')->where('export_inv','like',"%".$strdate."%")->orderBy('export_id','desc')->first();
		if(empty($invoice)){
			$inv = 'SR'.$strdate;
		}else{
			$str = $invoice->export_inv;
			$sub = substr($str,8,4)+1;
			$cut = substr($str,0,8);
			$inv = $cut.sprintf("%04d",$sub);
		}
		$data = [
			'export_inv'			=> $inv,
			'export_date'			=> date("Y-m-d"),
			'export_empid'			=> $selling->selling_empid,
			'export_empname'		=> $selling->selling_empname,
			'export_customerid'		=> $selling->selling_customerid,
			'export_customername'	=> $selling->selling_customername,
			'export_note'			=> !empty($selling->selling_note)?$selling->selling_note:'',
			'export_total'			=> 0,
			'export_discount'		=> 0,
			'export_discountsum'	=> 0,
			'export_lastbill'		=> 0,
			'export_vat'			=> $selling->selling_vat,
			'export_vatsum'			=> 0,
			'export_totalall'		=> 0,
			'export_totalpayment'	=> 0,
			'export_status'			=> 0,
			'created_at'			=> new DateTime(),
			'updated_at'			=> new DateTime(),
		];

		DB::table('export')->insert($data);
		$lastid = DB::table('export')->latest()->first();
		$total = 0;
		if($product){
			foreach($product as $key => $row){
				$selling_detail = DB::table('selling_detail')->leftjoin('orders','order_id','sellingdetail_sellingref')->where('sellingdetail_id',$sellingdetailid[$key])->first();
				$checkdata = $selling_detail->sellingdetail_qty - $productqty[$key];
				// dd($selling_detail);
				if($arrayremoveqty[$key] != 0){ //เช็คว่าจำนวนในใบขายมีการแก้ไขไหม

				$detail = array(
					'order_ref'				=>$lastid->export_id,
					'order_productid'		=>$selling_detail->sellingdetail_productid,
					'order_price'			=>!empty($productprice[$key])?$productprice[$key]:0,
					'order_typeunit'		=>$selling_detail->order_typeunit,
					'order_unit'			=>$selling_detail->order_unit,
					'order_capital'			=>!empty($selling_detail->order_capital)?$selling_detail->order_capital:0,
					'order_qty'				=>$productqty[$key],
					'order_balance'			=>$productqty[$key],
					'order_total'			=>$totalpro[$key],
					'order_status'			=>'', //ตอนแรกตั้งไว้เป็น1
					'created_at'			=>new DateTime(),
					'updated_at'			=>new DateTime()
				);
				$total += $totalpro[$key];
				
				DB::table('orders')->insert($detail);
				}
			}
		}
		if($arraynot){
			foreach($arraynot as $key => $row){
				$selling_detail = DB::table('selling_detail')->leftjoin('orders','order_id','sellingdetail_sellingref')->where('sellingdetail_id',$row)->first();
				$detail = array(
					'order_ref'				=>$lastid->export_id,
					'order_productid'		=>$selling_detail->sellingdetail_productid,
					'order_price'			=>!empty($productprice[$key])?$productprice[$key]:0,
					'order_typeunit'		=>$selling_detail->order_typeunit,
					'order_unit'			=>$selling_detail->order_unit,
					'order_capital'			=>!empty($selling_detail->order_capital)?$selling_detail->order_capital:0,
					'order_qty'				=>$selling_detail->sellingdetail_qty,
					'order_balance'			=>$selling_detail->sellingdetail_qty,
					'order_total'			=>$selling_detail->sellingdetail_total,
					'order_status'			=>'', //ตอนแรกตั้งไว้เป็น1
					'created_at'			=>new DateTime(),
					'updated_at'			=>new DateTime()
				);
				$total += $selling_detail->sellingdetail_total;
				DB::table('orders')->insert($detail);
				DB::table('selling_detail')->where('sellingdetail_id',$row)->delete();
			}
		}
		$data = [
			'export_total'			=> $total,
			'export_totalall'		=> $total,
		];
		DB::table('export')->where('export_id',$lastid->export_id)->update($data);
		savelog('5','เพิ่มข้อมูลออเดอร์จากหน้าการขายชื่อลูกค้า '.$selling->selling_customername);
		Session::flash('alert-insert','insert');
		return redirect('export');

    }
}
