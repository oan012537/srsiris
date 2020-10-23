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
		.classprintwarning{
			background: #fb6c6c;
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
							
							<form id="myForm" method="post" action="{{url('export_create')}}">
							{{ csrf_field() }}
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6">
										<fieldset>
											<legend class="text-semibold"><i class="icon-stack2"></i> ข้อมูลหลัก</legend>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>เลขที่ออเดอร์ :</label>
														<?php 
															if(!empty($invoice)){
																$str = $invoice->export_inv;
																$sub = substr($str,8,4)+1;
																$cut = substr($str,0,8);
																$inv = $cut.sprintf("%04d",$sub);
															}else{
																$dateY = date('Y');
																$dateM = date('m');
																$dateD = date('d');
																$cutdate = substr($dateY,2,2);
																$strdate = $cutdate.$dateM.$dateD.sprintf("%04d",1);
																$inv = 'SR'.$strdate;
															}
														?>
														<input type="text" class="form-control" name="invoice" id="invoice" placeholder="เลขที่ใบรับสินค้า" value="<?php echo $inv;?>" readonly>
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
															<input type="text" name="docdate" id="docdate" placeholder="วันที่" class="form-control datepicker-dates" onkeydown="return false;" autocomplete="off" value="<?php echo date('d/m/Y');?>">
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
														<input type="text" class="form-control" name="customername" id="customername" placeholder="ชื่อลูกค้า" autocomplete="new-password" value="">
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<label>เลขประจำตัวผู้เสียภาษีอากร :</label>
														<input type="text" class="form-control" name="customertax" id="customertax" placeholder="เลขประจำตัวผู้เสียภาษีอากร" autocomplete="off">
													</div>
													<input type="hidden" name="customerid" id="customerid" value="">
												</div>
											</div>

											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label>ที่อยู่ :</label>
														<textarea name="customeraddr" id="customeraddr" rows="2" class="form-control" placeholder="ที่อยู่"></textarea>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>เบอร์โทรศัพท์ :</label>
														<input type="text" class="form-control number" name="customercontel" id="customercontel" placeholder="เบอร์โทรศัพท์">
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
														<textarea name="note" id="note" rows="2" class="form-control" placeholder="หมายเหตุ"></textarea>
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
																{{-- <div class="col-md-2">
																	<div class="form-group has-feedback has-feedback-left">
																		<input type="text" id="searchbarcode" class="form-control input-xlg" placeholder="รหัสสินค้า">
																		<div class="form-control-feedback">
																			<i class="icon-barcode2"></i>
																		</div>
																	</div>
																</div> --}}
																<div class="col-md-3">
																	<div class="input-group has-feedback has-feedback-left">
																		<input type="text" id="searchbarcode" class="form-control input-xlg" placeholder="รหัสสินค้า">
																		<div class="form-control-feedback">
																			<i class="icon-barcode2"></i>
																		</div>
																		<span class="input-group-addon searchcode"><i class="icon-search4"></i></span>
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
															<tbody id="rowdata"></tbody>
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
																<input type="text" id="sumtotalsp" class="form-control summary-box textshow" onkeydown="return false;" value="0.00" autocomplete="off">
																<input type="hidden" class="form-control" name="sumtotal" id="sumtotal" readonly value="0.00">
															</div>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="row" style="display: none">
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
																	<input type="text" id="sumdiscountsp" class="form-control summary-box textshow" onkeydown="return false;" value="0.00" autocomplete="off">
																	<input type="hidden" class="form-control" name="sumdiscount" id="sumdiscount" value="0.00" readonly>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="row" style="display: none">
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
																	<input type="text" id="sumvatsp" class="form-control summary-box textshow" onkeydown="return false;" value="0.00" autocomplete="off">
																	<input type="hidden" class="form-control" name="sumvat" id="sumvat" value="0.00" readonly>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="row" style="display: none">
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
																	<input type="text" id="sumpaymentsp" class="form-control summary-box textshow" onkeydown="return false;" value="0.00" autocomplete="off">
																	<input type="hidden" class="form-control" name="sumpayment" id="sumpayment" value="0.00" readonly>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<br>
											<div class="row" style="display: none">
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
																	<input type="text" id="sumtotalallsp" class="form-control summary-box textshow" onkeydown="return false;" value="0.00" autocomplete="off">
																	<input type="hidden" class="form-control" name="sumtotalall" id="sumtotalall" value="0.00" readonly>
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
	<div id="myModalview" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">

		<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h4 class="modal-title">ตรวจสอบข้อมูลสินค้าที่เคยสั่ง</h4>
				</div>
				<div class="modal-body">
					<div class="form-inline">
						<div id="rowdata">
							<table class="table">
								<thead>
									<tr>
										<th class="text-center" width="10%">ลำดับ</th>
										{{-- <th class="text-center" width="20%">เลขที่ออเดอร์</th> --}}
										<th class="text-center" width="30%">วันที่</th>
										<th class="text-center" width="20%">จำนวน</th>
										<th class="text-center" width="20%">ราคา</th>
									</tr>
								</thead>
								<tbody id="rowdatas">

								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div id="myModalvieworder" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">

		<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h4 class="modal-title">ข้อมูลสินค้าในออเดอร์ที่ไม่ได้ส่งไปการขาย</h4>
				</div>
				<div class="modal-body">
					<div class="form-inline">
						<div id="rowdata">
							<table class="table">
								<thead>
									<tr>
										<th class="text-center" width="10%">ลำดับ</th>
										<th class="text-center" width="20%">เลขที่ออเดอร์</th>
										<th class="text-center" width="30%">วันที่</th>
										<th class="text-center" width="20%">จำนวนที่เหลือ</th>
										<th class="text-center" width="20%">หน่วย</th>
									</tr>
								</thead>
								<tbody id="rowdataorders">

								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
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

	$(".searchcode").click(function(event) {
		searchcodeproduct();
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
	$('#searchbarcode').keyup(function(e){
		if(e.which == 13){
			searchcodeproduct();
		}
	});
	$('#customername,#customertax,#customeraddr,#customercontel,#note').keyup(function(e){
		if(e.which == 13){
			$("#searchproduct").focus();
		}
	});
	// $(document).keypress(function(e){
	// 	if(e.which == 13){
	// 		// searchcodeproduct();
	// 		$("#searchproduct").focus();
	// 	}
	// });
	
	function searchcodeproduct(){
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
							if($(this).is('#row'+find+item.id) == true){
								find++;
							}
						});
						
						// if(find == 0){
							var unitname = '';
							var select = '<select class="form-control" id="unit'+find+item.id+'" onchange="changeunit(this)" name="unit[]" required style="width:150px;">';
							$.each(item.unitdata,function(key2,item2){
								select += '<option value="1,'+item2.unit_unitfirst+'">'+item2.unit_name+'</option>';
								select += '<option value="2,'+item2.unit_unitsec+'">'+item2.unitsub_name+'</option>';
								if(key2 == 0){
									unitname = item2.unit_name; //แก้เป็นหน่วยใหญ่
								}
								// unitname = item2.unitsub_name;
							});
							if(item.unitdata.length == 0){
								select += '<option value="1,'+item.unitid+'">'+item.unit+'</option>';
								unitname = item.unit;
							}
							select += '</select>'
							$('#rowdata').append('<tr class="rowproduct" id="row'+find+item.id+'"><td align="center">'+item.code+'</td>'
								+'<td>'+item.name+'<input type="hidden" name="productid[]" value="'+item.id+'"></td>'
								+'<td align="center"><input type="number" inputmode="numeric" class="form-control number" name="productqty[]" id="qty'+find+item.id+'" onkeyup="qtypush(\''+find+item.id+'\')" value="1" style="width:70px"></td>'
								+'<td align="center">'+select+'</td>'
								+'<td align="right"><input type="number" inputmode="numeric" class="form-control number" placeholder="0" name="productprice[]" id="price'+find+item.id+'" value="'+(item.price == 0 ? '' : item.price)+'" onkeyup="qtypush(\''+find+item.id+'\')"><input type="hidden" id="savekeypeice'+find+item.id+'"><input type="hidden" id="pricesystem'+find+item.id+'" value="'+(item.capital == 0 ? '' : item.capital)+'"></td>'
								+'<td align="center">'+item.stock+' ( '+unitname+' )</td>'
								+'<td align="right"><span id="totalprosp'+find+item.id+'"></span><input type="hidden" name="totalpro[]" id="totalpro'+find+item.id+'"></td>'
								+'<td  align="center"><button type="button" class="btn btn-danger btn-rounded" onclick="delrow(\''+find+item.id+'\')"><i class="icon-cancel-square position-left"></i> Delete</button> <button type="button" class="btn btn-primary btn-rounded" onclick="view(\''+item.id+'\')"><i class="icon-search4 position-left"></i> View</button></td>'
							+'</tr>');
							var price = $('#price'+find+item.id).val()||0;
							var total = parseFloat(price*1);
							$('#totalprosp'+find+item.id).text(formatNumber(total.toFixed(2)));
							$('#totalpro'+find+item.id).val(total);
							notkeystr();
						// }else{
						// 	var qty = $('#qty'+item.id).val();
						// 	var sum = parseInt(qty)+1;
						// 	var price = $('#price'+item.id).val()||0;
						// 	var total = parseFloat(price*sum);
							
						// 	$('#qty'+item.id).val(sum);
						// 	$('#totalprosp'+item.id).text(formatNumber(total.toFixed(2)));
						// 	$('#totalpro'+item.id).val(total);
						// }
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
							if($(this).is('#row'+find+item.id) == true){
								find++;
							}                 
						});
						
						// if(find == 0){
							var select = '<select class="form-control" id="unit'+find+item.id+'" onchange="changeunit(this)" name="unit[]" required style="width:150px;">';
							var unitname = '';
							$.each(item.unitdata,function(key2,item2){
								select += '<option value="1,'+item2.unit_unitfirst+'">'+item2.unit_name+'</option>';
								select += '<option value="2,'+item2.unit_unitsec+'">'+item2.unitsub_name+'</option>';
								if(key2 == 0){
									unitname = item2.unit_name; //แก้เป็นหน่วยใหญ่
								}
								// unitname = item2.unitsub_name;
								
							});
							if(item.unitdata.length == 0){
								select += '<option value="1,'+item.unitid+'">'+item.unit+'</option>';
								unitname = item.unit;
							}
							select += '</select>';

							$('#rowdata').append('<tr class="rowproduct" id="row'+find+item.id+'"><td align="center">'+item.code+'</td>'
								+'<td>'+item.name+'<input type="hidden" name="productid[]" value="'+item.id+'"></td>'
								+'<td align="center"><input type="number" inputmode="numeric" class="form-control number" name="productqty[]" id="qty'+find+item.id+'" onkeyup="qtypush(\''+find+item.id+'\')" value="1" style="width:70px"></td>'
								+'<td align="center">'+select+'</td>'
								+'<td align="right"><div>'+formatNumber(item.price.toFixed(2))+'</div><input type="number" class="form-control number" inputmode="numeric" placeholder="0"  name="productprice[]" id="price'+find+item.id+'" value="'+(item.price == 0 ? '' : item.price)+'" onkeyup="qtypush(\''+find+item.id+'\')"><input type="hidden" id="savekeypeice'+find+item.id+'"><input type="hidden" id="pricesystem'+find+item.id+'" value="'+(item.capital == 0 ? '' : item.capital)+'"></td>'
								+'<td align="center">'+item.stock+' ( '+unitname+' )</td>'
								
								+'<td align="right"><span id="totalprosp'+find+item.id+'"></span><input type="hidden" name="totalpro[]" id="totalpro'+find+item.id+'"></td>'
								+'<td  align="center"><button type="button" class="btn btn-danger btn-rounded" onclick="delrow(\''+find+item.id+'\')"><i class="icon-cancel-square position-left"></i> Delete</button> <button type="button" class="btn btn-primary btn-rounded" onclick="view(\''+item.id+'\')"><i class="icon-search4 position-left"></i> View</button></td>'
							+'</tr>');
							var price = $('#price'+find+item.id).val()||0;
							var total = parseFloat(price*1);
							$('#totalprosp'+find+item.id).text(formatNumber(total.toFixed(2)));
							$('#totalpro'+find+item.id).val(total);
							notkeystr();
						// }else{
						// 	var qty = $('#qty'+item.id).val();
						// 	var sum = parseInt(qty)+1;
						// 	var price = $('#price'+item.id).val()||0;
						// 	var total = parseFloat(price*sum);
							
						// 	$('#qty'+item.id).val(sum);
						// 	$('#totalprosp'+item.id).text(formatNumber(total.toFixed(2)));
						// 	$('#totalpro'+item.id).val(total);
						// }
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
		var pricesystem = $("#pricesystem"+id).val();
		if(parseFloat(price) < parseFloat(pricesystem)){
			$("#row"+id).addClass('classprintwarning')
			Lobibox.notify('error',{
				msg: 'กรุณาตรวจสอบราคาสินค้าน้อยกว่าต้นทุน!',
				buttonsAlign: 'center',
				closeOnEsc: true,
				sound: false,
			});
		}else{
			$("#row"+id).removeClass('classprintwarning')
		}
		$("#savekeypeice"+id).val(price);
		// var totalpro 	= qty*price;
		var stock = $("#row"+id+" td:nth-child(6)").text()||0;
		var chcek = (stock - qty);
		console.log("stock : "+chcek);
		//เช็คจำนวนที่ต้องการไม่ให้มากกว่าจำนวนที่เหลือ
		// if(chcek < 0){
		// 	Lobibox.notify('error',{
		// 		msg: 'จำนวนคงเหลือไม่พอ!',
		// 		buttonsAlign: 'center',
		// 		closeOnEsc: true,
		// 		sound: true,  
		// 	});
		// 	qty = stock;
		// 	$('#qty'+id).val(qty);
		// }
		
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
	
	// <!-- Vat Process -->
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
	// <!-- /Vat Process -->
	
	// <!-- Discount Process -->
	$('#discount').change(function(){
		// <!-- คำนวณ ยอด -->
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
		// <!-- /คำนวณ ยอด -->
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
		var customername = $("#customername").val();
		if(customername == ''){
			Lobibox.notify('error',{
				msg: 'กรุณาเพิ่มข้อมูลลูกค้า',
				buttonsAlign: 'center',
				closeOnEsc: true,
				sound: true,  
			});
			return false;
		}
		var customerid = $("#customerid").val();
		if($("#rowdata tr").length == 0){
			Lobibox.notify('error',{
				msg: 'กรุณาเพิ่มสินค้า',
				buttonsAlign: 'center',
				closeOnEsc: true,
				sound: true,  
			});
			return false;
		}
		var checkinputqty = true;
		var checkprice = true;
		$('input[name="productqty[]"]').each(function(index, el) {
			var getid = el.id
			var filed = getid.replace('qty','');
			var price 		= $('#price'+filed).val()||0;
			var pricesystem = $("#pricesystem"+filed).val();
			if(parseFloat(price) < parseFloat(pricesystem)){
				$("#row"+filed).addClass('classprintwarning');
				checkprice = false;
			}
			if($(this).val() == 0 || $(this).val() == ''){
				checkinputqty = false;
			}
		});
		if(!checkinputqty){
			Lobibox.notify('error',{
				msg: 'กรุณาตรวจสอบจำนวนสินค้า กรุณาใส่จำนวนให้มากกว่า0หรือปล่อยว่าง',
				buttonsAlign: 'center',
				closeOnEsc: true,
				sound: true,  
			});
			return false;
		}
		if(!checkprice){
			Lobibox.notify('warning',{
				msg: 'กรุณาตรวจสอบราคาสินค้า เนื่องจากบางรายการมีราคาน้อยกว่าราคาต้นทุน',
				buttonsAlign: 'center',
				closeOnEsc: true,
				sound: false,  
			});
			return false;
		}
		$.ajax({
			url: '{{ url('/export/checkorder/') }}',
			type:'post',
			data:$('#myForm').serialize(),
			dataType: 'json',
			success:function(data){
				var txt = '';
				if(data.length > 0){
					data.forEach(function(index, key) {
						txt += '<tr>';
						txt += '<td>'+(key+1)+'</td>';
						txt += '<td>'+index.export_inv+'</td>';
						txt += '<td>'+index.export_date+'</td>';
						txt += '<td>'+index.order_balance+'</td>';
						txt += '<td>'+index.unitname+'</td>';
						txt += '<tr>';
					});
					$("#rowdataorders").empty().append(txt);
					$("#myModalvieworder").modal('show');
					
				}else{
					submitorder(customerid);
				}
				
			}
			
		});
		
		
	}
	function submitorder(customerid){
		$.ajax({
			url: '{{ url('/checkpay/') }}/'+customerid,
			dataType: 'json',
			success:function(data){
				if(!data){
					Lobibox.notify('error',{
						msg: 'ยังไม่ได้ทำการชำระเงินครั้งก่อน',
						buttonsAlign: 'center',
						closeOnEsc: true,
						sound: true,  
					});
				}else{
					// alert()
					$('#myForm').submit();
				}
			}
		});
	}
	function changeunit(id){
		var customerid = $("#customerid").val();
		var data = id.id.split('unit');
		var proid = data[1];
		var price = $("#savekeypeice"+proid).val();
		$.ajax({
			url: '{{ url('orderchangeunit') }}',
			data:{
				'id':id.value,
				'proid':proid,
				'price':price,
				'customerid':customerid,
				'_token': "{{ csrf_token() }}",
			},
			type:'post',
			dataType: 'json',
			success:function(data){
				if(data.length != 0){
					var dataprice = parseFloat(data.price);
					$("#row"+proid+" td:nth-child(5) div").html(formatNumber(dataprice.toFixed(2)));
					$("#row"+proid+" td:nth-child(5) input[name='productprice[]']").val(data.price);
					$("#row"+proid+" td:nth-child(5) #pricesystem"+proid).val(data.price);

					$("#row"+proid+" td:nth-child(6)").html(data.stock+' ( '+data.name+' )');

					var qty = $('#qty'+proid).val();
					var price = $('#price'+proid).val()||0;
					price = price.replace(',','');
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
					
					// $('#searchproduct').val('');
					// $('#searchproduct').trigger("focus");
				}
			}
		});
	}
	function view(id) {
		var myForm = $("#myForm").serialize();
		$.post("{{url('export/checkviewbeforeorder')}}", myForm+'&viewproductid='+id, function(data, textStatus, xhr) {
			var txt = '';
			data.forEach(function(index, el) {
				txt += '<tr>';
				txt += '<td>'+(el+1)+'</td>';
				// txt += '<td>'+index.selling_inv+'</td>';
				txt += '<td>'+index.export_date+'</td>';
				txt += '<td>'+index.order_qty+'</td>';
				txt += '<td>'+index.order_price+'</td>';
				txt += '<tr>';
			});
			$("#rowdatas").empty().append(txt);
		});
		$("#myModalview").modal('show');
	}
	$('#myModalvieworder').on('hidden.bs.modal', function () {
		var customerid = $("#customerid").val();
		bootbox.confirm({
			title: "ยืนยัน?",
			message: "คุณต้องการบันทึกรายการนี้ หรือไม่?",
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
					submitorder(customerid);
				}
			}
		});
	});
</script>
@stop