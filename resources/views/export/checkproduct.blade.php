@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- <div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Selling - Export / Create
				</h4>
			</div>
		</div>
	</div>-->
	<!-- /page header -->
	<style type="text/css">
		.classexport{
			background: rgb(199,199,199,0.3);
		}
		.disabled{
			background: rgb(199,199,199,0.5);
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
										<li><a data-action="move" onclick="newpage();"></a></li>
										<li><a data-action="close"></a></li>
									</ul>
								</div>
							</div>
							
							<form id="myForm" method="post" action="{{url('export_pay')}}" >
								{{-- onsubmit="return checkstock();" --}}
							{{ csrf_field() }}
							<input type="hidden" class="form-control" name="export_id" id="export_id" value="{{ $data->export_id }}" readonly>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6">
										<fieldset>
											<legend class="text-semibold"><i class="icon-stack2"></i> ข้อมูลหลัก</legend>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>เลขที่ออเดอร์ :</label>
														<input type="text" class="form-control" name="invoice" id="invoice" placeholder="เลขที่ใบรับสินค้า" value="{{ $data->export_inv }}" readonly>
													</div>
												</div>

												<div class="col-md-6">
													{{-- <div class="form-group">
														<br>
														<label class="checkbox-inline checkbox-switchery checkbox-right switchery-xs">
															<input type="checkbox" class="switch" value="on">
														</label>
													</div> --}}
												</div>
											</div>
										
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>วันที่ :</label>
														<div class="input-group">
															<input type="text" name="docdate" id="docdate" placeholder="วันที่" class="form-control" onkeydown="return false;" autocomplete="off" value="{{ date('Y-m-d') }}" readonly>
														</div>
													</div>
												</div>
												
												<div class="col-md-6">
													<div class="form-group">
														<label>พนักงานขาย :</label>
														<div class="input-group">
															<input type="text" name="empsalename" id="empsalename" class="form-control" onkeydown="return false;" autocomplete="off" value="{{ $data->export_empname }}" readonly>
															<input type="hidden" name="empsaleid" id="empsaleid" class="form-control" onkeydown="return false;" autocomplete="off" value="{{ $data->export_empid }}" readonly>
														</div>
													</div>
												</div>
											</div>
										</fieldset>
									</div>
									
									<div class="col-md-6">
										<fieldset>
											<legend class="text-semibold"><i class="icon-info22"></i> รายละเอียด ลูกค้า</legend>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>ชื่อลูกค้า :</label>
														<input type="text" class="form-control" name="customername" id="customername" placeholder="ชื่อลูกค้า" autocomplete="new-password" value="{{ $data->export_customername }}" readonly>
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<label>เลขประจำตัวผู้เสียภาษีอากร :</label>
														<input type="text" class="form-control" name="customertax" id="customertax" placeholder="เลขประจำตัวผู้เสียภาษีอากร" autocomplete="off" value="{{ $customer->customer_idtax }}" readonly>
													</div>
													<input type="hidden" name="customerid" id="customerid" value="{{ $data->export_customerid }}" readonly>
												</div>
											</div>
											@php
											$address = "บ้านเลขที่ - ซอย :  ".$customer->customer_address1;
											$address .= " ถนน :  ".$customer->customer_address2;
											$address .= " เขต / อำเภอ :  ".$customer->customer_address3;
											$address .= " จังหวัด :  ".$customer->customer_address4;
											$address .= " รหัสไปรษณย์ :  ".$customer->customer_address5;
											@endphp
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label>ที่อยู่ :</label>
														<textarea name="customeraddr" id="customeraddr" rows="2" class="form-control" placeholder="ที่อยู่" readonly>ที่อยู่ : {{ $address }}</textarea>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>เบอร์โทรศัพท์ :</label>
														<input type="text" class="form-control number" name="customercontel" id="customercontel" placeholder="เบอร์โทรศัพท์" value="{{ $customer->customer_tel }}" readonly>
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label>หมายเหตุ :</label>
														<textarea name="note" id="note" rows="2" class="form-control" placeholder="หมายเหตุ" readonly>{{ $data->export_note }}</textarea>
													</div>
												</div>
											</div>
										</fieldset>
									</div>
						
								</div>
							</div>
						<!-- /vertical form -->
						
						<!-- Vertical form options -->
						<div class="row">
							<div class="col-md-12">
								<!-- Basic layout-->
									<div class="panel panel-flat">
										<div class="panel-heading">
											<h5 class="panel-title">รายการออเดอร์</h5>
											<div class="heading-elements">
												<ul class="icons-list">
													<li><a data-action="collapse"></a></li>
													<li><a data-action="reload"></a></li>
													<li><a data-action="close"></a></li>
												</ul>
											</div>
										</div>

										<div class="panel-body">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group"  style="display: none;">
														<label class="control-label col-md-1">รายละเอียดสินค้า</label>
														<div class="col-md-11">
															<div class="row">
																<div class="col-md-2">
																	<div class="form-group has-feedback has-feedback-left">
																		<input type="text" id="searchbarcode" class="form-control input-xlg" placeholder="รหัสสินค้า">
																		<div class="form-control-feedback">
																			<i class="icon-barcode2"></i>
																		</div>
																	</div>
																</div>

																<div class="col-md-2">
																	<div class="form-group has-feedback has-feedback-left">
																		<input type="text" id="searchproduct" class="form-control input-xlg" placeholder="ชื่อสินค้า">
																		<div class="form-control-feedback">
																			<i class="icon-cart-add"></i>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<br><br>
													<div class="table-responsive">
														<table id="myTable" class="table table-framed">
															<thead>
																<tr>
																	<th class="text-center"></th>
																	<th class="text-center">รหัสสินค้า</th>
																	<th class="text-center">รายการสินค้า</th>
																	<th class="text-center">จำนวน</th>
																	<th class="text-center" style="width:150px;">หน่วยนับ</th>
																	<th class="text-center" style="width:100px;">ราคาขาย</th>
																	<th class="text-center">คงเหลือ</th>
																	<th class="text-center">รวม</th>
																	<th class="text-center">#</th>
																</tr>
															</thead>
															<tbody id="rowdata">
																@if(!empty($orders))
																	@foreach($orders as $key => $item)
																	@php 
																	$disabled = '';
																	if($item->order_status == 1 || $item->order_status == 2){
																		$disabled = 'disabled'; 
																	}
																	@endphp
																	
																	<tr class="rowproduct rowproduct{{ $item->order_id }} {{ $disabled }}" id="row{{$key}}{{ $item->order_productid }}">
																		<td align="center"><input type="checkbox" name="check[]" value="{{ $item->order_id }}" id="check{{ $item->order_id }}" checked {{ $disabled }}></td>
																		<td align="center">{{ $item->product_code }}<input type="hidden" name="productid[]" value="{{ $item->order_productid }}" {{ $disabled }}></td>
																		<td><div data-toggle="tooltip" data-placement="top" title="{{ $item->product_qty }}">{{ $item->product_name }}</div></td>
																		<td align="center">
																			
																			<input type="text" class="form-control number" name="productqty[]" id="qty{{$key}}{{ $item->order_productid }}" onkeyup="qtypush('{{$key}}{{ $item->order_productid }}')" value="{{ $item->order_balance }}" style="width:70px" {{ $disabled }}>
																			<input type="hidden" class="form-control number" name="productoldqty[]" id="oldqty{{$key}}{{ $item->order_productid }}" value="{{ $item->order_balance }}">

																		</td>
																		<td align="center">{{ $item->unitname }}</td>

																		<td align="right">
																			<div>
																			{{ number_format($item->order_price,2) }}</div>
																			<input type="hidden" class="form-control" name="productprice[]" id="price{{$key}}{{ $item->order_productid }}" value="{{ $item->order_price }}" {{ $disabled }}>
																		</td>

																		<td align="center">
																			<input type="text" value="{{ $item->product_qty}}" id="stock{{$key}}{{ $item->order_productid }}" name="stock[]" style="width:70px" class="form-control" readonly>
																		</td>
																		
																		<td align="right">
																			<span id="totalprosp{{$key}}{{ $item->order_productid }}">{{ number_format($item->order_total,2) }}</span>
																			<input type="hidden" name="totalpro[]" id="totalpro{{$key}}{{ $item->order_productid }}" value="{{ $item->order_total }}" {{ $disabled }}></td>
																		<td align="center"><button type="button" class="btn btn-danger btn-rounded" onclick="delrow({{$key}}{{ $item->order_productid }})" {{ $disabled }}><i class="icon-cancel-square position-left"></i> Delete</button></td>
																	</tr>
																	@endforeach
																@endif
															</tbody>
														</table>
													</div>
												</div>
											</div>
											<br><br>
											<div class="row">
												<div class="col-md-12">
													<div class="col-md-4"></div>
													<div class="col-md-4"></div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label col-md-4" style="top:8px;"><b>มูลค่า</b></label>
															<div class="col-md-8">
																<input type="text" id="sumtotalsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{ $data->export_total }}" autocomplete="off">
																<input type="hidden" class="form-control" name="sumtotal" id="sumtotal" readonly value="{{ $data->export_total }}">
															</div>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="row" style="display: none;">
												<div class="">
													<div class="col-md-12">
														<div class="col-md-4"></div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label col-md-4">ส่วนลด</label>
																<div class="col-md-8">
																	<?php 
																		$discount = array(5,10,15,20,25,30);
																	?>
																	<select name="discount" id="discount" class="form-control">
																		<option value="0">ไม่มีส่วนลด</option>
																		<?php
																			foreach($discount as $dis){
																				echo '<option value="'.$dis.'">'.$dis.' %</option>';
																			}
																		?>
																	</select>
																</div>
															</div>
														</div>
														
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label col-md-4"><span id="fontdis"></span></label>
																<div class="col-md-8">
																	<input type="text" id="sumdiscountsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{ $data->export_discount }}" autocomplete="off">
																	<input type="hidden" class="form-control" name="sumdiscount" id="sumdiscount" value="{{ $data->export_discount }}" readonly>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="row" style="display: none;">
												<div class="">
													<div class="col-md-12">
														<div class="col-md-4"></div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label col-md-4">ภาษี</label>
																<div class="col-md-8">
																	<div class="radio">
																		<label>
																			<input type="radio" class="styled vat" name="vat" id="vat1" value="0" checked="checked">No Vat
																		</label>
																	</div>
																	<div class="radio">
																		<label>
																			<input type="radio" class="styled vat" name="vat" id="vat2" value="1">Exclude Vat
																		</label>
																	</div>
																	<div class="radio">
																		<label>
																			<input type="radio" class="styled vat" name="vat" id="vat3" value="2">Include Vat
																		</label>
																	</div>
																</div>
															</div>
														</div>
														
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label col-md-4"><span id="fontvat"><strong>ภาษีมูลค่าเพิ่ม</strong></span></label>
																<div class="col-md-8">
																	<input type="text" id="sumvatsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{ $data->export_vat }}" autocomplete="off">
																	<input type="hidden" class="form-control" name="sumvat" id="sumvat" value="{{ $data->export_vat }}" readonly>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="row" style="display: none;">
												<div class="">
													<div class="col-md-12">
														<div class="col-md-4"></div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label col-md-4">การชำระเงิน</label>
																<div class="col-md-8">
																	@php
																		$payment = array('เงินสด','เช็ค','โอน');
																	@endphp
																	<select name="payment" id="payment" class="form-control" onchange="changepay(this.value)">
																		@php
																			foreach($payment as $pay){
																				echo '<option value="'.$pay.'">'.$pay.'</option>';
																			}
																		@endphp
																	</select>
																	<input type="text" class="form-control" name="noauccount" id="noauccount" style="display: none" placeholder="เลขที่บัญชี">
																</div>
															</div>
														</div>
														
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label col-md-4"><span><strong>รวมทั้งสิ้น</strong></span></label>
																<div class="col-md-8">
																	<input type="text" id="sumpaymentsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{ $data->export_totalall }}" autocomplete="off">
																	<input type="hidden" class="form-control" name="sumpayment" id="sumpayment" value="{{ $data->export_totalall }}" readonly>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="row" style="display: none;">
												<div class="">
													<div class="col-md-12">
														<div class="col-md-4"></div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label col-md-4">ส่วนลดท้ายบิล</label>
																<div class="col-md-8">
																	<input type="text" class="form-control number" name="discountlastbill" id="discountlastbill" value="{{ $data->export_lastbill }}">
																</div>
															</div>
														</div>
														
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label col-md-4"><span><strong><font color="green">ยอดชำระ</font></strong></span></label>
																<div class="col-md-8">
																	<input type="text" id="sumtotalallsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{ $data->export_totalall }}" autocomplete="off">
																	<input type="hidden" class="form-control" name="sumtotalall" id="sumtotalall" value="{{ $data->export_totalall }}" readonly>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="text-right">
												<a href="{{url('export')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
												<button type="button" onclick="checkpay()" id="submitform" class="btn btn-primary"><i class="icon-floppy-disk"></i>  บันทึก</button>
											</div>
										</div>
									</div>
								<!-- /basic layout -->
							</div>
						</div>
						<!-- /vertical form options -->
						</form>	
					</div>
				</div>
			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
<style>
	.textshow{
		font-size:18px;
		border: none;
		text-align: right;
		margin-bottom: 8px;
	}
</style>

<script>
	$(document).ready(function(){
		var switches = Array.prototype.slice.call(document.querySelectorAll('.switch'));
		switches.forEach(function(html) {
			var switchery = new Switchery(html, {color: '#4CAF50'});
		});
		$("input[name='check[]']").click(function(event) {
			var total 		= 0;
			$('#rowdata tr').each(function(){
				var field = $(this).attr('id');
				var check = $("#"+field+" td:nth-child(1) input[name='check[]']").is(":checked");
				var id = $("#"+field+" td:nth-child(1) input[name='check[]']").val();
				if(check){
					// $("#"+field+" td:nth-child(1) input[name='check[]']").prop('disabled',false);
					$("#"+field+" td:nth-child(2) input[name='productid[]']").prop('disabled',false);
					$("#"+field+" td:nth-child(6) input[name='productprice[]']").prop('disabled',false);
					$("#"+field+" td:nth-child(7) input[name='productqty[]']").prop('disabled',false);
					$("#"+field+" td:nth-child(8) input[name='totalpro[]']").prop('disabled',false);
					var totals = $("#"+field+" td:nth-child(8) input[name='totalpro[]']").val()||0;
					total += parseFloat(totals);
				}else{
					// $("#"+field+" td:nth-child(1) input[name='check[]']").prop('disabled',true);
					$("#"+field+" td:nth-child(2) input[name='productid[]']").prop('disabled',true);
					$("#"+field+" td:nth-child(6) input[name='productprice[]']").prop('disabled',true);
					$("#"+field+" td:nth-child(7) input[name='productqty[]']").prop('disabled',true);
					$("#"+field+" td:nth-child(8) input[name='totalpro[]']").prop('disabled',true);
				}
			});
			$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
			$('#sumtotal').val(total.toFixed(2));
			fncalmoney();
			// $('#rowdata tr').each(function(){
			// 	var field = $(this).attr('id');
			// 	var check = $("#"+field+" td:nth-child(1) input[name='check[]']").is(":checked");
			// 	var id = $("#"+field+" td:nth-child(1) input[name='check[]']").val();
			// 	if(check){
			// 		console.log(id);
			// 	}
			// });
		});
		var total = 0;
		$('#rowdata tr').each(function(){
			var field = $(this).attr('id');
			var check = $("#"+field+" td:nth-child(1) input[name='check[]']").is(":checked");
			var id = $("#"+field+" td:nth-child(1) input[name='check[]']").val();
			var productid = $(this).attr('id').replace('row','');
			if(check){
				var price = $("#price"+productid).val()||0;
				var qty = $("#qty"+productid).val()||0;
				var totals = parseFloat(price)*parseFloat(qty);
				$("#totalpro"+productid).val(totals)
				$("#totalprosp"+productid).html(formatNumber(totals.toFixed(2)));
				total += parseFloat(totals);
			}
		});
		$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
		$('#sumtotal').val(total.toFixed(2));
		fncalmoney();
	});
	
	function formatNumber (x) {
		return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	
	$(document).on('click','.switchery',function(){
		var check = $(this).parent().find('input').val();
		if(check == 'on'){
			$("#invoice").prop('readonly', false);
			$(this).parent().find('input').val("off");
		}else{
			$("#invoice").prop('readonly', true);
			$(this).parent().find('input').val("on");
		}
	});
	
	$('#customername').keyup(function(){
		$(this).autocomplete({
			source: "{{url('searchcustomername/autocomplete')}}",
			minLength: 1,
			select: function(event, ui){
				$('#customerid').val(ui.item.idcus);
				$('#customertax').val(ui.item.idtax);
				$('#customeraddr').val(ui.item.address);
				$('#customercontel').val(ui.item.tel);
				$('#note').val(ui.item.note);
				$('.rowproduct').remove();
				$("#sumtotalsp").val('0.00');
				$("#sumtotal").val('0.00');
				$("#sumdiscountsp").val('0.00');
				$("#sumdiscount").val('0.00');
				$("#sumvatsp").val('0.00');
				$("#sumvat").val('0.00');
				$("#sumpaymentsp").val('0.00');
				$("#sumpayment").val('0.00');
				$("#sumtotalallsp").val('0.00');
				$("#sumtotalall").val('0.00');
			}
		})
		.autocomplete("instance")._renderItem = function(ul, item) {
			return $("<li>").append("<span class='text-semibold'>" + item.label + '</span>' + "<br>" + '<span class="text-muted text-size-small">' + item.attr + '</span>').appendTo(ul);
		};
	});
	
	$('#customertax').keyup(function(){
		$(this).autocomplete({
			source: "{{url('searchcustomertax/autocomplete')}}",
			minLength: 1,
			select: function(event, ui){
				$('#customerid').val(ui.item.idcus);
				$('#customername').val(ui.item.name);
				$('#customertax').val(ui.item.idtax);
				$('#customeraddr').val(ui.item.addr);
				$('#customercontel').val(ui.item.tel);
				$('#note').val(ui.item.note);
				$('.rowproduct').remove();
				$("#sumtotalsp").val('0.00');
				$("#sumtotal").val('0.00');
				$("#sumdiscountsp").val('0.00');
				$("#sumdiscount").val('0.00');
				$("#sumvatsp").val('0.00');
				$("#sumvat").val('0.00');
				$("#sumpaymentsp").val('0.00');
				$("#sumpayment").val('0.00');
				$("#sumtotalallsp").val('0.00');
				$("#sumtotalall").val('0.00');
			}
		})
		.autocomplete("instance")._renderItem = function(ul, item) {
			return $("<li>").append("<span class='text-semibold'>" + item.label + '</span>' + "<br>" + '<span class="text-muted text-size-small">' + item.attr + '</span>').appendTo(ul);
		};
	});
	$('#customercontel').keyup(function(){
		$(this).autocomplete({
			source: "{{url('searchcustomertel/autocomplete')}}",
			minLength: 1,
			select: function(event, ui){
				$('#customerid').val(ui.item.idcus);
				$('#customername').val(ui.item.name);
				$('#customertax').val(ui.item.idtax);
				$('#customeraddr').val(ui.item.addr);
				$('#customercontel').val(ui.item.tel);
				$('#note').val(ui.item.note);
				$('.rowproduct').remove();
				$("#sumtotalsp").val('0.00');
				$("#sumtotal").val('0.00');
				$("#sumdiscountsp").val('0.00');
				$("#sumdiscount").val('0.00');
				$("#sumvatsp").val('0.00');
				$("#sumvat").val('0.00');
				$("#sumpaymentsp").val('0.00');
				$("#sumpayment").val('0.00');
				$("#sumtotalallsp").val('0.00');
				$("#sumtotalall").val('0.00');
			}
		})
		.autocomplete("instance")._renderItem = function(ul, item) {
			return $("<li>").append("<span class='text-semibold'>" + item.label + '</span>' + "<br>" + '<span class="text-muted text-size-small">' + item.attr + '</span>').appendTo(ul);
		};
	});
	
	$(document).keypress(function(e){
		if(e.which == 13){
			$.ajax({
			'dataType': 'json',
			'type': 'post',
			'url': "{{url('enterbarcode')}}",
			'data': {
				'barcode': $('#searchbarcode').val(),
				'cusid': $('#customerid').val(),
				'_token': "{{ csrf_token() }}"
			},
				'success': function(data){
					$.each(data,function(key,item){
						var find = 0;
						$('#rowdata tr').each(function(){
							if($(this).is('#row'+item.id) == true){
								find = 1;
							}                 
						});
						
						if(find == 0){
							$('#rowdata').append('<tr class="rowproduct" id="row'+item.id+'"><td align="center">'+item.code+'</td>'
								+'<td>'+item.name+'<input type="hidden" name="productid[]" value="'+item.id+'"></td>'
								+'<td align="center">'+item.unit+'</td>'
								+'<td align="right">'+formatNumber(item.price.toFixed(2))+'<input type="hidden" class="form-control" name="productprice[]" id="price'+item.id+'" value="'+item.price+'"></td>'
								+'<td align="center"><input type="text" class="form-control number" name="productqty[]" id="qty'+item.id+'" onkeyup="qtypush(\''+item.id+'\')" value="1" style="width:70px"></td>'
								+'<td align="right"><span id="totalprosp'+item.id+'"></span><input type="hidden" name="totalpro[]" id="totalpro'+item.id+'"></td>'
								+'<td  align="center"><button type="button" class="btn btn-danger btn-rounded" onclick="delrow(\''+item.id+'\')"><i class="icon-cancel-square position-left"></i> Delete</button></td>'
							+'</tr>');
							var price = $('#price'+item.id).val()||0;
							var total = parseFloat(price*1);
							$('#totalprosp'+item.id).text(formatNumber(total.toFixed(2)));
							$('#totalpro'+item.id).val(total);
						}else{
							var qty = $('#qty'+item.id).val();
							var sum = parseInt(qty)+1;
							var price = $('#price'+item.id).val()||0;
							var total = parseFloat(price*sum);
							
							$('#qty'+item.id).val(sum);
							$('#totalprosp'+item.id).text(formatNumber(total.toFixed(2)));
							$('#totalpro'+item.id).val(total);
						}
					});
					
					var sumrowall = 0;
					$("input[name='totalpro[]']").each(function(){
						sumrowall += parseFloat($(this).val()||0);
					});
					
					// <!-- คำนวณ ยอด -->
					$('#sumtotalsp').val(formatNumber(sumrowall.toFixed(2)));
					$('#sumtotal').val(sumrowall.toFixed(2));
					
					var sumtotal 	= $('#sumtotal').val()||0;
					var discount 	= $('#discount').val()||0;
					var sumdiscount	= parseFloat((discount)*sumtotal)/100;
					var vat 		= $('.vat:checked').val();
					var discounts	= parseFloat(sumtotal-sumdiscount);
					var lastbill 	= $('#discountlastbill').val()||0;
					
					$('#fontdis').html('<strong> => </strong>');
					$('#sumdiscountsp').val(formatNumber(sumdiscount.toFixed(2)));
					$('#sumdiscount').val(sumdiscount.toFixed(2));
					
					if(vat == 0){
						$('#sumvatsp').val('0.00');
						$('#sumvat').val('0.00');
						$('#sumpaymentsp').val(formatNumber(discounts.toFixed(2)));
						$('#sumpayment').val(discounts.toFixed(2));
						$('#sumtotalallsp').val(formatNumber((discounts-lastbill).toFixed(2)));
						$('#sumtotalall').val((discounts-lastbill).toFixed(2));
					}else if(vat == 1){
						sumvat 		= parseFloat(discounts * 7)/(100);
						var payment = parseFloat(discounts+sumvat);
						$('#sumvatsp').val(formatNumber(sumvat.toFixed(2)));
						$('#sumvat').val(parseFloat(sumvat.toFixed(2)));
						$('#sumpaymentsp').val(formatNumber(payment.toFixed(2)));
						$('#sumpayment').val(payment.toFixed(2));
						$('#sumtotalallsp').val(formatNumber((payment-lastbill).toFixed(2)));
						$('#sumtotalall').val((payment-lastbill).toFixed(2));
					}else if(vat == 2){
						sumvat = parseFloat(discounts * 100)/(107);
						var sumvats = parseFloat(discounts-sumvat);
						$('#sumvatsp').val(formatNumber(sumvats.toFixed(2)));
						$('#sumvat').val(sumvats.toFixed(2));
						$('#sumpaymentsp').val(formatNumber(discounts.toFixed(2)));
						$('#sumpayment').val(discounts.toFixed(2));
						$('#sumtotalallsp').val(formatNumber((discounts-lastbill).toFixed(2)));
						$('#sumtotalall').val((discounts-lastbill).toFixed(2));
					}
					
					// <!-- /คำนวณ ยอด -->
					
					$('#searchbarcode').val('');
					$('#searchbarcode').trigger("focus");
				}
			});
		}
	});
	
	$("#searchproduct").autocomplete({
		source: "{{url('searchproductname/autocomplete')}}",
		minLength: 1,
		select: function(event, ui){
			$.ajax({
			'dataType': 'json',
			'type': 'post',
			'url': "{{url('enterproduct')}}",
			'data': {
				'id': ui.item.id,
				'cusid': $('#customerid').val(),
				'_token': "{{ csrf_token() }}"
			},
				'success': function (data) {
					$.each(data,function(key,item){
						var find = 0;
						$('#rowdata tr').each(function(){
							if($(this).is('#row'+item.id) == true){
								find = 1;
							}                 
						});
						
						if(find == 0){
							var select = '<select class="form-control" id="unit'+item.id+'" onchange="changeunit(this)" name="unit" required style="width:150px;">';
							$.each(item.unitdata,function(key2,item2){
								select += '<option value="1,'+item2.unit_unitfirst+'">'+item2.unit_name+'</option>';
								select += '<option value="2,'+item2.unit_unitsec+'">'+item2.unitsub_name+'</option>';
							});
							select += '</select>'
							$('#rowdata').append('<tr class="rowproduct" id="row'+item.id+'"><td align="center">'+item.code+'</td>'
								+'<td>'+item.name+'<input type="hidden" name="productid[]" value="'+item.id+'"></td>'
								+'<td align="center"><input type="text" class="form-control number" name="productqty[]" id="qty'+item.id+'" onkeyup="qtypush(\''+item.id+'\')" value="1" style="width:70px"></td>'
								+'<td align="center">'+select+'</td>'
								+'<td align="right"><div>'+formatNumber(item.price.toFixed(2))+'</div><input type="hidden" class="form-control" name="productprice[]" id="price'+item.id+'" value="'+item.price+'"></td>'
								
								+'<td align="right"><span id="totalprosp'+item.id+'"></span><input type="hidden" name="totalpro[]" id="totalpro'+item.id+'"></td>'
								+'<td  align="center"><button type="button" class="btn btn-danger btn-rounded" onclick="delrow(\''+item.id+'\')"><i class="icon-cancel-square position-left"></i> Delete</button></td>'
							+'</tr>');
							var price = $('#price'+item.id).val()||0;
							var total = parseFloat(price*1);
							$('#totalprosp'+item.id).text(formatNumber(total.toFixed(2)));
							$('#totalpro'+item.id).val(total);
						}else{
							var qty = $('#qty'+item.id).val();
							var sum = parseInt(qty)+1;
							var price = $('#price'+item.id).val()||0;
							var total = parseFloat(price*sum);
							
							$('#qty'+item.id).val(sum);
							$('#totalprosp'+item.id).text(formatNumber(total.toFixed(2)));
							$('#totalpro'+item.id).val(total);
						}
					});
					
					var sumrowall = 0;
					$("input[name='totalpro[]']").each(function(){
						sumrowall += parseFloat($(this).val()||0);
					});
					
					// <!-- คำนวณ ยอด -->
					$('#sumtotalsp').val(formatNumber(sumrowall.toFixed(2)));
					$('#sumtotal').val(sumrowall.toFixed(2));
					
					var sumtotal 	= $('#sumtotal').val()||0;
					var discount 	= $('#discount').val()||0;
					var sumdiscount	= parseFloat((discount)*sumtotal)/100;
					var vat 		= $('.vat:checked').val();
					var discounts	= parseFloat(sumtotal-sumdiscount);
					var lastbill 	= $('#discountlastbill').val()||0;
					
					$('#fontdis').html('<strong> => </strong>');
					$('#sumdiscountsp').val(formatNumber(sumdiscount.toFixed(2)));
					$('#sumdiscount').val(sumdiscount.toFixed(2));
					
					if(vat == 0){
						console.log(discounts);
						$('#sumvatsp').val('0.00');
						$('#sumvat').val('0.00');
						$('#sumpaymentsp').val(formatNumber(discounts.toFixed(2)));
						$('#sumpayment').val(discounts.toFixed(2));
						$('#sumtotalallsp').val(formatNumber((discounts-lastbill).toFixed(2)));
						$('#sumtotalall').val((discounts-lastbill).toFixed(2));
					}else if(vat == 1){
						sumvat 		= parseFloat(discounts * 7)/(100);
						var payment = parseFloat(discounts+sumvat);
						$('#sumvatsp').val(formatNumber(sumvat.toFixed(2)));
						$('#sumvat').val(parseFloat(sumvat.toFixed(2)));
						$('#sumpaymentsp').val(formatNumber(payment.toFixed(2)));
						$('#sumpayment').val(payment.toFixed(2));
						$('#sumtotalallsp').val(formatNumber((payment-lastbill).toFixed(2)));
						$('#sumtotalall').val((payment-lastbill).toFixed(2));
					}else if(vat == 2){
						sumvat = parseFloat(discounts * 100)/(107);
						var sumvats = parseFloat(discounts-sumvat);
						$('#sumvatsp').val(formatNumber(sumvats.toFixed(2)));
						$('#sumvat').val(sumvats.toFixed(2));
						$('#sumpaymentsp').val(formatNumber(discounts.toFixed(2)));
						$('#sumpayment').val(discounts.toFixed(2));
						$('#sumtotalallsp').val(formatNumber((discounts-lastbill).toFixed(2)));
						$('#sumtotalall').val((discounts-lastbill).toFixed(2));
					}
					
					// <!-- /คำนวณ ยอด -->
					
					$('#searchproduct').val('');
					$('#searchproduct').trigger("focus");
				}
			});
		}
	})
	.autocomplete("instance")._renderItem = function(ul, item) {
		return $("<li>").append("<span class='text-semibold'>" + item.label + '</span>' + "<br>" + '<span class="text-muted text-size-small">' + item.attrs + '</span>').appendTo(ul);
	};
	
	function qtypush(id){
		var total 		= 0;
		var qty 		= $('#qty'+id).val()||0;
		var price 		= $('#price'+id).val()||0;
		var totalpro 	= qty*price;
		
		$('#totalprosp'+id).text(formatNumber(totalpro.toFixed(2)));
		$('#totalpro'+id).val(totalpro.toFixed(2));
		//เก่า
		// $("input[name = 'totalpro[]']").each(function(){
		// 	var totals = $(this).val()||0;
		// 	total += parseFloat(totals);
		// });
		//ใหม่เช็คตัวที่ติ้กเอา
		$('#rowdata tr').each(function(){
			var field = $(this).attr('id');
			var check = $("#"+field+" td:nth-child(1) input[name='check[]']").is(":checked");
			var id = $("#"+field+" td:nth-child(1) input[name='check[]']").val();
			if(check){
				var totals = $("#"+field+" td:nth-child(8) input[name='totalpro[]']").val()||0;
				total += parseFloat(totals);
			}
		});
		console.log(total)
		$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
		$('#sumtotal').val(total.toFixed(2));
		
		var sumtotal 	= $('#sumtotal').val()||0;
		var discount 	= $('#discount').val()||0;
		var sumdiscount	= parseFloat((discount)*sumtotal)/100;
		var vat 		= $('.vat:checked').val();
		var discounts	= parseFloat(sumtotal-sumdiscount);
		var lastbill 	= $('#discountlastbill').val()||0;
		
		$('#fontdis').html('<strong> => </strong>');
		$('#sumdiscountsp').val(formatNumber(sumdiscount.toFixed(2)));
		$('#sumdiscount').val(sumdiscount.toFixed(2));
		
		if(vat == 0){
			console.log(discounts);
			$('#sumvatsp').val('0.00');
			$('#sumvat').val('0.00');
			$('#sumpaymentsp').val(formatNumber(discounts.toFixed(2)));
			$('#sumpayment').val(discounts.toFixed(2));
			$('#sumtotalallsp').val(formatNumber((discounts-lastbill).toFixed(2)));
			$('#sumtotalall').val((discounts-lastbill).toFixed(2));
		}else if(vat == 1){
			sumvat 		= parseFloat(discounts * 7)/(100);
			var payment = parseFloat(discounts+sumvat);
			$('#sumvatsp').val(formatNumber(sumvat.toFixed(2)));
			$('#sumvat').val(parseFloat(sumvat.toFixed(2)));
			$('#sumpaymentsp').val(formatNumber(payment.toFixed(2)));
			$('#sumpayment').val(payment.toFixed(2));
			$('#sumtotalallsp').val(formatNumber((payment-lastbill).toFixed(2)));
			$('#sumtotalall').val((payment-lastbill).toFixed(2));
		}else if(vat == 2){
			sumvat = parseFloat(discounts * 100)/(107);
			var sumvats = parseFloat(discounts-sumvat);
			$('#sumvatsp').val(formatNumber(sumvats.toFixed(2)));
			$('#sumvat').val(sumvats.toFixed(2));
			$('#sumpaymentsp').val(formatNumber(discounts.toFixed(2)));
			$('#sumpayment').val(discounts.toFixed(2));
			$('#sumtotalallsp').val(formatNumber((discounts-lastbill).toFixed(2)));
			$('#sumtotalall').val((discounts-lastbill).toFixed(2));
		}
	}
	
	// <!-- Vat Process -->
	$('input.vat').on('change', function() {
		fncalmoney();
	});
	// <!-- /Vat Process -->
	
	// <!-- Discount Process -->
	$('#discount').change(function(){
		fncalmoney();
	});
	// <!-- /Discount Process -->
	
	// <!-- Discountlastbill Process -->
	$('#discountlastbill').keyup(function(){
		var payment = $('#sumpayment').val()||0;
		var lastbill = $(this).val()||0;
		var payments =  parseFloat(payment)-parseFloat(lastbill);
		$('#sumtotalallsp').val(formatNumber(payments.toFixed(2)));
		$('#sumtotalall').val(payments.toFixed(2));
	});
	// <!-- /Discountlastbill Process -->
	
	function delrow(id){
		$('#row'+id).closest('tr').remove();
		
		var sumrowall = 0;
		$("input[name='totalpro[]']").each(function(){
			sumrowall += parseFloat($(this).val()||0);
		});
		fncalmoney();
		// <!-- /คำนวณ ยอด -->
	}
	
	/* function changeprice(id){
		var total 		= 0;
		var qty 		= $('#qty'+id).val()||0;
		var price 		= $('#price'+id).val()||0;
		var totalpro 	= qty*price;
		
		$('#totalprosp'+id).text(formatNumber(totalpro.toFixed(2)));
		$('#totalpro'+id).val(totalpro.toFixed(2));
		
		$("input[name = 'totalpro[]']").each(function(){
			var totals = $(this).val()||0;
			total += parseFloat(totals);
		});
		
		$('#sumtotalsp').val(formatNumber(total.toFixed(2)));
		$('#sumtotal').val(total.toFixed(2));
		
		var sumtotal 	= $('#sumtotal').val()||0;
		var discount 	= $('#discount').val()||0;
		var sumdiscount	= parseFloat((discount)*sumtotal)/100;
		var vat 		= $('.vat:checked').val();
		var discounts	= parseFloat(sumtotal-sumdiscount);
		var lastbill 	= $('#discountlastbill').val()||0;
		
		$('#fontdis').html('<strong> => </strong>');
		$('#sumdiscountsp').val(formatNumber(sumdiscount.toFixed(2)));
		$('#sumdiscount').val(sumdiscount.toFixed(2));
		
		if(vat == 0){
			console.log(discounts);
			$('#sumvatsp').val('0.00');
			$('#sumvat').val('0.00');
			$('#sumpaymentsp').val(formatNumber(discounts.toFixed(2)));
			$('#sumpayment').val(discounts.toFixed(2));
			$('#sumtotalallsp').val(formatNumber((discounts-lastbill).toFixed(2)));
			$('#sumtotalall').val((discounts-lastbill).toFixed(2));
		}else if(vat == 1){
			sumvat 		= parseFloat(discounts * 7)/(100);
			var payment = parseFloat(discounts+sumvat);
			$('#sumvatsp').val(formatNumber(sumvat.toFixed(2)));
			$('#sumvat').val(parseFloat(sumvat.toFixed(2)));
			$('#sumpaymentsp').val(formatNumber(payment.toFixed(2)));
			$('#sumpayment').val(payment.toFixed(2));
			$('#sumtotalallsp').val(formatNumber((payment-lastbill).toFixed(2)));
			$('#sumtotalall').val((payment-lastbill).toFixed(2));
		}else if(vat == 2){
			sumvat = parseFloat(discounts * 100)/(107);
			var sumvats = parseFloat(discounts-sumvat);
			$('#sumvatsp').val(formatNumber(sumvats.toFixed(2)));
			$('#sumvat').val(sumvats.toFixed(2));
			$('#sumpaymentsp').val(formatNumber(discounts.toFixed(2)));
			$('#sumpayment').val(discounts.toFixed(2));
			$('#sumtotalallsp').val(formatNumber((discounts-lastbill).toFixed(2)));
			$('#sumtotalall').val((discounts-lastbill).toFixed(2));
		}
	} */
	
	$('#submitform').click(function(){
		
	});
	function newpage(){
		window.open('create');
	}
	function checkpay(){
		$('body').waitMe({});
		var customerid = $("#customerid").val();
		$.ajax({
			url: '{{ url('/checkpay/') }}/'+customerid,
			dataType: 'json',
			success:function(data){
				if(!data){
					$('body').waitMe("hide");
					Lobibox.notify('error',{
						msg: 'ยังไม่ได้ทำการชำระเงินครั้งก่อน',
						buttonsAlign: 'center',
						closeOnEsc: true,
						sound: true,  
					});
				}else{
					var checkval = [];
					$("#submitform").prop('disabled',true);
					$("#rowdata tr").each(function(index, el) {
						var field = $(this).attr('id');
						var qty = $("#"+field+" td:nth-child(4) input[name='productqty[]']").val();
						var stock = $("#"+field+" td:nth-child(7) input[name='stock[]']").val();
						var oldqty = $("#"+field+" td:nth-child(4) input[name='productoldqty[]']").val();
						var check = $("#"+field+" td:nth-child(1) input[name='check[]']").is(":checked");
						if(check){
							console.log(qty + ' > '+stock)
							if(parseInt(qty) > parseInt(oldqty)){
								checkval.push(false);
								$(this).css('background-color','orange');
								// break;
							}else{
								if(parseInt(qty) > parseInt(stock)){
									checkval.push(false);
									$(this).css('background-color','red');
								}else{
									$(this).removeAttr('style');
								}
							}
						}
					});

					console.log(checkval)
					var checkqty = checkval.indexOf(false);
					if( checkqty >= 0){
						$('body').waitMe('hide');
						Lobibox.notify('error',{
							msg: 'กรุณาตรวจสอบจำนวนสินค้า! เนื่องจากมีรายการที่สินค้าไม่พอตามความต้องการหรือจำนวนที่ต้องการมากกว่าจำนวนออเดอร์ที่สั่ง',
							buttonsAlign: 'center',
							closeOnEsc: true,
							sound: true,  
						});
						
						return false;
					}else{

						$('#myForm').submit();
						$('body').waitMe({});
					}
				}
			}
		});
	}
	function changeunit(id){
		var customerid = $("#customerid").val();
		var data = id.id.split('unit');
		var proid = data[1];
		$.ajax({
			url: '{{ url('orderchangeunit') }}',
			data:{
				'id':id.value,
				'proid':proid,
				'customerid':customerid,
				'_token': "{{ csrf_token() }}",
			},
			type:'post',
			dataType: 'json',
			success:function(data){
				if(data != ''){
					$("#row"+proid+" td:nth-child(4) div").html(formatNumber(data.toFixed(2)));
					$("#row"+proid+" td:nth-child(4) input[name='productprice[]']").val(data);
					var qty = $('#qty'+proid).val();
					var price = $('#price'+proid).val()||0;
					var total = parseFloat(price*qty);
					$('#totalprosp'+proid).text(formatNumber(total.toFixed(2)));
					$('#totalpro'+proid).val(total);

					var sumrowall = 0;
					$("input[name='totalpro[]']").each(function(){
						sumrowall += parseFloat($(this).val()||0);
					});
					
					// <!-- คำนวณ ยอด -->
					$('#sumtotalsp').val(formatNumber(sumrowall.toFixed(2)));
					$('#sumtotal').val(sumrowall.toFixed(2));
					
					var sumtotal 	= $('#sumtotal').val()||0;
					var discount 	= $('#discount').val()||0;
					var sumdiscount	= parseFloat((discount)*sumtotal)/100;
					var vat 		= $('.vat:checked').val();
					var discounts	= parseFloat(sumtotal-sumdiscount);
					var lastbill 	= $('#discountlastbill').val()||0;
					
					$('#fontdis').html('<strong> => </strong>');
					$('#sumdiscountsp').val(formatNumber(sumdiscount.toFixed(2)));
					$('#sumdiscount').val(sumdiscount.toFixed(2));
					
					if(vat == 0){
						console.log(discounts);
						$('#sumvatsp').val('0.00');
						$('#sumvat').val('0.00');
						$('#sumpaymentsp').val(formatNumber(discounts.toFixed(2)));
						$('#sumpayment').val(discounts.toFixed(2));
						$('#sumtotalallsp').val(formatNumber((discounts-lastbill).toFixed(2)));
						$('#sumtotalall').val((discounts-lastbill).toFixed(2));
					}else if(vat == 1){
						sumvat 		= parseFloat(discounts * 7)/(100);
						var payment = parseFloat(discounts+sumvat);
						$('#sumvatsp').val(formatNumber(sumvat.toFixed(2)));
						$('#sumvat').val(parseFloat(sumvat.toFixed(2)));
						$('#sumpaymentsp').val(formatNumber(payment.toFixed(2)));
						$('#sumpayment').val(payment.toFixed(2));
						$('#sumtotalallsp').val(formatNumber((payment-lastbill).toFixed(2)));
						$('#sumtotalall').val((payment-lastbill).toFixed(2));
					}else if(vat == 2){
						sumvat = parseFloat(discounts * 100)/(107);
						var sumvats = parseFloat(discounts-sumvat);
						$('#sumvatsp').val(formatNumber(sumvats.toFixed(2)));
						$('#sumvat').val(sumvats.toFixed(2));
						$('#sumpaymentsp').val(formatNumber(discounts.toFixed(2)));
						$('#sumpayment').val(discounts.toFixed(2));
						$('#sumtotalallsp').val(formatNumber((discounts-lastbill).toFixed(2)));
						$('#sumtotalall').val((discounts-lastbill).toFixed(2));
					}
					
					// <!-- /คำนวณ ยอด -->
					
					$('#searchproduct').val('');
					$('#searchproduct').trigger("focus");
				}
			}
		});
	}
	function changepay(value){
		if(value == 'โอน'){
			$("#noauccount").css('display','block');
		}else{
			$("#noauccount").css('display','none').val("");
		}
	}
	function fncalmoney(){
		// alert();
		// <!-- คำนวณ ยอด -->
		var sumtotal 	= $('#sumtotal').val()||0;
		var discount 	= $('#discount').val()||0;
		var sumdiscount	= parseFloat((discount)*sumtotal)/100;
		var vat 		= $('.vat:checked').val();
		var discounts	= parseFloat(sumtotal-sumdiscount);
		var lastbill 	= $('#discountlastbill').val()||0;
		
		$('#fontdis').html('<strong> => </strong>');
		$('#sumdiscountsp').val(formatNumber(sumdiscount.toFixed(2)));
		$('#sumdiscount').val(sumdiscount.toFixed(2));
		
		if(vat == 0){
			$('#sumvatsp').val('0.00');
			$('#sumvat').val('0.00');
			$('#sumpaymentsp').val(formatNumber(discounts.toFixed(2)));
			$('#sumpayment').val(discounts.toFixed(2));
			$('#sumtotalallsp').val(formatNumber((discounts-lastbill).toFixed(2)));
			$('#sumtotalall').val((discounts-lastbill).toFixed(2));
		}else if(vat == 1){
			sumvat 		= parseFloat(discounts * 7)/(100);
			var payment = parseFloat(discounts+sumvat);
			$('#sumvatsp').val(formatNumber(sumvat.toFixed(2)));
			$('#sumvat').val(parseFloat(sumvat.toFixed(2)));
			$('#sumpaymentsp').val(formatNumber(payment.toFixed(2)));
			$('#sumpayment').val(payment.toFixed(2));
			$('#sumtotalallsp').val(formatNumber((payment-lastbill).toFixed(2)));
			$('#sumtotalall').val((payment-lastbill).toFixed(2));
		}else if(vat == 2){
			sumvat = parseFloat(discounts * 100)/(107);
			var sumvats = parseFloat(discounts-sumvat);
			$('#sumvatsp').val(formatNumber(sumvats.toFixed(2)));
			$('#sumvat').val(sumvats.toFixed(2));
			$('#sumpaymentsp').val(formatNumber(discounts.toFixed(2)));
			$('#sumpayment').val(discounts.toFixed(2));
			$('#sumtotalallsp').val(formatNumber((discounts-lastbill).toFixed(2)));
			$('#sumtotalall').val((discounts-lastbill).toFixed(2));
		}
		// <!-- /คำนวณ ยอด -->
	}

	//เช็คคลังสินค้าก่อนว่ามีสินค้าหรือไม่
	function checkstock(){
		var myForm = $("#myForm").serialize();
		$.ajax({
			url: '{{ url('export/checkstock') }}',
			data:myForm,
			type:'post',
			dataType: 'json',
			success:function(data){
				console.log(data[0]);
				var json = data[1];
				console.log(json);
				if(data[0]){
					$("#myForm").submit();
					return true;
				}else{
					if(json.length > 0){
						$(".rowproduct td:eq(0)").removeClass('bg-danger');
						$(".rowproduct td:eq(1)").removeClass('bg-danger');
						$(".rowproduct td:eq(2)").removeClass('bg-danger');
						$(".rowproduct td:eq(3)").removeClass('bg-danger');
						$(".rowproduct td:eq(4)").removeClass('bg-danger');
						$(".rowproduct td:eq(5)").removeClass('bg-danger');
						$(".rowproduct td:eq(6)").removeClass('bg-danger');
						json.forEach(function(index, key) {
							$("#row"+index.id+' td:eq(0)').addClass('bg-danger');
							$("#row"+index.id+' td:eq(1)').addClass('bg-danger');
							$("#row"+index.id+' td:eq(2)').addClass('bg-danger');
							$("#row"+index.id+' td:eq(3)').addClass('bg-danger');
							$("#row"+index.id+' td:eq(4)').addClass('bg-danger');
							$("#row"+index.id+' td:eq(5)').addClass('bg-danger');
							$("#row"+index.id+' td:eq(6)').addClass('bg-danger');
						});
					}
				}
			}
		});
		return false;
	}
	$("input[name='check[]']").click(function(event) {
		var checkclick = $(this).is(":checked");
		if(checkclick){
			console.log($(this).val());
			var enabled = false;
		}else{
			var enabled = true;
		}
		$(".rowproduct"+$(this).val()+" td input").prop('disabled', enabled );
		$(".rowproduct"+$(this).val()+" td input:checkbox").prop('disabled', false );
		
	});
</script>
@stop