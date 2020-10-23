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
use App\Payimport;
use App\User;

class ImportsController extends Controller
{
    public function index(){
        $supplier = supplier::all();
        $startdate = date("Y-m-").'01';
        $lastdate = date("Y-m-t", strtotime('2020-'.date('m')));
		return view('imports/index',['supplier'=>$supplier,'startdate' => $startdate,'lastdate' => $lastdate]);
	}
    
    public function datatable(){
		$imports = imports::orderBy('imp_no','desc');
        $noorder = request('noorder');
        if($noorder != ''){
            $imports->where('imp_no','like',$noorder.'%');
        }

        $datestart = request('datestart');
        $dateend = request('dateend');

        if($datestart != '' && $dateend != ''){
            // $datestart = date('Y-m-d',strtotime(str_replace('/','-',$datestart)));
            // $dateend = date('Y-m-d',strtotime(str_replace('/','-',$dateend)));
            $imports->whereBetween('imp_date',[$datestart,$dateend]);
        }else if($datestart != ''){
            // $datestart = date('Y-m-d',strtotime(str_replace('/','-',$datestart)));
            $imports->whereDate('imp_date','>=',$datestart);
        }else if($dateend != ''){
            // $dateend = date('Y-m-d',strtotime(str_replace('/','-',$dateend)));
            $imports->whereDate('imp_date','<=',$dateend);
        }

        $supplier = request('supplier');
        if($supplier != ''){
            $imports->where('supplier_id','like',$supplier.'%');
        }

		$status = request('status');
        if($status != ''){
            $imports->where('impt_status','like',$status.'%');
        }
        $imports = $imports->get();
		$sQuery	= Datatables::of($imports)
		// ->editColumn('supplier_id',function($data){
		// 	if($data->supplierdata){
  //               return $data->supplierdata->supplier_name;
  //           }
  //           else{
  //               return '-';
  //           }
		// })
        ->editColumn('user_id',function($data){
			if($data->userdata){
                return $data->userdata->name;
            }
            else{
                return '-';
            }
		})
		->editColumn('updated_at',function($data){
			return date('d/m/Y',strtotime($data->updated_at));
		})
		->editColumn('imp_date',function($data){
			return date('d/m/Y',strtotime($data->imp_date));
		})
        ->addColumn('money',function($data){
            $money = subimports::where('imp_id',$data->imp_id)->select(DB::raw('SUM(amount*product_capital) as money'))->first();
            return number_format($money->money,2);
        })
        ->addColumn('supplier_name',function($data){
            if($data->supplierdata){
                return $data->supplierdata->supplier_name;
            }
            else{
                return '-';
            }
        });
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function viewcreate(){
		
        $lastdata = imports::orderBy('imp_id','desc')->first();
        $orderno = '';
        if(!empty($lastdata)){
            $cutno = explode('/',$lastdata->imp_no);
            $newnum = (int)$cutno['1'] + 1;
            $orderno = 'AP'.date('my').'/'.sprintf("%04d",$newnum);
        }
        else{
            $orderno = 'AP'.date('my').'/0001';
        }
        
		return view('imports/create')->with('orderno',$orderno);
	}
    
    public function createdata(Request $request){
        $ordno = '';
        if(strpos($request->input('impno'),'AP'.date('my')) == true){
            $lastdata = imports::orderBy('imp_id','desc')->first();
            if(!empty($lastdata)){
                $cutno = explode('/',$lastdata->imp_no);
                $newnum = (int)$cutno['1'] + 1;
                $ordno = 'AP'.date('my').'/'.sprintf("%04d",$newnum);
            }
            else{
                $ordno = 'AP'.date('my').'/0001';
            }
        }
        else{
            $ordno = $request->input('impno');
        }
        $save = new imports;
        $save->imp_no                   = $ordno;
        $save->supplier_id              = $request->input('supplier_id');
        $save->imp_date                 = date('Y-m-d',strtotime(str_replace('/','-',$request->input('docdate'))));
        $save->impt_note                = $request->input('note');
        $save->user_id                  = $request->input('empsaleid');
        // $save->save();
        // savelog('11','เพิ่มข้อมูลการนำเข้าเลขที่ออเดอร์ '.$ordno.' ซัพพลายเออร์ชื่อ '.$request->input('suppliername'));

        $lastid = imports::latest()->first();
        //แจ้งเตือนสินค้าเข้า
        $alertorder = DB::table('alertordernoproduct')->leftjoin('orders','order_id','alertordernoproduct_orderid')->leftjoin('export','order_ref','export_id')->where('alertordernoproduct_status','!=','1')->where('export_status','!=','3')->get();
        $arrayproductinorder  = []; //สินค้าที่ค้าออเดอร์แล้วขึ้นสถานะว่าไม่มีของ
        foreach ($alertorder as $dataalertorder) {
            $arrayproductinorder[$dataalertorder->order_productid][] = $dataalertorder;
        }
        // dd($arrayproductinorder);
        //
        $size = sizeof($request->input('proid'));
        if($size > 0){
            $row = 0;
            foreach($request->input('proid') AS $pro){
                $subsave = new subimports;
                $dataproduct = product::where('product_id',$pro)->first();
                
                $rateitembigunit = 1;
                $explodeunit = explode(',',$request->input('unit')[$row]);
                $unit = $explodeunit[1];
                $typeunit = $explodeunit[0];
                if($typeunit == '1'){
                    $processunit = processingunit::where('unit_productid',$pro)->where('unit_unitfirst',$unit)->first();
                }else{
                    $processunit = processingunit::where('unit_productid',$pro)->where('unit_unitsec',$unit)->first();
                    $rateitembigunit = ($processunit->unit_total != 0 ? $processunit->unit_total :1);
                }

                if($dataproduct->product_retailunit == 1){
                    $sale = ($request->input('capital')[$row] + $dataproduct->product_retailnumber) * $rateitembigunit;
                }else{
                    $sale = ($request->input('capital')[$row] + ($request->input('capital')[$row] * $dataproduct->product_retailnumber)/100 )* $rateitembigunit;
                }
                if($dataproduct->product_wholesaleunit == 1){
                    $wholesale1 = ($request->input('capital')[$row] + $dataproduct->product_wholesalenumber) * $rateitembigunit;
                }else{
                    $wholesale1 = ($request->input('capital')[$row] + ($request->input('capital')[$row] * $dataproduct->product_wholesalenumber)/100) * $rateitembigunit;
                }
                if($dataproduct->product_wholesale2unit == 1){
                    $wholesale2 = ($request->input('capital')[$row] + $dataproduct->product_wholesale2number) * $rateitembigunit;
                }else{
                    $wholesale2 = ($request->input('capital')[$row] + ($request->input('capital')[$row] * $dataproduct->product_wholesale2number)/100) * $rateitembigunit;
                }
                if($dataproduct->product_wholesale3unit == 1){
                    $wholesale3 = ($request->input('capital')[$row] + $dataproduct->product_wholesale3number) * $rateitembigunit;
                }else{
                    $wholesale3 = ($request->input('capital')[$row] + ($request->input('capital')[$row] * $dataproduct->product_wholesale3number)/100 )*$rateitembigunit;
                }
                
                $subsave->imp_id                    = $lastid->imp_id;
                $subsave->product_id                = $pro;
                $subsave->amount                    = $request->input('amount')[$row];
                $subsave->product_capital           = $request->input('capital')[$row];
                $subsave->product_sale              = $sale;
                $subsave->typyunit                  = $typeunit;
                $subsave->unit_id                   = $unit;
                // $subsave->product_size              = $request->input('size')[$row];
                $subsave->save();

                savelog('11','เพิ่มสินค้านำเข้าเลขที่ออเดอร์ '.$ordno.' ซัพพลายเออร์ชื่อ '.$request->input('suppliername').' รหัสสินค้า '.$dataproduct->product_code.' ชื่อสินค้า '.$dataproduct->product_name .' จำนวน '.$request->input('amount')[$row].' ราคา '.$request->input('capital')[$row]);

                $stock = stock::where('product_id',$pro)->where('product_sale',$request->input('sale')[$row])->where('product_capital',$request->input('capital')[$row])->where('product_size',$request->input('size')[$row])->first();
                if($typeunit == '1'){
                    $processunit = processingunit::where('unit_productid',$pro)->where('unit_unitfirst',$unit)->first();
                }else{
                    $processunit = processingunit::where('unit_productid',$pro)->where('unit_unitsec',$unit)->first();
                }
                if($typeunit == '1'){
                    if(!empty($processunit)){
                        $unit_total = $processunit->unit_total;
                    }else{
                        $unit_total = 1;
                    }
                }else{
                    $unit_total = 1;
                }
                if(!empty($stock)){
                    $savestock = stock::where('product_id',$pro)->where('product_sale',$request->input('sale')[$row])->update([
                        'product_qty'       => (($request->input('amount')[$row] * $unit_total) + $stock->product_qty),
                    ]);
                }
                else{
                    $savestock = new stock;
                    $savestock->product_id          = $pro;
                    $savestock->product_sale        = $sale;
                    $savestock->product_qty         = ($request->input('amount')[$row] * $unit_total);
                    $savestock->product_capital     = $request->input('capital')[$row];
                    // $savestock->product_size        = $request->input('size')[$row];
                    // dd($savestock);
                    $savestock->save();
                }
                $allstock = stock::where('product_id',$pro)->sum('product_qty');
                if($request->input('capital')[$row] > 0){ //แก้ถ้าราคาเป็น0ไม่ต้องอัพเดทราคาขาย
                    $savepro = product::where('product_id',$pro)->update([
                        'product_buy'            => $request->input('capital')[$row],
                        // 'product_qty'            => $allstock,
                        'product_qty'            => $dataproduct->product_qty + ($request->input('amount')[$row]*$unit_total),
                        'product_retail'         => $sale,
                        'product_wholesale'      => $wholesale1,
                        'product_wholesale2'     => $wholesale2,
                        'product_wholesale3'     => $wholesale3,
                    ]);
                }
                //แจ้งเตือนสินค้าเข้า
                $qtyamount = ($request->input('amount')[$row] * $unit_total);
                if(array_key_exists($pro,$arrayproductinorder)){
                    foreach ($arrayproductinorder[$pro] as $key => $datainorfers) {
                        $calqty = $qtyamount - ($datainorfers->alertordernoproduct_balance * $unit_total);
                        if($calqty >= 0){
                            
                            $savealertdata = [
                                'alertordernoproduct_balance'  =>  0,
                                'alertordernoproduct_qty'  =>  $qtyamount,
                                'alertordernoproduct_status'  =>  '1',
                            ];
                            DB::table('alertordernoproduct')->where('alertordernoproduct_id',$datainorfers->alertordernoproduct_id)->update($savealertdata);
                            unset($arrayproductinorder[$pro][$key]);
                            savelog('11','อัพเดทข้อมูลการแจ้งเตือนมีสินค้าครบตามออเดอร์แล้ว ของเลขที่การแจ้งเตือน '.$datainorfers->alertordernoproduct_id);
                        }else{
                            // echo $datainorfers->alertordernoproduct_balance.'<br>';
                            $datainorfers->alertordernoproduct_balance = ($datainorfers->alertordernoproduct_balance * $unit_total)-$qtyamount;
                            $savealertdata = [
                                'alertordernoproduct_balance'  =>  $datainorfers->alertordernoproduct_balance,
                                'alertordernoproduct_qty'  =>  $qtyamount,

                            ];
                            // echo $qtyamount;
                            // dd($savealertdata);
                            DB::table('alertordernoproduct')->where('alertordernoproduct_id',$datainorfers->alertordernoproduct_id)->update($savealertdata);
                            savelog('11','อัพเดทข้อมูลการแจ้งเตือนมีสินค้าเข้า ของเลขที่การแจ้งเตือน '.$datainorfers->alertordernoproduct_id);
                        }
                        
                        $qtyamount = $qtyamount - ($datainorfers->order_qty * $unit_total);
                        // 
                    }
                }
                //
                $row++;
            }
        }
        
        Session::flash('alert-insert','insert');
		return redirect('imports');
    }
	
    public function editdata($id){
        dd($id);
    }
	
    public function checkprice($id){
        $subimports = subimports::where('product_id',$id)->orderBy('created_at', 'desc')->first();
        if(!empty($subimports)){
            $data = $subimports;
        }else{
            $product = product::where('product_id',$id)->first();
            if(!empty($product)){
                $data = $product;
            }else{
                $data = 'X';
            }
        }
        return  response()->json($data);
    }

    public function getpay(Request $request){
        $money = 0;
        if(!empty($request->id)){
            foreach ($request->id as $key => $value) {
                $data = subimports::select(DB::raw('SUM(amount*product_capital) as cal'))->where('imp_id',$request->id[$key])->first();
                $money += $data->cal;
            }
        }
        return  response()->json($money);
    }

    public function checkdatapay(Request $request){
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $money = 0;
        $txt = '';
        $status = 'X';
        $checkarray = [];
        $data = imports::leftjoin('sub_import_product','import_product.imp_id','sub_import_product.imp_id')->select(DB::raw('*,(amount*product_capital) as cal,import_product.imp_id as importid'))->where('supplier_id',$request->supplier)->whereBetween('imp_date',[$startdate,$enddate])->where('impt_status','=','0')->get();
        
        if(!empty($data)){
            foreach($data as $key => $value){
                $money += $value->cal;
                if($txt == ''){
                    $txt = $value->importid.',';
                    $checkarray[] = $value->importid;
                }else{
                    if(!in_array($value->importid, $checkarray )){
                        $txt .= $value->importid.',';
                        $checkarray[] = $value->importid;
                    }
                }
                $status = 'Y';
            }
            
        }
        $txt = substr($txt,0,-1);
        $json = [
            'money' => $money,
            'txt'   => $txt,
            'arraytxt'  => $checkarray,
            'status'    => $status,
            'data' => $data
        ];
        return  response()->json($json);
    }

    public function payforimport(Request $request){
        $explode = explode(',',$request->saveimportid);
        // dd($request);
        $checkid = "";
        foreach($explode as $key => $value){
            $getdata = imports::find($value);
            $getdata->impt_status = '1';
            $getdata->type_pay = $request->type;
            $getdata->save();
            // dd($getdata);
        }
        $file   = '';
        if($request->hasFile('uploadfile')){
            $files = $request->file('uploadfile');
            $filename   = $files->getClientOriginalName();
            $extension  = $files->getClientOriginalExtension();
            $size       = $files->getSize();
            $file       = date('His').$filename;
            $destinationPath = base_path()."/assets/import/pay/";
            $files->move($destinationPath, $file);
        }

        $payimport = new Payimport;
        $payimport->payimport_type = $request->type;
        $payimport->payimport_refid = $request->saveimportid;
        $payimport->payimport_date = $request->date;
        $payimport->payimport_pay = $request->paymoney;
        $payimport->payimport_account = !empty($request->account)?$request->account:'';
        $payimport->payimport_bank = !empty($request->bank)?$request->bank:'';
        $payimport->payimport_file = $file;
        $payimport->save();
        $txt = '';
        if($payimport->account != ''){
            $txt .= ' เลขบัญชี '.$payimport->account;
        }
        if($payimport->bank != ''){
            $txt .= ' ธนาคาร '.$payimport->bank;
        }
        // dd();
        savelog('11','ชำระเงินสินค้านำเข้า จำนวนเงิน '.$request->paymoney.$txt);
        return redirect('imports');
    }

    public function destroy($id){
        $imports = imports::find($id);
        $imports->impt_status = 2;
        $supplier = supplier::find($imports->supplier_id);
        $subimports = subimports::where('imp_id',$id)->get();
        foreach ($subimports as $value) { //คืนของออกจาก
            if($value->typyunit == '1'){
                $processunit = processingunit::where('unit_productid',$value->product_id)->where('unit_unitfirst',$value->unit_id)->first();
                $qtyitem = $value->amount*($processunit->unit_total != 0?$processunit->unit_total:1);
            }else{
                $processunit = processingunit::where('unit_productid',$value->product_id)->where('unit_unitsec',$value->unit_id)->first();
                $qtyitem = $value->amount;
            }
            $stock = stock::where('product_id',$value->product_id)->where('product_qty','!=','0')->get();
            $qtyitems = $qtyitem;
            foreach ($stock as $datastock) {
                if($datastock->product_qty-$qtyitems >= 0){
                    $savestock = stock::where('stock_id',$datastock->stock_id)->update([
                        'product_qty'       =>  $datastock->product_qty-$qtyitems,
                    ]);
                    break;
                }else{
                    $qtyitems = $qtyitems-$datastock->product_qty;
                    echo $qtyitems.'<br>';
                    $savestock = stock::where('stock_id',$datastock->stock_id)->update([
                        'product_qty'       =>  0,
                    ]);

                }
            }

            $savepro = product::find($value->product_id);
            // dd();
            savelog('11','ยกเลิกข้อมูลนำเข้าเลขที่บิล '.$imports->imp_no.' ชื่อพนักงาน '.$supplier->supplier_name.'และคืนสินค้ารหัส'.$savepro->product_code.' ชื่อสินค้า '.$savepro->product_name.' จากจำนวน '.$savepro->product_qty.' เหลือ '.($savepro->product_qty-$qtyitem<0?0:$savepro->product_qty-$qtyitem));

            $savepro->product_qty = ($savepro->product_qty-$qtyitem<0?0:$savepro->product_qty-$qtyitem);
            $savepro->save();
                
            
        }
        
        // $imports->delete();
        
        $imports->save();
        savelog('11','ยกเลิกข้อมูลนำเข้าเลขที่บิล '.$imports->imp_no.' ชื่อพนักงาน '.$supplier->supplier_name);
        Session::flash('alert-delete','Cancel');
        return redirect('imports');
    }

    public function edit($id){
        $imports = imports::find($id);
        $subimports = subimports::leftjoin('product','product.product_id','sub_import_product.product_id')->leftjoin('unit','product.product_unit','unit.unit_id')->where('imp_id',$id)->select(DB::raw('*, sub_import_product.unit_id as importunit'))->get();
        $supplier = supplier::find($imports->supplier_id);
        $imports['username'] = imports::find($id)->userdata->name;
        foreach ($subimports as $key => $value) {
            $value['unit'] = DB::table('processingunit')->leftjoin('unit','processingunit.unit_unitfirst','unit.unit_id')->leftjoin('unitsub','processingunit.unit_unitsec','unitsub.unitsub_id')->where('processingunit.unit_productid',$value->product_id)->get();

            // $unit = processingunit::where('unit_productid',$value->product_id)->get();
            // $opunit='<select class="form-control" name="unit[]" required>';
            // // $opunit.='<option value="">-- เลือกหน่วยนับ --</option>';
            // if(count($unit) > 0){
            //     foreach($unit AS $valun){
            //         $bigunit = DB::table('unit')->where('unit_id',$valun->unit_unitfirst)->first();
            //         $smallunit = DB::table('unitsub')->where('unitsub_id',$valun->unit_unitsec)->first();
            //         if($valun->unit_unitfirst){
            //             $opunit.='<option value="1,'.$bigunit->unit_id.'">'.$bigunit->unit_name.'</option>';
            //         }
            //         if($valun->unit_unitsec){
            //             $opunit.='<option value="2,'.$smallunit->unitsub_id.'">'.$smallunit->unitsub_name.'</option>';
            //         }
            //     }
            // }else{
            //     $unit = unit::find($product->product_unit);
            //     $opunit.='<option value="1,'.$unit->unit_id.'">'.$unit->unit_name.'</option>';
            // }
            // $opunit.='</select>';
            // $value['units'] = $opunit;
        }
        
        // dd($subimports);
        
        return view('imports/update',['imports' => $imports,'subimports' => $subimports,'supplier'=>$supplier]);
    }
    
    public function update(Request $request){
        $imports = imports::find($request->impid);
        // savelog('11','แก้ไขข้อมูลการนำเข้าเลขที่ออเดอร์ '.$request->input('impno').' ซัพพลายเออร์ชื่อ '.$request->input('suppliername'));
        $countoldqty = 0;
        foreach ($request->proid as $key => $item) {
            $dataproduct = product::where('product_id',$request->proid[$key])->first();
            // dd($dataproduct);
            $rateitembigunit = 1;
            $explodeunit = explode(',',$request->input('unit')[$key]);
            $unit = $explodeunit[1];
            $typeunit = $explodeunit[0];
            if($typeunit == '1'){
                $processunit = processingunit::where('unit_productid',$request->input('proid')[$key])->where('unit_unitfirst',$unit)->first();
            }else{
                $processunit = processingunit::where('unit_productid',$request->input('proid')[$key])->where('unit_unitsec',$unit)->first();
                $rateitembigunit = ($processunit->unit_total != 0 ? $processunit->unit_total :1);
            }


            if($dataproduct->product_retailunit == 1){
                $sale = ($request->input('capital')[$key] + $dataproduct->product_retailnumber) * $rateitembigunit;
            }else{
                $sale = ($request->input('capital')[$key] + ($request->input('capital')[$key] * $dataproduct->product_retailnumber)/100 )* $rateitembigunit;
            }
            if($dataproduct->product_wholesaleunit == 1){
                $wholesale1 = ($request->input('capital')[$key] + $dataproduct->product_wholesalenumber) * $rateitembigunit;
            }else{
                $wholesale1 = ($request->input('capital')[$key] + ($request->input('capital')[$key] * $dataproduct->product_wholesalenumber)/100) * $rateitembigunit;
            }
            if($dataproduct->product_wholesale2unit == 1){
                $wholesale2 = ($request->input('capital')[$key] + $dataproduct->product_wholesale2number) * $rateitembigunit;
            }else{
                $wholesale2 = ($request->input('capital')[$key] + ($request->input('capital')[$key] * $dataproduct->product_wholesale2number)/100) * $rateitembigunit;
            }
            if($dataproduct->product_wholesale3unit == 1){
                $wholesale3 = ($request->input('capital')[$key] + $dataproduct->product_wholesale3number) * $rateitembigunit;
            }else{
                $wholesale3 = ($request->input('capital')[$key] + ($request->input('capital')[$key] * $dataproduct->product_wholesale3number)/100 )*$rateitembigunit;
            }


            // if($dataproduct->product_retailunit == 1){
            //     $sale = $request->input('capital')[$key] + $dataproduct->product_retailnumber;
            // }else{
            //     $sale = $request->input('capital')[$key] + ($request->input('capital')[$key] * $dataproduct->product_retailnumber)/100;
            // }
            // if($dataproduct->product_wholesaleunit == 1){
            //     $wholesale1 = $request->input('capital')[$key] + $dataproduct->product_wholesalenumber;
            // }else{
            //     $wholesale1 = $request->input('capital')[$key] + ($request->input('capital')[$key] * $dataproduct->product_wholesalenumber)/100;
            // }
            // if($dataproduct->product_wholesale2unit == 1){
            //     $wholesale2 = $request->input('capital')[$key] + $dataproduct->product_wholesale2number;
            // }else{
            //     $wholesale2 = $request->input('capital')[$key] + ($request->input('capital')[$key] * $dataproduct->product_wholesale2number)/100;
            // }
            // if($dataproduct->product_wholesale3unit == 1){
            //     $wholesale3 = $request->input('capital')[$key] + $dataproduct->product_wholesale3number;
            // }else{
            //     $wholesale3 = $request->input('capital')[$key] + ($request->input('capital')[$key] * $dataproduct->product_wholesale3number)/100;
            // }

            if($request->importdataid[$key] != ''){
                $subsave = subimports::find($request->importdataid[$key]);
                // dd($subsave);
                // echo $subsave->amount;
                if($subsave->typyunit == 1){
                    $processunit = processingunit::where('unit_productid',$request->proid[$key])->where('unit_unitfirst',$subsave->unit_id)->first();
                    $unit_total = 1;
                    if(!empty($processunit)){
                        $unit_total = $processunit->unit_total;
                    }
                    $qtyold = $subsave->amount*$unit_total;
                    $qtynew = $request->input('amount')[$key]*$unit_total;
                }else{
                    $qtyold = $subsave->amount;
                    $qtynew = $request->input('amount')[$key];
                }
                // dd($qtyold);
                $calqty = $request->oldqty[$countoldqty] - $request->amount[$key];
                // $stock = stock::where('product_id',$request->proid[$key])->where('product_sale',$request->input('sale')[$key])->where('product_capital',$request->input('capital')[$key])->first();
                // dd($stock);
                // $processunit = processingunit::where('unit_productid',$request->proid[$key])->where('unit_unitfirst',$request->input('unit')[$key])->first();


                // if(!empty($stock)){
                    // $savestock = stock::where('product_id',$request->input('proid')[$row])->where('product_sale',$request->input('sale')[$key])->update([
                    //     'product_qty'       => (($request->input('amount')[$key] * $processunit->unit_total) + $stock->product_qty),
                    // ]);
                // }
                // else{
                    
                // }
                $addstock = 0;
                if($calqty == 0){ //เท่าเดิม
                    
                }else if($calqty > 0){ //จำนวนน้อยกว่าเก่า ต้องเอาข้อมูลออกจากสต้อกด้วย
                    $addstock = ($calqty*-1);
                }else if($calqty < 0){ //จำนวนมากกว่าเก่า
                    $addstock = ($calqty*-1);
                    $savestock = new stock;
                    $savestock->product_id          = $request->proid[$key];
                    $savestock->product_sale        = $sale;
                    $savestock->product_qty         = (($calqty*-1) * $processunit->unit_total);
                    $savestock->product_capital     = $request->input('capital')[$key];
                    
                    $savestock->save();
                }
                // dd($subsave);
                // $subsave->imp_id                    = $request->importdataid[$key];
                $subamount = $subsave->amount;
                $subcapital  = $subsave->product_capital;
                $subsave->product_id                = $request->proid[$key];
                $subsave->amount                    = $subsave->amount + $addstock;
                $subsave->product_capital           = $request->input('capital')[$key];
                $subsave->product_sale              = $sale;
                $subsave->typyunit                  = $typeunit;
                $subsave->unit_id                   = $unit;
                // dd($subsave);
                $subsave->save();

                $savepro = product::find($request->proid[$key]);
                // dd($savepro);
                // dd($request->proid[$key]);
                $savepro->product_buy = $request->input('capital')[$key];
                $savepro->product_qty = ($dataproduct->product_qty -$qtyold) + $qtynew;
                $savepro->product_retail = $sale;
                $savepro->product_wholesale = $wholesale1;
                $savepro->product_wholesale2 = $wholesale2;
                $savepro->product_wholesale3 = $wholesale3;
                $savepro->save();
                savelog('11','แก้ไขข้อมูลการนำเข้าเลขที่ออเดอร์ '.$request->input('impno').' ซัพพลายเออร์ชื่อ '.$request->input('suppliername').' รหัสสินค้า '.$dataproduct->product_code.' ชื่อสินค้า '.$dataproduct->product_name .' จำนวนจาก '.$subamount.' เป็น '.$subsave->amount.' จากราคา '.$subcapital.' เป็นราคา '.$request->input('capital')[$key]);
                // dd($savepro);
                $countoldqty++;
            }else{

                $subsave = new subimports;
                // dd($subsave);
                
                $subsave->imp_id                    = $request->impid;
                $subsave->product_id                = $request->proid[$key];
                $subsave->amount                    = $request->input('amount')[$row];
                $subsave->product_capital           = $request->input('capital')[$row];
                $subsave->product_sale              = $sale;
                $subsave->typyunit                  = $typeunit;
                $subsave->unit_id                   = $unit;
                // $subsave->product_size              = $request->input('size')[$row];
                $subsave->save();

                $stock = stock::where('product_id',$request->proid[$key])->where('product_sale',$request->input('sale')[$key])->where('product_capital',$request->input('capital')[$key])->where('product_size',$request->input('size')[$key])->first();
                $processunit = processingunit::where('unit_productid',$request->proid[$key])->where('unit_unitfirst',$request->input('unit')[$key])->first();

                if(!empty($stock)){
                    $savestock = stock::where('product_id',$request->proid[$key])->where('product_sale',$request->input('sale')[$key])->update([
                        'product_qty'       => (($request->input('amount')[$key] * $processunit->unit_total) + $stock->product_qty),
                    ]);
                }
                else{
                    $savestock = new stock;
                    $savestock->product_id          = $request->proid[$key];
                    $savestock->product_sale        = $sale;
                    $savestock->product_qty         = ($request->input('amount')[$key] * $processunit->unit_total);
                    $savestock->product_capital     = $request->input('capital')[$key];
                    // $savestock->product_size        = $request->input('size')[$row];
                    $savestock->save();
                }
                $allstock = stock::where('product_id',$request->proid[$key])->sum('product_qty');
                $savepro = product::where('product_id',$request->proid[$key])->update([
                    'product_buy'            => $request->input('capital')[$key],
                    // 'product_qty'            => $allstock,
                    'product_qty'            => $dataproduct->product_qty + $request->input('amount')[$key],
                    'product_retail'         => $sale,
                    'product_wholesale'      => $wholesale1,
                    'product_wholesale2'     => $wholesale2,
                    'product_wholesale3'     => $wholesale3,
                ]);
                savelog('11','แก้ไขเพิ่มสินค้านำเข้าเลขที่ออเดอร์ '.$request->input('impno').' ซัพพลายเออร์ชื่อ '.$request->input('suppliername').' รหัสสินค้า '.$dataproduct->product_code.' ชื่อสินค้า '.$dataproduct->product_name .' จำนวน '.$request->input('amount')[$key].' ราคา '.$request->input('capital')[$key]);
            }
        }
        
        Session::flash('alert-update','update');
        return redirect('imports');
    }

    public function cancelpay($id){
        $payimport = Payimport::where('payimport_refid','LIKE','%'.$id.'%')->get();
        foreach($payimport as $item){
            $ref = $item->payimport_refid;
            $explode = explode(',',$ref);

            foreach($explode as $value){
                // dd($value);
                $imports = imports::find($value);
                // dd($imports);
                $imports->type_pay = '';
                $imports->impt_note = '';
                $imports->impt_status = '';
                $imports->save();
                savelog('11','ยกเลิกการชำระการนำเข้าเลขที่บิล '.$value);
            }
            $pay = Payimport::find($item->payimport_id);
            $pay->delete();
        }
        Session::flash('alert-update','update');
        return redirect('imports');
    }
}
