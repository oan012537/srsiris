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

class ReportsellController extends Controller
{
    public function index(){
        $area = area::all();
		return view('report/reportsell',['area' =>$area]);
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
        $selling = DB::table('selling')->leftjoin('selling_detail','selling.selling_id','selling_detail.sellingdetail_ref')->leftjoin('product','product.product_id','selling_detail.sellingdetail_productid')->leftjoin('category','category.category_id','product.product_category')->leftjoin('orders','orders.order_id','selling_detail.sellingdetail_sellingref')->leftjoin('customer','customer.customer_id','selling.selling_customerid')->leftjoin('area','customer.customer_group','area.area_id')->leftjoin('billingnotedata','billingnotedata.billingnotedata_exportid','selling.selling_id')->select(DB::raw('*,order_price-order_capital as profit'))->where('selling_status','!=','3');

        $datestartpay = request('datestartpay');
        $dateendpay = request('dateendpay');
        if($datestartpay != '' && $dateendpay != ''){
            // 
            $selling = $selling->where('billingnotedata_status',1)->whereBetween('billingnotedata.updated_at',[$datestartpay.' '.'00:00',$dateendpay.' '.'23:59']);
        }
        // if(Auth::user()->position != 1){
        //     $customer->where('customer_group',Auth::user()->groupsell);
        // }
        $billno = request('billno');
        $billnoto = request('billnoto');
        if($billno != '' && $billnoto != ''){
            $selling->whereBetween('selling_inv',[$billno,$billnoto]);  //เปลี่ยนเป็นselect2เลยให้ค้นจากidแทน
        }else{
            if(!empty($name)){
                $selling->where('selling_inv',$billno);
            }
            
            if(!empty($nameto)){
                $selling->where('selling_inv',$billnoto);
            }
        }
        $start = request('datestart');
        $end = request('dateend');
        if($start != '' && $end != ''){
            $selling = $selling->whereBetween('selling_date',[$start,$end]);
        }
        $customergroup = $request->customergroup;
        if(!empty($customergroup)){
            $whereIn = [];
            foreach ($customergroup as $value) {
                $whereIn[]=$value;
            }
            $selling->whereIn('customer_group',$whereIn);
        }

        

        $moneytotalpay = $request->moneytotalpay;
        $moneynotpay = $request->moneynotpay;
        

        if(!empty($moneytotalpay)){
            $selling = $selling->where('selling_totalall',$request->typetotalpay,$moneytotalpay);
        }
        if(!empty($moneynotpay)){
            // $selling = $selling->where('(selling_totalall-selling_totalpayment)',$request->typenotpay,$moneynotpay);
            $selling = $selling->havingRaw('(selling_totalall-billingnotedata_pay)'.$request->typenotpay.' ?',[$moneynotpay]);
        }

        $typesort = $request->typesort;
        if(!empty($typesort)){
            $selling = $selling->orderBy($typesort,'ASC');
        }

        $selling = $selling->groupBy('selling_id')->get();

        // dd($selling->tosql());
        $moneynotpay = request('moneynotpay');
        $data = [];
        $start = request('datestart');
        $end = request('dateend');

        $arrayhead = ['ลำดับที่','เลขที่บิล','วันที่'];
        $countdate = 1;
        $datasup = [];
        if(!empty($request->send)){
            $arrayhead[] = $request->send;
        }
        if(!empty($request->checkcustomergroup)){
            $arrayhead[] = $request->checkcustomergroup;
            $countdate += 1;
        }
        if(!empty($request->customer)){
            $arrayhead[] = $request->customer;
        }
        if(!empty($request->supplier)){
            $arrayhead[] = $request->supplier;
        }
        if(!empty($request->statusbill)){
            $arrayhead[] = $request->statusbill;
        }
        if(!empty($request->address)){
            $arrayhead[] = $request->address;
        }
        if(!empty($request->tel)){
            $arrayhead[] = $request->tel;
        }
        if(!empty($request->amount)){
            $arrayhead[] = $request->amount;
        }
        if(!empty($request->tax)){
            $arrayhead[] = $request->tax;
        }
        if(!empty($request->discount)){
            $arrayhead[] = $request->discount;
        }
        if(!empty($request->vat)){
            $arrayhead[] = $request->vat;
        }
        if(!empty($request->totalall)){
            $arrayhead[] = $request->totalall;
        }
        if(!empty($request->discountbill)){
            $arrayhead[] = $request->discountbill;
        }
        if(!empty($request->note)){
            $arrayhead[] = $request->note;
        }
        if(!empty($request->totalpay)){
            $arrayhead[] = $request->totalpay;
        }
        if(!empty($request->notpay)){
            $arrayhead[] = $request->notpay;
        }
        if(!empty($request->profit)){
            $arrayhead[] = $request->profit;
        }
        if(!empty($request->cost)){
            $arrayhead[] = $request->cost;
        }
        if(!empty($request->sales)){
            $arrayhead[] = $request->sales;
        }
        if(!empty($request->datestartduepay)){
            $datestartduepay = strtotime($request->datestartduepay);
        }
        if(!empty($request->dateendduepay)){
            $dateendduepay = strtotime($request->dateendduepay);
        }
        
        foreach ($selling as $key => $value) {
            $datecredit = strtotime("+".$value->customer_credit." day",strtotime($value->selling_date));
            if(!empty($request->datestartduepay) && !empty($request->dateendduepay)){
                if($datestartduepay > $datecredit && $dateendduepay < $datecredit){
                    continue;
                }
            }else if(!empty($request->datestartduepay)){
                if($datestartduepay > $datecredit){
                    continue;
                }
            }else if(!empty($request->dateendduepay)){
                if($dateendduepay < $datecredit){
                    continue;
                }
            }
            
            $datas = [];
            $datas[] = $key+1;
            $datas[] = $value->selling_inv;
            $datas[] = $value->selling_date;
            if(!empty($request->send)){
                $transport = DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->where('sub_order',$value->selling_id)->where('sub_status',1)->first();
                if(!empty($transport)){
                    $datas[] = $transport->trans_delivery;
                }else{
                    $datas[] = date("Y-m-d",$datecredit);
                }
            }
            if(!empty($request->checkcustomergroup)){
                $datas[] = $value->area_name;
            }
            if(!empty($request->customer)){
                $datas[] = $value->customer_name;
            }
            if(!empty($request->supplier)){
                $datas[] = $value->selling_empname;
            }
            if(!empty($request->statusbill)){
                if($value->selling_status == 8){
                    $value->selling_status = 'ชำระเรียบร้อย';
                }else if($value->selling_status == 7){
                    $value->selling_status = 'มียอดค้างชำระ';
                }else if($value->selling_status == 6){
                    $value->selling_status = 'แพ็คของยังไม่ครบ';
                }else if($value->selling_status == 5){
                    $value->selling_status = 'จัดขนส่ง';
                }else if($value->selling_status == 4){
                    $value->selling_status = 'แพ็คของแล้ว';
                }else if($value->selling_status == 3){
                    $value->selling_status = 'ยกเลิก';
                }else if($value->selling_status == 2){
                    $value->selling_status = 'บิลชั่วคราว';
                }else if($value->selling_status == 1){
                    $value->selling_status = 'เรียบร้อย';
                }else{
                    $value->selling_status = '';
                }
                $datas[] = $value->selling_status;
            }
            if(!empty($request->address)){
                $datas[] = " บ้านเลขที่ ".$value->customer_address1." ถนน ". $value->customer_address2 ." แขวง ". $value->customer_address3 ." เขต ". $value->customer_address4 ." จังหวัด ". $value->customer_address5 ." รหัสไปรษณย์ ".$value->customer_address6;;
            }
            if(!empty($request->tel)){
                $datas[] = $value->customer_tel;
            }
            if(!empty($request->amount)){
                $datas[] = $value->selling_total;
            }
            if(!empty($request->tax)){
                if($value->selling_vat == 1){
                    $value->selling_vat = 'จ่ายเต็ม';
                }else if($value->selling_vat == 2){
                    $value->selling_vat = 'จ่ายครึ่ง';
                }else if($value->selling_vat == 0){
                    $value->selling_vat = 'ฟรี';
                }else{
                    $value->selling_vat = '';
                }
                $datas[] = $value->selling_vat;
            }
            if(!empty($request->discount)){
                $datas[] = number_format($value->selling_discountsum,2);
            }
            if(!empty($request->vat)){
                $datas[] = number_format($value->selling_vatsum,2);
            }
            if(!empty($request->totalall)){
                $datas[] = number_format(($value->selling_total-($value->selling_discountsum+$value->selling_vatsum)),2);
            }
            if(!empty($request->discountbill)){
                $datas[] = number_format($value->selling_lastbill,2);
            }
            if(!empty($request->note)){
                $datas[] = $value->selling_note;
            }
            if(!empty($request->totalpay)){
                $datas[] = number_format($value->selling_totalall,2);
            }
            if(!empty($request->notpay)){
                $datas[] = number_format(($value->selling_totalall-$value->billingnotedata_pay),2);
            }
            if(!empty($request->profit)){
                $datas[] = number_format($value->profit,2);
            }
            if(!empty($request->cost)){
                $datas[] = number_format($value->order_capital,2);
            }
            if(!empty($request->sales)){
                $datas[] = number_format($value->order_price,2);
            }
            $datasup[] = $datas;
        }

        $responsedata = [];
        $responsedata['head'] = $arrayhead;
        $responsedata['data'] = $datasup;
        return Response::json($responsedata);
    }

    public function reportexcel(Request $request){

        
        $selling = DB::table('selling')->leftjoin('selling_detail','selling.selling_id','selling_detail.sellingdetail_ref')->leftjoin('product','product.product_id','selling_detail.sellingdetail_productid')->leftjoin('category','category.category_id','product.product_category')->leftjoin('orders','orders.order_id','selling_detail.sellingdetail_sellingref')->leftjoin('customer','customer.customer_id','selling.selling_customerid')->leftjoin('area','customer.customer_group','area.area_id')->leftjoin('billingnotedata','billingnotedata.billingnotedata_exportid','selling.selling_id')->select(DB::raw('*,order_price-order_capital as profit'))->where('selling_status','!=','3');

        $datestartpay = request('datestartpay');
        $dateendpay = request('dateendpay');
        if($datestartpay != '' && $dateendpay != ''){
            // 
            $selling = $selling->where('billingnotedata_status',1)->whereBetween('billingnotedata.updated_at',[$datestartpay.' '.'00:00',$dateendpay.' '.'23:59']);
        }
        // if(Auth::user()->position != 1){
        //     $customer->where('customer_group',Auth::user()->groupsell);
        // }
        $billno = request('billno');
        $billnoto = request('billnoto');
        if($billno != '' && $billnoto != ''){
            $selling->whereBetween('selling_inv',[$billno,$billnoto]);  //เปลี่ยนเป็นselect2เลยให้ค้นจากidแทน
        }else{
            if(!empty($name)){
                $selling->where('selling_inv',$billno);
            }
            
            if(!empty($nameto)){
                $selling->where('selling_inv',$billnoto);
            }
        }
        $start = request('datestart');
        $end = request('dateend');
        if($start != '' && $end != ''){
            $selling = $selling->whereBetween('selling_date',[$start,$end]);
        }
        $customergroup = $request->customergroup;
        if(!empty($customergroup)){
            $whereIn = [];
            foreach ($customergroup as $value) {
                $whereIn[]=$value;
            }
            $selling->whereIn('customer_group',$whereIn);
        }

        

        $moneytotalpay = $request->moneytotalpay;
        $moneynotpay = $request->moneynotpay;
        

        if(!empty($moneytotalpay)){
            $selling = $selling->where('selling_totalall',$request->typetotalpay,$moneytotalpay);
        }
        if(!empty($moneynotpay)){
            // $selling = $selling->where('(selling_totalall-selling_totalpayment)',$request->typenotpay,$moneynotpay);
            $selling = $selling->havingRaw('(selling_totalall-billingnotedata_pay)'.$request->typenotpay.' ?',[$moneynotpay]);
        }

        $typesort = $request->typesort;
        if(!empty($typesort)){
            $selling = $selling->orderBy($typesort,'ASC');
        }

        $selling = $selling->groupBy('selling_id')->get();

        // dd($selling->tosql());
        $moneynotpay = request('moneynotpay');
        $data = [];
        $start = request('datestart');
        $end = request('dateend');

        $arrayhead = ['ลำดับที่','เลขที่บิล','วันที่'];
        $countdate = 1;
        $datasup = [];
        if(!empty($request->send)){
            $arrayhead[] = $request->send;
        }
        if(!empty($request->checkcustomergroup)){
            $arrayhead[] = $request->checkcustomergroup;
            $countdate += 1;
        }
        if(!empty($request->customer)){
            $arrayhead[] = $request->customer;
        }
        if(!empty($request->supplier)){
            $arrayhead[] = $request->supplier;
        }
        if(!empty($request->statusbill)){
            $arrayhead[] = $request->statusbill;
        }
        if(!empty($request->address)){
            $arrayhead[] = $request->address;
        }
        if(!empty($request->tel)){
            $arrayhead[] = $request->tel;
        }
        if(!empty($request->amount)){
            $arrayhead[] = $request->amount;
        }
        if(!empty($request->tax)){
            $arrayhead[] = $request->tax;
        }
        if(!empty($request->discount)){
            $arrayhead[] = $request->discount;
        }
        if(!empty($request->vat)){
            $arrayhead[] = $request->vat;
        }
        if(!empty($request->totalall)){
            $arrayhead[] = $request->totalall;
        }
        if(!empty($request->discountbill)){
            $arrayhead[] = $request->discountbill;
        }
        if(!empty($request->note)){
            $arrayhead[] = $request->note;
        }
        if(!empty($request->totalpay)){
            $arrayhead[] = $request->totalpay;
        }
        if(!empty($request->notpay)){
            $arrayhead[] = $request->notpay;
        }
        if(!empty($request->profit)){
            $arrayhead[] = $request->profit;
        }
        if(!empty($request->cost)){
            $arrayhead[] = $request->cost;
        }
        if(!empty($request->sales)){
            $arrayhead[] = $request->sales;
        }
        if(!empty($request->datestartduepay)){
            $datestartduepay = strtotime($request->datestartduepay);
        }
        if(!empty($request->dateendduepay)){
            $dateendduepay = strtotime($request->dateendduepay);
        }
        
        foreach ($selling as $key => $value) {
            $datecredit = strtotime("+".$value->customer_credit." day",strtotime($value->selling_date));
            if(!empty($request->datestartduepay) && !empty($request->dateendduepay)){
                if($datestartduepay > $datecredit && $dateendduepay < $datecredit){
                    continue;
                }
            }else if(!empty($request->datestartduepay)){
                if($datestartduepay > $datecredit){
                    continue;
                }
            }else if(!empty($request->dateendduepay)){
                if($dateendduepay < $datecredit){
                    continue;
                }
            }
            
            $datas = [];
            $datas[] = $key+1;
            $datas[] = $value->selling_inv;
            $datas[] = $value->selling_date;
            if(!empty($request->send)){
                $transport = DB::table('transport')->leftjoin('sub_tran','sub_ref','trans_id')->where('sub_order',$value->selling_id)->where('sub_status',1)->first();
                if(!empty($transport)){
                    $datas[] = $transport->trans_delivery;
                }else{
                    $datas[] = date("Y-m-d",$datecredit);
                }
            }
            if(!empty($request->checkcustomergroup)){
                $datas[] = $value->area_name;
            }
            if(!empty($request->customer)){
                $datas[] = $value->customer_name;
            }
            if(!empty($request->supplier)){
                $datas[] = $value->selling_empname;
            }
            if(!empty($request->statusbill)){
                if($value->selling_status == 8){
                    $value->selling_status = 'ชำระเรียบร้อย';
                }else if($value->selling_status == 7){
                    $value->selling_status = 'มียอดค้างชำระ';
                }else if($value->selling_status == 6){
                    $value->selling_status = 'แพ็คของยังไม่ครบ';
                }else if($value->selling_status == 5){
                    $value->selling_status = 'จัดขนส่ง';
                }else if($value->selling_status == 4){
                    $value->selling_status = 'แพ็คของแล้ว';
                }else if($value->selling_status == 3){
                    $value->selling_status = 'ยกเลิก';
                }else if($value->selling_status == 2){
                    $value->selling_status = 'บิลชั่วคราว';
                }else if($value->selling_status == 1){
                    $value->selling_status = 'เรียบร้อย';
                }else{
                    $value->selling_status = '';
                }
                $datas[] = $value->selling_status;
            }
            if(!empty($request->address)){
                $datas[] = " บ้านเลขที่ ".$value->customer_address1." ถนน ". $value->customer_address2 ." แขวง ". $value->customer_address3 ." เขต ". $value->customer_address4 ." จังหวัด ". $value->customer_address5 ." รหัสไปรษณย์ ".$value->customer_address6;;
            }
            if(!empty($request->tel)){
                $datas[] = $value->customer_tel;
            }
            if(!empty($request->amount)){
                $datas[] = $value->selling_total;
            }
            if(!empty($request->tax)){
                if($value->selling_vat == 1){
                    $value->selling_vat = 'จ่ายเต็ม';
                }else if($value->selling_vat == 2){
                    $value->selling_vat = 'จ่ายครึ่ง';
                }else if($value->selling_vat == 0){
                    $value->selling_vat = 'ฟรี';
                }else{
                    $value->selling_vat = '';
                }
                $datas[] = $value->selling_vat;
            }
            if(!empty($request->discount)){
                $datas[] = number_format($value->selling_discountsum,2);
            }
            if(!empty($request->vat)){
                $datas[] = number_format($value->selling_vatsum,2);
            }
            if(!empty($request->totalall)){
                $datas[] = number_format(($value->selling_total-($value->selling_discountsum+$value->selling_vatsum)),2);
            }
            if(!empty($request->discountbill)){
                $datas[] = number_format($value->selling_lastbill,2);
            }
            if(!empty($request->note)){
                $datas[] = $value->selling_note;
            }
            if(!empty($request->totalpay)){
                $datas[] = number_format($value->selling_totalall,2);
            }
            if(!empty($request->notpay)){
                $datas[] = number_format(($value->selling_totalall-$value->billingnotedata_pay),2);
            }
            if(!empty($request->profit)){
                $datas[] = number_format($value->profit,2);
            }
            if(!empty($request->cost)){
                $datas[] = number_format($value->order_capital,2);
            }
            if(!empty($request->sales)){
                $datas[] = number_format($value->order_price,2);
            }

            $datasup[] = $datas;
        }

        $datename = date('d_m_Y_H_i_s');
        
        $fileexcel = Excel::create('รายงานขาย'.$datename, function ($excel) use ($datasup,$arrayhead){
            
            $excel->sheet('รายงานขาย', function ($sheet) use ($datasup,$arrayhead){
                // dd($customer);
                $sheet->fromArray($datasup);
                $sheet->setFontFamily('Tahoma');
                $sheet->cells('A1:Z1', function($cells) {
                });

                $sheet->setAutoSize(array(
                    'A', 'B','C', 'D','E', 'F','G', 'H','I', 'J','K', 'L','M', 'N','O', 'P','Q','R','S','T','U','W','X','Y','Z'
                ));
                $sheet->setPageMargin(0.25);
                $sheet->setOrientation('landscape');
                $sheet->setFontSize(11);


                $sheet->row(1, $arrayhead); //กำหนดหัวข้อใส่array
            });
        });
        // dd($fileexcel);
        savelog('12','ออกรายงานขายเป็นไฟล์ Excel ');
        $fileexcel->download('xlsx');
    }

    public function reportsellpdf(Request $request){
        $selling = DB::table('selling')->leftjoin('selling_detail','selling.selling_id','selling_detail.sellingdetail_ref')->leftjoin('product','product.product_id','selling_detail.sellingdetail_productid')->leftjoin('category','category.category_id','product.product_category')->leftjoin('orders','orders.order_id','selling_detail.sellingdetail_sellingref')->leftjoin('customer','customer.customer_id','selling.selling_customerid')->leftjoin('area','customer.customer_group','area.area_id')->leftjoin('billingnotedata','billingnotedata.billingnotedata_exportid','selling.selling_id')->select(DB::raw('*,order_price-order_capital as profit'))->where('selling_status','!=','3');

        $datestartpay = request('datestartpay');
        $dateendpay = request('dateendpay');
        if($datestartpay != '' && $dateendpay != ''){
            // 
            $selling = $selling->where('billingnotedata_status',1)->whereBetween('billingnotedata.updated_at',[$datestartpay.' '.'00:00',$dateendpay.' '.'23:59']);
        }
        // if(Auth::user()->position != 1){
        //     $customer->where('customer_group',Auth::user()->groupsell);
        // }
        $billno = request('billno');
        $billnoto = request('billnoto');
        if($billno != '' && $billnoto != ''){
            $selling->whereBetween('selling_inv',[$billno,$billnoto]);  //เปลี่ยนเป็นselect2เลยให้ค้นจากidแทน
        }else{
            if(!empty($name)){
                $selling->where('selling_inv',$billno);
            }
            
            if(!empty($nameto)){
                $selling->where('selling_inv',$billnoto);
            }
        }
        $start = request('datestart');
        $end = request('dateend');
        if($start != '' && $end != ''){
            $selling = $selling->whereBetween('selling_date',[$start,$end]);
        }
        $customergroup = $request->customergroup;
        if(!empty($customergroup)){
            $whereIn = [];
            foreach ($customergroup as $value) {
                $whereIn[]=$value;
            }
            $selling->whereIn('customer_group',$whereIn);
        }

        

        $moneytotalpay = $request->moneytotalpay;
        $moneynotpay = $request->moneynotpay;
        

        if(!empty($moneytotalpay)){
            $selling = $selling->where('selling_totalall',$request->typetotalpay,$moneytotalpay);
        }
        if(!empty($moneynotpay)){
            // $selling = $selling->where('(selling_totalall-selling_totalpayment)',$request->typenotpay,$moneynotpay);
            $selling = $selling->havingRaw('(selling_totalall-billingnotedata_pay)'.$request->typenotpay.' ?',[$moneynotpay]);
        }

        // $typesort = $request->typesort;
        // if(!empty($typesort)){
        //     $selling = $selling->orderBy($typesort,'ASC');
        // }

        $selling = $selling->orderBy('selling_customerid','ASC')->groupBy('selling_id')->get();

        // dd($selling->tosql());
        $moneynotpay = request('moneynotpay');
        $data = [];
        $start = request('datestart');
        $end = request('dateend');

        

        if(!empty($request->datestartduepay)){
            $datestartduepay = strtotime($request->datestartduepay);
        }
        if(!empty($request->dateendduepay)){
            $dateendduepay = strtotime($request->dateendduepay);
        }
        $a = 0;
        $sheet = [];
        $datas = [];
        foreach ($selling as $key => $value) {
            $datecredit = strtotime("+".$value->customer_credit." day",strtotime($value->selling_date));
            if(!empty($request->datestartduepay) && !empty($request->dateendduepay)){
                if($datestartduepay > $datecredit && $dateendduepay < $datecredit){
                    continue;
                }
            }else if(!empty($request->datestartduepay)){
                if($datestartduepay > $datecredit){
                    continue;
                }
            }else if(!empty($request->dateendduepay)){
                if($dateendduepay < $datecredit){
                    continue;
                }
            }
            
            if($value->selling_status == 8){
                $value->selling_status = 'ชำระเรียบร้อย';
            }else if($value->selling_status == 7){
                $value->selling_status = 'มียอดค้างชำระ';
            }else if($value->selling_status == 6){
                $value->selling_status = 'แพ็คของยังไม่ครบ';
            }else if($value->selling_status == 5){
                $value->selling_status = 'จัดขนส่ง';
            }else if($value->selling_status == 4){
                $value->selling_status = 'แพ็คของแล้ว';
            }else if($value->selling_status == 3){
                $value->selling_status = 'ยกเลิก';
            }else if($value->selling_status == 2){
                $value->selling_status = 'บิลชั่วคราว';
            }else if($value->selling_status == 1){
                $value->selling_status = 'เรียบร้อย';
            }else{
                $value->selling_status = '';
            }
            $value->address = " บ้านเลขที่ ".$value->customer_address1." ถนน ". $value->customer_address2 ." แขวง ". $value->customer_address3 ." เขต ". $value->customer_address4 ." จังหวัด ". $value->customer_address5 ." รหัสไปรษณย์ ".$value->customer_address6;

            if($value->selling_vat == 1){
                $value->selling_vat = 'จ่ายเต็ม';
            }else if($value->selling_vat == 2){
                $value->selling_vat = 'จ่ายครึ่ง';
            }else if($value->selling_vat == 0){
                $value->selling_vat = 'ฟรี';
            }else{
                $value->selling_vat = '';
            }
            $datas[] = $value;
            $a++;
            if($a%23 == 0){
                $sheet[] = $datas;
                $datas = [];
            }

        }
        // dd($sheet);
        $groucustomer = [];
        $count = 0;
        foreach ( $selling as $value ) {
            $groucustomer[$value->selling_customerid][] = $value;
        }
        foreach ( $groucustomer as $key => $item) {
            // echo $key.'<br>';
            $groucustomer[$count] = $item;
            unset($groucustomer[$key]);
            $count++;
        }
        // dd($groucustomer[1][count($groucustomer[1])-1]);
        $pdf = PDF::loadView('reportpdf/reportpdfsell',['data' => $groucustomer,'datestart'=>$request->datestart,'dateend'=>$request->dateend,'area'=>[],'status'=>[]],[],['orientation' => 'L', 'format' => 'A4-L']);
        savelog('12','ออกรายงานขายเป็นไฟล์ PDF ');
        return $pdf->stream();
    }
}
