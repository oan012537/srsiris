@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- <div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Product
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
							
							<div class="panel-body">
								<form class="form-horizontal" action="#">
									<div class="form-group">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-md-2">
													<div class="form-group">
														<input type="text" placeholder="ตั้งแต่วันที่" class="form-control datepicker-dates" onkeypress="return false;" name="datestart" id="datestart" value="" autocomplete="off">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<input type="text" placeholder="ถึงวันที่" class="form-control datepicker-dates" onkeypress="return false;" name="dateend" id="dateend" value="" autocomplete="off">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<select name="menu" id="menu" class="form-control">
															<option value="">- เลือกประเภทเมนู -</option>
															<option value="1">สินค้า</option>
															<option value="3">ลูกค้า</option>
															<option value="4">ออเดอร์</option>
															<option value="5">การขาย</option>
															<option value="6">แพ็คของ</option>
															<option value="7">การขนส่ง</option>
															<option value="8">การเก็บเงิน</option>
															<option value="9">แจ้งการอัพโหลดสลิป</option>
															<option value="10">ซัพพลายเออร์</option>
															<option value="11">การนำเข้า</option>
															<option value="12">รายงาน</option>
															<option value="13">หมวดหมู่สินค้า</option>
															<option value="14">พนักงานขับรถ</option>
															<option value="15">รถยนต์</option>
															<option value="16">เขตพื้นที่ลูกค้า</option>
															<option value="17">หน่วย</option>
															<option value="18">แก้ไขที่อยู่หัวบิล</option>
															<option value="19">เปอร์เซ็นลดเงิน</option>
															<option value="20">การตั้งค่า</option>
														</select>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<button type="button" id="searchdata" class="btn btn-primary"><i class="icon-folder-search"></i> ค้นหา</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
							
							<div class="table-responsive">
								<table class="table table-bordered" id="datatables">
									<thead>
										<tr>
											<th class="text-center" >ลำดับที่</th>
											<th class="text-center" >รายละเอียด</th>
											<th class="text-center" >ชื่อผู้ใช้งาน</th>
											<th class="text-center" >วันที่</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
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
<script>
	// var oTable = $('#datatables').DataTable({
	// 		processing: false,
	// 		serverSide: false,
	// 		searching: false,
	// 		lengthChange: false,
	// 	});
	var oTable = '';
	$(document).ready(function(){
        
		oTable = $('#datatables').DataTable({
			processing: true,
			serverSide: true,
			searching: false,
			lengthChange: false,
			// retrieve: true,
			ajax:{ 
				url : "{{url('logsystemdata')}}",
				data: function (d) {
					d.datestart = $('#datestart').val();
					d.dateend = $('#dateend').val();
					d.menu = $('#menu').val();
				},
			},
			columns: [
				{ 'className': "text-center", data: 'logsystem_id', name: 'logsystem_id' },
				{ data: 'logsystem_text', name: 'logsystem_text' },
				{ data: 'name', name: 'name' },
				{ 'className': "text-center", data: 'created_at', name: 'created_at' },
				{ 'className': "text-center", data: 'logsystem_id', name: 'logsystem_id' },
				{ 'className': "text-center", data: 'logsystem_id', name: 'logsystem_id' },
			],
			columnDefs: [
		        { targets: 0},
		        { targets: 1},
		        { targets: 2},
		        { targets: 3},
		        { targets: 4,"visible": false,"searchable": false},
		        { targets: 5,"visible": false,"searchable": false},
		    ],
			order: [[0, 'asc']],
		});
		
		// oTable.on( 'order.dt search.dt', function(){
		// 	oTable.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell, i){
		// 		cell.innerHTML = i+1;
		// 	} );
		// }).draw();
		
		$('#searchdata').click(function(e){
			oTable.draw();
			e.preventDefault();
		});
		$.ajax({
			url: '{{url('logsystemdata')}}',
			success:function(results){
				console.log(results)
			}
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});
	
	
</script>
@stop