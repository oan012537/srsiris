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

class ManufactureController extends Controller
{
    public function index(){
		$cates 		= ' ';
		$subcate 	= ' ';
		$category 	= DB::table('category')->get();
        $supplier 	= supplier::orderBy('supplier_name','asc')->get();
		return view('manufacture/index',['category' => $category,'supplier' => $supplier,'cates' => $cates,'subcate' => $subcate]);
	}
	
	public function datatable(){
		$product = DB::table('product')->where('product_type','2');
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
	
	public function create(){
		$category = DB::table('category')->orderBy('category_name')->get();
		$unit = DB::table('unit')->orderBy('unit_name')->get();
		return view('manufacture/create',['category' => $category,'unit' => $unit,'producttype' => '2']);
	}
	
	public function store(Request $request){
		$imgcover 	= '';
		$imgthumbs 	= '';
        $recommended = 0;
        if($request->input('recommended') == 'on'){
            $recommended = 1;
        }
        
		if($request->hasFile('uploadcover')){
			$files = $request->file('uploadcover');
			$filename 	= $files->getClientOriginalName();
			$extension 	= $files->getClientOriginalExtension();
			$size		= $files->getSize();
			$imgcover 		= date('His').$filename;
			$destinationPath = base_path()."/assets/images/product/";
			$files->move($destinationPath, $imgcover);
			
		}
		
		$prosmo = '';
		if(!empty($request->input('productprosdate'))){
			$datepros 	= explode('/',$request->input('productprosdate'));
			$prosmo 		= $datepros[2].'-'.$datepros[0].'-'.$datepros[1];
		}
		
		$proemo = '';
		if(!empty($request->input('productproedate'))){
			$dateproe 	= explode('/',$request->input('productproedate'));
			$proemo 		= $dateproe[2].'-'.$dateproe[0].'-'.$dateproe[1];
		}

		$dateexp = '';
		if(!empty($request->input('dateexpire'))){
			$dateexp 	= explode('/',$request->input('dateexpire'));
			$dateexp 		= $dateexp[2].'-'.$dateexp[0].'-'.$dateexp[1];
		}
		
		
		$data = [
			'product_type'			=> '2',
			'product_code'			=> $request->input('productcode'),
			'product_category'		=> $request->input('category'),
			'product_subcategory'	=> !empty($request->input('subcategory'))?$request->input('subcategory'):0,
			'product_name'			=> $request->input('productname'),
			'product_barcode'		=> $request->input('barcode'),
			'product_detail'		=> $request->input('productdetail'),
			'product_buy'			=> $request->input('productbuy'),
			'product_qty'			=> 0,
			'product_retail'		=> $request->input('productretail'),
			'product_wholesalenumber'	=> $request->input('productwholesale'),
			'product_wholesaleunit'	=> $request->input('productwholesaleunit'),
			'product_wholesale2number'	=> $request->input('productwholesale2'),
			'product_wholesale2unit'=> $request->input('productwholesaleunit2'),
			'product_wholesale3number'	=> $request->input('productwholesale3'),
			'product_wholesale3unit'=> $request->input('productwholesaleunit3'),
			'product_minstock'		=> $request->input('productmin'),
			'product_unit'			=> $request->input('productunit'),
			'product_promotion'		=> $request->input('productpromotion'),
			'product_prosdate'		=> $prosmo,
			'product_proedate'		=> $proemo,
			'product_expired'		=> $dateexp,
			'product_picture'		=> $imgcover,
			'product_thumbs'		=> $imgcover,
            'product_recommended'   => $recommended,
			'created_at'			=> new DateTime(),
			'updated_at'			=> new DateTime(),
		];
		// dd($data);
		DB::table('product')->insert($data);
		$lastid = DB::table('product')->latest()->first();
		
		$unitid = $request->input('total');
		foreach($unitid as $key => $rs){
			$datas = array(
				'unit_productid'		=> $lastid->product_id,
				'unit_unitfirst'		=> $request->input('bunit')[$key],
				'unit_unitsec'			=> $request->input('unit')[$key],
				'unit_total'			=> $request->input('total')[$key],
				'created_at'			=> new DateTime(),
				'updated_at'			=> new DateTime(),
			);
			
			DB::table('processingunit')->insert($datas);
		}
		
		Session::flash('alert-insert','insert');
		return redirect('manufacture');
	}
	
	public function edit($id){
		$category	= DB::table('category')->orderBy('category_name')->get();
		$subcate	= DB::table('subcategory')->get();
		$unit 		= DB::table('unit')->orderBy('unit_name')->get();
		$product 	= DB::table('product')->where('product_id',$id)->first();
		$productpro	= DB::table('processingunit')->where('unit_productid',$id)->get();
		$process = [];
		if($productpro){
			foreach($productpro as $rs){
				$bunit = DB::table('unit')->where('unit_id',$rs->unit_unitfirst)->first();
				$units = DB::table('unit')->where('unit_id',$rs->unit_unitsec)->first();
				$process[] = [
					'procid'		=> $rs->unit_id,
					'procbunit'		=> $bunit->unit_name,
					'procunit'		=> $units->unit_name,
					'proctotal'		=> $rs->unit_total,
				];
			}
		}
		return view('manufacture/update',['category' => $category,'subcate' => $subcate,'unit' => $unit,'product' => $product,'process' => $process]);
	}
	
	public function deleteproc(Request $request){
		DB::table('processingunit')->where('unit_id',$request->input('id'))->delete();
		return Response::json(1);
	}
	
	public function update(Request $request){
		$res = DB::table('product')->where('product_id',$request->input('updateid'))->first();
		$imgcover 	= $res->product_picture;
		$imgthumbs 	= $res->product_thumbs;
        $recommended = 0;
        if($request->input('recommended') == 'on'){
            $recommended = 1;
        }
        
		if($request->hasFile('uploadcover')){
			File::delete('assets/images/product/'.$res->product_picture.'');
			//File::delete('assets/images/product/'.$res->product_thumbs.'');
			/*$files = $request->file('uploadcover');
			$filename 			= $files->getClientOriginalName();
			$extension 			= $files->getClientOriginalExtension();
			$size				= $files->getSize();
			
			$imgcover 			= time().'.'.$extension;
			$destinationPath 	= base_path()."/assets/images/product";
			$filedes = $files->move($destinationPath, $imgcover);
			
			$imgthumbs = 'thumbs'.time().'.'.$extension;
			$location = base_path('/assets/images/product/thumbs/'. $imgthumbs);
			Image::make($filedes,array('width' => 305,'height' => 425,'grayscale' => false))->save($location); */
			
			$files = $request->file('uploadcover');
			$filename 	= $files->getClientOriginalName();
			$extension 	= $files->getClientOriginalExtension();
			$size		= $files->getSize();
			$imgcover 		.= date('His').$filename;
			$destinationPath = base_path()."/assets/images/product/";
			$files->move($destinationPath, $imgcover);
		}
		
		/*$expire = '';
		if(!empty($request->input('dateexpire'))){
			$dateex 	= explode('/',$request->input('dateexpire'));
			$expire 	= $dateex[2].'-'.$dateex[0].'-'.$dateex[2];
		}*/
		
		$prosmo = '';
		if(!empty($request->input('productprosdate'))){
			$datepros 	= explode('/',$request->input('productprosdate'));
			$prosmo 		= $datepros[2].'-'.$datepros[1].'-'.$datepros[0];
		}
		
		$proemo = '';
		if(!empty($request->input('productproedate'))){
			$dateproe 		= explode('/',$request->input('productproedate'));
			$proemo 		= $dateproe[2].'-'.$dateproe[1].'-'.$dateproe[0];
		}
		$dateexp = '';
		if(!empty($request->input('dateexpire'))){
			$dateexp 	= explode('/',$request->input('dateexpire'));
			$dateexp 		= $dateexp[2].'-'.$dateexp[1].'-'.$dateexp[0];
		}
		
		$data = [
			'product_code'			=> $request->input('productcode'),
			'product_category'		=> $request->input('category'),
			'product_subcategory'	=> !empty($request->input('subcategory'))?$request->input('subcategory'):0,
			'product_name'			=> $request->input('productname'),
			'product_barcode'		=> $request->input('barcode'),
			'product_detail'		=> $request->input('productdetail'),
			'product_buy'			=> $request->input('productbuy'),
			'product_retail'		=> $request->input('productretail'),
			'product_retailnumber'		=> $request->input('productretailnumber'),
			'product_retailunit'		=> $request->input('productwholesaleunit'),
			'product_wholesale'		=> $request->input('productwholesale'),
			'product_wholesalenumber'		=> $request->input('productwholesalenumber'),
			'product_wholesaleunit'		=> $request->input('productwholesaleunit'),
			'product_wholesale2'		=> $request->input('productwholesale2'),
			'product_wholesale2number'	=> $request->input('productwholesale2number'),
			'product_wholesale2unit'		=> $request->input('productwholesale2unit'),
			'product_wholesale3'		=> $request->input('productwholesale3'),
			'product_wholesale3number'	=> $request->input('productwholesale3number'),
			'product_wholesale3unit'		=> $request->input('productwholesale3unit'),
			'product_minstock'		=> $request->input('productmin'),
			'product_unit'			=> $request->input('productunit'),
			'product_promotion'		=> $request->input('productpromotion'),
			'product_prosdate'		=> $prosmo,
			'product_proedate'		=> $proemo,
			'product_expired'		=> $dateexp,
			'product_picture'		=> $imgcover,
			'product_thumbs'		=> $imgcover,
			'product_recommended'   => $recommended,
			'updated_at'			=> new DateTime(),
		];
		// dd($data);
		$unitid = $request->input('total');
		foreach($unitid as $key => $rs){
			if(!empty($request->input('total')[$key])){
				$datas = array(
					'unit_productid'		=> $request->input('updateid'),
					'unit_unitfirst'		=> $request->input('bunit')[$key],
					'unit_unitsec'			=> $request->input('unit')[$key],
					'unit_total'			=> $request->input('total')[$key],
					'created_at'			=> new DateTime(),
					'updated_at'			=> new DateTime(),
				);
				
				DB::table('processingunit')->insert($datas);
			}
		}
		
		DB::table('product')->where('product_id',$request->input('updateid'))->update($data);
		Session::flash('alert-update','update');
		return redirect('manufacture');
	}
	
	
	public function destroy($id){
		DB::table('customer')->where('customer_id',$id)->delete();
		
		Session::flash('alert-delete','delete');
		return redirect('customer');
	}

	public function datagroupcustomer(){
		$groupcustomer = DB::table('groupcustomer')->where('groupcustomer_status','1')->get();
		return Response::json($groupcustomer);
	}
}
