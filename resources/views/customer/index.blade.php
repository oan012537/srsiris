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
	<style type="text/css">
		.classcustomer{
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
									<a href="{{url('customer/create')}}"<button type="button" class="btn btn-success btn-lg"><i class="icon-plus-circle2"></i> เพิ่ม</button></a>
								</div>
								@endif
							</div>
							
							<table class="table" id="datatables">
								<thead>
									<tr>
										<th class="text-center" width="10%">ลำดับที่</th>
										<th class="text-center" width="20%">ชื่อลูกค้า</th>
										<th class="text-center" width="20%">ที่อยู่</th>
										<th class="text-center" width="15%">เบอร์ติดต่อ</th>
										<th class="text-center" width="15%">อีเมล์</th>
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
				url : "{{url('customerdatatables')}}",
			},
			columns: [
				{ 'className': "text-center", data: 'customer_id', name: 'customer_id' },
				{ data: 'customer_name', name: 'customer_name' },
				{ data: 'address', name: 'address' },
				{ 'className': "text-center", data: 'customer_tel', name: 'customer_tel' },
				{ data: 'customer_email', name: 'customer_email' },
				{ 'className': "text-center", data: 'created_at', name: 'created_at' },
			],
			order: [[1, 'asc']],
			rowCallback: function(row,data,index ){
				var btndel = '';
                var permissiondel = "{{Auth::user()->actiondelete}}";
                var permissionedit = "{{Auth::user()->actionedit}}";
                if( permissiondel != ''){
                	btndel = ' <i class="icon-trash" onclick="del('+data['customer_id']+');" data-popup="tooltip" title="Delete"></i>';
                }
                var btnedit = '';
                if(permissionedit !=''){
                	btnedit = ' <a href="customer/update/'+data['customer_id']+'"><i class="icon-pencil7"  data-popup="tooltip" title="Update"></i></a>';
                }

				$('td:eq(5)', row).html( '<a href="javascript:sharedmap('+"'"+data['lat']+','+data['lng']+"'"+')"><i class="icon-map5"  data-popup="tooltip" title="Map"></i></a>'+btnedit+btndel );
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
					window.location.href="customer-delete/"+id+"";
				}
			}
		});
	}
	function sharedmap(maps){
		window.open('https://www.google.com/maps/place/'+maps);
	}
</script>
@stop