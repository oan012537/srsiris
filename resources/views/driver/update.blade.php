@extends('../template')

@section('content')
	<!-- Page header -->
	<!--<div class="page-header">
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
							
							<form method="post" action="{{url('driver/update')}}" enctype="multipart/form-data">
							{{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$data->driver_id}}">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6 col-md-6 col-md-offset-3">
                                        <fieldset>
                                            <legend class="text-semibold">ข้อมูลพนักงานขับรถ</legend>
                                            <div class="form-group">
                                                <label>ชื่อ-สกุล :</label>
                                                <div class="input-control">
                                                    <input type="text" class="form-control" name="name" id="name" value="{{$data->driver_name}}" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>ที่อยู่ :</label>
                                                <div class="input-control">
                                                    <textarea name="address" class="form-control" required style="resize: vertical;" rows="3">{{$data->driver_address}}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>เบอร์ติดต่อ :</label>
                                                <div class="input-control">
                                                    <input type="text" class="form-control" name="tel" id="tel" value="{{$data->driver_tel}}" maxlength="10" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>อีเมล์ :</label>
                                                <div class="input-control">
                                                    <input type="text" class="form-control" name="email" id="email" value="{{$data->driver_email}}" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>เลขประจำตัวประชาชน :</label>
                                                <div class="input-control">
                                                    <input type="text" class="form-control" name="tax" id="tax" value="{{$data->driver_tax}}" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>วันที่เกิด :</label>
                                                <div class="input-control">
                                                    <input type="text" class="form-control  datepicker-dates" name="bdate" id="bdate" value="{{$data->driver_date}}" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>อายุ :</label>
                                                <div class="input-control">
                                                    <input type="number" class="form-control" name="age" id="age" value="{{$data->driver_age}}" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>วันที่เข้า :</label>
                                                <div class="input-control">
                                                    <input type="text" class="form-control  datepicker-dates" name="datein" id="datein" value="{{$data->driver_in}}" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>สถานะ :</label>
                                                <div class="input-control">
                                                    <select name="status" class="form-control">
                                                        <option value="1" @if($data->driver_status=='1')selected @endif>ใช้งานอยู่</option>
                                                        <option value="0" @if($data->driver_status=='0')selected @endif>ไม่ใช้แล้ว</option>
                                                        option
                                                    </select>
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
</script>
@stop