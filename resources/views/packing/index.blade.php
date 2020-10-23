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
		.classpacking{
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
							
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<fieldset>
											<legend class="text-semibold"><i class="icon-stack2"></i> รายงานการขาย</legend>
											<div class="row">
												<div class="col-md-2">
													<div class="form-group">
														<label>เลขที่บิล :</label>
														<input type="text" placeholder="เลขที่บิล" class="form-control" name="billno" id="billno" autocomplete="off" onkeypress="putcode(event)" value="{{$inv}}">
														<input type="hidden" name="billid" id="billid">
													</div>
												</div>
												
												<div class="col-md-2">
													<div class="form-group">
														<label>กล่องที่ :</label>
														<input type="text" placeholder="กล่องที่" class="form-control" name="boxno" id="boxno" value="1">
														{{-- <input type="hidden" name="boxtax" id="boxtax" value="{{ $invoice }}"> --}}
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label>&nbsp;</label>
														<input type="text" class="form-control" name="boxtax" id="boxtax" value="{{ $invoice }}">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label>ประเภทหน่วยสินค้า</label>
														<select name="" class="form-control" id="typeunit" name="typeunit">
															<option value="1">กล่อง</option>
															<option value="2">ห่อ</option>
															<option value="3">มัด</option>
															<option value="4">กส.</option>
														</select>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label>&nbsp;</label><br>
														<button type="button" id="changebox" class="btn btn-warning" disabled=""><i class="icon-box position-left"></i>  เปลี่ยนกล่อง</button>
														<button type="button" id="searchdata" class="btn btn-success"><i class="icon-folder-search position-left"></i>  ค้นหา</button>
														{{-- id="searchdata" --}}
													</div>
												</div>
											</div>
										</fieldset>
									</div>
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
										<h5 class="panel-title">ข้อมูลบิล</h5>
									</div>

									<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
												<table>
													<tbody id="showdetail">
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<!-- /basic layout -->
							</div>
							<div class="col-md-12">
								<!-- Basic layout-->
								<div class="panel panel-flat">
									<div class="panel-heading">
										<h5 class="panel-title">รายละเอียดสินค้า</h5>
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
												<div class="table-responsive">
													<table id="myTable" class="table table-bordered">
														<thead>
															<tr>
																<th class="text-center">#</th>
																<th class="text-center">ลำดับ</th>
																<th class="text-center">รหัสสินค้า</th>
																<th class="text-center">ชื่อสินค้า</th>
																<th class="text-center">จำนวนที่สั่ง</th>
																<th class="text-center">หน่วย</th>
																<th class="text-center">จำนวนที่นับได้</th>
																<th class="text-center">จำนวนลงกล่อง</th>
																<th class="text-center">คงเหลือ</th>
																<th class="text-center">สถานะ</th>
															</tr>
														</thead>
														<tbody id="rowdata">
															<tr id="firstauto">
																<td colspan="9" align="center">-- No data --</td>
															</tr>
														</tbody>
														
													</table>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<div id="" style="margin-right: 1%;" class="pull-right">
											<button type="button" class="btn btn-success" onclick="packinbox();">ใส่กล่อง</button>
										</div>
										<div id="rowfoot" style="display: none;margin-right: 1%;" class="pull-right">
											<button type="button" class="btn btn-primary" onclick="scanbarcode();">Scan</button>
										</div>
										<div id="print" style="display: none;margin-right: 1%;" class="pull-right">
											<button type="button" class="btn btn-primary" onclick="print();">พิมพ์</button>
										</div>
									</div>
								</div>
								<!-- /basic layout -->
							</div>
						</div>
						<!-- /vertical form options -->
						
					</div>
				</div>
			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>

	<!-- /page container -->
<div class="modal inmodal" data-backdrop="static" id="scanbarcode" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" style="width:70%">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-center">สแกนบาร์โค้ด</h4>
            </div>
            <div class="modal-body">
                <div class="row">
					<div class="col-md-12 col-md-12">
						<div class="form-group">
							<input type="text" class="form-control" name="productbarcode" id="productbarcode" placeholder="รหัสบาร์โค้ด" required>
							{{-- <input type="hidden" name="productid" id="productid"> --}}
						</div>
					</div>
				</div>
            </div>
            <div class="modal-footer" style="margin-top:3%">
                <button type="button" class="btn btn-white" data-dismiss="modal" >ปิด</button>
            </div>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){
		// $('#rowdata').append('<tr id="firstauto"><td colspan="9" align="center">-- No data --</td></tr>');

		$("#billno").focus();
		document.addEventListener("keydown", onKeyDown, false);
		var txt = '';
	    function onKeyDown(e) {
	        var x = e.keyCode;
	        if(x==13){
	        	$("#billno").val();
	        }
	    }

	    $("#productbarcode").keypress(function(e) {
	    	var x = e.keyCode;
	        if(x==13){
	        	$.ajax({
					url: "{{url('/packing/scanbarcode')}}",
					type: 'post',
					dataType: 'json',
					data: {
						'billno': $('#billno').val(),
						'billid': $('#billid').val(),
						'barcode': $('#productbarcode').val(),
						'typeunit': $('#typeunit').val(),
						'boxno': $('#boxno').val(),
						'boxtax': $('#boxtax').val(),
						'_token': "{{ csrf_token() }}"
					},
					success: function (data){
						if(data.returnsearchbarcode.status == 'Y'){
							$('#productbarcode').val('');
							var count 	= data.order.length;
							if(data.export.selling_status == '4'){
								Lobibox.notify('success',{
									msg: 'ทำการจัดการสินค้าครบแล้ว',
									buttonsAlign: 'center',
									closeOnEsc: true,  
								});
								$("#status").html("<h6>จัดของเรียบร้อยแล้ว</h6>");
								// $('#scanbarcode').modal('hide');
								$("#rowfoot").hide();
								$("#print").show();
							}
							if(data.statusproduct.status == "Y"){
								Lobibox.notify('warning',{
									msg: 'สินค้า '+data.statusproduct.name+' นี้ทำการสแกนครบตามจำนวนแล้ว กรุณาตรวจสอบ',
									buttonsAlign: 'center',
									closeOnEsc: true,  
								});
							}
							
							
							if(count > 0){
								$('#firstauto').closest( 'tr').remove();
								$('.rowbody').closest( 'tr').remove();
								$('.rowfoot').closest( 'tr').remove();
								
								var num = 1;
								var text = '';
								$.each(data.order,function(key,item){
									var balance = parseInt(item.sellingdetail_qty) - parseInt(item.sellingdetail_count);
									var status = '';
									var notclick = '';
									if(item.sellingdetail_status == '2'){
										status = 'ครบแล้ว';
										notclick = 'disabled';
									}else {
										status = 'ยังไม่ครบ';
									}
									text += '<tr class="rowbody'+item.sellingdetail_id+'">'
									+'<td align="center"><input type="checkbox" name="checkboxorder[]" value="'+item.sellingdetail_id+'" id="checkboxorder'+item.sellingdetail_id+'" '+notclick+'></td>'
									+'<td align="center">'+num+'</td>'
									+'<td align="center">'+item.product_code+'</td>'
									+'<td align="center">'+item.product_name+'</td>'
									+'<td align="center">'+item.sellingdetail_qty+'</td>'
									+'<td align="center">'+item.unitname+'</td>'
									+'<td align="center">'+item.sellingdetail_count+'</td>'
									+'<td align="center"><input type="number" disabled class="form-control" value="0" style="width: 100px;" id="countinbox'+item.sellingdetail_id+'" name="countinbox[]" max="'+balance+'" min="0"></td>'
									+'<td align="center">'+balance+'</td>'
									+'<td align="center">'+status+'</td>'
									+'</tr>';
									
									num++;
								});
								$('#rowdata').empty().append(text);
								$("input[name='checkboxorder[]']").click(function(event) {
									var id = $(this).val();
									if($(this).is(':checked')){
										$("#countinbox"+id).prop('disabled',false);
									}else{
										$("#countinbox"+id).prop('disabled',true);
									}
									
								});
							}
						}else{
							$('#productbarcode').val('').focus();
							Lobibox.notify('error',{
								msg: 'บาร์โค้ดสินค้าไม่ตรงกับรายการสินค้าในใบเปิดบิลเลขนี้!',
								buttonsAlign: 'center',
								closeOnEsc: true,  
							});
							// $("#rowfoot").hide();
						}
					}
				});
	        }
	    });
	});
	
	$("#changebox").click(function(event) {
		if($("input[name='checkboxorder[]']:checked").length == 0){
			Lobibox.notify('error',{
				msg: 'กรุณาเลือกรายการออเดอร์ก่อนกดปุ่ม!',
				buttonsAlign: 'center',
				closeOnEsc: true,  
			});
			return false;
		}
		$.ajax({
			url: "{{url('/packing/changebox')}}",
			type: 'post',
			dataType: 'json',
			data: {
				'billno': $('#billno').val(),
				'boxno': $('#boxno').val(),
				'_token': "{{ csrf_token() }}"
			},
			success:function(data){
				$("#boxno").val(data.box);
				$("#boxtax").val(data.invoice);
			}
		});
	});
	$('#searchdata').click(function(){
		$.ajax({
			url: "{{url('/packing/dataproduct')}}",
			type: 'post',
			dataType: 'json',
			data: {
				'billno': $('#billno').val(),
				'_token': "{{ csrf_token() }}"
			},
			success: function (data){
				console.log(data)
				// console.log(data.selling.length);
				var sumtotal 	= 0;
				var count 	= data.order.length;
				var showdetail = '';
				if(data.selling.length == 0){
					$("#billid").val('');
					$("#showdetail").empty().append(showdetail);
					Lobibox.notify('error',{
						msg: 'ไม่มีข้อมูลตามเลขบิลที่ค้นหา!',
						buttonsAlign: 'center',
						closeOnEsc: true,  
					});
					$("#rowfoot").hide();
					$("#print").show();
				}else{
					$("#changebox").prop('disabled',false);
					showdetail += '<tr>';
					showdetail += '<td width="10%"><h6>เลขที่บิล : </h6></td>';
					showdetail += '<td width="20%"><h6>'+data.selling.selling_inv+'</h6></td>';
					showdetail += '<td width="10%"></td>';
					showdetail += '<td width="10%"><h6>วันที่ : </h6></td>';
					showdetail += '<td width="20%"><h6>'+data.selling.selling_date+'</h6></td>';
					showdetail += '</tr>';

					showdetail += '<tr>';
					showdetail += '<td width="10%"><h6>ชื่อพนักงาน : </h6></td>';
					showdetail += '<td width="20%"><h6>'+data.selling.selling_empname+'</h6></td>';
					showdetail += '<td width="10%"></td>';
					showdetail += '<td width="10%"><h6>ชื่อลูกค้า : </h6></td>';
					showdetail += '<td width="20%"><h6>'+data.selling.selling_customername+'</h6></td>';
					showdetail += '</tr>';

					showdetail += '<tr>';
					showdetail += '<td width="10%"><h6>สถานะ : </h6></td>';
					if(data.selling.selling_status == '4'){
						showdetail += '<td width="20%" id="status"><h6>แพ็คของเรียบร้อยแล้ว</h6></td>';
						$("#rowfoot").hide();
						$("#print").show();
						$("#changebox").prop('disabled',true);
					}else if(data.selling.selling_status == '5'){
						showdetail += '<td width="20%" id="status"><h6>จัดการขนส่งแล้ว</h6></td>';
						$("#rowfoot").hide();
						$("#print").show();
						$("#changebox").prop('disabled',true);
					}else{
						showdetail += '<td width="20%" id="status"><h6>ยังไม่ได้แพ็คของ</h6></td>';
						$("#rowfoot").show();
						$("#print").hide();
						$("#changebox").prop('disabled',false);
					}
					
					showdetail += '</tr>';
					$("#billid").val(data.selling.selling_id);
				}
				$("#showdetail").empty().append(showdetail);
				if(count > 0){
					$('#firstauto').closest( 'tr').remove();
					$('.rowbody').closest( 'tr').remove();
					$('.rowfoot').closest( 'tr').remove();
					
					var num = 1;
					var text = '';
					$("#rowdata").empty();
					$.each(data.order,function(key,item){
						// console.log(item);
						var balance = parseInt(item.sellingdetail_qty) - parseInt(item.sellingdetail_count);
						var status = '';
						var notclick = '';
						if(item.sellingdetail_status == '2'){
							status = 'ครบแล้ว';
							notclick = 'disabled';
						}else {
							status = 'ยังไม่ครบ';
						}
						text += '<tr class="rowbody'+item.sellingdetail_id+'">'
							+'<td align="center"><input type="checkbox" name="checkboxorder[]" value="'+item.sellingdetail_id+'" id="checkboxorder'+item.sellingdetail_id+'" '+notclick+'></td>'
							+'<td align="center">'+num+'</td>'
							+'<td align="center">'+item.product_code+'</td>'
							+'<td align="center">'+item.product_name+'</td>'
							+'<td align="center">'+item.sellingdetail_qty+'</td>'
							+'<td align="center">'+item.unitname+'</td>'
							+'<td align="center">'+item.sellingdetail_count+'</td>'
							+'<td align="center"><input type="number" disabled class="form-control" value="0" style="width: 100px;" id="countinbox'+item.sellingdetail_id+'" name="countinbox[]" max="'+balance+'" min="0"></td>'
							+'<td align="center">'+balance+'</td>'
							+'<td align="center">'+status+'</td>'
						+'</tr>';
						
						num++;
					});
					$('#rowdata').append(text);
					$("input[name='checkboxorder[]']").click(function(event) {
						var id = $(this).val();
						if($(this).is(':checked')){
							$("#countinbox"+id).prop('disabled',false);
						}else{
							$("#countinbox"+id).prop('disabled',true);
						}
						
					});
				}else{
					$("#rowfoot").hide();
					// $('#firstauto').closest( 'tr').remove();
					$('#rowdata').empty().append('<tr id="firstauto"><td colspan="7" align="center">-- No data --</td></tr>');
				}
			}
		});
	});
	function putcode(e){
		var x = e.keyCode;
        if(x==13){
        	$('#searchdata').click();
        }
	}

	function scanbarcode(){
		$('#scanbarcode').modal('show');
		$("#productbarcode").focus();
	}
	function print(){
		var id = $("#billid").val();
		
		console.log()
		if(window.location.pathname.split('/').length > 3){
			window.open('invoice/'+id);
			window.open('../transport/poll/'+id);
		}else{
			window.open('packing/invoice/'+id);
			window.open('transport/poll/'+id);
		}
	}
	function packinbox(){
		var orderdata = [];
		var ordervalue = [];
		if($("input[name='checkboxorder[]']:checked").length == 0){
			Lobibox.notify('error',{
				msg: 'กรุณาเลือกรายการออเดอร์ก่อนกดปุ่ม!',
				buttonsAlign: 'center',
				closeOnEsc: true,  
			});
			return false;
		}
		// console.log($("input[name='checkboxorder[]']:checked").length)
		$("input[name='checkboxorder[]']").each(function(index, el) {
			if($(this).is(":checked")){
				var id = $(this).val();
				var stockinput = $(".rowbody"+$(this).val()+" input[name='countinbox[]']").val();
				var balance = $(".rowbody"+$(this).val()+" td:nth-child(9)").text();
				var countitem = $(".rowbody"+$(this).val()+" td:nth-child(7)").text();
				if(parseInt(stockinput) > parseInt(balance)){
					Lobibox.notify('error',{
						msg: 'กรุณาเลือกตรวจสอบจำนวนที่ต้องการใส่ลงกล่อง!',
						buttonsAlign: 'center',
						closeOnEsc: true,  
					});
					return false;
				}
				
				if(parseInt(stockinput) == parseInt(balance)){
					$(".rowbody"+$(this).val()+" td:nth-child(10)").text('ครบแล้ว');
					$(this).prop('checked',false).prop('disabled',true);
					$("#countinbox"+id).val('0').prop('disabled',true);
				}else{
					$(".rowbody"+$(this).val()+" td:nth-child(10)").text('ยังไม่ครบ');
				}
				countitem = parseInt(countitem)+parseInt(stockinput);
				balance = parseInt(balance)-parseInt(stockinput);

				$(".rowbody"+$(this).val()+" td:nth-child(9)").text(balance);
				$(".rowbody"+$(this).val()+" td:nth-child(7)").text(countitem);
				$(".rowbody"+$(this).val()+" td:nth-child(8) input[name='countinbox[]']").attr('max',balance).val('0');
				
				orderdata.push($(this).val());
				ordervalue.push(stockinput);
			}
		});
		console.log(orderdata);
		console.log(ordervalue);
		// return false;
		
		if(orderdata.length > 0){
			var typeunit = $("#typeunit").val();
			var boxtax = $("#boxtax").val();
			var boxno = $("#boxno").val();
			var billid = $("#billid").val();
			var billno = $("#billno").val();
			$.post("{{url('packing/putinbox')}}", {_token: "{{ csrf_token() }}",orderdata: orderdata,ordervalue: ordervalue,typeunit:typeunit,boxtax:boxtax,boxno:boxno,billid:billid,billno:billno}, function(data, textStatus, xhr) {
				if(data == '4'){
					Lobibox.notify('success',{
						msg: 'ทำการจัดการสินค้าครบแล้ว',
						buttonsAlign: 'center',
						closeOnEsc: true,  
					});
					$("#status").html("<h6>จัดของเรียบร้อยแล้ว</h6>");
					// $('#scanbarcode').modal('hide');
					$("#changebox").prop('disabled',true);
					$("#rowfoot").hide();
					$("#print").show();
				}
			});
		}
	}
</script>
@if ($inv != '')
<script>
	$("#searchdata").click();
	
</script>
@endif
@stop