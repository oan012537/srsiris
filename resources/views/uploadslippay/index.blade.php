@extends('../template')

@section('content')
	<!-- Page header -->
	<!--<div class="page-header">
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
		.classuploadslippay{
			background: rgb(199,199,199,0.3);
		}
		.forcheck,.forbank{
			display: none;
		}
		.notclick{
			pointer-events: none;
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
								<form class="form-horizontal col-md-10" action="#">
									<div class="form-group">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-md-2">
													<div class="form-group">
														<input type="text" name="noorder" id="noorder" class="form-control" placeholder="เลขที่ออเดอร์">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<input type="text" name="datestart" id="datestart" class="form-control datepicker-dates" placeholder="วันที่เริ่มต้น" autocomplete="off">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<input type="text" name="dateend" id="dateend" class="form-control datepicker-dates" placeholder="วันที่สิ้นสุด" autocomplete="off">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<select name="customer" class="form-control" id="customer">
															<option value=""> - </option>
															@foreach($customer as $key => $val)
															<option value="{{$val->customer_id}}">{{$val->customer_name}}</option>
															@endforeach
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
							</div>
							
							<table class="table" id="datatables">
								<thead>
									<tr>
										<th class="text-center" width="10%">#</th>
										<th class="text-center" width="10%">เลขที่ออเดอร์</th>
										<th class="text-center" width="10%">วันที่</th>
										<th class="text-center" width="15%">ลูกค้า</th>
										<th class="text-center" width="15%">จำนวนเงิน</th>
										<th class="text-center" width="10%">รูปภาพ</th>
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
	$('#seaechstartdate,#seaechenddate,#date,#datestart,#dateend').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('.modal-child').on('show.bs.modal', function () {
	    var modalParent = $(this).attr('data-modal-parent');
	    $(modalParent).css('opacity', 0);
	});
 
	$('.modal-child').on('hidden.bs.modal', function () {
	    var modalParent = $(this).attr('data-modal-parent');
	    $(modalParent).css('opacity', 1);
	});
	function formatNumber (x) {
		return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	var arrayselectbox = [];
	var txtselectbox = '';
	$(document).ready(function(){
		var oTable = $('#datatables').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: false,
			ajax:{ 
				url : "{{url('uploadslippay/datatables')}}",
				data: function (d) {
					d.noorder = $('#noorder').val();
					d.datestart = $('#datestart').val();
					d.dateend = $('#dateend').val();
					d.customer = $('#customer').val();
				},
			},
			columns: [
				{ 'className': "text-center", data: 'payment_id', name: 'payment_id' },
				{ 'className': "text-center", data: 'order_no', name: 'order_no' },
				{ 'className': "text-center", data: 'payment_datetime', name: 'payment_datetime' },
				{ 'className': "text-center", data: 'export_customername', name: 'export_customername' },
				{ 'className': "text-center", data: 'payment_amount', name: 'payment_amount' },
				{ 'className': "text-center", data: 'payment_slip', name: 'payment_slip' },
				{ 'className': "text-center", data: 'payment_slip', name: 'payment_slip' },
			],
			order: [[0, 'desc']],
			rowCallback: function(row,data,index ){
				$('td:eq(5)', row).html('<a data-fancybox="images" class="fancybox" href="{{asset('../srsiri_ci/uploads/slip')}}/'+data['payment_slip']+'" style="width:500px;"><img width="150px" height="150px" src="{{asset('../srsiri_ci/uploads/slip')}}/'+data['payment_slip']+'"></a>');
				$('td:eq(6)', row).html('<button type="button" class="btn btn-primary" onclick="approve(this.value)" value="'+data['payment_id']+'">อนุมัติ</button>');
			}
		});
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
	function approve(id){
		$.get("{{url('uploadslippay/approve')}}/"+id, function(data, textStatus, xhr) {
			
		});
	}
</script>
@stop