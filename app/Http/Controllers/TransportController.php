<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Session;
use Response;
use Datatables;
use PDF;
use \Milon\Barcode\DNS2D;
use App\selling;
use URL;
use App\logscanboxputtingcar;
use Auth;

class TransportController extends Controller
{
    public function index(){
		return view('transport/index');
	}
	
	public function trandata(){
		$trans = DB::table('transport');
		if($noorder = request('noorder')){
			$trans->where('trans_invoice','like','%'.$noorder.'%');
		}
		$datestart = request('datestart');
		$dateend = request('dateend');
		if($datestart != '' && $dateend != ''){
			$trans->whereBetween('trans_delivery',[$datestart,$dateend]);
		}
		$staus = request('staus');
		if($staus != ''){
			$trans->where('trans_status','like',$staus.'%');
		}else{
			$trans->where('trans_status','!=','9');
		}
		// $trans->where('trans_status','!=','9');
		
		// $trans = $trans->get();
		// dd($trans);
		$s_Query	= Datatables::of($trans)
		->editColumn('trans_date',function($data){
			return date('d/m/Y',strtotime($data->trans_date));
		})
		->editColumn('updated_at',function($data){
			return date('d/m/Y',strtotime($data->updated_at));
		})
		->editColumn('trans_delivery',function($data){
			return date('d/m/Y',strtotime($data->trans_delivery));
		})->addColumn('viewdetail', function($data){
			$btn = '<a href="transport/view/'.$data->trans_invoice.'">'.$data->trans_invoice.'</a>';
			return $btn;
		})->addColumn('upfile', function($data){
			$countfile = DB::table('transport_uploadfile')->where('transportuploadfile_transportid',$data->trans_id)->count();
			return $countfile;
		});
		return $s_Query->escapeColumns([])->make(true);
	}
	
	public function datatable(){
		$order = DB::table('selling')->where('selling_status',4)->get(); //เอาสินค้าที่มีสถานะ4แล้วอย่างเดียว
		// $order = DB::table('box')->leftjoin('selling','selling_inv','box_orderinv')->where('selling_status',4)->get(); //เอาที่แพ็คลงกล่องแล้วมาจับคู่
		$sQuery	= Datatables::of($order)
		->editColumn('selling_totalpayment',function($data){
			return number_format($data->selling_totalpayment,2);
		})
		->editColumn('selling_date',function($data){
			return date('d/m/Y',strtotime($data->selling_date));
		});
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function create(){
		$dateY	 	= date('Y');
		$dateM 		= date('m');
		$dateD 		= date('d');
		$cutdate 	= substr($dateY,2,2);
		$strdate 	= 'TR'.$cutdate.$dateM.$dateD;
		$invoice	= DB::table('transport')->where('trans_invoice','like',$strdate."%")->orderBy('trans_id','desc')->first();
		return view('transport/create',['invoice' => $invoice]);
	}
	
	public function store(Request $request){
		$datedoc	= explode('/',$request->input('docdate'));
		$strdate 	= $datedoc[2].'-'.$datedoc[1].'-'.$datedoc[0];
		$datedeli 	= explode('/',$request->input('delivery'));
		$strdeli 	= $datedeli[2].'-'.$datedeli[1].'-'.$datedeli[0];
		
		$data = [
			'trans_invoice'		=> $request->input('invoice'),
			'trans_date'		=> $strdate,
			'trans_delivery'	=> $strdeli,
			'trans_emp'			=> !empty($request->input('empsalename'))?$request->input('empsalename'):'',
			'trans_truck'		=> !empty($request->input('truckname'))?$request->input('truckname'):'',
			'trans_truckid'		=> !empty($request->input('truckid'))?$request->input('truckid'):'',
			'trans_status'		=> 0,
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		];
		DB::table('transport')->insert($data);
		$lastid = DB::table('transport')->latest()->first();	
		
		$order = $request->input('order');
		foreach($order as $key => $rs){
			if(!empty($request->input('order')[$key])){
				$arr = [
					'sub_ref'		=> $lastid->trans_id,
					'sub_order'		=> $request->input('order')[$key],
					'created_at'	=> new DateTime(),
					'updated_at'	=> new DateTime(),
				];
				DB::table('sub_tran')->insert($arr);
				DB::table('selling')->where('selling_id',$request->input('order')[$key])->update(['selling_status' => 5,'updated_at' => new DateTime()]);
			}
		}
		savelog('7','เพิ่มข้อมูลขนส่งเลขที่ออเดอร์ '.$request->input('invoice'));
		Session::flash('alert-insert','insert');
		return redirect('transport');
	}
	
	public function destroy($id){
		$res = DB::table('sub_tran')->where('sub_ref',$id)->get();
		if($res){
			foreach($res as $rs){
				DB::table('export')->where('export_id',$rs->sub_order)->update(['export_status' => 2,'updated_at' => new DateTime()]);
			}
		}
		DB::table('transport')->where('trans_id',$id)->delete();
		DB::table('sub_tran')->where('sub_ref',$id)->delete();
		Session::flash('alert-delete','delete');
		return redirect('transport');
	}
	public function cancel($id){
		$transportsup = DB::table('sub_tran')->where('sub_ref',$id)->get();
		foreach($transportsup as $subdata){
			DB::table('selling')->where('selling_id',$subdata->sub_order)->update(['selling_status'=>4]);
			DB::table('sub_tran')->where('sub_id',$subdata->sub_id)->update(['sub_status'=>0]);
		}
		DB::table('transport')->where('trans_id',$id)->update(['trans_status' => 9,'updated_at' => new DateTime()]);
		$transport = DB::table('transport')->where('trans_id',$id)->first();
		savelog('7','ยกเลิกรายการขนเลขที่ '.$transport->trans_invoice);
		Session::flash('alert-delete','delete');
		return redirect('transport');
	}
	
	public function tranwait($id){
		DB::table('transport')->where('trans_id',$id)->update(['trans_status' => 2,'updated_at' => new DateTime()]);
		$res = DB::table('sub_tran')->where('sub_ref',$id)->get();
		if($res){
			foreach($res as $rs){
				DB::table('selling')->where('selling_id',$rs->sub_order)->update(['selling_status' => 5,'updated_at' => new DateTime()]);
			}
		}
		$transport = DB::table('transport')->where('trans_id',$id)->first();
		savelog('7','เปลี่ยนสถานะขนส่งเป็นกำลังจัดส่งเลขที่ออเดอร์ '.$transport->trans_invoice);
		Session::flash('alert-update','update');
		return redirect('transport');
	}
	
	public function tranapprove($id){
		DB::table('transport')->where('trans_id',$id)->update(['trans_status' => 1,'updated_at' => new DateTime()]);
		$res = DB::table('sub_tran')->where('sub_ref',$id)->get();
		if($res){
			foreach($res as $rs){
				DB::table('selling')->where('selling_id',$rs->sub_order)->update(['selling_status' => 1,'updated_at' => new DateTime()]);
				DB::table('sub_tran')->where('sub_order',$rs->sub_order)->update(['updated_at' => new DateTime()]);
			}
		}
		$transport = DB::table('transport')->where('trans_id',$id)->first();
		savelog('7','เปลี่ยนสถานะขนส่งเป็นจัดส่งแล้วเลขที่ออเดอร์ '.$transport->trans_invoice);
		Session::flash('alert-update','update');
		return redirect('transport');
	}
	
	public function invoice($id){
		$setting 	= DB::table('setting')->first();
		$tran 		= DB::table('transport')->where('trans_id',$id)->first();
		$sub 		= DB::table('sub_tran')->where('sub_ref',$id)->get();
		// $sub 		= DB::table('sub_tran')->leftjoin('box','box.box_sellingid','sub_tran.sub_order')->where('sub_ref',$id)->groupby('box_tax')->get();

		$data 		= [];
		$databox 	= [];
		// dd($sub);
		if($sub){
			foreach($sub as $rs){
				$order = DB::table('selling')->where('selling_id',$rs->sub_order)->first();
				// dd($order);
				$box   = DB::table('box')->select('*', DB::raw('SUM(box_number) as sum'))->where('box_orderinv',$order->selling_inv)->groupby('box_no')->get();
				$boxcat   = DB::table('box')->leftjoin('product','box_product','product_id')->leftjoin('category','category_id','product_category')->where('box_orderinv',$order->selling_inv)->get();
		        // dd($boxcat);
		        $arraycat = [] ;
		        foreach($boxcat as $datainbox){
		            if($datainbox->category_id != ''){
		            	if(array_key_exists($datainbox->box_tax,$arraycat)){
		            		if(!in_array($datainbox->category_name, $arraycat[$datainbox->box_tax] )){
			            		$arraycat[$datainbox->box_tax][] = $datainbox->category_name;
			            	}
		            	}else{
		            		$arraycat[$datainbox->box_tax][] = $datainbox->category_name;
		            	}
		            }
		        }
		        // dd($arraycat);
		        // $boxsum   = DB::table('box')->select('box_number', DB::raw('SUM(box_number) as sum'))->where('box_orderinv',$order->export_inv)->where('box_no',$box->box_no)->get();
		        $cust  = DB::table('customer')->where('customer_id',$order->selling_customerid)->first();
		        $data[] = [
		            'inv'       => $order->selling_inv,
		            'cname'     => $cust->customer_name,
		            'ctel'      => $cust->customer_tel,
		            'caddr'     => 'บ้านเลขที่-ซอย '.$cust->customer_address1.' ถนน '.$cust->customer_address2.' แขวง/ตำบล '.$cust->customer_address3.' เขต/อำเภอ '.$cust->customer_address4.' จังหวัด '.$cust->customer_address5.' รหัสไปรษณย์ '.$cust->customer_address6,
		        ];
				// dd($box);
				// $boxsum   = DB::table('box')->select('box_number', DB::raw('SUM(box_number) as sum'))->where('box_orderinv',$order->export_inv)->where('box_no',$box->box_no)->get();
				$geturl = URL::current();
		        $geturl = explode('/',$geturl);

		        $d = new DNS2D();
		        $d->setStorPath(__DIR__."/cache/");
		        if(!empty($box)){
		            foreach($box as $keybox => $listbox){
		                $url = $geturl[0].'//'.$geturl[2].'/'.$geturl[3].'/checkproductinbox/'.$listbox->box_tax;
		                // echo $url.'<br>';
		                $genbarcode = $d->getBarcodePNG($url, "QRCODE",4,4);
		                // $genbarcode = $d->getBarcodePNG('box_tax', "QRCODE",6,6);
		                $listbox->genbarcode = $genbarcode;
		                $listbox->datacat = $arraycat[$listbox->box_tax];

		            }
		        }else{
		            $genbarcode = $d->getBarcodePNG('box_tax', "QRCODE",6,6);
		        }
		        $databox[] = $box;
			}
		}
		// $d = new DNS2D();
        // $d->setStorPath(__DIR__."/cache/");

        // $genbarcode = $d->getBarcodePNG($tran->trans_invoice, "QRCODE",6,6);
        // dd($databox);
		$pdf = PDF::loadView('transport.invoice',['data' => $data,'setting' => $setting,'tran' => $tran,'databox'=>$databox,'qrcode'=>$genbarcode],[],['title' => 'รายการส่งออก','format'=>'A4-L']);
		return $pdf->stream();
	   //return view('transport/invoice',['data' => $data,'setting' => $setting,'tran' => $tran]);
	}
	
	public function checkdatatran(Request $request){
		$tran = DB::table('transport')->where('trans_invoice',$request->input('keyword'))->first();
		$sub = DB::table('sub_tran')->where('sub_ref',$tran->trans_id)->leftjoin('selling', 'sub_tran.sub_order', '=', 'selling.selling_id')->get();
		// dd($sub);
		if(!empty($sub)){
			foreach($sub as $rs){
				if($rs->sub_status == 0){
					$stat = 'ยกเลิก';
				}else if($rs->sub_status == 1){
					$stat = 'รอส่ง';
				}else if($rs->sub_status == 2){
					$stat = 'ส่งไม่สำเร็จ';
				}
				$subs[] = [
					'id'		=> $rs->selling_id,
					'inv'		=> $rs->selling_inv,
					'date'		=> date('d/m/Y',strtotime($tran->trans_date)),
					'datedeli'	=> date('d/m/Y',strtotime($tran->trans_delivery)),
					'statustext'	=> $stat,
					'status'	=> $rs->sub_status,
				];
			}
		}
		return Response::json(['tran' => $tran,'subs' => $subs]);
	}

	public function viewdatatran(Request $request){
		$tran = DB::table('transport')->where('trans_id',$request->input('id'))->first();
		$sub = DB::table('sub_tran')->where('sub_ref',$request->id)->leftjoin('selling', 'sub_tran.sub_order', '=', 'selling.selling_id')->get();
		// dd($sub);
		if(!empty($sub)){
			foreach($sub as $rs){
				if($rs->sub_status == 0){
					$stat = 'ยกเลิก';
				}else if($rs->sub_status == 1){
					$stat = 'รอส่ง';
				}else if($rs->sub_status == 2){
					$stat = 'ส่งไม่สำเร็จ';
				}
				$subs[] = [
					'id'		=> $rs->selling_id,
					'inv'		=> $rs->selling_inv,
					'date'		=> date('d/m/Y',strtotime($tran->trans_date)),
					'datedeli'	=> date('d/m/Y',strtotime($tran->trans_delivery)),
					'statustext'	=> $stat,
					'status'	=> $rs->sub_status,
					'statusselling'	=> $rs->selling_status,
					'customerid'	=> $rs->selling_customerid,
				];
			}
		}
		return Response::json(['tran' => $tran,'subs' => $subs]);
	}

	
	public function orderdata(Request $request){
		$order = DB::table('selling_detail')->where('sellingdetail_ref',$request->input('id'))->join('product','selling_detail.sellingdetail_productid','=','product.product_id')->get();
		return Response::json($order);
	}

	public function uploadfile(Request $request){
		// dd($request->transportid);
		if($request->hasFile('uploadcover')){
			$files = $request->file('uploadcover');
			$filename 	= $files->getClientOriginalName();
			$extension 	= $files->getClientOriginalExtension();
			$size		= $files->getSize();
			$imgcover 	= date('His').$filename;
			$destinationPath = base_path()."/assets/images/uploadtransport/";
			$files->move($destinationPath, $imgcover);
			$data = [
				'transportuploadfile_transportid' => $request->transportid,
				'transportuploadfile_name' => $imgcover,
				'transportuploadfile_status' => '1',
				'created_at' => new DateTime(),
				'updated_at' => new DateTime(),
			];
			DB::table('transport_uploadfile')->insert($data);
			Session::flash('alert-insert','insert');
			return redirect('transport');
		}

	}

	public function entertransportemp(Request $request){
		$driver = DB::table('driver')->where('driver_id',$request->id)->first();
		$results[] = [
			'id'			=>$driver->driver_id,
			'name'			=>$driver->driver_name,
			'email'			=>$driver->driver_email,
			'tax'			=>$driver->driver_tax,
			'address'		=>$driver->driver_address,
		];
		return Response::json($results);
	}

	public function cancelorder(Request $request){
		$selling = DB::table('selling')->where('selling_id',$request->id)->update(['selling_status'=>4]);
		$sub_order = DB::table('sub_tran')->where('sub_ref',$request->transportid)->where('sub_order',$request->id)->update(['sub_status'=>0]);
		if($selling){
			return Response::json('Y');
		}else{
			return Response::json('X');
		}
		$transport = DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->leftjoin('selling','selling_id','sub_order')->where('sub_ref',$request->transportid)->where('sub_order',$request->id)->first();
		savelog('7','ยกเลิกรายการขนส่งรหัส '.$transport->selling_inv.' ของเลขที่ออเดอร์ '.$transport->trans_invoice);
	} 
	public function uploadfileforselling(Request $request){
		// dd();
		$imgcover = '';
		$selling = selling::find($request->sellingid);
		if($request->hasFile('uploadfileselling')){
			$files = $request->file('uploadfileselling');
			$filename 	= $files->getClientOriginalName();
			$extension 	= $files->getClientOriginalExtension();
			$size		= $files->getSize();
			$imgcover 	= date('His').$filename;
			$destinationPath = base_path()."/assets/images/uploadtransport/selling/";
			$files->move($destinationPath, $imgcover);
		}
		$data = [
			'upfiletransportforselling_transportid' => $request->transportid,
			'upfiletransportforselling_sellingid' => $request->sellingid,
			'upfiletransportforselling_money' => '1',
			'upfiletransportforselling_file' => 'selling/'.$imgcover,
			'created_at' => new DateTime(),
			'updated_at' => new DateTime(),
		];
		$selling->selling_shippingcost = $selling->selling_shippingcost + $request->shippingcost;
		// $selling->selling_totalall = $selling->selling_totalall + $request->shippingcost;
		$selling->selling_totalpayment = $selling->selling_totalpayment + $request->shippingcost;
		$selling->selling_destination = $request->destination;
		$selling->selling_deliveryno = $request->nodelivery;
		// $selling->selling_status = '8';

		$selling->selling_status = '1';
		$selling->save();
		// dd($selling);
		// selling_shippingcost
		$result = DB::table('upfiletransportforselling')->insert($data);
		
		
		$result = DB::table('upfiletransportforselling')->insert($data);
		if($request->transportid){
			$transport = DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->leftjoin('selling','selling_id','sub_order')->where('sub_ref',$request->transportid)->where('sub_order',$request->sellingid)->first();
			savelog('7','เพิ่มไฟล์รายการขนส่งรหัส '.$transport->selling_inv.' ของเลขที่ออเดอร์ '.$transport->trans_invoice);
		}else{
			savelog('7','เพิ่มไฟล์รายการขนส่งจากหน้าขาย ของเลขที่บิลขาย '.$request->sellingid);
		}

		// Session::flash('alert-insert','insert');
		return Response::json($result);
	}

	public function ordertransport($id){

		$tran 		= DB::table('transport')->where('trans_id',$id)->first();
		$data 		= DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->leftjoin('selling','sub_order','selling_id')->leftjoin('customer_destination','selling_destination','destination_id')->where('sub_ref',$id)->get();
		$countdata = $data->count();
		$countcopy 		= DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->leftjoin('selling','sub_order','selling_id')->leftjoin('customer_destination','selling_destination','destination_id')->where('sub_ref',$id)->where('selling_statuspacking','=','')->get()->count();
		// $countpacking 		= DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->leftjoin('selling','sub_order','selling_id')->leftjoin('customer_destination','selling_destination','destination_id')->where('sub_ref',$id)->where('selling_statuspacking','!=','')->where('selling_status','!=','8')->get()->count(); //นับใบที่แพ็กของแล้วแต่สถานะเป็นยังไม่ได้จ่ายเงิน
		$countpacking 		= DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->leftjoin('selling','sub_order','selling_id')->leftjoin('customer_destination','selling_destination','destination_id')->where('sub_ref',$id)->where('selling_statuspacking','!=','')->get()->count(); //นับใบที่แพ็กของแล้วไม่สนอย่างอื่น
		$countbill 		= DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->leftjoin('selling','sub_order','selling_id')->leftjoin('customer_destination','selling_destination','destination_id')->where('sub_ref',$id)->where('selling_status','=','8')->get()->count();

		$transportexpen =  DB::table('transportexpen')->where('transportexpen_transportid',$id)->get();
		if(empty($transportexpen)){
			$transportexpen =[];
		}
        $pdf = PDF::loadView('transport/createpdf',['data' => $data,'countcopy' => $countcopy,'countpacking' => $countpacking,'countbill' => $countbill,'countdata'=>$countdata,'transportexpen'=>$transportexpen]);
            return $pdf->stream();
	}

	public function getdestination(Request $request){
		$data = DB::table('customer_destination')->where('destination_customerid',$request->id)->get();
		return Response::json($data);
	}

	public function expend(Request $request){
		// dd($request);
		// $transport = DB::table('transport')->where('trans_id',$request->transportid)->get();
		$withdrawal = $request->withdrawal;
		foreach ($request->details as $key => $item) {
			// echo '1';
			if($request->expendid[$key] == '' || $request->expendid[$key] == null){
				$balance = $withdrawal-$request->expend[$key];
				$data = [
					'transportexpen_transportid' 	=>$request->transportid,
					'transportexpen_withdraw' 		=>$withdrawal,
					'transportexpen_detail' 		=>$request->details[$key],
					'transportexpen_expen' 			=>$request->expend[$key],
					'transportexpen_balance' 		=>$balance,
					'created_at' 					=> new DateTime(),
					'updated_at' 					=> new DateTime(),
				];
				// dd($data);
				$transport = DB::table('transportexpen')->insert($data);
				$withdrawal -= $request->expend[$key];
				$transport = DB::table('transport')->where('trans_id',$id)->first();
				savelog('7','เพิ่มค่าใช้จ่ายในการขนส่ง เลขที่ออเดอร์  '.$transport->trans_invoice.' รายการจ่าย '.$request->details[$key].' จำนวน '.$request->expend[$key]);
			}
		}
		// dd();
		if($request->hasFile('uploadfile_')){
			foreach ($request->uploadfile_ as $key => $value) {
				$files = $request->uploadfile_[$key];
				$filename 	= $files->getClientOriginalName();
				$extension 	= $files->getClientOriginalExtension();
				$size		= $files->getSize();
				$imgcover 	= date('His').$filename;
				$destinationPath = base_path()."/assets/images/uploadtransport/";
				$files->move($destinationPath, $imgcover);
				$data = [
					'transportuploadfile_transportid' => $request->transportid,
					'transportuploadfile_name' => $imgcover,
					'transportuploadfile_status' => '1',
					'created_at' => new DateTime(),
					'updated_at' => new DateTime(),
				];
				DB::table('transport_uploadfile')->insert($data);
			}
			
		}
		$transport = DB::table('transport')->where('trans_id',$id)->first();
		savelog('7','เพิ่มค่าใช้จ่ายในการขนส่ง เลขที่ออเดอร์ '.$transport->trans_invoice);

		Session::flash('alert-insert','insert');
		return redirect('transport');
	}

	public function getexpen(Request $request){
		// dd($request);
		$transport = DB::table('transportexpen')->where('transportexpen_transportid',$request->id)->get();
		return Response::json($transport);
	}

	public function getfileupload(Request $request){
		$file = DB::table('transport_uploadfile')->where('transportuploadfile_transportid',$request->id)->get();
		return Response::json($file);
	}

	public function getdatascanbill($id){

		$data = DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->leftjoin('selling','selling_id','sub_order')->leftjoin('selling_detail','selling_id','sellingdetail_ref')->leftjoin('product','product_id','sellingdetail_productid')->select(DB::raw('*,(selling_typeunit1+selling_typeunit2+selling_typeunit3+selling_typeunit4) as sumitem,(selling_scantypeunit1+selling_scantypeunit2+selling_scantypeunit3+selling_scantypeunit4) as sumscanitem'))->where('trans_id',$id)->groupby('selling_id')->get();

		if(count($data) > 0){
			return view('transport/scanbarcode',['data'=>$data,'id'=>$id]);
		}else{
			return redirect()->back();
		}
		
	}
	public function scanbillfortranfer(Request $request){
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

	public function poll($id){
		$setting 	= DB::table('setting')->first();
		$tran 		= DB::table('transport')->where('trans_id',$id)->first();
		$sub 		= DB::table('selling')->leftjoin('selling_detail','sellingdetail_ref','selling_id')->leftjoin('product','product_id','sellingdetail_productid')->leftjoin('category','product_category','category_id')->where('selling_id',$id)->get();

		$data 		= [];
		$databox 	= [];
		$total = 0;
		$totalcount = DB::table('selling_detail')->where('sellingdetail_ref',$id)->count();
		if($sub){
			$cust  = DB::table('customer')->where('customer_id',$sub[0]->selling_customerid)->first();
			$data[] = [
	            'cname'     => $cust->customer_name,
	            'ctel'      => $cust->customer_tel,
	            'caddr'     => 'บ้านเลขที่-ซอย '.$cust->customer_address1.' ถนน '.$cust->customer_address2.' แขวง/ตำบล '.$cust->customer_address3.' เขต/อำเภอ '.$cust->customer_address4.' จังหวัด '.$cust->customer_address5.' รหัสไปรษณย์ '.$cust->customer_address6,
	            'address1'     => 'บ้านเลขที่-ซอย '.$cust->customer_address1,
	            'address2'     => ' ถนน '.$cust->customer_address2,
	            'address3'     => ' แขวง/ตำบล '.$cust->customer_address3,
	            'address4'     => ' เขต/อำเภอ '.$cust->customer_address4,
	            'address5'     => ' จังหวัด '.$cust->customer_address5,
	            'address6'     => ' รหัสไปรษณย์ '.$cust->customer_address6,
	        ];
	        
			foreach($sub as $rs){
				$total += $rs->sellingdetail_qty;
		        $arraycat = [] ;
		        // foreach($boxcat as $datainbox){
		        //     if($datainbox->category_id != ''){
		        //     	if(array_key_exists($datainbox->box_tax,$arraycat)){
		        //     		if(!in_array($datainbox->category_name, $arraycat[$datainbox->box_tax] )){
			       //      		$arraycat[$datainbox->box_tax][] = $datainbox->category_name;
			       //      	}
		        //     	}else{
		        //     		$arraycat[$datainbox->box_tax][] = $datainbox->category_name;
		        //     	}
		        //     }
		        // }
		        

			}
			$d = new DNS2D();
			$d->setStorPath(__DIR__."/cache/");
			$genbarcode = $d->getBarcodePNG($sub[0]->selling_inv, "QRCODE",8,8);
		}
		$boxunit1 = 0;
		$boxunit2 = 0;
		$boxunit3 = 0;
		$boxunit4 = 0;
		$box_unit = DB::table('box')->where('box_sellingid',$id)->groupby('created_at')->get();
		foreach ($box_unit as $value) {
			$boxunit1 += $value->box_unit1;
			$boxunit2 += $value->box_unit2;
			$boxunit3 += $value->box_unit3;
			$boxunit4 += $value->box_unit4;
		}
		// $box_unit = DB::table('box')->select(DB::raw('sum(box_unit1) as sum1,sum(box_unit2) as sum2,sum(box_unit3) as sum3,sum(box_unit4) as sum4'))->where('box_sellingid',$id)->groupby('created_at')->first();
		// $boxunit1 = $box_unit->sum1;
		// $boxunit2 = $box_unit->sum2;
		// $boxunit3 = $box_unit->sum3;
		// $boxunit4 = $box_unit->sum4;
		// dd($sub);
		$pdf = PDF::loadView('transport.poll',['data' => $data,'setting' => $setting,'tran' => $tran,'sub'=>$sub,'qrcode'=>$genbarcode,'total'=>$totalcount,'boxunit1'=>$boxunit1,'boxunit2'=>$boxunit2,'boxunit3'=>$boxunit3,'boxunit4'=>$boxunit4],[],['title' => 'โพย','format'=>'A4-L']);
        return $pdf->stream();
		// return view('transport/poll');
	}

	public function createscanbill(Request $request){
		$selling = selling::where('selling_inv',$request->inv)->where('selling_status','4')->first();
		return Response::json($selling);
	}

	public function scanwaitboxputtingcar(Request $request){

		$box = DB::table('box')->leftjoin('selling','selling_id','box_sellingid')->where('box_tax',$request->scanbarcode)->where('box_status','=','')->groupby('box.created_at')->get();
		// $sub_tran = DB::table('sub_tran')->leftjoin('selling','selling_id','sub_order')->where('sub_status','!=','0')->where('sub_ref','=',$request->id)->get();
		// $dataselling = [];
		// foreach ($sub_tran as $sell) {
		// 	$dataselling[$sell->sub_order] = $sell->selling_inv;
		// }
		$unit1 = 0;
		$unit2 = 0;
		$unit3 = 0;
		$unit4 = 0;
		$arrayselling = [];
		// dd($dataselling);
		foreach ($box as $value) {
			// if(array_search($value->box_orderinv,$dataselling)){
				$unit1 += $value->box_unit1 ;
				$unit2 += $value->box_unit2 ;
				$unit3 += $value->box_unit3 ;
				$unit4 += $value->box_unit4 ;
				$selling = selling::find($value->box_sellingid);
				$selling->selling_scantypeunit1 = $selling->selling_scantypeunit1+$value->box_unit1 ;
				$selling->selling_scantypeunit2 = $selling->selling_scantypeunit2+$value->box_unit2 ;
				$selling->selling_scantypeunit3 = $selling->selling_scantypeunit3+$value->box_unit3 ;
				$selling->selling_scantypeunit4 = $selling->selling_scantypeunit4+$value->box_unit4 ;
				// $totalselling = $selling->selling_typeunit1 +$selling->selling_typeunit2 +$selling->selling_typeunit3 +$selling->selling_typeunit4;
				// $totalsellingscan = $selling->selling_scantypeunit1 +$selling->selling_scantypeunit2 +$selling->selling_scantypeunit3 +$selling->selling_scantypeunit4;
				// if($totalselling == $totalsellingscan){

				// }
				$selling->save();
				// DB::table('box')->where('box_id',$value->box_id)->update(['box_status'=>1]);
			// }else{
			// 	$datax = [
			// 		'check' =>0,
			// 		'id' =>'',
			// 		// 'qty' =>$qty,
			// 	];
			// 	return Response::json($datax);
			// }
		}
		DB::table('box')->where('box_tax',$request->scanbarcode)->where('box_status','=','')->update(['box_status'=>1]);
		// dd($box);
		if(count($box) == 0){
			$datax = [
				'check' =>0,
				'id' 	=>'',
				'data' 	=>'',
			];
			$boxcheck = DB::table('box')->leftjoin('selling','selling_id','box_sellingid')->where('box_tax',$request->scanbarcode)->where('box_status','=','1')->get();
			if(count($boxcheck) == 0){
				// dd('บันทึกสแกนข้อมูลที่ไม่มีในบิล');
				$check = logscanboxputtingcar::where('scanboxputtingcar_tax',$request->scanbarcode)->where('scanboxputtingcar_ref',$request->id)->where('scanboxputtingcar_date',date("Y-m-d"))->first();
				if(!empty($check)){
					$check->scanboxputtingcar_count = $check->scanboxputtingcar_count+1;
					$check->save();
				}else{
					$logscanboxputtingcar = new logscanboxputtingcar;
					$logscanboxputtingcar->scanboxputtingcar_date = date("Y-m-d");
					$logscanboxputtingcar->scanboxputtingcar_ref = $request->id;
					$logscanboxputtingcar->scanboxputtingcar_tax = $request->scanbarcode;
					$logscanboxputtingcar->scanboxputtingcar_count = ($logscanboxputtingcar->scanboxputtingcar_count||0)+1;
					$logscanboxputtingcar->scanboxputtingcar_user = Auth::id();
					$logscanboxputtingcar->save();
				}
			}else{
				$datax = [
					'check' =>2,
					'id' 	=>'',
					'data' 	=>'',
				];
			}
			

		}else{
			$box = DB::table('box')->leftjoin('selling','selling_id','box_sellingid')->select(DB::raw('*,(selling_typeunit1+selling_typeunit2+selling_typeunit3+selling_typeunit4) as sumitem,(selling_scantypeunit1+selling_scantypeunit2+selling_scantypeunit3+selling_scantypeunit4) as sumscanitem'))->where('box_tax',$request->scanbarcode)->groupby('selling_id')->get();
			$checkallitem = DB::table('sub_tran')->leftjoin('selling','selling_id','sub_order')->leftjoin('box','selling_id','box_sellingid')->select(DB::raw("*,COUNT(CASE WHEN box_status = '' THEN 1 END) as countstatus"))->where('sub_status','!=','0')->where('sub_ref','=',$request->id)->first();
			if($checkallitem->countstatus == 0){
				DB::table('transport')->where('trans_id',$request->id)->update(['trans_status' => 5,'updated_at'=>date("Y-m-d H:i:s")]);
			}else{
				DB::table('transport')->where('trans_id',$request->id)->update(['trans_status' => 6,'updated_at'=>date("Y-m-d H:i:s")]);
			}
			// dd($sub_tran);
			$datax = [
				'check' =>1,
				'id' 	=>'',
				'data' 	=>$box,
			];

		}
		return Response::json($datax);
		echo $unit1.' '.$unit2.' '.$unit3.' '.$unit4;
		
		dd($arrayselling);
		$data = DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->leftjoin('selling','selling_id','sub_order')->where('selling_inv',$request->scanbarcode)->where('trans_id',$request->id)->first();
		// $data = DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->leftjoin('selling','selling_id','sub_order')->leftjoin('selling_detail','selling_id','sellingdetail_ref')->where('product_barcode',$request->scanbarcode)->where('trans_id',$request->id)->first();
		$count = 0;
		$id = '';
		$qty = 0;
		if(!empty($data)){
			$count = 1;
			$id = $request->scanbarcode;
			DB::table('sub_tran')->where('sub_id',$data->sub_id)->update(['sub_status' => 1,'updated_at' => new DateTime()]);
			// $qty = $data->sellingdetail_qty;
		}
		$datax = [
			'check' =>$count,
			'id' =>$id,
			// 'qty' =>$qty,
		];
		$checkall = true;
		$datatran = DB::table('sub_tran')->where('sub_ref',$request->id)->get();
		foreach($datatran as $item){
			if($item->sub_status == ''){
				$checkall = false;
			}
		}
		// if($checkall){
		// 	DB::table('transport')->where('trans_id',$request->id)->update(['trans_status' => 3,'updated_at' => new DateTime()]);
		// }else{
		// 	DB::table('transport')->where('trans_id',$request->id)->update(['trans_status' => 4,'updated_at' => new DateTime()]);
		// }
		return Response::json($datax);
	}

	public function addpollintransport(Request $request){
		$selling = selling::where('selling_inv',$request->poll)->where('selling_status','4')->first();
		if(count($selling) != 0){
			$arr = [
				'sub_ref'		=> $request->id,
				'sub_order'		=> $request->input('poll'),
				'created_at'	=> new DateTime(),
				'updated_at'	=> new DateTime(),
			];
			DB::table('sub_tran')->insert($arr);
			DB::table('selling')->where('selling_id',$request->input('poll'))->update(['selling_status' => 5,'updated_at' => new DateTime()]);
			savelog('7','เพิ่มข้อมูลขนส่งเลขที่เดอร์ '.$request->input('poll'));

			
			$checkallitem = DB::table('sub_tran')->leftjoin('selling','selling_id','sub_order')->leftjoin('box','selling_id','box_sellingid')->select(DB::raw("*,COUNT(CASE WHEN box_status = '' THEN 1 END) as countstatus"))->where('sub_status','!=','0')->where('sub_ref','=',$request->id)->first();
			if($checkallitem->countstatus == 0){
				DB::table('transport')->where('trans_id',$request->id)->update(['trans_status' => 5,'updated_at'=>date("Y-m-d H:i:s")]);
			}else{
				DB::table('transport')->where('trans_id',$request->id)->update(['trans_status' => 6,'updated_at'=>date("Y-m-d H:i:s")]);
			}
			return "Y";
		}else{
			return "X";
		}
		
	}
}
