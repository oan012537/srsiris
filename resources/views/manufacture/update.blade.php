@extends('../template')

@section('content')
	<!-- Page header -->
	<!--<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Product / Update
				</h4>
			</div>
		</div>
	</div>-->
	<!-- /page header -->
	<style type="text/css">
		.classproduct{
			background: rgb(199,199,199,0.3);
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
							
							<form method="post" action="{{url('manufacture/update')}}" enctype="multipart/form-data">
							{{ csrf_field() }}
							<input type="hidden" name="updateid" value="{{$product->product_id}}">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6 col-md-6 col-md-offset-3">
										<fieldset>
											<legend class="text-semibold">รายละเอียดสินค้า</legend>
											<div class="form-group">
												<label>รูปสินค้า :</label>
												{{-- <input type="file" class="file-input" name="uploadcover"> --}}
												<div class="file-loading"> 
													<input type="file" id="uploadcover" name="uploadcover[]" multiple >
												</div>
												<span class="help-block">ขนาดรูป : 305 x 425px</span>
												@if(!empty($product->product_thumbs))
													<img src="{{asset('assets/images/product')}}/{{$product->product_thumbs}}" width="300px" class="img-thumbnail">
												@endif
											</div>
											<div class="form-group">
												<label>ประเภท :</label>
												<div class="input-control">
													<div class="radio">
														<label>
															<input type="radio" class="styled" name="producttype" id="producttype1" value="1" checked="checked">สินค้าผลิตเอง
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" class="styled" name="producttype" id="producttype2" value="2">สินค้าซื้อเข้ามา
														</label>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>รหัสสินค้า :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="productcode" id="productcode" value="{{$product->product_code}}" required>
												</div>
											</div>
											
											<div class="form-group">
												<label>ชื่อสินค้า :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="productname" id="productname" value="{{$product->product_name}}" placeholder="Product" required>
												</div>
											</div>
											
											<div class="form-group">
												<label>บาร์โค้ด :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="barcode" id="barcode" placeholder="Barcode" required value="{{$product->product_barcode}}">
												</div>
											</div>

											<div class="form-group">
												<label>รายละเอียดสินค้า :</label>
												<div class="input-control">
													<textarea rows="3" cols="5" class="form-control" name="productdetail" required>{{$product->product_detail}}</textarea>
												</div>
											</div>
										
											<div class="row">
												<div class="form-group">
													<div class="col-md-3">
														<label>ราคาทุน :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productbuy" id="productbuy" required style="width:250px;" value="{{$product->product_buy}}">
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
														<label>ราคาขายปลีก :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productretail" id="productretail" required style="width:250px;" value="{{$product->product_retail}}">
														</div>
													</div>
													<div class="col-md-2  col-md-offset-2">
														<label>&nbsp</label>
														<input type="text" class="form-control number" name="productretailnumber" id="productretailnumber" required style="width:250px;" value="{{$product->product_retailnumber}}" onkeyup="putpriceprofit()">
													</div>
													<div class="col-md-2  col-md-offset-3">
														<label>&nbsp</label>
														<div class="input-control">
															<select class="form-control" name="productretailunit" id="productretailunit" onchange="putpriceprofit()">
																<option value="1">บาท</option>
																<option value="2">%</option>
															</select>
														</div>
													</div>
												</div>
											</div>
											<br>
											<legend class="text-semibold">กำหนดราคาขายจากราคาต้นทุน</legend>
											<div class="row">
												<div class="form-group">
													<div class="col-md-3">
														<label>ราคาขายส่ง1 :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productwholesale" id="productwholesale" value="{{$product->product_wholesale}}" readonly>
														</div>
													</div>
													<div class="col-md-3">
														<label>กำไรจากราคาต้นทุน :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productwholesalenumber" id="productwholesalenumber" value="{{$product->product_wholesalenumber}}" required onkeyup="putpercenprofit('')">
														</div>
													</div>
													<div class="col-md-2 ">
														<label>&nbsp</label>
														<div class="input-control">
															<select class="form-control" name="productwholesaleunit" id="productwholesaleunit" onchange="putpercenprofit('')">
																<option value="1" @if($product->product_wholesaleunit == '1')selected @endif>บาท</option>
																<option value="2" @if($product->product_wholesaleunit == '2')selected @endif>%</option>
															</select>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="form-group">
													<div class="col-md-3">
														<label>ราคาขายส่ง2 :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productwholesale2" id="productwholesale2" value="{{$product->product_wholesale2}}" readonly>
														</div>
													</div>
													<div class="col-md-3">
														<label>กำไรจากราคาต้นทุน :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productwholesale2number" id="productwholesale2number" value="{{$product->product_wholesale2number}}" required onkeyup="putpercenprofit(2)">
														</div>
													</div>
													<div class="col-md-2 ">
														<label>&nbsp</label>
														<div class="input-control">
															<select class="form-control" name="productwholesale2unit" id="productwholesale2unit" onchange="putpercenprofit(2)">
																<option value="1" @if($product->product_wholesale2unit == '1')selected @endif>บาท</option>
																<option value="2" @if($product->product_wholesale2unit == '2')selected @endif>%</option>
															</select>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="form-group">
													<div class="col-md-3">
														<label>ราคาขายส่ง3 :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productwholesale3" id="productwholesale3" value="{{$product->product_wholesale3}}" readonly>
														</div>
													</div>
													<div class="col-md-3">
														<label>กำไรจากราคาต้นทุน :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productwholesale3number" id="productwholesale3number" value="{{$product->product_wholesale3number}}" required onkeyup="putpercenprofit(3)">
														</div>
													</div>
													<div class="col-md-2 ">
														<label>&nbsp</label>
														<div class="input-control">
															<select class="form-control" name="productwholesale3unit" id="productwholesale3unit" onchange="putpercenprofit(3)">
																<option value="1" @if($product->product_wholesale3unit == '1')selected @endif>บาท</option>
																<option value="2" @if($product->product_wholesale3unit == '2')selected @endif>%</option>
															</select>
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
															<input type="text" class="form-control number" name="productmin" id="productmin" value="{{$product->product_minstock}}" required style="width:250px;">
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
															<input type="text" class="form-control number" name="productpromotion" id="productpromotion" style="width:250px;" value="{{$product->product_promotion}}">
														</div>
													</div>
													
													<div class="col-md-3  col-md-offset-2">
														
													</div>
												</div>
											</div>
											<br>
											@php
												$sdate = '';
												if(!empty($product->product_prosdate)){
													$sdate = date('d/m/Y',strtotime($product->product_prosdate));
												}
												
												$edate = '';
												if(!empty($product->product_proedate)){
													$edate = date('d/m/Y',strtotime($product->product_proedate));
												}
												
												$expdate = '';
												if(!empty($product->product_expired)){
													$expdate = date('d/m/Y',strtotime($product->product_expired));
												}
											@endphp
											<div class="row">
												<div class="form-group">
													<div class="col-md-3">
														<label>วันที่เริ่มโปรโมชั่น  :</label>
														<div class="input-control">
															<input type="text" name="productprosdate" id="productsprodate" class="form-control datepicker-dates" onkeydown="return false;" autocomplete="off" style="width:250px;" value="{{$sdate}}">
														</div>
													</div>
													
													<div class="col-md-3  col-md-offset-2">
														<label>วันที่สิ้นสุดโปรโมชั่น  :</label>
														<div class="input-control">
															<input type="text" name="productproedate" id="productproedate" class="form-control datepicker-dates" onkeydown="return false;" autocomplete="off" style="width:250px;" value="{{$edate}}">
														</div>
													</div>
												</div>
											</div>
											<br>
											
											<div class="form-group">
												<label>วันที่หมดอายุ :</label>
												<div class="input-control">
													<input type="text" name="dateexpire" id="dateexpire" class="form-control datepicker-dates" onkeydown="return false;" autocomplete="off" required style="width:250px;" required  value="{{$expdate}}">
												</div>
											</div>
											
											
											<div class="form-group">
												<label>หน่วยสินค้า :</label>
												<select class="form-control" name="productunit" id="productunit" required style="width:250px;">
													<option value="">เลือก</option>
													@php
														if($unit){
															foreach($unit as $rs){
																if($rs->unit_id == $product->product_unit){
																@endphp
																	<option value="{{$rs->unit_id}}" selected>{{$rs->unit_name}}</option>
																@php
																}else{
																@endphp	
																	<option value="{{$rs->unit_id}}">{{$rs->unit_name}}</option>
																@php
																}
															}
														}
													@endphp
												</select>
											</div>
											
											<hr>
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
												<div class="col-md-3">
													<div class="form-group">
														<label>#</label>
													</div>
												</div>
											</div>
											
											<div class="row">
												<table class="table">
													<tbody>
														@php
															if($process){
																foreach($process as $key => $proc){
																	@endphp
																	<tr id="proc{{$proc['procid']}}">
																		<td align="left">{{$proc['procbunit']}}</td>
																		<td align="left">{{$proc['procunit']}}</td>
																		<td align="left">{{$proc['proctotal']}}</td>
																		<td><button type="button" class="btn btn-danger btn-icon minus" onclick="delproc({{$proc['procid']}})"><i class="icon-minus-circle2"></i></button></td>
																	</tr>
																	@php
																}
															}
														@endphp
														
													</tbody>
												</table>
												<div id="rowunit">
													<div id="dataunit1">
														<div class="col-md-3">
															<div class="form-group">
																<select class="form-control" name="bunit[]" style="width:150px;">
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
																<select class="form-control" name="unit[]" style="width:150px;">
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
																<input type="text" class="form-control number" name="total[]">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<button type="button" class="btn btn-success btn-icon addrow"><i class="icon-plus-circle2"></i></button>
															</div>
														</div>
													</div>
												</div>
											</div>
											<hr>
											
											<div class="row">
												<div class="form-group">
													<div class="col-md-3">
														<label>หมวดหมู่สินค้า :</label>
														<select class="form-control" name="category" id="category" required style="width:250px;">
															<option value="">เลือก</option>
															@php
																if($category){
																	foreach($category as $rs){
																		if($rs->category_id == $product->product_category){
																		@endphp
																			<option value="{{$rs->category_id}}" selected>{{$rs->category_name}}</option>
																		@php
																		}else{
																		@endphp
																			<option value="{{$rs->category_id}}">{{$rs->category_name}}</option>
																		@php
																		}
																	}
																}
															@endphp
														</select>
													</div>
													
													<div class="col-md-3  col-md-offset-2">
														<label>หมวดหมู่ย่อย :</label>
														<select class="form-control" name="subcategory" id="subcategory" style="width:250px;">
															@php
																if($subcate){
																	foreach($subcate as $rs){
																		if($rs->sub_id == $product->product_subcategory){
																		@endphp
																			<option value="{{$rs->sub_id}}" selected>{{$rs->sub_name}}</option>
																		@php
																		}
																	}
																}
															@endphp
														</select>
													</div>
												</div>
											</div>
											 <br>
                                            <div class="row">
												<div class="form-group">
													<div class="col-md-3">
														<label>สินค้าแนะนำ :</label>
                                                        @php
                                                            $recom = 'off';
                                                            if($product->product_recommended == 1){
                                                                $recom = 'on';
                                                            }
                                                        @endphp
														<label class="checkbox-inline checkbox-switchery checkbox-right switchery-md" style="margin-top: -13px;">
															<input type="checkbox" class="switch" value="off">
                                                            <input type="hidden" name="recommended" id="recommended" value="{{$recom}}">
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
	<!-- /page container -->
<script>
    var options = '';
	$(document).ready(function(){
        var switches = Array.prototype.slice.call(document.querySelectorAll('.switch'));
		switches.forEach(function(html) {
			var switchery = new Switchery(html, {color: '#4CAF50'});
		});
        if({{$product->product_recommended }} == 1){
            $('.switchery').trigger('click');
        }
        
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
	});
    
     $(document).on('click','.switchery',function(){
		var check = $(this).parent().find('input').val();
		if(check == 'on'){
			$(this).parent().find('input').val("off");
		}else{
			$(this).parent().find('input').val("on");
		}
	});
    
	$('#category').change(function(){
		$.ajax({
		'dataType': 'json',
		'type': 'post',
		'url': "{{url('product_category')}}",
		'data': {
			'id': $('#category').val(),
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data) {
				$('#subcategory').html('');
				$.each(data,function(key,item){
					$('#subcategory').append('<option value="'+item.sub_id+'">'+item.sub_name+'</option>');
				});
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
					+'<select class="form-control" name="bunit[]" required style="width:150px;"><option value="">เลือก</option>'+options+'</select>'
				+'</div>'
			+'</div>'
			+'<div class="col-md-3">'
				+'<div class="form-group">'
					+'<select class="form-control" name="unit[]" required style="width:150px;"><option value="">เลือก</option>'+options+'</select>'
				+'</div>'
			+'</div>'
			+'<div class="col-md-3">'
				+'<div class="form-group">'
					+'<input type="text" class="form-control" onkeypress="return isNumberKey(event);" name="total[]" required>'
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
					+'<select class="form-control" name="bunit[]" required style="width:150px;"><option value="">เลือก</option>'+options+'</select>'
				+'</div>'
			+'</div>'
			+'<div class="col-md-3">'
				+'<div class="form-group">'
					+'<select class="form-control" name="unit[]" required style="width:150px;"><option value="">เลือก</option>'+options+'</select>'
				+'</div>'
			+'</div>'
			+'<div class="col-md-3">'
				+'<div class="form-group">'
					+'<input type="text" class="form-control" onkeypress="return isNumberKey(event);" name="total[]" required>'
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
	
	function delproc(id){
		bootbox.confirm({
			title: "ยืนยัน?",
			message: "คุณต้องการลบรายการนี้ หรือไม่?",
			buttons:{
				cancel: {
					label: '<i class="fa fa-times"></i> ยกเลิก',
					className: 'btn-danger'
				},
				confirm:{
					label: '<i class="fa fa-check"></i> ยืนยัน',
					className: 'btn-success'
				}
			},
			callback: function (result){
				if(result == true){
					$.ajax({
					'dataType': 'json',
					'type': 'post',
					'url': "{{url('product/deleteproc')}}",
					'data': {
						'id' : id,
						'_token': "{{ csrf_token() }}"
					},
						'success': function (data) {
							$('#proc'+id).closest('tr').remove();
						}
					});
				}
			}
		});
	}
	
	function isNumberKey(event){
		var key = window.event ? event.keyCode : event.which;
		if (event.keyCode === 8 || event.keyCode === 46){
			return true;
		}else if ( key < 48 || key > 57 ){
			return false;
		}else{
			return true;
		}
	};

	function putpriceprofit(){
		var productbuy = $("#productbuy").val()||0;
		var productretailnumber = $("#productretailnumber").val()||0;
		var productretailunit = $("#productretailunit").val();
		var cal = 0;
		if(productretailunit == 1){
			cal = parseFloat(productbuy) + parseFloat(productretailnumber);
		}else{
			cal = parseFloat(productbuy) + (parseFloat(productbuy) * parseFloat(productretailnumber))/100;
		}
		$("#productretail").val(cal);
	}
	function putpercenprofit(number){
		var productbuy = $("#productbuy").val()||0;
		var profit = $('#productwholesale'+number+'number').val()||0;
		productwholesalenumber
		var unit = $('#productwholesale'+number+'unit').val();
		console.log(profit);
		var cal = 0;
		if(unit == 1){
			cal = parseFloat(productbuy) + parseFloat(profit);
		}else{
			cal = parseFloat(productbuy) + (parseFloat(productbuy) * parseFloat(profit))/100;
		}
		$("#productwholesale"+number).val(cal);
	}
</script>
@stop