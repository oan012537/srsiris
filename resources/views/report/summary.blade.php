@extends('../template')

@section('content')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">รายงาน</span> - รายงานยอดขาย - Summary</h4>
			</div>

			
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{url('/')}}"><i class="icon-home2 position-left"></i> รายงาน</a></li>
				<li class="active">รายงานยอดขาย - Summary</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">
		
		<!-- Basic datatable -->
		<div class="panel panel-flat">
			<div class="panel-heading">
				<h5 class="panel-title">รายงานยอดขาย - Summary</h5>
				<div class="heading-elements">
					<ul class="icons-list">
						<li><a data-action="collapse"></a></li>
						<li><a data-action="reload"></a></li>
						<li><a data-action="close"></a></li>
					</ul>
				</div>
			</div>
			
			<form method="post" id="myForm" action="{{url('printreportsummary')}}" target="blank">
			{{ csrf_field() }}
			<div class="panel-body">
				<div class="row">
					<div class="col-md-2">
						<div class="form-group">
							<label>ตั้งแต่วันที่ :</label>
							<input type="text" placeholder="ตั้งแต่วันที่" class="form-control datepicker-dates" name="datestart" id="datestart">
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label>ถึงวันที่ :</label>
							<input type="text" placeholder="ถึงวันที่" class="form-control datepicker-dates" name="dateend" id="dateend">
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
							<button type="submit" id="printer" class="btn btn-primary btn-lg" style=""><i class="icon-printer2"></i> พิมพ์รายงาน</button>
						</div>
					</div>
				</div>
			</div>
			</form>
			
			<table class="table">
				<thead>
					<tr>
						<th class="text-center">ลำดับ</th>
						<th class="text-center">ลูกค้า</th>
						<th class="text-center">รวม</th>
					</tr>
				</thead>
				<tbody id="bodytbshow"></tbody>
				<tfoot id="foottbshow"></tfoot>
			</table>
		</div>
		
		<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">ออเดอร์</h4>
			  </div>
			  <div class="modal-body">
				<table class="table">
					<thead>
						<tr>
							<th class="text-center">เลขที่ออเดอร์</th>
							<th class="text-center">รายการ</th>
							<th class="text-center">หมวด</th>
							<th class="text-center">ราคาซื้อ	</th>
							<th class="text-center">ราคาขาย</th>
							<th class="text-center">จำนวน</th>
							<th class="text-center">กำไรสุทธิ</th>
							<th class="text-center">รวม</th>
						</tr>
					</thead>
					<tbody id="orderbodytbshow"></tbody>
					<tfoot id="orderfoottbshow"></tfoot>
				</table>
				<br>
				<span id="cash"></span><br>
				<span id="credit"></span>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>

		  </div>
		</div>

		<!-- Footer -->
		<div class="footer text-muted">
			&copy; 2016-2017. <a href="https://www.orange-thailand.com">Orange Technology Solution</a>
		</div>
		<!-- /footer -->

	</div>
	<!-- /content area -->

</div>
<!-- /main content -->

</div>
<!-- /page content -->

</div>
<!-- /page container -->
<script>
	$(document).ready(function(){
		$('#bodytbshow').append('<tr id="firstauto"><td colspan="3" align="center">-- No data --</td></tr>');
		$('#orderbodytbshow').append('<tr id="orderfirstauto"><td colspan="8" align="center">-- No data --</td></tr>');
	});
	
	$('#searchdata').click(function(){
		$.ajax({
		'type': 'post',
		'url': "{{url('reportdatasummary')}}",
		'dataType': 'json',
		'data': {
			'start': $('#datestart').val(),
			'end': $('#dateend').val(),
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data){
				var sumtotal 	= 0;
				var count 	= data.length;
				if(count != 0){
					$('#firstauto').closest( 'tr').remove();
					$('.rowbody').closest( 'tr').remove();
					$('#footerrow').closest( 'tr').remove();
					
					function formatNumber (x) {
						return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
					}
					
					var num = 1;
					var text = '';
					
					$.each(data,function(key,item){
						var totalcust = 0;
						for(var i = 0;i < data[key].length;i++){
							sumtotal 		+= parseFloat(data[key][i]['total']);
							totalcust 		+= parseFloat(data[key][i]['total']);
						}
						
						text += '<tr class="rowbody" onclick="myclick('+key+');">'
							+'<td align="center">'+num+'</td>'
							+'<td align="left">'+data[key][0]['cusname']+'</td>'
							+'<td align="right">'+formatNumber(totalcust.toFixed(2))+'</td>'
						+'</tr>';
						
						num++;
					});
					$('#bodytbshow').append(text);
					$('#foottbshow').append('<tr id="footerrow"><td colspan="2" align="center">รวม<td align="right">'+formatNumber(sumtotal.toFixed(2))+'</td></tr>');
				}else{
					$('#firstauto').closest( 'tr').remove();
					$('#bodytbshow').append('<tr id="firstauto"><td colspan="3" align="center">-- No data --</td></tr>');
				}
				
				$(".styled").uniform({ radioClass: 'choice' });
			}
		});
	});
	
	function myclick(id){
		$.ajax({
		'type': 'post',
		'url': "{{url('datasummary')}}",
		'dataType': 'json',
		'data': {
			'id': id,
			'start': $('#datestart').val(),
			'end': $('#dateend').val(),
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data){
				var sumtotal 	= 0;
				var count 	= data.results.length;
				if(count != 0){
					$('#orderfirstauto').closest( 'tr').remove();
					$('.orderrowbody').closest( 'tr').remove();
					$('#orderfooterrow').closest( 'tr').remove();
					
					function formatNumber (x) {
						return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
					}
					
					var num = 1;
					var text = '';
					
					$.each(data.results,function(key,item){
						var totalcust = 0;
						var profitcust = 0;
						sumtotal 		+= parseFloat(data.results[key][0]['total']);
						profitcust 		+= parseFloat(data.results[key][0]['profit']);
						totalcust 		+= parseFloat(data.results[key][0]['total']);
						text += '<tr class="orderrowbody">'
							+'<td align="left">'+data.results[key][0]['inv']+'</td>'
							+'<td align="left">'+data.results[key][0]['name']+'</td>'
							+'<td align="left">'+data.results[key][0]['category']+'</td>'
							+'<td align="right">'+formatNumber(data.results[key][0]['pricebuy'])+'</td>'
							+'<td align="right">'+formatNumber(data.results[key][0]['pricesale'])+'</td>'
							+'<td align="center">'+data.results[key][0]['qty']+'</td>'
							+'<td align="right">'+formatNumber(data.results[key][0]['profit'])+'</td>'
							+'<td align="right">'+formatNumber(data.results[key][0]['total'])+'</td>'
						+'</tr>';
						
						for(var i = 1;i < data.results[key].length;i++){
							sumtotal 		+= parseFloat(data.results[key][i]['total']);
							profitcust 		+= parseFloat(data.results[key][i]['profit']);
							totalcust 		+= parseFloat(data.results[key][i]['total']);
							text += '<tr class="orderrowbody">'
								+'<td align="left">'+data.results[key][i]['inv']+'</td>'
								+'<td align="left">'+data.results[key][i]['name']+'</td>'
								+'<td align="left">'+data.results[key][i]['category']+'</td>'
								+'<td align="right">'+formatNumber(data.results[key][i]['pricebuy'])+'</td>'
								+'<td align="right">'+formatNumber(data.results[key][i]['pricesale'])+'</td>'
								+'<td align="center">'+data.results[key][i]['qty']+'</td>'
								+'<td align="right">'+formatNumber(data.results[key][i]['profit'])+'</td>'
								+'<td align="right">'+formatNumber(data.results[key][i]['total'])+'</td>'
							+'</tr>';
						}
						
						text += '<tr class="orderrowbody">'
							+'<td align="center" colspan="6">รวม</td>'
							+'<td align="right">'+formatNumber(profitcust)+'</td>'
							+'<td align="right">'+formatNumber(totalcust)+'</td>'
						+'</tr>';
						
						num++;
					});
					$('#orderbodytbshow').append(text);
				}else{
					$('#orderfirstauto').closest( 'tr').remove();
					$('#orderbodytbshow').append('<tr id="orderfirstauto"><td colspan="8" align="center">-- No data --</td></tr>');
				}
				$('#cash').text(formatNumber('เงินสด  '+data.cash.toFixed(2)));
				$('#credit').text(formatNumber('เครดิต   '+data.credit.toFixed(2)));
				$('#myModal').modal('show');
			}
		});	
	}
</script>
</body>
</html>
@stop