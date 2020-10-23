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
		.classorder{
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
								<div class="pull-right">
									<a href="{{url('order/create')}}"<button type="button" class="btn btn-success btn-lg"><i class="icon-plus-circle2"></i> เพิ่ม</button></a>
								</div>
							</div>
							
							<table class="table" id="datatables">
								<thead>
									<tr>
										<th class="text-center" width="10%">ลำดับ</th>
										<th class="text-center" width="20%">เลขที่ออเดอร์</th>
										<th class="text-center" width="20%">วันที่</th>
										<th class="text-center" width="20%">สถานะ</th>
										<th class="text-center" width="15%">รวม</th>
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
				url : "{{url('orderdatatables')}}",
			},
			columns: [
				{ 'className': "text-center", data: 'export_id', name: 'export_id' },
				{ 'className': "text-center", data: 'export_inv', name: 'export_inv' },
				{ 'className': "text-center", data: 'export_date', name: 'export_date' },
				{ 'className': "text-center", data: 'export_status', name: 'export_status' },
				{ 'className': "text-center", data: 'export_totalpayment', name: 'export_totalpayment' },
				{ 'className': "text-center", data: 'updated_at', name: 'updated_at' },
			],
			order: [[0, 'asc']],
			rowCallback: function(row,data,index ){
				var dates = moment().format("YYYY-MM-DD");
				var countdate = moment(data['created_at']).add(3, 'months').format("YYYY-MM-DD");
				if(dates >= countdate){
					$(row).css('background', '#ff5555');
				}
				var status = '<span class="label bg-success-400">POS</span>';
				// if(data['product_status'] > 0){ //อันเก่า
				if(data['export_status'] > 0){
					var status = '<span class="label bg-danger">Export</span>';
				}
				$('td:eq(3)', row).html(status);
				$('td:eq(5)', row).html( '<i class="icon-mailbox" data-popup="tooltip" title="Mail" onclick="mail('+data['export_id']+');"></i> <i class="icon-magazine" data-popup="tooltip" title="Bill" onclick="openbill('+data['export_id']+');"></i> <a href="{{url("order/update")}}/'+data['export_id']+'"><i class="icon-pencil7" data-popup="tooltip" title="Update"></i></a> <i class="icon-trash" onclick="del('+data['export_id']+');" data-popup="tooltip" title="Delete"></i>' );
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
					window.location.href="export-delete/"+id+"";
				}
			}
		});
	}
	function openbill(id){
		window.open("export-bill/"+id);
	}
	function mail(id){
		// window.open("export-mail/"+id);
		run_waitMe($('body'), 3, 'roundBounce');
		$.ajax({
			url : "{{url('export-mail')}}/"+id,
			// datatype:'json',
			success:function(data){
				// console.log(data)
				$('body').waitMe('hide');
				if(data == 'y'){
					Lobibox.notify('success',{
						msg: 'Success send email',
						buttonsAlign: 'center',
						closeOnEsc: true,  
					});
				}else{
					Lobibox.notify('error',{
						msg: 'Error send email',
						buttonsAlign: 'center',
						closeOnEsc: true,  
					});
				}
			}
		});
	}
</script>
@stop