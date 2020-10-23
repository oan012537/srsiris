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
use App\area;
use App\product;
use App\imports;
use App\subimports;
use App\processingunit;
use App\stock;

class ReportstockController extends Controller
{
    public function index(){
        $product = product::all();
        $category   = DB::table('category')->get();
		return view('report/reportstock',['product' =>$product,'category' => $category]);
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
        $selling = DB::table('selling')->leftjoin('selling_detail','selling.selling_id','selling_detail.sellingdetail_ref')->leftjoin('product','product.product_id','selling_detail.sellingdetail_productid')->leftjoin('category','category.category_id','product.product_category')->leftjoin('orders','orders.order_id','selling_detail.sellingdetail_sellingref')->select(DB::raw('*,order_price-order_capital as profit'));
        // if(Auth::user()->position != 1){
        //     $customer->where('customer_group',Auth::user()->groupsell);
        // }
        $name = request('productname');
        $nameto = request('productnameto');
        if($name != '' && $nameto != ''){
            // $name = request('productnameid');
            // $nameto = request('productnametoid');
            $selling->whereBetween('product_name',[$name,$nameto]);  //เปลี่ยนเป็นselect2เลยให้ค้นจากidแทน
        }else{
            if(!empty($name)){
                $selling->where('product_name',$name);
            }
            
            if(!empty($nameto)){
                $selling->where('product_name',$nameto);
            }
        }
        $start = request('datestart');
        $end = request('dateend');
        if($start != '' && $end != ''){
            $selling = $selling->whereBetween('selling_date',[$start,$end]);
        }

        $sqlselling = $selling;

        $moneyprice = $request->moneyprice;
        $moneystandardprice = $request->moneystandardprice;
        $moneyprofit = $request->moneyprofit;
        
        if(!empty($moneyprice)){
            $selling = $selling->where('order_price',$request->typeprice,$moneyprice);
        }
        if(!empty($moneystandardprice)){
            $selling = $selling->where('order_capital',$request->typestandardprice,$moneystandardprice);
        }
        if(!empty($moneyprofit)){
            $selling = $selling->havingRaw('(order_price-order_capital)'.$request->typeprofit.' ?',[$moneyprofit]);
        }
        $selling = $selling->get();

        // dd($selling->tosql());
        $moneynotpay = request('moneynotpay');
        $data = [];
        $start = request('datestart');
        $end = request('dateend');

        $arrayhead = ['ลำดับที่','ชื่อสินค้า'];
        $countdate = 1;
        $datasup = [];
        if(!empty($request->checkcategory)){
            $arrayhead[] = $request->checkcategory;
            $countdate += 1;
        }
        if(!empty($request->checkdate)){
            $arrayhead[] = $request->checkdate;
        }
        if(!empty($request->billno)){
            $arrayhead[] = $request->billno;
        }
        if(!empty($request->checkprice)){
            $arrayhead[] = $request->checkprice;
        }
        if(!empty($request->checkprice)){
            $arrayhead[] = $request->checkstandardprice;
        }
        if(!empty($request->checkprofit)){
            $arrayhead[] = $request->checkprofit;
        }
        if(!empty($request->checkin)){
            $arrayhead[] = $request->checkin;
        }
        if(!empty($request->checkout)){
            $arrayhead[] = $request->checkout;
        }
        if(!empty($request->percen)){
            $arrayhead[] = $request->percen;
        }
        // dd($selling);
        
        foreach ($selling as $key => $value) {

            $datas = [];
            $datas[] = $key+1;
            $datas[] = $value->product_name;

            if(!empty($request->checkcategory)){
                $datas[] = $value->category_name;
            }
            if(!empty($request->checkdate)){
                $datas[] = $value->selling_date;
            }
            if(!empty($request->billno)){
                $datas[] = $value->selling_inv;
            }
            if(!empty($request->checkprice)){
                $datas[] = $value->order_price;
            }
            if(!empty($request->checkprice)){
                $datas[] = $value->order_capital;
            }
            if(!empty($request->checkprofit)){
                $datas[] = $value->profit;
            }
            if(!empty($request->checkin)){
                $datas[] = 0;
            }
            if(!empty($request->checkout)){
                $datas[] = $value->sellingdetail_qty;
            }
            if(!empty($request->percen)){
                if($value->order_price == 0){
                    $datas[] = 0;
                }else{
                    $datas[] = number_format(($value->profit/$value->order_price),2);
                }
                
            }

            $datasup[] = $datas;

        }

        $import = DB::table('import_product')->leftjoin('sub_import_product','import_product.imp_id','sub_import_product.imp_id')->leftjoin('product','product.product_id','sub_import_product.product_id')->leftjoin('category','category.category_id','product.product_category');
        // if(Auth::user()->position != 1){
        //     $customer->where('customer_group',Auth::user()->groupsell);
        // }
        $name = request('productname');
        $nameto = request('productnameto');
        if($name != '' && $nameto != ''){
            // $name = request('productnameid');
            // $nameto = request('productnametoid');
            $import->whereBetween('product.product_name',[$name,$nameto]);  //เปลี่ยนเป็นselect2เลยให้ค้นจากidแทน
        }else{
            if(!empty($name)){
                $import->where('product_name',$name);
            }
            
            if(!empty($nameto)){
                $import->where('product_name',$nameto);
            }
        }
        $start = request('datestart');
        $end = request('dateend');
        if($start != '' && $end != ''){
            $import = $import->whereBetween('imp_date',[$start,$end]);
        }

        $moneyprice = $request->moneyprice;
        $moneystandardprice = $request->moneystandardprice;
        $moneyprofit = $request->moneyprofit;
        
        if(!empty($moneyprice)){
            // $import = $selling->where('order_price',$request->typeprice,$moneyprice);
        }
        if(!empty($moneystandardprice)){
            $import = $import->where('product_capital',$request->typestandardprice,$moneystandardprice);
        }
        if(!empty($moneyprofit)){
            // $import = $selling->havingRaw('(order_price-order_capital)'.$request->typeprofit.' ?',[$moneyprofit]);
        }
        $import = $import->get();
        
        foreach ($import as $key => $value) {

            $datas = [];
            $datas[] = count($datasup)+1;
            $datas[] = $value->product_name;

            if(!empty($request->checkcategory)){
                $datas[] = $value->category_name;
            }
            if(!empty($request->checkdate)){
                $datas[] = $value->imp_date;
            }
            if(!empty($request->billno)){
                $datas[] = $value->imp_no;
            }
            if(!empty($request->checkprice)){
                $datas[] = 0;
            }
            if(!empty($request->checkprice)){
                $datas[] = $value->product_capital;
            }
            if(!empty($request->checkprofit)){
                $datas[] = 0;
            }
            if(!empty($request->checkin)){
                $datas[] = $value->amount;
            }
            if(!empty($request->checkout)){
                $datas[] = 0;
            }
            if(!empty($request->percen)){
                $datas[] = 0;
            }
            $datasup[] = $datas;

        }
        //เอาไว้เรียงข้อมูลตามวันที่
        if(count($datasup) > 0 && !empty($request->checkdate)){
            foreach ($datasup as $key => $part) {
                $sort[$key] = strtotime($part[$countdate+1]);
            }
            array_multisort($sort, SORT_ASC, $datasup);
        }
        //เอาไว้เรียงข้อมูลตามวันที่

        // dd($array);
        // $customer = $data;
        $responsedata = [];
        $responsedata['head'] = $arrayhead;
        $responsedata['data'] = $datasup;
        return Response::json($responsedata);

        // $supplier = $supplier->get();
        // return view('report/reportsupplier',['data'=>$supplier]);
    }

    public function reportexcel(Request $request){

        $selling = DB::table('selling')->leftjoin('selling_detail','selling.selling_id','selling_detail.sellingdetail_ref')->leftjoin('product','product.product_id','selling_detail.sellingdetail_productid')->leftjoin('category','category.category_id','product.product_category')->leftjoin('orders','orders.order_id','selling_detail.sellingdetail_sellingref')->select(DB::raw('*,order_price-order_capital as profit'));
        // if(Auth::user()->position != 1){
        //     $customer->where('customer_group',Auth::user()->groupsell);
        // }
        $name = request('productname');
        $nameto = request('productnameto');
        if($name != '' && $nameto != ''){
            // $name = request('productnameid');
            // $nameto = request('productnametoid');
            $selling->whereBetween('product_name',[$name,$nameto]);  //เปลี่ยนเป็นselect2เลยให้ค้นจากidแทน
        }else{
            if(!empty($name)){
                $selling->where('product_name',$name);
            }
            
            if(!empty($nameto)){
                $selling->where('product_name',$nameto);
            }
        }
        $start = request('datestart');
        $end = request('dateend');
        if($start != '' && $end != ''){
            $selling = $selling->whereBetween('selling_date',[$start,$end]);
        }

        $sqlselling = $selling;

        $moneyprice = $request->moneyprice;
        $moneystandardprice = $request->moneystandardprice;
        $moneyprofit = $request->moneyprofit;
        
        if(!empty($moneyprice)){
            $selling = $selling->where('order_price',$request->typeprice,$moneyprice);
        }
        if(!empty($moneystandardprice)){
            $selling = $selling->where('order_capital',$request->typestandardprice,$moneystandardprice);
        }
        if(!empty($moneyprofit)){
            $selling = $selling->havingRaw('(order_price-order_capital)'.$request->typeprofit.' ?',[$moneyprofit]);
        }
        $selling = $selling->get();

        // dd($selling->tosql());
        $moneynotpay = request('moneynotpay');
        $data = [];
        $start = request('datestart');
        $end = request('dateend');

        $arrayhead = ['ลำดับที่','ชื่อสินค้า'];
        $countdate = 1;
        $datasup = [];
        if(!empty($request->checkcategory)){
            $arrayhead[] = $request->checkcategory;
            $countdate += 1;
        }
        if(!empty($request->checkdate)){
            $arrayhead[] = $request->checkdate;
        }
        if(!empty($request->billno)){
            $arrayhead[] = $request->billno;
        }
        if(!empty($request->checkprice)){
            $arrayhead[] = $request->checkprice;
        }
        if(!empty($request->checkprice)){
            $arrayhead[] = $request->checkstandardprice;
        }
        if(!empty($request->checkprofit)){
            $arrayhead[] = $request->checkprofit;
        }
        if(!empty($request->checkin)){
            $arrayhead[] = $request->checkin;
        }
        if(!empty($request->checkout)){
            $arrayhead[] = $request->checkout;
        }

        if(!empty($request->percen)){
            $arrayhead[] = $request->percen;
        }
        // dd($arrayhead);
        
        foreach ($selling as $key => $value) {

            $datas = [];
            $datas[] = $key+1;
            $datas[] = $value->product_name;

            if(!empty($request->checkcategory)){
                $datas[] = $value->category_name;
            }
            if(!empty($request->checkdate)){
                $datas[] = $value->selling_date;
            }
            if(!empty($request->billno)){
                $datas[] = $value->selling_inv;
            }
            if(!empty($request->checkprice)){
                $datas[] = $value->order_price;
            }
            if(!empty($request->checkprice)){
                $datas[] = $value->order_capital;
            }
            if(!empty($request->checkprofit)){
                $datas[] = $value->profit;
            }
            if(!empty($request->checkin)){
                $datas[] = 0;
            }
            if(!empty($request->checkout)){
                $datas[] = $value->sellingdetail_qty;
            }
            
            if(!empty($request->percen)){
                if($value->order_price == 0){
                    $datas[] = 0;
                }else{
                    $datas[] = number_format(($value->profit/$value->order_price),2);
                }
                
            }

            $datasup[] = $datas;

        }

        $import = DB::table('import_product')->leftjoin('sub_import_product','import_product.imp_id','sub_import_product.imp_id')->leftjoin('product','product.product_id','sub_import_product.product_id')->leftjoin('category','category.category_id','product.product_category');
        // if(Auth::user()->position != 1){
        //     $customer->where('customer_group',Auth::user()->groupsell);
        // }
        $name = request('productname');
        $nameto = request('productnameto');
        if($name != '' && $nameto != ''){
            // $name = request('productnameid');
            // $nameto = request('productnametoid');
            $import->whereBetween('product.product_name',[$name,$nameto]);  //เปลี่ยนเป็นselect2เลยให้ค้นจากidแทน
        }else{
            if(!empty($name)){
                $import->where('product_name',$name);
            }
            
            if(!empty($nameto)){
                $import->where('product_name',$nameto);
            }
        }
        $start = request('datestart');
        $end = request('dateend');
        if($start != '' && $end != ''){
            $import = $import->whereBetween('imp_date',[$start,$end]);
        }

        $moneyprice = $request->moneyprice;
        $moneystandardprice = $request->moneystandardprice;
        $moneyprofit = $request->moneyprofit;
        
        if(!empty($moneyprice)){
            // $import = $selling->where('order_price',$request->typeprice,$moneyprice);
        }
        if(!empty($moneystandardprice)){
            $import = $import->where('product_capital',$request->typestandardprice,$moneystandardprice);
        }
        if(!empty($moneyprofit)){
            // $import = $selling->havingRaw('(order_price-order_capital)'.$request->typeprofit.' ?',[$moneyprofit]);
        }
        $import = $import->get();
        
        foreach ($import as $key => $value) {

            $datas = [];
            $datas[] = count($datasup)+1;
            $datas[] = $value->product_name;

            if(!empty($request->checkcategory)){
                $datas[] = $value->category_name;
            }
            if(!empty($request->checkdate)){
                $datas[] = $value->imp_date;
            }
            if(!empty($request->billno)){
                $datas[] = $value->imp_no;
            }
            if(!empty($request->checkprice)){
                $datas[] = 0;
            }
            if(!empty($request->checkprice)){
                $datas[] = $value->product_capital;
            }
            if(!empty($request->checkprofit)){
                $datas[] = 0;
            }
            if(!empty($request->checkin)){
                $datas[] = $value->amount;
            }
            if(!empty($request->checkout)){
                $datas[] = 0;
            }
            if(!empty($request->percen)){
                $datas[] = 0;
            }

            $datasup[] = $datas;

        }
        //เอาไว้เรียงข้อมูลตามวันที่
        if(count($datasup) > 0 && !empty($request->checkdate)){
            foreach ($datasup as $key => $part) {
                $sort[$key] = strtotime($part[$countdate+1]);
            }
            array_multisort($sort, SORT_ASC, $datasup);
        }
        foreach ($datasup as $key => $value) {
            $datasup[$key][0] =  $key+1;
        }
        
        $datename = date('d_m_Y_H_i_s');
        
        $fileexcel = Excel::create('รายงานสต๊อก'.$datename, function ($excel) use ($datasup,$arrayhead){
            
            $excel->sheet('รายงานสต๊อก', function ($sheet) use ($datasup,$arrayhead){
                // dd($customer);
                $sheet->fromArray($datasup);
                $sheet->setFontFamily('Tahoma');
                $sheet->cells('A1:Z1', function($cells) {
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


                $sheet->row(1, $arrayhead); //กำหนดหัวข้อใส่array
            });
        });
        // dd($fileexcel);
        savelog('12','ออกรายงานสต๊อกเป็นไฟล์ Excel ');
        $fileexcel->download('xlsx');
        // return view('backend.delivery.report',["data"=>$deliverydata,"date"=>$request->input('date')]);
    }

    public function reportpdf(Request $request){
        $selling = DB::table('selling')->leftjoin('selling_detail','selling.selling_id','selling_detail.sellingdetail_ref')->leftjoin('product','product.product_id','selling_detail.sellingdetail_productid')->leftjoin('category','category.category_id','product.product_category')->leftjoin('orders','orders.order_id','selling_detail.sellingdetail_sellingref')->select(DB::raw('*,order_price-order_capital as profit'));
        // if(Auth::user()->position != 1){
        //     $customer->where('customer_group',Auth::user()->groupsell);
        // }
        $name = request('productname');
        $nameto = request('productnameto');
        if($name != '' && $nameto != ''){
            // $name = request('productnameid');
            // $nameto = request('productnametoid');
            $selling->whereBetween('product_name',[$name,$nameto]);  //เปลี่ยนเป็นselect2เลยให้ค้นจากidแทน
        }else{
            if(!empty($name)){
                $selling->where('product_name',$name);
            }
            
            if(!empty($nameto)){
                $selling->where('product_name',$nameto);
            }
        }
        $start = request('datestart');
        $end = request('dateend');
        if($start != '' && $end != ''){
            $selling = $selling->whereBetween('selling_date',[$start,$end]);
        }

        $sqlselling = $selling;

        $moneyprice = $request->moneyprice;
        $moneystandardprice = $request->moneystandardprice;
        $moneyprofit = $request->moneyprofit;
        
        if(!empty($moneyprice)){
            $selling = $selling->where('order_price',$request->typeprice,$moneyprice);
        }
        if(!empty($moneystandardprice)){
            $selling = $selling->where('order_capital',$request->typestandardprice,$moneystandardprice);
        }
        if(!empty($moneyprofit)){
            $selling = $selling->havingRaw('(order_price-order_capital)'.$request->typeprofit.' ?',[$moneyprofit]);
        }
        $selling = $selling->get();

        // dd($selling->tosql());
        $moneynotpay = request('moneynotpay');
        $data = [];
        $start = request('datestart');
        $end = request('dateend');

        $arrayhead = ['ลำดับที่','ชื่อสินค้า'];
        $countdate = 1;
        $datasup = [];
        if(!empty($request->checkcategory)){
            $arrayhead[] = $request->checkcategory;
            $countdate += 1;
        }
        if(!empty($request->checkdate)){
            $arrayhead[] = $request->checkdate;
        }
        if(!empty($request->billno)){
            $arrayhead[] = $request->billno;
        }
        if(!empty($request->checkprice)){
            $arrayhead[] = $request->checkprice;
        }
        if(!empty($request->checkprice)){
            $arrayhead[] = $request->checkstandardprice;
        }
        if(!empty($request->checkprofit)){
            $arrayhead[] = $request->checkprofit;
        }
        if(!empty($request->checkin)){
            $arrayhead[] = $request->checkin;
        }
        if(!empty($request->checkout)){
            $arrayhead[] = $request->checkout;
        }

        if(!empty($request->percen)){
            $arrayhead[] = $request->percen;
        }
        // dd($arrayhead);
        
        foreach ($selling as $key => $value) {

            $datas = [];
            $datas['id'] = $key+1;
            $datas['name'] = $value->product_name;

            if(!empty($request->checkcategory)){
                $datas['category'] = $value->category_name;
            }
            if(!empty($request->checkdate)){
                $datas['date'] = $value->selling_date;
            }
            if(!empty($request->billno)){
                $datas['bill'] = $value->selling_inv;
            }
            if(!empty($request->checkprice)){
                $datas['price'] = $value->order_price;
            }
            if(!empty($request->checkprice)){
                $datas['capital'] = $value->order_capital;
            }
            if(!empty($request->checkprofit)){
                $datas['profit'] = $value->profit;
            }
            if(!empty($request->checkin)){
                $datas['amount'] = 0;
            }
            if(!empty($request->checkout)){
                $datas['out'] = $value->sellingdetail_qty;
            }
            
            if(!empty($request->percen)){
                if($value->order_price == 0){
                    $datas['percen'] = 0;
                }else{
                    $datas['percen'] = number_format(($value->profit/$value->order_price),2);
                }
                
            }

            $datasup[] = $datas;

        }

        $import = DB::table('import_product')->leftjoin('sub_import_product','import_product.imp_id','sub_import_product.imp_id')->leftjoin('product','product.product_id','sub_import_product.product_id')->leftjoin('category','category.category_id','product.product_category');
        // if(Auth::user()->position != 1){
        //     $customer->where('customer_group',Auth::user()->groupsell);
        // }
        $name = request('productname');
        $nameto = request('productnameto');
        if($name != '' && $nameto != ''){
            // $name = request('productnameid');
            // $nameto = request('productnametoid');
            $import->whereBetween('product.product_name',[$name,$nameto]);  //เปลี่ยนเป็นselect2เลยให้ค้นจากidแทน
        }else{
            if(!empty($name)){
                $import->where('product_name',$name);
            }
            
            if(!empty($nameto)){
                $import->where('product_name',$nameto);
            }
        }
        $start = request('datestart');
        $end = request('dateend');
        if($start != '' && $end != ''){
            $import = $import->whereBetween('imp_date',[$start,$end]);
        }

        $moneyprice = $request->moneyprice;
        $moneystandardprice = $request->moneystandardprice;
        $moneyprofit = $request->moneyprofit;
        
        if(!empty($moneyprice)){
            // $import = $selling->where('order_price',$request->typeprice,$moneyprice);
        }
        if(!empty($moneystandardprice)){
            $import = $import->where('product_capital',$request->typestandardprice,$moneystandardprice);
        }
        if(!empty($moneyprofit)){
            // $import = $selling->havingRaw('(order_price-order_capital)'.$request->typeprofit.' ?',[$moneyprofit]);
        }
        $import = $import->get();
        
        foreach ($import as $key => $value) {

            $datas = [];
            $datas['id'] = count($datasup)+1;
            $datas['name'] = $value->product_name;

            if(!empty($request->checkcategory)){
                $datas['category'] = $value->category_name;
            }
            if(!empty($request->checkdate)){
                $datas['date'] = $value->imp_date;
            }
            if(!empty($request->billno)){
                $datas['bill'] = $value->imp_no;
            }
            if(!empty($request->checkprice)){
                $datas['price'] = 0;
            }
            if(!empty($request->checkprice)){
                $datas['capital'] = $value->product_capital;
            }
            if(!empty($request->checkprofit)){
                $datas['profit'] = 0;
            }
            if(!empty($request->checkin)){
                $datas['amount'] = $value->amount;
            }
            if(!empty($request->checkout)){
                $datas['out'] = 0;
            }
            if(!empty($request->percen)){
                $datas['percen'] = 0;
            }

            $datasup[] = $datas;

        }
        //เอาไว้เรียงข้อมูลตามวันที่
        if(count($datasup) > 0 && !empty($request->checkdate)){
            foreach ($datasup as $key => $part) {
                $sort[$key] = strtotime($part['date']);
            }
            array_multisort($sort, SORT_ASC, $datasup);
        }

        // dd($datasup);

        $pdf = PDF::loadView('reportpdf/reportpdfstock',['head' => $arrayhead,'data' => $datasup,'datestart'=> date("d/m/Y",strtotime($request->datestart)),'dateend'=>date("d/m/Y",strtotime($request->dateend))],[],['orientation' => 'L', 'format' => 'A4-L']);
        savelog('12','ออกรายงานสต๊อกเป็นไฟล์ PDF ');
        return $pdf->stream();
    }
}
