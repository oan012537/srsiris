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
		.classselling{
			background: rgb(199,199,199,0.3);
		}
		.disabled{
			pointer-events: none;
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
							
							<form id="myForm" method="post" action="{{url('sellinggrouporder')}}">
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
																$sub = substr($str,6,3)+1;
																$cut = substr($str,0,6);
																$inv = $cut.sprintf("%03d",$sub);
															}else{
																$dateY = date('Y');
																$dateM = date('m');
																$dateD = date('d');
																$cutdate = substr($dateY,2,2);
																$strdate = $cutdate.$dateM.$dateD.sprintf("%03d",1);
																$inv = $strdate;
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
														<input type="text" class="form-control" name="customername" id="customername" placeholder="ชื่อลูกค้า" autocomplete="new-password" value="เงินสด">
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<label>เลขประจำตัวผู้เสียภาษีอากร :</label>
														<input type="text" class="form-control" name="customertax" id="customertax" placeholder="เลขประจำตัวผู้เสียภาษีอากร" autocomplete="off">
													</div>
													<input type="hidden" name="customerid" id="customerid" value="1">
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
														<div class="col-md-2">
															<button type="button" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#myModal"><i class=" icon-plus-circle2 position-left"></i> เพิ่มออเดอร์</button>
														</div>
													</div>
													<br><br>
													<table id="myTable" class="table table-framed">
														<thead>
															<tr>
																<th class="text-center">ออเดอร์</th>
																<th class="text-center">วันที่</th>
																<th class="text-center" style="width:150px;">ลูกค้า</th>
																<th class="text-center" style="width:100px;">จำนวน</th>
																{{-- <th class="text-center">จำนวน</th> --}}
																{{-- <th class="text-center">รวม</th> --}}
																<th class="text-center">#</th>
															</tr>
														</thead>
														<tbody id="rowdata"></tbody>
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
																<input type="text" id="sumtotalsp" class="form-control summary-box textshow" onkeydown="return false;" value="0.00" autocomplete="off">
																<input type="hidden" class="form-control" name="sumtotal" id="sumtotal" readonly value="0.00">
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
																	<input type="text" id="sumdiscountsp" class="form-control summary-box textshow" onkeydown="return false;" value="0.00" autocomplete="off">
																	<input type="hidden" class="form-control" name="sumdiscount" id="sumdiscount" value="0.00" readonly>
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
																	<input type="text" id="sumvatsp" class="form-control summary-box textshow" onkeydown="return false;" value="0.00" autocomplete="off">
																	<input type="hidden" class="form-control" name="sumvat" id="sumvat" value="0.00" readonly>
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
																	<input type="text" id="sumpaymentsp" class="form-control summary-box textshow" onkeydown="return false;" value="0.00" autocomplete="off">
																	<input type="hidden" class="form-control" name="sumpayment" id="sumpayment" value="0.00" readonly>
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
	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">ออเดอร์</h4>
			</div>
			<div class="modal-body">
			  <table class="table table-bordered" id="datatables">
				<thead>
					<tr>
						<th class="text-center">ลำดับ</th>
						<th class="text-center">ออเดอร์</th>
						<th class="text-center">วันที่</th>
						<th class="text-center">ลูกค้า</th>
						<th class="text-center">จำนวน</th>
						<th class="text-center">#</th>
					</tr>
				</thead>
				<tbody></tbody>
			  </table>
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
		var switches = Array.prototype.slice.call(document.querySelectorAll('.switch'));
		switches.forEach(function(html) {
			var switchery = new Switchery(html, {color: '#4CAF50'});
		});
		
		var oTable = $('#datatables').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: false,
			ajax:{ 
				url : "{{url('showorders')}}",
			},
			columns: [
				{ 'className': "text-center", data: 'export_id', name: 'export_id' },
				{ 'className': "text-center", data: 'export_inv', name: 'export_inv' },
				{ 'className': "text-center", data: 'export_date', name: 'export_date	' },
				{ 'className': "text-left", data: 'export_customername', name: 'export_customername' },
				{ 'className': "text-right", data: 'export_totalpayment', name: 'export_totalpayment' },
				{ 'className': "text-center", data: 'updated_at', name: 'updated_at' },
			],
			order: [[0, 'asc']],
			rowCallback: function(row,data,index ){
				$('td:eq(5)', row).html( '<i id="chooseorder'+data['export_id']+'" class="icon-stack-check" onclick="chooseorder('+"'"+data['export_id']+"'"+','+"'"+data['export_inv']+"'"+',\''+data['export_date']+'\',\''+data['export_customerid']+'\',\''+data['export_totalpayment']+'\');" data-popup="tooltip" title="Select"></i>' );
			}
		});
		oTable.on( 'order.dt search.dt', function(){
			oTable.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell, i){
				cell.innerHTML = i+1;
			} );
		}).draw();
	});
	function chooseorder(id,inv,date,cusid,total){
		// $("#chooseorder"+id).removeAttr('onclick');
		$("#chooseorder"+id).addClass('disabled');
		$('#myModal').modal('hide');
		$.ajax({
			url: "{{url('searchexport')}}",
			type: 'post',
			data: {
				'id': id,
				'_token': "{{ csrf_token() }}"
			},
			success:function(result){
				$('#rowdata').append('<tr class="rowproduct" id="row'+result[0].export_id+'"><td align="center">'+result[0].export_inv+'</td>'
				+'<td align="center">'+result[0].export_date+'<input type="hidden" name="order[]" value="'+result[0].export_id+'"></td>'
				+'<td>'+result[0].export_customername+'</td>'
				+'<td align="right">'+total+'</td>'
				+'<td  align="center"><button type="button" class="btn btn-danger btn-rounded" onclick="delrow(\''+result[0].export_id+'\')"><i class="icon-cancel-square position-left"></i> Delete</button></td>'
				+'</tr>');
				searchproduct(result[0].export_customerid,result[0].export_id);
				// $.each(result,function(key,item){
				// 	searchproduct(item.order_productid,item.export_customerid,item.export_id);
				// });
			}
		});
		
	}
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

	function searchproduct(cusid,ref){
		$.ajax({
			'dataType': 'json',
			'type': 'post',
			'url': "{{url('searchproduct')}}",
			'data': {
				'cusid': cusid,
				// 'id': id,
				'ref': ref,
				'_token': "{{ csrf_token() }}"
			},
			'success': function(data){
				var count 	= data.length;
				if(count != 0){
					var datatext = '<tr class="ref'+ref+'"><td colspan="5"><table class="table" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'
						+'<th class="text-center bg-info">รหัสสินค้า</th>'
						+'<th class="text-center bg-info">รายการสินค้า</th>'
						+'<th class="text-center bg-info">หน่วยนับ</th>'
						+'<th class="text-center bg-info">ราคาขาย</th>'
						+'<th class="text-center bg-info">จำนวน</th>'
						+'<th class="text-center bg-info">รวม</th>'
						+'<th class="text-center bg-info">#</th><tbody id="showorders'+ref+'"></tbody>'
						+'</table></td></tr>';
						$('#rowdata').append(datatext);
					$.each(data,function(key,item){
						var find = 0;
						var text = '';
						// $('#rowdata tr').each(function(){
						// 	if($(this).is('#row'+item.id) == true){
						// 		find = 1;
						// 	}                 
						// });
						
						// if(find == 0){
							text += '<tr class="rowproduct" id="roworder'+item.orderid+'"><td align="center">'+item.code+'</td>'
							+'<td>'+item.name+'<input type="hidden" name="productid[]" value="'+item.id+'"></td>'
							+'<td align="center">'+item.unit+'</td>'
							+'<td align="right">'+formatNumber(item.price.toFixed(2))+'<input type="hidden" class="form-control" name="productprice[]" id="price'+item.orderid+'" value="'+item.price+'"></td>'
							+'<td align="center"><input type="text" class="form-control number" name="productqty[]" id="qty'+item.orderid+'" onkeyup="qtypush(\''+item.orderid+'\')" value="'+item.qty+'" style="width:70px"></td>'
							+'<td align="right"><span id="totalprosp'+item.orderid+'"></span><input type="hidden" name="totalpro[]" id="totalpro'+item.orderid+'"></td>'
							+'<td  align="center"><button type="button" class="btn btn-danger btn-rounded" onclick="delroworder(\''+item.orderid+','+item.id+'\')"><i class="icon-cancel-square position-left"></i> Delete</button></td>'
							+'</tr>';
							$("#showorders"+ref).append(text);
							var qty = $('#qty'+item.orderid).val();
							var price = $('#price'+item.orderid).val()||0;
							var total = parseFloat(price*qty);
							$('#totalprosp'+item.orderid).text(formatNumber(total.toFixed(2)));
							$('#totalpro'+item.orderid).val(total);
							
						// }else{
						// 	var qty = $('#qty'+item.id).val();
						// 	// var sum = parseInt(qty)+1; //ของเก่า
						// 	var sum = parseInt(qty)+item.qty;
						// 	var price = $('#price'+item.id).val()||0;
						// 	var total = parseFloat(price*sum);
							
						// 	$('#qty'+item.id).val(sum);
						// 	$('#totalprosp'+item.id).text(formatNumber(total.toFixed(2)));
						// 	$('#totalpro'+item.id).val(total);
						// }
					});

				}else{
					text += '<tr class="bg-success"><td colspan="6" align="center">-- No data --</td></tr>';
				}
				$("#rowdata").append('<tr class="ref'+ref+'"><td colspan="5" style="background: lavenderblush;"></td></tr>');
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
		$('.ref'+id).closest('tr').remove();
		$("#chooseorder"+id).removeClass('disabled');
		cal();
	}
	function delroworder(id,productid){
		bootbox.confirm({
			title: "ยืนยัน?",
			message: "คุณต้องการลบรายการสินค้านี้ หรือไม่?",
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
						url: "{{url('searchproduct')}}",
						type: 'post',
						data: {
							'orderid': id,
							'productid':productid,
							'_token': "{{ csrf_token() }}"
						},success:function(result){
							$('#roworder'+id).closest('tr').remove();
							$("#chooseorder"+id).removeClass('disabled');
							cal();
						}
					});
				}
			}
		});
		
	}
	function cal(){
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
		var customerid = $("#customerid").val();
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
					$('#myForm').submit();
				}
			}
		});
	}
</script>
@stop