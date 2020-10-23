<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use DB;
use DateTime;
use Session;
use Response;
use Datatables;
use File;
use Folklore\Image\Facades\Image;
use PDF;
use Excel;

class ReportsupplierController extends Controller
{
    public function index(){

        $data = DB::table('supplier')->get();
        $category   = DB::table('category')->get();
		return view('report/reportsupplier',['data'=>$data,'category' => $category]);
	}

    public function datatable(){
        $customer = DB::table('customer');
        // if(Auth::user()->position != 1){
        //     $customer->where('customer_group',Auth::user()->groupsell);
        // }
        $customername = request('customername');
        if(!empty($customername)){
            $customer->where('customer_name',$customername);
        }
        $province = request('province');
        if(!empty($province)){
            $customer->where('customer_address5',$province);
        }
        $amphure = request('amphure');
        if(!empty($amphure)){
            $customer->where('customer_address4',$amphure);
        }
        $district = request('district');
        if(!empty($district)){
            $customer->where('customer_address3',$district);
        }
        $zidcode = request('zidcode');
        if(!empty($zidcode)){
            $customer->where('customer_address6',$zidcode);
        }
        $customergroup = request('customergroup');
        if(!empty($customergroup)){
            $customer->where('customer_group',$customergroup);
        }

        $customer = $customer->get();
        $sQuery = Datatables::of($customer);
        return $sQuery->escapeColumns([])->make(true);
    }

    public function report(Request $request){
        $cutstart = explode('/',$request->input('datestart'));
        $datestart = $cutstart[2].'-'.$cutstart[1].'-'.$cutstart[0];
        
        $cutend = explode('/',$request->input('dateend'));
        $dateend = $cutend[2].'-'.$cutend[1].'-'.$cutend[0];
        
        $data = [
            "import"        => imports::whereBetween('imp_date',[$datestart,$dateend])->get(),
            "datestart"     => $request->input('datestart'),
            "dateend"       => $request->input('dateend'),
            "setting"       => DB::table('setting')->orderBy('set_id','desc')->first()
        ];
        
        $pdf = PDF::loadView('report.reportimport',$data,[],['title' => 'ประวัติการนำเข้าสินค้า','format'=>'A4']);
	    return $pdf->stream();
    }

    public function search(Request $request){
        $supplier = DB::table('supplier');
        // if(Auth::user()->position != 1){
        //     $customer->where('customer_group',Auth::user()->groupsell);
        // }
        $name = request('name');
        $nameto = request('nameto');
        
        if($name != '' && $nameto != ''){
            $supplier->whereBetween('supplier_id',[$name,$nameto]);  //เปลี่ยนเป็นselect2เลยให้ค้นจากidแทน
        }else{
            if(!empty($name)){
                $supplier->where('supplier_id',$name);
            }
            
            if(!empty($nameto)){
                $supplier->where('supplier_id',$nameto);
            }
        }
        
        $supplier = $supplier->get();
        // dd($customer);
        $moneynotpay = request('moneynotpay');
        $data = [];
        $start = request('datestart');
        $end = request('dateend');

        $category = request('category');
        $wherein = [];
        if(!empty($category)){
            foreach ($category as $value) {
                $wherein[]=$value;
            }
        }

        $arrayhead = ['ลำดับที่','ชื่อผู้ผลิต'];
        $datasup = [];
        if(!empty($request->latlong)){
            $arrayhead[] = $request->latlong;
        }
        if(!empty($request->tel)){
            $arrayhead[] = $request->tel;
        }
        if(!empty($request->email)){
            $arrayhead[] = $request->email;
        }
        if(!empty($request->tax)){
            $arrayhead[] = $request->tax;
        }
        if(!empty($request->notpay)){
            $arrayhead[] = $request->notpay;
        }
        if(!empty($request->total)){
            $arrayhead[] = $request->total;
        }

        $typepay = $request->typepay;
        // dd($arrayhead);
        foreach ($supplier as $key => $value) {


            $datatotal = DB::table('import_product')->leftjoin('sub_import_product','import_product.imp_id','sub_import_product.imp_id')->leftjoin('product','product.product_id','sub_import_product.product_id')->select(DB::raw('IFNULL(SUM(amount*product_capital),0) as totalpayment'))->where('supplier_id',$value->supplier_id)->whereBetween('imp_date',[$start,$end]);
            if($category != ''){
                $datatotal = $datatotal->whereIn('product_category',$wherein);
            }
            $datatotal = $datatotal->first();

            $datanopay = DB::table('import_product')->leftjoin('sub_import_product','import_product.imp_id','sub_import_product.imp_id')->leftjoin('product','product.product_id','sub_import_product.product_id')->select(DB::raw('IFNULL(SUM(amount*product_capital),0) as totalpayment'))->where('supplier_id',$value->supplier_id)->where('impt_status',0)->whereBetween('imp_date',[$start,$end]);  //จัดบิลเก็บแล้วยังไม่จ่าย
            if($category != ''){
                $datanopay = $datanopay->whereIn('product_category',$wherein);
            }
            $datanopay = $datanopay->first();
            // $datapay = DB::table('customer')->leftjoin('selling','selling_customerid','customer_id')->select(DB::raw('IFNULL(SUM(selling_totalpayment),0) as totalpayment'))->where('customer_id',$value->customer_id)->where('selling_status',8)->whereBetween('selling_date',[$start,$end])->first();  //จัดบิลเก็บแล้วยังจ่าย
            if($typepay != ''){
                $datatypepay = DB::table('import_product')->leftjoin('sub_import_product','import_product.imp_id','sub_import_product.imp_id')->leftjoin('product','product.product_id','sub_import_product.product_id')->select(DB::raw('IFNULL(SUM(amount*product_capital),0) as totalpayment'))->where('type_pay',$typepay)->whereBetween('imp_date',[$start,$end]);
                if($category != ''){
                    $datatypepay = $datatypepay->whereIn('product_category',$wherein);
                }
                $datatypepay = $datatypepay->count();
                if($datatypepay == 0){
                    continue;
                }
            }


            $datas = [];
            $datas[] = $key+1;
            $datas[] = $value->supplier_name;

            if(!empty($request->latlong)){
                $datas[] = $value->lat.','.$value->lng;
            }
            if(!empty($request->tel)){
                $datas[] = $value->supplier_tel;
            }
            if(!empty($request->email)){
                $datas[] = $value->supplier_email;
            }
            if(!empty($request->tax)){
                $datas[] = $value->supplier_tax;
            }
            if(!empty($request->notpay)){
                $datas[] = number_format($datanopay->totalpayment,2);
            }
            if(!empty($request->total)){
                $datas[] = number_format($datatotal->totalpayment,2);
            }
            
            if(!empty($moneynotpay)){
                $txt = '';
                if($request->typenotpay == '1'){
                    $txt = $datanopay->totalpayment > $moneynotpay;
                }else if($request->typenotpay == '2'){
                    $txt = $datanopay->totalpayment == $moneynotpay;
                }else if($request->typenotpay == '3'){
                    $txt = $datanopay->totalpayment < $moneynotpay;
                }
                if($txt){
                    $datasup[] = $datas;
                }
            }else{
                $datasup[] = $datas;
            }

        }
        // $customer = $data;
        $responsedata = [];
        $responsedata['head'] = $arrayhead;
        $responsedata['data'] = $datasup;
        return Response::json($responsedata);

        $supplier = $supplier->get();
        return view('report/reportsupplier',['data'=>$supplier]);
    }

    public function reportexcel(Request $request){
        $supplier = DB::table('supplier');
        $name = request('name');
        $nameto = request('nameto');
        
        if($name != '' && $nameto != ''){
            $supplier->whereBetween('supplier_id',[$name,$nameto]);  //เปลี่ยนเป็นselect2เลยให้ค้นจากidแทน
        }else{
            if(!empty($name)){
                $supplier->where('supplier_id',$name);
            }
            
            if(!empty($nameto)){
                $supplier->where('supplier_id',$nameto);
            }
        }
        
        $supplier = $supplier->get();
        // dd($customer);
        $moneynotpay = request('moneynotpay');
        $data = [];
        $start = request('datestart');
        $end = request('dateend');
        $category = request('category');
        $wherein = [];
        if(!empty($category)){
            foreach ($category as $value) {
                $wherein[]=$value;
            }
        }

        $arrayhead = ['ลำดับที่','ชื่อผู้ผลิต'];
        $datasup = [];
        if(!empty($request->latlong)){
            $arrayhead[] = $request->latlong;
        }
        if(!empty($request->tel)){
            $arrayhead[] = $request->tel;
        }
        if(!empty($request->email)){
            $arrayhead[] = $request->email;
        }
        if(!empty($request->tax)){
            $arrayhead[] = $request->tax;
        }
        if(!empty($request->notpay)){
            $arrayhead[] = $request->notpay;
        }
        if(!empty($request->total)){
            $arrayhead[] = $request->total;
        }

        $typepay = $request->typepay;

        foreach ($supplier as $key => $value) {


            $datatotal = DB::table('import_product')->leftjoin('sub_import_product','import_product.imp_id','sub_import_product.imp_id')->leftjoin('product','product.product_id','sub_import_product.product_id')->select(DB::raw('IFNULL(SUM(amount*product_capital),0) as totalpayment'))->where('supplier_id',$value->supplier_id)->whereBetween('imp_date',[$start,$end]);
            if($category != ''){
                $datatotal = $datatotal->whereIn('product_category',$wherein);
            }
            $datatotal = $datatotal->first();
            $datanopay = DB::table('import_product')->leftjoin('sub_import_product','import_product.imp_id','sub_import_product.imp_id')->leftjoin('product','product.product_id','sub_import_product.product_id')->select(DB::raw('IFNULL(SUM(amount*product_capital),0) as totalpayment'))->where('supplier_id',$value->supplier_id)->where('impt_status',0)->whereBetween('imp_date',[$start,$end]);
            if($category != ''){
                $datanopay = $datanopay->whereIn('product_category',$wherein);
            }
            $datanopay = $datanopay->first();
            // $datapay = DB::table('customer')->leftjoin('selling','selling_customerid','customer_id')->select(DB::raw('IFNULL(SUM(selling_totalpayment),0) as totalpayment'))->where('customer_id',$value->customer_id)->where('selling_status',8)->whereBetween('selling_date',[$start,$end])->first();  //จัดบิลเก็บแล้วยังจ่าย
            if($typepay != ''){
                $datatypepay = DB::table('import_product')->leftjoin('sub_import_product','import_product.imp_id','sub_import_product.imp_id')->leftjoin('product','product.product_id','sub_import_product.product_id')->select(DB::raw('IFNULL(SUM(amount*product_capital),0) as totalpayment'))->where('type_pay',$typepay)->whereBetween('imp_date',[$start,$end]);
                if($category != ''){
                    $datatypepay = $datatypepay->whereIn('product_category',$wherein);
                }
                $datatypepay = $datatypepay->count();
                if($datatypepay == 0){
                    continue;
                }
            }


            $datas = [];
            $datas[] = $key+1;
            $datas[] = $value->supplier_name;

            if(!empty($request->latlong)){
                $datas[] = $value->lat.','.$value->lng;
            }
            if(!empty($request->tel)){
                $datas[] = $value->supplier_tel;
            }
            if(!empty($request->email)){
                $datas[] = $value->supplier_email;
            }
            if(!empty($request->tax)){
                $datas[] = $value->supplier_tax;
            }
            if(!empty($request->notpay)){
                $datas[] = number_format($datanopay->totalpayment,2);
            }
            if(!empty($request->total)){
                $datas[] = number_format($datatotal->totalpayment,2);
            }
            
            if(!empty($moneynotpay)){
                $txt = '';
                if($request->typenotpay == '1'){
                    $txt = $datanopay->totalpayment > $moneynotpay;
                }else if($request->typenotpay == '2'){
                    $txt = $datanopay->totalpayment == $moneynotpay;
                }else if($request->typenotpay == '3'){
                    $txt = $datanopay->totalpayment < $moneynotpay;
                }
                if($txt){
                    $datasup[] = $datas;
                }
            }else{
                $datasup[] = $datas;
            }

        }
        // dd($datacustomer);
        // return $datename;
        $datename = date('d_m_Y_H_i_s');
        $colunmhead = "A";
        $fileexcel = Excel::create('รายงานซัพพลายเออร์'.$datename, function ($excel) use ($datasup,$arrayhead,$colunmhead){
            
            $excel->sheet('รายงานซัพพลายเออร์', function ($sheet) use ($datasup,$arrayhead,$colunmhead){
                // dd($customer);
                $sheet->fromArray($datasup);
                $sheet->setFontFamily('Tahoma');
                $sheet->cells('A1:J1', function($cells) {
                    // $cells->setFontWeight('bold');
                    
                    // $cells->setFont(array(
                    //  'family'     => 'Tahoma',
                    //  'size'       => '11',
                    //  'bold'       => true
                    // ));
                });

                $sheet->setAutoSize(array(
                    'A', 'B','C', 'D','E', 'F','G', 'H','I', 'J','K', 'L','M', 'N','O', 'P','Q'
                ));
                $sheet->setFontSize(11);
                $sheet->row(1, $arrayhead);
            });
        });
        savelog('12','ออกรายงานซัพพลายเออร์เป็นไฟล์ Excel ');
        $fileexcel->download('xlsx');
    }

    public function reportpdf(Request $request){
        $supplier = DB::table('supplier');
        $name = request('name');
        $nameto = request('nameto');
        
        if($name != '' && $nameto != ''){
            $supplier->whereBetween('supplier_id',[$name,$nameto]);  //เปลี่ยนเป็นselect2เลยให้ค้นจากidแทน
        }else{
            if(!empty($name)){
                $supplier->where('supplier_id',$name);
            }
            
            if(!empty($nameto)){
                $supplier->where('supplier_id',$nameto);
            }
        }
        
        $supplier = $supplier->get();
        // dd($customer);
        $moneynotpay = request('moneynotpay');
        $data = [];
        $start = request('datestart');
        $end = request('dateend');

        $category = request('category');
        $wherein = [];
        if(!empty($category)){
            foreach ($category as $value) {
                $wherein[]=$value;
            }
        }

        $arrayhead = ['ลำดับที่','ชื่อผู้ผลิต'];
        $datasup = [];
        if(!empty($request->latlong)){
            $arrayhead[] = $request->latlong;
        }
        if(!empty($request->tel)){
            $arrayhead[] = $request->tel;
        }
        if(!empty($request->email)){
            $arrayhead[] = $request->email;
        }
        if(!empty($request->tax)){
            $arrayhead[] = $request->tax;
        }
        if(!empty($request->notpay)){
            $arrayhead[] = $request->notpay;
        }
        if(!empty($request->total)){
            $arrayhead[] = $request->total;
        }

        $typepay = $request->typepay;
        // dd($arrayhead);
        $count = 0;
        foreach ($supplier as $key => $value) {


            $datatotal = DB::table('import_product')->leftjoin('sub_import_product','import_product.imp_id','sub_import_product.imp_id')->leftjoin('product','product.product_id','sub_import_product.product_id')->select(DB::raw('IFNULL(SUM(amount*product_capital),0) as totalpayment'))->where('supplier_id',$value->supplier_id)->whereBetween('imp_date',[$start,$end]);
            if($category != ''){
                $datatotal = $datatotal->whereIn('product_category',$wherein);
            }
            $datatotal = $datatotal->first();

            $datanopay = DB::table('import_product')->leftjoin('sub_import_product','import_product.imp_id','sub_import_product.imp_id')->leftjoin('product','product.product_id','sub_import_product.product_id')->select(DB::raw('IFNULL(SUM(amount*product_capital),0) as totalpayment'))->where('supplier_id',$value->supplier_id)->where('impt_status',0)->whereBetween('imp_date',[$start,$end]);  //จัดบิลเก็บแล้วยังไม่จ่าย
            if($category != ''){
                $datanopay = $datanopay->whereIn('product_category',$wherein);
            }
            $datanopay = $datanopay->first();
            // $datapay = DB::table('customer')->leftjoin('selling','selling_customerid','customer_id')->select(DB::raw('IFNULL(SUM(selling_totalpayment),0) as totalpayment'))->where('customer_id',$value->customer_id)->where('selling_status',8)->whereBetween('selling_date',[$start,$end])->first();  //จัดบิลเก็บแล้วยังจ่าย
            if($typepay != ''){
                $datatypepay = DB::table('import_product')->leftjoin('sub_import_product','import_product.imp_id','sub_import_product.imp_id')->leftjoin('product','product.product_id','sub_import_product.product_id')->select(DB::raw('IFNULL(SUM(amount*product_capital),0) as totalpayment'))->where('type_pay',$typepay)->whereBetween('imp_date',[$start,$end]);
                if($category != ''){
                    $datatypepay = $datatypepay->whereIn('product_category',$wherein);
                }
                $datatypepay = $datatypepay->count();
                if($datatypepay == 0){
                    continue;
                }
            }


            $datas = [];
            $datas[] = $key+1;
            $datas[] = $value->supplier_name;

            if(!empty($request->latlong)){
                $datas[] = $value->lat.','.$value->lng;
            }
            if(!empty($request->tel)){
                $datas[] = $value->supplier_tel;
            }
            if(!empty($request->email)){
                $datas[] = $value->supplier_email;
            }
            if(!empty($request->tax)){
                $datas[] = $value->supplier_tax;
            }
            if(!empty($request->notpay)){
                $value->notpay = number_format($datanopay->totalpayment,2);
            }
            if(!empty($request->total)){
                $value->total = number_format($datatotal->totalpayment,2);
            }
            
            if(!empty($moneynotpay)){
                $txt = '';
                if($request->typenotpay == '1'){
                    $txt = $datanopay->totalpayment > $moneynotpay;
                }else if($request->typenotpay == '2'){
                    $txt = $datanopay->totalpayment == $moneynotpay;
                }else if($request->typenotpay == '3'){
                    $txt = $datanopay->totalpayment < $moneynotpay;
                }
                if($txt){
                    $supplier[$count] = $supplier[$key];
                    unset($supplier[$key]);
                    $count++;
                }else{
                    unset($supplier[$key]);
                }
            }else{
                $datasup[] = $datas;
            }

        }
        // $customer = $data;
        $responsedata = [];
        $responsedata['head'] = $arrayhead;
        $responsedata['data'] = $datasup;

        $pdf = PDF::loadView('reportpdf/reportpdfsupplier',['head' => $arrayhead,'data' => $supplier,'datestart'=> date("d/m/Y",strtotime($request->datestart)),'dateend'=>date("d/m/Y",strtotime($request->dateend))],[],['orientation' => 'L', 'format' => 'A4-L']);
        savelog('12','ออกรายงานซัพพลายเออร์เป็นไฟล์ PDF ');
        return $pdf->stream();
    }
}
