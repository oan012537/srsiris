@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- /page header -->
	<style type="text/css">
		.classuser{
			background: rgb(199,199,199,0.3);
		}
	</style>
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
														<input type="text" name="name" id="name" class="form-control" placeholder="ชื่อ-นามสกุล">
													</div>
												</div>
												{{-- <div class="col-md-3">
													<div class="form-group">
														<input type="text" name="lastname" id="lastname" class="form-control" placeholder="นามสกุล">
													</div>
												</div> --}}
												<div class="col-md-3">
													<div class="form-group">
														<select name="staus" class="form-control" id="staus">
															<option value=""> - </option>
															<option value="1">ใช้งาน</option>
															<option value="0">ยกเลิก</option>
														</select>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<select name="position" class="form-control" id="position">
															<option value=""> - </option>
															@if(!empty($data))
															@foreach ($data as $val)
															<option value="{{ $val->position_id }}"> {{ $val->position_name }} </option>
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
											</div>
										</div>
									</div>
								</form>
								<div class="col-md-3 pull-right" style="text-align: right;">
									@if(Auth::user()->actionadd != '')
									<a href="{{url('users/create')}}"><button type="button" class="btn btn-success"><i class="icon-plus-circle2"></i> เพิ่ม</button></a>
									@endif
								</div>
							</div>
							
							<table class="table" id="datatables">
								<thead>
									<tr>
										<th class="text-center">ID</th>
										<th class="text-center">ชื่อ</th>
										<th class="text-center">E-mail</th>
										<th class="text-center">เบอร์โทร</th>
										<th class="text-center">สถานะ</th>
										<th class="text-center">#</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
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
				url : "{{url('users/datatables')}}",
				data: function (d) {
					d.name = $('#name').val();
					// d.lastname = $('#lastname').val();
					d.staus = $('#staus').val();
					d.position = $('#position').val();
				},
			},
			columns: [
				{ 'className': "text-center", data: 'id', name: 'id' },
				{ 'className': "text-center", data: 'name', name: 'name' },
				{ 'className': "text-center", data: 'email', name: 'email' },
				{ 'className': "text-center", data: 'phone', name: 'phone' },
				{ 'className': "text-center", data: 'status', name: 'status' },
				{ 'className': "text-center", data: 'updated_at', name: 'updated_at' },
			],
			order: [[0, 'asc']],
			rowCallback: function(row,data,index ){
				$('td:eq(0)', row).html(index+1);
				var status = '';
				// if(data['product_status'] > 0){ //อันเก่า
				if(data['status'] == 1){
					// var status = '<span class="label bg-success-400">ใช้งาน</span>';
				}else if(data['status'] == 0){
					var status = '<span class="label bg-warning-400">ยกเลิก</span>';
				}
				$('td:eq(4)', row).html(status);
				var btndel = '';
                var permissiondel = "{{Auth::user()->actiondelete}}";
                var permissionedit = "{{Auth::user()->actionedit}}";
                if( permissiondel != ''){
                	btndel = ' <i class="icon-cancel-square" onclick="del('+data['id']+');" data-popup="tooltip" title="ยกเลิก"></i>';
                }
                var btnedit = '';
                if(permissionedit !=''){
                	btnedit = ' <a href="{{url("users/update")}}/'+data['id']+'"><i class="icon-pencil7" data-popup="tooltip" title="อัพเดท"></i></a>';
                }

				// $('td:eq(5)', row).html( '<i class="icon-mailbox" data-popup="tooltip" title="Mail" onclick="mail('+data['export_id']+');"></i> <i class="icon-magazine" data-popup="tooltip" title="Bill" onclick="openbill('+data['export_id']+');"></i> <a href="{{url("export-update")}}/'+data['export_id']+'"><i class="icon-pencil7" data-popup="tooltip" title="Update"></i></a> <i class="icon-trash" onclick="del('+data['export_id']+');" data-popup="tooltip" title="Delete"></i>' );
				if(data['id'] > 7){
					$('td:eq(5)', row).html(btnedit+btndel);
				}else{
					$('td:eq(5)', row).html('');
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
					window.location.href="users/remove/"+id+"";
				}
			}
		});
	}
</script>
@stop
