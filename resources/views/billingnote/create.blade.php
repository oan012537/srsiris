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
		.classbillingnote{
			background: rgb(199,199,199,0.3);
		}
	</style>

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">
		
			<!-- Main content -->
			<div class="content-wrapper">
			<form id="myForm" method="post" action="{{url('/billingnote/create')}}">
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
														<label>ชื่อลูกค้า :</label>
														<input type="text" placeholder="ชื่อลูกค้า" class="form-control" name="customer" id="customer"  autocomplete="off">
													</div>
												</div>
												<div class="col-md-2" style="display: none;">
													<div class="form-group">
														<label> &nbsp</label>
														<select name="area" class="form-control" id="area">
															<option value=""> - </option>
															@if(!empty($area))
															@foreach($area as $item)
															<option value="{{ $item->area_id }}">{{ $item->area_name }}</option>
															@endforeach
															@endif
														</select>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label>&nbsp;</label><br>
														<button type="button" id="searchdata" class="btn btn-success"><i class="icon-folder-search position-left"></i>  ค้นหา</button>
													</div>
												</div>

												<div class="pull-right">
													<button type="button" onclick="createbilling();" class="btn btn-success btn-lg"><i class="icon-plus-circle2"></i> บันทึก</button>
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
																<th class="text-center">#</th>
																<th class="text-center">ลำดับ</th>
																<th class="text-center">เลขที่ออเดอร์</th>
																<th class="text-center">ชื่อลูกค้า(ร้าน)</th>
																<th class="text-center">วันที่</th>
																{{-- <th class="text-center">รหัสสินค้า</th> --}}
																{{-- <th class="text-center">รายการสินค้า</th> --}}
																{{-- <th class="text-center" style="width:100px;">ราคาขาย</th> --}}
																{{-- <th class="text-center" style="width:100px;">ราคาซื้อ</th> --}}
																{{-- <th class="text-center">จำนวน</th> --}}
																<th class="text-center">รวม</th>
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
		$('#rowdata').append('<tr id="firstauto"><td colspan="10" align="center">-- No data --</td></tr>');
	});
	
	$('#searchdata').click(function(){
		$.ajax({
			'type': 'post',
			'url': "{{url('billingnote/reportdatasale')}}",
			'dataType': 'json',
			'data': {
				'start': $('#datestart').val(),
				'end': $('#dateend').val(),
				'customer': $('#customer').val(),
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
					
					$.each(data.sale,function(key,item){
						text += '<tr class="rowbody">'
							+'<td align="center"><input type="checkbox" name="selectbill[]" id="selectbill'+item.selling_id+'" value="'+item.selling_id+'"></td>'
							+'<td align="center">'+num+'</td>'
							+'<td align="left">'+item.selling_inv+'</td>'
							+'<td align="center">'+item.selling_customername+'</td>'
							+'<td align="center">'+item.selling_date+'</td>'
							// +'<td align="left">'+item.code+'</td>'
							// +'<td align="left">'+item.name+'</td>'
							// +'<td align="right">'+item.price+'</td>'
							// +'<td align="right">'+item.capital+'</td>'
							// +'<td align="center">'+item.qty+'  '+item.unit+'</td>'
							+'<td align="right">'+item.selling_totalpayment+'</td>'
						+'</tr>';
						
						num++;
					});
					// $.each(data.results,function(key,item){
					// 	text += '<tr class="rowbody">'
					// 		+'<td align="center">'+item.checkbox+'</td>'
					// 		+'<td align="center">'+num+'</td>'
					// 		+'<td align="left">'+item.inv+'</td>'
					// 		+'<td align="center">'+item.date+'</td>'
					// 		+'<td align="left">'+item.code+'</td>'
					// 		+'<td align="left">'+item.name+'</td>'
					// 		+'<td align="right">'+item.price+'</td>'
					// 		+'<td align="right">'+item.capital+'</td>'
					// 		+'<td align="center">'+item.qty+'  '+item.unit+'</td>'
					// 		+'<td align="right">'+item.total+'</td>'
					// 	+'</tr>';
						
					// 	num++;
					// });
					$('#rowdata').append(text);
					$('#rowfoot').append('<tr class="rowfoot"><td colspan="4"></td><td>ต้นทุน</td><td align="right">'+data.total[0]['sumtotal']+'</td></tr><tr class="rowfoot"><td colspan="4"></td><td>ยอดขาย</td><td align="right">'+data.total[0]['sumsale']+'</td></tr><tr class="rowfoot"><td colspan="4"></td><td>กำไรสุทธิ</td><td align="right">'+data.total[0]['totals']+'</td></tr>');
				}else{
					$('#firstauto').closest( 'tr').remove();
					$('#rowdata').append('<tr id="firstauto"><td colspan="6" align="center">-- No data --</td></tr>');
				}
			}
		});
	});
	
	function createbilling(){
		var selectbill = $("input[name='selectbill[]']").is(':checked');
		if(!selectbill){
			Lobibox.notify('error',{
				msg: 'กรุณาเลือกรายการบิลก่อน!',
				buttonsAlign: 'center',
				closeOnEsc: true,  
			});
		}else{
			$("#myForm").submit();
		}
	}
</script>
@stop