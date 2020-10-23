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
			<form id="myForm" method="post" action="{{url('reportorderpdf')}}" target="_blank">
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
											<legend class="text-semibold"><i class="icon-stack2"></i> รายงานออเดอร์</legend>
											<div class="row">
												<div class="col-md-2">
													<div class="form-group">
														<label>ตั้งแต่วันที่ :</label>
														<input type="text" placeholder="ตั้งแต่วันที่" class="form-control datepicker-dates" onkeypress="return false;" name="datestart" id="datestart" value="" autocomplete="off">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label>ถึงวันที่ :</label>
														<input type="text" placeholder="ถึงวันที่" class="form-control datepicker-dates" onkeypress="return false;" name="dateend" id="dateend" value="" autocomplete="off">
													</div>
												</div>
												<div class="col-md-2">
	                                                <div class="form-group">
	                                                    <label>ชื่อผู้ผลิต :</label>
	                                                    <select class="form-control select2" name="namesupplier" id="namesupplier">
	                                                        <option value="" selected>ชื่อ</option>
	                                                        @if(!empty($data))
	                                                        @foreach($data as $item)
	                                                            <option value="{{ $item->supplier_id}}">{{ $item->supplier_name}}</option>
	                                                            @endforeach
	                                                        @endif
	                                                    </select>
	                                                </div>
	                                            </div>
												<div class="col-md-2">
													<div class="form-group">
														<label>ประเภท :</label>
														<select class="form-control" name="producttype" id="producttype">
	                                                        <option value="" > เลือกประเภท </option>
	                                                        <option value="2" >สินค้าผลิตเอง</option>
	                                                        <option value="1" >สินค้าซื้อเข้ามา</option>
	                                                    </select>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label>&nbsp;</label><br>
														<button type="button" id="searchdata" class="btn btn-success"><i class="icon-folder-search position-left"></i>  ค้นหา</button>
													</div>
												</div>
												
												<div class="col-md-3 pull-right">
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
												<div class="col-md-12 table-responsive">
													<table id="myTable" class="table table-bordered">
														<thead>
															<tr>
																<th class="text-center">ลำดับ</th>
																<th class="text-center">รหัสสินค้า</th>
																<th class="text-center">ชื่อสินค้า</th>
																<th class="text-center">ประเภท</th>
																<th class="text-center">ชื่อซัฟพลายเออร์</th>
																<th class="text-center">เบอร์</th>
																<th class="text-center">จำนวนหน่วยใหญ่</th>
																<th class="text-center">จำนวนหน่วยย่อย</th>
																<th class="text-center">วันที่สั่ง</th>
																<th class="text-center">วันที่ส่ง</th>
																<th class="text-center">จำนวนสินค้าทั้งหมด</th>
															</tr>
														</thead>
														<tbody id="rowdata"></tbody>
														<tfoot id="rowfoot"></tfoot>
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
		$('.select2').select2();
		// $('#rowdata').append('<tr id="firstauto"><td colspan="9" align="center">-- No data --</td></tr>');
	});
	var oTable = $('#myTable').DataTable({
		processing: false,
		serverSide: false,
		searching: false,
		lengthChange: false,
	});
	$('#searchdata').click(function(){
		$.ajax({
		'type': 'post',
		'url': "{{url('reportorder')}}",
		'dataType': 'json',
		'data': {
			'start': $('#datestart').val(),
			'end': $('#dateend').val(),
			'namesupplier': $('#namesupplier').val(),
			'producttype': $('#producttype').val(),
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data){
				var sumtotal 	= 0;
				var count 	= data.results.length;

				if(count > 0){
					$('#firstauto').closest( 'tr').remove();
					$('.rowbody').closest( 'tr').remove();
					$('.rowfoot').closest( 'tr').remove();
					
					var num = 1;
					var text = '';
					oTable.rows().remove().draw();
					
					$.each(data.results,function(key,item){
						var suppliername= '';
						var suppliertel= '';
						$.each(item.supplier_name,function(key2,item2){
							if(item2.supplier_name){
								suppliername += item2.supplier_name;
								suppliertel += item2.supplier_tel;
								if(key2 != item.supplier_name.length-1){
									suppliername += ' , ';
									suppliertel += ' , ';
								}
							}
						});
						text += '<tr class="rowbody">'
							+'<td align="center">'+num+'</td>'
							+'<td align="left">'+item.code+'</td>'
							+'<td align="center">'+item.name+'</td>'
							+'<td align="center">'+item.typeproduct+'</td>'
							+'<td align="left">'+suppliername+'</td>'
							+'<td align="left">'+suppliertel+'</td>'
							+'<td align="right">'+item.bigunit+'</td>'
							+'<td align="right">'+item.smallunit+'</td>'
							+'<td align="center"></td>'
							+'<td align="center"></td>'
							// +'<td align="center">'+item.product_qty+'</td>'
						+'</tr>';
						oTable.row.add( [
				            num,
				            item.code,
				            item.name,
				            item.typeproduct,
				            suppliername,
				            suppliertel,
				            item.bigunit,
				            item.smallunit,
				            '',
				            '',
				            item.product_qty,
				        ] ).draw();
						num++;

					});
					// $('#rowdata').append(text);
					
					
					
				}else{
					$('#firstauto').closest( 'tr').remove();
					oTable.rows().remove().draw();
					// $('#rowdata').append('<tr id="firstauto"><td colspan="9" align="center">-- No data --</td></tr>');
				}
			}
		});
	});

	
$('#excel').click(function(){
	var strs 	= $('#datestart').val();
	var startd 	= strs.substr(0,2);
	var startm 	= strs.substr(3,2);
	var starty 	= strs.substr(6,4);
	var starts 	= starty+'-'+startm+'-'+startd;
	
	var stre 	= $('#dateend').val();
	var endd 	= stre.substr(0,2);
	var endm 	= stre.substr(3,2);
	var endy 	= stre.substr(6,4);
	
	var ends 	= endy+'-'+endm+'-'+endd;
	var producttype = $("#producttype").val();
	var namesupplier = $("#namesupplier").val();
	if(producttype == ''){
		producttype = '-';
	}
	if(namesupplier == ''){
		namesupplier = '-';
	}
	window.open('{{url("reportorderexportexcel")}}/'+starts+'/'+ends+'/'+producttype+'/'+namesupplier,'_blank');
});
</script>
@stop