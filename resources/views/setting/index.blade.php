@extends('../template')

@section('content')
	<!-- Page header -->
	<!--<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Product / Create
				</h4>
			</div>
		</div>-->
	<!-- /page header -->


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
							
							<form method="post" action="{{url('setting_update')}}" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6 col-md-6 col-md-offset-3">
										<fieldset>
											<legend class="text-semibold">รายละเอียด การตั้งค่า</legend>
											<div class="form-group">
												<label>โลโก้ :</label>
												<input type="file" class="file-input" name="fileupload">
												<span class="help-block">ขนาดรูป : 305 x 425px</span>
												@if(!empty($setting->set_logo))
													<br>
													<img src="{{asset('assets/images/setting')}}/{{$setting->set_logo}}" class="img-thumbnail" width="300px">
												@endif
											</div>
											
											<div class="form-group">
												<label>ชื่อบริษัท :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="compname" id="compname" placeholder="ชื่อบริษัท" required value="{{$setting->set_name}}">
												</div>
											</div>
											
											<div class="form-group">
												<label>ที่อยู่ :</label>
												<div class="input-control">
													<textarea class="form-control" name="compaddr" id="compaddr" rows="3" required>{{$setting->set_address}}</textarea>
												</div>
											</div>
											
											
											<div class="form-group">
												<label>สีเนวิเกชั่น :</label>
												<input type="color" name="color" placeholder="สีเนวิเกชั่น" class="form-control" value="{{$setting->set_nav}}">
											</div>
											
											<div class="form-group">
												<label>สีฟรอนต์เนวิเกชั่น :</label>
												<input type="color" name="colorfont" placeholder="สีฟรอนต์เนวิเกชั่น" class="form-control" value="{{$setting->set_navfont}}">
											</div>
											
											<div class="form-group">
												<label>สีฟรอนต์เมนู :</label>
												<input type="color" name="colormenu" placeholder="สีฟรอนต์เมนู" class="form-control" value="{{$setting->set_menu}}">
											</div>
											<div class="form-group">
												<label>ค่าเริ่มต้นกำไรที่ต้องการ(ขายปลีก) :</label>
												<input type="text" name="setprice" class="form-control" value="{{$setting->set_price}}">
											</div>
											<div class="form-group">
												<label>ค่าเริ่มต้นราคาขายส่ง1 :</label>
												<input type="text" name="setprice1" class="form-control" value="{{$setting->set_price1}}">
											</div>
											<div class="form-group">
												<label>ค่าเริ่มต้นราคาขายส่ง2 :</label>
												<input type="text" name="setprice2" class="form-control" value="{{$setting->set_price2}}">
											</div>
											<div class="form-group">
												<label>ค่าเริ่มต้นราคาขายส่ง3 :</label>
												<input type="text" name="setprice3" class="form-control" value="{{$setting->set_price3}}">
											</div>
										
											<br>
											<div class="text-right">
												@if(Auth::user()->actionedit != '')
												<a href="{{url('dashboard')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
												<button type="submit" class="btn btn-primary"><i class="icon-floppy-disk"></i>  บันทึก</button>
												@endif
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
	
</script>
@stop