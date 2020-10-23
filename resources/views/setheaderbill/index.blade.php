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
							<form method="post" action="{{url('setheaderbill/create')}}" enctype="multipart/form-data">
							{{ csrf_field() }}
								<div class="panel-body">
									<div class="row">
										<div class="col-md-6 col-md-6 col-md-offset-3">
											<fieldset>
												<legend class="text-semibold">รายละเอียด การตั้งค่า</legend>
												<div class="form-group">
													<label>โลโก้บิลต้นฉบับ :</label>
													<input type="file" class="file-input" name="fileuploadraw">
													<span class="help-block">ขนาดรูป : 60 x 130px</span>
													@if(!empty($setting->setheadbill_logoraw))
														<br>
														<img src="{{asset('assets/images/setting')}}/{{$setting->setheadbill_logoraw}}" class="img-thumbnail" width="300px">
													@endif
												</div>
												<div class="form-group">
													<label>โลโก้ :</label>
													<input type="file" class="file-input" name="fileupload">
													<span class="help-block">ขนาดรูป : 60 x 130px</span>
													@if(!empty($setting->setheadbill_logo))
														<br>
														<img src="{{asset('assets/images/setting')}}/{{$setting->setheadbill_logo}}" class="img-thumbnail" width="300px">
													@endif
												</div>
												<div class="form-group">
													<label>บรรยายรูปภาพ :</label>
													<div class="input-control">
														<input type="text" class="form-control" name="textlogo" id="textlogo" placeholder="บรรยายรูปภาพ" required value="{{$setting->setheadbill_textlogo}}">
													</div>
												</div>

												<div class="form-group">
													<label>หัวเรื่อง :</label>
													<div class="input-control">
														<input type="text" class="form-control" name="title" id="title" placeholder="ชื่อบริษัท" required value="{{$setting->setheadbill_title}}">
													</div>
												</div>
												
												<div class="form-group">
													<label>ที่อยู่(ไทย) :</label>
													<div class="input-control">
														<textarea class="form-control" name="addressth" id="addressth" rows="3" required>{{$setting->setheadbill_address_th}}</textarea>
													</div>
												</div>
												<div class="form-group">
													<label>ที่อยู่(อังกฤษ) :</label>
													<div class="input-control">
														<textarea class="form-control" name="addresseh" id="addresseh" rows="3" required>{{$setting->setheadbill_address_en}}</textarea>
													</div>
												</div>
												
												<div class="form-group">
													<label>เว็บไซต์ :</label>
													<input type="text" name="web" placeholder="เว็บไซต์" class="form-control" value="{{$setting->setheadbill_web}}">
												</div>
												
												<div class="form-group">
													<label>อีเมล์ :</label>
													<input type="text" name="email" placeholder="อีเมล์" class="form-control" value="{{$setting->setheadbill_email}}">
												</div>
												<div class="form-group">
													<label>เบอร์ติดต่อ :</label>
													<input type="text" name="tel" placeholder="เบอร์ติดต่อ" class="form-control" value="{{$setting->setheadbill_tel}}">
												</div>
												<div class="form-group">
													<label>แฟต :</label>
													<input type="text" name="fax" placeholder="แฟต" class="form-control" value="{{$setting->setheadbill_fax}}">
												</div>
												<div class="form-group">
													<label>ข้อมูลบัญชี :</label>
													<div class="input-control">
														<div class="col-md-10" style="padding-left: 0px;">
															<input type="text" name="dataaccount[]" value="{{ $dataaccounts[0]->setheadbillaccount_name}}" class="form-control">
															<input type="hidden" name="dataaccountid[]" value="{{$dataaccounts[0]->setheadbillaccount_id}}" class="form-control">
														</div>
														<div class="col-md-1">
															<input type="radio" name="selectaccount" style="margin: 10px 12px;" value="1" @if($setting->setheadbill_selectaccount == $dataaccounts[0]->setheadbillaccount_name) checked @endif>
														</div>
														<div class="col-md-1">
															<button type="button" class="btn btn-primary" onclick="addtextbox()"><i class="fa fa-plus-square"></i>  เพิ่ม</button>
														</div>
														<div class="formaddto">
															@foreach($dataaccounts as $key => $value)
															@if($key != 0)
															<label>&nbsp;</label>
															<div class="input-control">
																<div class="col-md-11" style="padding-left: 0px;">
																	<input type="text" name="dataaccount[]" value="{{$value->setheadbillaccount_name}}" class="form-control">
																	<input type="hidden" name="dataaccountid[]" value="{{$value->setheadbillaccount_id}}" class="form-control">
																</div>
																<div class="col-md-1"><input type="radio" name="selectaccount" style="margin: 10px 12px;" value="{{$key+1}}" @if($setting->setheadbill_selectaccount == $value->setheadbillaccount_name) checked @endif></div>
															</div>
															@endif
															@endforeach
														</div>
													</div>
												</div>
												<br>
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
								</div>
							</form>
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
	function addtextbox(){
		var len = $("input[name='selectaccount']").length;
		len = parseInt(len)+1;
		$(".formaddto").append('<label>&nbsp;</label><div class="input-control"><div class="col-md-11" style="padding-left: 0px;"><input type="text" name="dataaccount[]" value="" class="form-control"><input type="hidden" name="dataaccountid[]" value="" class="form-control"></div><div class="col-md-1"><input type="radio" name="selectaccount" style="margin: 10px 12px;" value="'+len+'"></div></div>');
	}
</script>
@stop