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
		.classorder{
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
										<li><a data-action="move" onclick="newpage();"></a></li>
										<li><a data-action="close"></a></li>
									</ul>
								</div>
							</div>
							
							<form id="myForm" method="post" action="{{url('export_update')}}">
							{{ csrf_field() }}
							<input type="hidden" name="exportid" value="{{ $export->export_id }}">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6">
										<fieldset>
											<legend class="text-semibold"><i class="icon-stack2"></i> ข้อมูลหลัก</legend>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>เลขที่ออเดอร์ :</label>
														<input type="text" class="form-control" name="invoice" id="invoice" placeholder="เลขที่ใบรับสินค้า" value="{{ $export->export_inv}}" readonly>
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<br>
														<label class="checkbox-inline checkbox-switchery checkbox-right switchery-xs">
															<input type="checkbox" class="switch" value="on">
														</label>
													</div>
												</div>
											</div>
										
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>วันที่ :</label>
														<div class="input-group">
															<input type="text" name="docdate" id="docdate" placeholder="วันที่" class="form-control datepicker-dates" onkeydown="return false;" autocomplete="off" value="{{ $export->export_date}}">
														</div>
													</div>
												</div>
												
												<div class="col-md-6">
													<div class="form-group">
														<label>พนักงานขาย :</label>
														<div class="input-group">
															<input type="text" name="empsalename" id="empsalename" class="form-control" onkeydown="return false;" autocomplete="off" value="<?php echo Auth::user()->name;?>" readonly>
															<input type="hidden" name="empsaleid" id="empsaleid" class="form-control" onkeydown="return false;" autocomplete="off" value="<?php echo Auth::user()->id;?>" readonly>
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
														<input type="text" class="form-control" name="customername" id="customername" placeholder="ชื่อลูกค้า" autocomplete="new-password" value="{{ $customer->customer_name }}">
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<label>เลขประจำตัวผู้เสียภาษีอากร :</label>
														<input type="text" class="form-control" name="customertax" id="customertax" placeholder="เลขประจำตัวผู้เสียภาษีอากร" autocomplete="off" value="{{ $customer->customer_idtax }}">
													</div>
													<input type="hidden" name="customerid" id="customerid" value="{{ $customer->customer_id }}">
												</div>
											</div>

											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label>ที่อยู่ :</label>
														<textarea name="customeraddr" id="customeraddr" rows="2" class="form-control" placeholder="ที่อยู่">{{ $customer->location }}</textarea>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>เบอร์โทรศัพท์ :</label>
														<input type="text" class="form-control number" name="customercontel" id="customercontel" placeholder="เบอร์โทรศัพท์" value="{{ $customer->customer_tel }}">
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
														<textarea name="note" id="note" rows="2" class="form-control" placeholder="หมายเหตุ">{{ $customer->customer_note }}</textarea>
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
													<div class="form-group">
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
													<table id="myTable" class="table table-framed">
														<thead>
															<tr>
																<th class="text-center">รหัสสินค้า</th>
																<th class="text-center">รายการสินค้า</th>
																<th class="text-center" style="width:150px;">หน่วยนับ</th>
																<th class="text-center" style="width:100px;">ราคาขาย</th>
																<th class="text-center">จำนวน</th>
																<th class="text-center">รวม</th>
																<th class="text-center">#</th>
															</tr>
														</thead>
														<tbody id="rowdata">
															@if(!empty($order))
																@foreach($order as $key => $dataorder)
																<tr class="rowproduct" id="row{{ $dataorder->product_id }}">
																	<td align="center">{{ $dataorder->product_code }}</td>
																	<td>{{ $dataorder->product_name }}<input type="hidden" name="productid[]" value="{{ $dataorder->product_id }}"></td>
																	<td align="center">{{ $dataorder->unit_name }}</td>
																	<td align="right">{{ $dataorder->order_price }}<input type="hidden" class="form-control" name="productprice[]" id="price{{ $dataorder->product_id }}" value="{{ $dataorder->order_price }}"></td>
																	<td align="center"><input type="text" class="form-control number" name="productqty[]" id="qty{{ $dataorder->product_id }}" onkeyup="qtypush({{ $dataorder->product_id }})" value="{{ $dataorder->order_qty }}" style="width:70px"></td>
																	<td align="right"><span id="totalprosp{{ $dataorder->product_id }}">{{ $dataorder->order_total }}</span><input type="hidden" name="totalpro[]" id="totalpro{{ $dataorder->product_id }}" value="{{ $dataorder->order_total }}"></td>
																	<td  align="center"><button type="button" class="btn btn-danger btn-rounded" onclick="delrow({{ $dataorder->product_id }})"><i class="icon-cancel-square position-left"></i> Delete</button></td>
																</tr>
																@endforeach
															@endif
														</tbody>
													</table>
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
																<input type="text" id="sumtotalsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{ $export->export_total }}" autocomplete="off">
																<input type="hidden" class="form-control" name="sumtotal" id="sumtotal" readonly value="{{ $export->export_total }}">
															</div>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="row">
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
																	<input type="text" id="sumdiscountsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{ $export->export_discountsum }}" autocomplete="off">
																	<input type="hidden" class="form-control" name="sumdiscount" id="sumdiscount" value="{{ $export->export_discountsum }}" readonly>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="row">
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
																	<input type="text" id="sumvatsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{ $export->export_vat }}" autocomplete="off">
																	<input type="hidden" class="form-control" name="sumvat" id="sumvat" value="{{ $export->export_vat }}" readonly>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="">
													<div class="col-md-12">
														<div class="col-md-4"></div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label col-md-4">การชำระเงิน</label>
																<div class="col-md-8">
																	<?php 
																		$payment = array('เงินสด','เครดิต','เครดิต 15 วัน','เครดิต 30 วัน');
																	?>
																	<select name="payment" id="payment" class="form-control">
																		<?php
																			foreach($payment as $pay){
																				echo '<option value="'.$pay.'">'.$pay.'</option>';
																			}
																		?>
																	</select>
																</div>
															</div>
														</div>
														
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label col-md-4"><span><strong>รวมทั้งสิ้น</strong></span></label>
																<div class="col-md-8">
																	<input type="text" id="sumpaymentsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{ $export->export_totalall }}" autocomplete="off">
																	<input type="hidden" class="form-control" name="sumpayment" id="sumpayment" value="{{ $export->export_totalall }}" readonly>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="">
													<div class="col-md-12">
														<div class="col-md-4"></div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label col-md-4">ส่วนลดท้ายบิล</label>
																<div class="col-md-8">
																	<input type="text" class="form-control number" name="discountlastbill" id="discountlastbill">
																</div>
															</div>
														</div>
														
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label col-md-4"><span><strong><font color="green">ยอดชำระ</font></strong></span></label>
																<div class="col-md-8">
																	<input type="text" id="sumtotalallsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{ $export->export_totalpayment }}" autocomplete="off">
																	<input type="hidden" class="form-control" name="sumtotalall" id="sumtotalall" value="{{ $export->export_totalpayment }}" readonly>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="">
													<div class="col-md-12">
														<div class="col-md-4"></div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label col-md-4">สถานะ</label>
																<div class="col-md-8">
																	<div class="radio">
																		<label>
																			<input type="radio" class="styled " name="status" id="status1" value="1" checked="checked"> เรียบร้อย
																		</label>
																	</div>
																	<div class="radio">
																		<label>
																			<input type="radio" class="styled " name="status" id="status2" value="2"> บิลชั่วคราว
																		</label>
																	</div>
																	<div class="radio">
																		<label>
																			<input type="radio" class="styled " name="status" id="status2" value="3"> ยกเลิก
																		</label>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="text-right">
												<a href="{{url('export')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
												<button type="button" id="submitform" class="btn btn-primary"><i class="icon-floppy-disk"></i>  บันทึก</button>
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
					
					<!-- คำนวณ ยอด -->
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
					
					<!-- /คำนวณ ยอด -->
					
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
					
					<!-- คำนวณ ยอด -->
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
					
					<!-- /คำนวณ ยอด -->
					
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
	}
	
	<!-- Vat Process -->
	$('input.vat').on('change', function() {
		var vat 		= $(this).val();
		var sumtotal 	= $('#sumtotal').val()||0;
		var sumdiscount	= $('#sumdiscount').val()||0;
		var sumvat 		= 0;
		var discount	= parseFloat(sumtotal-sumdiscount);
		var lastbill 	= $('#discountlastbill').val()||0;
		
		if(vat == 0){
			$('#sumvatsp').val('0.00');
			$('#sumvat').val('0.00');
			$('#sumpaymentsp').val(formatNumber(discount.toFixed(2)));
			$('#sumpayment').val(discount.toFixed(2));
			$('#sumtotalallsp').val(formatNumber((discount-lastbill).toFixed(2)));
			$('#sumtotalall').val((discount-lastbill).toFixed(2));
		}else if(vat == 1){
			sumvat 		= parseFloat(discount * 7)/(100);
			var payment = parseFloat(discount+sumvat);
			$('#sumvatsp').val(formatNumber(sumvat.toFixed(2)));
			$('#sumvat').val(parseFloat(sumvat.toFixed(2)));
			$('#sumpaymentsp').val(formatNumber(payment.toFixed(2)));
			$('#sumpayment').val(payment.toFixed(2));
			$('#sumtotalallsp').val(formatNumber((payment-lastbill).toFixed(2)));
			$('#sumtotalall').val((payment-lastbill).toFixed(2));
		}else if(vat == 2){
			sumvat = parseFloat(discount * 100)/(107);
			var sumvats = parseFloat(discount-sumvat);
			$('#sumvatsp').val(formatNumber(sumvats.toFixed(2)));
			$('#sumvat').val(sumvats.toFixed(2));
			$('#sumpaymentsp').val(formatNumber(discount.toFixed(2)));
			$('#sumpayment').val(discount.toFixed(2));
			$('#sumtotalallsp').val(formatNumber((discount-lastbill).toFixed(2)));
			$('#sumtotalall').val((discount-lastbill).toFixed(2));
		}
	});
	<!-- /Vat Process -->
	
	<!-- Discount Process -->
	$('#discount').change(function(){
		<!-- คำนวณ ยอด -->
		var sumtotal 	= $('#sumtotal').val()||0;
		var discount 	= $(this).val();
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
		<!-- /คำนวณ ยอด -->
	});
	<!-- /Discount Process -->
	
	<!-- Discountlastbill Process -->
	$('#discountlastbill').keyup(function(){
		var payment = $('#sumpayment').val()||0;
		var lastbill = $(this).val()||0;
		var payments =  parseFloat(payment)-parseFloat(lastbill);
		$('#sumtotalallsp').val(formatNumber(payments.toFixed(2)));
		$('#sumtotalall').val(payments.toFixed(2));
	});
	<!-- /Discountlastbill Process -->
	
	function delrow(id){
		$('#row'+id).closest('tr').remove();
		
		var sumrowall = 0;
		$("input[name='totalpro[]']").each(function(){
			sumrowall += parseFloat($(this).val()||0);
		});
		
		<!-- คำนวณ ยอด -->
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
		<!-- /คำนวณ ยอด -->
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
		$('#myForm').submit();
	});
	function newpage(){
		window.open('create');
	}
</script>
@stop