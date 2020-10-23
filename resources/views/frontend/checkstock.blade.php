<!doctype html>
<html lang="th">
	<head>      
		<link rel="icon" href="{{asset('assetsfrontend/image/logo.png')}}">  
		<title>SR-SIRI</title>
		@include('frontend/header')
	</head>
	<body>
		<div class="row" style="margin-top: 20px;">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<form id="myForm" method="post" action="{{url('scanbill')}}" >
					{{ csrf_field() }}
					<h2 style="text-align: center;">สแกนบิลขนส่ง</h2>
					<div class="col-md-12">
						<div class="form-group">
							<input type="text" name="scanbill" class="form-control" id="scanbill" required="">
						</div>
					</div>
					<div class="col-md-12" style="text-align: center;">
						<button type="submit" class="btn btn-primary">ค้นหาข้อมูล</button>
					</div>
				</form>
			</div>
			<div class="col-md-2"></div>
		</div>
	</body>
</html>
<script type="text/javascript">
	$(document).ready(function($) {
		$("#scanbill").focus();
	});
</script>