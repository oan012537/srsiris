@extends('../template')

@section('content')
<style type="text/css">
	i.disabled {
		pointer-events: none;
		cursor: default;
	}
</style>
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
		.classtransport{
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
								<div class="row" style="margin-top: 20px;">
								<div class="col-md-2"></div>
								<div class="col-md-8">
									<form id="myForm" method="post" action="#">
										{{ csrf_field() }}
										<input type="hidden" id="id" name="id" value="{{ $id }}">
										<h2 style="text-align: center;">สแกนบาร์โค้ด</h2>
										<div class="col-md-12">
											<div class="form-group">
												<input type="text" name="scanbarcode" class="form-control" id="scanbarcode" required="" autocomplete="off">
											</div>
										</div>
										<div class="col-md-12" style="text-align: center;">
											<button type="button" onclick="clickscanbarcode();" id="search" class="btn btn-primary">ค้นหาข้อมูล</button>
											<a href="{{ url('/transport') }}" class="btn btn-success">ย้อนกลับ</a>
											<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary">เพิ่มโพย</button>
										</div>
									</form>
									<br>
									<table class="table table-bordered" style="overflow-x: auto;margin-top:100px;">
										<thead class="thead-dark">
											<tr>
												<th>ชื่อลูกค้า</th>
												<th>เลขที่บิล</th>
												<th>จำนวน</th>
												<th>สแกนแล้ว</th>
												<th>กล่อง</th>
												<th>ห่อ</th>
												<th>มัด</th>
												<th>กส.</th>
												<th>สถานะ</th>
											</tr>
										</thead>
										<tbody>
											@if(!empty($data))
											@foreach($data as $key => $value)
											<tr>
												<td>{{ $value->selling_customername }}</td>
												<td>{{ $value->selling_inv }}</td>
												<td id="count{{ $value->selling_id }}">{{ $value->sumitem }}</td>
												<td id="countscan{{ $value->selling_id }}">{{ $value->sumscanitem }}</td>
												<td id="count1{{ $value->selling_id }}">{{ $value->selling_typeunit1-$value->selling_scantypeunit1 }}</td>
												<td id="count2{{ $value->selling_id }}">{{ $value->selling_typeunit2-$value->selling_scantypeunit2 }}</td>
												<td id="count3{{ $value->selling_id }}">{{ $value->selling_typeunit3-$value->selling_scantypeunit3 }}</td>
												<td id="count4{{ $value->selling_id }}">{{ $value->selling_typeunit4-$value->selling_scantypeunit4 }}</td>
												<td id="status{{ $value->selling_id }}">@if($value->sumitem == $value->sumscanitem) ครบแล้ว @elseif($value->sumitem > $value->sumscanitem && $value->sumscanitem != 0) ยังไม่ครบ @endif</td>
											</tr>
											@endforeach
											@endif
										</tbody>
									</table>
								</div>
								<div class="col-md-2"></div>
							</div>
							</div>
							
							
						</div>
						<!-- /vertical form -->
						
						<!-- Vertical form options -->
						<div class="row">
							
						</div>
						<!-- /vertical form options -->
					</div>
				</div>
			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
	
	 <!-- The Modal -->
	 <div class="modal" id="myModal">
	 	<div class="modal-dialog">
	 		<div class="modal-content">
	 			<!-- Modal Header -->
	 			<div class="modal-header">
	 				<h4 class="modal-title">เพิ่มโพย</h4>
	 				<button type="button" class="close" data-dismiss="modal">&times;</button>
	 			</div>

	 			<!-- Modal body -->
	 			<div class="modal-body">
	 				<form>
	 					<div class="form-group">
	 						<label>สแกนโพย</label>
	 						<div class="">
	 							<input type="text" name="addpoll" id="addpoll" class="form-control">
	 						</div>
	 					</div>
	 				</form>
	 			</div>
	 			<!-- Modal footer -->
	 			<div class="modal-footer">
	 				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	 			</div>
	 		</div>
	 	</div>
	 </div>
	
<style>
	.textshow{
		font-size:18px;
		border: none;
		text-align: right;
		margin-bottom: 8px;
	}
</style>

<script type="text/javascript">
	$(document).ready(function($) {
		$("#scanbarcode").focus();
	});
	function clickscanbarcode(){
		var myForm = $("#myForm").serialize();
		$.ajax({
			url: "{{url('transport/scanwaitboxputtingcar')}}",
			type: 'POST',
			data: myForm,
			success:function(result){
				$("#myForm")[0].reset();
				if(result['check'] == '1'){
					$("#scanbarcode").val('');
					var data = result['data'];
					console.log(data);
					data.forEach( function(element, index) {
						console.log(element);
						$("#count"+element.selling_id).html(element.sumitem);
						$("#countscan"+element.selling_id).html(element.sumscanitem);
						$("#count1"+element.selling_id).html(parseFloat(element.selling_typeunit1)-parseFloat(element.selling_scantypeunit1));
						$("#count2"+element.selling_id).html(parseFloat(element.selling_typeunit2)-parseFloat(element.selling_scantypeunit2));
						$("#count3"+element.selling_id).html(parseFloat(element.selling_typeunit3)-parseFloat(element.selling_scantypeunit3));
						$("#count4"+element.selling_id).html(parseFloat(element.selling_typeunit4)-parseFloat(element.selling_scantypeunit4));
						if(parseFloat(element.sumitem) == parseFloat(element.sumscanitem)){
							$("#status"+element.selling_id).html('ครบแล้ว');
						}else if(parseFloat(element.sumitem) > parseFloat(element.sumscanitem) && parseFloat(element.sumscanitem) != 0 ){
							$("#status"+element.selling_id).html('ยังไม่ครบ');
						}else{
							$("#status"+element.selling_id).html('');
						}
						
					});
					// $("#status"+result['id']).html('เช็คสินค้าแล้ว');
				}else if(result['check'] == '2'){
					
					Lobibox.notify('warning',{
						msg: 'บาร์โค้ดนี้เคยสแกนไปแล้ว',
						buttonsAlign: 'center',
						closeOnEsc: true,
					});
				}else{
					Lobibox.notify('error',{
						msg: 'บาร์โค้ดไม่ตรงกับบิลขาส่งนี้',
						buttonsAlign: 'center',
						closeOnEsc: true,
					});
				}
			}
		});
	}
	document.getElementById("scanbarcode").onkeypress = function(e) {
		var key = e.charCode || e.keyCode || 0;     
		if (key == 13) {
			e.preventDefault();
			$("#search").click();
		}
	}
	document.getElementById("addpoll").onkeypress = function(e) {
		var key = e.charCode || e.keyCode || 0;     
		if (key == 13) {
			e.preventDefault();
			$.post('../addpollintransport', {'_token': "{{ csrf_token() }}",poll:$(this).val(),id:"{{$id}}"}, function(data, textStatus, xhr) {
				if(data == 'Y'){
					Lobibox.notify('success',{
						msg: 'เพิ่มข้อมูลเรียบร้อย',
						buttonsAlign: 'center',
						closeOnEsc: true,
					});
					window.locale.reload();
				}else{
					Lobibox.notify('error',{
						msg: 'ไม่สามารถเพิ่มโพยนี้ได้กรุณาตรวจสอบสถานะ',
						buttonsAlign: 'center',
						closeOnEsc: true,
					});
				}
			});
		}
	}
</script>
@stop