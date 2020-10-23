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
use App\area;
use App\billingnote;
use App\selling;
use PDF;

class BillingNoteController extends Controller
{
    public function index(){
        $area = area::all();
		return view('billingnote/index',['area'=>$area]);
	}

    public function datatable(){
        $billingnote = DB::table('billingnote')->select(DB::raw('*,count(*) as count'))->leftjoin('billingnotedata','billingnotedata_billingnoteid','billingnote_id');
        $noorder = request('noorder');
        if($noorder != ''){
            $billingnote->where('billingnote_inv','like','%'.$noorder.'%');
        }
        $datestart = request('datestart');
        $dateend = request('dateend');
        $datestart_ = explode('/',$datestart);
        if(count($datestart_) > 2){
            $datestart = $datestart_[2].'-'.$datestart_[1].'-'.$datestart_[0];
        }
        $dateend_ = explode('/',$dateend);
        if(count($dateend_) > 2){
            $dateend = $dateend_[2].'-'.$dateend_[1].'-'.$dateend_[0];
        }
        if($datestart != '' && $dateend != ''){
            $billingnote->whereBetween('billingnote_date',[$datestart,$dateend]);
        }
        $staus = request('staus');
        if($staus != ''){
            $billingnote->where('billingnote_status','like',$staus.'%');
        }
        $billingnote = $billingnote->groupBy('billingnote_id')->get();
        $sQuery = Datatables::of($billingnote)
        ->addColumn('customername', function($data){
            $customername = DB::table('selling')->where('selling_id',$data->billingnotedata_exportid)->first();
            return $customername->selling_customername;
        });
        return $sQuery->escapeColumns([])->make(true);
    }

    public function create(){
        $area = area::all();
        return view('billingnote/create',['area'=>$area]);
    }

    public function reportdatasale(Request $request){
        $start      = explode('/',$request->input('start'));
        // $strstart   = $start[2]."-".$start[1]."-".$start[0]." 00:00";
        $strstart   = $start[2]."-".$start[1]."-".$start[0];
        $end        = explode('/',$request->input('end'));
        // $strend     = $end[2]."-".$end[1]."-".$end[0]." 23:59";
        $enddate     = $end[2]."-".$end[1]."-".$end[0];
        // $enddate    = date('Y-m-d',strtotime($strend . "+1 days"));

        // $sale   = DB::table('selling')->leftjoin('sub_tran','selling.selling_id','sub_tran.sub_order')->leftjoin('transport','sub_tran.sub_ref','transport.trans_id')->whereBetween('selling.selling_date',[$strstart,$enddate]); //เช็คจากวันที่สร้างออกเดอร์
        $sale   = DB::table('selling')->leftjoin('sub_tran','selling.selling_id','sub_tran.sub_order')->leftjoin('transport','sub_tran.sub_ref','transport.trans_id')->whereBetween('sub_tran.updated_at',[$strstart,$enddate]); //เช็คจากวันที่มีการอัพเดทข้อมูลการส่ง
        $sale   = DB::table('selling')->whereBetween('selling.selling_date',[$strstart,$enddate]);
        if($request->input('customer') != ''){
            $sale = $sale->where('selling_customername','like','%'.$request->input('customer').'%');
        }
        // $sale = $sale->where('trans_status',1)->where('selling_status',1)->get(); //เอาเฉพาะข้อมูลที่ส่งของถึงลูกค้าแล้วมาแสดง
        $sale = $sale->where('selling_status','!=',3)->get(); //เอาเฉพาะข้อมูลที่ส่งของถึงลูกค้าแล้วมาแสดง
        // dd($sale);
        // where('export_status',1)->
        $results = [];
        $sumtotal = 0;
        $sumsale = 0;
        if($sale){
            foreach($sale as $rs){
                $sumsale += $rs->selling_totalpayment;
                $order = DB::table('selling_detail')->where('sellingdetail_ref',$rs->selling_id)->get();
                if($order){
                    foreach($order as $ar){
                        $sumtotal   += $ar->sellingdetail_total;
                        $product    = DB::table('product')->where('product_id',$ar->sellingdetail_productid)->first();
                        $unit       = DB::table('unit')->where('unit_id',$product->product_unit)->first();
                        $stock      = DB::table('product_stock')->where('product_id',$ar->sellingdetail_productid)->where('product_sale',$ar->sellingdetail_price)->first();
                        
                        $results[] = [
                            'checkbox'  => '<input type="checkbox" name="selectbill[]" id="selectbill'.$rs->selling_id.'" value="'.$rs->selling_id.'">',
                            'inv'       => $rs->selling_inv,
                            'date'      => date('d/m/Y',strtotime($rs->selling_date)),
                            'code'      => $product->product_code,
                            'name'      => $product->product_name,
                            'unit'      => $unit->unit_name,
                            'price'     => number_format($ar->sellingdetail_price,2),
                            // 'capital'   => number_format($ar->order_capital,2),
                            'qty'       => number_format($ar->sellingdetail_qty),
                            'total'     => number_format($ar->sellingdetail_total,2),
                        ];
                    }
                }
            }
        }
        $total[] = ['sumtotal' => number_format($sumtotal,2),'sumsale' => number_format($sumsale,2),'totals' => number_format($sumsale-$sumtotal,2)];
        return Response::json(['sale' => $sale,'results' => $results,'total' => $total]);
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
                // echo $request->input('selectbill')[$key];
                $selling = DB::table('selling')->where('selling_id',$request->input('selectbill')[$key])->first();
                $total = $total + $selling->selling_totalpayment;
                $detail = [
                    'billingnotedata_billingnoteid' => $lastid->billingnote_id,
                    'billingnotedata_exportid'      => $request->input('selectbill')[$key],
                    'created_at'                    => new DateTime(),
                    'updated_at'                    => new DateTime(),
                ];
                DB::table('billingnotedata')->insert($detail);
                DB::table('selling')->where('selling_id',$request->input('selectbill')[$key])->update(['selling_status'=>7]);
            }
        }
        $data_ = [
            'billingnote_pay'        => 0,
            'billingnote_balance'    => $total,
            'billingnote_total'      => $total,
        ];
        DB::table('billingnote')->where('billingnote_id',$lastid->billingnote_id)->update($data_);

        savelog('8','เพิ่มข้อมูลใบเก็บเงินเลขที่บิล '.$inv);

        Session::flash('alert-insert','insert');
        return redirect('billingnote');
    }

    public function delete($id){
        $billingnote = DB::table('billingnote')->where('billingnote_id',$id)->first();
        savelog('8','ลบข้อมูลใบเก็บเงินเลขที่บิล '.$billingnote->billingnote_inv);

        DB::table('billingnote')->where('billingnote_id',$id)->delete();
        DB::table('billingnotedata')->where('billingnotedata_billingnoteid',$id)->delete();
        
        Session::flash('alert-delete','delete');
        return redirect('billingnote');
    }

    public function viewpay($id){
        $billingnote = DB::table('billingnote')->leftjoin('billingnotedata','billingnote.billingnote_id','billingnotedata.billingnotedata_billingnoteid')->leftjoin('selling','billingnotedata.billingnotedata_exportid','selling.selling_id')->where('billingnote_id',$id)->get();
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

    public function updates(Request $request){
        // dd($request);
        // if($request->file('uploadcover')){
        //     foreach($request->file('uploadcover') as $key => $files){
        //         $filename   = $files->getClientOriginalName();
        //         $extension  = $files->getClientOriginalExtension();
        //         $size       = $files->getSize();
        //         $imgcover   = date('His').$filename;
        //         $destinationPath = base_path()."/assets/images/billingnote/";
        //         $files->move($destinationPath, $imgcover);
        //         $billingnoteimage = array(
        //             'billingnoteimage_type'             =>  $request->typepay,
        //             'billingnoteimage_billingnoteid'    =>  $request->billingnoteid,
        //             'billingnoteimage_date'             =>  date("Y-m-d"),
        //             'billingnoteimage_name'             =>  $imgcover,
        //             'billingnoteimage_status'           =>  1,
        //             'created_at'                        =>  new DateTime,
        //             'updated_at'                        =>  new DateTime
        //         );
        //        DB::table('billingnoteimage')->insert($billingnoteimage);
        //     }
        // }
        if($request->file('uploaddiscount')){
            foreach($request->file('uploaddiscount') as $key => $files){
                $filename   = $files->getClientOriginalName();
                $extension  = $files->getClientOriginalExtension();
                $size       = $files->getSize();
                $imgcover   = date('His').$filename;
                $destinationPath = base_path()."/assets/images/billingnote/";
                $files->move($destinationPath, $imgcover);
                $billingnoteimage = array(
                    'billingnoteimage_type'             =>  '2',
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
        if($request->file('imagecheck')){
            foreach($request->file('imagecheck') as $key => $files){
                $filename   = $files->getClientOriginalName();
                $extension  = $files->getClientOriginalExtension();
                $size       = $files->getSize();
                $imgcover   = date('His').$filename;
                $destinationPath = base_path()."/assets/images/billingnote/";
                $files->move($destinationPath, $imgcover);
                $billingnoteimage = array(
                    'billingnoteimage_type'             =>  '2',
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
        if($request->uploadimage!=''){

            $uploadcover = explode(',',$request->uploadimage);
            if(count($uploadcover) > 0){
                foreach ($uploadcover as $uploadcovers) {
                    $exploadnames = explode('.',$uploadcovers);
                    $imgcover   = date('Ymd_His');
                    $destinationPath = base_path()."/assets/images/billingnote/upload/".$valuecheck;
                    File::move($destinationPath, base_path()."/assets/images/billingnote/".$imgcover.'.'.$exploadnames[count($exploadnames)-1]);
                    $billingnoteimage = array(
                        'billingnoteimage_type'             =>  '2',
                        'billingnoteimage_billingnoteid'    =>  $request->billingnoteid,
                        'billingnoteimage_date'             =>  date("Y-m-d"),
                        'billingnoteimage_name'             =>  $imgcover.'.'.$exploadnames[count($exploadnames)-1],
                        'billingnoteimage_status'           =>  1,
                        'created_at'                        =>  new DateTime,
                        'updated_at'                        =>  new DateTime
                    );
                   DB::table('billingnoteimage')->insert($billingnoteimage);
                    
                }
            }
        }
        if($request->uploadimagecheck!=''){
            $imagecheck = explode(',',$request->uploadimagecheck);
            if(count($imagecheck) > 0){
                foreach ($imagecheck as $valuecheck) {
                    $exploadname = explode('.',$valuecheck);
                    $imgcover   = date('Ymd_His');
                    $destinationPath = base_path()."/assets/images/billingnote/upload/".$valuecheck;
                    File::move($destinationPath, base_path()."/assets/images/billingnote/".$imgcover.'.'.$exploadname[count($exploadname)-1]);
                    $billingnoteimage = array(
                        'billingnoteimage_type'             =>  '2',
                        'billingnoteimage_billingnoteid'    =>  $request->billingnoteid,
                        'billingnoteimage_date'             =>  date("Y-m-d"),
                        'billingnoteimage_name'             =>  $imgcover.'.'.$exploadname[count($exploadname)-1],
                        'billingnoteimage_status'           =>  1,
                        'created_at'                        =>  new DateTime,
                        'updated_at'                        =>  new DateTime
                    );
                   DB::table('billingnoteimage')->insert($billingnoteimage);
                    
                }
            }
        }
        // if($request->hasFile('imagecheck')){
        //     $files = $request->file('imagecheck');
        //     $filename   = $files->getClientOriginalName();
        //     $extension  = $files->getClientOriginalExtension();
        //     $size       = $files->getSize();
        //     $imgcover   = date('His').$filename;
        //      $destinationPath = base_path()."/assets/images/billingnote/";
        //     $files->move($destinationPath, $imgcover);
        //     $billingnoteimage = array(
        //             'billingnoteimage_type'             =>  '3',
        //             'billingnoteimage_billingnoteid'    =>  $request->billingnoteid,
        //             'billingnoteimage_date'             =>  date("Y-m-d"),
        //             'billingnoteimage_name'             =>  $imgcover,
        //             'billingnoteimage_status'           =>  1,
        //             'created_at'                        =>  new DateTime,
        //             'updated_at'                        =>  new DateTime
        //         );
        //        DB::table('billingnoteimage')->insert($billingnoteimage);
        // }
        // dd();

        if($request->input('pay')){
            // exit();
            $billingnote = DB::table('billingnote')->where('billingnote_id',$request->billingnoteid)->first();
            $cal = $billingnote->billingnote_balance - $request->pay;
            if($cal < 0){
                $cal = 0;
            }
            $data = [
                'billingnotepay_billingnoteid'      => $request->billingnoteid,
                'billingnotepay_date'               => date("Y-m-d"),
                'billingnotepay_money'              => $request->pay,
                'billingnotepay_typepay'            => $request->typepay,
                'billingnotepay_bank'               => ($request->checkbank != ''?$request->checkbank:''),
                'billingnotepay_account'            => ($request->checkno != ''?$request->checkno:''),
                'billingnotepay_balance'            => $cal,
                'billingnotepay_oldbalance'         => $billingnote->billingnote_balance,
                'billingnotepay_discount'           => ($request->discount != ''?$request->discount:0),
                'created_at'        => new DateTime(),
                'updated_at'        => new DateTime(),
            ];
            DB::table('billingnotepay')->insert($data);

            if($cal != 0){
                $status = '2';
            }else if($cal == 0){
                $status = '1';
                
            }
            $check = explode(',',$request->check);
            $moneypay = $request->pay+($request->discount != ''?$request->discount:0) ; //จำนวนเงินที่จ่าย

            // dd($request->discount);
            $wherein = [];
            foreach ($check as $sellid) {
                // echo  $sellid.'<br>';
                $selling = selling::find($sellid); //หาข้อมูลขาย
                $getbillingnotedata = DB::table('billingnotedata')->where('billingnotedata_billingnoteid',$request->billingnoteid)->where('billingnotedata_exportid',$sellid)->first(); //ดึงข้อมูลการจ่ายเงินเก่า

                $calmoney = $moneypay - ($selling->selling_totalall-$getbillingnotedata->billingnotedata_pay) ; //เอายอดจ่าย - ยอดบิล เพื่อเช็คบิลว่าจ่ายเงินแล้ว
                // dd($calmoney);
                if($calmoney < 0){
                    //สถานะว่ายังไม่ได้จ่ายเงิน
                    $wherein[] = $sellid;
                    if($moneypay == 0){
                        $calmoney = 0;
                    }else{
                        if($calmoney < 0){
                            $calmoney = $moneypay+$getbillingnotedata->billingnotedata_pay;
                        }else{
                            $calmoney = $moneypay;
                        }
                        $moneypay = 0;
                    }
                    
                }else{
                    if($calmoney == 0){
                        $calmoney = $moneypay+$getbillingnotedata->billingnotedata_pay;
                    }else if($calmoney > 0 && $request->payamount < $moneypay){
                        $moneypay = $calmoney;
                        $calmoney = $getbillingnotedata->billingnotedata_pay+$request->pay;
                    } else{
                        $moneypay = $calmoney;
                    }
                    $updatestatus = [
                        'selling_status'      => '8',
                        'updated_at'          => new DateTime(),
                    ];
                    // dd($updatestatus);
                    DB::table('selling')->where('selling_id',$sellid)->update($updatestatus);
                }
                $updatebillingnotedata = [
                    'billingnotedata_pay'      => $calmoney, 
                    'updated_at'          => new DateTime(),
                ];
                // dd($updatebillingnotedata);
                DB::table('billingnotedata')->where('billingnotedata_billingnoteid',$request->billingnoteid)->where('billingnotedata_exportid',$sellid)->update($updatebillingnotedata);
                // echo $moneypay.'<br>';
                
            }
            // dd($request->pay);

            //แก้ใหม่ตามที่บอกว่า ถ้ากดจ่ายเงินบางรายการแล้วรายการที่เหลือจะยกเลิกโดยอัตโนมัติ และถ้าจะจ่ายต้องทำการจัดบิลใหม่
            $billingnotedata = DB::table('billingnotedata')->leftjoin('selling','selling_id','billingnotedata_exportid')->where('billingnotedata_billingnoteid',$request->billingnoteid)->where('selling_status','!=','8');
            if(!empty($wherein)){
                $billingnotedata = $billingnotedata->whereNotIn('selling_id',$wherein);
            }
            $billingnotedata = $billingnotedata->get();
            // dd($billingnotedata);
            $billingnote_balance = 0;
            if($billingnotedata){
                foreach ($billingnotedata as $billingnotedataid) {
                    $selling = selling::find($billingnotedataid->selling_id);
                    $selling->selling_status = '1';
                    $selling->save();

                    $updatestatusbillingnotedata = [
                        'billingnotedata_status'        => '0',
                        'updated_at'                    => new DateTime(),
                    ];
                    DB::table('billingnotedata')->where('billingnotedata_id',$billingnotedataid->billingnotedata_id)->update($updatestatusbillingnotedata);

                    $billingnote_balance += $billingnotedataid->selling_totalall-$billingnotedataid->billingnotedata_pay;
                }
            }
            // echo $cal.'<br>';
            $cal2 = $billingnote->billingnote_total - $billingnote_balance; //จำนวนเงินที่ตามใบเก็บเงิน-จำนวนเงินที่ตัดออกจากใบเก็บเงิน
            // dd($cal2);
            // echo $cal2.'<br>';
            // dd($request->payamount.' == '.$request->pay)

            $datasumpay = DB::table('billingnotedata')->select('billingnotedata_pay', DB::raw('SUM(billingnotedata_pay) as sumpay'))->where('billingnotedata_billingnoteid',$request->billingnoteid)->first(); //จำนวนเงินที่จ่ายมาทั้งหมดของบิล
            $sumpay = $datasumpay->sumpay;
            // if($request->payamount != $request->pay){
            if($request->payamount > $request->pay+($request->discount != ''?$request->discount:0)){
                $status = '2';
                // echo $sumpay.' < '.$billingnote->billingnote_total;
                if($sumpay > $billingnote->billingnote_total){ //ถ้าจำนวนที่เคยจ่ายมาทั้งหมด มากกว่ายอดต้องจ่ายบิล ให้ยอดคงเหลือเป็น0
                    $amountbalance = 0;
                }else{
                    $amountbalance = $cal2-$sumpay;
                }
                
            // }else if($request->payamount == $request->pay){ //
            }else {
                $status = '1';
                $amountbalance = 0;
            }
            $update = [
                'billingnote_pay'        => $billingnote->billingnote_pay + $request->pay,
                'billingnote_balance'    => $amountbalance, 
                'billingnote_total'      => $cal2,
                'billingnote_status'     => $status,
                'updated_at'             => new DateTime(),
            ];
            // dd($update);
            DB::table('billingnote')->where('billingnote_id',$request->billingnoteid)->update($update);
        }
        // exit();
        savelog('8','แก้ไขข้อมูลใบเก็บเงินเลขที่บิล '.$billingnote->billingnote_inv);

        Session::flash('alert-insert','insert');
        return redirect('billingnote');
    }


    public function viewdata($id){
        $data = DB::table('billingnote')->leftjoin('billingnotedata','billingnote.billingnote_id','billingnotedata.billingnotedata_billingnoteid')->leftjoin('selling','billingnotedata.billingnotedata_exportid','selling.selling_id')->where('billingnote_id',$id)->get();
        $pay = DB::table('billingnotepay')->where('billingnotepay_billingnoteid',$id)->get();

        $file = DB::table('billingnoteimage')->where('billingnoteimage_billingnoteid',$id)->get();

        return view('billingnote.viewdata',['data' => $data,'datapay' => $pay,'datafile' => $file]);
    }

    public function pdf($id){
        $data = DB::table('billingnote')->leftJoin('billingnotedata','billingnote.billingnote_id','billingnotedata.billingnotedata_billingnoteid')->leftJoin('selling','billingnotedata.billingnotedata_exportid','selling.selling_id')->where('billingnote_id',$id)->get();
        $settingbill    = DB::table('setheadbill')->where('setheadbill_id',1)->first();
        if(!empty($data)){ 
            $customer = DB::table('customer')->where('customer_id',$data[0]->selling_customerid)->first();
            $pdf = PDF::loadView('billingnote/createpdf',['settingbill' => $settingbill,'data' => $data,'customer'=>$customer]);
            return $pdf->stream();
        }
    }

    public function printall(Request $request){
        $billingnote = DB::table('billingnote')->leftJoin('billingnotedata','billingnote_id','billingnotedata_billingnoteid')->leftJoin('selling','selling_id','billingnotedata_exportid');
        $noorder = $request->noorder;
        if($noorder != ''){
            $billingnote->where('billingnote_inv','like','%'.$noorder.'%');
        }
        $datestart = $request->datestart;
        $dateend = $request->dateend;
        $datestart_ = explode('/',$datestart);
        if(count($datestart_) > 2){
            $datestart = $datestart_[2].'-'.$datestart_[1].'-'.$datestart_[0];
        }
        $dateend_ = explode('/',$dateend);
        if(count($dateend_) > 2){
            $dateend = $dateend_[2].'-'.$dateend_[1].'-'.$dateend_[0];
        }
        
        if($datestart != '' && $dateend != ''){
            $billingnote->whereBetween('billingnote_date',[$datestart,$dateend]);
        }
        $staus = $request->staus;
        if($staus != ''){
            $billingnote->where('billingnote_status','like',$staus.'%');
        }
        $group = $billingnote->groupBy('selling_customerid')->get();
        $area = area::find($request->area);
        // dd($group);
        // $billingnote = $billingnote->get();
        $a = 0;
        $sheet = [];
        if(!empty($group)){
            foreach ($group as $key => $value) {
                $billingnotex = DB::table('billingnote')->leftJoin('billingnotedata','billingnote_id','billingnotedata_billingnoteid')->leftJoin('selling','selling_id','billingnotedata_exportid');
                if($noorder != ''){
                    $billingnotex->where('billingnote_inv','like','%'.$noorder.'%');
                }
                if($datestart != '' && $dateend != ''){
                    $billingnotex->whereBetween('billingnote_date',[$datestart,$dateend]);
                }
                if($staus != ''){
                    $billingnotex->where('billingnote_status','like',$staus.'%');
                }
                $databillingnote = $billingnotex->where('selling_customerid',$value->selling_customerid)->groupBy('billingnote_id')->get();
                $value->data = $databillingnote;
                $a++;
                if($a%23 == 0){
                    $sheet[] = $value->data;
                }
                if($key == count($group)-1){
                    $sheet[] = $value->data;
                }
            }
            // dd($sheet);
            // dd($group[0]->data[0]->billingnote_inv);
            // dd($group);
            $pdf = PDF::loadView('billingnote/createpdfbill',['data' => $group,'sheet'=>$sheet,'datestart'=>$request->datestart,'dateend'=>$request->dateend,'area'=>$area,'status'=>$staus],[],['orientation' => 'L', 'format' => 'A4-L']);
            return $pdf->stream();
        }
    }

    public function canceldataforbilling(Request $request){
        $billingnote = DB::table('billingnote')->leftjoin('billingnotedata','billingnote.billingnote_id','billingnotedata.billingnotedata_billingnoteid')->leftJoin('selling','selling.selling_id','billingnotedata.billingnotedata_exportid')->where('billingnote_id',$request->billingnoteid)->where('billingnotedata_exportid',$request->id)->first();
        $billingnotedata = DB::table('billingnotedata')->select(DB::raw('SUM(selling_totalpayment) as sum'))->leftjoin('selling','billingnotedata_exportid','selling_id')->where('billingnotedata_billingnoteid',$request->billingnoteid)->where('billingnotedata_exportid','!=',$request->id)->first();
        // dd($sum);
        $billingnote = billingnote::find($request->billingnoteid);
        $selling = selling::find($request->id);
        $billingnote->billingnote_balance = $billingnote->billingnote_balance-$selling->selling_totalpayment;
        $billingnote->billingnote_total = $billingnotedata->sum;
        $billingnote->save();
        
        $selling->selling_status = 1;
        $selling->save();
        DB::table('billingnotedata')->where('billingnotedata_billingnoteid',$request->billingnoteid)->where('billingnotedata_exportid',$request->id)->update(['billingnotedata_status'=>'0']);

        
        savelog('8','ยกเลิกข้อมูลขายเลขที่บิล '.$selling->selling_inv.' ในใบเก็บเงินเลขที่บิล '.$billingnote->billingnote_inv.'');

        // return Response::json($billingnotedata);
    }

    public function viewmodal(Request $request){
        $data = DB::table('billingnotedata')->leftjoin('selling','selling_id','billingnotedata_exportid')->where('billingnotedata_billingnoteid',$request->id)->get();
        return Response::json($data);
    }

    public function getdatapay(Request $request){
        $data = DB::table('billingnote')->select(DB::raw('sum(selling_totalall) as summoney'))->leftjoin('billingnotedata','billingnote.billingnote_id','billingnotedata.billingnotedata_billingnoteid')->leftjoin('selling','billingnotedata.billingnotedata_exportid','selling.selling_id')->where('billingnote_id',$request->billid)->where('selling_id',$request->id)->first();
        $txt = $request->id;
        $json = [
            'txt'=>$txt,
            'summoney'=>$data->summoney
        ];
        return Response::json($json);
    }

    public function getdatapays(Request $request){
        $data = DB::table('billingnote')->select(DB::raw('sum(selling.selling_totalall) as summoney'))->leftjoin('billingnotedata','billingnote.billingnote_id','billingnotedata.billingnotedata_billingnoteid')->leftjoin('selling','billingnotedata.billingnotedata_exportid','selling.selling_id')->where('billingnote_id',$request->billingnoteid);
        $txt = '';
        $wehrein = [];
        foreach ($request->check as $value) {
            // $data = $data->where('selling_id',$value);
            $txt .= $value.',';
            $wehrein[] = $value;
        }
        $txt = substr($txt,0,-1);
        $data = $data->whereIn('selling_id',$wehrein)->first();
        $billingnotedata = DB::table('billingnotedata')->select(DB::raw('sum(billingnotedata_pay) as summoney'))->where('billingnotedata_billingnoteid',$request->billingnoteid)->whereIn('billingnotedata_exportid',$wehrein)->first(); //ข้อเลือกเงินที่เคยจ่ายแล้ว แต่ยังสามารถเลือกกดชำระเงินได้อยู่
        $json = [
            'txt'=>$txt,
            'summoney'=>number_format($data->summoney-$billingnotedata->summoney,2)
        ];
        return Response::json($json);
    }

    public function uploadfileonly(Request $request){
        foreach($request->file('uploadfile') as $key => $files){
            $filename   = $files->getClientOriginalName();
            $extension  = $files->getClientOriginalExtension();
            $size       = $files->getSize();
            $file   = date('His').$filename;
            $destinationPath = base_path()."/assets/images/selling/";
            $files->move($destinationPath, $file);
            $data = array(
                'sellingfile_sellingref'=>  $request->sellingid,
                'sellingfile_billingref'=>  $request->billingnoteid,
                'sellingfile_name'      =>  $file,
                'sellingfile_date'      =>  date("Y-m-d"),
                'created_at'            =>  new DateTime,
                'updated_at'            =>  new DateTime
            );
           DB::table('sellingfile')->insert($data);
        }
        $selling = DB::table('selling')->where('selling_id',$request->sellingid)->first();
        $billingnote = DB::table('billingnote')->where('billingnote_id',$request->billingnoteid)->first();
        savelog('8','อัพโหลดไฟล์ข้อมูลขายเลขที่บิล '.$selling->selling_inv.' ในใบเก็บเงินเลขที่บิล '.$billingnote->billingnote_inv.'');
        return redirect()->back();
    }

    public function printbill($id){
        $billingnote = new billingnote;
        $data = $billingnote->leftjoin('billingnotedata','billingnote_id','billingnotedata_billingnoteid')->leftjoin('selling','billingnotedata_exportid','selling_id')->leftjoin('sub_tran','sub_order','selling_id')->leftjoin('transport','trans_id','sub_ref')->where('billingnotedata_billingnoteid',$id)->get();
        // dd($data);
        $pdf = PDF::loadView('billingnote/createpdfbilldetail',['data' => $data]);
            return $pdf->stream();
    }

    public function getdataimgcheck(Request $request){
        $customer = DB::table('billingnotedata')->leftjoin('selling','selling_id','billingnotedata_exportid')->leftjoin('customer','customer_id','selling_customerid')->where('billingnotedata_billingnoteid',$request->billingnoteid)->first();
        return Response::json($customer);
    }

    public function fileupload(Request $request){
        if($request->hasFile('uploadcover')){
            $files_ = $request->file('uploadcover');
            foreach ($files_ as $value) {
                $files = $value;
                $filename   = $files->getClientOriginalName();
                $extension  = $files->getClientOriginalExtension();
                $size       = $files->getSize();
                $imgcover1  = date('His').$filename;
                $destinationPath = base_path()."/assets/images/billingnote/upload/";
                $files->move($destinationPath, $imgcover1);
                // $datashop = [
                //     'imageshopcustomer_customerid'  => $request->input('updateid'),
                //     'imageshopcustomer_name'        => $imgcover1,
                //     'craete_at'                     => new DateTime(),
                //     'update_at'                     => new DateTime()
                // ];
                // DB::table('imageshop_customer')->insert($datashop);
            }
            return response()->json(['uploaded' => $imgcover1]);
        }else{
            return response()->json(['uploaded' => 'ERROR']);
        }
        
    }
    public function fileuploadcheck(Request $request){
        if($request->hasFile('imagecheck')){
            $files_ = $request->file('imagecheck');
            foreach ($files_ as $value) {
                $files = $value;
                $filename   = $files->getClientOriginalName();
                $extension  = $files->getClientOriginalExtension();
                $size       = $files->getSize();
                $imgcover1  = date('His').$filename;
                $destinationPath = base_path()."/assets/images/billingnote/upload/";
                $files->move($destinationPath, $imgcover1);
                // $datashop = [
                //     'imageshopcustomer_customerid'  => $request->input('updateid'),
                //     'imageshopcustomer_name'        => $imgcover1,
                //     'craete_at'                     => new DateTime(),
                //     'update_at'                     => new DateTime()
                // ];
                // DB::table('imageshop_customer')->insert($datashop);
            }
            return response()->json(['uploaded' => $imgcover1]);
        }else{
            return response()->json(['uploaded' => 'ERROR']);
        }
        
    }
}
