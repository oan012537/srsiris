@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- <div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Customer / Create
				</h4>
			</div>
		</div>
	</div>-->
	<!-- /page header -->
	<style type="text/css">
		.classuser{
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
							
							<form method="post" action="{{url('users/create')}}" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6 col-md-6 col-md-offset-3">
										<fieldset>
											<legend class="text-semibold">ข้อมูลผู้ใช้</legend>
											<div class="form-group">
												<label>ชื่อ-นามสกุล :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="name" id="name" required>
												</div>
											</div>
											<div class="form-group">
												<label>ตำแหน่ง :</label>
												<div class="input-control">
													<select name="position" class="form-control" id="position" required>
														<option value=""> - </option>
														@if(!empty($data))
														@foreach ($data as $val)
														<option value="{{ $val->position_id }}"> {{ $val->position_name }} </option>
														@endforeach
														@endif
													</select>
												</div>
											</div>
											<div class="form-group">
												<label>หมวดหมู่สินค้าที่ดูแล :</label>
												<div class="input-control">
													<select class="form-control" name="groupcategory" id="groupcategory" disabled>
														<option value="">ไม่ระบุ</option>
														@if(!empty($categorys))
														@foreach($categorys as $category)
														<option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
														@endforeach
														@endif
													</select>
												</div>
											</div>
											<div class="form-group">
												<label>เขตพื้นที่ดูแล :</label>
												<div class="input-control">
													<select class="form-control" name="groupcustomer" id="groupcustomer" disabled>
														<option value="">ไม่ระบุ</option>
														@if(!empty($area))
														@foreach($area as $item)
														<option value="{{ $item->area_id }}">{{ $item->area_name }}</option>
														@endforeach
														@endif
													</select>
												</div>
											</div>
											<div class="form-group">
												<label>เลขบัญชี :</label>
												<div class="input-control">
													<select class="form-control" name="accountarea" id="accountarea" disabled>
														<option value="">ไม่ระบุ</option>
														@if(!empty($dataaccount))
														@foreach($dataaccount as $dataaccounts)
														<option value="{{ $dataaccounts->setheadbillaccount_id }}">{{ $dataaccounts->setheadbillaccount_name }}</option>
														@endforeach
														@endif
													</select>
												</div>
											</div>
											<div class="form-group">
												<label>อีเมล์ :</label>
												<div class="input-control">
													<input type="email" class="form-control" name="email" id="email" required>
												</div>
											</div>
											<div class="form-group">
												<label>รูปภาพ :</label>
												<input type="file" class="file-input" name="image">
												<span class="help-block">ขนาดรูป : 305 x 425px</span>
											</div>
											<div class="form-group">
												<label>เบอร์ติดต่อ :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="tel" id="tel" maxlength="10" required>
												</div>
											</div>
											<div class="form-group">
												<label>รหัสผ่าน :</label>
												<div class="input-control">
													<input type="password" class="form-control" name="password" id="password" minlength="6" required>
												</div>
											</div>
											<div class="form-group">
												<label>สิทธิ์การเพิ่มข้อมูล :</label>
												{{-- <div class="input-control"> --}}
													<input type="checkbox" name="actionadd" id="actionadd" value="1">
												{{-- </div> --}}
											</div>
											<div class="form-group">
												<label>สิทธิ์การแก้ไขข้อมูล :</label>
												{{-- <div class="input-control"> --}}
													<input type="checkbox" name="actionedit" id="actionedit" value="1">
												{{-- </div> --}}
											</div>
											<div class="form-group">
												<label>สิทธิ์การลบข้อมูล :</label>
												{{-- <div class="input-control"> --}}
													<input type="checkbox" name="actiondelete" id="actiondelete" value="1">
												{{-- </div> --}}
											</div>
											<br>
											<div class="text-right">
												<a href="{{url('customer')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
												<button type="submit" class="btn btn-primary"><i class="icon-floppy-disk"></i>  บันทึก</button>
											</div>
										</fieldset>
									</div>
								</div>
								</form>
							</div>
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
	$("#position").change(function(event) {
		if($(this).val() == '4'){
			$("#groupcustomer").prop('disabled',false);
			$("#accountarea").prop('disabled',false).val('');
			$("#groupcategory").prop('disabled',true).val('');
		}else if($(this).val() == '3' || $(this).val() == '6'){
			$("#groupcategory").prop('disabled',false);
			$("#groupcustomer").prop('disabled',true).val('');
			$("#accountarea").prop('disabled',true).val('');
		}else{
			$("#groupcustomer").prop('disabled',true).val('');
			$("#groupcategory").prop('disabled',true).val('');
			$("#accountarea").prop('disabled',true).val('');
		}
	});
</script>
@stop