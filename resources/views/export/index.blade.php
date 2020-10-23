@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- <div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Selling / Export
				</h4>
			</div>

		</div>
	</div>-->
	<!-- /page header -->
	<style type="text/css">
		.classexport{
			background: rgb(199,199,199,0.3);
		}
		#keyword {
			margin-left: 20px;
		}
		#searchname {
			/*margin-left: 20px;*/
		}
		.importsuccess{
			/*background: green;*/
			padding: 2px 5px;
		    border: 1px solid;
		    font-size: 0.5rem;
		    border-radius: 7px;
		    vertical-align:middle;
		    border-style: none;
		    /*color: #ffffff;*/
		    display: inline-block;
		    position: relative;
		    background-color: #58D68D ;

		}
		@media only screen and (max-width: 600px) {
			#keyword {
				margin-left: 0px;
			}

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
							
							<div class="panel-body">
								{{-- <div class="col-md-2">
									<div class="form-group">
										<input type="text" name="keyword" id="keyword" class="form-control" placeholder="ค้นหาชื่อสินค้า">
									</div>
								</div> --}}
								@if(Auth::user()->actionadd != '')
								<div class="pull-right">
									<a href="{{url('export/create')}}"<button type="button" class="btn btn-success btn-lg"><i class="icon-plus-circle2"></i> เพิ่ม</button></a>
								</div>
								@endif
							</div>
							
							<table class="table" id="datatables">
								<thead>
									<tr>
										<th class="text-center" width="10%">ลำดับ</th>
										<th class="text-center" width="15%">เลขที่ออเดอร์</th>
										<th class="text-center" width="10%">วันที่</th>
										<th class="text-center" width="25%">ลูกค้า</th>
										<th class="text-center" width="10%">สถานะ</th>
										<th class="text-center" width="15%">รวม</th>
										<th class="text-center" width="10%">#</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
							
						</div>
						<!-- /vertical form -->
					</div>
				</div>
			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<div class="modal inmodal" id="calculator" tabindex="-1" role="dialog"  aria-hidden="true">
	    <div class="modal-dialog" style="width:70%">
	        <div class="modal-content animated fadeIn">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title text-center">คำนวณ</h4>
	            </div>
	            <div class="modal-body">
	                <div class="row">
						<div class="col-md-10 col-md-10 col-md-offset-1">
							<fieldset>
								<legend class="text-semibold">รายละเอียดสินค้า</legend>
								<form method="post" action="{{url('calmoney')}}" enctype="multipart/form-data" id="formgenbarcode" target="_blank">
								{{ csrf_field() }}
									<div class="form-group">
										<label>ราคาทั้งหมด :</label>
										<input type="text" class="form-control" name="sumtotal" id="sumtotal"  required readonly>
										<input type="hidden" name="orderid" id="orderid">
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="col-md-6">
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
											
											<div class="col-md-6">
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
									<div class="form-group">
										<div class="col-md-12">
											<div class="col-md-6">
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
											
											<div class="col-md-6">
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
									<div class="form-group">
										<div class="col-md-12">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label col-md-4">การชำระเงิน</label>
													<div class="col-md-8">
														@php 
															// $payment = array('เงินสด','เครดิต','เครดิต 15 วัน','เครดิต 30 วัน');
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
											
											<div class="col-md-6">
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
									<div class="form-group">
										<div class="col-md-12">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label col-md-4">ส่วนลดท้ายบิล</label>
													<div class="col-md-8">
														<input type="text" class="form-control number" name="discountlastbill" id="discountlastbill">
													</div>
												</div>
											</div>
											
											<div class="col-md-6">
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
								</form>
							</fieldset>
						</div>
					</div>
	            </div>
	            <div class="modal-footer" style="margin-top:3%">
	                <button type="submit" form="formgenbarcode" class="btn btn-primary"  >พิมพ์</button>
	                <button type="button" class="btn btn-white" data-dismiss="modal" >ปิด</button>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- /page container -->
<script>
	function formatNumber (x) {
		return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	$(document).ready(function(){
		var oTable = $('#datatables').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: false,
			// dom: '<"toolbar">frtip',
			ajax:{ 
				url : "{{url('exportdatatables')}}",
				data: function (d) {
					d.keyword = $('#keyword').val();
				},
			},
			columns: [
				{ 'className': "text-center", data: 'export_id', name: 'export_id' },
				{ 'className': "text-center", data: 'export_inv', name: 'export_inv' },
				{ 'className': "text-center", data: 'export_date', name: 'export_date' },
				{ 'className': "text-center", data: 'export_customername', name: 'export_customername' },
				{ 'className': "text-center", data: 'export_status', name: 'export_status' },
				{ 'className': "text-center", data: 'export_totalpayment', name: 'export_totalpayment' },
				{ 'className': "text-center", data: 'updated_at', name: 'updated_at' },
			],
			order: [[1, 'desc']],
			rowCallback: function(row,data,index ){
				// if(){
					// $(row).css('background', 'rgb(90 224 57)');
				// }
				if(data['export_status'] != 7){
					if(data['alertorder']){
						// $(row).css('background', 'rgb(90 224 57)');
						$('td:eq(3)', row).append('&nbsp;&nbsp;&nbsp;<span class="importsuccess">มีสินค้า</span>');
					}
				}
				console.log(data['alertorder']);
				var status = '<span class="label bg-danger">ยังไม่ได้ทำการแพ็กของ</span>';
				// if(data['product_status'] > 0){ //อันเก่า
				if(data['export_status'] == 1){
					var status = '<span class="label bg-success-400">เรียบร้อย</span>';
				}else if(data['export_status'] == 2){
					var status = '<span class="label bg-primary-400">บิลชั่วคราว</span>';
				}else if(data['export_status'] == 3){
					var status = '<span class="label bg-danger-400">ยกเลิก</span>';
				}else if(data['export_status'] == 4){
					var status = '<span class="label bg-success-400">แพ็คของแล้ว</span>';
				}else if(data['export_status'] == 5){
					var status = '<span class="label bg-success-400">จัดขนส่ง</span>';
				}else if(data['export_status'] == 6){
					var status = '<span class="label bg-warning-400">แพ็คของยังไม่ครบ</span>';
				}else if(data['export_status'] == 7){
					var status = '<span class="label bg-warning-400">ยังมีสินค้าคงเหลือ</span>';
				}else if(data['export_status'] == 0){
					var status = '<span class="label bg-primary-400">ยังไม่มีการทำรายการ</span>';
				}
				$('td:eq(1)', row).html('<a href="{{url('export/view')}}/'+data['export_id']+'">'+data['export_inv']+'</a>');
				$('td:eq(4)', row).html(status);
				// <i class="icon-magazine" data-popup="tooltip" title="บิล" onclick="openbill('+data['export_id']+');"></i>   พิมพ์บิล
				var btndel = '';
                var permissiondel = "{{Auth::user()->actiondelete}}";
                var permissionedit = "{{Auth::user()->actionedit}}";
                if( permissiondel != ''){
                	btndel = ' <i class="icon-cancel-square" onclick="cancel('+data['export_id']+');" data-popup="tooltip" title="ยกเลิก"></i>';
                }
                var btnedit = '';
                if(permissionedit !=''){
                	btnedit = ' <a href="{{url("export-update")}}/'+data['export_id']+'"><i class="icon-pencil7" data-popup="tooltip" title="แก้ไข"></i></a>';
                }

				$('td:eq(6)', row).html( '<i class="icon-mailbox" data-popup="tooltip" title="ส่งเมล" onclick="mail('+data['export_id']+');"></i> <i class="icon-cart2" data-popup="tooltip" title="ส่งข้อมูลไปการขาย" onclick="calmoney('+data['export_id']+');"></i>'+btnedit +btndel );
			}
		});
		
		oTable.on( 'order.dt search.dt', function(){
			oTable.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell, i){
				cell.innerHTML = i+1;
			} );
		}).draw();
		// $('#keyword').keyup(function(e){
		// 	if(e.keyCode == '13'){
		// 		alert();
		// 		oTable.draw();
		// 		e.preventDefault();
		// 	}
		// });
		// $("div.dataTables_filter span").remove();
		$("div.dataTables_filter").append('<input type="text" name="keyword" id="keyword" placeholder="ค้นหาชื่อสินค้า"> <button type="button" id="searchname" class="btn btn-primary"><i class="icon-folder-search"></i> ค้นหา</button>');
		$("#keyword").keyup(function (e) {
			if(e.keyCode == '13'){
				oTable.draw();
				e.preventDefault();
			}
		 });
		$("#searchname").click(function (e) {
			oTable.draw();
			e.preventDefault();
		});
	});
	
	function del(id){
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
					window.location.href="export-delete/"+id+"";
				}
			}
		});
	}
	function cancel(id){
		bootbox.confirm({
			title: "ยืนยัน?",
			message: "คุณต้องการยกเลิกรายการนี้ หรือไม่?",
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
					window.location.href="export-cancel/"+id+"";
				}
			}
		});
	}
	function openbill(id){
		window.open("export-bill/"+id);
	}
	function mail(id){
		// window.open("export-mail/"+id);
		run_waitMe($('body'), 3, 'roundBounce');
		$.ajax({
			url : "{{url('export-mail')}}/"+id,
			// datatype:'json',
			success:function(data){
				// console.log(data)
				$('body').waitMe('hide');
				if(data == 'y'){
					Lobibox.notify('success',{
						msg: 'Success send email',
						buttonsAlign: 'center',
						closeOnEsc: true,  
					});
				}else{
					Lobibox.notify('error',{
						msg: 'Error send email',
						buttonsAlign: 'center',
						closeOnEsc: true,  
					});
				}
			}
		});
	}
	function calmoney(orderid){
		// checkproduct.blade.php
		window.location.href="export/checkdatapay/"+orderid+"";
		// $.post('{{url('getdataorder')}}', {'orderid': orderid,'_token': "{{ csrf_token() }}",}, function(data, textStatus, xhr) {
		// 	$("#sumtotal").val(data.export_totalall);
		// 	$("#orderid").val(orderid);
		// 	var sumrowall = data.export_totalall||0;
		// 	$('#sumtotalsp').val(formatNumber(sumrowall.toFixed(2)));
		// 	$('#sumtotal').val(sumrowall.toFixed(2));
		// 	fncalmoney();
		// 	$('#calculator').modal('show');
		// });
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
	function changepay(value){
		if(value == 'โอน'){
			$("#noauccount").css('display','block');
		}else{
			$("#noauccount").css('display','none')
		}
	}
</script>
@stop