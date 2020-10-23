@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- <div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Category
				</h4>
			</div>
		</div>
	</div>-->
	<!-- /page header -->
	<style type="text/css">
		.classcategory{
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
									<button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square"></i>  เพิ่ม</button>
								</div>
								@endif
							</div>
							
							<div class="table-responsive">
								<table class="table datatable-basic">
									<thead>
										<tr>
											<th class="text-center">ลำดับที่</th>
											<th class="text-center">รหัส</th>
											<th class="text-center">รายการ</th>
											<th class="text-center">วันที่</th>
											<th class="text-center">#</th>
										</tr>
									</thead>
									<tbody>
										@php
										if($category){
											$num = 1;
											foreach($category as $rs){
												@endphp
												<tr>
													<td align="center">{{$num}}</td>
													<td>{{$rs->category_code}}</td>
													<td>{{$rs->category_name}}</td>
													<td align="center">{{$rs->created_at}}</td>
													<td align="center">
														@if(Auth::user()->actionedit != '')
														<i class="icon-pencil7"  onclick="edit({{$rs->category_id}});" data-popup="tooltip" title="Update"></i>
														@endif
														@if(Auth::user()->actiondelete != '')
														<i class="icon-trash"  onclick="del({{$rs->category_id}});" data-popup="tooltip" title="Delete"></i> 
														@endif
													</td>
												</tr>
												@php
												$num++;
											}
										}
										@endphp
									</tbody>
								</table>
							</div>
						</div>
						
						<form method="post" action="category_create">
						{{ csrf_field() }}
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">เพิ่ม</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="form-group">
											<label>รหัสหมวดหมู่ : </label>
											<input type="text" class="form-control" name="codecategory" id="codecategory" required maxlength="2">
										</div>
										<div class="form-group">
											<label>ชื่อหมวดหมู่ : </label>
											<input type="text" class="form-control" name="category" id="category" required>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">ปิด</button>
										<button type="submit" class="btn btn-primary waves-effect waves-light ">บันทึก</button>
									</div>
								</div>
							</div>
						</div>
						</form>			
						
						
						<form method="post" action="category_update">
						{{ csrf_field() }}
						<div class="modal fade" id="myModaledit" tabindex="-1" role="dialog">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">แก้ไข</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="form-group">
											<label>รหัสหมวดหมู่ : </label>
											<input type="text" class="form-control" name="codecategoryedit" id="codecategoryedit" required maxlength="2">
										</div>
										<div class="form-group">
											<label>ชื่อหมวดหมู่ : </label>
											<input type="text" class="form-control" name="categoryedit" id="categoryedit" required>
											<input type="hidden" class="form-control" name="categoryidedit" id="categoryidedit">
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">ปิด</button>
										<button type="submit" class="btn btn-primary waves-effect waves-light ">บันทึก</button>
									</div>
								</div>
							</div>
						</div>
						</form>			
				
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
	function edit(id){
		$.ajax({
		'dataType': 'json',
		'type': 'post',
		'url': "{{url('editcategory')}}",
		'data': {
			'id' : id,
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data) {
				$('#codecategoryedit').val(data.category_code);
				$('#categoryedit').val(data.category_name);
				$('#categoryidedit').val(data.category_id);
				$('#myModaledit').modal('show');
			}
		});
	}
	
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
					window.location.href="category-delete/"+id+"";
				}
			}
		});
	}
</script>
@stop