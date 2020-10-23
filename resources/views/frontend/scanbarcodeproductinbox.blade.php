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
				<h2 style="text-align: center;">ข้อมูลสินค้าในกล่อง {{ $data[0]->box_tax }}</h2>
				<br>
				<table class="table table-bordered">
					<thead class="thead-dark">
						<tr>
							<th>รหัสสินค้า</th>
							<th>ชื่อสินค้า</th>
							<th>จำนวนสินค้า</th>
						</tr>
					</thead>
					<tbody>
						@if(!empty($data))
						@foreach($data as $key => $value)
						<tr>
							<td>{{ $value->product_code }}</td>
							<td>{{ $value->product_name }}</td>
							<td>{{ $value->box_number }}</td>
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
