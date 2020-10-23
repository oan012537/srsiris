<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\percendiscount;
use Session;
use Response;
class PercenDiscountController extends Controller
{
    public function index(){
		$percendiscount = percendiscount::all();
		return view('percendiscount.index',['percendiscount'=>$percendiscount]);
	}

	public function store(Request $request){
		$percendiscount = new percendiscount;
		$percendiscount->percendiscount_value = $request->discount;
		$percendiscount->save();
		savelog('19','เพิ่มข้อมูลเปอร์เซ็นลดเงิน '.$request->input('discount'));
		Session::flash('alert-insert','insert');
		return redirect('percendiscount');
	}

	public function edit(Request $request){
		$results = percendiscount::find($request->id);
		return Response::json($results);
	}
	
	public function update(Request $request){
		$percendiscount = percendiscount::find($request->discountidedit);

		savelog('19','แก้ไขข้อมูลเปอร์เซ็นลดเงินลำดับที่ '.$percendiscount->percendiscount_id.' จาก '.$percendiscount->percendiscount_value.' เป็น '.$request->input('discountedit'));

		$percendiscount->percendiscount_value = $request->discountedit;
		$percendiscount->save();
		Session::flash('alert-update','update');
		return redirect('percendiscount');
	}

	public function destroy($id){
		$percendiscount = percendiscount::find($id);
		savelog('19','ลบข้อมูลเปอร์เซ็นลดเงินลำดับที่ '.$percendiscount->percendiscount_id.' จำนวน '.$percendiscount->percendiscount_value);
		
		$percendiscount->delete();
		Session::flash('alert-delete','delete');
		return redirect('percendiscount');
	}
}
