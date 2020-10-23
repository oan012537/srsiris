@extends('../template')

@section('content')
	<!-- Page header -->
	<!--<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Product / Create
				</h4>
			</div>
		</div>
	</div>-->
	<!-- /page header -->
	<style type="text/css">
		.classproduct{
			background: rgb(199,199,199,0.3);
		}
		.checkproductcode,.checkproductcode:focus {
			border: 2px solid red;
		}
	</style>

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">
				<div class="row">
					<div class="col-md-12">
						<!-- Vertical form -->
						<div class="panel panel-flat">
							<div class="panel-heading">
								<div class="heading-elements">
									<ul class="icons-list">
										<li><a data-action="collapse"></a></li>
										<li><a data-action="reload"></a></li>
										<li><a data-action="close"></a></li>
									</ul>
								</div>
							</div>
							
							<form method="post" action="{{url('product_create')}}" id="formproduct" enctype="multipart/form-data" onsubmit="return checkdata();">
							{{ csrf_field() }}
							<input type="hidden" name="lastid" id="lastid" value="{{ $lastid }}">
							<input type="hidden" name="countitem" id="countitem">
							<input type="hidden" class="form-control" name="uploadimage" id="uploadimage">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6 col-md-6 col-md-offset-3">
										<fieldset>
											<legend class="text-semibold">รายละเอียดสินค้า</legend>
											<div class="form-group">
												<label>รูปสินค้า :</label>
												{{-- <input type="file" class="file-input" name="uploadcover" required> --}}
												<div class="file-loading"> 
													<input type="file" id="uploadcover" name="uploadcover[]" multiple >
												</div>
												<span class="help-block">ขนาดรูป : 305 x 425px</span>
											</div>
											<div class="form-group">
												<label>ประเภท :</label>
												<div class="input-control">
													<div class="radio">
														<label>
															<input type="radio" class="styled" name="producttype" id="producttype1" value="2" checked="checked">สินค้าผลิตเอง
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" class="styled" name="producttype" id="producttype2" value="1">สินค้าซื้อเข้ามา
														</label>
													</div>
												</div>
											</div>
											<div class="row" style="margin-bottom: 20px;position: relative;">
												<div class="form-group">
													<div class="col-md-11">
														<label>หมวดหมู่สินค้า :</label>
														<select class="form-control" name="category" id="category" required>
															<option value="">เลือก</option>
															@php
																if($category){
																	foreach($category as $rs){
																		@endphp
																			<option value="{{$rs->category_id}}">{{$rs->category_name}}</option>
																		@php
																	}
																}
															@endphp
														</select>
														<input type="hidden" class="form-control" name="categorycode" id="categorycode">
													</div>
													
													<div class="col-md-1">
														<label>&nbsp</label>
														<div class="input-control">
															<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square"></i>  เพิ่ม</button>
														</div>
													</div>
													{{-- <div class="col-md-3  col-md-offset-2">
														<label>หมวดหมู่ย่อย :</label>
														<select class="form-control" name="subcategory" id="subcategory" style="width:250px;"></select>
													</div> --}}
												</div>
											</div>
											<div class="row" style="margin-bottom: 20px;position: relative;">
												<div class="form-group">
													<div class="col-md-11">
														<label>รหัสสินค้า :</label>
														<input type="text" class="form-control" name="productcode" id="productcode" required>
													</div>
													<div class="col-md-1 ">
														<label>&nbsp</label>
														<div class="input-control">
															<button type="button" class="btn btn-primary" onclick="gencodeproduct();"> Generated</button>
														</div>
													</div>
												</div>
											</div>
											
											<div class="form-group">
												<label>ชื่อสินค้า :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="productname" id="productname" placeholder="Product" required>
												</div>
											</div>
											
											<div class="form-group">
												<label>บาร์โค้ด :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="barcode" id="barcode" placeholder="Barcode" maxlength="13">
												</div>
											</div>
											<div id="showbarcode" style="text-align: center;"></div>
											<div class="form-group">
												<label>รายละเอียดสินค้า :</label>
												<div class="input-control">
													<textarea rows="3" cols="5" class="form-control" name="productdetail" required></textarea>
												</div>
											</div>
										
											<div class="row">
												<div class="form-group">
													<div class="col-md-3">
														<label>ราคาทุน :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productbuy" id="productbuy" value="0" required style="width:250px;">
														</div>
													</div>
													
													<div class="col-md-3  col-md-offset-2">
														
													</div>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="form-group">
													<div class="col-md-3">
														<label>กำไรที่ต้องการ(ขายปลีก) :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productretail" id="productretail" value="{{ $setting->set_price }}" required style="width:250px;">
														</div>
													</div>
													<div class="col-md-2  col-md-offset-2">
														<label>&nbsp</label>
														<div class="input-control">
															<select class="form-control" name="productretailunit" id="productretailunit">
																<option value="1">บาท</option>
																<option value="2" selected>%</option>
															</select>
														</div>
													</div>
												</div>
											</div>
											<br>
											<legend class="text-semibold">กำหนดราคาขายจากราคาต้นทุน</legend>
											<div class="row">
												<div class="form-group">
													<div class="col-md-2">
														<label>ราคาขายส่ง1 :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productwholesale" id="productwholesale" value="{{ $setting->set_price1 }}" required>
														</div>
													</div>
													<div class="col-md-2 ">
														<label>&nbsp</label>
														<div class="input-control">
															<select class="form-control" name="productwholesaleunit">
																<option value="1">บาท</option>
																<option value="2" selected>%</option>
															</select>
														</div>
													</div>
													<div class="col-md-2 ">
														<label>ราคาขายส่ง2 :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productwholesale2" id="productwholesale2" value="{{ $setting->set_price2 }}" required>
														</div>
													</div>
													<div class="col-md-2 ">
														<label>&nbsp</label>
														<div class="input-control">
															<select class="form-control" name="productwholesaleunit2">
																<option value="1">บาท</option>
																<option value="2" selected>%</option>
															</select>
														</div>
													</div>
													<div class="col-md-2">
														<label>ราคาขายส่ง3 :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productwholesale3" id="productwholesale3" value="{{ $setting->set_price3 }}" required>
														</div>
													</div>
													<div class="col-md-2 ">
														<label>&nbsp</label>
														<div class="input-control">
															<select class="form-control" name="productwholesaleunit3">
																<option value="1">บาท</option>
																<option value="2" selected>%</option>
															</select>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="form-group">
													<div class="col-md-3">
														<label>ราคาโปรโมชั่น :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productpromotion" id="productpromotion" value="0" style="width:250px;">
														</div>
													</div>
													
													<div class="col-md-3  col-md-offset-2">
														
													</div>
												</div>
											</div>
											
											<br>
											<div class="row">
												<div class="form-group">
													<div class="col-md-3">
														<label>วันที่เริ่มโปรโมชั่น :</label>
														<div class="input-control">
															<input type="text" name="productprodate" id="productprosdate" class="form-control datepicker-dates" onkeydown="return false;" autocomplete="off" style="width:250px;">
														</div>
													</div>
													
													<div class="col-md-3  col-md-offset-2">
														<label>วันที่สิ้นสุดโปรโมชั่น :</label>
														<div class="input-control">
															<input type="text" name="productprodate" id="productproedate" class="form-control datepicker-dates" onkeydown="return false;" autocomplete="off" style="width:250px;">
														</div>
													</div>
												</div>
											</div>
										
											<br>
											<div class="row">
												<div class="form-group">
													<div class="col-md-3">
														<label>จำนวนขั้นต่ำ สต๊อกสินค้า :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productmin" id="productmin" value="0" required style="width:250px;">
														</div>
													</div>
												</div>
											</div>
											
											<br>
											
											<div class="form-group">
												<label>วันที่หมดอายุ :</label>
												<div class="input-control">
													<input type="text" name="dateexpire" id="dateexpire" class="form-control datepicker-dates" onkeydown="return false;" autocomplete="off" style="width:250px;">
												</div>
											</div>
											
											
											<div class="form-group">
												<label>หน่วยสินค้า :</label>
												<select class="form-control" name="productunit" id="productunit" required style="width:250px;">
													<option value="">เลือก</option>
													@php
														if($unit){
															foreach($unit as $rs){
																@endphp
																	<option value="{{$rs->unit_id}}">{{$rs->unit_name}}</option>
																@php
															}
														}
													@endphp
												</select>
											</div>
											
											<legend class="text-semibold">หน่วยสินค้านำเข้า</legend>
											<input type="hidden" id="countrow" value="1">
											<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<label>หน่วยสินค้าใหญ่ :</label>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>หน่วยสินค้าย่อย :</label>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>รวม :</label>
													</div>
												</div>
												<div class="col-md-1">
													<div class="form-group">
														<label>#</label>
													</div>
												</div>
											</div>
											
											<div class="row">	
												<div id="rowunit">
													<div id="dataunit1">
														<div class="col-md-3">
															<div class="form-group">
																<select class="form-control" name="bunit[]" required style="width:150px;">
																	<option value="">เลือก</option>
																	@php
																		if($unit){
																			foreach($unit as $rs){
																				@endphp
																					<option value="{{$rs->unit_id}}">{{$rs->unit_name}}</option>
																				@php
																			}
																		}
																	@endphp
																</select>
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<select class="form-control" name="unit[]" required style="width:150px;">
																	<option value="">เลือก</option>
																	@php
																		if($unitsub){
																			foreach($unitsub as $rs){
																				@endphp
																					<option value="{{$rs->unitsub_id}}">{{$rs->unitsub_name}}</option>
																				@php
																			}
																		}
																	@endphp
																</select>
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control number" name="total[]" required>
															</div>
														</div>
														<div class="col-md-1">
															<div class="form-group">
																<button type="button" class="btn btn-success btn-icon addrow"><i class="icon-plus-circle2"></i></button>
															</div>
														</div>
														<div class="col-md-1">
															<div class="input-control">
																<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalUnit"><i class="fa fa-plus-square"></i>  เพิ่ม</button>
															</div>
														</div>
													</div>
												</div>
											</div>
											<hr>
								
                                            <br>
                                            <div class="row">
												<div class="form-group">
													<div class="col-md-3">
														<label>สินค้าแนะนำ :</label>
														<label class="checkbox-inline checkbox-switchery checkbox-right switchery-md" style="margin-top: -13px;">
															<input type="checkbox" class="switch" value="off">
                                                            <input type="hidden" name="recommended" id="recommended" value="off">
														</label>
													</div>
												</div>
											</div>
											
											<br>
											<div class="text-right">
												<a href="{{url('product')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
												<button type="submit" class="btn btn-primary"><i class="icon-floppy-disk"></i>  บันทึก</button>
											</div>
										</fieldset>
									</div>
								</div>
								</form>
							</div>
						</div>
						<!-- /vertical form -->
					</div>
				</div>
			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<form method="post" action="category_create" id="formcategory" onsubmit="return savecategory();">
		{{ csrf_field() }}
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">เพิ่ม</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						  <div class="form-group">
							<label>ชื่อหมวดหมู่ : </label>
							<input type="text" class="form-control" name="categoryname" id="categoryname" required>
						  </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">ปิด</button>
						<button type="submit" class="btn btn-primary waves-effect waves-light ">บันทึก</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<form method="post" action="unit_create" id="formunit" onsubmit="return saveunit();">
		{{ csrf_field() }}
		<div class="modal fade" id="myModalUnit" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">เพิ่ม</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						  <div class="form-group">
							<label>ชื่อหน่วย : </label>
							<input type="text" class="form-control" name="unit" id="unit" required>
						  </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">ปิด</button>
						<button type="submit" class="btn btn-primary waves-effect waves-light ">บันทึก</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!-- /page container -->
<script>
	var options = '';
	var checkimage = false;
    var imageadd = [];
	$(document).ready(function(){
        var switches = Array.prototype.slice.call(document.querySelectorAll('.switch'));
		switches.forEach(function(html) {
			var switchery = new Switchery(html, {color: '#4CAF50'});
		});
        
		$.ajax({
		'dataType': 'json',
		'type': 'post',
		'url': "{{url('queryunit')}}",
		'data': {
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data) {
				$.each(data,function(key,item){
					options += '<option value="'+item.unit_id+'">'+item.unit_name+'</option>';
				});
			}
		});

		// $("#uploadcover").fileinput({
	 //        uploadUrl: '/file-upload-batch/2',
	 //        showUpload: false,
	 //        maxFilePreviewSize: 10240,
	 //        maxFileCount: 8,
	 //    });
	    $("#uploadcover").fileinput({
	        maxFilePreviewSize: 10240,
	        // showUpload: false,
	        maxFileCount: 8,
	        showUpload: false,
			fileActionSettings: {
				showRemove: false,
				showZoom: true,
				showUpload: false,
				showCaption: false,
				showSize: false,
			},
			append: true,
    		// initialPreview:shopdata,
    		initialPreviewAsData: true,
    		// initialPreviewConfig:configimages,
	        uploadUrl: 'product/file-upload',
	        uploadAsync: true,
		    uploadExtraData: function() {

                return {
                    _token: $("input[name='_token']").val(),

                };

            },
	        maxFilePreviewSize: 10240,
	        maxFileCount: 8,
	        maxFileSize: 1024,
	        slugCallback: function (data) {
                return data;

            }
	    }).on('fileuploaded', function(event, data, previewId, index) {
		    var response = data.response;
		    imageadd.push(response);
	        
	        var count = $("#imageshop").fileinput("getFilesCount");
	        if(count == 1){
	        	console.log($("#imageshop").val())
	        }
		    
		}).on('fileclear', function(event) {
			imageadd = [];
		    console.log("fileclear");
		}).on('filebatchuploadcomplete', function(event, preview, config, tags, extraData) {
	        // console.log('File Batch Uploaded', preview, config, tags, extraData);
	        
        	$("#uploadimage").val(imageadd);
        	checkimage = true;
        	$("#formproduct").submit();
        	// uploadiamge();
	    });
	});
    
    $(document).on('click','.switchery',function(){
		var check = $(this).parent().find('input').val();
		if(check == 'on'){
			$(this).parent().find('input').val("off");
		}else{
			$(this).parent().find('input').val("on");
		}
	});
    
	
	$('#category,input[name="producttype"]').change(function(){
		var producttype = $("input[name='producttype']:checked").val();
		$.ajax({
		'dataType': 'json',
		'type': 'post',
		'url': "{{url('product_category')}}",
		'data': {
			'producttype':producttype,
			'id': $('#category').val(),
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data) {
				$('#categorycode').val(data.data);
				$('#countitem').val(data.count);
				// $('#subcategory').html('');
				// $.each(data,function(key,item){
				// 	$('#subcategory').append('<option value="'+item.sub_id+'">'+item.sub_name+'</option>');
				// });

			}
		});
	});
	
	$('.addrow').click(function(){
		var countrow 	= $('#countrow').val();
		var sumrow 		= parseInt(countrow)+1;
		$('#countrow').val(sumrow);
		$('#rowunit').append('<div id="dataunit'+sumrow+'">'
			+'<div class="col-md-3">'
				+'<div class="form-group">'
					+'<select class="form-control" name="bunit[]" required style="width:150px;"><option value="">Choose</option>'+options+'</select>'
				+'</div>'
			+'</div>'
			+'<div class="col-md-3">'
				+'<div class="form-group">'
					+'<select class="form-control" name="unit[]" required style="width:150px;"><option value="">Choose</option>'+options+'</select>'
				+'</div>'
			+'</div>'
			+'<div class="col-md-3">'
				+'<div class="form-group">'
					+'<input type="text" class="form-control" name="total[]" required>'
				+'</div>'
			+'</div>'
			+'<div class="col-md-3">'
				+'<div class="form-group">'
					+'<button type="button" class="btn btn-success btn-icon" onclick="addrow()"><i class="icon-plus-circle2"></i></button>'
					+'<button type="button" class="btn btn-danger btn-icon minus" onclick="del('+ sumrow +')"><i class="icon-minus-circle2"></i></button>'
				+'</div>'
			+'</div>'
		+'</div>');
	});
	
	function addrow(){
		var countrow 	= $('#countrow').val();
		var sumrow 		= parseInt(countrow)+1;
		$('#countrow').val(sumrow);
		$('#rowunit').append('<div id="dataunit'+sumrow+'">'
			+'<div class="col-md-3">'
				+'<div class="form-group">'
					+'<select class="form-control" name="bunit[]" required style="width:150px;"><option value="">Choose</option>'+options+'</select>'
				+'</div>'
			+'</div>'
			+'<div class="col-md-3">'
				+'<div class="form-group">'
					+'<select class="form-control" name="unit[]" required style="width:150px;"><option value="">Choose</option>'+options+'</select>'
				+'</div>'
			+'</div>'
			+'<div class="col-md-3">'
				+'<div class="form-group">'
					+'<input type="text" class="form-control" name="total[]" required>'
				+'</div>'
			+'</div>'
			+'<div class="col-md-3">'
				+'<div class="form-group">'
					+'<button type="button" class="btn btn-success btn-icon" onclick="addrow()"><i class="icon-plus-circle2"></i></button>'
					+'<button type="button" class="btn btn-danger btn-icon minus" onclick="del('+ sumrow +')"><i class="icon-minus-circle2"></i></button>'
				+'</div>'
			+'</div>'
		+'</div>');
	}
	
	function del(id){
		var countrow 	= $('#countrow').val();
		var sumrow 		= parseInt(countrow)-1;
		$('#countrow').val(sumrow);
		$('#dataunit'+id).remove();
	}
	function savecategory(){

		var form = $("#formcategory").serialize();
		$.ajax({
			url: "{{url('product/savecategory')}}",
			type: 'post',
			dataType: 'json',
			data: form,
			success:function(result){
				var appen = '<option value="">เลือก</option>';
				$.each(result,function(key,value){
					appen += '<option value="'+value.category_id+'">'+value.category_name+'</option>';
				});
				$("#categoryname").val('');
				$("#category").empty().append(appen);
			}
		});
		return false;
	}
	function saveunit(){

		var form = $("#formunit").serialize();
		$.ajax({
			url: "{{url('product/saveunit')}}",
			type: 'post',
			dataType: 'json',
			data: form,
			success:function(result){
				var appen = '<option value="">เลือก</option>';
				var appensub = '<option value="">เลือก</option>';
				$.each(result[0],function(key,value){
					appen += '<option value="'+value.unit_id+'">'+value.unit_name+'</option>';
				});
				$.each(result[1],function(key,value){
					appensub += '<option value="'+value.unitsub_id+'">'+value.unitsub_name+'</option>';
				});
				$("#unit").val('');
				$("select[name='bunit[]']").empty().append(appen);
				$("select[name='unit[]']").empty().append(appensub);
			}
		});
		return false;
	}
	function padLeft(nr, n, str){
	    return Array(n-String(nr).length+1).join(str||'0')+nr;
	}
	function gencodeproduct(){
		var producttype = $("input[name='producttype']:checked").val();
		var category = $("#category").val(); //เก่าเอาidมาใช้
		var lastid = $("#lastid").val();
		var code = '';
		var category = $("#categorycode").val();  //เอารหัสโค้ดมาใช้
		var lastid = $("#countitem").val();  //เอาจำนวนต่อจากหมวดเดิม
		if(!category){
			alert("กรุณาเลือกหมวดหมู่สินค้าเพื่อทำการสร้างรหัสสินค้า");
			return false;
		}
		code = producttype+padLeft(category,2)+padLeft(lastid,4);
		$("#productcode").val(code);
		barcode = producttype+padLeft(category,2)+'00000'+padLeft(lastid,4);
		var digit = (3*(parseInt(barcode.substr(0,1))+parseInt(barcode.substr(2,1))+parseInt(barcode.substr(4,1))+parseInt(barcode.substr(6,1))+parseInt(barcode.substr(8,1))+parseInt(barcode.substr(10,1)))) + parseInt(barcode.substr(1,1))+parseInt(barcode.substr(3,1))+parseInt(barcode.substr(5,1))+parseInt(barcode.substr(7,1))+parseInt(barcode.substr(9,1))+parseInt(barcode.substr(11,1));
		digit = digit%10;
		var barcode_ = barcode+''+digit;
		$.ajax({
			url: "{{url('product/gencodeproduct')}}",
			type: 'post',
			dataType: 'json',
			data: {'barcode':barcode,'_token': "{{ csrf_token() }}"},
			success:function(result){
				if(result != ''){
					$("#showbarcode").empty().append('<div class="col-md-12"><img src="data:image/png;base64,'+result+'" style="width: 100%;" alt="barcode" class="barcode" /></div><button type="button" class="btn btn-primary" onclick="printbarcode('+barcode_+')">พิมพ์</button>');
				}else{
				}
			}
		});
		$("#barcode").val(barcode+''+digit);

	}
	$("#productcode").keyup(function(event) {
		checkproductcode();
	});
	$("#productcode").change(function(event) {
		checkproductcode();
	});
	function checkproductcode(){
		var productcode = $("#productcode").val();
		$.ajax({
			url: "{{url('product/checkproductcode')}}",
			type: 'post',
			dataType: 'json',
			data: {'productcode':productcode,'_token': "{{ csrf_token() }}"},
			success:function(result){
				console.log(result)
				if(result > 0){
					$("#productcode").addClass('checkproductcode');
				}else{
					$("#productcode").removeClass('checkproductcode');
				}
			}
		});
	}
	function checkdata(){
		var checkproductcode = $("#productcode").hasClass('checkproductcode');
		if(checkproductcode){
			$("#productcode").focus();
			return false;
		}else{
			if($(".file-preview-frame").length == 0){
	    		return true;
	    	}else{
	    		if(!checkimage){
	    			$("#uploadcover").fileinput('upload');
	    			console.log($(".file-preview-frame").length)
	    			return false;
	    		}else{
	    			console.log(imageadd)
	    			return checkimage;
	    		}
	    	}
			// return true;
		}
	}

	function printbarcode(barcode){
		window.open('product/printbarcode/'+barcode);
	}
</script>
@stop