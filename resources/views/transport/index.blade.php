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
		.classtransport{
			background: rgb(199,199,199,0.3);
		}
		.datails{
			margin-top: 10px;
		}
		
		.light-box{
			z-index: 999999 !important;
		}
		.chocolat-wrapper{
			z-index: 999999 !important;
		}
		.fancybox-close:after{
			content:none !important;
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
								<form class="form-horizontal col-md-9" action="#">
									<div class="form-group">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-md-2">
													<div class="form-group">
														<input type="text" name="noorder" id="noorder" class="form-control" placeholder="เลขที่ออเดอร์">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<input type="text" name="datestart" id="datestart" class="form-control datepicker-dates" placeholder="วันที่เริ่มต้น" autocomplete="off">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<input type="text" name="dateend" id="dateend" class="form-control datepicker-dates" placeholder="วันที่สิ้นสุด" autocomplete="off">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<select name="staus" class="form-control" id="staus">
															<option value=""> - </option>
															<option value="9">ยกเลิก</option>
															<option value="0">รอจัดส่ง</option>
															<option value="2">กำลังจัดส่ง</option>
															<option value="1">จัดส่งเรียบร้อย</option>
														</select>
													</div>
												</div>
												<div class="col-md-1">
													<div class="form-group">
														<button type="button" id="searchdata" class="btn btn-primary"><i class="icon-folder-search"></i> ค้นหา</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
								<div class="col-md-3 pull-right" style="text-align: right;">
									@if(Auth::user()->actionadd != '')
									<a href="{{url('transport/create')}}"<button type="button" class="btn btn-success"><i class="icon-plus-circle2"></i> เพิ่ม</button></a>
									@endif
									<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="icon-truck"></i> ตรวจสอบใบขนส่ง</button>
								</div>
							</div>
							
							<table class="table" id="datatables">
								<thead>
									<tr>
										<th class="text-center" width="10%">ลำดับ</th>
										<th class="text-center" width="20%">เลขที่ออเดอร์</th>
										<th class="text-center" width="20%">วันที่</th>
										<th class="text-center" width="15%">วันที่ส่ง</th>
										<th class="text-center" width="20%">สถานะ</th>
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
	<!-- /page container -->
	
	
	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">ตรวจสอบใบขนส่ง</h4>
		  </div>
		  <div class="modal-body">
			<div class="form-inline">
				<div class="form-group">
				  <label for="email">Barcode:</label>
				  <input type="text" class="form-control" id="barcode" placeholder="Enter barcode" name="barcode">
				</div>
				<button type="button" id="searchtran" class="btn btn-default">ค้นหา</button>
				<br>
				<input type="hidden" name="transportid" id="transportid">
				<div id="rowdata" style="display:none;">
					<table class="table">
						<thead>
							<tr>
								<th class="text-center" width="10%">ลำดับ</th>
								<th class="text-center" width="15%">เลขที่ออเดอร์</th>
								<th class="text-center" width="15%">วันที่</th>
								<th class="text-center" width="15%">วันที่ส่ง</th>
								<th class="text-center" width="20%">สถานะ</th>
								<th class="text-center" width="25%">#</th>
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
	
	<!-- Modal -->
	<div id="roworder" class="modal fade modal-child" role="dialog" data-backdrop-limit="1" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-modal-parent="#myModal">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title"></h4>
		  </div>
		  <div class="modal-body">
			<table class="table">
				<thead>
					<tr>
						<th class="text-center" width="10%">ลำดับ</th>
						<th class="text-center" width="15%">รหัสสินค้า</th>
						<th class="text-center" width="20%">รายการ</th>
						<th class="text-center" width="20%">จำนวน</th>
						<th class="text-center" width="20%">มูลค่า</th>
					</tr>
				</thead>
				<tbody id="rowdataorder">
				
				</tbody>
			</table>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
		  </div>
		</div>

	  </div>
	</div>
	
	{{-- <div id="rowordersend" class="modal fade modal-child" role="dialog" data-backdrop-limit="1" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-modal-parent="#myModal">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title"></h4>
		  </div>
		  <div class="modal-body">
			<table class="table">
				<thead>
					<tr>
						<th class="text-center" width="10%">ลำดับ</th>
						<th class="text-center" width="15%">เลขที่ออเดอร์</th>
						<th class="text-center" width="20%">สถานะ</th>
						<th class="text-center" width="20%">จำนวน</th>
						<th class="text-center" width="20%">#</th>
					</tr>
				</thead>
				<tbody id="rowdataordersend">
				
				</tbody>
			</table>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
		  </div>
		</div>

	  </div>
	</div> --}}

	<div class="modal inmodal" data-backdrop="static" id="savefile" tabindex="-1" role="dialog"  aria-hidden="true">
	    <div class="modal-dialog" style="width:70%">
	        <div class="modal-content animated fadeIn">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title text-center">บันทึกใบส่งของ</h4>
	            </div>
	            <div class="modal-body">
	            	<form id="myform" method="post" action="{{url('transport/uploadfile')}}" enctype="multipart/form-data">
	            		<input type="hidden" id="transportid" name="transportid">
						{{ csrf_field() }}
		                <div class="row">
							<div class="col-md-12 col-md-12">
								<div class="form-group">
									<label>รูปสินค้า :</label>
									<input type="file" class="file-input" name="uploadcover" required>
									<span class="help-block">ขนาดรูป : 305 x 425px</span>
								</div>
							</div>
						</div>
					</form>
	            </div>
	            <div class="modal-footer" style="margin-top:3%">
	                <button type="submit" form="myform" class="btn btn-white" >บันทึก</button>
	            </div>
	        </div>
	    </div>
	</div>

	<div id="myModalview" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">รายการขนส่ง</h4>
		  </div>
		  <div class="modal-body">
			<div class="form-inline">
				<table class="table">
					<thead>
						<tr>
							<th class="text-center" width="10%">ลำดับ</th>
							<th class="text-center" width="15%">เลขที่ออเดอร์</th>
							<th class="text-center" width="15%">วันที่</th>
							<th class="text-center" width="15%">วันที่ส่ง</th>
							<th class="text-center" width="20%">สถานะ</th>
							<th class="text-center" width="25%">#</th>
						</tr>
					</thead>
					<tbody id="rowdatas">
					
					</tbody>
				</table>
			  </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>

	  </div>
	</div>

	<div class="modal" data-backdrop="static" id="uploadfile" tabindex="-1" role="dialog"  aria-hidden="true">
	    <div class="modal-dialog" style="width:70%">
	        <div class="modal-content animated fadeIn">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title text-center">บันทึกไฟล์</h4>
	            </div>
	            <div class="modal-body">
	            	<form id="myformuploadfileselling" method="post" action="{{url('transport/uploadfileforselling')}}" enctype="multipart/form-data">
	            		<input type="hidden" id="sellingid" name="sellingid">
	            		<input type="hidden" id="transportid" name="transportid">
						{{ csrf_field() }}
		                <div class="row">
		                	<div class="col-md-12 col-md-12">
								<div class="form-group">
									<label>สถานที่ส่ง :</label>
									<select class="form-control" id="destination" name="destination">
									</select>
								</div>
							</div>
							<div class="col-md-12 col-md-12">
								<div class="form-group">
									<label>เลขที่จัดส่ง :</label>
									<input type="text" class="form-control" name="nodelivery" id="nodelivery" required>
								</div>
							</div>
		                	<div class="col-md-12 col-md-12">
								<div class="form-group">
									<label>ค่าขนส่ง :</label>
									<input type="number" class="form-control" name="shippingcost" id="shippingcost" required>
								</div>
							</div>
							<div class="col-md-12 col-md-12">
								<div class="form-group">
									<label>ไฟล์ :</label>
									<input type="file" class="file-input" name="uploadfileselling" id="uploadfileselling" required>
								</div>
							</div>
						</div>
					</form>
	            </div>
	            <div class="modal-footer" style="margin-top:3%">
	                <button type="submit" form="myformuploadfileselling" class="btn btn-white" >บันทึก</button>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal" data-backdrop="static" id="expend" tabindex="-1" role="dialog"  aria-hidden="true">
	    <div class="modal-dialog" style="width:70%">
	        <div class="modal-content animated fadeIn">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title text-center">ค่าใช้จ่ายในการขนส่ง</h4>
	            </div>
	            <div class="modal-body">
	            	<form id="myformexpend" method="post" action="{{url('transport/expend')}}" enctype="multipart/form-data">
	            		<input type="hidden" id="transportid" name="transportid">
						{{ csrf_field() }}
		                <div class="row">
							<div class="col-md-12 col-md-12">
								<div class="form-group">
									<label>เงินเบิก :</label>
									<input type="text" class="form-control" name="withdrawal" required>
								</div>
								<fieldset>
									<legend class="text-semibold"><b>รายการจ่ายต่างๆ</b></legend>
									{{-- <div class="col-md-12 col-md-12"> --}}
										<div class="form-group">
											<label class="col-md-2 datails">รายการจ่าย :</label>
											<div class="input-control col-md-7 datails" style="padding-left: 0;">
												<input type="text" class="form-control" name="details[]" required value="">
											</div>
											<div class="input-control col-md-2 datails" style="padding-left: 0;">
												<input type="text" class="form-control" name="expend[]"  required value="0">
												<input type="hidden" class="form-control" name="expendid[]"   value="">
											</div>
											<div class="col-md-1 datails">
												<button type = "button" onclick="addformbtn();" class="btn btn-default">เพิ่ม</button>
											</div>
											<div class="formaddto"></div>
											<br>
											<br>
											<div class="form-group">
												<label>ไฟล์อ้างอิง :</label>
												<div class="file-loading"> 
													<input type="file"  id="uploadfile_" name="uploadfile_[]" multiple >
												</div>
											</div>
										</div>
									{{-- </div> --}}
								</fieldset>
							</div>
						</div>
					</form>
	            </div>
	            <div class="modal-footer" style="margin-top:3%">
	                <button type="submit" form="myformexpend" class="btn btn-white" >บันทึก</button>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal inmodal" id="showfile" tabindex="-1" role="dialog"  aria-hidden="true">
	    <div class="modal-dialog" style="width:70%">
	        <div class="modal-content animated fadeIn">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title text-center">ดูข้อมูล</h4>
	            </div>
	            <div class="modal-body">
	                <div class="row">
						<div class="col-md-10 col-md-10 col-md-offset-1">
							{{-- <fieldset> --}}
								{{-- <legend class="text-semibold">ข้อมูลไฟล์</legend> --}}
								<div class="row">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>ชื่อไฟล์</th>
												<th>วันที่</th>
												{{-- <th>ประเภท</th> --}}
												<th>#</th>
											</tr>
										</thead>
										<tbody id="showdatafile">
										</tbody>
									</table>
								</div>
							{{-- </fieldset> --}}
						</div>
					</div>
	            </div>
	            <div class="modal-footer" style="margin-top:3%">
	                <button type="button" class="btn btn-danger" data-dismiss="modal" >ปิด</button>
	            </div>
	        </div>
	    </div>
	</div>

<script>
	$('#datestart,#dateend').datepicker({
        dateFormat: 'yy-mm-dd'
    });
	function formatNumber (x) {
		return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	$("#uploadfile_").fileinput({
        uploadUrl: '/file-upload-batch/2',
        maxFilePreviewSize: 10240,
        showUpload: false,
        maxFileCount: 8,
    });

	$('.modal-child').on('show.bs.modal', function () {
	    var modalParent = $(this).attr('data-modal-parent');
	    $(modalParent).css('opacity', 0);
	});
 
	$('.modal-child').on('hidden.bs.modal', function () {
	    var modalParent = $(this).attr('data-modal-parent');
	    $(modalParent).css('opacity', 1);
	});

	$('#barcode').keypress(function(e){
		if(e.which == 13){
			$.ajax({
			'type': 'post',
			'url': "{{url('checkdatatran')}}",
			'dataType': 'json',
			'data': {
				'keyword': $('#barcode').val(),
				'_token': "{{ csrf_token() }}"
			},
				'success': function (data){
					var num = 1;
					var text = '';
					$("#myModal #transportid").val(data.tran.trans_id);
					$('.rowbody').closest('tr').remove();
					$.each(data.subs,function(key,item){
						text += '<tr class="rowbody" >'
							+'<td align="center">'+num+'</td>'
							+'<td align="left" onclick="roworder('+item.id+')">'+item.inv+'</td>'
							+'<td align="center">'+item.date+'</td>'
							+'<td align="center">'+item.datedeli+'</td>'
							+'<td align="center">'+item.statustext+'</td>';
						var disabled = "";
						if(item.status == 0){
							disabled = "disabled";
						}
						text += '<td align="center"><button type="button" '+ disabled +' class="btn btn-warning" onclick="canceldata('+item.id+')">ยกเลิก</button></td>'
						+'</tr>';
						num++;
					});
					$('#rowdatas').append(text);
					$('#rowdata').show();
				}
			});
		}
	});
	
	$('#searchtran').click(function(){
		$.ajax({
		'type': 'post',
		'url': "{{url('checkdatatran')}}",
		'dataType': 'json',
		'data': {
			'keyword': $('#barcode').val(),
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data){
				var num = 1;
				var text = '';
				$("#myModal #transportid").val(data.tran.trans_id);
				$('.rowbody').closest('tr').remove();
				$.each(data.subs,function(key,item){
					text += '<tr class="rowbody" >'
						+'<td align="center">'+num+'</td>'
						+'<td align="left" onclick="roworder('+item.id+')">'+item.inv+'</td>'
						+'<td align="center">'+item.date+'</td>'
						+'<td align="center">'+item.datedeli+'</td>'
						+'<td align="center">'+item.statustext+'</td>';
					var disabled = "";
					if(item.status == 0){
						disabled = "disabled";
					}
					text += '<td align="center"><button type="button" '+ disabled +' class="btn btn-warning" onclick="canceldata('+item.id+')">ยกเลิก</button></td>'
					+'</tr>';
					num++;
				});
				$('#rowdatas').append(text);
				$('#rowdata').show();
			}
		});
	});
	
	function roworder(id){
		console.log(id);
	 	$.ajax({
			'type': 'post',
			'url': "{{url('orderdata')}}",
			'dataType': 'json',
			'data': {
				'id': id,
				'_token': "{{ csrf_token() }}"
			},
			'success': function (data){
				var num = 1;
				var text = '';
				$('.rowbodyorder').closest('tr').remove();
				$.each(data,function(key,item){
					text += '<tr class="rowbodyorder">'
						+'<td align="center">'+num+'</td>'
						+'<td align="left">'+item.product_code+'</td>'
						+'<td align="left">'+item.product_name+'</td>'
						+'<td align="center">'+item.sellingdetail_qty+'</td>'
						+'<td align="right">'+formatNumber(item.sellingdetail_total.toFixed(2))+'</td>'
					+'</tr>';
					num++;
				});
				$('#rowdataorder').append(text);
				$('#roworder').modal('show');
			}
		}); 
	}
	
	
	$(document).ready(function(){
		var oTable = $('#datatables').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: false,
			ajax:{ 
				url : "{{url('trandata')}}",
				data: function (d) {
					d.noorder = $('#noorder').val();
					d.datestart = $('#datestart').val();
					d.dateend = $('#dateend').val();
					d.staus = $('#staus').val();
				},
			},
			columns: [
				{ 'className': "text-center", data: 'trans_id', name: 'trans_id' },
				{ 'className': "text-center", data: 'trans_invoice', name: 'trans_invoice' },
				// { 'className': "text-center", data: 'viewdetail', name: 'viewdetail' },
				{ 'className': "text-center", data: 'trans_date', name: 'trans_date	' },
				{ 'className': "text-center", data: 'trans_delivery', name: 'trans_delivery' },
				{ 'className': "text-center", data: 'updated_at', name: 'updated_at' },
				{ 'className': "text-center", data: 'updated_at', name: 'updated_at' },
			],
			order: [[0, 'asc']],
			rowCallback: function(row,data,index ){
				var status = '';
				var truckwait = '';
				var trucksucc = '';
				var btndel = '';
                var permissiondel = "{{Auth::user()->actiondelete}}";
                var permissionedit = "{{Auth::user()->actionedit}}";
                if( permissiondel != ''){
                	btndel = ' <i class="icon-trash text-danger" onclick="cancel('+data['trans_id']+');" data-popup="tooltip" title="ลบ"></i>';
                }
                var btnedit = '';
                if(permissionedit !=''){
                	btnedit = ' <a href="{{url("export-update")}}/'+data['export_id']+'"><i class="icon-pencil7" data-popup="tooltip" title="แก้ไข"></i></a>';
                }

				var doc = '<a href="{{url("transport/invoice")}}/'+data['trans_id']+'" target="_blank"><i class="icon-price-tags text-success" data-popup="tooltip" title="ใบแปะหน้า"></i></a>';
				if(data['trans_status'] == 0){
					// truckwait = '<i class="icon-truck text-success" onclick="wait('+data['trans_id']+');" data-popup="tooltip" title="กำลังส่ง"></i> <a href="{{url("transport/scanbillfortranfer")}}/'+data['trans_id']+'"><i class="icon-barcode2 " data-popup="tooltip" title="สแกนขึ้นรถ"></i></a> ';
					truckwait = '<a href="{{url("transport/scanbillfortranfer")}}/'+data['trans_id']+'"><i class="icon-barcode2 " data-popup="tooltip" title="สแกนขึ้นรถ"></i></a> ';
					// status = '<span class="label bg-primary"> </span>';
				}else if(data['trans_status'] == 1){
					status = '<span class="label bg-success">ส่งแล้ว</span>';
				}else if(data['trans_status'] == 2){
					trucksucc = '<i class="icon-file-check" onclick="approve('+data['trans_id']+');" data-popup="tooltip" title="ส่งแล้ว"></i>';
					status = '<span class="label bg-success">กำลังส่ง</span>';
				}else if(data['trans_status'] == 3){
					truckwait = '<i class="icon-truck text-success" onclick="wait('+data['trans_id']+');" data-popup="tooltip" title="กำลังส่ง"></i> ';
					status = '<span class="label bg-primary">จัดของขึ้นรถ</span>';
				}else if(data['trans_status'] == 5){
					truckwait = '<i class="icon-truck text-success" onclick="wait('+data['trans_id']+');" data-popup="tooltip" title="กำลังส่ง"></i> ';
					status = '<span class="label bg-success">สแกนขึ้นรถครบแล้ว</span>';
				}else if(data['trans_status'] == 6){
					truckwait = '<a href="{{url("transport/scanbillfortranfer")}}/'+data['trans_id']+'"><i class="icon-barcode2 " data-popup="tooltip" title="สแกนขึ้นรถ"></i></a> ';
					status = '<span class="label bg-warning">สแกนขึ้นรถยังไม่ครบ</span>';
				}else if(data['trans_status'] == 9){
					status = '<span class="label bg-danger">ยกเลิก</span>';
				}
				var viewordertranspot = ' <i class="icon-files-empty2" onclick="viewordertranspot('+data['trans_id']+');" data-popup="tooltip" title="รายการส่งสินค้า"></i> ';
				// $('td:eq(1)', row).html('<div onclick="getroworder('+"'"+data['trans_invoice']+"'"+')" data-popup="tooltip" title="ดูข้อมูลกล่องสินค้า">'+data['trans_invoice']+'</div>');
				$('td:eq(4)', row).html(status);
				if(data['trans_status'] != 1){
					$('td:eq(5)', row).html( truckwait+'  '+trucksucc+ '  ' +viewordertranspot+' <i class="icon-clipboard2 text-primary" onclick="savefile('+data['trans_id']+');" data-popup="tooltip" title="แนบไฟล์"></i>  '+doc+' <i class="icon-search4 text-warning" onclick="viewdata('+data['trans_id']+');" data-popup="tooltip" title="ดูข้อมูล"></i> '+btndel );
				}else{
					var viewfile = '';
					if(data['upfile'] > 0){
						viewfile = '<i class="icon-file-text" onclick="viewuploadfile('+data['trans_id']+');" data-popup="tooltip" title="ไฟล์ที่อัพโหลด"></i>'
					}
					$('td:eq(5)', row).html(viewordertranspot+' ' +viewfile+' <i class="icon-cash" onclick="withdraw('+data['trans_id']+');" data-popup="tooltip" title="เพิ่มค่าใช้จ่าย"></i> '+doc+' <i class="icon-search4 text-warning" onclick="viewdata('+data['trans_id']+');" data-popup="tooltip" title="ดูข้อมูล"></i>');
				}
			}
		});
		
		oTable.on( 'order.dt search.dt', function(){
			oTable.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell, i){
				cell.innerHTML = i+1;
			} );
		}).draw();
		$('#searchdata').click(function(e){
			oTable.draw();
			e.preventDefault();
		});
		$("#noorder").keyup(function(e){
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
					window.location.href="tran-delete/"+id+"";
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
					window.location.href="transport/cancel/"+id+"";
				}
			}
		});
	}

	function wait(id){
		bootbox.confirm({
			title: "ยืนยัน?",
			message: "คุณต้องการเปลี่ยนรายการนี้เป็นกำลังส่ง หรือไม่?",
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
					window.location.href="tran-wait/"+id+"";
				}
			}
		});
	}
	
	function approve(id){
		bootbox.confirm({
			title: "ยืนยัน?",
			message: "คุณต้องการเปลี่ยนรายการนี้เป็นส่งแล้ว หรือไม่?",
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
					window.location.href="tran-approve/"+id+"";
				}
			}
		});
	}
	function savefile(id){
		$("#transportid").val(id);
		$("#savefile").modal('show');
	}

	function canceldata(id){
		var transportid = $("#myModal #transportid").val();
		$.post("{{url('transport/cancel/order')}}",{'id': id,'transportid':transportid,'_token': "{{ csrf_token() }}"}, function(data, textStatus, xhr) {
			if(data == "Y"){
				$('#searchtran').click();
			}
		});
	}

	function viewdata(id){
		$.ajax({
		'type': 'post',
		'url': "{{url('viewdatatran')}}",
		'dataType': 'json',
		'data': {
			'id': id,
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data){
				var num = 1;
				var text = '';
				$("#myModalview").modal('show');
				$('.rowbody').closest('tr').remove();
				$.each(data.subs,function(key,item){
					text += '<tr class="rowbody" >'
						+'<td align="center">'+num+'</td>'
						+'<td align="left" onclick="roworder('+item.id+')">'+item.inv+'</td>'
						+'<td align="center">'+item.date+'</td>'
						+'<td align="center">'+item.datedeli+'</td>'
						+'<td align="center">'+item.statustext+'</td>';
					var disabled = "";
					var disabled2 = "";
					if(item.status == 0){
						disabled = "disabled";
						disabled2 = "disabled";
					}
					if(item.statusselling == 8){
						disabled = "disabled";
						disabled2 = '';
					}
					text += '<td align="center"><button type="button" '+ disabled +' class="btn btn-warning" onclick="canceldataview('+item.id+','+id+')" id="btncancel'+item.id+'">ยกเลิก</button> <button type="button" '+ disabled2 +' class="btn btn-primary" onclick="uploadfile('+item.id+','+id+','+item.customerid+')" id="btnupload'+item.id+'">อัพไฟล์</button></td>'
					+'</tr>';
					num++;
				});
				$('#myModalview #rowdatas').append(text);
				$('#myModalview #rowdata').show();
			}
		});
	}

	function canceldataview(id,transportid){
		$.post("{{url('transport/cancel/order')}}",{'id': id,'transportid':transportid,'_token': "{{ csrf_token() }}"}, function(data, textStatus, xhr) {
			if(data == "Y"){
				$("#btncancel"+id).prop('disabled',true);
				$("#btnupload"+id).prop('disabled',true);
			}
		});
	}

	function uploadfile(id,trans_id,customerid){
		$("#uploadfile #sellingid").val(id);
		$("#uploadfile #transportid").val(trans_id);
		$("#uploadfile").modal('show');
		$.post("{{url('transport/getdestination')}}", {id: customerid,'_token': "{{ csrf_token() }}"}, function(data, textStatus, xhr) {
			var optiontxt = '<option value=""> - </option>';
			$.each(data,function(key,item){
				optiontxt += '<option value="'+item.destination_id+'"> '+item.destination_name+' </option>'
			});
			$("#destination").empty().append(optiontxt);
			
		});
	}

	$('#myformuploadfileselling').on('submit', function(e) {
        e.preventDefault(); 
        var formData = new FormData(this); // value total in form
        $.ajax({    
           	url:"{{url('uploadfileforselling')}}",
           	data:formData,
           	type:"POST",
           	async: false,
           	contentType: false,
           	processData: false,
           	success:function(data){
                if(data==true){
                	var sellingid = $("#sellingid").val();
                    Lobibox.notify('success',{
						msg: 'บันทึกเรียบร้อย',
						buttonsAlign: 'center',
						closeOnEsc: true,  
					});
					$("#myformuploadfileselling")[0].reset();
					$("#btncancel"+sellingid).prop('disabled',true);
					$("#uploadfile").modal('hide');
                }else if(data==false){
                    Lobibox.notify('warning',{
						msg: 'เกิดข้อผิดพลาด!',
						buttonsAlign: 'center',
						closeOnEsc: true,  
					});
                }else{
                    Lobibox.notify('error',{
						msg: 'เกิดข้อผิดพลาด!',
						buttonsAlign: 'center',
						closeOnEsc: true,  
					}); 
                }       
            },
            error:function(){
                Lobibox.notify('error',{
					msg: 'เกิดข้อผิดพลาด!',
					buttonsAlign: 'center',
					closeOnEsc: true,  
				}); 
            },
        });
    });

    function viewordertranspot(id){
    	window.open("transport/ordertransport/"+id);
    }

    function withdraw(id){
    	$(".formaddto .addform").remove();
    	$("#myformexpend #transportid").val(id);
    	$("input[name='withdrawal']").val('');
    	$("input[name='details[]']").val('');
		$("input[name='expend[]']").val('');
		$("input[name='expendid[]']").val('');
    	$.post('{{url("transport/getexpen")}}', {id: id,'_token': "{{ csrf_token() }}"}, function(data, textStatus, xhr) {
    		if(data.length > 0){
    			$("input[name='withdrawal']").val(data[data.length - 1].transportexpen_balance);
    			$("input[name='details[]']").val(data[0].transportexpen_detail);
    			$("input[name='expend[]']").val(data[0].transportexpen_expen);
    			$("input[name='expendid[]']").val(data[0].transportexpen_id);
    			$.each(data,function(key,item){
    				if(key != 0){
    					addformbtn();
		    			$("#addform"+(key-1)+" input[name='details[]']").val(data[key].transportexpen_detail);
		    			$("#addform"+(key-1)+" input[name='expend[]']").val(data[key].transportexpen_expen);
		    			$("#addform"+(key-1)+" input[name='expendid[]']").val(data[key].transportexpen_id);
    				}
    			});
    		}
    	});
    	$("#expend").modal('show');
    }

    function addformbtn(){
    	var len = $(".formaddto .addform").length;
    	var txt = '<div class="addform" id="addform'+len+'"><label class="col-md-2 datails">รายการจ่าย :</label><div class="input-control col-md-7 datails" style="padding-left: 0;"><input type="text" class="form-control" name="details[]" required value=""></div><div class="input-control col-md-2 datails" style="padding-left: 0;"><input type="text" class="form-control" name="expend[]"  required value="0"><input type="hidden" class="form-control" name="expendid[]"   value=""></div><div class="col-md-1 datails"><button type = "button" onclick="removeadd('+len+');" class="btn btn-danger">ลบ</button></div><div>';
    	$(".formaddto").append(txt);
    }
    function removeadd(num){
    	$("#addform"+num).remove();
    }

    function viewuploadfile(id){
    	$.post("{{url('transport/getfileupload')}}", {'id': id,'_token': "{{ csrf_token() }}"}, function(data, textStatus, xhr) {
			var txt = '';
			data.forEach(function(index, el) {
				txt += '<tr>';
				txt += '<td>'+index.transportuploadfile_name+'</td>';
				txt += '<td>'+index.created_at+'</td>';
				txt += '<td><div class=""><a class="fancybox" href="{{asset('assets/images/uploadtransport/')}}/'+index.transportuploadfile_name+'" style="width:500px;">เปิด</a></div></td>';
				txt += '<tr>';
			});
			$("#showdatafile").empty().append(txt);
			$("#showfile").modal('show');
			$(".fancybox").fancybox({
				// openEffect: "none",
				// closeEffect: "none",
				type   :'iframe',
				titleShow:false,
				centerOnScroll:true,
				// width:'80%',
				// height:420,
				scrolling:'auto',
				fullScreenApi:true,
				iframe:true,

			});
		});
    }

    function scanincar(id){
    	window.location.href = 'scanbillfortranfer/'+id;
    }
</script>
@stop