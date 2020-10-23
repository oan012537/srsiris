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
								<h3>ข้อมูลการสแกนกล่องขึ้นรถ</h3>
							</div>
							
							<div class="table-responsive">
								<table class="table datatable-basic">
									<thead>
										<tr>
											<th class="text-center" width="10%">ลำดับที่</th>
											<th class="text-center" width="13%">วันที่</th>
											<th class="text-center" width="20%">รหัสบิลที่สแกน</th>
											<th class="text-center" width="20%">รหัสกล่องที่สแกน</th>
											<th class="text-center" width="15%">จำนวนครั้งที่สแกน</th>
											<th class="text-center" width="22%">ผู้สแกน</th>
										</tr>
									</thead>
									<tbody>
										@php
										if($data){
											$num = 1;
											foreach($data as $rs){
												@endphp
												<tr>
													<td align="center">{{$num}}</td>
													<td align="center">{{$rs->scanboxputtingcar_date}}</td>
													<td align="center">{{$rs->scanboxputtingcar_ref}}</td>
													<td align="center">{{$rs->scanboxputtingcar_tax}}</td>
													<td align="center">{{$rs->scanboxputtingcar_count}}</td>
													<td align="center">{{$rs->name}}</td>
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