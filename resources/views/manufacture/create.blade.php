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
							
							<form method="post" action="{{url('manufacture/create')}}" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6 col-md-6 col-md-offset-3">
										<fieldset>
											<legend class="text-semibold">รายละเอียดสินค้า</legend>
											<div class="form-group">
												<label>รูปสินค้า :</label>
												<input type="file" class="file-input" name="uploadcover" required>
												<span class="help-block">ขนาดรูป : 305 x 425px</span>
											</div>
											
											<div class="form-group">
												<label>รหัสสินค้า :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="productcode" id="productcode" required>
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
													<input type="text" class="form-control" name="barcode" id="barcode" placeholder="Barcode" required>
												</div>
											</div>
											
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
															<input type="text" class="form-control number" name="productretail" id="productretail" value="0" required style="width:250px;">
														</div>
													</div>
													<div class="col-md-2  col-md-offset-2">
														<label>&nbsp</label>
														<div class="input-control">
															<select class="form-control" name="productretailunit" id="productretailunit">
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
													<div class="col-md-2">
														<label>ราคาขายส่ง1 :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productwholesale" id="productwholesale" value="0" required>
														</div>
													</div>
													<div class="col-md-2 ">
														<label>&nbsp</label>
														<div class="input-control">
															<select class="form-control" name="productwholesaleunit" id="productwholesaleunit">
																<option value="1">บาท</option>
																<option value="2">%</option>
															</select>
														</div>
													</div>
													<div class="col-md-2 ">
														<label>ราคาขายส่ง2 :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productwholesale2" id="productwholesale2" value="0" required>
														</div>
													</div>
													<div class="col-md-2 ">
														<label>&nbsp</label>
														<div class="input-control">
															<select class="form-control" name="productwholesaleunit2" id="productwholesaleunit2">
																<option value="1">บาท</option>
																<option value="2">%</option>
															</select>
														</div>
													</div>
													<div class="col-md-2">
														<label>ราคาขายส่ง3 :</label>
														<div class="input-control">
															<input type="text" class="form-control number" name="productwholesale3" id="productwholesale3" value="0" required>
														</div>
													</div>
													<div class="col-md-2 ">
														<label>&nbsp</label>
														<div class="input-control">
															<select class="form-control" name="productwholesaleunit3" id="productwholesaleunit3">
																<option value="1">บาท</option>
																<option value="2">%</option>
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
															<input type="text" class="form-control number" name="productpromotion" id="productpromotion" value="0" required style="width:250px;">
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
													<input type="text" name="dateexpire" id="dateexpire" class="form-control datepicker-dates" onkeydown="return false;" autocomplete="off" required style="width:250px;" required>
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
												<div class="col-md-3">
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
																<input type="text" class="form-control number" name="total[]" required>
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
																		@endphp
																			<option value="{{$rs->category_id}}">{{$rs->category_name}}</option>
																		@php
																	}
																}
															@endphp
														</select>
													</div>
													
													<div class="col-md-3  col-md-offset-2">
														<label>หมวดหมู่ย่อย :</label>
														<select class="form-control" name="subcategory" id="subcategory" style="width:250px;"></select>
													</div>
												</div>
											</div>
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
												<a href="{{url('manufacture')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
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
</script>
@stop