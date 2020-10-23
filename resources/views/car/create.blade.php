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
							
							<form method="post" action="{{url('car/create')}}" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6 col-md-6 col-md-offset-3">
										<fieldset>
											<legend class="text-semibold">ข้อมูลรถยนต์</legend>
											<div class="form-group">
												<label>ทะเบียนรถ :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="text" id="text"  required placeholder="เช่น กก 8888 กรุงเทพมหานคร">
												</div>
											</div>
											<br>
											<div class="text-right">
												<a href="{{url('car')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
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
@stop