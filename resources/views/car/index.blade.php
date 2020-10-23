@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- <div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Supplier
				</h4>
			</div>

		</div>
	</div>-->
	<!-- /page header -->
	<style type="text/css">
		.classsupplier{
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
								@if(Auth::user()->actionadd != '')
								<div class="pull-right">
									<a href="{{url('car/create')}}"<button type="button" class="btn btn-success btn-lg"><i class="icon-plus-circle2"></i> เพิ่ม</button></a>
								</div>
								@endif
							</div>
							
							<table class="table" id="datatables">
								<thead>
									<tr>
										<th class="text-center" width="10%">#</th>
										<th class="text-center" width="30%">ทะเบียนรถ</th>
										<th class="text-center" width="20%">สถานะ</th>
										<th class="text-center" width="15%">วันที่สร้าง</th>
										<th class="text-center" width="15%">วันที่อัพเดท</th>
										<th class="text-center" width="10%">Action</th>
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
				url : "{{url('car/datatables')}}",
			},
			columns: [
				{ 'className': "text-center", data: 'car_id', name: 'car_id' },
				{ data: 'car_text', name: 'car_text' },
				{ 'className': "text-center", data: 'car_status', name: 'car_status' },
				{ 'className': "text-center", data: 'created_at', name: 'created_at' },
				{ 'className': "text-center", data: 'created_at', name: 'created_at' },
				{ 'className': "text-center", data: 'updated_at', name: 'updated_at' }
			],
			order: [[0, 'asc']],
			rowCallback: function(row,data,index ){
				if(data['car_status'] == '1'){
					$('td:eq(2)', row).html('ใช้งานอยู่');
				}else{
					$('td:eq(2)', row).html('ไม่ใช้แล้ว');
					$('td:eq(0)', row).addClass('bg-danger');
					$('td:eq(1)', row).addClass('bg-danger');
					$('td:eq(2)', row).addClass('bg-danger');
					$('td:eq(3)', row).addClass('bg-danger');
					$('td:eq(4)', row).addClass('bg-danger');
					$('td:eq(5)', row).addClass('bg-danger');
				}
				var btndel = '';
                var permissiondel = "{{Auth::user()->actiondelete}}";
                var permissionedit = "{{Auth::user()->actionedit}}";
                if( permissiondel != ''){
                	btndel = ' <i class="icon-trash" onclick="del('+data['car_id']+');" data-popup="tooltip" title="Delete"></i>';
                }
                var btnedit = '';
                if(permissionedit !=''){
                	btnedit = ' <a href="car/update/'+data['car_id']+'"><i class="icon-pencil7" data-popup="tooltip" title="Update"></i></a>';
                }
				$('td:eq(5)', row).html( btnedit+btndel);
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
					window.location.href="car/delete/"+id+"";
				}
			}
		});
	}
</script>
@stop