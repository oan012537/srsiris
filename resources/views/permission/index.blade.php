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
								<fieldset>
									<legend><h3>ตำแหน่ง : {{ $position->position_name }}</h3></legend>
									<form class="form-horizontal col-md-12" method="post" action="{{url('permission/create')}}" id="formpermission">
										{{ csrf_field() }}
										<input type="hidden" name="positionid" id="positionid" value="{{ $position->position_id }}">
										<div class="form-group">
											<div class="col-md-4">
												<label>เมนู :</label>
												<select name="permission" class="form-control" id="permission" required="">
													<option value="" selected> - </option>
													@if(!empty($menu))
													@foreach($menu as $val)
													<option value="{{$val->menu_id}}">{{ $val->menu_name}}</option>
													@endforeach
													@endif
												</select>
											</div>
											<div class="col-md-1">
												<label>&nbsp;</label>
												<button class="btn btn-primary" type="submit"><i class="icon-plus2"></i> เพิ่มสิทธิ์การใช้งาน</button>
											</div>
											
										</div>
									</form>
								</fieldset>
							</div>
							
							<div class="table-responsive">
								<table class="table ">
									<thead>
										<tr>
											<th class="text-center">ลำดับที่</th>
											<th class="text-center">สิทธิ์การใช้งาน</th>
											<th class="text-center">วันที่สร้าง</th>
											<th class="text-center">วันที่แก้ไขล่าสุด</th>
											<th class="text-center">#</th>
										</tr>
									</thead>
									<tbody>
										@if(!empty($permission))
											@foreach($permission as $key => $rs)
												<tr>
													<td align="center">{{$key+1}}</td>
													<td>{{$rs->menu_name}}</td>
													<td align="center">{{$rs->created_at}}</td>
													<td align="center">{{$rs->updated_at}}</td>
													<td align="center">
														{{-- <button class="btn btn-warning" type="button" onclick="edit({{$rs->permission_id}});" data-popup="tooltip" title="แก้ไข"> <i class="icon-pencil7"></i> แก้ไข</button> --}}
														<button class="btn btn-danger" type="button" onclick="del({{$rs->permission_id}});" data-popup="tooltip" title="ลบ"> <i class="icon-trash"></i> ลบ</button>
														{{-- <i class="icon-pencil7"  onclick="edit({{$rs->position_id}});" data-popup="tooltip" title="Update"></i>  <i class="icon-trash"  onclick="del({{$rs->position_id}});" data-popup="tooltip" title="Delete"></i>  --}}
													</td>
												</tr>
											@endforeach
										@else
										<tr>
											<td rowspan ="5"> -- No Data --</td>
										</tr>
										@endif
									</tbody>
								</table>
							</div>
						</div>
						
						<form method="post" action="position/create">
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
											<label>ชื่อตำแหน่ง : </label>
											<input type="text" class="form-control" name="name" id="name" required>
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
						
						
						<form method="post" action="position/update">
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
											<input type="text" class="form-control" name="name" id="name" required>
											<input type="hidden" class="form-control" name="id" id="id">
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
					// window.location.href="position/cancel/"+id+"";
					window.location.href="del/"+id+"";
				}
			}
		});
	}
</script>
@stop