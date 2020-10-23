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
							
							<form method="post" action="{{url('groupcustomer/update')}}">
							{{ csrf_field() }}
							<input type="hidden" class="form-control" name="id" id="id" value="{{ $groupcustomer->groupcustomer_id }}">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6 col-md-6 col-md-offset-3">
										<fieldset>
											<legend class="text-semibold">ข้อมูลกลุ่มลูกค้า</legend>
											<div class="form-group">
												<label>ชื่อกลุ่มลูกค้า :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="name" id="name" value="{{ $groupcustomer->groupcustomer_text }}">
												</div>
											</div>
											<div class="form-group">
												<label>สถานะ :</label>
												<div class="input-control">
													<div class="radio">
														<label>
															<input type="radio" class="styled" name="status" id="status" value="1" checked="checked">ใช้งาน
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" class="styled" name="status" id="status" value="0">ยกเลิก
														</label>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>หมายเหตุ :</label>
												<div class="input-control">
                                                    <textarea name="note" class="form-control" style="resize: vertical;" rows="3">{{ $groupcustomer->groupcustomer_comment }}</textarea>
												</div>
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
	
</script>
@stop