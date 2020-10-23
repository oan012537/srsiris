@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- <div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Selling - Export / Create
				</h4>
			</div>
		</div>
	</div>-->
	<!-- /page header -->
    <style type="text/css">
        .classreport{
            background: rgb(199,199,199,0.3);
        }
    </style>

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">
		
			<!-- Main content -->
			<div class="content-wrapper">
			<form id="myForm" method="post" action="{{url('exportpdf')}}" target="_blank">
				{{ csrf_field() }}
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
								<div class="row">
									<div class="col-md-12">
										<fieldset>
											<legend class="text-semibold"><i class="icon-stack2"></i> รายงานนำออก</legend>
											<div class="row">
												<div class="col-md-2">
													<div class="form-group">
														<label>ตั้งแต่วันที่ :</label>
														<input type="text" placeholder="ตั้งแต่วันที่" class="form-control datepicker-dates" name="datestart" id="datestart" value="{{date('d/m/Y')}}" autocomplete="off">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label>ถึงวันที่ :</label>
														<input type="text" placeholder="ถึงวันที่" class="form-control datepicker-dates" name="dateend" id="dateend" value="{{date('d/m/Y')}}" autocomplete="off">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label>&nbsp;</label><br>
														<button type="button" id="searchdata" class="btn btn-success"><i class="icon-folder-search position-left"></i>  ค้นหา</button>
													</div>
												</div>
												
												<div class="col-md-2 pull-right">
													<div class="form-group">
														<label>&nbsp;</label><br>
														<button type="submit" id="printer" class="btn btn-primary btn-lg"><i class="icon-printer2"></i> พิมพ์รายงาน</button>
														<button type="button" id="excel" class="btn btn-primary btn-lg"><i class="icon-file-excel"></i> Excel</button>
													</div>
												</div>
											</div>
										
											
										</fieldset>
									</div>
									
									
						
								</div>
							</div>
						</div>
						<!-- /vertical form -->
						
						<!-- Vertical form options -->
						<div class="row">
							<div class="col-md-12">
								<!-- Basic layout-->
									<div class="panel panel-flat">
										<div class="panel-heading">
											<h5 class="panel-title">รายละเอียดสินค้า</h5>
											<div class="heading-elements">
												<ul class="icons-list">
													<li><a data-action="collapse"></a></li>
													<li><a data-action="reload"></a></li>
													<li><a data-action="close"></a></li>
												</ul>
											</div>
										</div>

										<div class="panel-body">
											<div class="row">
												<div class="col-md-12">
													<table id="myTable" class="table table-bordered">
														<thead>
															<tr>
																<th class="text-center">ลำดับ</th>
																<th class="text-center">เลขที่ออเดอร์</th>
																<th class="text-center">วันที่</th>
																<th class="text-center">รหัสสินค้า</th>
																<th class="text-center">รายการสินค้า</th>
																<th class="text-center" style="width:150px;">หน่วยนับ</th>
																<th class="text-center" style="width:100px;">Lot ราคา</th>
																<th class="text-center">จำนวน</th>
																<th class="text-center">สถานะ</th>
															</tr>
														</thead>
														<tbody id="rowdata"></tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								<!-- /basic layout -->
							</div>
						</div>
						<!-- /vertical form options -->
						</form>	
					</div>
				</div>
			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
<script>
	$(document).ready(function(){
		$('#rowdata').append('<tr id="firstauto"><td colspan="9" align="center">-- No data --</td></tr>');
	});
	
	$('#searchdata').click(function(){
		$.ajax({
		'type': 'post',
		'url': "{{url('reportdataexport')}}",
		'dataType': 'json',
		'data': {
			'start': $('#datestart').val(),
			'end': $('#dateend').val(),
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data){
				var sumtotal 	= 0;
				var count 	= data.length;
				if(count > 0){
					$('#firstauto').closest( 'tr').remove();
					$('.rowbody').closest( 'tr').remove();
					
					var num = 1;
					var text = '';
					var totalqty = 0;
					
					$.each(data,function(key,item){
						totalqty += parseInt(item.qty);
						text += '<tr class="rowbody">'
							+'<td align="center">'+num+'</td>'
							+'<td align="left">'+item.inv+'</td>'
							+'<td align="center">'+item.date+'</td>'
							+'<td align="left">'+item.code+'</td>'
							+'<td align="left">'+item.name+'</td>'
							+'<td align="center">'+item.unit+'</td>'
							+'<td align="center">'+item.lot+'</td>'
							+'<td align="center">'+item.qty+'</td>'
							+'<td align="center">'+item.status+'</td>'
						+'</tr>';
						
						num++;
					});
					$('#rowdata').append(text);
				}else{
					$('#firstauto').closest( 'tr').remove();
					$('#rowdata').append('<tr id="firstauto"><td colspan="9" align="center">-- No data --</td></tr>');
				}
			}
		});
	});
	
$('#excel').click(function(){
	var strs 	= $('#datestart').val();
	var startd 	= strs.substr(0,2);
	var startm 	= strs.substr(3,2);
	var starty 	= strs.substr(6,4);
	var starts 	= startd+'-'+startm+'-'+starty;
	
	var stre 	= $('#dateend').val();
	var endd 	= stre.substr(0,2);
	var endm 	= stre.substr(3,2);
	var endy 	= stre.substr(6,4);
	
	var ends 	= endd+'-'+endm+'-'+endy;
	
	window.open('{{url("exportexcel")}}/'+starts+'/'+ends,'_blank');
});
</script>
@stop