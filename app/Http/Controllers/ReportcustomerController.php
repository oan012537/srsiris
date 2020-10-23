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

class ReportcustomerController extends Controller
{
    public function index(){
        $area = area::all();
        $customer = DB::table('customer')->get();
		return view('report/customer',['area' =>$area,'customergroup'=>'','customer'=>$customer]);
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
        $customernameto = request('customernameto');
        if(!empty($customernameto)){
            $customer->where('customer_name',$customernameto);
        }
        $limitmoney = request('limitmoney');
        if(!empty($limitmoney)){
            $customer->where('customer_creditmoney',$limitmoney);
        }
        $customergroup = request('customergroup');
        if(!empty($customergroup)){
            $customer->where('customer_group',$customergroup);
        }
        $address = request('address');
        if(!empty($address)){
            $customer->where('customer_address1','LIKE','%'.$address.'%');
            $customer->where('customer_address2','LIKE','%'.$address.'%');
            $customer->where('customer_address3','LIKE','%'.$address.'%');
            $customer->where('customer_address4','LIKE','%'.$address.'%');
            $customer->where('customer_address5','LIKE','%'.$address.'%');
            $customer->where('customer_address6','LIKE','%'.$address.'%');
        }
        $tel = request('tel');
        if(!empty($tel)){
            $customer->where('customer_tel',$tel);
        }

        $moneynotpay = request('moneynotpay');
        if(!empty($moneynotpay)){
            $customer->where('tel',$moneynotpay);
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
        $area = area::all();
        $customer = DB::table('customer')->leftjoin('area','area_id','customer_group')->leftjoin('deliverytype','deliverytype_id','customer_typedelivery');
        // if(Auth::user()->position != 1){
        //     $customer->where('customer_group',Auth::user()->groupsell);
        // }
        $customername = request('customername');
        $customernameto = request('customernameto');
        
        if($customername != '' && $customernameto != ''){
            // $customer->whereBetween('customer_name',[$customername,$customernameto]);
            $customer->whereBetween('customer_id',[$customername,$customernameto]);  //เปลี่ยนเป็นselect2เลยให้ค้นจากidแทน
        }else{
            if(!empty($customername)){
                // $customer->where('customer_name',$customername);
                $customer->where('customer_id',$customername);
            }
            
            if(!empty($customernameto)){
                // $customer->where('customer_name',$customernameto);
                $customer->where('customer_id',$customernameto);
            }
        }
        $limitmoney = request('limitmoney');
        if(!empty($limitmoney)){
            $customer->where('customer_creditmoney',$limitmoney);
        }
        $customergroup = request('customergroup');
        if(!empty($customergroup)){
            $wherein = [];
            foreach ($customergroup as $value) {
                $wherein[]=$value;
            }
            $customer->whereIn('customer_group',$wherein);
            // dd($customer->toSql());
        }
        
        // $address = request('address');
        // if(!empty($address)){
        //     $customer->where('customer_address1','LIKE','%'.$address.'%');
        //     $customer->where('customer_address2','LIKE','%'.$address.'%');
        //     $customer->where('customer_address3','LIKE','%'.$address.'%');
        //     $customer->where('customer_address4','LIKE','%'.$address.'%');
        //     $customer->where('customer_address5','LIKE','%'.$address.'%');
        //     $customer->where('customer_address6','LIKE','%'.$address.'%');
        // }
        // $tel = request('tel');
        // if(!empty($tel)){
        //     $customer->where('customer_tel',$tel);
        // }

        // $moneynotpay = request('moneynotpay');
        // if(!empty($moneynotpay)){
        //     $customer->where('tel',$moneynotpay);
        // }
        // dd($customer->toSql());
        $customer = $customer->get();
        // dd($customer);
        $moneynotpay = request('moneynotpay');
        $data = [];
        $start = request('datestart');
        $end = request('dateend');

        $arrayhead = ['ลำดับที่','ชื่อลูกค้า'];
        $datacustomer = [];
        if(!empty($request->checkcustomergroup)){
            $arrayhead[] = $request->checkcustomergroup;
        }
        if(!empty($request->address)){
            $arrayhead[] = $request->address;
        }
        if(!empty($request->tel)){
            $arrayhead[] = $request->tel;
        }
        if(!empty($request->idtax)){
            $arrayhead[] = $request->idtax;
        }
        if(!empty($request->latlong)){
            $arrayhead[] = $request->latlong;
        }
        // if(!empty($request->long)){
        //     $arrayhead[] = $request->long;
        // }
        if(!empty($request->email)){
            $arrayhead[] = $request->email;
        }
        if(!empty($request->credit)){
            $arrayhead[] = $request->credit;
        }
        if(!empty($request->creditmoney)){
            $arrayhead[] = $request->creditmoney;
        }
        if(!empty($request->vat)){
            $arrayhead[] = $request->vat;
        }
        if(!empty($request->typedelivery)){
            $arrayhead[] = $request->typedelivery;
        }
        if(!empty($request->rate)){
            $arrayhead[] = $request->rate;
        }
        if(!empty($request->rateshiping)){
            $arrayhead[] = $request->rateshiping;
        }
        if(!empty($request->note)){
            $arrayhead[] = $request->note;
        }
        if(!empty($request->notpay)){
            $arrayhead[] = $request->notpay;
        }
        if(!empty($request->total)){
            $arrayhead[] = $request->total;
        }

        $typepay = $request->typepay;
        foreach ($customer as $key => $value) {
            if($value->customer_vat == 1){
                $value->customer_vat = 'Exclude Vat';
            }else if($value->customer_vat == 2){
                $value->customer_vat = 'Include Vat';
            }else if($value->customer_vat == 0){
                $value->customer_vat = 'No Vat';
            }else{
                $value->customer_vat = '';
            }

            if($value->customer_rateshiping == 1){
                $value->customer_rateshiping = 'จ่ายเต็ม';
            }else if($value->customer_rateshiping == 2){
                $value->customer_rateshiping = 'จ่ายครึ่ง';
            }else if($value->customer_rateshiping == 0){
                $value->customer_rateshiping = 'ฟรี';
            }else{
                $value->customer_rateshiping = '';
            }
            $value->location = " บ้านเลขที่ ".$value->customer_address1." ถนน ". $value->customer_address2 ." แขวง ". $value->customer_address3 ." เขต ". $value->customer_address4 ." จังหวัด ". $value->customer_address5 ." รหัสไปรษณย์ ".$value->customer_address6;

            $datatotal = DB::table('customer')->leftjoin('selling','selling_customerid','customer_id')->select(DB::raw('IFNULL(SUM(selling_totalpayment),0) as totalpayment'))->where('customer_id',$value->customer_id)->whereBetween('selling_date',[$start,$end])->first();
            $datanopay = DB::table('customer')->leftjoin('selling','selling_customerid','customer_id')->select(DB::raw('IFNULL(SUM(selling_totalpayment),0) as totalpayment'))->where('customer_id',$value->customer_id)->where('selling_status',7)->whereBetween('selling_date',[$start,$end])->first();  //จัดบิลเก็บแล้วยังไม่จ่าย
            $datapay = DB::table('customer')->leftjoin('selling','selling_customerid','customer_id')->select(DB::raw('IFNULL(SUM(selling_totalpayment),0) as totalpayment'))->where('customer_id',$value->customer_id)->where('selling_status',8)->whereBetween('selling_date',[$start,$end])->first();  //จัดบิลเก็บแล้วยังจ่าย
            if($typepay != ''){
                $datatypepay = DB::table('customer')->leftjoin('selling','selling_customerid','customer_id')->select(DB::raw('selling_typepay'))->where('customer_id',$value->customer_id)->where('selling_typepay',$typepay)->whereBetween('selling_date',[$start,$end])->count();
                if($datatypepay == 0){
                    continue;
                }
            }
            

            $datas = [];
            $datas[] = $key+1;
            $datas[] = $value->customer_name;

            if(!empty($request->checkcustomergroup)){
                $datas[] = $value->area_name;
            }
            if(!empty($request->address)){
                $datas[] = $value->location;
            }
            if(!empty($request->tel)){
                $datas[] = $value->customer_tel;
            }
            if(!empty($request->idtax)){
                $datas[] = $value->customer_idtax;
            }
            if(!empty($request->latlong)){
                $datas[] = $value->lat.','.$value->lng;
            }
            // if(!empty($request->long)){
            //     $datas[] = $value->lng;
            // }
            if(!empty($request->email)){
                $datas[] = $value->customer_email;
            }
            if(!empty($request->credit)){
                $datas[] = $value->customer_credit;
            }
            if(!empty($request->creditmoney)){
                $datas[] = $value->customer_creditmoney;
            }
            if(!empty($request->vat)){
                $datas[] = $value->customer_vat;
            }
            if(!empty($request->typedelivery)){
                $datas[] = $value->deliverytype_name;
            }
            if(!empty($request->rate)){
                $datas[] = $value->customer_rate;
            }
            if(!empty($request->rateshiping)){
                $datas[] = $value->customer_rateshiping;
            }
            if(!empty($request->note)){
                $datas[] = $value->customer_note;
            }
            if(!empty($request->notpay)){
                $datas[] = $datanopay->totalpayment;
            }
            if(!empty($request->total)){
                $datas[] = $datatotal->totalpayment;
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
                    $datacustomer[] = $datas;
                }
            }else{
                $datacustomer[] = $datas;
            }

        }
        // $customer = $data;
        $responsedata = [];
        $responsedata['head'] = $arrayhead;
        $responsedata['data'] = $datacustomer;
        return Response::json($responsedata);
        // return view('report/customer',['data'=>$customer,'area'=>$area,'customergroup'=>$customergroup]);
    }

    public function reportexcel(Request $request){

        $customer = DB::table('customer')->leftjoin('area','area_id','customer_group')->leftjoin('deliverytype','deliverytype_id','customer_typedelivery');
        $customername = $request->customername;
        $customernameto = $request->customernameto;
        if($customername != '' && $customernameto != ''){
            $customer->whereBetween('customer_id',[$customername,$customernameto]);
        }else{
            if(!empty($customername)){
                $customer->where('customer_name','LIKE','%'.$customername.'%');
            }
            
            if(!empty($customernameto)){
                $customer->where('customer_name','LIKE','%'.$customernameto.'%');
            }
        }
        
        $limitmoney = $request->limitmoney;
        if(!empty($limitmoney)){
            $customer->where('customer_creditmoney',$limitmoney);
        }
        $customergroup = $request->customergroup;
        if(!empty($customergroup)){
            // $customer->where('customer_group',$customergroup);
            $xxxx = [];
            foreach ($customergroup as $value) {
                $xxxx[]=$value;
            }
            $customer->whereIn('customer_group',$xxxx);
        }

        // $customer = $customer->select(
        //     'customer_id',
        //     'customer_name',
        //     'customer_idtax',
        //     'location',
        //     'customer_tel',
        //     'customer_email',
        //     'area_name',
        //     'customer_vat',
        //     'customer_rateshiping',
        //     'customer_note'
        // )->get();
        $customer = $customer->get();

        $arrayhead = ['ลำดับที่','ชื่อลูกค้า'];
        if(!empty($request->checkcustomergroup)){
            $arrayhead[] = $request->checkcustomergroup;
        }
        if(!empty($request->address)){
            $arrayhead[] = $request->address;
        }
        if(!empty($request->tel)){
            $arrayhead[] = $request->tel;
        }
        if(!empty($request->idtax)){
            $arrayhead[] = $request->idtax;
        }
        if(!empty($request->latlong)){
            $arrayhead[] = $request->latlong;
        }
        // if(!empty($request->long)){
        //     $arrayhead[] = $request->long;
        // }
        if(!empty($request->email)){
            $arrayhead[] = $request->email;
        }
        if(!empty($request->credit)){
            $arrayhead[] = $request->credit;
        }
        if(!empty($request->creditmoney)){
            $arrayhead[] = $request->creditmoney;
        }
        if(!empty($request->vat)){
            $arrayhead[] = $request->vat;
        }
        if(!empty($request->typedelivery)){
            $arrayhead[] = $request->typedelivery;
        }
        if(!empty($request->rate)){
            $arrayhead[] = $request->rate;
        }
        if(!empty($request->rateshiping)){
            $arrayhead[] = $request->rateshiping;
        }
        if(!empty($request->note)){
            $arrayhead[] = $request->note;
        }
        if(!empty($request->notpay)){
            $arrayhead[] = $request->notpay;
        }
        if(!empty($request->total)){
            $arrayhead[] = $request->total;
        }
        $colunmhead = "A";
        $moneynotpay = request('moneynotpay');
        $datacustomer = [];
        $start = request('datestart');
        $end = request('dateend');
        $typepay = $request->typepay;
        foreach ($customer as $key => $value) { //เช็คค่าในarrayก่อนว่าสถานะอะไร
            // echo $key." : ".$value->status."<br>";
            if($value->customer_vat == 1){
                $value->customer_vat = 'Exclude Vat';
            }else if($value->customer_vat == 2){
                $value->customer_vat = 'Include Vat';
            }else if($value->customer_vat == 0){
                $value->customer_vat = 'No Vat';
            }else{
                $value->customer_vat = '';
            }

            if($value->customer_rateshiping == 1){
                $value->customer_rateshiping = 'จ่ายเต็ม';
            }else if($value->customer_rateshiping == 2){
                $value->customer_rateshiping = 'จ่ายครึ่ง';
            }else if($value->customer_rateshiping == 0){
                $value->customer_rateshiping = 'ฟรี';
            }else{
                $value->customer_rateshiping = '';
            }
            // $data = DB::table('customer')->where('customer_id',$value->customer_id)->first();
            $value->location = " บ้านเลขที่ ".$value->customer_address1." ถนน ". $value->customer_address2 ." แขวง ". $value->customer_address3 ." เขต ". $value->customer_address4 ." จังหวัด ". $value->customer_address5 ." รหัสไปรษณย์ ".$value->customer_address6;
            $value->customer_id = $key+1;
            $datatotal = DB::table('customer')->leftjoin('selling','selling_customerid','customer_id')->select(DB::raw('SUM(selling_totalpayment) as totalpayment'))->where('customer_id',$value->customer_id)->whereBetween('selling_date',[$start,$end])->first();
            $datanopay = DB::table('customer')->leftjoin('selling','selling_customerid','customer_id')->select(DB::raw('SUM(selling_totalpayment) as totalpayment'))->where('customer_id',$value->customer_id)->where('selling_status',7)->whereBetween('selling_date',[$start,$end])->first();  //จัดบิลเก็บแล้วยังไม่จ่าย
            $datapay = DB::table('customer')->leftjoin('selling','selling_customerid','customer_id')->select(DB::raw('SUM(selling_totalpayment) as totalpayment'))->where('customer_id',$value->customer_id)->where('selling_status',8)->whereBetween('selling_date',[$start,$end])->first();  //จัดบิลเก็บแล้วยังจ่าย

            if($typepay != ''){
                $datatypepay = DB::table('customer')->leftjoin('selling','selling_customerid','customer_id')->select(DB::raw('selling_typepay'))->where('customer_id',$value->customer_id)->where('selling_typepay',$typepay)->whereBetween('selling_date',[$start,$end])->count();
                if($datatypepay == 0){
                    continue;
                }
            }

            $datas = [];
            $datas[] = $key+1;
            $datas[] = $value->customer_name;
            // $datas[] = $value->customer_idtax;
            // $datas[] = $value->location;
            // $datas[] = $value->customer_tel;
            // $datas[] = $value->customer_email;
            // $datas[] = $value->area_name;
            // $datas[] = $value->customer_vat;
            // $datas[] = $value->customer_rateshiping;
            // $datas[] = $value->customer_note;
            // $datas[] = $datanopay->totalpayment;
            // $datas[] = $datatotal->totalpayment;

            if(!empty($request->checkcustomergroup)){
                $datas[] = $value->area_name;
            }
            if(!empty($request->address)){
                $datas[] = $value->location;
            }
            if(!empty($request->tel)){
                $datas[] = $value->customer_tel;
            }
            if(!empty($request->idtax)){
                $datas[] = $value->customer_idtax;
            }
            if(!empty($request->lat)){
                $datas[] = $value->lat.','.$value->lng;
            }
            // if(!empty($request->long)){
            //     $datas[] = $value->lng;
            // }
            if(!empty($request->email)){
                $datas[] = $value->customer_email;
            }
            if(!empty($request->credit)){
                $datas[] = $value->customer_credit;
            }
            if(!empty($request->creditmoney)){
                $datas[] = $value->customer_creditmoney;
            }
            if(!empty($request->vat)){
                $datas[] = $value->customer_vat;
            }
            if(!empty($request->typedelivery)){
                $datas[] = $value->deliverytype_name;
            }
            if(!empty($request->rate)){
                $datas[] = $value->customer_rate;
            }
            if(!empty($request->rateshiping)){
                $datas[] = $value->customer_rateshiping;
            }
            if(!empty($request->note)){
                $datas[] = $value->customer_note;
            }
            if(!empty($request->notpay)){
                $datas[] = $datanopay->totalpayment;
            }
            if(!empty($request->total)){
                $datas[] = $datatotal->totalpayment;
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
                    $datacustomer[] = $datas;
                }
            }else{
                $datacustomer[] = $datas;
            }
        }
        // dd($datacustomer);
        // return $datename;
        $datename = date('d_m_Y_H_i_s');
        
        $fileexcel = Excel::create('รายงานลูกค้า'.$datename, function ($excel) use ($datacustomer,$arrayhead,$colunmhead){
            
            $excel->sheet('รายงานลูกค้า', function ($sheet) use ($datacustomer,$arrayhead,$colunmhead){
                // dd($customer);
                $sheet->fromArray($datacustomer);
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
        savelog('12','ออกรายงานลูกค้าเป็นไฟล์ Excel ');
        // dd($fileexcel);
        $fileexcel->download('xlsx');
        
        // return view('backend.delivery.report',["data"=>$deliverydata,"date"=>$request->input('date')]);
    }
	
    public function reportpdf(Request $request){
        $area = area::all();
        $customer = DB::table('customer')->leftjoin('area','area_id','customer_group')->leftjoin('deliverytype','deliverytype_id','customer_typedelivery');
        // if(Auth::user()->position != 1){
        //     $customer->where('customer_group',Auth::user()->groupsell);
        // }
        $customername = request('customername');
        $customernameto = request('customernameto');
        
        if($customername != '' && $customernameto != ''){
            // $customer->whereBetween('customer_name',[$customername,$customernameto]);
            $customer->whereBetween('customer_id',[$customername,$customernameto]);  //เปลี่ยนเป็นselect2เลยให้ค้นจากidแทน
        }else{
            if(!empty($customername)){
                // $customer->where('customer_name',$customername);
                $customer->where('customer_id',$customername);
            }
            
            if(!empty($customernameto)){
                // $customer->where('customer_name',$customernameto);
                $customer->where('customer_id',$customernameto);
            }
        }
        $limitmoney = request('limitmoney');
        if(!empty($limitmoney)){
            $customer->where('customer_creditmoney',$limitmoney);
        }
        $customergroup = request('customergroup');
        if(!empty($customergroup)){
            $wherein = [];
            foreach ($customergroup as $value) {
                $wherein[]=$value;
            }
            $customer->whereIn('customer_group',$wherein);
            // dd($customer->toSql());
        }
        
        // dd($customer->toSql());
        $customer = $customer->get();
        // dd($customer);
        $moneynotpay = request('moneynotpay');
        $data = [];
        $start = request('datestart');
        $end = request('dateend');

        $arrayhead = ['ลำดับที่','ชื่อลูกค้า'];
        $datacustomer = [];
        if(!empty($request->checkcustomergroup)){
            $arrayhead[] = $request->checkcustomergroup;
        }
        if(!empty($request->address)){
            $arrayhead[] = $request->address;
        }
        if(!empty($request->tel)){
            $arrayhead[] = $request->tel;
        }
        if(!empty($request->idtax)){
            $arrayhead[] = $request->idtax;
        }
        if(!empty($request->latlong)){
            $arrayhead[] = $request->latlong;
        }
        // if(!empty($request->long)){
        //     $arrayhead[] = $request->long;
        // }
        if(!empty($request->email)){
            $arrayhead[] = $request->email;
        }
        if(!empty($request->credit)){
            $arrayhead[] = $request->credit;
        }
        if(!empty($request->creditmoney)){
            $arrayhead[] = $request->creditmoney;
        }
        if(!empty($request->vat)){
            $arrayhead[] = $request->vat;
        }
        if(!empty($request->typedelivery)){
            $arrayhead[] = $request->typedelivery;
        }
        if(!empty($request->rate)){
            $arrayhead[] = $request->rate;
        }
        if(!empty($request->rateshiping)){
            $arrayhead[] = $request->rateshiping;
        }
        if(!empty($request->note)){
            $arrayhead[] = $request->note;
        }
        if(!empty($request->notpay)){
            $arrayhead[] = $request->notpay;
        }
        if(!empty($request->total)){
            $arrayhead[] = $request->total;
        }

        $typepay = $request->typepay;
        $count = 0;
        foreach ($customer as $key => $value) {
            if($value->customer_vat == 1){
                $value->customer_vat = 'Exclude Vat';
            }else if($value->customer_vat == 2){
                $value->customer_vat = 'Include Vat';
            }else if($value->customer_vat == 0){
                $value->customer_vat = 'No Vat';
            }else{
                $value->customer_vat = '';
            }

            if($value->customer_rateshiping == 1){
                $value->customer_rateshiping = 'จ่ายเต็ม';
            }else if($value->customer_rateshiping == 2){
                $value->customer_rateshiping = 'จ่ายครึ่ง';
            }else if($value->customer_rateshiping == 0){
                $value->customer_rateshiping = 'ฟรี';
            }else{
                $value->customer_rateshiping = '';
            }
            $value->location = " บ้านเลขที่ ".$value->customer_address1." ถนน ". $value->customer_address2 ." แขวง ". $value->customer_address3 ." เขต ". $value->customer_address4 ." จังหวัด ". $value->customer_address5 ." รหัสไปรษณย์ ".$value->customer_address6;

            $datatotal = DB::table('customer')->leftjoin('selling','selling_customerid','customer_id')->select(DB::raw('IFNULL(SUM(selling_totalpayment),0) as totalpayment'))->where('customer_id',$value->customer_id)->whereBetween('selling_date',[$start,$end])->first();
            $datanopay = DB::table('customer')->leftjoin('selling','selling_customerid','customer_id')->select(DB::raw('IFNULL(SUM(selling_totalpayment),0) as totalpayment'))->where('customer_id',$value->customer_id)->where('selling_status',7)->whereBetween('selling_date',[$start,$end])->first();  //จัดบิลเก็บแล้วยังไม่จ่าย
            $datapay = DB::table('customer')->leftjoin('selling','selling_customerid','customer_id')->select(DB::raw('IFNULL(SUM(selling_totalpayment),0) as totalpayment'))->where('customer_id',$value->customer_id)->where('selling_status',8)->whereBetween('selling_date',[$start,$end])->first();  //จัดบิลเก็บแล้วยังจ่าย
            if($typepay != ''){
                $datatypepay = DB::table('customer')->leftjoin('selling','selling_customerid','customer_id')->select(DB::raw('selling_typepay'))->where('customer_id',$value->customer_id)->where('selling_typepay',$typepay)->whereBetween('selling_date',[$start,$end])->count();
                if($datatypepay == 0){
                    unset($customer[$key]);
                    continue;
                }
            }
            

            $datas = [];
            $datas[] = $key+1;
            $value->profile = 'ชื่อ '.$value->customer_name;

            if(!empty($request->checkcustomergroup)){
                $value->profile .= ' กลุ่มลูกค้า '.$value->area_name;
            }
            if(!empty($request->address)){
                $value->profile .= ' ที่อยู่ '.$value->location;
            }
            if(!empty($request->tel)){
                $datas[] = $value->customer_tel;
            }
            if(!empty($request->idtax)){
                $value->profile .= ' เลขประจำตัวผู้เสียภาษีอากร '.$value->customer_idtax;
            }
            if(!empty($request->latlong)){
                $value->profile .= ' ละติจูด,ลองจิจูด '.$value->lat.','.$value->lng;
            }
            if(!empty($request->email)){
                $value->profile .= ' อีเมล์ '. $value->customer_email;
            }
            if(!empty($request->credit)){
                $value->profile .= ' เครดิต '.$value->customer_credit;
            }
            if(!empty($request->creditmoney)){
                $value->profile .=  ' เครดิตเงินที่ค้างได้ '.$value->customer_creditmoney;
            }
            if(!empty($request->vat)){
                $datas[] = $value->customer_vat;
            }
            if(!empty($request->typedelivery)){
                $datas[] = $value->deliverytype_name;
            }
            if(!empty($request->rate)){
                $datas[] =  ' เครดิต '.$value->customer_rate;
            }
            if(!empty($request->rateshiping)){
                $datas[] = $value->customer_rateshiping;
            }
            if(!empty($request->note)){
                $datas[] = $value->customer_note;
            }
            // if(!empty($request->notpay)){
                $value->totalpayment = $datanopay->totalpayment;
            // }
            // if(!empty($request->total)){
                $value->totalpayment = $datatotal->totalpayment;
            // }
            
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
                    $customer[$count] = $customer[$key];
                    unset($customer[$key]);
                    $count++;
                }else{
                    unset($customer[$key]);
                }
            }else{
                $datacustomer[] = $datas;
            }

        }
        // $customer = $data;
        $responsedata = [];
        $responsedata['head'] = $arrayhead;
        $responsedata['data'] = $datacustomer;

        $pdf = PDF::loadView('reportpdf/reportpdfcustomer',['head' => $arrayhead,'data' => $customer,'datestart'=> date("d/m/Y",strtotime($request->datestart)),'dateend'=>date("d/m/Y",strtotime($request->dateend))],[],['orientation' => 'L', 'format' => 'A4-L']);
        savelog('12','ออกรายงานลูกค้าเป็นไฟล์ PDF ');
        return $pdf->stream();
    }
}
