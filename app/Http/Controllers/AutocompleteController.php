<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use DB;
use Illuminate\Support\Facades\Input;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\supplier;
use App\processingunit;
use App\driver;
use App\car;
use App\unit;
use Auth;

class AutocompleteController extends Controller
{
	public function enterbarcode(Request $request){
		
		$product 	= DB::table('product')->join('unit', 'product.product_unit', '=', 'unit.unit_id')->where('product_code',$request->input('barcode'))->first();
		$results = [];
		if(empty($product)){
			return Response::json($results);
		}
		$unitdata 	= DB::table('processingunit')->leftjoin('unit','unit.unit_id','=','processingunit.unit_unitfirst')->leftjoin('unitsub','unitsub.unitsub_id','=','processingunit.unit_unitsec')->where('unit_productid',$product->product_id)->get();
		/* $stock = DB::table('product_stock')->where('product_id',$product->product_id)->get();
		$stocks = '';
		if($stock){
			foreach($stock as $rs){
				$stocks .= '<option value="'.$rs->product_sale.'">'.$rs->product_sale.'</option>';
			}
		} */

		if(!empty($request->input('cusid'))){
			$customer 	= DB::table('customer')->where('customer_id',$request->input('cusid'))->first();
			if($customer->customer_rate == 1){
				$price = $product->product_wholesale;
			}else if($customer->customer_rate == 2){
				$price = $product->product_wholesale2;
			}else if($customer->customer_rate == 3){
				$price = $product->product_wholesale3;
			}
		}else{
			$price = $product->product_wholesale3;
		}
		if(count($unitdata) != 0){
			$product->product_qty = $product->product_qty/($unitdata[0]->unit_total == 0 ?1:$unitdata[0]->unit_total);
		}

		$importcheck = DB::table('sub_import_product')->where('product_id',$product->product_id)->orderBy('sub_id','DESC')->first();
		if(count($importcheck) > 0){
			if($importcheck->typyunit == '2' ){
				if(!empty($unitdata)){
					$capital= $product->product_buy*$unitdata[0]->unit_total;
				}else{
					$capital= $product->product_buy;
				}
			}else{
				$capital=  $product->product_buy;
			}
		}else{
			$capital=  $product->product_buy;
		}
		// dd($capital);
		$results[] = [
			'id'			=>$product->product_id,
			'code'			=>$product->product_code,
			'name'			=>$product->product_name,
			'stock'			=>ceil($product->product_qty),
			'price'			=>$price,
			'capital'		=>$capital,
			'unitid'		=>$product->unit_id,
			'unit'			=>$product->unit_name,
			'unitdata'		=>$unitdata,
			'cate'			=>$product->product_category,
			'subcate'		=>$product->product_subcategory,
			'picture'		=>$product->product_picture,
		];
		return Response::json($results);
	}
	
	public function enterbarcodeselling(Request $request){
		$customer 	= DB::table('customer')->where('customer_id',$request->input('cusid'))->first();
		$product 	= DB::table('product')->join('unit', 'product.product_unit', '=', 'unit.unit_id')->where('product_code',$request->input('barcode'))->first();
		$order = DB::table('selling')->leftjoin('orders','orders.order_ref','selling.selling_ref')->where('order_productid',$product->product_id)->where('selling_id',$request->input('sellingid'))->first();
		/* $stock = DB::table('product_stock')->where('product_id',$product->product_id)->get();
		$stocks = '';
		if($stock){
			foreach($stock as $rs){
				$stocks .= '<option value="'.$rs->product_sale.'">'.$rs->product_sale.'</option>';
			}
		} */
		if($customer->customer_rate == 1){
			$price = $product->product_wholesale;
		}else if($customer->customer_rate == 2){
			$price = $product->product_wholesale2;
		}else if($customer->customer_rate == 3){
			$price = $product->product_wholesale3;
		}
		
		$results[] = [
			'id'			=>$product->product_id,
			'code'			=>$product->product_code,
			'name'			=>$product->product_name,
			'price'			=>$price,
			'unit'			=>$product->unit_name,
			'cate'			=>$product->product_category,
			'subcate'		=>$product->product_subcategory,
			'picture'		=>$product->product_picture,
		];
		return Response::json($results);
	}

	public function enterproduct(Request $request){
		
		$product = DB::table('product')->join('unit', 'product.product_unit', '=', 'unit.unit_id')->where('product_id',$request->input('id'))->first();
		$unitdata 	= DB::table('processingunit')->leftjoin('unit','unit.unit_id','=','processingunit.unit_unitfirst')->leftjoin('unitsub','unitsub.unitsub_id','=','processingunit.unit_unitsec')->where('unit_productid',$product->product_id)->get();
		if(!empty($request->input('cusid'))){
			$customer 	= DB::table('customer')->where('customer_id',$request->input('cusid'))->first();
			if($customer->customer_rate == 1){
				$price = $product->product_wholesale;
			}else if($customer->customer_rate == 2){
				$price = $product->product_wholesale2;
			}else if($customer->customer_rate == 3){
				$price = $product->product_wholesale3;
			}
		}else{
			$price = $product->product_wholesale3;
		}
		if(count($unitdata) != 0){
			$product->product_qty = $product->product_qty/($unitdata[0]->unit_total == 0 ?1:$unitdata[0]->unit_total);
		}
		$importcheck = DB::table('sub_import_product')->where('product_id',$product->product_id)->orderBy('sub_id','DESC')->first();
		if(count($importcheck) > 0){
			if($importcheck->typyunit == '2' ){
				if(!empty($unitdata)){
					$capital= $product->product_buy*$unitdata[0]->unit_total;
				}else{
					$capital= $product->product_buy;
				}

			}else{
				$capital=  $product->product_buy;
			}
		}else{
			$capital=  $product->product_buy;
		}
		
		$results[] = [
			'id'			=>$product->product_id,
			'code'			=>$product->product_code,
			'name'			=>$product->product_name,
			'stock'			=>ceil($product->product_qty),
			'price'			=>$price,
			'capital'		=>$capital,
			'unitid'		=>$product->unit_id,
			'unit'			=>$product->unit_name,
			'unitdata'		=>$unitdata,
			'cate'			=>$product->product_category,
			'subcate'		=>$product->product_subcategory,
			'picture'		=>$product->product_picture,
		];
		return Response::json($results);
	}
	
	public function enterproductselling(Request $request){
		$customer 	= DB::table('customer')->where('customer_id',$request->input('cusid'))->first();
		$product = DB::table('product')->join('unit', 'product.product_unit', '=', 'unit.unit_id')->where('product_id',$request->input('id'))->first();
		$order = DB::table('selling')->leftjoin('orders','orders.order_ref','selling.selling_ref')->where('order_productid',$request->input('id'))->where('selling_id',$request->input('sellingid'))->first();
		$unitdata 	= DB::table('processingunit')->leftjoin('unit','unit.unit_id','=','processingunit.unit_unitfirst')->leftjoin('unitsub','unitsub.unitsub_id','=','processingunit.unit_unitsec')->where('unit_productid',$product->product_id)->get();
		
		if($customer->customer_rate == 1){
			$price = $product->product_wholesale;
		}else if($customer->customer_rate == 2){
			$price = $product->product_wholesale2;
		}else if($customer->customer_rate == 3){
			$price = $product->product_wholesale3;
		}
		
		$results[] = [
			'id'			=>$product->product_id,
			'code'			=>$product->product_code,
			'name'			=>$product->product_name,
			'price'			=>$price,
			'unitid'		=>$product->unit_id,
			'unit'			=>$product->unit_name,
			'unitdata'		=>$unitdata,
			'cate'			=>$product->product_category,
			'subcate'		=>$product->product_subcategory,
			'picture'		=>$product->product_picture,
			'balance'		=>$order->order_balance,
		];
		return Response::json($results);
	}
	public function autocompleteproductname(){
		$term = Input::get('term');
		$results = array();
		$query = DB::table('product')->where('product_name', 'LIKE', '%'.$term.'%')->LIMIT('50')->get();
		if($query){
			foreach ($query as $rs){
				$results[] = [ 
					'id' 			=> $rs->product_id, 
					'value' 		=> $rs->product_name,
					'barcode' 		=> $rs->product_code,
					'label' 		=> $rs->product_code." / ".$rs->product_name,
					'qty'			=> $rs->product_qty,
					'picture'		=> $rs->product_picture,
					'attrs'			=> $rs->product_name." / ".$rs->product_detail
				];
			}
		}
		return Response::json($results);
	}

	public function autocompleteproductnameeditselling(Request $request){
		$term = Input::get('term');
		$results = array();
		$selling = DB::table('selling')->where('selling_id',$request->sellingid)->first();
		$query = DB::table('orders')->leftjoin('product','product.product_id','orders.order_productid')->where('product_name', 'LIKE', '%'.$term.'%')->where('order_ref',$selling->selling_ref)->where('order_balance','>',0)->LIMIT('50')->get();
		if($query){
			foreach ($query as $rs){
				$results[] = [ 
					'id' 			=> $rs->product_id, 
					'value' 		=> $rs->product_name,
					'barcode' 		=> $rs->product_code,
					'label' 		=> $rs->product_code." / ".$rs->product_name,
					'qty'			=> $rs->product_qty,
					'picture'		=> $rs->product_picture,
					'attrs'			=> $rs->product_name." / ".$rs->product_detail
				];
			}
		}
		return Response::json($results);
	}
	
	public function searchcustomername(){
		$term = Input::get('term');
		$results = array();
		$query = DB::table('customer')->where('customer_type','1')->where('customer_name', 'LIKE', '%'.$term.'%');
		if(Auth::user()->position > 2){
    		$query = $query->where('customer_group',Auth::user()->groupsell);
    	}

		$query = $query->get();
		if($query){
			foreach ($query as $rs){
				$addr = "";
				if(!empty($rs->customer_detail)){
					$addr = "ที่อยู่ :  ".$rs->customer_detail;
				}
				$address = "บ้านเลขที่ - ซอย :  ".$rs->customer_address1;
				$address .= " ถนน :  ".$rs->customer_address2;
				$address .= " แขวง / ตำบล :  ".$rs->customer_address3;
				$address .= " เขต / อำเภอ :  ".$rs->customer_address4;
				$address .= " จังหวัด :  ".$rs->customer_address5;
				$address .= " รหัสไปรษณย์ :  ".$rs->customer_address6;
				
				$results[] = [
					'value' 		=> $rs->customer_name,
					'label' 		=> $rs->customer_name." / ".$rs->customer_idtax,
					'idcus'			=> $rs->customer_id,
					'tel'			=> $rs->customer_tel,
					'note'			=> $rs->customer_note,
					'idtax'			=> $rs->customer_idtax,
					'addr'			=> $rs->customer_detail,
					'address'		=> $address,
					'attr'			=> $addr." โทร :  ".$rs->customer_tel.",  อีเมลล์ :  ".$rs->customer_email
				];
			}
		}
		
		return Response::json($results);
	}
	
	public function searchcustomertax(){
		$term = Input::get('term');
		$results = array();
		$query = DB::table('customer')->where('customer_idtax', 'LIKE', '%'.$term.'%')->get();
		if($query){
			foreach ($query as $rs){
				$addr = "";
				if(!empty($rs->customer_detail)){
					$addr = "ที่อยู่ :  ".$rs->customer_detail;
				}
				
				$results[] = [
					'value' 		=> $rs->customer_idtax,
					'idcus'			=> $rs->customer_id,
					'label' 		=> $rs->customer_name." / ".$rs->customer_idtax,
					'name'			=> $rs->customer_name,
					'tel'			=> $rs->customer_tel,
					'note'			=> $rs->customer_note,
					'idtax'			=> $rs->customer_idtax,
					'addr'			=> $rs->customer_detail,
					'attr'			=> $addr." โทร :  ".$rs->customer_tel.",  อีเมลล์ :  ".$rs->customer_email
				];
			}
		}
		
		return Response::json($results);
	}

	public function searchcustomertel(){
		$term = Input::get('term');
		$results = array();
		$query = DB::table('customer')->where('customer_tel', 'LIKE', '%'.$term.'%')->get();
		if($query){
			foreach ($query as $rs){
				$addr = "";
				if(!empty($rs->customer_detail)){
					$addr = "ที่อยู่ :  ".$rs->customer_detail;
				}
				
				$results[] = [
					'value' 		=> $rs->customer_tel,
					'idcus'			=> $rs->customer_id,
					'label' 		=> $rs->customer_name." / ".$rs->customer_idtax,
					'name'			=> $rs->customer_name,
					'tel'			=> $rs->customer_tel,
					'note'			=> $rs->customer_note,
					'idtax'			=> $rs->customer_idtax,
					'addr'			=> $rs->customer_detail,
					'attr'			=> $addr." โทร :  ".$rs->customer_tel.",  อีเมลล์ :  ".$rs->customer_email
				];
			}
		}
		
		return Response::json($results);
	}
    
    public function searchsupplier(){
        $term = Input::get('term');
		$results = array();
		$query = supplier::where('supplier_name', 'LIKE', '%'.$term.'%')->get();
		if($query){
			foreach ($query as $rs){
				$addr = "";
				if(!empty($rs->supplier_address)){
					$addr = "ที่อยู่ :  ".$rs->supplier_address;
				}
				
				$results[] = [
					'tax' 		=> $rs->supplier_tax,
					'id'			=> $rs->supplier_id,
					'label' 		=> $rs->supplier_name." / ".$rs->supplier_tax,
					'name'			=> $rs->supplier_name,
					'tel'			=> $rs->supplier_tel,
					'email'			=> $rs->supplier_email,
					'addr'			=> $rs->supplier_address,
					'attr'			=> $addr." โทร :  ".$rs->supplier_tel.",  อีเมลล์ :  ".$rs->supplier_email
				];
			}
		}
		
		return Response::json($results);
    }
    
    public function searchsuppliertax(){
        $term = Input::get('term');
		$results = array();
		$query = supplier::where('supplier_tax', 'LIKE', '%'.$term.'%')->get();
		if($query){
			foreach ($query as $rs){
				$addr = "";
				if(!empty($rs->supplier_address)){
					$addr = "ที่อยู่ :  ".$rs->supplier_address;
				}
				
				$results[] = [
					'tax' 		    => $rs->supplier_tax,
					'id'			=> $rs->supplier_id,
					'label' 		=> $rs->supplier_name." / ".$rs->supplier_tax,
					'name'			=> $rs->supplier_name,
					'tel'			=> $rs->supplier_tel,
					'email'			=> $rs->supplier_email,
					'addr'			=> $rs->supplier_address,
					'attr'			=> $addr." โทร :  ".$rs->supplier_tel.",  อีเมลล์ :  ".$rs->supplier_email
				];
			}
		}
		
		return Response::json($results);
    }
    
    public function enterimportproduct(Request $request){
		
        $product = DB::table('product')->where('product_id',$request->input('id'))->first();
        $unit = processingunit::where('unit_productid',$product->product_id)->get();
        $opunit='<select class="form-control" name="unit[]" required>';
        // $opunit.='<option value="">-- เลือกหน่วยนับ --</option>';
        if(count($unit) > 0){
            foreach($unit AS $valun){
            	$bigunit = DB::table('unit')->where('unit_id',$valun->unit_unitfirst)->first();
            	$smallunit = DB::table('unitsub')->where('unitsub_id',$valun->unit_unitsec)->first();
                if($valun->unit_unitfirst){
                    $opunit.='<option value="1,'.$bigunit->unit_id.'">'.$bigunit->unit_name.'</option>';
                }
                if($valun->unit_unitsec){
                    $opunit.='<option value="2,'.$smallunit->unitsub_id.'">'.$smallunit->unitsub_name.'</option>';
                }
            }
        }else{
        	$unit = unit::find($product->product_unit);
        	$opunit.='<option value="1,'.$unit->unit_id.'">'.$unit->unit_name.'</option>';
        }
        $opunit.='</select>';
		
        $size = '<input type="text" class="form-control" name="size[]">';
        
        $results[] = [
            'pro_id'          =>$product->product_id,
            'importdataid'	  => '<input type="hidden" name="importdataid[]" value="">',
            'pro_code'        =>$product->product_code.'<input type="hidden" name="proid[]" value="'.$product->product_id.'">',
            'pro_name'        =>$product->product_name ,
            'size'            =>$size,
            'unit'            =>$opunit,
            'capital'         =>'<input type="text" name="capital[]" id="capital'.$product->product_id.'"  class="form-control number" onkeyup="capitalpush('.$product->product_id.');cal()" required>',
            'sale'            =>'<input type="text" name="sale[]" class="form-control number" required>',
            'amount'          =>'<input type="text" name="amount[]" onkeyup="cal()" class="form-control number" required>'
        ];
		return Response::json(['results' => $results]);
	}
    
    public function enterimportbarcodeproduct(Request $request){
        $product = DB::table('product')->where('product_code',$request->input('barcode'))->first();
        $unit = processingunit::where('unit_productid',$product->product_id)->get();
        $opunit='<select class="form-control" name="unit[]" required>';
        // $opunit.='<option value="">-- เลือกหน่วยนับ --</option>';
        if(count($unit) > 0){
            foreach($unit AS $valun){
            	$bigunit = DB::table('unit')->where('unit_id',$valun->unit_unitfirst)->first();
            	$smallunit = DB::table('unitsub')->where('unitsub_id',$valun->unit_unitsec)->first();
                if($valun->unit_unitfirst){
                    $opunit.='<option value="1,'.$bigunit->unit_id.'">'.$bigunit->unit_name.'</option>';
                }
                if($valun->unit_unitsec){
                    $opunit.='<option value="2,'.$smallunit->unitsub_id.'">'.$smallunit->unitsub_name.'</option>';
                }
            }
        }else{
        	$unit = unit::find($product->product_unit);
        	$opunit.='<option value="1,'.$unit->unit_id.'">'.$unit->unit_name.'</option>';
        }
        $opunit.='</select>';
		
        $size = '<input type="text" class="form-control" name="size[]">';
        
        
        $results[] = [
            'pro_id'          =>$product->product_id,
            'importdataid'	  => '<input type="hidden" name="importdataid[]" value="">',
            'pro_code'        =>$product->product_code.'<input type="hidden" name="proid[]" value="'.$product->product_id.'">',
            'pro_name'        =>$product->product_name ,
            'size'            =>$size,
            'unit'            =>$opunit,
            'capital'         =>'<input type="text" name="capital[]" id="capital'.$product->product_id.'" class="form-control number" onkeyup="capitalpush('.$product->product_id.');cal()"  required>',
            'sale'            =>'<input type="text" name="sale[]" class="form-control number" required>',
            'amount'          =>'<input type="text" name="amount[]" onkeyup="cal()" class="form-control number" required>'
        ];
		return Response::json(['results' => $results]);
    }

    public function transportemp(){
        $term = Input::get('term');
		$results = array();
		$query = driver::where('driver_name', 'LIKE', '%'.$term.'%')->get();
		if($query){
			foreach ($query as $rs){
				$addr = "";
				if(!empty($rs->driver_address)){
					$addr = "ที่อยู่ :  ".$rs->driver_address;
				}
				
				$results[] = [
					'tax' 		    => $rs->driver_tax,
					'id'			=> $rs->driver_id,
					'labels' 		=> $rs->driver_name." / ".$rs->driver_tax,
					'label'			=> $rs->driver_name,
					'tel'			=> $rs->driver_tel,
					'email'			=> $rs->driver_email,
					'addr'			=> $rs->driver_address,
					'addr'			=> $addr." โทร :  ".$rs->driver_tel.",  อีเมลล์ :  ".$rs->driver_email
				];
			}
		}
		
		return Response::json($results);
    }

    public function transporttruck(){
        $term = Input::get('term');
		$results = array();
		$query = car::where('car_text', 'LIKE', '%'.$term.'%')->get();
		if($query){
			foreach ($query as $rs){
				$results[] = [
					'id'			=> $rs->car_id,
					'label'			=> $rs->car_name,
					'name'			=> $rs->car_name,
					'text'			=> $rs->car_text,
					'labels'		=> $rs->name.'  '.$rs->car_text,
				];
			}
		}
		
		return Response::json($results);
    }

    public function searchbillno(){
		$term = Input::get('term');
		$results = array();
		$query = DB::table('selling')->where('selling_inv', 'LIKE', '%'.$term.'%')->get();
		if($query){
			foreach ($query as $rs){
				$results[] = [
					'value' 		=> $rs->selling_inv,
					'label' 		=> $rs->selling_inv." / ".$rs->selling_date,
					'id'			=> $rs->selling_id,
				];
			}
		}
		
		return Response::json($results);
	}

	public function searchproductnameandemp(Request $request){
		$term = Input::get('term');
		$results = array();
		$product = DB::table('product')->where('product_name', 'LIKE', '%'.$term.'%')->get();

		if($product){
			foreach ($product as $rs){
				$results[] = [ 
					'id' 			=> 'product,'.$rs->product_id, 
					'value' 		=> $rs->product_name,
					'label' 		=> $rs->product_name,
				];
			}
		}
		$customer = DB::table('customer')->where('customer_type','1')->where('customer_name', 'LIKE', '%'.$term.'%')->get();
		if($customer){
			foreach ($customer as $rs){
				$results[] = [ 
					'id' 			=> 'customer,'.$rs->customer_id, 
					'value' 		=> $rs->customer_name,
					'label' 		=> $rs->customer_name,
				];
			}
		}

		return Response::json($results);
	}
}
