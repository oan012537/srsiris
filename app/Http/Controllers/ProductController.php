<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Session;
use Response;
use Datatables;
use File;
use Auth;
use Folklore\Image\Facades\Image;
use App\supplier;
use App\product;
use App\imports;
use App\subimports;
use App\processingunit;
use App\stock;
use \Milon\Barcode\DNS1D;
use PDF;
use Config;
use App\importbyproduct;
use App\subimportbyproduct;

class ProductController extends Controller
{
    public function index(){
		$cates 		= ' ';
		$subcate 	= ' ';
		$category 	= DB::table('category')->get();
        $supplier 	= supplier::orderBy('supplier_name','asc')->get();
		return view('product/index',['category' => $category,'supplier' => $supplier,'cates' => $cates,'subcate' => $subcate]);
	}
	
	public function indexcate($cate){
		$cates 		= $cate;
		$subcate 	= ' ';
		$category 	= DB::table('category')->get();
        $supplier 	= supplier::orderBy('supplier_name','asc')->get();
		return view('product/index',['category' => $category,'supplier' => $supplier,'cates' => $cates,'subcate' => $subcate]);
	}
	
	public function indexsubcate($cate,$sub){
		$cates 		= $cate;
		$subcate 	= $sub;
		$category 	= DB::table('category')->get();
        $supplier 	= supplier::orderBy('supplier_name','asc')->get();
		return view('product/index',['category' => $category,'supplier' => $supplier,'cates' => $cates,'subcate' => $subcate]);
	}
	
	public function datatable(){
		$product = DB::table('product')->where('product_status','!=','0');
		
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
			$product->where('product_name','like','%'.$keyword.'%');
		}
		if($product_code = request('product_code')){
			$product->where('product_code','like','%'.$product_code.'%');
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
		$myproduct = $product;
		$sQuery	= Datatables::of($product)
		->editColumn('updated_at',function($data){
			return date('d/m/Y',strtotime($data->updated_at));
		})
		->editColumn('product_qty',function($data){
			return number_format($data->product_qty);
		})
		->editColumn('product_buy',function($data){
			return number_format($data->product_buy,2);
		})
		->addColumn('qty',function($data){
			return $data->product_buy;
		})
		->addColumn('min',function($data){
			return $data->product_minstock;
		})
		->addColumn('unitname',function($data){
			$processingunit = DB::table('processingunit')->where('unit_productid',$data->product_id)->first();
			$unit = DB::table('unitsub')->where('unitsub_id',$processingunit->unit_unitsec)->first();
			return $unit->unitsub_name;
		})
		->addColumn('product_big',function($data){
			$datas = DB::table('processingunit')->where('unit_productid',$data->product_id)->first();
			if(!empty($datas)){
				return number_format($data->product_qty/($datas->unit_total == '0' ?1:$datas->unit_total),2);
			}else{
				return number_format($data->product_qty,2);
			}
			
		});
		return $sQuery->escapeColumns([])->make(true);
	}
	
	public function create(){
		$category = DB::table('category')->orderBy('category_name')->get();
		$unit = DB::table('unit')->orderBy('unit_name')->get();
		$unitsub = DB::table('unitsub')->orderBy('unitsub_name')->get();
        $lastid = DB::table('product')->latest()->first();
        $setting = DB::table('setting')->first();
		return view('product/create',['category' => $category,'unit' => $unit,'unitsub' => $unitsub,'lastid' => ($lastid->product_id+1),'setting'=>$setting]);
	}
	
	public function store(Request $request){
		$imgcover 	= '';
		$imgthumbs 	= '';
		//ทำใหม่
		if(!$request->input('barcode')){
			if($request->input('producttype') == '1'){
				$producttype = '01';
			}else{
				$producttype = '02';
			}
			$barcode = $producttype.$request->input('category');
			$search = DB::table('product')->where('product_barcode','LIKE',$barcode.'%')->first();
			if(!empty($search)){
				$str = $search->product_barcode;
				$sub = (substr($str,strlen($barcode))+1);
				$len = 12-strlen($barcode);
				$barcode = $barcode.sprintf("%0{$len}d",$sub);
			}else{
				$len = 12-strlen($barcode);
				$barcode = $barcode.sprintf("%0{$len}d",1);
			}


		}else{
			$barcode = $request->input('barcode');
		}
        $recommended = 0;
        if($request->input('recommended') == 'on'){
            $recommended = 1;
        }
        
		// if($request->hasFile('uploadcover')){
		// 	$files = $request->file('uploadcover');
		// 	$filename 	= $files->getClientOriginalName();
		// 	$extension 	= $files->getClientOriginalExtension();
		// 	$size		= $files->getSize();
		// 	$imgcover 		= date('His').$filename;
		// 	$destinationPath = base_path()."/assets/images/product/";
		// 	$files->move($destinationPath, $imgcover);
			
		// }
		
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
		
		if($request->input('productretailunit') == '1'){
			$product_retail = $request->input('productbuy') + $request->input('productretail');
		}else{
			$product_retail = $request->input('productbuy') + $request->input('productbuy')*$request->input('productretail')/100;
		}
		if($request->input('productwholesaleunit') == '1'){
			$productwholesale1 = $request->input('productbuy') + $request->input('productwholesale');
		}else{
			$productwholesale1 = $request->input('productbuy') + $request->input('productbuy')*$request->input('productwholesale')/100;
		}
		if($request->input('productwholesale2unit') == '1'){
			$productwholesale2 = $request->input('productbuy') + $request->input('productwholesale2');
		}else{
			$productwholesale2 = $request->input('productbuy') + $request->input('productbuy')*$request->input('productwholesale2')/100;
		}
		if($request->input('productwholesale3unit') == '1'){
			$productwholesale3 = $request->input('productbuy') + $request->input('productwholesale3');
		}else{
			$productwholesale3 = $request->input('productbuy') + $request->input('productbuy')*$request->input('productwholesale3')/100;
		}

		$data = [
			'product_type'			=> $request->input('producttype'),
			'product_code'			=> $request->input('productcode'),
			'product_category'		=> $request->input('category'),
			'product_subcategory'	=> !empty($request->input('subcategory'))?$request->input('subcategory'):0,
			'product_name'			=> $request->input('productname'),
			'product_barcode'		=> $barcode,
			'product_detail'		=> !empty($request->input('productdetail'))?$request->input('productdetail'):'',
			'product_buy'			=> $request->input('productbuy'),
			'product_qty'			=> 0,
			'product_retail'		=> $request->input('productretail'),
			'product_retailnumber'	=> $request->input('productretail'),
			'product_retailunit'	=> $request->input('productretailunit'),
			'product_wholesale'		=> $productwholesale1,
			'product_wholesalenumber'=> $request->input('productwholesale'),
			'product_wholesaleunit'	=> $request->input('productwholesaleunit'),
			'product_wholesale2'	=> $productwholesale2,
			'product_wholesale2number'=> $request->input('productwholesale2'),
			'product_wholesale2unit'=> $request->input('productwholesaleunit2'),
			'product_wholesale3'	=> $productwholesale3,
			'product_wholesale3number'=> $request->input('productwholesale3'),
			'product_wholesale3unit'=> $request->input('productwholesaleunit3'),
			'product_minstock'		=> $request->input('productmin'),
			'product_unit'			=> !empty($request->input('productunit'))?$request->input('productunit'):'',
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
		
		DB::table('product')->insert($data);
		$lastid = DB::table('product')->latest()->first();
		if(!empty($request->uploadimage)){
			$file = explode(',',$request->uploadimage);
			foreach($file as $filemove){
				File::move(base_path("/assets/images/product/upload/".$filemove), base_path("/assets/images/product/".$filemove));
				$dataimg = [
					'imageproduct_productid'=> $lastid->product_id,
					'imageproduct_name'		=> $filemove
				];
				DB::table('imageproduct')->insert($dataimg);
			}
		}else{
			if($request->hasFile('uploadcover')){
				$files_ = $request->file('uploadcover');
				foreach ($files_ as $value) {
					$files = $value;
					$filename 	= $files->getClientOriginalName();
					$extension 	= $files->getClientOriginalExtension();
					$size		= $files->getSize();
					$imgcover1 	= date('His').$filename;
					$destinationPath = base_path()."/assets/images/product/";
					$files->move($destinationPath, $imgcover1);
					//เพิ่มข้อมูล
					$dataimg = [
						'imageproduct_productid'=> $lastid->product_id,
						'imageproduct_name'		=> $imgcover1
					];
					DB::table('imageproduct')->insert($dataimg);
					//เพิ่มข้อมูล
				}
			}
		}
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
		savelog('1','เพิ่มข้อมูลสินค้าชื่อ '.$request->input('productname'));
		Session::flash('alert-insert','insert');
		return redirect('product');
	}
	
	public function edit($id){
		$category	= DB::table('category')->orderBy('category_name')->get();
		$subcate	= DB::table('subcategory')->get();
		$unit 		= DB::table('unit')->orderBy('unit_name')->get();
		$unitsub 	= DB::table('unitsub')->orderBy('unitsub_name')->get();
		$product 	= DB::table('product')->leftjoin('category','category_id','product_category')->where('product_id',$id)->first();
		$productpro	= DB::table('processingunit')->where('unit_productid',$id)->get();
		$productlast = DB::table('product')->where('product_type',$product->product_type)->where('product_category',$product->product_category)->orderBy('product_barcode','DESC')->first();
		$barcode = substr($productlast->product_code,4);

		$barcodelast = $barcode+1;
		$process = [];
		if($productpro){
			foreach($productpro as $rs){
				$bunit = DB::table('unit')->where('unit_id',$rs->unit_unitfirst)->first();
				// $units = DB::table('unit')->where('unit_id',$rs->unit_unitsec)->first();
				$units = DB::table('unitsub')->where('unitsub_id',$rs->unit_unitsec)->first();
				$process[] = [
					'procid'		=> $rs->unit_id,
					'procbunitid'	=> !empty($rs->unit_unitfirst)?$rs->unit_unitfirst:'',
					'procunitid'	=> !empty($rs->unit_unitsec)?$rs->unit_unitsec:'',
					'procbunit'		=> !empty($bunit)?$bunit->unit_name:$bunit,
					'procunit'		=> !empty($units)?$units->unitsub_name:$units,
					'proctotal'		=> $rs->unit_total,
				];
			}
		}
		$d = new DNS1D();
		$d->setStorPath(__DIR__."/cache/");
		$genbarcode = $d->getBarcodePNG(substr($product->product_barcode,0,12), "EAN13",2,43);

		return view('product/update',['category' => $category,'subcate' => $subcate,'unit' => $unit,'product' => $product,'process' => $process,'barcodelast'=>$barcodelast,'unitsub'=>$unitsub,'genbarcode'=>$genbarcode]);
	}
	
	public function getbarcode($id){
		$product 	= DB::table('product')->where('product_id',$id)->first();
		$d = new DNS1D();
		$d->setStorPath(__DIR__."/cache/");
		$genbarcode = $d->getBarcodePNG(substr($product->product_barcode,0,12), "EAN13",2,43);
		// echo DNS1D::getBarcodeHTML($product->product_barcode, "C128");
		// echo DNS1D::getBarcodeHTML($product->product_barcode, "EAN13");
		// exit();
		if(!empty($genbarcode)){ 
            // $pdf = PDF::loadView('product/genbarcode',['genbarcode' => $genbarcode,'barcode' =>$product->product_barcode],[], ['format' => [70,30]]);
            $pdf = PDF::loadView('product/genbarcode',['genbarcode' => $genbarcode,'barcode' =>$product->product_barcode],[], ['format' => [100,28]]);
            return $pdf->stream();
        }else{
        	dd($data);
        }
		// return Response::json($product);
	}

	public function barcode(Request $request){
		$id = $request->productid;
		$w = $request->width;
		$h = $request->height;
		$product 	= DB::table('product')->where('product_id',$id)->first();
		$d = new DNS1D();
		$d->setStorPath(__DIR__."/cache/");
		$genbarcode = $d->getBarcodePNG($product->product_barcode, "C128");
		// echo '<img src="data:image/png;base64,' . $genbarcode . '" alt="barcode"   />';
	
		// echo $d->getBarcodeHTML($product->product_barcode, "C39",2,33,"black", true); //text,type,w,h,color
		if(!empty($genbarcode)){ 
            $pdf = PDF::loadView('product/genbarcode',['genbarcode' => $genbarcode,'barcode' =>$product->product_barcode],[], ['format' => [$w,$h]]);
            return $pdf->stream();
        }else{
        	dd($data);
        }
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
        
		// if($request->hasFile('uploadcover')){
			// File::delete('assets/images/product/'.$res->product_picture.'');
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
			
			// $files = $request->file('uploadcover');
			// $filename 	= $files->getClientOriginalName();
			// $extension 	= $files->getClientOriginalExtension();
			// $size		= $files->getSize();
			// $imgcover 		= date('His').$filename;
			// $destinationPath = base_path()."/assets/images/product/";
			// $files->move($destinationPath, $imgcover);
		// }
		
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
		
		
		$data = [
			'product_type'			=> $request->input('producttype'),
			'product_code'			=> $request->input('productcode'),
			'product_category'		=> $request->input('category'),
			'product_subcategory'	=> !empty($request->input('subcategory'))?$request->input('subcategory'):0,
			'product_name'			=> $request->input('productname'),
			'product_barcode'		=> $request->input('barcode'),
			'product_detail'		=> $request->input('productdetail'),
			'product_buy'			=> $request->input('productbuy'),
			'product_retail'		=> $request->input('productretail'),
			'product_retailnumber'		=> $request->input('productretailnumber'),
			'product_retailunit'		=> $request->input('productretailunit'),
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
		if($request->hasFile('uploadcover')){
			$imageproduct = DB::table('imageproduct')->where('imageproduct_productid',$request->input('updateid'))->get();
			if(!empty($imageproduct)){
				foreach ($imageproduct as $value) {
					File::delete('assets/images/product/'.$value->imageproduct_name);
					DB::table('imageproduct')->where('imageproduct_id',$value->imageproduct_id)->delete();
				}
			}
			
			$files_ = $request->file('uploadcover');
			foreach ($files_ as $value) {

				$files = $value;
				$filename 	= $files->getClientOriginalName();
				$extension 	= $files->getClientOriginalExtension();
				$size		= $files->getSize();
				$imgcover1 	= date('His').$filename;
				$destinationPath = base_path()."/assets/images/product/";
				$files->move($destinationPath, $imgcover1);
				$dataimg = [
					'imageproduct_productid'=> $request->input('updateid'),
					'imageproduct_name'		=> $imgcover1
				];
				DB::table('imageproduct')->insert($dataimg);
			}
		}
		
		savelog('1','แก้ไขข้อมูลสินค้า ลำดับที่'.$request->input('updateid').' จากชื่อ '.$res->product_name.' เป็นชื่อ '.$request->input('productname'));
		DB::table('product')->where('product_id',$request->input('updateid'))->update($data);
		Session::flash('alert-update','update');
		return redirect('product');
	}
	
	public function product_category(Request $request){
		$category = DB::table('category')->where('category_id',$request->input('id'))->first();
		// $product = DB::table('product')->where('product_type',$request->input('producttype'))->where('product_category',$request->input('id'))->orderBy('product_code','DESC')->first();
		$product = DB::table('product')->where('product_type',$request->input('producttype'))->where('product_category',$request->input('id'))->orderBy('product_code','ASC')->get();
		$search = [];
		foreach($product as $value){
			$barcode = substr($value->product_code,4);
			$search = DB::table('product')->where('product_type',$request->input('producttype'))->where('product_category',$request->input('id'))->whereRaw("SUBSTRING(product_code, 4,  4) LIKE '%".($barcode+1)."'")->first();
			if(empty($search)){
				break;
			}
		}
		// $barcode = substr($product->product_code,4);
		$json['data'] = $category->category_code;
		$json['count'] = $barcode+1;
		return Response::json($json);
	}
	
	public function destroy($id){
		$selling = DB::table("selling_detail")->where('sellingdetail_productid',$id)->get();
		$order = DB::table("orders")->where('order_productid',$id)->get();
		if(count($selling) > 0 || count($order) > 0){
			return response::json('X');
		}else{
			$res = DB::table('product')->where('product_id',$id)->first();
			File::delete('assets/images/product/'.$res->product_picture.'');
			File::delete('assets/images/product/thumbs/'.$res->product_thumbs.'');
			DB::table('product')->where('product_id',$id)->delete();
			DB::table('processingunit')->where('unit_productid',$id)->delete();
			savelog('1','ลบข้อมูลสินค้า ลำดับที่'.$res->product_id.' ชื่อ '.$res->product_name);
			return response::json('Y');
		}
		// Session::flash('alert-delete','delete');
		// return redirect('product');
		
	}
	public function cancel($id){
		$product = product::find($id);
		$product->product_status = '0';
		$product->save();
		return response::json('Y');
	}
    
    public function stock(Request $request){
        $arrcol = array();
        $result = array();
        $stock = stock::where('product_id',$request->get('id'))->orderBy('product_sale','asc')->get();
        foreach($stock AS $val){
            $arrcol['sale'] = number_format($val->product_sale,2);
            $arrcol['amt'] = $val->product_qty;
            $arrcol['size'] = $val->product_size;
            array_push($result,$arrcol);
        }
        
        return response()->json($result);
    }
    
    public function findunit(Request $request){
        $arrcol = array();
        $result = array();
        $text = '<option value="">-- เลือกหน่วยนับ --</option>';
        $unit = DB::table('processingunit')->where('unit_productid',$request->get('id'))->get();
        foreach($unit AS $valun){
        	$bigunit = DB::table('unit')->where('unit_id',$valun->unit_unitfirst)->first();
        	$smallunit = DB::table('unitsub')->where('unitsub_id',$valun->unit_unitsec)->first();
            if($valun->unit_unitfirst){
                $text.='<option value="1,'.$bigunit->unit_id.'">'.$bigunit->unit_name.'</option>';
            }
            if($valun->unit_unitsec){
                $text.='<option value="2,'.$smallunit->unitsub_id.'">'.$smallunit->unitsub_name.'</option>';
            }
        }
        return response()->json($text);
    }
    
    public function import(Request $request){
        $lastdata = importbyproduct::orderBy('imp_id','desc')->first();
        $orderno = '';
        if(!empty($lastdata)){
            $cutno = explode('/',$lastdata->imp_no);
            $newnum = (int)$cutno['1'] + 1;
            $orderno = 'AP'.date('my').'/'.sprintf("%04d",$newnum);
        }
        else{
            $orderno = 'AP'.date('my').'/0001';
        }
        
        $save = new importbyproduct;
        $save->imp_no                   = $orderno;
        // $save->supplier_id              = $request->input('supplier');
        $save->imp_date                 = date('Y-m-d');
        $save->impt_note                = 'เพิ่มข้อมูลจากหน้าสินค้า';
        $save->user_id                  = $request->input('userid');
        $save->save();
        savelog('1','เพิ่มข้อมูลการนำจาหน้าสินค้า ซัพพลายเออร์ชื่อ '.$request->input('suppliername'));
        
        $lastid = importbyproduct::latest()->first();
        
        $pro = $request->proid;
        $subsave = new subimportbyproduct;
        $dataproduct = product::where('product_id',$pro)->first();
        
        $rateitembigunit = 1;
        $explodeunit = explode(',',$request->input('unit'));
        $unit = $explodeunit[1];
        $typeunit = $explodeunit[0];
        if($typeunit == '1'){
            $processunit = processingunit::where('unit_productid',$pro)->where('unit_unitfirst',$unit)->first();
        }else{
            $processunit = processingunit::where('unit_productid',$pro)->where('unit_unitsec',$unit)->first();
            $rateitembigunit = $processunit->unit_total;
        }

        if($dataproduct->product_retailunit == 1){
            $sale = ($request->input('capital') + $dataproduct->product_retailnumber) * $rateitembigunit;
        }else{
            $sale = ($request->input('capital') + ($request->input('capital') * $dataproduct->product_retailnumber)/100 )* $rateitembigunit;
        }
        if($dataproduct->product_wholesaleunit == 1){
            $wholesale1 = ($request->input('capital') + $dataproduct->product_wholesalenumber) * $rateitembigunit;
        }else{
            $wholesale1 = ($request->input('capital') + ($request->input('capital') * $dataproduct->product_wholesalenumber)/100) * $rateitembigunit;
        }
        if($dataproduct->product_wholesale2unit == 1){
            $wholesale2 = ($request->input('capital') + $dataproduct->product_wholesale2number) * $rateitembigunit;
        }else{
            $wholesale2 = ($request->input('capital') + ($request->input('capital') * $dataproduct->product_wholesale2number)/100) * $rateitembigunit;
        }
        if($dataproduct->product_wholesale3unit == 1){
            $wholesale3 = ($request->input('capital') + $dataproduct->product_wholesale3number) * $rateitembigunit;
        }else{
            $wholesale3 = ($request->input('capital') + ($request->input('capital') * $dataproduct->product_wholesale3number)/100 )*$rateitembigunit;
        }
        
        $subsave->imp_id                    = $lastid->imp_id;
        $subsave->product_id                = $pro;
        $subsave->amount                    = $request->input('qty');
        $subsave->product_capital           = $request->input('capital');
        $subsave->product_sale              = $sale;
        $subsave->typyunit                  = $typeunit;
        $subsave->unit_id                   = $unit;
        // $subsave->product_size              = $request->input('size');
        $subsave->save();

        savelog('1','เพิ่มสินค้านำเข้าจากหน้าสินค้า ซัพพลายเออร์ชื่อ '.$request->input('suppliername').' รหัสสินค้า '.$dataproduct->product_code.' ชื่อสินค้า '.$dataproduct->product_name .' จำนวน '.$request->input('qty').' ราคา '.$request->input('capital'));

        $stock = stock::where('product_id',$pro)->where('product_sale',$request->input('sale'))->where('product_capital',$request->input('capital'))->where('product_size',$request->input('size'))->first();
        if($typeunit == '1'){
            $processunit = processingunit::where('unit_productid',$pro)->where('unit_unitfirst',$unit)->first();
        }else{
            $processunit = processingunit::where('unit_productid',$pro)->where('unit_unitsec',$unit)->first();
        }
        if($typeunit == '1'){
            if(!empty($processunit)){
                $unit_total = $processunit->unit_total;
            }else{
                $unit_total = 1;
            }
        }else{
            $unit_total = 1;
        }
        if(!empty($stock)){
            $savestock = stock::where('product_id',$pro)->where('product_sale',$request->input('sale'))->update([
                'product_qty'       => (($request->input('qty') * $unit_total) + $stock->product_qty),
            ]);
        }
        else{
            $savestock = new stock;
            $savestock->product_id          = $pro;
            $savestock->product_sale        = $sale;
            $savestock->product_qty         = ($request->input('qty') * $unit_total);
            $savestock->product_capital     = $request->input('capital');
            // $savestock->product_size        = $request->input('size')[$row];
            // dd($savestock);
            $savestock->save();
        }
        $allstock = stock::where('product_id',$pro)->sum('product_qty');
        // if($request->input('capital') > 0){ //แก้ถ้าราคาเป็น0ไม่ต้องอัพเดทราคาขาย
            $savepro = product::where('product_id',$pro)->update([
                // 'product_buy'            => $request->input('capital'),
                // 'product_qty'            => $allstock,
                'product_qty'            => $dataproduct->product_qty + ($request->input('qty')*$unit_total),
                // 'product_retail'         => $sale,
                // 'product_wholesale'      => $wholesale1,
                // 'product_wholesale2'     => $wholesale2,
                // 'product_wholesale3'     => $wholesale3,
            ]);
        // }
                
        // Session::flash('alert-insert','insert');
		return "Y";
        
    }
    
    public function historyimport(Request $request){
        $data = imports::join('sub_import_product','import_product.imp_id','=','sub_import_product.imp_id')
                        ->where('sub_import_product.product_id',$request->get('id'))
                        ->orderBy('import_product.imp_date','desc')
                        ->orderBy('import_product.imp_id','desc')
                        ->get();
        $text = '<table class="table table-bordered">';
        $text.= '<thead>';
        $text.= '<tr>';
        $text.= '<td class="text-center">วันที่</td><td class="text-center">เลขที่รายการ</td>';
        $text.= '<td class="text-center">ไซส์</td><td class="text-center">จำนวน</td>';
        $text.= '<td class="text-center">ราคาทุน</td><td class="text-center">ราคาขาย</td>';
        $text.= '</tr>';
        $text.= '</thead>';
        $text.= '<tbody>';
        if(!empty($data)){
            foreach($data AS $val){
                $unitname = DB::table('unit')->where('unit_id',$val->unit_id)->first();
                $text.='<tr>';
                $text.='<td>'.date('d/m/Y',strtotime($val->imp_date)).'</td>';
                $text.='<td>'.$val->product_size.'</td>';
                $text.='<td>'.$val->imp_no.'</td>';
                $text.='<td class="text-right">'.number_format($val->amount).' ';
                if(!empty($unitname)){
                    $text.=$unitname->unit_name.'</td>';
                }
                else{
                    $text.='&nbsp;</td>';
                }
                $text.='<td class="text-right">'.number_format($val->product_capital,2).'</td>';
                $text.='<td class="text-right">'.number_format($val->product_sale,2).'</td>';
                $text.='</tr>';
            }
        }
        $text.= '</tbody>';
        /*$text.= '<tfoot>';
        $text.= '<tr><td colspan="5" class="text-right">'.$data->links().'</td></tr>';
        $text.= '</tfoot>';*/
        $text.= '</table>';
        
        return response()->json($text);
    }
    
    public function historysale(Request $request){
        $data = DB::table('export')
                    ->join('orders','export.export_id','=','orders.order_ref')
                    ->where('orders.order_productid',$request->get('id'))
                    ->orderBy('export.export_date','desc')
                    ->orderBy('export.export_id','desc')
                    ->get();
        
        $unitname = DB::table('processingunit')
                    ->join('unit','processingunit.unit_unitfirst','=','unit.unit_id')
                    ->where('processingunit.unit_unitfirst',$request->get('id'))
                    ->where('processingunit.unit_total',1)
                    ->first();
        
        $text = '<table class="table table-bordered">';
        $text.= '<thead>';
        $text.= '<tr>';
        $text.= '<td class="text-center">วันที่</td><td class="text-center">เลขที่รายการ</td>';
        $text.= '<td class="text-center">ไซส์</td><td class="text-center">ราคา</td>';
        $text.= '<td class="text-center">จำนวน</td><td class="text-center">ยอดรวม</td>';
        $text.= '</tr>';
        $text.= '</thead>';
        $text.= '<tbody>';
        if(!empty($data)){
            foreach($data AS $val){
                $text.='<tr>';
                $text.='<td>'.date('d/m/Y',strtotime($val->export_date)).'</td>';
                $text.='<td>'.$val->export_inv.'</td>';
                $text.='<td>'.$val->product_size.'</td>';
                $text.='<td class="text-right">'.number_format($val->order_price,2).'</td>';
                $text.='<td class="text-right">'.number_format($val->order_qty).' ';
                if(!empty($unitname)){
                    $text.=$unitname->unit_name.'</td>';
                }
                else{
                    $text.='&nbsp;</td>';
                }
                $text.='<td class="text-right">'.number_format($val->order_total,2).'</td>';
                $text.='</tr>';
            }
        }
        $text.= '</tbody>';
        /*$text.= '<tfoot>';
        $text.= '<tr><td colspan="5" class="text-right">'.$data->links().'</td></tr>';
        $text.= '</tfoot>';*/
        $text.= '</table>';
        
        return response()->json($text);
    }
    
    public function historyexport(Request $request){
        $data = DB::table('exp')
                    ->join('subexp','exp.exp_id','=','subexp.subexp_ref')
                    ->where('subexp.subexp_productid',$request->get('id'))
                    ->orderBy('exp.exp_date','desc')
                    ->orderBy('exp.exp_id','desc')
                    ->get();
        
        $unitname = DB::table('processingunit')
                    ->join('unit','processingunit.unit_unitfirst','=','unit.unit_id')
                    ->where('processingunit.unit_unitfirst',$request->get('id'))
                    ->where('processingunit.unit_total',1)
                    ->first();
        
        $text = '<table class="table table-bordered">';
        $text.= '<thead>';
        $text.= '<tr>';
        $text.= '<td class="text-center">วันที่</td><td class="text-center">เลขที่รายการ</td>';
        $text.= '<td class="text-center">ไซส์</td><td class="text-center">จำนวน</td>';
        $text.= '</tr>';
        $text.= '</thead>';
        $text.= '<tbody>';
        if(!empty($data)){
            foreach($data AS $val){
                $text.='<tr>';
                $text.='<td>'.date('d/m/Y',strtotime($val->exp_date)).'</td>';
                $text.='<td>'.$val->exp_inv.'</td>';
                $text.='<td>'.$val->product_size.'</td>';
                $text.='<td class="text-right">'.number_format($val->order_qty).' ';
                if(!empty($unitname)){
                    $text.=$unitname->unit_name.'</td>';
                }
                else{
                    $text.='&nbsp;</td>';
                }
                $text.='</tr>';
            }
        }
        $text.= '</tbody>';
        /*$text.= '<tfoot>';
        $text.= '<tr><td colspan="5" class="text-right">'.$data->links().'</td></tr>';
        $text.= '</tfoot>';*/
        $text.= '</table>';
        
        return response()->json($text);
    }
    public function savecategory(Request $request){
    	$data = array(
			'category_name'		=> $request->input('categoryname'),
			'created_at'		=> new DateTime(),
			'updated_at'		=> new DateTime(),
		);
		
		DB::table('category')->insert($data);
		$category = DB::table('category')->get();
		// Session::flash('alert-insert','insert');
    	return Response::json($category);
    }
    public function saveunit(Request $request){
    	$data = array(
			'unit_name'		=> $request->input('unit'),
			'created_at'	=> new DateTime(),
			'updated_at'	=> new DateTime(),
		);
		$data2 = array(
			'unitsub_name'	=> $request->input('unit'),
			'created_at'	=> new DateTime(),
			'updated_at'	=> new DateTime(),
		);
		DB::table('unit')->insert($data);
		DB::table('unitsub')->insert($data2);
		$unit = DB::table('unit')->get();
		$unitsub = DB::table('unitsub')->get();
		$json[0] = $unit;
		$json[1] = $unitsub;
		savelog('1','เพิ่มข้อมูลหน่วย '.$request->input('unit'));
		// Session::flash('alert-insert','insert');
    	return Response::json($json);
    }

    public function productchangecode($producttype){
    	$category = DB::table('category')->orderBy('category_code','asc')->get();
    	foreach($category as $keys => $values){
	    	$product = DB::table('product')->leftjoin('category','category_id','product_category')->where('product_type',$producttype)->where('product_category',$values->category_id)->where('product_id','>','10')->get();
	    	foreach ($product as $key => $value) {
	    		$value->product_code = $value->product_type.str_pad($value->category_code,2,'0',STR_PAD_LEFT).str_pad(($key+1),4,'0',STR_PAD_LEFT);
	    		$product_barcode = $value->product_type.str_pad($value->category_code,2,'0',STR_PAD_LEFT).'00000'.str_pad(($key+1),4,'0',STR_PAD_LEFT);
	    		$digit = (3*((substr($product_barcode,1,1))+(substr($product_barcode,3,1))+(substr($product_barcode,5,1))+(substr($product_barcode,7,1))+(substr($product_barcode,9,1))+(substr($product_barcode,11,1))))+((substr($product_barcode,0,1))+(substr($product_barcode,2,1))+(substr($product_barcode,4,1))+(substr($product_barcode,6,1))+(substr($product_barcode,8,1))+(substr($product_barcode,10,1)));
	    		$digit = $digit%10;
	    		$value->product_barcode = $value->product_type.str_pad($value->category_code,2,'0',STR_PAD_LEFT).'00000'.str_pad(($key+1),4,'0',STR_PAD_LEFT).$digit;
	    		$data = [
	    			// 'product_id'		=>  $value->product_id,
	    			'product_code'		=>  $value->product_code,
	    			'product_barcode'	=>  $value->product_barcode
	    		];
	    		// dd($data);
	    		DB::table('product')->where('product_id',$value->product_id)->update($data);

	    	}
	    }
    	// dd($data);
    }

    public function checkproductcode(Request $request){
    	$product = product::where('product_code',$request->productcode)->count();
    	return response::json($product);
    }

    public function gencodeproduct(Request $request){
		$d = new DNS1D();
		$d->setStorPath(__DIR__."/cache/");
		$genbarcode = $d->getBarcodePNG($request->barcode, "EAN13",2,43);
		return response::json($genbarcode);
    }

    public function printbarcode($barcode){
		$d = new DNS1D();
		$d->setStorPath(__DIR__."/cache/");
		$genbarcode = $d->getBarcodePNG(substr($barcode,0,12), "EAN13",2,43);
		if(!empty($genbarcode)){ 
            $pdf = PDF::loadView('product/genbarcode',['genbarcode' => $genbarcode,'barcode' =>$barcode],[], ['format' => [100,28]]);
            return $pdf->stream();
        }else{
        	dd($data);
        }
		// return Response::json($product);
	}

	public function fileupload(Request $request){
		if($request->hasFile('uploadcover')){
			$files_ = $request->file('uploadcover');
			foreach ($files_ as $value) {
				$files = $value;
				$filename 	= $files->getClientOriginalName();
				$extension 	= $files->getClientOriginalExtension();
				$size		= $files->getSize();
				$imgcover1 	= date('His').$filename;
				$destinationPath = base_path()."/assets/images/product/upload";
				$files->move($destinationPath, $imgcover1);
			}
			return response()->json($imgcover1);
		}
	}

	public function saveproc(Request $request){
		$processingunit = processingunit::find($request->id);
		savelog('1','แก้ไขข้อมูลหน่วยใหญ่ต่อหน่วยย่อย เลขที่สินค้า'.$processingunit->unit_productid.' จาก '.$processingunit->unit_total.' เป็น '.$request->number);
		// dd($processingunit);
		$processingunit->unit_unitfirst = $request->bunit;
		$processingunit->unit_unitsec = $request->sunit;
		$processingunit->unit_total = $request->number;
		$processingunit->save();
		return Response::json(1);
	}
}
