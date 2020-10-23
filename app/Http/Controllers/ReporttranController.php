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

class ReporttranController extends Controller
{
    public function index(){
        $area = area::all();
		return view('report/reporttransport',['area' =>$area]);
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
        $selling = DB::table('transport')->leftjoin('sub_tran','sub_tran.sub_ref','transport.trans_id')->leftjoin('selling','selling.selling_id','sub_tran.sub_order')->leftjoin('customer','customer.customer_id','selling.selling_customerid')->leftjoin('area','customer.customer_group','area.area_id')->select(DB::raw('*'));
        // ->leftjoin('selling_detail','selling.selling_id','selling_detail.sellingdetail_ref')->leftjoin('product','product.product_id','selling_detail.sellingdetail_productid')->leftjoin('orders','orders.order_id','selling_detail.sellingdetail_sellingref')

        $datestart = request('datestart');
        $dateend = request('dateend');
        if($datestart != '' && $dateend != ''){
            $selling = $selling->whereBetween('trans_date',[$datestart,$dateend]);
        }else if($datestart != ''){
            $selling = $selling->where('trans_date','>',$datestart);
        }else{
            $selling = $selling->where('trans_date','<',$dateend);
        }
        // if(Auth::user()->position != 1){
        //     $customer->where('customer_group',Auth::user()->groupsell);
        // }
        $billno = request('billno');
        $billnoto = request('billnoto');
        if($billno != '' && $billnoto != ''){
            $selling->whereBetween('trans_invoice',[$billno,$billnoto]);  //เปลี่ยนเป็นselect2เลยให้ค้นจากidแทน
        }else{
            if(!empty($name)){
                $selling->where('trans_invoice',$billno);
            }
            
            if(!empty($nameto)){
                $selling->where('trans_invoice',$billnoto);
            }
        }
        $status = $request->status;
        if($status != '' ){
            if($status == 4){
                $selling = $selling->where('trans_status',1);
            }else if($status == 3){
                $selling = $selling->where('trans_status',2);
            }else if($status == 2){
                $selling = $selling->where('selling_status',4);
            }else if($status == 1){
                $selling = $selling->where('trans_status',1)->where('selling_statuspacking','=','');
            }
        }
        

        

        $selling = $selling->get();

        // dd($selling->tosql());
        // $moneynotpay = request('moneynotpay');
        $data = [];
        // $start = request('datestart');
        // $end = request('dateend');

        $arrayhead = ['ลำดับที่','เลขที่บิลจัดส่ง'];
        $countdate = 1;
        $datasup = [];
        if(!empty($request->showdate)){
            $arrayhead[] = $request->showdate;
        }
        if(!empty($request->showsellingbill)){
            $arrayhead[] = $request->showsellingbill;
        }
        if(!empty($request->showcustomername)){
            $arrayhead[] = $request->showcustomername;
        }
        if(!empty($request->showdetailts)){
            $arrayhead[] = $request->showdetailts;
            
        }
        if(!empty($request->showunit)){
            $arrayhead[] = 'กล่อง';
            $arrayhead[] = 'ห่อ';
            $arrayhead[] = 'มัด';
            $arrayhead[] = 'กระสอบ';
        }
        if(!empty($request->showstatus)){
            $arrayhead[] = $request->showstatus;
        }

        
        foreach ($selling as $key => $value) {
            
            $datas = [];
            $datas[] = $key+1;
            $datas[] = $value->trans_invoice;

            if(!empty($request->showdate)){
                $datas[] = $value->trans_delivery;
            }
            if(!empty($request->showsellingbill)){
                $datas[] = $value->selling_inv;
            }
            if(!empty($request->showcustomername)){
                $datas[] = $value->selling_customername;
            }
            if(!empty($request->showdetailts)){
                $datas[] = $value->trans_emp.' '.$value->trans_truck.' '.$value->trans_truckid;
            }
            if(!empty($request->showunit)){
                $datas[] = $value->selling_typeunit1;
                $datas[] = $value->selling_typeunit2;
                $datas[] = $value->selling_typeunit3;
                $datas[] = $value->selling_typeunit4;
            }
            if(!empty($request->showstatus)){
                if($value->trans_status == '1'){
                    $datas[] = 'ส่งเรียบร้อยแล้ว';
                }else if($value->trans_status == '0'){
                    $datas[] = 'รอขนส่ง';
                }else if($value->trans_status == '2'){
                    $datas[] = 'กำลังส่ง';
                }else{
                    $datas[] = '';
                }
                
            }

            $datasup[] = $datas;
        }

        $order = DB::table('export')->where('export_status',0);
        if($datestart != '' && $dateend != ''){
            $order = $order->whereBetween('export_date',[$datestart,$dateend]);
        }else if($datestart != ''){
            $order = $order->where('export_date','>',$datestart);
        }else{
            $order = $order->where('export_date','<',$dateend);
        }
        $order = $order->get();
        foreach ($order as $key => $value) {
            $count = count($datasup);
            $datas = [];
            $datas[] = $count+1;
            $datas[] = '';
            $datas[] = '';

            if(!empty($request->showdate)){
                // $datas[] = 'ออเดอร์';
            }
            if(!empty($request->showsellingbill)){
                $datas[] = $value->export_inv;
            }
            if(!empty($request->showcustomername)){
                $datas[] = $value->export_customername;
            }
            if(!empty($request->showdetailts)){
                $datas[] = '';
            }
            if(!empty($request->showunit)){
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
            }
            if(!empty($request->showstatus)){
                $datas[] = 'ออเดอร์';
            }
            $datasup[] = $datas;
        }

        $selling = DB::table('selling')->where('selling_status',1)->where('selling_statuspacking','');
        if($datestart != '' && $dateend != ''){
            $selling = $selling->whereBetween('selling_date',[$datestart,$dateend]);
        }else if($datestart != ''){
            $selling = $selling->where('selling_date','>',$datestart);
        }else{
            $selling = $selling->where('selling_date','<',$dateend);
        }
        $selling = $selling->get();
        foreach ($selling as $key => $value) {
            $count = count($datasup);
            $datas = [];
            $datas[] = $count+1;
            $datas[] = '';
            $datas[] = '';

            if(!empty($request->showdate)){
                // $datas[] = 'เปิดบิล';
            }
            if(!empty($request->showsellingbill)){
                $datas[] = $value->selling_inv;
            }
            if(!empty($request->showcustomername)){
                $datas[] = $value->selling_customername;
            }
            if(!empty($request->showdetailts)){
                $datas[] = '';
            }
            if(!empty($request->showunit)){
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
            }
            if(!empty($request->showstatus)){
                $datas[] = 'เปิดบิล';
            }
            $datasup[] = $datas;
        }

        $packing = DB::table('selling')->where('selling_status',4);
        if($datestart != '' && $dateend != ''){
            $packing = $packing->whereBetween('selling_date',[$datestart,$dateend]);
        }else if($datestart != ''){
            $packing = $packing->where('selling_date','>',$datestart);
        }else{
            $packing = $packing->where('selling_date','<',$dateend);
        }
        $packing = $packing->get();
        foreach ($packing as $key => $value) {
            $count = count($datasup);
            $datas = [];
            $datas[] = $count+1;
            $datas[] = '';
            $datas[] = '';

            if(!empty($request->showdate)){
                // $datas[] = 'แพ็กของ';
            }
            if(!empty($request->showsellingbill)){
                $datas[] = $value->selling_inv;
            }
            if(!empty($request->showcustomername)){
                $datas[] = $value->selling_customername;
            }
            if(!empty($request->showdetailts)){
                $datas[] = '';
            }
            if(!empty($request->showunit)){
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
            }
            if(!empty($request->showstatus)){
                $datas[] = 'แพ็กของ';
            }
            $datasup[] = $datas;
        }

        $incar = DB::table('selling')->where('selling_status',5);
        if($datestart != '' && $dateend != ''){
            $incar = $incar->whereBetween('selling_date',[$datestart,$dateend]);
        }else if($datestart != ''){
            $incar = $incar->where('selling_date','>',$datestart);
        }else{
            $incar = $incar->where('selling_date','<',$dateend);
        }
        $incar = $incar->get();
        foreach ($incar as $key => $value) {
            $count = count($datasup);
            $datas = [];
            $datas[] = $count+1;
            $datas[] = '';
            $datas[] = '';

            if(!empty($request->showdate)){
                // $datas[] = 'แพ็กของ';
            }
            if(!empty($request->showsellingbill)){
                $datas[] = $value->selling_inv;
            }
            if(!empty($request->showcustomername)){
                $datas[] = $value->selling_customername;
            }
            if(!empty($request->showdetailts)){
                $datas[] = '';
            }
            if(!empty($request->showunit)){
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
            }
            if(!empty($request->showstatus)){
                $datas[] = 'ขึ้นรถ';
            }
            $datasup[] = $datas;
        }

        $responsedata = [];
        $responsedata['head'] = $arrayhead;
        $responsedata['data'] = $datasup;
        return Response::json($responsedata);
    }

    public function reportexcel(Request $request){

        $selling = DB::table('transport')->leftjoin('sub_tran','sub_tran.sub_ref','transport.trans_id')->leftjoin('selling','selling.selling_id','sub_tran.sub_order')->leftjoin('customer','customer.customer_id','selling.selling_customerid')->leftjoin('area','customer.customer_group','area.area_id')->select(DB::raw('*'));

        $datestart = request('datestart');
        $dateend = request('dateend');
        if($datestart != '' && $dateend != ''){
            $selling = $selling->whereBetween('trans_date',[$datestart,$dateend]);
        }else if($datestart != ''){
            $selling = $selling->where('trans_date','>',$datestart);
        }else{
            $selling = $selling->where('trans_date','<',$dateend);
        }

        $billno = request('billno');
        $billnoto = request('billnoto');
        if($billno != '' && $billnoto != ''){
            $selling->whereBetween('trans_invoice',[$billno,$billnoto]);  //เปลี่ยนเป็นselect2เลยให้ค้นจากidแทน
        }else{
            if(!empty($name)){
                $selling->where('trans_invoice',$billno);
            }
            
            if(!empty($nameto)){
                $selling->where('trans_invoice',$billnoto);
            }
        }
        $status = $request->status;
        if($status != '' ){
            if($status == 4){
                $selling = $selling->where('trans_status',1);
            }else if($status == 3){
                $selling = $selling->where('trans_status',2);
            }else if($status == 2){
                $selling = $selling->where('selling_status',4);
            }else if($status == 1){
                $selling = $selling->where('trans_status',1)->where('selling_statuspacking','=','');
            }
        }

        $selling = $selling->get();

        $data = [];


        $arrayhead = ['ลำดับที่','เลขที่บิลจัดส่ง'];
        $countdate = 1;
        $datasup = [];
        if(!empty($request->showdate)){
            $arrayhead[] = $request->showdate;
        }
        if(!empty($request->showsellingbill)){
            $arrayhead[] = $request->showsellingbill;
        }
        if(!empty($request->showcustomername)){
            $arrayhead[] = $request->showcustomername;
        }
        if(!empty($request->showdetailts)){
            $arrayhead[] = $request->showdetailts;
            
        }
        if(!empty($request->showunit)){
            $arrayhead[] = 'กล่อง';
            $arrayhead[] = 'ห่อ';
            $arrayhead[] = 'มัด';
            $arrayhead[] = 'กระสอบ';
        }
        if(!empty($request->showstatus)){
            $arrayhead[] = $request->showstatus;
        }

        
        foreach ($selling as $key => $value) {
            
            $datas = [];
            $datas[] = $key+1;
            $datas[] = $value->trans_invoice;

            if(!empty($request->showdate)){
                $datas[] = $value->trans_delivery;
            }
            if(!empty($request->showsellingbill)){
                $datas[] = $value->selling_inv;
            }
            if(!empty($request->showcustomername)){
                $datas[] = $value->selling_customername;
            }
            if(!empty($request->showdetailts)){
                $datas[] = $value->trans_emp.' '.$value->trans_truck.' '.$value->trans_truckid;
            }
            if(!empty($request->showunit)){
                $datas[] = $value->selling_typeunit1;
                $datas[] = $value->selling_typeunit2;
                $datas[] = $value->selling_typeunit3;
                $datas[] = $value->selling_typeunit4;
            }
            if(!empty($request->showstatus)){
                if($value->trans_status == '1'){
                    $datas[] = 'ส่งเรียบร้อยแล้ว';
                }else if($value->trans_status == '0'){
                    $datas[] = 'รอขนส่ง';
                }else if($value->trans_status == '2'){
                    $datas[] = 'กำลังส่ง';
                }else{
                    $datas[] = '';
                }
                
            }

            $datasup[] = $datas;
        }

        $order = DB::table('export')->where('export_status',0);
        if($datestart != '' && $dateend != ''){
            $order = $order->whereBetween('export_date',[$datestart,$dateend]);
        }else if($datestart != ''){
            $order = $order->where('export_date','>',$datestart);
        }else{
            $order = $order->where('export_date','<',$dateend);
        }
        $order = $order->get();
        foreach ($order as $key => $value) {
            $count = count($datasup);
            $datas = [];
            $datas[] = $count+1;
            $datas[] = '';
            

            if(!empty($request->showdate)){
                $datas[] = '';
            }
            if(!empty($request->showsellingbill)){
                $datas[] = $value->export_inv;
            }
            if(!empty($request->showcustomername)){
                $datas[] = $value->export_customername;
            }
            if(!empty($request->showdetailts)){
                $datas[] = '';
            }
            if(!empty($request->showunit)){
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
            }
            if(!empty($request->showstatus)){
                $datas[] = 'ออเดอร์';
            }
            $datasup[] = $datas;
        }

        $selling = DB::table('selling')->where('selling_status',1)->where('selling_statuspacking','');
        if($datestart != '' && $dateend != ''){
            $selling = $selling->whereBetween('selling_date',[$datestart,$dateend]);
        }else if($datestart != ''){
            $selling = $selling->where('selling_date','>',$datestart);
        }else{
            $selling = $selling->where('selling_date','<',$dateend);
        }
        $selling = $selling->get();
        foreach ($selling as $key => $value) {
            $count = count($datasup);
            $datas = [];
            $datas[] = $count+1;
            $datas[] = '';

            if(!empty($request->showdate)){
                $datas[] = '';
            }
            if(!empty($request->showsellingbill)){
                $datas[] = $value->selling_inv;
            }
            if(!empty($request->showcustomername)){
                $datas[] = $value->selling_customername;
            }
            if(!empty($request->showdetailts)){
                $datas[] = '';
            }
            if(!empty($request->showunit)){
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
            }
            if(!empty($request->showstatus)){
                $datas[] = 'เปิดบิล';
            }
            $datasup[] = $datas;
        }

        $packing = DB::table('selling')->where('selling_status',4);
        if($datestart != '' && $dateend != ''){
            $packing = $packing->whereBetween('selling_date',[$datestart,$dateend]);
        }else if($datestart != ''){
            $packing = $packing->where('selling_date','>',$datestart);
        }else{
            $packing = $packing->where('selling_date','<',$dateend);
        }
        $packing = $packing->get();
        foreach ($packing as $key => $value) {
            $count = count($datasup);
            $datas = [];
            $datas[] = $count+1;
            $datas[] = '';

            if(!empty($request->showdate)){
                $datas[] = '';
            }
            if(!empty($request->showsellingbill)){
                $datas[] = $value->selling_inv;
            }
            if(!empty($request->showcustomername)){
                $datas[] = $value->selling_customername;
            }
            if(!empty($request->showdetailts)){
                $datas[] = '';
            }
            if(!empty($request->showunit)){
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
            }
            if(!empty($request->showstatus)){
                $datas[] = 'แพ็กของ';
            }
            $datasup[] = $datas;
        }

        $incar = DB::table('selling')->where('selling_status',5);
        if($datestart != '' && $dateend != ''){
            $incar = $incar->whereBetween('selling_date',[$datestart,$dateend]);
        }else if($datestart != ''){
            $incar = $incar->where('selling_date','>',$datestart);
        }else{
            $incar = $incar->where('selling_date','<',$dateend);
        }
        $incar = $incar->get();
        foreach ($incar as $key => $value) {
            $count = count($datasup);
            $datas = [];
            $datas[] = $count+1;
            $datas[] = '';

            if(!empty($request->showdate)){
                $datas[] = '';
            }
            if(!empty($request->showsellingbill)){
                $datas[] = $value->selling_inv;
            }
            if(!empty($request->showcustomername)){
                $datas[] = $value->selling_customername;
            }
            if(!empty($request->showdetailts)){
                $datas[] = '';
            }
            if(!empty($request->showunit)){
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
            }
            if(!empty($request->showstatus)){
                $datas[] = 'ขึ้นรถ';
            }
            $datasup[] = $datas;
        }

        $responsedata = [];
        $responsedata['head'] = $arrayhead;
        $responsedata['data'] = $datasup;

        // dd($datacustomer);
        // return $datename;
        $datename = date('d_m_Y_H_i_s');
        
        $fileexcel = Excel::create('รายงานการจัดส่ง'.$datename, function ($excel) use ($arrayhead,$datasup){
            
            $excel->sheet('รายงานลูกค้า', function ($sheet) use ($arrayhead,$datasup){
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
        // dd($fileexcel);
        savelog('12','ออกรายงานการจัดส่งเป็นไฟล์ Excel ');
        $fileexcel->download('xlsx');
        // return view('backend.delivery.report',["data"=>$deliverydata,"date"=>$request->input('date')]);
    }

    public function reportpdf(Request $request){
        $selling = DB::table('transport')->leftjoin('sub_tran','sub_tran.sub_ref','transport.trans_id')->leftjoin('selling','selling.selling_id','sub_tran.sub_order')->leftjoin('customer','customer.customer_id','selling.selling_customerid')->leftjoin('area','customer.customer_group','area.area_id')->select(DB::raw('*'));

        $datestart = request('datestart');
        $dateend = request('dateend');
        if($datestart != '' && $dateend != ''){
            $selling = $selling->whereBetween('trans_date',[$datestart,$dateend]);
        }else if($datestart != ''){
            $selling = $selling->where('trans_date','>',$datestart);
        }else{
            $selling = $selling->where('trans_date','<',$dateend);
        }
        $billno = request('billno');
        $billnoto = request('billnoto');
        if($billno != '' && $billnoto != ''){
            $selling->whereBetween('trans_invoice',[$billno,$billnoto]);  //เปลี่ยนเป็นselect2เลยให้ค้นจากidแทน
        }else{
            if(!empty($name)){
                $selling->where('trans_invoice',$billno);
            }
            
            if(!empty($nameto)){
                $selling->where('trans_invoice',$billnoto);
            }
        }
        $status = $request->status;
        if($status != '' ){
            if($status == 4){
                $selling = $selling->where('trans_status',1);
            }else if($status == 3){
                $selling = $selling->where('trans_status',2);
            }else if($status == 2){
                $selling = $selling->where('selling_status',4);
            }else if($status == 1){
                $selling = $selling->where('trans_status',1)->where('selling_statuspacking','=','');
            }
        }
        

        

        $selling = $selling->get();
        $data = [];
        $datasup = [];
        foreach ($selling as $key => $value) {
            
            $datas = [];
            $datas[] = $key+1;
            $datas[] = $value->trans_invoice;

            if(!empty($request->showdate)){
                $datas[] = $value->trans_delivery;
            }
            if(!empty($request->showsellingbill)){
                $datas['selling_inv'] = $value->selling_inv;
            }
            if(!empty($request->showcustomername)){
                $datas['selling_customername'] = $value->selling_customername;
            }
            if(!empty($request->showdetailts)){
                $datas[] = $value->trans_emp.' '.$value->trans_truck.' '.$value->trans_truckid;
            }
            if(!empty($request->showunit)){
                $datas['selling_typeunit1'] = $value->selling_typeunit1;
                $datas['selling_typeunit2'] = $value->selling_typeunit2;
                $datas['selling_typeunit3'] = $value->selling_typeunit3;
                $datas['selling_typeunit4'] = $value->selling_typeunit4;
            }
            if(!empty($request->showstatus)){
                if($value->trans_status == '1'){
                    $datas[] = 'ส่งเรียบร้อยแล้ว';
                }else if($value->trans_status == '0'){
                    $datas[] = 'รอขนส่ง';
                }else if($value->trans_status == '2'){
                    $datas[] = 'กำลังส่ง';
                }else{
                    $datas[] = '';
                }
            }

            $datasup[] = $datas;
        }

        $order = DB::table('export')->where('export_status',0);
        if($datestart != '' && $dateend != ''){
            $order = $order->whereBetween('export_date',[$datestart,$dateend]);
        }else if($datestart != ''){
            $order = $order->where('export_date','>',$datestart);
        }else{
            $order = $order->where('export_date','<',$dateend);
        }
        $order = $order->get();
        foreach ($order as $key => $value) {
            $count = count($datasup);
            $datas = [];
            $datas[] = $count+1;
            $datas[] = $value->export_date;

            if(!empty($request->showdate)){
                $datas[] = '';
            }
            if(!empty($request->showsellingbill)){
                $datas['selling_inv'] = $value->export_inv;
            }
            if(!empty($request->showcustomername)){
                $datas['selling_customername'] = $value->export_customername;
            }
            if(!empty($request->showdetailts)){
                $datas[] = '';
            }
            if(!empty($request->showunit)){
                $datas['selling_typeunit1'] = '';
                $datas['selling_typeunit2'] = '';
                $datas['selling_typeunit3'] = '';
                $datas['selling_typeunit4'] = '';
            }
            if(!empty($request->showstatus)){
                $datas[] = 'ออเดอร์';
            }
            $datasup[] = $datas;
        }

        $selling = DB::table('selling')->where('selling_status',1)->where('selling_statuspacking','');
        if($datestart != '' && $dateend != ''){
            $selling = $selling->whereBetween('selling_date',[$datestart,$dateend]);
        }else if($datestart != ''){
            $selling = $selling->where('selling_date','>',$datestart);
        }else{
            $selling = $selling->where('selling_date','<',$dateend);
        }
        $selling = $selling->get();
        foreach ($selling as $key => $value) {
            $count = count($datasup);
            $datas = [];
            $datas[] = $count+1;
            $datas[] = $value->selling_date;

            if(!empty($request->showdate)){
                $datas[] = '';
            }
            if(!empty($request->showsellingbill)){
                $datas['selling_inv'] = $value->selling_inv;
            }
            if(!empty($request->showcustomername)){
                $datas['selling_customername'] = $value->selling_customername;
            }
            if(!empty($request->showdetailts)){
                $datas[] = '';
            }
            if(!empty($request->showunit)){
                $datas['selling_typeunit1'] = '';
                $datas['selling_typeunit2'] = '';
                $datas['selling_typeunit3'] = '';
                $datas['selling_typeunit4'] = '';
            }
            if(!empty($request->showstatus)){
                $datas[] = 'เปิดบิล';
            }
            $datasup[] = $datas;
        }

        $packing = DB::table('selling')->where('selling_status',4);
        if($datestart != '' && $dateend != ''){
            $packing = $packing->whereBetween('selling_date',[$datestart,$dateend]);
        }else if($datestart != ''){
            $packing = $packing->where('selling_date','>',$datestart);
        }else{
            $packing = $packing->where('selling_date','<',$dateend);
        }
        $packing = $packing->get();
        foreach ($packing as $key => $value) {
            $count = count($datasup);
            $datas = [];
            $datas[] = $count+1;
            $datas[] = $value->selling_date;

            if(!empty($request->showdate)){
                $datas[] = '';
            }
            if(!empty($request->showsellingbill)){
                $datas['selling_inv'] = $value->selling_inv;
            }
            if(!empty($request->showcustomername)){
                $datas['selling_customername'] = $value->selling_customername;
            }
            if(!empty($request->showdetailts)){
                $datas[] = '';
            }
            if(!empty($request->showunit)){
                $datas['selling_typeunit1'] = '';
                $datas['selling_typeunit2'] = '';
                $datas['selling_typeunit3'] = '';
                $datas['selling_typeunit4'] = '';
            }
            if(!empty($request->showstatus)){
                $datas[] = 'แพ็กของ';
            }
            $datasup[] = $datas;
        }

        $incar = DB::table('selling')->where('selling_status',5);
        if($datestart != '' && $dateend != ''){
            $incar = $incar->whereBetween('selling_date',[$datestart,$dateend]);
        }else if($datestart != ''){
            $incar = $incar->where('selling_date','>',$datestart);
        }else{
            $incar = $incar->where('selling_date','<',$dateend);
        }
        $incar = $incar->get();
        foreach ($incar as $key => $value) {
            $count = count($datasup);
            $datas = [];
            $datas[] = $count+1;
            $datas[] = '';
            $datas[] = '';

            if(!empty($request->showdate)){
                // $datas[] = 'แพ็กของ';
            }
            if(!empty($request->showsellingbill)){
                $datas[] = $value->selling_inv;
            }
            if(!empty($request->showcustomername)){
                $datas[] = $value->selling_customername;
            }
            if(!empty($request->showdetailts)){
                $datas[] = '';
            }
            if(!empty($request->showunit)){
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
                $datas[] = '';
            }
            if(!empty($request->showstatus)){
                $datas[] = 'ขึ้นรถ';
            }
            $datasup[] = $datas;
        }

        // dd($datasup);
        $pdf = PDF::loadView('reportpdf/reportpdftrans',['data' => $datasup,'datestart'=> date("d/m/Y",strtotime($request->datestart)),'dateend'=>date("d/m/Y",strtotime($request->dateend))],[],['orientation' => '', 'format' => 'A4']);
        savelog('12','ออกรายงานการจัดส่งเป็นไฟล์ PDF ');
        return $pdf->stream();
    }
}
