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
		.classbillingnote{
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
								<form class="form-horizontal col-md-10" action="{{ url('billingnote/print') }}" method="post" target="_blank">
									{{ csrf_field() }}
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
												<div class="col-md-2">
													<div class="form-group">
														<select name="staus" class="form-control" id="staus">
															<option value=""> - </option>
															<!-- <option value="7">พิมพ์แล้ว</option> -->
															<option value="0">ยังไม่ได้ชำระ</option>
															<option value="2">มียอดค้างชำระ</option>
															<option value="1">ชำระเรียบร้อย</option>
														</select>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<select name="area" class="form-control" id="area">
															<option value=""> - </option>
															@if(!empty($area))
															@foreach($area as $item)
															<option value="{{ $item->area_id }}">{{ $item->area_name }}</option>
															@endforeach
															@endif
														</select>
													</div>
												</div>
												<div class="col-md-1">
													<div class="form-group">
														<button type="button" id="searchdata" class="btn btn-primary"><i class="icon-folder-search"></i> ค้นหา</button>
													</div>
												</div>
												<div class="col-md-1">
													<div class="form-group">
														<button type="submit" class="btn btn-primary"><i class="icon-printer"></i> พิมพ์</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
								@if(Auth::user()->actionadd != '')
								<div class="col-md-2 pull-right" style="text-align: right;">
									<a href="{{url('billingnote/create')}}"><button type="button" class="btn btn-success"><i class="icon-plus-circle2"></i> จัดทำใบเก็บเงิน</button></a>
								</div>
								@endif
							</div>
							
							<table class="table" id="datatables">
								<thead>
									<tr>
										<th class="text-center" width="10%">ลำดับ</th>
										<th class="text-center" width="15%">เลขที่ออเดอร์</th>
										<th class="text-center" width="8%">วันที่</th>
										<th class="text-center" width="12%">ลูกค้า</th>
										<th class="text-center" width="8%">จำนวนบิล</th>
										<th class="text-center" width="10%">สถานะ</th>
										<th class="text-center" width="9%">ชำระแล้ว</th>
										<th class="text-center" width="9%">คงเหลือ</th>
										<th class="text-center" width="9%">รวม</th>
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
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">ออเดอร์</h4>
			</div>
			<div class="modal-body">
			  <table class="table table-bordered" id="showdata">
				<thead>
					<tr>
						<th class="text-center">ลำดับ</th>
						<th class="text-center">ออเดอร์</th>
						<th class="text-center">วันที่</th>
						<th class="text-center">ลูกค้า</th>
						<th class="text-center">สถานะ</th>
						{{-- <th class="text-center">#</th> --}}
					</tr>
				</thead>
				<tbody id="rowdataselling">
					
				</tbody>
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
				url : "{{url('/billingnote/datatable')}}",
				data: function (d) {
					d.noorder = $('#noorder').val();
					d.datestart = $('#datestart').val();
					d.dateend = $('#dateend').val();
					d.staus = $('#staus').val();
					d.area = $('#area').val();
				},
			},
			columns: [
				{ 'className': "text-center", data: 'billingnote_id', name: 'billingnote_id' },
				{ 'className': "text-center", data: 'billingnote_inv', name: 'billingnote_inv' },
				{ 'className': "text-center", data: 'billingnote_date', name: 'billingnote_date' },
				{ 'className': "text-center", data: 'customername', name: 'customername' },
				{ 'className': "text-center", data: 'count', name: 'count' },
				{ 'className': "text-center", data: 'billingnote_status', name: 'billingnote_status' },
				{ 'className': "text-center", data: 'billingnote_pay', name: 'billingnote_pay' },
				{ 'className': "text-center", data: 'billingnote_balance', name: 'billingnote_balance' },
				{ 'className': "text-center", data: 'billingnote_total', name: 'billingnote_total' },
				{ 'className': "text-center", data: 'created_at', name: 'created_at' },
			],
			order: [[1, 'desc']],
			rowCallback: function(row,data,index ){
				var btndel = '';
                var permissiondel = "{{Auth::user()->actiondelete}}";
                var permissionedit = "{{Auth::user()->actionedit}}";
                if( permissiondel != ''){
                	btndel = ' <i class="icon-trash" onclick="del('+data['billingnote_id']+');" data-popup="tooltip" title="Delete"></i>';
                }
                var btnedit = '';
                if(permissionedit !=''){
                	btnedit = ' <a href="{{url("/billingnote/update")}}/'+data['billingnote_id']+'"><i class="icon-pencil7" data-popup="tooltip" title="Update"></i></a>';
                }

				var status = '<span class="label bg-danger-400">ยังไม่ชำระเงิน</span>';

				if(data['billingnote_status'] == 1){
					var status = '<span class="label bg-success-400">ชำระเงินแล้ว</span>';
				}else if(data['billingnote_status'] == 2){
					var status = '<span class="label bg-warning-400">ค้างชำระ</span>';
				}
				var total = 0;
				total = parseFloat(total) + parseFloat(data['export_totalpayment']);
				$('td:eq(5)', row).html(status);
				// $('td:eq(4)', row).html(total);
				$('td:eq(9)', row).html('<a href="{{url("/billingnote/view")}}/'+data['billingnote_id']+'"><i class="icon-search4" data-popup="tooltip" title="View"></i></a> <a href="{{url("/billingnote/pdf")}}/'+data['billingnote_id']+'" target="_blank"><i class="icon-magazine" data-popup="tooltip" title="PDF"></i></a> '+btnedit+' <i onclick="viewmodal('+data['billingnote_id']+');" class="icon-eye" data-popup="tooltip" title="viewdata"></i> '+btndel );
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
					window.location.href="billingnote/delete/"+id;
				}
			}
		});
	}
	function viewmodal(id){
		$.post('{{url('/billingnote/viewmodal')}}', {'id': id,'_token': "{{ csrf_token() }}"}, function(data, textStatus, xhr) {
			var txt = '';
			data.forEach(function(value,index){
				if(value['selling_status'] == '7'){var status = 'ยังไม่ชำระเงิน'}else{var status = 'ชำระเรียบร้อย'}
				txt += '<tr>';
				txt += '<td>'+(index+1)+'</td>';
				txt += '<td>'+value['selling_inv']+'</td>';
				txt += '<td>'+value['selling_date']+'</td>';
				txt += '<td>'+value['selling_empname']+'</td>';
				txt += '<td>'+status+'</td>';
				txt += '</tr>';
			});
			/*optional stuff to do after success */
			$("#rowdataselling").empty().append(txt);
			$('#myModal').modal('show');
		});
	}
</script>
@stop