@extends('../template')

@section('content')
<style type="text/css">
	i.disabled {
		pointer-events: none;
		cursor: default;
	}
</style>
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
		.classtransport{
			background: rgb(199,199,199,0.3);
		}
	</style>

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">
		
			<!-- Main content -->
			<div class="content-wrapper">
			<form id="myForm" method="post" action="{{url('transt_create')}}" onsubmit="return submitfn();">
				{{ csrf_field() }}
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
									<div class="col-md-6">
										<fieldset>
											<legend class="text-semibold"><i class="icon-stack2"></i> ข้อมูลหลัก</legend>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>เลขที่ออเดอร์ :</label>
														<?php 
															if(!empty($invoice)){
																$str = $invoice->trans_invoice;
																$sub = substr($str,8,3)+1;
																$cut = substr($str,0,8);
																$inv = $cut.sprintf("%03d",$sub);
															}else{
																$dateY = date('Y');
																$dateM = date('m');
																$dateD = date('d');
																$cutdate = substr($dateY,2,2);
																$strdate = 'TR'.$cutdate.$dateM.$dateD.sprintf("%03d",1);
																$inv = $strdate;
															}
														?>
														<input type="text" class="form-control" name="invoice" id="invoice" placeholder="เลขที่ใบออเดอร์" value="<?php echo $inv;?>" readonly>
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
														<label>วันที่ส่งของ :</label>
														<div class="input-group">
															<input type="text" name="delivery" id="delivery" placeholder="วันที่ส่งของ" class="form-control datepicker-dates" onkeydown="return false;" autocomplete="off" value="<?php echo date('d/m/Y');?>">
														</div>
													</div>
												</div>
											</div>
										</fieldset>
									</div>
									<div class="col-md-6">
										<fieldset>
											<legend class="text-semibold"><i class="icon-stack2"></i> ข้อมูลขนส่ง</legend>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>พนักงานขับรถ :</label>
														<div class="input-group">
															<input type="text" name="transportemp" id="transportemp" class="form-control" value="" >
														</div>
													</div>
												</div>
												
												<div class="col-md-6">
													<div class="form-group">
														<label>รถยนต์ :</label>
														<div class="input-group">
															<input type="text" name="truckname" id="truckname" class="form-control" value="" >
														</div>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>ป้ายทะเบียนรถ :</label>
														<div class="input-group">
															<input type="text" name="truckid" id="truckid" class="form-control" value="" >
														</div>
													</div>
												</div>
												
												<div class="col-md-6">
													<div class="form-group">
														<label>พนักงาน :</label>
														<div class="input-group">
															<input type="text" name="empsalename" id="empsalename" class="form-control" onkeydown="return false;" autocomplete="off" value="<?php echo Auth::user()->name;?>" readonly>
															<input type="hidden" name="empsaleid" id="empsaleid" class="form-control" onkeydown="return false;" autocomplete="off" value="<?php echo Auth::user()->id;?>" readonly>
														</div>
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
														<div class="col-md-11">
															<div class="row">
																{{-- <div class="col-md-2">
																	<button type="button" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#myModal"><i class=" icon-plus-circle2 position-left"></i> เพิ่มออเดอร์จัดส่ง</button>
																</div> --}}
																<div class="col-md-5">
																	<input type="text" class="form-control" id="scanpoll" name="scanpoll">
																</div>
																<div class="col-md-1">
																	{{-- <button class="btn btn-primary" id="searchpoll">ค้นหา</button> --}}
																</div>
															</div>
														</div>
													</div>
													<br><br>
													<div class="table-responsive">
														<table id="myTable" class="table table-framed">
															<thead>
																<tr>
																	<th class="text-center">ออเดอร์</th>
																	<th class="text-center">วันที่</th>
																	<th class="text-center">ลูกค้า</th>
																	{{-- <th class="text-center">จำนวน</th> --}}
																	<th class="text-center">#</th>
																</tr>
															</thead>
															<tbody id="rowdata"></tbody>
														</table>
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
						{{-- <th class="text-center">จำนวน</th> --}}
						<th class="text-center">#</th>
					</tr>
				</thead>
				<tbody></tbody>
			  </table>
			  <input type="hidden" name="saveid" id="saveid">
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-primary" onclick="confirmorder()">OK</button>
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
	var arrayselectbox = [];
	var txtselectbox = '';
	$(document).ready(function(){
		var switches = Array.prototype.slice.call(document.querySelectorAll('.switch'));
		switches.forEach(function(html) {
			var switchery = new Switchery(html, {color: '#4CAF50'});
		});
		
		// var oTable = $('#datatables').DataTable({
		// 	processing: true,
		// 	serverSide: true,
		// 	searching: true,
		// 	lengthChange: false,
		// 	pageLength:500,
		// 	ajax:{ 
		// 		url : "{{url('orderres')}}",
		// 	},
		// 	columns: [
		// 		{ 'className': "text-center", data: 'selling_id', name: 'selling_id' },
		// 		{ 'className': "text-center", data: 'selling_inv', name: 'selling_inv' },
		// 		{ 'className': "text-center", data: 'selling_date', name: 'selling_date	' },
		// 		{ 'className': "text-left", data: 'selling_customername', name: 'selling_customername' },
		// 		{ 'className': "text-center", data: 'selling_totalpayment', name: 'selling_totalpayment' },
		// 		{ 'className': "text-center", data: 'updated_at', name: 'updated_at' },
		// 	],
		// 	order: [[0, 'asc']],
		// 	rowCallback: function(row,data,index ){
		// 		$('td:eq(5)', row).remove()
		// 		// $('td:eq(5)', row).html( '<i id="chooseorder'+data['export_id']+'" class="icon-stack-check" onclick="chooseorder('+"'"+data['selling_id']+"'"+','+"'"+data['selling_inv']+"'"+',\''+data['selling_date']+'\',\''+data['selling_customername']+'\',\''+data['selling_totalpayment']+'\');" data-popup="tooltip" title="Select"></i>' );
		// 		$('td:eq(4)', row).html( '<input type="checkbox" value="'+data['selling_id']+'" name="select[]" id="chooseorder'+data['selling_id']+'" onclick="chooseorder('+"'"+data['selling_id']+"'"+','+"'"+data['selling_inv']+"'"+',\''+data['selling_date']+'\',\''+data['selling_customername']+'\',\''+data['selling_totalpayment']+'\');" data-popup="tooltip" title="Select">' );
		// 	}
		// });
		
		// oTable.on( 'order.dt search.dt', function(){
		// 	oTable.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell, i){
		// 		cell.innerHTML = i+1;
		// 	} );
		// }).draw();
		// oTable.on( 'page.dt', function () {
		// 	var info = oTable.page.info();
		// 	console.log(info);
		// 	// setInterval(function (){
		// 	// 	var explodearray = txtselectbox.split(',');
		// 	// 	console.log(explodearray);
		// 	// 	explodearray.forEach(function(index, el) {
		// 	// 		$("#chooseorder"+index).prop( "checked", true );
		// 	// 	});
		// 	// },50);
		// 	setTimeout(function(){ 
		// 		var explodearray = txtselectbox.split(',');
		// 		explodearray.forEach(function(index, el) {
		// 			$("#chooseorder"+index).prop( "checked", true );
		// 			var xxx= $("#chooseorder"+index).val();
		// 			// $("#chooseorder"+index).parent().parent().css({'background': '#ff0000ad'});
		// 		});
		// 	}, 300);
		// }).draw();
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
	$("#submitform").click(function(event) {
		$("#myForm").submit();
	});
	function chooseorder(id,inv,date,cusname,total){
		var saveid = $("#saveid").val();
		var chooseorder = $("#chooseorder"+id).is(':checked');
		var arraydata = saveid.split(',');
		var txt = '';
		if(chooseorder){
			var xxx = [];
			xxx['id'] = id;
			xxx['inv'] = inv;
			xxx['date'] = date;
			xxx['cusname'] = cusname;
			xxx['total'] = total;
			arrayselectbox[id] = xxx;
			// $("#chooseorder"+id).parent().parent().css({'background': '#ff0000ad'});
			if(arraydata.indexOf(id) < 0){
				// txt += saveid+id+',';
				if(saveid.length == 0){
					// $("#saveid").val(id);
					txt += id+',';
				}else{
					// $("#saveid").val(saveid+','+id);
					txt += saveid+','+id+',';
				}
			}
		}else{
			if(arraydata.indexOf(id) >= 0){
				arraydata.splice(arraydata.indexOf(id),1);
				arrayselectbox[id] = '';
			}
			// console.log(arraydata);
			arraydata.forEach(function(index, el) {
				txt += index+',';
			});
		}
		var len = txt.length-1;
		// console.log(len)
		txt = txt.substr(0,len);
		// console.log(txt);
		$("#saveid").val(txt);
		txtselectbox = txt;
		// alert()
		// $('#myModal').modal('hide');
		// $('#rowdata').append('<tr class="rowproduct" id="row'+id+'"><td align="center">'+inv+'</td>'
		// 	+'<td align="center">'+date+'<input type="hidden" name="order[]" value="'+id+'"></td>'
		// 	+'<td>'+cusname+'</td>'
		// 	+'<td align="right">'+total+'</td>'
			
		// 	+'<td  align="center"><button type="button" class="btn btn-danger btn-rounded" onclick="delrow(\''+id+'\')"><i class="icon-cancel-square position-left"></i> Delete</button></td>'
		// +'</tr>');
		// $("#chooseorder"+id).addClass('disabled');
	}
	
	function delrow(id){
		$('#row'+id).closest('tr').remove();
	}
	
	$("#transportemp").autocomplete({
		source: "{{url('transport/autocompleteemp')}}",
		minLength: 1,
		select: function(event, ui){
		}
	})
	.autocomplete("instance")._renderItem = function(ul, item) {
		return $("<li>").append("<span class='text-semibold'>" + item.labels + '</span>' + "<br>" + '<span class="text-muted text-size-small">' + item.addr + '</span>').appendTo(ul);
	};
	$("#truckname").autocomplete({
		source: "{{url('transport/autocompletetruck')}}",
		minLength: 1,
		select: function(event, ui){
			$("#truckid").val(ui.item.text);
		}
	})
	.autocomplete("instance")._renderItem = function(ul, item) {
		return $("<li>").append("<span class='text-semibold'>" + item.label + '</span>' + "<br>" + '<span class="text-muted text-size-small">' + item.labels + '</span>').appendTo(ul);
	};
	function submitfn(){
		var data = $("#rowdata tr").length;
		var emp = $("#transportemp").val();
		var truckname = $("#truckname").val();
		var truckid = $("#truckid").val();

		if(emp.length == 0){
			Lobibox.notify('warning',{
				msg: 'กรุณาใส่ข้อมูลพนักงานขับรถ',
				buttonsAlign: 'center',
				closeOnEsc: true,  
			});
			$("#transportemp").focus();
			return false;
		}
		if(truckname.length == 0){
			Lobibox.notify('warning',{
				msg: 'กรุณาใส่ข้อมูลรถยนต์',
				buttonsAlign: 'center',
				closeOnEsc: true,  
			});
			$("#truckname").focus();
			return false;
		}
		if(truckid.length == 0){
			Lobibox.notify('warning',{
				msg: 'กรุณาใส่ข้อมูลป้ายทะเบียนรถ',
				buttonsAlign: 'center',
				closeOnEsc: true,  
			});
			$("#truckid").focus();
			return false;
		}
		if(data == 0){
			Lobibox.notify('warning',{
				msg: 'ไม่มีข้อมูล',
				buttonsAlign: 'center',
				closeOnEsc: true,  
			});
			return false;
		}
		$("#submitform").prop('disabled',true);
		// return true;
		// $('#myForm').submit();
	}

	function confirmorder(){
		var explodearray = txtselectbox.split(',');
		console.log(arrayselectbox);
		$('#rowdata').empty();
		console.log()
		if(explodearray.length > 0){
			explodearray.forEach(function(index, el) {
				if(index){
					var id =  arrayselectbox[index]['id']||'';
					var inv = arrayselectbox[index]['inv']||'';
					var date = arrayselectbox[index]['date']||'';
					var cusname = arrayselectbox[index]['cusname']||'';
					var total = arrayselectbox[index]['total']||'';
					$('#rowdata').append('<tr class="rowproduct" id="row'+id+'"><td align="center">'+inv+'</td>'
					+'<td align="center">'+date+'<input type="hidden" name="order[]" value="'+id+'"></td>'
					+'<td>'+cusname+'</td>'
					// +'<td align="right">'+total+'</td>'
					
					+'<td  align="center"><button type="button" class="btn btn-danger btn-rounded" onclick="delrow(\''+id+'\')"><i class="icon-cancel-square position-left"></i> Delete</button></td>'
					+'</tr>');
					$("#chooseorder"+id).addClass('disabled');
				}
			});
		}
	}
	$("#scanpoll").keyup(function(e) {
		var code = e.keyCode || e.which;
		e.preventDefault();
		if(code == 13) {
			var scanpoll = $("#scanpoll").val();
			$.post('create/scanbill', {inv: scanpoll,'_token': "{{ csrf_token() }}"}, function(data, textStatus, xhr) {
				$("#scanpoll").val('');
				if(data.selling_id !== undefined){
					if(arrayselectbox.indexOf(data.selling_id) >= 0){
						Lobibox.notify('warning',{
							msg: 'บาร์โค้ดซ้ำกรุณาตรวจสอบรายการ',
							buttonsAlign: 'center',
							closeOnEsc: true,  
						});
						return false;
					}else{
						Lobibox.notify('success',{
							msg: 'จัดรายการขนส่งเรียบร้อย',
							buttonsAlign: 'center',
							closeOnEsc: true,  
						});
						$('#rowdata').append('<tr class="rowproduct" id="row'+data.selling_id+'"><td align="center">'+data.selling_inv+'</td>'
						+'<td align="center">'+data.selling_date+'<input type="hidden" name="order[]" value="'+data.selling_id+'"></td>'
						+'<td>'+data.selling_customername+'</td>'
						+'<td  align="center"><button type="button" class="btn btn-danger btn-rounded" onclick="delrow(\''+data.selling_id+'\')"><i class="icon-cancel-square position-left"></i> Delete</button></td>'
						+'</tr>');
						arrayselectbox.push(data.selling_id);
					}
				}else{
					Lobibox.notify('error',{
						msg: 'กรุณาตรวจสอบบาร์โค้ด',
						buttonsAlign: 'center',
						closeOnEsc: true,  
					});
					return false;
				}
				
			});
				
		}
	});
</script>
@stop