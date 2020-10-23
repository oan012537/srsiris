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
use App\supplier;
use App\product;
use App\imports;
use App\subimports;
use App\processingunit;
use App\stock;
use App\selling;
use App\sellingdetail;
use PDF;
use \Milon\Barcode\DNS2D;
use URL;

class PackingController extends Controller
{
    public function index(){
        $dateY      = date('Y');
        $dateM      = date('m');
        $dateD      = date('d');
        $cutdate    = substr($dateY,2,2);
        $strdate    = 'B'.$cutdate.$dateM.$dateD;
        $invoice    = DB::table('box')->where('box_tax','like',$strdate."%")->orderBy('box_id','desc')->first();
        if(!empty($invoice)){
            $str = $invoice->box_tax;
            $sub = substr($str,8,3)+1;
            $cut = substr($str,0,8);
            $inv = $cut.sprintf("%02d",$sub);
        }else{
            $dateY = date('Y');
            $dateM = date('m');
            $dateD = date('d');
            $cutdate = substr($dateY,2,2);
            $strdate = 'B'.$cutdate.$dateM.$dateD.sprintf("%03d",1);
            $inv = $strdate;
        }
		return view('packing/index',['invoice' => $inv,'inv'=>'']);
	}

    public function inv($invoice){
        $inv = $this->index()->invoice;
        return view('packing/index',['invoice' => $inv,'inv'=>$invoice]);
    }
    public function datatable(){
        $billingnote = DB::table('billingnote')->leftjoin('billingnotedata','billingnote.billingnote_id','billingnotedata.billingnotedata_billingnoteid')->leftjoin('export','billingnotedata.billingnotedata_exportid','export.export_id')->get();
        
        $sQuery = Datatables::of($billingnote);
        return $sQuery->escapeColumns([])->make(true);
    }

    public function packingitem(){
        $billingnote = DB::table('billingnote')->leftjoin('billingnotedata','billingnote.billingnote_id','billingnotedata.billingnotedata_billingnoteid')->leftjoin('export','billingnotedata.billingnotedata_exportid','export.export_id')->first();
        return view('packing/packingitem');
    }

    public function dataproduct(Request $request){
        

        // $selling   = DB::table('selling')->where('selling_inv',$request->input('billno'))->first();//ของเก่า
        $selling   = DB::table('selling')->where('selling_inv',$request->input('billno'))->where('selling_status','!=','0')->first();
        if(!empty($selling)){
            // $orders   = DB::table('selling_detail')->leftjoin('product','selling_detail.sellingdetail_productid','product.product_id')->leftjoin('orders','selling_detail.sellingdetail_sellingref','orders.order_id')->where('sellingdetail_ref',$selling->selling_id)->get();
            $orders   = DB::table('selling_detail')->leftjoin('product','selling_detail.sellingdetail_productid','product.product_id')->where('sellingdetail_ref',$selling->selling_id)->get();
            foreach($orders as $item){
                if($item->sellingdetail_typeunit == '1'){
                    $unit = DB::table('unit')->where('unit_id',$item->sellingdetail_unit)->first();
                    $item->unitname = $unit->unit_name;
                }elseif($item->sellingdetail_typeunit == '2'){
                    $unit = DB::table('unitsub')->where('unitsub_id',$item->sellingdetail_unit)->first();
                    $item->unitname = $unit->unitsub_name;
                }else{
                    $item->unitname = '';
                }
            }
        }else{
            $orders = [];
            $selling = [];
        }
        return Response::json(['selling' => $selling,'order' => $orders]);
    }

    public function store(Request $request){
        $dateY      = date('Y');
        $dateM      = date('m');
        $dateD      = date('d');
        $cutdate    = substr($dateY,2,2);
        $strdate    = $cutdate.$dateM.$dateD;
        $invoice    = DB::table('billingnote')->where('billingnote_inv','like',$strdate."%")->orderBy('billingnote_id','desc')->first();
        if(!empty($invoice)){
            $str = $invoice->billingnote_inv;
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
            'billingnote_inv'       => $inv,
            'billingnote_date'      => date("Y-m-d"),
            // 'billingnote_total'     => $request->input('empsaleid'),
            'billingnote_status'    => 0,
            'created_at'            => new DateTime(),
            'updated_at'            => new DateTime(),
        ];
        DB::table('billingnote')->insert($data);
        $lastid = DB::table('billingnote')->latest()->first();
        $total = 0;
        if($request->input('selectbill')){
            foreach($request->input('selectbill') as $key => $row){
                $export = DB::table('export')->where('export_id',$request->input('selectbill')[$key]);
                $total = $total + $export->export_totalpayment;
                $detail = [
                    'billingnotedata_billingnoteid' => $lastid->billingnote_id,
                    'billingnotedata_exportid'      => $request->input('selectbill')[$key],
                    'created_at'                    => new DateTime(),
                    'updated_at'                    => new DateTime(),
                ];
                DB::table('billingnotedata')->insert($detail);
            }
        }
        $data_ = [
            'billingnote_pay'        => 0,
            'billingnote_balance'    => $total,
            'billingnote_total'      => $total,
        ];
        DB::table('billingnote')->where('billingnote_id',$lastid->billingnote_id)->update($data_);
        Session::flash('alert-insert','insert');
        return redirect('billingnote');
    }

    public function delete($id){
        DB::table('billingnote')->where('billingnote_id',$id)->delete();
        DB::table('billingnotedata')->where('billingnotedata_billingnoteid',$id)->delete();
        
        Session::flash('alert-delete','delete');
        return redirect('billingnote');
    }

    public function viewpay($id){
        $billingnote = DB::table('billingnote')->leftjoin('billingnotedata','billingnote.billingnote_id','billingnotedata.billingnotedata_billingnoteid')->leftjoin('export','billingnotedata.billingnotedata_exportid','export.export_id')->where('billingnote_id',$id)->get();
        return view('billingnote.view',['data' => $billingnote]);
    }

    public function update(Request $request){
        if($request->file('uploadcover')){
            foreach($request->file('uploadcover') as $key => $files){
                $filename   = $files->getClientOriginalName();
                $extension  = $files->getClientOriginalExtension();
                $size       = $files->getSize();
                $imgcover   = date('His').$filename;
                $destinationPath = base_path()."/assets/images/billingnote/";
                $files->move($destinationPath, $imgcover);
                $billingnoteimage = array(
                    'billingnoteimage_billingnoteid'    =>  $request->billingnoteid,
                    'billingnoteimage_date'             =>  date("Y-m-d"),
                    'billingnoteimage_name'             =>  $imgcover,
                    'billingnoteimage_status'           =>  1,
                    'created_at'                        =>  new DateTime,
                    'updated_at'                        =>  new DateTime
                );
               DB::table('billingnoteimage')->insert($billingnoteimage);
            }
        }
        if($request->input('pay')){
            // exit();
            $billingnote = DB::table('billingnote')->where('billingnote_id',$request->billingnoteid)->first();
            $cal = $billingnote->billingnote_balance - $request->pay;
            $data = [
                'billingnotepay_billingnoteid'      => $request->billingnoteid,
                'billingnotepay_date'               => date("Y-m-d"),
                'billingnotepay_money'              => $request->pay,
                'billingnotepay_balance'            => $cal,
                'billingnotepay_oldbalance'         => $billingnote->billingnote_balance,
                'created_at'        => new DateTime(),
                'updated_at'        => new DateTime(),
            ];
            DB::table('billingnotepay')->insert($data);
            if($cal != 0){
                $status = '2';
            }else if($cal == 0){
                $status = '1';
            }
            $update = [
                'billingnote_pay'        => $billingnote->billingnote_pay + $request->pay,
                'billingnote_balance'    => $cal,
                'billingnote_status'     => $status,
                'updated_at'             => new DateTime(),
            ];
            DB::table('billingnote')->where('billingnote_id',$request->billingnoteid)->update($update);
        }
        // exit();
        Session::flash('alert-insert','insert');
        return redirect('billingnote');
    }

    public function viewdata($id){
        $data = DB::table('billingnote')->leftjoin('billingnotedata','billingnote.billingnote_id','billingnotedata.billingnotedata_billingnoteid')->leftjoin('export','billingnotedata.billingnotedata_exportid','export.export_id')->where('billingnote_id',$id)->first();
        $pay = DB::table('billingnote')->leftjoin('billingnotepay','billingnote.billingnote_id','billingnotepay.billingnotepay_billingnoteid')->where('billingnote_id',$id)->get();

        $file = DB::table('billingnote')->leftjoin('billingnoteimage','billingnote.billingnote_id','billingnoteimage.billingnoteimage_billingnoteid')->where('billingnote_id',$id)->get();

        // dd($data);
        return view('billingnote.viewdata',['data' => $data,'datapay' => $pay,'datafile' => $file]);
    }

    public function scanbarcode(Request $request){
        // dd($request);
        $dataorder = DB::table('selling_detail')->leftjoin('product','selling_detail.sellingdetail_productid','product.product_id')->where('sellingdetail_ref',$request->input('billid'))->where('product_barcode',$request->barcode)->first();
        $statusproduct = [];
        if(!empty($dataorder)){
            
            $returnsearchbarcode = 'Y';
            $statusorder = '1';
            if($dataorder->sellingdetail_count + 1 <= $dataorder->sellingdetail_qty){

                //นับหน่วยยังไม่เสร็จ
                $selling = selling::find($dataorder->sellingdetail_ref);
                $txt = 'selling_typeunit'.$request->typeunit;
                $sumunit = $selling->$txt+1;
                $selling->$txt = $sumunit ;
                $selling->save();
                //นับหน่วย
            
                if($dataorder->sellingdetail_count + 1 == $dataorder->sellingdetail_qty){
                    $statusorder = '2';
                }

                //ใส่หน่วยมรา
                $sellingdetail = sellingdetail::find($dataorder->sellingdetail_id);
                $txtdetail = 'sellingdetail_typepack'.$request->typeunit;
                $sumunitdetail = $sellingdetail->$txtdetail+1;
                $sellingdetail->$txtdetail = $sumunitdetail ;
                $sellingdetail->sellingdetail_count = $sellingdetail->sellingdetail_count+1;
                $sellingdetail->sellingdetail_status = $statusorder ;
                // dd($sellingdetail);
                $sellingdetail->save();

                // $update = [
                //     'sellingdetail_count' => $dataorder->sellingdetail_count + 1,
                //     'sellingdetail_status' => $statusorder
                // ];
                // dd($update);
                // DB::table('selling_detail')->where('sellingdetail_id',$dataorder->sellingdetail_id)->update($update);

                $databox = DB::table('box')->where('box_orderinv',$request->input('billno'))->where('box_tax',$request->input('boxtax'))->where('box_product',$dataorder->product_id)->first();
                // dd($dataorder);
                

                if(!empty($databox)){
                    $txtbox = 'box_unit'.$request->typeunit;
                    $sumunitbox = $databox->$txtbox+1;
                    $box = [
                        'box_date'          =>      date('Y-m-d'),
                        'box_tax'           =>      $request->input('boxtax'),
                        'box_sellingid'     =>      $dataorder->sellingdetail_ref,
                        'box_orderinv'      =>      $request->input('billno'),
                        'box_product'       =>      $dataorder->product_id,
                        'box_no'            =>      $request->input('boxno'),
                        'box_number'        =>      $databox->box_number + 1,
                        'box_unit'.$request->typeunit        =>      $sumunitbox,

                    ];
                    DB::table('box')->where('box_id',$databox->box_id)->update($box);
                }else{
                    $box = [
                        'box_date'          =>      date('Y-m-d'),
                        'box_tax'           =>      $request->input('boxtax'),
                        'box_sellingid'     =>      $dataorder->sellingdetail_ref,
                        'box_orderinv'      =>      $request->input('billno'),
                        'box_product'       =>      $dataorder->product_id,
                        'box_no'            =>      $request->input('boxno'),
                        'box_number'        =>      1,
                        'box_unit'.$request->typeunit        =>      1,
                    ];
                    DB::table('box')->insert($box);
                }
            }else{
                
                $statusproduct = [
                    'status'    => 'Y',
                    'name'      => $dataorder->product_name,
                ];
            }
        }else{
            $returnsearchbarcode = 'X';
        }

        //ทำต่อนับหน่วยสินค้า
        $dataorder = DB::table('selling_detail')->where('sellingdetail_ref',$request->input('billid'))->where('sellingdetail_status','1')->get();
        if(count($dataorder) == 0){
            $updateexport = [
                'selling_status'        => '4',
                'selling_statuspacking' => '1',
                'updated_at'            => new DateTime(),
            ];
            DB::table('selling')->where('selling_id',$request->input('billid'))->update($updateexport);
        }else{
            $updateexport = [
                'selling_status' => '6',
                'updated_at'   => new DateTime(),
            ];
            DB::table('selling')->where('selling_id',$request->input('billid'))->update($updateexport);
        }
        $export   = DB::table('selling')->where('selling_id',$request->input('billid'))->first();
        
        if(!empty($export)){
            // $orders   = DB::table('selling_detail')->leftjoin('product','selling_detail.sellingdetail_productid','product.product_id')->leftjoin('orders','selling_detail.sellingdetail_sellingref','orders.order_id')->where('sellingdetail_ref',$export->selling_id)->get();
            $orders   = DB::table('selling_detail')->leftjoin('product','selling_detail.sellingdetail_productid','product.product_id')->where('sellingdetail_ref',$selling->selling_id)->get();
            // dd($orders);
            foreach($orders as $item){
                if($item->sellingdetail_typeunit == '1'){
                    $unit = DB::table('unit')->where('unit_id',$item->sellingdetail_unit)->first();
                    $item->unitname = $unit->unit_name;
                }elseif($item->sellingdetail_typeunit == '2'){
                    $unit = DB::table('unitsub')->where('unitsub_id',$item->sellingdetail_unit)->first();
                    $item->unitname = $unit->unitsub_name;
                }else{
                    $item->unitname = '';
                }
            }
            echo "";
        }else{
            $orders = [];
            $export = [];
        }
        savelog('6','สแกนบาร์โค้ดเลขบิลขาย '.$request->input('billid').' เลขที่บิล '.$request->input('barcode'));
        return Response::json(['export' => $export,'order' => $orders,'statusproduct' => $statusproduct,'returnsearchbarcode' => ['status' => $returnsearchbarcode]]);
    }
    public function changebox(Request $request){
        $dateY      = date('Y');
        $dateM      = date('m');
        $dateD      = date('d');
        $cutdate    = substr($dateY,2,2);
        $strdate    = 'B'.$cutdate.$dateM.$dateD;
        $invoice    = DB::table('box')->where('box_tax','like',$strdate."%")->orderBy('box_id','desc')->first();
        if(!empty($invoice)){
            $str = $invoice->box_tax;
            $sub = substr($str,8,3)+1;
            $cut = substr($str,0,8);
            $inv = $cut.sprintf("%02d",$sub);
        }else{
            $dateY = date('Y');
            $dateM = date('m');
            $dateD = date('d');
            $cutdate = substr($dateY,2,2);
            $strdate = 'B'.$cutdate.$dateM.$dateD.sprintf("%03d",1);
            $inv = $strdate;
        }
        $boxno = $request->boxno+1;
        return Response::json(['invoice' => $inv,'box'=>$boxno]);
    }

    public function invoice($id){
        $setting    = DB::table('setting')->first();

        $data       = [];
        $databox    = [];
        $order = DB::table('selling')->where('selling_id',$id)->first();
        $totaldetail = DB::table('selling_detail')->where('sellingdetail_ref',$id)->count();
        // dd($order);
        $box   = DB::table('box')->select('*', DB::raw('SUM(box_number) as sum'))->where('box_orderinv',$order->selling_inv)->groupby('box_tax')->get();
        $boxcat   = DB::table('box')->leftjoin('product','box_product','product_id')->leftjoin('category','category_id','product_category')->where('box_sellingid',$id)->where('box_product','!=','0')->get();
        // dd($box);
        $arraycat = [] ;
        if(count($boxcat) == 0){
            $boxcat   = DB::table('boxdetail')->leftjoin('box','boxdetail_ref','box_id')->leftjoin('product','boxdetail_productid','product_id')->leftjoin('category','category_id','product_category')->where('box_orderinv',$order->selling_inv)->get();
        }
        foreach($boxcat as $datainbox){
            if($datainbox->category_id != ''){
                $arraycat[$datainbox->box_tax][] = $datainbox->category_name;
            }
        }
        // dd($arraycat);
        // dd($arraycat);
        // $boxsum   = DB::table('box')->select('box_number', DB::raw('SUM(box_number) as sum'))->where('box_orderinv',$order->export_inv)->where('box_no',$box->box_no)->get();
        $cust  = DB::table('customer')->where('customer_id',$order->selling_customerid)->first();
        $data[] = [
            'inv'       => $order->selling_inv,
            'cname'     => $cust->customer_name,
            'ctel'      => $cust->customer_tel,
            'caddr'     => 'บ้านเลขที่-ซอย '.$cust->customer_address1.' ถนน '.$cust->customer_address2.' แขวง/ตำบล '.$cust->customer_address3.' เขต/อำเภอ '.$cust->customer_address4.' จังหวัด '.$cust->customer_address5.' รหัสไปรษณย์ '.$cust->customer_address6,
        ];
        $geturl = URL::current();
        $geturl = explode('/',$geturl);

        $d = new DNS2D();
        $d->setStorPath(__DIR__."/cache/");
        // dd($arraycat);
        if(!empty($box)){
            foreach($box as $keybox => $listbox){
                // $url = $geturl[0].'//'.$geturl[2].'/'.$geturl[3].'/checkproductinbox/'.$listbox->box_tax;
                $url = $geturl[0].'//'.$geturl[2].'/'.'/checkproductinbox/'.$listbox->box_tax;
                // echo $url.'<br>';
                $genbarcode = $d->getBarcodePNG($url, "QRCODE",3.2,3.2);
                // $genbarcode = $d->getBarcodePNG('box_tax', "QRCODE",6,6);
                $listbox->genbarcode = $genbarcode;
                $listbox->datacat = $arraycat[$listbox->box_tax];
                $listbox->sum   = DB::table('box')->where('box_tax',$listbox->box_tax)->count();
                if(count($boxcat) == 0){
                    $listbox->sum   = DB::table('boxdetail')->where('boxdetail_ref',$listbox->box_id)->count();
                }

            }
        }else{
            $genbarcode = $d->getBarcodePNG('box_tax', "QRCODE",6,6);
        }
        
        $databox[] = $box;
        

        // dd($databox);
        $pdf = PDF::loadView('packing.invoice',['data' => $data,'setting' => $setting,'databox'=>$databox,'qrcode'=>$genbarcode,'totaldetail'=>$totaldetail],[],['title' => 'รายการส่งออก','format'=>'A4-L']);
        return $pdf->stream();
       //return view('transport/invoice',['data' => $data,'setting' => $setting,'tran' => $tran]);
    }

    public function putinbox(Request $request){
        // dd($request);
        $statuscountbox = false;
        foreach($request->orderdata as $key => $item){
            // echo $request->ordervalue[$key];
            $dataorder = sellingdetail::leftjoin('product','selling_detail.sellingdetail_productid','product.product_id')->where('sellingdetail_id',$item)->first();
            // $dataorder = DB::table('selling_detail')->leftjoin('product','selling_detail.sellingdetail_productid','product.product_id')->where('sellingdetail_id',$request->input('billid'))->where('product_barcode',$request->barcode)->first();
            $statusproduct = [];
            if(!empty($dataorder)){
                
                $returnsearchbarcode = 'Y';
                $statusorder = '1';
                $balance = $dataorder->sellingdetail_count+$request->ordervalue[$key];
                // dd($balance);
                if($balance <= $dataorder->sellingdetail_qty){ 
                    if(!$statuscountbox){
                        //นับหน่วย
                        $selling = selling::find($dataorder->sellingdetail_ref);
                        $txt = 'selling_typeunit'.$request->typeunit;
                        // $sumunit = $selling->$txt+$request->ordervalue[$key];
                        $sumunit = $selling->$txt+1;
                            $selling->$txt = $sumunit ;
                        $selling->save();
                        //นับหน่วย
                    }
                
                    if($balance == $dataorder->sellingdetail_qty){
                        $statusorder = '2';
                    }
                    // dd($selling->$txt.' == '.$dataorder->sellingdetail_qty);
                    $update = [
                        'sellingdetail_count' => $balance,
                        'sellingdetail_status' => $statusorder
                    ];
                    $dataorder->sellingdetail_count = $balance;
                    $dataorder->sellingdetail_status = $statusorder;
                    $txtselling = 'sellingdetail_typepack'.$request->typeunit;
                    // $dataorder->$txtselling = $dataorder->$txtselling+$request->ordervalue[$key];
                    $dataorder->$txtselling = $dataorder->$txtselling+1;
                    $dataorder->save();
                    // dd($update);
                    // DB::table('selling_detail')->where('sellingdetail_id',$dataorder->sellingdetail_id)->update($update);

                    // $databox = DB::table('box')->where('box_orderinv',$request->input('billno'))->where('box_tax',$request->input('boxtax'))->where('box_product',$dataorder->sellingdetail_productid)->first(); //เก่า
                    $databox = DB::table('box')->where('box_orderinv',$request->input('billno'))->where('box_tax',$request->input('boxtax'))->first(); //ใหม่
                    if(!empty($databox)){
                        $txtbox = 'box_unit'.$request->typeunit;
                        // $sumunitbox = $databox->$txtbox+$request->ordervalue[$key];
                        $sumunitbox = $databox->$txtbox+1;
                        if(!$statuscountbox){
                        
                            $box = [
                                'box_date'          =>      date('Y-m-d'),
                                'box_tax'           =>      $request->input('boxtax'),
                                'box_sellingid'     =>      $dataorder->sellingdetail_ref,
                                'box_orderinv'      =>      $request->input('billno'),
                                // 'box_product'       =>      $dataorder->sellingdetail_productid,
                                'box_no'            =>      $request->input('boxno'),
                                // 'box_number'        =>      $databox->box_number + $request->ordervalue[$key],
                                'box_number'        =>      $databox->box_number + 1,
                                'box_unit'.$request->typeunit        =>      $sumunitbox,
                            ];
                            DB::table('box')->where('box_id',$databox->box_id)->update($box);
                        }
                        $boxid = $databox->box_id;
                        
                    }else{
                        $box = [
                            'box_date'          =>      date('Y-m-d'),
                            'box_tax'           =>      $request->input('boxtax'),
                            'box_sellingid'     =>      $dataorder->sellingdetail_ref,
                            'box_orderinv'      =>      $request->input('billno'),
                            // 'box_product'       =>      $dataorder->sellingdetail_productid,
                            'box_no'            =>      $request->input('boxno'),
                            // 'box_number'        =>      $request->ordervalue[$key],
                            'box_number'        =>      1,
                            // 'box_unit'.$request->typeunit        =>      $request->ordervalue[$key],
                            'box_unit'.$request->typeunit        =>      1,
                        ];
                        DB::table('box')->insert($box);
                        $lastid = DB::table('box')->latest()->first();
                        $boxid = $lastid->box_id;
                    }
                    savelog('6','สแกนบาร์โค้ดเลขบิลขาย '.$item.' เลขที่บิล '.$request->input('billno').' ลงกล่องเลขที่ '.$request->input('boxtax').' กล่องที่ '.$request->input('boxno'));
                    $databoxdetail = DB::table('boxdetail')->where('boxdetail_ref',$boxid)->where('boxdetail_productid',$dataorder->sellingdetail_productid)->count();
                    if($databoxdetail==0){
                        $box = [
                            'boxdetail_ref'          =>      $boxid,
                            'boxdetail_productid'    =>      $dataorder->sellingdetail_productid,
                        ];
                        DB::table('boxdetail')->insert($box);
                    }
                    
                }else{
                    
                    $statusproduct = [
                        'status'    => 'Y',
                        'name'      => $dataorder->product_name,
                    ];
                }
                savelog('6','สแกนบาร์โค้ดเลขบิลขาย '.$item.' เลขที่บิล '.$request->input('billno').' ชื่อสินค้า '.$dataorder->product_name.' จำนวนลงกล่อง '.$request->ordervalue[$key]);
            }else{
                $returnsearchbarcode = 'X';
            }

            //ทำต่อนับหน่วยสินค้า
            $dataorders = DB::table('selling_detail')->where('sellingdetail_ref',$dataorder->sellingdetail_ref)->where('sellingdetail_status','1')->get();
            if(count($dataorders) == 0){
                $updateexport = [
                    'selling_status'        => '4',
                    'selling_statuspacking' => '1',
                    'updated_at'            => new DateTime(),
                ];
                DB::table('selling')->where('selling_id',$dataorder->sellingdetail_ref)->update($updateexport);
            }else{
                $updateexport = [
                    'selling_status' => '6',
                    'updated_at'   => new DateTime(),
                ];
                DB::table('selling')->where('selling_id',$dataorder->sellingdetail_ref)->update($updateexport);
            }
            $export   = DB::table('selling')->where('selling_id',$dataorder->sellingdetail_ref)->first();
            
            savelog('6','สแกนบาร์โค้ดเลขบิลขาย '.$item.' เลขที่บิล '.$export->selling_inv);
            $statuscountbox = true;
        }
        $selling = selling::find($dataorder->sellingdetail_ref);
        // dd();
        return Response::json($selling->selling_status);
    }
}
