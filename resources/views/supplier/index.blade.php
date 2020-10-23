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
									<a href="{{url('supplier/create')}}"<button type="button" class="btn btn-success btn-lg"><i class="icon-plus-circle2"></i> เพิ่ม</button></a>
								</div>
								@endif
							</div>
							
							<table class="table" id="datatables">
								<thead>
									<tr>
										<th class="text-center" width="10%">#</th>
										<th class="text-center" width="20%">ชื่อผู้ผลิต</th>
										<th class="text-center" width="15%">เบอร์ติดต่อ</th>
										<th class="text-center" width="15%">อีเมล์</th>
										<th class="text-center" width="15%">เลขผู้เสียภาษี</th>
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
				url : "{{url('supplierdatatables')}}",
			},
			columns: [
				{ 'className': "text-center", data: 'supplier_id', name: 'supplier_id' },
				{ data: 'supplier_name', name: 'supplier_name' },
				{ 'className': "text-center", data: 'supplier_tel', name: 'supplier_tel' },
				{ 'className': "text-center", data: 'supplier_email', name: 'supplier_email' },
				{ 'className': "text-center", data: 'supplier_tax', name: 'supplier_tax' },
				{ 'className': "text-center", data: 'created_at', name: 'created_at' },
			],
			order: [[0, 'asc']],
			rowCallback: function(row,data,index ){
				var btndel = '';
                var permissiondel = "{{Auth::user()->actiondelete}}";
                var permissionedit = "{{Auth::user()->actionedit}}";
                if( permissiondel != ''){
                	btndel = ' <i class="icon-trash" onclick="del('+data['supplier_id']+');" data-popup="tooltip" title="Delete"></i>';
                }
                var btnedit = '';
                if(permissionedit !=''){
                	btnedit = ' <a href="supplier/update/'+data['supplier_id']+'"><i class="icon-pencil7" data-popup="tooltip" title="Update"></i></a>';
                }
				$('td:eq(5)', row).html(btnedit + btndel );
                /*<a href="supplier/product/'+data['supplier_id']+'" class="btn btn-info btn-rounded"><i class="icon-display4"></i> รายการสินค้า</a>*/
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
					window.location.href="supplier-delete/"+id+"";
				}
			}
		});
	}
</script>
@stop