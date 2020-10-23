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
use Auth;

class BuyproductController extends Controller
{
    public function index(){
    	$cates 		= ' ';
		$subcate 	= ' ';
		$category 	= DB::table('category')->get();
        $supplier 	= supplier::orderBy('supplier_name','asc')->get();
		return view('buyproduct/index',['category' => $category,'supplier' => $supplier,'cates' => $cates,'subcate' => $subcate]);
	}
	
	public function datatable(){
		$product = DB::table('product')->where('product_type','1');
		if($cate = request('cate')){
			if(!empty($cate)){
				$product->where('product_category',$cate);
			}
		}
		if($subcate = request('subcate')){
			if(!empty($subcate)){
				$product->where('product_subcategory',$subcate);
			}
		}
		if($category = request('category')){
			if(!empty($category)){
				$product->where('product_category',$category);
			}
		}
		if($keyword = request('keyword')){
			$product->where('product_name','like',$keyword.'%');
		}
		if($product_code = request('barcode')){
			$product->where('product_code','like',$product_code.'%');
		}
		if($product_exp = request('product_exp')){
			$dateexp 		= explode('/',$product_exp);
			$dateexps 		= $dateexp[2].'-'.$dateexp[1].'-'.$dateexp[0];
			$product_expn = date("Y-m-d", strtotime("+1 month",strtotime($dateexps)));
			$product_expp = date("Y-m-d", strtotime("-1 month",strtotime($dateexps)));
			$product->where('product_expired','!=','');
			$product->whereBetween('product_expired',[$product_expp,$product_expn]);
		}
		if(Auth::user()->position == 3 || Auth::user()->position == 6){
    		$product->where('product_category',Auth::user()->groupcategory);
    	}
		$myproduct = $product->get();
		$sQuery	= Datatables::of($myproduct);
		return $sQuery->escapeColumns([])->make(true);
	}
}
