@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- <div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Sub Category
				</h4>
			</div>
		</div>
	</div> -->
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
								<div class="pull-right">
									<button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square"></i>  เพิ่ม</button>
								</div>
							</div>
							
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th class="text-center">ลำดับที่</th>
											<th class="text-center">หมวดหมู่สินค้า</th>
											<th class="text-center">รายการ</th>
											<th class="text-center">วันที่</th>
											<th class="text-center">#</th>
										</tr>
									</thead>
									<tbody>
										@php
										if($subcategory){
											$num = 1;
											foreach($subcategory as $rs){
												@endphp
												<tr>
													<td align="center">{{$num}}</td>
													<td>{{$rs->category_name}}</td>
													<td>{{$rs->sub_name}}</td>
													<td align="center">{{$rs->created_at}}</td>
													<td align="center">
														<i class="icon-pencil7" onclick="edit({{$rs->sub_id}});" data-popup="tooltip" title="Update"></i> <i class="icon-trash"  onclick="del({{$rs->sub_id}});" data-popup="tooltip" title="Delete"></i> 
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
						
						<form method="post" action="subcategory_create">
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
											<label>ชื่อหมวดหมู่ : </label>
											<select name="category" class="form-control" required>
												<option value="">Choose</option>
												@php
													if($category){
														foreach($category as $rs){
															@endphp
															<option value="{{$rs->category_id}}">{{$rs->category_name}}</option>
															@php
														}
													}
												@endphp
											</select>
										  </div>
										  
										  <div class="form-group">
											<label>ชื่อหมวดหมู่ย่อย : </label>
											<input type="text" class="form-control" name="subcategory" id="subcategory" required>
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
						
						
						<form method="post" action="subcategory_update">
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
											<label>ชื่อหมวดหมู่ : </label>
											<select name="category" id="category" class="form-control" required>
												<option value="">Choose</option>
												@php
													if($category){
														foreach($category as $rs){
															@endphp
															<option value="{{$rs->category_id}}">{{$rs->category_name}}</option>
															@php
														}
													}
												@endphp
											</select>
										  </div>
										  
										  <div class="form-group">
											<label>ชื่อหมวดหมู่ย่อย : </label>
											<input type="text" class="form-control" name="subcategoryedit" id="subcategoryedit" required>
											<input type="hidden" class="form-control" name="subcategoryidedit" id="subcategoryidedit">
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
		'url': "{{url('editsubcategory')}}",
		'data': {
			'id' : id,
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data) {
				$('#category').val(data.results.sub_ref);
				$('#subcategoryedit').val(data.results.sub_name);
				$('#subcategoryidedit').val(data.results.sub_id);
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