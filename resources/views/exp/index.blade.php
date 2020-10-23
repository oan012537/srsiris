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
								<div class="pull-right">
									<a href="{{url('exp/create')}}"<button type="button" class="btn btn-success btn-lg"><i class="icon-plus-circle2"></i> เพิ่ม</button></a>
								</div>
							</div>
							
							<table class="table" id="datatables">
								<thead>
									<tr>
										<th class="text-center" width="10%">ลำดับ</th>
										<th class="text-center" width="20%">เลขที่ออเดอร์</th>
										<th class="text-center" width="20%">วันที่</th>
										<th class="text-center" width="20%">สถานะ</th>
										<th class="text-center" width="15%">วันที่อัพเดท</th>
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
			ajax:{ 
				url : "{{url('expdatatables')}}",
			},
			columns: [
				{ 'className': "text-center", data: 'exp_id', name: 'exp_id' },
				{ 'className': "text-center", data: 'exp_inv', name: 'exp_inv' },
				{ 'className': "text-center", data: 'exp_date', name: 'exp_date	' },
				{ 'className': "text-center", data: 'exp_status', name: 'exp_status' },
				{ 'className': "text-center", data: 'updated_at', name: 'updated_at' },
				{ 'className': "text-center", data: 'updated_at', name: 'updated_at' },
			],
			order: [[0, 'asc']],
			rowCallback: function(row,data,index ){
				var status = '';
				if(data['exp_status'] == 0){
					status = '<span class="label bg-danger">หาย</span>';
				}else if(data['exp_status'] == 1){
					status = '<span class="label bg-danger">ชำรุด</span>';
				}else if(data['exp_status'] == 2){
					status = '<span class="label bg-danger">หมดอายุ</span>';
				}
				
				$('td:eq(3)', row).html(status);
				$('td:eq(5)', row).html( '<i class="icon-trash" onclick="del('+data['exp_id']+');" data-popup="tooltip" title="Delete"></i>' );
			}
		});
		
		oTable.on( 'order.dt search.dt', function(){
			oTable.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell, i){
				cell.innerHTML = i+1;
			} );
		}).draw();
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
					window.location.href="exp-delete/"+id+"";
				}
			}
		});
	}
</script>
@stop