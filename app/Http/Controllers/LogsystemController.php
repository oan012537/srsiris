<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\savelogsystem;
use DB;
use Datatables;

class LogsystemController extends Controller
{
    public function index(){
		return view('logsystem/index');
	}
	
	public function datatable(){
		$logsystem = savelogsystem::select(DB::raw('log_system.logsystem_id,log_system.logsystem_text,users.name,log_system.created_at'))->leftjoin('users','users.id','log_system.logsystem_adminid');
		$datestart = '';
		$dateend = '';
		if(request('datestart')){
			$cutstart = explode('/',request('datestart'));
        	$datestart = $cutstart[2].'-'.$cutstart[1].'-'.$cutstart[0];
		}
		if(request('dateend')){
			$cutend = explode('/',request('dateend'));
        	$dateend = $cutend[2].'-'.$cutend[1].'-'.$cutend[0];
		}

		if($datestart != '' && $dateend != ''){
			$logsystem->whereBetween('log_system.created_at',[$datestart,$dateend]);
		}else if($datestart != ''){
			$logsystem->where('log_system.created_at','>=',$datestart);
		}else if($dateend != ''){
			$logsystem->where('log_system.created_at','<=',$datestart);
		}
		if(request('menu')){
			if(request('menu') == '1'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%เพิ่มข้อมูลสินค้าชื่อ%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลสินค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ลบข้อมูลสินค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%เพิ่มข้อมูลการนำจาหน้าสินค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%เพิ่มข้อมูลหน่วย%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลหน่วยใหญ่ต่อหน่วยย่อย%');
				});
			}else if(request('menu') == '3'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%เพิ่มข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ลบข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลลูกค้า%');
				});
			}else if(request('menu') == '4'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%เพิ่มข้อมูลออเดอร์%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ลบข้อมูลออเดอร์%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ยกเลิกข้อมูลออเดอร์%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ยกเลิกรายการในออเดอร์%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลออเดอร์%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ส่งข้อมูลออเดอร์ไปส่วนการขาย%');
				});
			}else if(request('menu') == '5'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%เพิ่มข้อมูลขาย%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ลบข้อมูลขายลำดับที่%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลขายลำดับที่%');
					$query->orwhere('log_system.logsystem_text','LIKE','%คำนวณเงินข้อมูลขายลำดับที่%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ยกเลิกข้อมูลขายลำดับที่%');
					$query->orwhere('log_system.logsystem_text','LIKE','%คืนสินค้าข้อมูลขายลำดับที่%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขการยกเลิกข้อมูลขายลำดับที่%');
					$query->orwhere('log_system.logsystem_text','LIKE','%เพิ่มข้อมูลออเดอร์ชื่อลูกค้า%');
				});
			}else if(request('menu') == '6'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%สแกนบาร์โค้ดเลขบิลขาย%');
				});
			}else if(request('menu') == '7'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%เพิ่มข้อมูลขนส่ง%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ยกเลิกรายการขน%');
					$query->orwhere('log_system.logsystem_text','LIKE','%เปลี่ยนสถานะขนส่งเป็นกำลังจัดส่ง%');
					$query->orwhere('log_system.logsystem_text','LIKE','%เปลี่ยนสถานะขนส่งเป็นจัดส่งแล้ว%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ยกเลิกรายการขนส่ง%');
					$query->orwhere('log_system.logsystem_text','LIKE','%เพิ่มไฟล์รายการขนส่ง%');
					$query->orwhere('log_system.logsystem_text','LIKE','%เพิ่มค่าใช้จ่ายในการขนส่ง%');
				});
			}else if(request('menu') == '8'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%เพิ่มข้อมูลใบเก็บเงินเลขที่บิล%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ลบข้อมูลใบเก็บเงินเลขที่บิล%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลใบเก็บเงินเลขที่บิล%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ยกเลิกข้อมูลขายเลขที่บิล%');
					$query->orwhere('log_system.logsystem_text','LIKE','%อัพโหลดไฟล์ข้อมูลขายเลขที่บิล%');
				});
			}else if(request('menu') == '9'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%อัพเดทและส่งข้อมูลออเดอร์ไปส่วนการขาย%');
				});
			}else if(request('menu') == '10'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%เพิ่มข้อมูลซัพพลายเออร์ชื่อ%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลซัพพลายเออร์ลำดับที่%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ลบข้อมูลซัพพลายเออร์ลำดับที่%');
				});
			}else if(request('menu') == '11'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%เพิ่มข้อมูลการนำเข้าเลขที่ออเดอร์%');
					$query->orwhere('log_system.logsystem_text','LIKE','%เพิ่มสินค้านำเข้าเลขที่ออเดอร์%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ชำระเงินสินค้านำเข้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ยกเลิกข้อมูลนำเข้าเลขที่บิล%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลการนำเข้าเลขที่ออเดอร์%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขเพิ่มสินค้านำเข้าเลขที่ออเดอร์%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ยกเลิกการชำระการนำเข้าเลขที่บิล%');
				});
			}else if(request('menu') == '12'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%ออกรายงานลูกค้าเป็นไฟล์%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ออกรายงานซัพพลายเออร์เป็นไฟล์%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ออกรายงานสต๊อกเป็นไฟล์%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ออกรายงานขายเป็นไฟล์%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ออกรายงานการจัดส่งเป็นไฟล์%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ออกรายงานออเดอร์เป็นไฟล์%');
				});
			}else if(request('menu') == '13'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ลบข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลลูกค้า%');
				});
			}else if(request('menu') == '14'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ลบข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลลูกค้า%');
				});
			}else if(request('menu') == '15'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ลบข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลลูกค้า%');
				});
			}else if(request('menu') == '16'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ลบข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลลูกค้า%');
				});
			}else if(request('menu') == '17'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ลบข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลลูกค้า%');
				});
			}else if(request('menu') == '18'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ลบข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลลูกค้า%');
				});
			}else if(request('menu') == '19'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ลบข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลลูกค้า%');
				});
			}else if(request('menu') == '20'){
				$logsystem->where(function($query){
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%ลบข้อมูลลูกค้า%');
					$query->orwhere('log_system.logsystem_text','LIKE','%แก้ไขข้อมูลลูกค้า%');
				});
			}
		}
		$count = 0;
		
		// dd($logsystem);
		$s_Query	= Datatables::of($logsystem);
		return $s_Query->escapeColumns([])->make(true);
	}
}
