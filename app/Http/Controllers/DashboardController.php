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
use Gloudemans\Shoppingcart\Facades\Cart;
use PDF;
use Mail;
use Redirect;
use App\product;
use App\selling;
use App\sellingdetail;
use App\billingnote;
use App\imports;
use Auth;

class DashboardController extends Controller
{
	public function datasale(Request $request){
		$json = [];
		$json2 = [];
		$json3 = [];
		if($request->productid != ''){
			$productid = explode(',',$request->productid);
			$id = $productid[1];
			$type = $productid[0];
		}
		
		if($request->type == '1'){
			for ($i = 1; $i < 32; $i++) {
				$date = $request->year.'-'.$request->mount.'-'.str_pad($i,2,'0',STR_PAD_LEFT);
				// $selling = selling::select('selling_totalall', DB::raw('SUM(selling_totalall) as selling_totalall'))->leftjoin('customer','selling_customerid','customer_id')->where('selling_date',$date);
				$selling = selling::select('selling_totalall', DB::raw('SUM(sellingdetail_total) as selling_totalall'))->leftjoin('customer','selling_customerid','customer_id')->leftjoin('selling_detail','sellingdetail_ref','selling_id')->where('selling_date',$date);

				if(Auth::user()->position != 1){
		    		$selling->where('customer_group',Auth::user()->groupsell);
		    	}
		    	if($request->sellname != ''){
		    		$selling->where('selling_empid',$request->sellname);
		    	}
		    	if(!empty($type)){
		    		if($type == 'product'){
		    			$selling->where('sellingdetail_productid',$id);
			    	}else{
			    		$selling->where('customer_id',$id);
			    	}
		    	}

		    	$selling = $selling->first();
				if($selling->selling_totalall == null){
					$json[] = 0;
				}else{
					$json[] = $selling->selling_totalall;
				}

				if(Auth::user()->position != 4){
					// $sellingprofit = selling::leftjoin('selling_detail','sellingdetail_ref','selling_id')->leftjoin('orders','order_id','sellingdetail_sellingref')->select(DB::raw('SUM((order_price-order_capital)*order_qty) as profit'))->leftjoin('customer','selling_customerid','customer_id')->where('selling_date',$date);
					$sellingprofit = selling::leftjoin('selling_detail','sellingdetail_ref','selling_id')->select(DB::raw('SUM((sellingdetail_price-sellingdetail_capital)*sellingdetail_qty) as profit'))->leftjoin('customer','selling_customerid','customer_id')->where('selling_date',$date);

					if(Auth::user()->position != 1){
			    		$sellingprofit->where('customer_group',Auth::user()->groupsell);
			    	}
			    	if($request->sellname != ''){
			    		$sellingprofit->where('selling_empid',$request->sellname);
			    	}
			    	if(!empty($type)){
				    	if($type == 'product'){
				    		$sellingprofit->where('sellingdetail_productid',$id);
				    	}else{
				    		$sellingprofit->where('customer_id',$id);
				    	}
				    }

			    	$sellingprofit = $sellingprofit->first();
					if($sellingprofit->profit == null){
						$json2[] = 0;
					}else{
						$json2[] = $sellingprofit->profit;
					}
				}

				// $billingnote = billingnote::select('billingnote_pay', DB::raw('SUM(billingnote_pay) as billingnote_pay'))->leftjoin('billingnotedata','billingnotedata_billingnoteid','billingnote_id')->leftjoin('selling','billingnotedata_exportid','selling_id')->leftjoin('customer','selling_customerid','customer_id')->where('billingnote_date',$date);
				$billingnote = billingnote::select('billingnote_pay', DB::raw('SUM(billingnote_pay) as billingnote_pay'))->leftjoin('billingnotedata','billingnotedata_billingnoteid','billingnote_id')->leftjoin('selling','billingnotedata_exportid','selling_id')->leftjoin('customer','selling_customerid','customer_id')->leftjoin('selling_detail','sellingdetail_sellingref','selling_id')->where('billingnote_date',$date);

				if(Auth::user()->position != 1){
		    		$billingnote->where('customer_group',Auth::user()->groupsell);
		    	}
		    	if($request->sellname != ''){
		    		$billingnote->where('selling_empid',$request->sellname);
		    	}
		    	if(!empty($type)){
			    	if($type == 'product'){
			    		$billingnote->where('sellingdetail_productid',$id);
			    	}else{
			    		$billingnote->where('customer_id',$id);
			    	}
			    }

		    	$billingnote = $billingnote->first();
				if($billingnote->billingnote_pay == null){
					$json3[] = 0;
				}else{
					$json3[] = $billingnote->billingnote_pay;
				}
				
			}
			$data['selling'] = $json;
			$data['profit'] = $json2;
			$data['billingnote'] = $json3;
		}else{
			for ($i = 1; $i < 13; $i++) {
				$date = $request->year.'-'.str_pad($i,2,'0',STR_PAD_LEFT);
				// $selling = selling::select('selling_totalall', DB::raw('SUM(selling_totalall) as selling_totalall'))->leftjoin('customer','selling_customerid','customer_id')->where('selling_date','like','%'.$date.'%');
				$selling = selling::select('selling_totalall', DB::raw('SUM(selling_totalall) as selling_totalall'))->leftjoin('customer','selling_customerid','customer_id')->leftjoin('selling_detail','sellingdetail_ref','selling_id')->where('selling_date','like','%'.$date.'%');

				if(Auth::user()->position != 1){
		    		$selling->where('customer_group',Auth::user()->groupsell);
		    	}
		    	if($request->sellname != ''){
		    		$selling->where('selling_empid',$request->sellname);
		    	}
		    	if(!empty($type)){
		    		if($type == 'product'){
		    			$selling->where('sellingdetail_productid',$id);
			    	}else{
			    		$selling->where('customer_id',$id);
			    	}
		    	}

		    	$selling = $selling->first();
				if($selling->selling_totalall == null){
					$json[] = 0;
				}else{
					$json[] = $selling->selling_totalall;
				}

				if(Auth::user()->position != 4){
					// $sellingprofit = selling::leftjoin('selling_detail','sellingdetail_ref','selling_id')->leftjoin('orders','order_id','sellingdetail_sellingref')->select(DB::raw('SUM((order_price-order_capital)*order_qty) as profit'))->leftjoin('customer','selling_customerid','customer_id')->where('selling_date','like',$date.'%');
					$sellingprofit = selling::leftjoin('selling_detail','sellingdetail_ref','selling_id')->select(DB::raw('SUM((sellingdetail_price-sellingdetail_capital)*sellingdetail_qty) as profit'))->leftjoin('customer','selling_customerid','customer_id')->where('selling_date','like',$date.'%');

					if(Auth::user()->position != 1){
			    		$sellingprofit->where('customer_group',Auth::user()->groupsell);
			    	}
			    	if($request->sellname != ''){
			    		$sellingprofit->where('selling_empid',$request->sellname);
			    	}
			    	if(!empty($type)){
				    	if($type == 'product'){
				    		$sellingprofit->where('sellingdetail_productid',$id);
				    	}else{
				    		$sellingprofit->where('customer_id',$id);
				    	}
				    }

			    	$sellingprofit = $sellingprofit->first();
					if($sellingprofit->profit == null){
						$json2[] = 0;
					}else{
						$json2[] = $sellingprofit->profit;
					}
				}

				$billingnote = billingnote::select('billingnote_pay', DB::raw('SUM(billingnote_pay) as billingnote_pay'))->leftjoin('billingnotedata','billingnotedata_billingnoteid','billingnote_id')->leftjoin('selling','billingnotedata_exportid','selling_id')->leftjoin('customer','selling_customerid','customer_id')->leftjoin('selling_detail','sellingdetail_sellingref','selling_id')->where('billingnote_date',$date);

				if(Auth::user()->position != 1){
		    		$billingnote->where('customer_group',Auth::user()->groupsell);
		    	}
		    	if($request->sellname != ''){
		    		$billingnote->where('selling_empid',$request->sellname);
		    	}
		    	if(!empty($type)){
			    	if($type == 'product'){
			    		$billingnote->where('sellingdetail_productid',$id);
			    	}else{
			    		$billingnote->where('customer_id',$id);
			    	}
			    }
		    	$billingnote = $billingnote->first();
				if($billingnote->billingnote_pay == null){
					$json3[] = 0;
				}else{
					$json3[] = $billingnote->billingnote_pay;
				}
				
			}
			$data['selling'] = $json;
			$data['profit'] = $json2;
			$data['billingnote'] = $json3;
		}
        return Response::json($data);
    }

    public function datastock(Request $request){
		$json = [];
		$json2 = [];
		$json3 = [];
		if($request->productid != ''){
			$productid = $request->productid;
			// $id = $productid[1];
			// $type = $productid[0];
		}
		
		if($request->type == '1'){
			for ($i = 1; $i < 32; $i++) {
				$date = $request->year.'-'.$request->mount.'-'.str_pad($i,2,'0',STR_PAD_LEFT);
				$imports = imports::leftjoin('sub_import_product','import_product.imp_id','sub_import_product.imp_id')->select(DB::raw('SUM(amount) as amount'))->where('import_product.imp_date','<=',$date);
				if(!empty($productid)){
					$imports->where('product_id',$productid);
			    }
			    $imports = $imports->first();
			    // dd($imports->amount);
			    if($imports->amount == null){
					$stock = 0;
				}else{
					$stock = $imports->amount;
				}
				$selling = selling::select(DB::raw('SUM(sellingdetail_qty) as sellingdetail_qty'))->leftjoin('selling_detail','sellingdetail_ref','selling_id')->where('selling_date','<=',$date);
				if(!empty($productid)){
					$selling->where('sellingdetail_productid',$productid);
			    }
			    $selling = $selling->first();
			    // dd($imports->amount);
			    if($selling->sellingdetail_qty == null){
					$sell = 0;
				}else{
					$sell = $selling->sellingdetail_qty;
				}

				$product = product::select('product_qty', DB::raw('SUM(product_qty-sellingdetail_qty) as product_qty'))->leftjoin('selling_detail','product_id','sellingdetail_productid')->leftjoin('selling','sellingdetail_ref','selling_id')->where('selling_date',$date);

				// if(Auth::user()->position != 1){
		  //   		$billingnote->where('customer_group',Auth::user()->groupsell);
		  //   	}
		    	// if($request->sellname != ''){
		    	// 	$billingnote->where('selling_empid',$request->sellname);
		    	// }
		    	if(!empty($productid)){
			    	// if($type == 'product'){
			    		$product->where('product_id',$productid);
			    	// }
			    }
		    	$product = $product->first();
				if($product->product_qty == null){
					$product_qty = 0;
				}else{
					$product_qty = $product->product_qty;
				}
				$json3[] = $stock - $sell;
			}
			$data['billingnote'] = $json3;
		}else{
			for ($i = 1; $i < 13; $i++) {
				$date = $request->year.'-'.str_pad($i,2,'0',STR_PAD_LEFT);
				// $selling = selling::select('selling_totalall', DB::raw('SUM(selling_totalall) as selling_totalall'))->leftjoin('customer','selling_customerid','customer_id')->where('selling_date','like','%'.$date.'%');
				$selling = selling::select('selling_totalall', DB::raw('SUM(selling_totalall) as selling_totalall'))->leftjoin('customer','selling_customerid','customer_id')->leftjoin('selling_detail','sellingdetail_ref','selling_id')->where('selling_date','like','%'.$date.'%');

				if(Auth::user()->position != 1){
		    		$selling->where('customer_group',Auth::user()->groupsell);
		    	}
		    	if($request->sellname != ''){
		    		$selling->where('selling_empid',$request->sellname);
		    	}
		    	if(!empty($type)){
		    		if($type == 'product'){
		    			$selling->where('sellingdetail_productid',$id);
			    	}else{
			    		$selling->where('customer_id',$id);
			    	}
		    	}

		    	$selling = $selling->first();
				if($selling->selling_totalall == null){
					$json[] = 0;
				}else{
					$json[] = $selling->selling_totalall;
				}

				if(Auth::user()->position != 4){
					// $sellingprofit = selling::leftjoin('selling_detail','sellingdetail_ref','selling_id')->leftjoin('orders','order_id','sellingdetail_sellingref')->select(DB::raw('SUM((order_price-order_capital)*order_qty) as profit'))->leftjoin('customer','selling_customerid','customer_id')->where('selling_date','like',$date.'%');
					$sellingprofit = selling::leftjoin('selling_detail','sellingdetail_ref','selling_id')->select(DB::raw('SUM((sellingdetail_price-sellingdetail_capital)*sellingdetail_qty) as profit'))->leftjoin('customer','selling_customerid','customer_id')->where('selling_date','like',$date.'%');

					if(Auth::user()->position != 1){
			    		$sellingprofit->where('customer_group',Auth::user()->groupsell);
			    	}
			    	if($request->sellname != ''){
			    		$sellingprofit->where('selling_empid',$request->sellname);
			    	}
			    	if(!empty($type)){
				    	if($type == 'product'){
				    		$sellingprofit->where('sellingdetail_productid',$id);
				    	}else{
				    		$sellingprofit->where('customer_id',$id);
				    	}
				    }

			    	$sellingprofit = $sellingprofit->first();
					if($sellingprofit->profit == null){
						$json2[] = 0;
					}else{
						$json2[] = $sellingprofit->profit;
					}
				}

				$billingnote = billingnote::select('billingnote_pay', DB::raw('SUM(billingnote_pay) as billingnote_pay'))->leftjoin('billingnotedata','billingnotedata_billingnoteid','billingnote_id')->leftjoin('selling','billingnotedata_exportid','selling_id')->leftjoin('customer','selling_customerid','customer_id')->leftjoin('selling_detail','sellingdetail_sellingref','selling_id')->where('billingnote_date',$date);

				if(Auth::user()->position != 1){
		    		$billingnote->where('customer_group',Auth::user()->groupsell);
		    	}
		    	if($request->sellname != ''){
		    		$billingnote->where('selling_empid',$request->sellname);
		    	}
		    	if(!empty($type)){
			    	if($type == 'product'){
			    		$billingnote->where('sellingdetail_productid',$id);
			    	}else{
			    		$billingnote->where('customer_id',$id);
			    	}
			    }
		    	$billingnote = $billingnote->first();
				if($billingnote->billingnote_pay == null){
					$json3[] = 0;
				}else{
					$json3[] = $billingnote->billingnote_pay;
				}
				
			}
			$data['selling'] = $json;
			$data['profit'] = $json2;
			$data['billingnote'] = $json3;
		}
        return Response::json($data);
    }

    public function stock(){
    	 $sellingdate = selling::select(DB::raw('YEAR(MIN(selling_date)) as min,year(MAX(selling_date)) as max'))->first();
        return view('dashboard/stock',['data'=>$sellingdate]);
    }
}
