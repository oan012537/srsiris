@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- <div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Import Goods
				</h4>
			</div>
		</div>
	</div>-->
	<!-- /page header -->
	<style type="text/css">
		.classimports{
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
							
							<form id="myForm" method="post" action="{{url('imports_create')}}" onsubmit="return checkaddproduct();">
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
														<input type="text" class="form-control" name="impno" id="impno" placeholder="เลขที่นำเข้าสินค้า" value="<?php echo $orderno;?>" readonly>
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
											<legend class="text-semibold"><i class="icon-info22"></i> รายละเอียด ผู้ผลิต</legend>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>ชื่อซัพพลายเออร์ :</label>
														<input type="text" class="form-control" name="suppliername" id="suppliername" placeholder="ชื่อผู้ผลิต" autocomplete="off" value="" required="">
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<label>เลขประจำตัวผู้เสียภาษีอากร :</label>
														<input type="text" class="form-control" name="supplier_tax" id="supplier_tax" placeholder="เลขประจำตัวผู้เสียภาษีอากร" autocomplete="off">
													</div>
													<input type="hidden" name="supplier_id" id="supplier_id" value="">
												</div>
											</div>

											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label>ที่อยู่ :</label>
														<textarea name="supplier_address" id="supplier_address" rows="2" class="form-control" placeholder="ที่อยู่"></textarea>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>เบอร์โทรศัพท์ :</label>
														<input type="text" class="form-control number" name="supplier_tel" id="supplier_tel" placeholder="เบอร์โทรศัพท์">
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
																<div class="col-md-2">
																	<div class="form-group has-feedback has-feedback-left">
																		<input type="text" id="searchbarcode" class="form-control input-xlg" placeholder="รหัสสินค้า / Barcode">
																		<div class="form-control-feedback">
																			<i class="icon-barcode2"></i>
																		</div>
																	</div>
																</div>

																<div class="col-md-2">
																	<div class="form-group has-feedback has-feedback-left">
																		<input type="text" id="searchproduct" class="form-control input-xlg" placeholder="ชื่อสินค้า / Product">
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
																{{-- <th class="text-center">ขนาด</th> --}}
																<th class="text-center" style="width:150px;">จำนวน</th>
																<th class="text-center" style="width:190px;">หน่วยนับ</th>
                                                                <th class="text-center" style="width:150px;">ราคาทุน/ชิ้น</th>
																{{-- <th class="text-center" style="width:150px;">ราคาขาย/ชิ้น</th> --}}
																<th class="text-center" style="width:150px;">#</th>
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
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="text-right">
												<a href="{{url('imports')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
												<button type="submit"   form="myForm" class="btn btn-primary"><i class="icon-floppy-disk"></i>  บันทึก</button>
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
		var switches = Array.prototype.slice.call(document.querySelectorAll('.switch'));
		switches.forEach(function(html) {
			var switchery = new Switchery(html, {color: '#4CAF50'});
		});
	});
	$(document).on('click','.switchery',function(){
		var check = $(this).parent().find('input').val();
		if(check == 'on'){
			$("#impno").prop('readonly', false);
			$(this).parent().find('input').val("off");
		}else{
			$("#impno").prop('readonly', true);
			$(this).parent().find('input').val("on");
		}
	});
	
	$('#suppliername').keyup(function(){
		$(this).autocomplete({
			source: "{{url('searchsuppliername/autocomplete')}}",
			minLength: 1,
			select: function(event, ui){
				$('#supplier_id').val(ui.item.id);
				$('#supplier_tax').val(ui.item.tax);
				$('#supplier_address').val(ui.item.addr);
				$('#supplier_tel').val(ui.item.tel);
			}
		})
		.autocomplete("instance")._renderItem = function(ul, item) {
			return $("<li>").append("<span class='text-semibold'>" + item.label + '</span>' + "<br>" + '<span class="text-muted text-size-small">' + item.attr + '</span>').appendTo(ul);
		};
	});
	
	$('#supplier_tax').keyup(function(){
		$(this).autocomplete({
			source: "{{url('searchsuppliertax/autocomplete')}}",
			minLength: 1,
			select: function(event, ui){
				$('#supplier_id').val(ui.item.idcus);
				$('#supplier_tax').val(ui.item.tax);
				$('#supplier_address').val(ui.item.addr);
				$('#supplier_tel').val(ui.item.tel);
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
			'url': "{{url('enteimportsrbarcode')}}",
			'data': {
				'barcode': $('#searchbarcode').val(),
				'_token': "{{ csrf_token() }}"
			},
				'success': function(data){
					//$('.rowproduct').closest( 'tr').remove();
					$.each(data.results,function(key,item){
						var find = 0;
                        $('#rowdata tr').each(function(){
                            if($(this).is('#row'+find+item.pro_id) == true){
                                find++;
                            }                 
                        });
                        // if(find == 0){
                            $('#rowdata').append('<tr class="rowproduct" id="row'+find+item.pro_id+'"><td align="center">'+item.pro_code+'</td>'
                                +'<td>'+item.pro_name+'</td>'
                                // +'<td>'+item.size+'</td>'
                                +'<td align="right">'+item.amount+'</td>'
                                +'<td align="center">'+item.unit+'</td>'
                                +'<td align="right">'+item.capital+'</td>'
                                // +'<td align="center">'+item.sale+'</td>'
                                +'<td  align="center"><button type="button" class="btn btn-danger btn-xs" onclick="delrow(\''+find+item.pro_id+'\')"><i class="icon-cancel-square"></i></button></td>'
                            +'</tr>');
                        // }
                        // else{
                        //     var amount = $('#row'+item.pro_id+' td:nth-child(6) input[name="amount[]"]').val();
                        //     var numamount = 0;
                        //     if(amount != ''){
                        //        numamount = parseInt(amount);
                        //     }
                        //     var newamount = numamount + 1;
                        //     $('#row'+item.pro_id+' td:nth-child(6) input[name="amount[]"]').val(newamount);
                        // }
					});
					
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
			'url': "{{url('enterimportsproduct')}}",
			'data': {
				'id': ui.item.id,
				'_token': "{{ csrf_token() }}"
			},
				'success': function (data) {
					//$('.rowproduct').closest( 'tr').remove();
                    
					$.each(data.results,function(key,item){
                        var find = 0;
                        $('#rowdata tr').each(function(){
                            if($(this).is('#row'+find+item.pro_id) == true){
                                find++;
                            }                 
                        });
                        // if(find == 0){
                            $('#rowdata').append('<tr class="rowproduct" id="row'+find+item.pro_id+'"><td align="center">'+item.pro_code+'</td>'
                                +'<td>'+item.pro_name+'</td>'
                                // +'<td>'+item.size+'</td>'
                                +'<td align="right">'+item.amount+'</td>'
                                +'<td align="center">'+item.unit+'</td>'
                                +'<td align="right">'+item.capital+'</td>'
                                // +'<td align="center">'+item.sale+'</td>'
                                +'<td  align="center"><button type="button" class="btn btn-danger btn-xs" onclick="delrow(\''+find+item.pro_id+'\')"><i class="icon-cancel-square"></i></button></td>'
                            +'</tr>');
                        // }
                        // else{
                        //     var amount = $('#row'+item.pro_id+' td:nth-child(6) input[name="amount[]"]').val();
                        //     var numamount = 0;
                        //     if(amount != ''){
                        //        numamount = parseInt(amount);
                        //     }
                        //     var newamount = numamount + 1;
                        //     $('#row'+item.pro_id+' td:nth-child(6) input[name="amount[]"]').val(newamount);
                        // }
					});
					$('#searchproduct').val('');
					$('#searchproduct').trigger("focus");
				}
			});
		}
	})
	.autocomplete("instance")._renderItem = function(ul, item) {
		return $("<li>").append("<span class='text-semibold'>" + item.label + '</span>' + "<br>" + '<span class="text-muted text-size-small">' + item.attrs + '</span>').appendTo(ul);
	};
	
	
	$('#submitform').click(function(){
		$('#myForm').submit();
	});
    
    function delrow(id){
        $('#row'+id).remove();
        cal();
    }
    function capitalpush (id){
    	$.ajax({
			url : "{{url('imports_checkprice')}}/"+id,
			// datatype:'json',
			success:function(data){
				console.log(data);
				if(data != 'X'){
					var capital = $("#capital"+id).val();
					if(data.product_capital != capital){
						$("#row"+id+' td:eq(0)').addClass('bg-danger');
						$("#row"+id+' td:eq(1)').addClass('bg-danger');
						$("#row"+id+' td:eq(2)').addClass('bg-danger');
						$("#row"+id+' td:eq(3)').addClass('bg-danger');
						$("#row"+id+' td:eq(4)').addClass('bg-danger');
						$("#row"+id+' td:eq(5)').addClass('bg-danger');
					}else{
						$("#row"+id+' td:eq(0)').removeClass('bg-danger');
						$("#row"+id+' td:eq(1)').removeClass('bg-danger');
						$("#row"+id+' td:eq(2)').removeClass('bg-danger');
						$("#row"+id+' td:eq(3)').removeClass('bg-danger');
						$("#row"+id+' td:eq(4)').removeClass('bg-danger');
						$("#row"+id+' td:eq(5)').removeClass('bg-danger');
					}
				}
			}
		});

    }

    function checkaddproduct(){
    	var len = $("#rowdata tr").length;
    	if(len == 0){
    		Lobibox.notify('warning',{
				msg: 'กรุณาเพิ่มข้อมูลสินค้าที่ต้องการนำเข้าก่อน อย่างน้อย1รายการ!',
				buttonsAlign: 'center',
				closeOnEsc: true, 
			});
    		return false;
    	}else {
    		return true;
    	}
    }
    function cal(){
    	// <!-- คำนวณ ยอด -->
		// $('#sumtotalsp').val(formatNumber(sumrowall.toFixed(2)));
		var totals = 0;
		$("#rowdata tr").each(function(key){
			var amount = $("#"+$(this)[0].id+" input[name='amount[]']").val()||0;
			var capital = $("#"+$(this)[0].id+" input[name='capital[]']").val()||0;
			// console.log($($(this)[0].id).text())
			console.log(key+" >>> "+amount +' || '+capital)
			totals += parseFloat(amount)*parseFloat(capital);
			console.log(totals)
		});
		$("#sumtotalsp").val(formatNumber(totals.toFixed(2)));
    }
    function formatNumber (x) {
		return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
</script>
@stop