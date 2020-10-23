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
use Auth;
use App\selling;

class ExportController extends Controller
{
    public function index(){
		return view('export/index');
	}
	
	public function datatable(){
		// $export = DB::table('export')->where('export_status','like','%0%')->orwhere('export_status','like','%7%')->get(); //แสดงข้อมูลที่เปิดออเดอร์และออเดอร์ที่ติ๊กขายข้อมูลยังไม่หมดเท่านั้น
		$export = DB::table('export')->leftjoin('orders','orders.order_ref','export.export_id')->leftjoin('customer','customer.customer_id','export.export_customerid')->leftjoin('product','product.product_id','orders.order_productid')->selectRaw('export.*,order_id,product_qty')->wherein('export_status',[0,7]); //แสดงข้อมูลที่เปิดออเดอร์และออเดอร์ที่ติ๊กขายข้อมูลยังไม่หมดเท่านั้น
		if($keyword = request('keyword')){
			if(!empty($keyword)){
				$keywords = explode(',',$keyword);
				if(count($keywords)>1){
					foreach ($keywords as $key => $values) {
						if($key == 0){
							$export->whereRaw("(product_name LIKE '%".$values."%' and order_status in('',3))");
						}else{
							$export->orwhereRaw("(product_name LIKE '%".$values."%' and order_status in('',3))");
						}
					}
					// $export->where('order_status','')->orwhere('order_status','3');
				}else{
					$export->where('product_name','LIKE','%'.$keyword.'%')->where(function($data){
						$data->where('order_status','')->orwhere('order_status','3');
					});
				}
			}
		}
		if(Auth::user()->position > 2){
    		if(Auth::user()->groupsell != 7){
    			$export->where('customer_group',Auth::user()->groupsell);
    		}
    	}
		// $export = $export->groupBy('export_id');
		$export = $export->groupBy('export_id');
		$dataserch = request('search')['value'];
		// dd($dataserch);
		$sQuery	= Datatables::of($export)
		->filter(function ($query) use ($dataserch){
			$explodesearch = explode(',',$dataserch);
			// dd($explodesearch);
			foreach ($explodesearch as $key => $value) {
				if($value != ''){
					if($key == 0){
						$query->where(function($querys) use ($value){
							$querys->where('export_inv','like','%'.$value.'%')
							->orwhere('export_date','like','%'.$value.'%')
							->orwhere('export_customername','like','%'.$value.'%')
							->orwhere('export_totalpayment','like','%'.$value.'%');
						});
					}else{
						$query->orwhere(function($querys) use ($value){
							$querys->where('export_inv','like','%'.$value.'%')
							->orwhere('export_date','like','%'.$value.'%')
							->orwhere('export_customername','like','%'.$value.'%')
							->orwhere('export_totalpayment','like','%'.$value.'%');
						});
					}
					
				}
			}
		})
		->editColumn('export_totalpayment',function($data){
			return empty($data->export_totalpayment)?'-':number_format($data->export_totalpayment,2);
		})
		->editColumn('updated_at',function($data){
			return date('d/m/Y',strtotime($data->updated_at));
		})
		->editColumn('export_date',function($data){
			return date('d/m/Y',strtotime($data->export_date));
		})
		->addColumn('alertorder',function($data){
			$check = false;
			$data = DB::table('orders')->leftjoin('product','product.product_id','orders.order_productid')->where('order_status','!=','1')->where('order_ref',$data->export_id)->get();
			foreach ($data as $value) {
				if($value->order_qty < $value->product_qty){
					$check = true;
					// 
				}
			}
			$update = DB::table('export')->where('export_id',$data->export_id)->first();
			return $check;
		});
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function create(){
		$dateY	 	= date('Y');
		$dateM 		= date('m');
		$dateD 		= date('d');
		$cutdate 	= substr($dateY,2,2);
		$strdate 	= $cutdate.$dateM.$dateD;
		$invoice	= DB::table('export')->where('export_inv','like',"%".$strdate."%")->orderBy('export_id','desc')->first();
		// dd($invoice);
		return view('export/create',['invoice' => $invoice]);
	}
	
	public function store(Request $request){
		if($request->input('vat') == 0){
			$vat = '0';
		}else if($request->input('vat') == 1){
			$vat = '7';
		}else if($request->input('vat') == 2){
			$vat = '-7';
		}

		$invoice	= DB::table('export')->where('export_inv','like',$request->input('invoice')."%")->orderBy('export_id','desc')->first();
		if(empty($invoice)){
			$idexport_inv =  $request->input('invoice');
		}else{
			$str = $invoice->export_inv;
			$sub = substr($str,8,4)+1;
			$cut = substr($str,0,8);
			$idexport_inv = $cut.sprintf("%04d",$sub);
		}

		$date = explode('/',$request->input('docdate'));
		$data = [
			'export_inv'			=> $idexport_inv,
			'export_date'			=> $date[2].'-'.$date[1].'-'.$date[0],
			'export_empid'			=> $request->input('empsaleid'),
			'export_empname'		=> $request->input('empsalename'),
			'export_customerid'		=> $request->input('customerid'),
			'export_customername'	=> $request->input('customername'),
			'export_note'			=> !empty($request->input('note'))?$request->input('note'):'',
			'export_total'			=> $request->input('sumtotal'),
			'export_discount'		=> $request->input('discount'),
			'export_discountsum'	=> $request->input('sumdiscount'),
			'export_lastbill'		=> !empty($request->input('discountlastbill'))?$request->input('discountlastbill'):0,
			'export_vat'			=> $vat,
			'export_vatsum'			=> $request->input('sumvat'),
			'export_totalall'		=> $request->input('sumpayment'),
			'export_totalpayment'	=> $request->input('sumtotalall'),
			'export_status'			=> 0,
			'created_at'			=> new DateTime(),
			'updated_at'			=> new DateTime(),
		];
		DB::table('export')->insert($data);
		$lastid = DB::table('export')->latest()->first();
		if($request->input('productid')){
			foreach($request->input('productid') as $key => $row){
				$product 			= DB::table('product')->where('product_id',$request->input('productid')[$key])->first();
				
				// $processproduct 	= DB::table('processingunit')->where('unit_productid',$product->product_id)->where('unit_unitfirst',$product->product_unit)->first();
				$qstock 			= DB::table('product_stock')->where('product_id',$product->product_id)->where('product_qty','>',0)->first();
				// $unitminus 			= $processproduct->unit_total*$request->input('productqty')[$key];
				// $unitsum			= $product->product_qty - $unitminus;
				// $unitsumstock		= $qstock->product_qty - $unitminus;
				
				//Update stock  ลูกค้ายังไม่ต้องการให้อัพเดทคลัง
				// $pro 				= DB::table('product')->where('product_id',$product->product_id)->update(['product_qty' => $unitsum,'updated_at' => new DateTime()]);
				// $stock 				= DB::table('product_stock')->where('product_id',$product->product_id)->where('stock_id',$request->input('productprice')[$key])->update(['product_qty' => $unitsumstock,'updated_at' => new DateTime()]); 
				//Update stock

				$unit = explode(',', $request->input('unit')[$key]);

				//คำนวนราคานำเข้า
				$importdata = DB::table('sub_import_product')->where('product_id',$request->input('productid')[$key])->orderBy('sub_id','DESC')->first();
				$processproduct 	= DB::table('processingunit')->where('unit_productid',$product->product_id)->orwhere('unit_unitfirst',$unit[1])->where('unit_unitsec',$unit[1])->first();
				$itemunit = $processproduct->unit_total;
				if(!empty($importdata)){
					if($importdata->typyunit == $unit[0]){ //ถ้าหน่วยที่เลือกตรงกับหน่วยที่นำเข้า ไม่ต้องคำนวณราคาต้ทุน
						$order_capital = !empty($product->product_buy)?$product->product_buy:0;
					}else{
						if($importdata->typyunit == 1){
							if($unit[0] == 1){
								$order_capital = !empty($importdata->product_capital)?$importdata->product_capital:0; //ไม่ต้องใส่ก็ได้เพราะเป็นเงืิ่อนไขเหมือนบนสุด
							}else{
								$order_capital = !empty($importdata->product_capital)?($importdata->product_capital/$itemunit):0;
							}
						}else{
							if($unit[0] == 1){
								$order_capital = !empty($importdata->product_capital)?($importdata->product_capital*$itemunit):0;
							}else{ //ไม่ต้องใส่ก็ได้เพราะเป็นเงืิ่อนไขเหมือนบนสุด
								$order_capital = !empty($importdata->product_capital)?$importdata->product_capital:0;
							}
						}
						
					}
				}else if($product->product_buy != ''){
					$order_capital = !empty($product->product_buy)?$product->product_buy:0;
				}else{
					$order_capital = 0;
				}
				//คำนวนราคานำเข้า

				$detail = array(
					'order_ref'				=>$lastid->export_id,
					'order_productid'		=>$request->input('productid')[$key],
					'order_price'			=>!empty($request->input('productprice')[$key])?$request->input('productprice')[$key]:0,
					'order_typeunit'		=>$unit[0],
					'order_unit'			=>$unit[1],
					// 'order_capital'			=>$qstock->product_capital,
					// 'order_capital'			=>!empty($product->product_buy)?$product->product_buy:0,
					'order_capital'			=>number_format($order_capital,2),
					'order_qty'				=>$request->input('productqty')[$key],
					'order_balance'			=>$request->input('productqty')[$key],
					'order_total'			=>$request->input('totalpro')[$key],
					'order_status'			=>'', //ตอนแรกตั้งไว้เป็น1
					'created_at'			=>new DateTime(),
					'updated_at'			=>new DateTime()
				);
				// echo $order_capital.'<br>';

				// dd($detail);
				
				DB::table('orders')->insert($detail);
				// $orderslastid = DB::table('orders')->latest()->first();
				$orderslastid = DB::table('orders')->where('order_ref',$lastid->export_id)->orderBy('order_id','desc')->first();
				if($request->input('productqty')[$key] > $product->product_qty){
					$alertordernoproduct = [
						'alertordernoproduct_orderid'		=> $orderslastid->order_id,
						'alertordernoproduct_want'			=> $request->input('productqty')[$key],
						'alertordernoproduct_balance'		=> $request->input('productqty')[$key]-$product->product_qty,
						'alertordernoproduct_qty'			=> $product->product_qty,
						'alertordernoproduct_status'		=> '0',
					];
					// dd($alertordernoproduct);
					DB::table('alertordernoproduct')->insert($alertordernoproduct);
				}
			}
		}
		// dd();
		savelog('4','เพิ่มข้อมูลออเดอร์ชื่อลูกค้า '.$request->input('customername'));
		Session::flash('alert-insert','insert');
		return redirect('export');
	}
		
	public function destroy($id){
		$export = DB::table('export')->where('export_id',$id)->first();
		DB::table('export')->where('export_id',$id)->delete();
		DB::table('orders')->where('order_ref',$id)->delete();
		savelog('4','ลบข้อมูลออเดอร์ลำดับที่ '.$export->export_id .' ของลูกค้า '.$export->export_customername);
		Session::flash('alert-delete','delete');
		return redirect('export');
	}

	public function cancel($id){
		$export = DB::table('export')->where('export_id',$id)->first();
		DB::table('export')->where('export_id',$id)->update(['export_status' => '3']);
		DB::table('orders')->where('order_ref',$id)->update(['order_status' => '0']);
		savelog('4','ยกเลิกข้อมูลออเดอร์ลำดับที่ '.$export->export_id .' ของลูกค้า '.$export->export_customername);
		Session::flash('alert-cancel','cancel');
		return redirect('export');
	}

	public function edit($id){
		$export 	= DB::table('export')->where('export_id',$id)->first();
		$customer 	= DB::table('customer')->where('customer_id',$export->export_customerid)->first();
		$order	= DB::table('orders')->where('order_ref',$export->export_id)->where('order_status','!=','5')->get();
		if($order){
			foreach($order as $key => $rs){
				$product = DB::table('product')->where('product_id',$rs->order_productid)->first();
				$unit = DB::table('unit')->where('unit_id',$product->product_unit)->first();
				$unitdata 	= DB::table('processingunit')->leftjoin('unit','unit.unit_id','=','processingunit.unit_unitfirst')->leftjoin('unitsub','unitsub.unitsub_id','=','processingunit.unit_unitsec')->where('unit_productid',$product->product_id)->get();
				// dd($unit);
				$order[$key]->product_id = $product->product_id;
				$order[$key]->product_code = $product->product_code;
				$order[$key]->product_name = $product->product_name;
				$order[$key]->product_detail = $product->product_detail;
				$order[$key]->unit_name  = $unit->unit_name;
				$order[$key]->unitdata  = $unitdata;
			}
		}
		return view('export/update',['customer' => $customer,'export' => $export,'order' => $order]);
	}
	public function update(Request $request){
		$export = DB::table('export')->where('export_id',$request->input('exportid'))->first();
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
			'export_inv'			=> $request->input('invoice'),
			'export_date'			=> $date,
			'export_empid'			=> $request->input('empsaleid'),
			'export_empname'		=> $request->input('empsalename'),
			'export_customerid'		=> $request->input('customerid'),
			'export_customername'	=> $request->input('customername'),
			'export_note'			=> $request->input('note'),
			'export_total'			=> $request->input('sumtotal'),
			'export_discount'		=> $request->input('discount'),
			'export_discountsum'	=> $request->input('sumdiscount'),
			'export_lastbill'		=> !empty($request->input('discountlastbill'))?$request->input('discountlastbill'):0,
			'export_vat'			=> $vat,
			'export_vatsum'			=> $request->input('sumvat'),
			'export_totalall'		=> $request->input('sumpayment'),
			'export_totalpayment'	=> $request->input('sumtotalall'),
			'export_status'			=> $request->input('status'),
			'created_at'			=> new DateTime(),
			'updated_at'			=> new DateTime(),
		];
		
		DB::table('export')->where('export_id',$request->input('exportid'))->update($data);
		if($request->input('productid')){
			$orders = DB::table('orders')->where('order_ref',$request->input('exportid'))->get();
			foreach($orders as $key => $row){
				if (!in_array($row->order_productid, $request->input('productid'))){
					// DB::table('orders')->where('order_ref',$request->input('exportid'))->where('order_productid',$row->order_productid)->delete();
					DB::table('orders')->where('order_ref',$request->input('exportid'))->where('order_productid',$row->order_productid)->update(['order_status'=>'5']);
					savelog('4','ยกเลิกรายการในออเดอร์ที่'.$request->input('exportid').' ลำดับสินค้า'.$row->order_productid);
				}
			}
			
			foreach($request->input('productid') as $key => $row){
				$unit = explode(',', $request->input('unit')[$key]);
				// $orders 			= DB::table('orders')->where('order_productid',$request->input('productid')[$key])->where('order_ref',$request->input('exportid'))->first(); //เก่ากรณีไม่มีสินค้าซ้ำ
				$orders 			= DB::table('orders')->where('order_id',$request->input('orderid')[$key])->first();
				$product 			= DB::table('product')->where('product_id',$request->input('productid')[$key])->first();
				if(empty($orders)){
					$processproduct 	= DB::table('processingunit')->where('unit_productid',$product->product_id)->where('unit_unitfirst',$product->product_unit)->first();
					$qstock 			= DB::table('product_stock')->where('product_id',$product->product_id)->where('product_qty','>',0)->first();

					$unitminus 			= (!empty($processproduct)?$processproduct->unit_total:1)*$request->input('productqty')[$key];
					$unitsum			= $product->product_qty - $unitminus;
					$unitsumstock		= $qstock->product_qty - $unitminus;
					
					//Update stock
					$pro 				= DB::table('product')->where('product_id',$product->product_id)->update(['product_qty' => $unitsum,'updated_at' => new DateTime()]);
					$stock 				= DB::table('product_stock')->where('product_id',$product->product_id)->where('stock_id',$qstock->stock_id)->update(['product_qty' => $unitsumstock,'updated_at' => new DateTime()]); 
					
					$detail = array(
						'order_ref'				=>$request->input('exportid'),
						'order_productid'		=>$request->input('productid')[$key],
						'order_price'			=>!empty($request->input('productprice')[$key])?$request->input('productprice')[$key]:0,
						'order_typeunit'		=>$unit[0],
						'order_unit'			=>$unit[1],
						// 'order_capital'			=>$qstock->product_capital,
						'order_capital'			=>!empty($product->product_buy)?$product->product_buy:!empty($request->input('productprice')[$key])?$request->input('productprice')[$key]:0,
						'order_qty'				=>$request->input('productqty')[$key],
						'order_balance'				=>$request->input('productqty')[$key],
						'order_total'			=>$request->input('totalpro')[$key],
						'order_status'			=>1,
						'created_at'			=>new DateTime(),
						'updated_at'			=>new DateTime()
					);
					DB::table('orders')->insert($detail);
				}else{

					$qstock 			= DB::table('product_stock')->where('product_id',$request->input('productid')[$key])->where('product_qty','>',0)->first();
					$detail = array(
						'order_ref'				=>$request->input('exportid'),
						'order_productid'		=>$request->input('productid')[$key],
						'order_price'			=>!empty($request->input('productprice')[$key])?$request->input('productprice')[$key]:0,
						'order_typeunit'		=>$unit[0],
						'order_unit'			=>$unit[1],
						// 'order_capital'			=>$qstock->product_capital,
						'order_capital'			=>$product->product_buy,
						'order_qty'				=>$request->input('productqty')[$key],
						'order_balance'				=>$request->input('productqty')[$key],
						'order_total'			=>$request->input('totalpro')[$key],
						'order_status'			=>1,
						'updated_at'			=>new DateTime()
					);
					DB::table('orders')->where('order_id',$orders->order_id)->update($detail);
				}
			}
			
		}else{
			// $orders = DB::table('orders')->where('order_ref',$request->input('exportid'))->delete();
			DB::table('orders')->where('order_ref',$request->input('exportid'))->update(['order_status'=>'5']);
		}
		$checkorder = DB::table('orders')->where('order_ref',$request->input('exportid'))->where('order_status','!=','1')->where('order_status','!=','5')->get();
    	$statusexport = 7;
    	if(count($checkorder) == 0){
    		$statusexport = 1;
    	}
    	DB::table('export')->where('export_id',$request->input('exportid'))->update(['export_status'=>$statusexport,'updated_at'=> new DateTime()]);
		savelog('4','แก้ไขข้อมูลออเดอร์ลำดับที่ '.$export->export_id .' ของลูกค้า '.$export->export_customername);
		Session::flash('alert-update','update');
		return redirect('export');
	}

	public function bill($id){
       $data = DB::table('export')->leftJoin('orders','export.export_id','orders.order_ref')->leftJoin('product','product.product_id','orders.order_productid')->leftJoin('customer','customer.customer_id','export.export_customerid')->where('export_id',$id)->get();
       $settingbill	= DB::table('setheadbill')->where('setheadbill_id',1)->first();

        $d = new DNS2D();
        $d->setStorPath(__DIR__."/cache/");

        $genbarcode = $d->getBarcodePNG($data[0]->export_inv, "QRCODE");
        // echo '<img src="data:image/png;base64,' . $d->getBarcodePNG("OE1906-00004", "QRCODE") . '" alt="barcode"   />';
        // exit();
        // $qrcode = QrCode::size(500)->format('png')->generate($data[0]->export_inv);
        if(!empty($data)){ 
            $pdf = PDF::loadView('export/createpdf',['settingbill' => $settingbill,'data' => $data,'barcode' => $genbarcode]);
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
    	$settingbill	= DB::table('setheadbill')->where('setheadbill_id',1)->first();

        $d = new DNS2D();
        $d->setStorPath(__DIR__."/cache/");
        // dd($settingbill);
        $genbarcode = $d->getBarcodePNG($data[0]->export_inv, "QRCODE");
    	// $pdf = PDF::loadView('export/createpdf',['data' => $data]);
    	$pdf = PDF::loadView('export/createpdf',['settingbill' => $settingbill,'data' => $data,'barcode' => $genbarcode]);
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
    	$data = DB::table('selling')->where('selling_customerid',$id)->get();
    	$customer = DB::table('customer')->where('customer_id',$id)->first();
    	$recheck = true;
    	$notpay = 0;
    	foreach ($data as $key => $value) {
    		if($value->selling_status != 8 ){

    			$d1 = date("Y-m-d",strtotime($value->selling_date));
    			$d2 = date("Y-m-d");
    			$date1=date_create($d1);
				$date2=date_create($d2);
				$diff=date_diff($date1,$date2);
				$day = $diff->format("%a");
    			if($day > $customer->customer_credit){
    				// $recheck = false;
    				$notpay = $notpay + $value->selling_totalall;
    			}
    		}
    	}
    	// dd($notpay);
    	if($notpay > $customer->customer_creditmoney){
    		$recheck = false;
    	}else{
    		$recheck = true;
    	}
    	return Response::json($recheck);
    }
    public function changeunit(Request $request){
    	$data = explode(',', $request->id);
    	$idunit = $data[1];
    	$type = $data[0];
    	$customer = DB::table('customer')->where('customer_id',$request->customerid)->first();
    	if($type == 1){
    		$product = DB::table('product')->leftJoin('processingunit','product.product_id','=','processingunit.unit_productid')->leftJoin('unit','unit.unit_id','=','processingunit.unit_unitfirst')->where('unit_productid',$request->proid)->where('unit_unitfirst',$idunit)->first();
    		$stock = ceil($product->product_qty/$product->unit_total);
    		$name = $product->unit_name;
    	}else{
    		$product = DB::table('product')->leftJoin('processingunit','product.product_id','=','processingunit.unit_productid')->leftJoin('unitsub','unitsub.unitsub_id','=','processingunit.unit_unitsec')->where('unit_productid',$request->proid)->where('unit_unitsec',$idunit)->first();
    		$stock = $product->product_qty;
    		$name = $product->unitsub_name;
    	}
    	if($customer->customer_rate == 1){
    		$customer_rate = 'product_wholesale';
    	}else{
    		$customer_rate = 'product_wholesale'.$customer->customer_rate;
    	}
    	$pricerate = $product->$customer_rate;
    	if($pricerate == 0){
    		$pricerate = $request->price;
    	}
    	if($type == 1){
			$price = number_format($pricerate,2);
		}else{
			$price = number_format($pricerate/$product->unit_total,2);
		}
  //   	if($customer->customer_rate == 1){
  //   		if($type == 1){
  //   			$price = $product->product_wholesale;
  //   		}else{
  //   			$price = $product->product_wholesale/$product->unit_total;
  //   		}
		// }else if($customer->customer_rate == 2){
		// 	if($type == 1){
  //   			$price = $product->product_wholesale2;
  //   		}else{
  //   			$price = $product->product_wholesale2/$product->unit_total;
  //   		}
		// }else if($customer->customer_rate == 3){
		// 	if($type == 1){
  //   			$price = $product->product_wholesale3;
  //   		}else{
  //   			$price = $product->product_wholesale3/$product->unit_total;
  //   		}
		// }
		// dd($stock);
		$data = [
			'stock' => $stock,
			'name' => $name,
			'price' => $price
		];
    	return Response::json($data);
    }
    public function getdataorder(Request $request){
    	$data = DB::table('export')->where('export_id',$request->orderid)->first();
    	return Response::json($data);
    }
    public function checkdatapay($id){
    	$data = DB::table('export')->where('export_id',$id)->first();
    	$customer = DB::table('customer')->where('customer_id',$data->export_customerid)->first();
    	$orders = DB::table('orders')->leftJoin('product','order_productid','product_id')->where('order_status','!=','1')->where('order_status','!=','5')->where('order_ref',$id)->get();
    	$nameunit = '';
    	$dataorder = [];
		foreach ($orders as $key => $value) {
			if($value->order_typeunit == '1'){
				$unit = DB::table('unit')->where('unit_id',$value->order_unit)->first();
				$nameunit = $unit->unit_name;
			}else{
				$unit = DB::table('unitsub')->where('unitsub_id',$value->order_unit)->first();
				$nameunit = $unit->unitsub_name;
			}
			$orders[$key]->unitname = $nameunit;
		}
    	
    	// dd($orders);
    	return view('export/checkproduct',['data'=>$data,'orders'=>$orders,'customer'=>$customer]);
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
			'export_discount'		=> $request->input('discount'),
			'export_discountsum'	=> $request->input('sumdiscount'),
			'export_lastbill'		=> !empty($request->input('discountlastbill'))?$request->input('discountlastbill'):0,
			'export_vat'			=> $vat,
			'export_vatsum'			=> $request->input('sumvat'),
			'export_totalall'		=> $request->input('sumpayment'),
			'export_totalpayment'	=> $request->input('sumtotalall'),
			// 'export_status'			=> 1,
			'updated_at'			=> new DateTime(),
		];
		DB::table('export')->where('export_id',$request->orderid)->update($data);
    }
    public function export_pay(Request $request){
    	$export = DB::table('export')->where('export_id',$request->input('export_id'))->first();
    	if(count($request->check) == 0){
    		return redirect()->back();
    	}
    	if($request->input('vat') == 0){
			$vat = '0';
		}else if($request->input('vat') == 1){
			$vat = '7';
		}else if($request->input('vat') == 2){
			$vat = '-7';
		}
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
		// dd($inv);
  //   	$data = [
		// 	'exportsub_ref'				=> $request->input('export_id'),
		// 	'exportsub_total'			=> $request->input('sumtotal'),
		// 	'exportsub_discount'		=> $request->input('discount'),
		// 	'exportsub_discountsum'		=> $request->input('sumdiscount'),
		// 	'exportsub_lastbill'		=> !empty($request->input('discountlastbill'))?$request->input('discountlastbill'):0,
		// 	'exportsub_vat'				=> $vat,
		// 	'exportsub_vatsum'			=> $request->input('sumvat'),
		// 	'exportsub_totalall'		=> $request->input('sumpayment'),
		// 	'exportsub_totalpayment'	=> $request->input('sumtotalall'),
		// 	'exportsub_status'			=> 1,
		// 	'created_at'				=> new DateTime(),
		// 	'updated_at'				=> new DateTime(),
		// ];
		// DB::table('export_sub')->insert($data);
		$data = [
			'selling_ref'			=> $request->input('export_id'),
			'selling_inv'			=> 'S'.$inv,
			'selling_date'			=> $request->input('docdate'),
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
			'selling_typepay'		=> $request->input('payment'),
			'selling_noaccount'		=> !empty($request->input('noauccount'))?$request->input('noauccount'):'',
			'selling_totalall'		=> $request->input('sumpayment'),
			'selling_totalpayment'	=> $request->input('sumtotalall'),
			'selling_status'		=> '',
			'created_at'			=> new DateTime(),
			'updated_at'			=> new DateTime(),
		];
		// dd($data);
		DB::table('selling')->insert($data);
		$lastid = DB::table('selling')->latest()->first();
		if($request->input('check')){
			$sumtotalprice = 0;
			foreach($request->input('check') as $key => $row){
				$order = DB::table('orders')->where('order_id',$request->input('check')[$key])->first();
				$balance = ($order->order_balance) - ($request->input('productqty')[$key]);
				$status = 3;
				if($balance <= 0){
					$status = 1;
					$balance = 0;
				}
				DB::table('orders')->where('order_id',$request->input('check')[$key])->update(['order_balance'=>$balance,'order_status'=>$status,'updated_at'=> new DateTime()]);

				$product 			= DB::table('product')->where('product_id',$request->input('productid')[$key])->first();
				// $processproduct 	= DB::table('processingunit')->where('unit_productid',$product->product_id)->where('unit_unitfirst',$product->product_unit)->first();
				$processproduct 	= DB::table('processingunit')->where('unit_productid',$product->product_id);
				if($order->order_typeunit == '1'){
					$processproduct = $processproduct->where('unit_unitfirst',$order->order_unit)->first();
				}else{
					$processproduct = $processproduct->where('unit_unitsec',$order->order_unit)->first();
				}
				$qstock 			= DB::table('product_stock')->where('product_id',$product->product_id)->where('product_qty','>',0)->first();
				if(empty( $processproduct)){
					$unit_total = 1;
				}else{
					$unit_total = $processproduct->unit_total;
				}
				if($order->order_typeunit == '1'){
					$unitminus 			= $unit_total*$request->input('productqty')[$key];
				}else{
					$unitminus 			= $request->input('productqty')[$key];
				}
				
				$unitsum			= $product->product_qty - $unitminus;
				$unitsumstock		= (!empty($qstock)?$qstock->product_qty:0) - $unitminus;
				// Update stock  ลูกค้ายังไม่ต้องการให้อัพเดทคลัง
				$pro 				= DB::table('product')->where('product_id',$product->product_id)->update(['product_qty' => $unitsum,'updated_at' => new DateTime()]);
				$stock 				= DB::table('product_stock')->where('product_id',$product->product_id)->where('stock_id',$request->input('productprice')[$key])->update(['product_qty' => $unitsumstock,'updated_at' => new DateTime()]); 
				// Update stock

				// $detail = array(
				// 	'ordersub_ref'				=>$request->input('export_id'),
				// 	'ordersub_ordersubref'		=>$request->input('check')[$key],
				// 	'ordersub_productid'		=>$request->input('productid')[$key],
				// 	'ordersub_price'			=>$request->input('productprice')[$key],
				// 	// 'order_typeunit'		=>$unit[0],
				// 	// 'order_unit'			=>$unit[1],
				// 	// 'order_capital'			=>$qstock->product_capital,
				// 	// 'order_capital'			=>$product->product_buy,
				// 	'ordersub_qty'				=>$request->input('productqty')[$key],
				// 	'ordersub_total'			=>$request->input('totalpro')[$key],
				// 	'ordersub_status'			=>'1', //ตอนแรกตั้งไว้เป็น1
				// 	'created_at'				=>new DateTime(),
				// 	'updated_at'				=>new DateTime()
				// );
				// DB::table('order_sub')->insert($detail);
				$detail = array(
					'sellingdetail_ref'				=>$lastid->selling_id,
					'sellingdetail_sellingref'		=>$request->input('check')[$key],
					'sellingdetail_productid'		=>$request->input('productid')[$key],
					'sellingdetail_price'			=>$request->input('productprice')[$key],
					'sellingdetail_typeunit'		=>$order->order_typeunit,
					'sellingdetail_unit'			=>$order->order_unit,
					'sellingdetail_capital'			=>$order->order_capital,
					'sellingdetail_qty'				=>$request->input('productqty')[$key],
					'sellingdetail_count'			=>0,
					'sellingdetail_total'			=>$request->input('totalpro')[$key],
					'sellingdetail_status'			=>'1', //ตอนแรกตั้งไว้เป็น1
					'created_at'				=>new DateTime(),
					'updated_at'				=>new DateTime()
				);
				DB::table('selling_detail')->insert($detail);
				$sumtotalprice += $request->input('totalpro')[$key];
			}
			$sellingedittotal = selling::find($lastid->selling_id);
			$sellingedittotal->selling_total = $sumtotalprice;
			$sellingedittotal->selling_totalall = $sumtotalprice;
			$sellingedittotal->selling_totalpayment = $sumtotalprice;
			$sellingedittotal->save();
		}


		$checkorder = DB::table("orders")->where('order_ref',$request->export_id)->where('order_status','!=','1')->get();
    	$statusexport = 7;
    	if(count($checkorder) == 0){
    		$statusexport = 1;
    	}
    	DB::table('export')->where('export_id',$request->export_id)->update(['export_status'=>$statusexport,'updated_at'=> new DateTime()]);

    	savelog('4','ส่งข้อมูลออเดอร์ไปส่วนการขาย ออเดอร์ลำดับที่ '.$export->export_id .'เป็นการขายลำดับที่ '.$lastid->selling_id.' ของลูกค้า '.$export->export_customername);
    	// dd($export);
		Session::flash('alert-insert','insert');
		return redirect('export');
    }
    public function checkstock(Request $request){
    	$return = true;
    	$array = [];
    	$array2 = [];
		if($request->input('check')){
			foreach($request->input('check') as $key => $row){
				$stock = DB::table('product_stock')->where('product_id',$request->input('productid')[$key])->first();
				if($stock->product_qty < $request->input('productqty')[$key]){
					$return = false;
					$array2[] = [
						'id'		=> $request->input('productid')[$key],
						'qty'		=> $stock->product_qty
					];
				}
			}
		}else{
			$return = false;
		}
		$array[] = $return;
		$array[] = $array2;
		return Response::json($array);
    }

    public function checkviewbeforeorder(Request $request){
    	$data = DB::table('export')->leftjoin('orders','orders.order_ref','export.export_id')->where('export_customerid',$request->customerid)->where('order_productid',$request->viewproductid)->orderBy('orders.created_at','DESC')->get();
    	return Response::json($data);
    }
    public function view($id){
		$export 	= DB::table('export')->where('export_id',$id)->first();
		$customer 	= DB::table('customer')->where('customer_id',$export->export_customerid)->first();
		$order	= DB::table('orders')->where('order_ref',$export->export_id)->where('order_status','!=',1)->get();
		if($order){
			foreach($order as $key => $rs){
				$product = DB::table('product')->where('product_id',$rs->order_productid)->first();
				$unit = DB::table('unit')->where('unit_id',$product->product_unit)->first();
				$unitdata 	= DB::table('processingunit')->leftjoin('unit','unit.unit_id','=','processingunit.unit_unitfirst')->leftjoin('unitsub','unitsub.unitsub_id','=','processingunit.unit_unitsec')->where('unit_productid',$product->product_id)->get();
				// dd($unit);
				$order[$key]->product_id = $product->product_id;
				$order[$key]->product_code = $product->product_code;
				$order[$key]->product_name = $product->product_name;
				$order[$key]->product_detail = $product->product_detail;
				$order[$key]->unit_name  = $unit->unit_name;
				$order[$key]->unitdata  = $unitdata;
			}
		}
		return view('export/view',['customer' => $customer,'export' => $export,'order' => $order]);
	}
	public function checkordersell($id){
		$order = DB::table('selling_detail')->where('sellingdetail_sellingref',$id)->first();
		return response::json($order);
    }

    public function checkorder(Request $request){
    	$data = DB::table('export')->leftjoin('orders','export_id','order_ref')->where('export_customerid',$request->customerid)->wherein('export_status',[0,7])->wherein('order_productid',$request->productid)->get();
    	foreach($data as $value){
    		if($value->order_typeunit == '1'){
				$unit = DB::table('unit')->where('unit_id',$value->order_unit)->first();
				$nameunit = $unit->unit_name;
			}else{
				$unit = DB::table('unitsub')->where('unitsub_id',$value->order_unit)->first();
				$nameunit = $unit->unitsub_name;
			}
			$value->unitname = $nameunit;
    	}
    	return Response::json($data);
    }
}
