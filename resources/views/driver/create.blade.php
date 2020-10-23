@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- <div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Supplier / Create
				</h4>
			</div>
		</div>
	</div>-->
	<!-- /page header -->
    <style type="text/css">
        .classsupplier{
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
							
							<form method="post" action="{{url('driver/create')}}" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6 col-md-6 col-md-offset-3">
										<fieldset>
											<legend class="text-semibold">ข้อมูลพนักงานขับรถ</legend>
                                            <div class="form-group">
                                                <label>ชื่อ-สกุล :</label>
                                                <div class="input-control">
                                                    <input type="text" class="form-control" name="name" id="name" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>ที่อยู่ :</label>
                                                <div class="input-control">
                                                    <textarea name="address" class="form-control" required style="resize: vertical;" rows="3"></textarea>
                                                </div>
                                            </div>
											<div class="form-group">
												<label>เบอร์ติดต่อ :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="tel" id="tel" maxlength="10" required>
												</div>
											</div>
											<div class="form-group">
												<label>อีเมล์ :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="email" id="email" required>
												</div>
											</div>
                                            <div class="form-group">
												<label>เลขประจำตัวประชาชน :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="tax" id="tax" required>
												</div>
											</div>
                                            <div class="form-group">
                                                <label>วันที่เกิด :</label>
                                                <div class="input-control">
                                                    <input type="text" class="form-control  datepicker-dates" name="bdate" id="bdate" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>อายุ :</label>
                                                <div class="input-control">
                                                    <input type="number" class="form-control" name="age" id="age" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>วันที่เข้า :</label>
                                                <div class="input-control">
                                                    <input type="text" class="form-control  datepicker-dates" name="datein" id="datein" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>รถยนต์ :</label>
                                                <div class="input-control">
                                                    <input type="text" class="form-control" name="carname" id="carname" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>ทะเบียนรถ :</label>
                                                <div class="input-control">
                                                    <input type="text" class="form-control" name="cartext" id="cartext" required>
                                                </div>
                                            </div>
											<br>
											<div class="text-right">
												<a href="{{url('driver')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
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
    $('.datepicker-dates').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $("#bdate").change(function(event) {
        var years = moment().diff($(this).val(), 'years');
        $("#age").val(years);
    });
</script>
@stop