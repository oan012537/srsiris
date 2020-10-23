@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- <div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Customer
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
									<a href="{{url('groupcustomer/create')}}"<button type="button" class="btn btn-success btn-lg"><i class="icon-plus-circle2"></i> เพิ่ม</button></a>
								</div>
							</div>
							
							<table class="table" id="datatables">
								<thead>
									<tr>
										<th class="text-center" width="10%">ลำดับที่</th>
										<th class="text-center" width="20%">ชื่อกลุ่มลูกค้า</th>
										<th class="text-center" width="20%">หมายเหตุ</th>
										<th class="text-center" width="20%">วันที่</th>
										<th class="text-center" width="15%">สถานะ</th>
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
				url : "{{url('groupcustomer/datatables')}}",
			},
			columns: [
				{ 'className': "text-center", data: 'groupcustomer_id', name: 'groupcustomer_id' },
				{ data: 'groupcustomer_text', name: 'groupcustomer_text' },
				{ data: 'groupcustomer_comment', name: 'groupcustomer_comment' },
				{ 'className': "text-center", data: 'created_at', name: 'created_at' },
				{ 'className': "text-center", data: 'created_at', name: 'created_at' },
				{ 'className': "text-center", data: 'created_at', name: 'created_at' },
			],
			order: [[0, 'asc']],
			rowCallback: function(row,data,index ){
				var status = '';
				if(data['groupcustomer_status'] == 0){
					var status = '<span class="label bg-danger-400">ยกเลิก</span>';
				}
				$('td:eq(4)', row).html(status);
				$('td:eq(5)', row).html( '<a href="groupcustomer/update/'+data['groupcustomer_id']+'"><i class="icon-pencil7"  data-popup="tooltip" title="Update"></i></a> <i class="icon-trash" onclick="del('+data['groupcustomer_id']+');" data-popup="tooltip" title="Delete"></i>' );
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
					window.location.href="groupcustomer/delete/"+id;
				}
			}
		});
	}
</script>
@stop