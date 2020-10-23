<!doctype html>
<html lang="th">
	<head>      
		<link rel="icon" href="{{asset('assetsfrontend/image/logo.png')}}">  
		<title>SR-SIRI</title>
		<style type="text/css" media="screen">
			.addcolor > td{
				background: red;
				border:1px solid red;
			}
		</style>
		@include('frontend/header')
	</head>
	<body>
		<div class="row" style="margin-top: 20px;">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<form id="myForm" method="post" action="#">
					{{ csrf_field() }}
					<input type="hidden" id="id" name="id" value="{{ $id }}">
					<h2 style="text-align: center;">สแกนบาร์โค้ด</h2>
					<div class="col-md-12">
						<div class="form-group">
							<input type="text" name="scanbarcode" class="form-control" id="scanbarcode" required="" >
						</div>
					</div>
					<div class="col-md-12" style="text-align: center;">
						<button type="button" onclick="clickscanbarcode();" id="search" class="btn btn-primary">ค้นหาข้อมูล</button>
						<a href="{{ url('/checkboxbeforeputtingcar') }}" class="btn btn-success">ส่งข้อมูลแพ็กสินค้า</a>
					</div>
				</form>
				<br>
				<table class="table table-bordered">
					<thead class="thead-dark">
						<tr>
							<th>รหัสกล่อง</th>
							{{-- <th>หมายเลขกล่อง</th> --}}
							{{-- <th>จำนวนของในกล่อง(ชิ้น)</th> --}}
							<th>สถานะ</th>
						</tr>
					</thead>
					<tbody>
						@if(!empty($data))
						@foreach($data as $key => $value)
						<tr>
							<td>{{ $value->selling_inv }}</td>
							{{-- <td>{{ $value->box_no }}</td> --}}
							{{-- <td id="show{{ $value->box_id }}">{{ $value->box_number }}</td> --}}
							<td id="status{{ $value->selling_inv }}"></td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
			<div class="col-md-2"></div>
		</div>
	</body>
</html>
<script type="text/javascript">
	$(document).ready(function($) {
		$("#scanbarcode").focus();
	});
	function clickscanbarcode(){
		var myForm = $("#myForm").serialize();
		$.ajax({
			url: "{{url('scanwaitboxputtingcar')}}",
			type: 'POST',
			data: myForm,
			success:function(result){
				if(result['check'] != '0'){
					$("#scanbarcode").val('');
					$("#status"+result['id']).html('เช็คสินค้าแล้ว');
				}else{
					Lobibox.notify('error',{
						msg: 'บาร์โค้ดไม่ตรงกับสินค้า',
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
</script>