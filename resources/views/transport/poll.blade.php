<html>
    <head>
        <meta charset="utf-8" />
        
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	    <link href="{{asset('assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
	    <link href="{{asset('assets/css/icons/fontawesome/styles.min.css')}}" rel="stylesheet" type="text/css">
	    <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
	    <link href="{{asset('assets/css/core.css')}}" rel="stylesheet" type="text/css">
	    <link href="{{asset('assets/css/components.css')}}" rel="stylesheet" type="text/css">
	    <link href="{{asset('assets/css/colors.css')}}" rel="stylesheet" type="text/css">
	
	    <link href="{{asset('assets/css/lobibox.min.css')}}" rel="stylesheet">
	    <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
        <script type="text/javascript" src="{{asset('assets/js/plugins/loaders/pace.min.js')}}"></script>
	    <script type="text/javascript" src="{{asset('assets/js/core/libraries/jquery.min.js')}}"></script>
	    <script type="text/javascript" src="{{asset('assets/js/core/libraries/bootstrap.min.js')}}"></script>
        <style>
            body{
                font-family: 'thaisarabun' !important;
                background-color: white !important;
                margin-top: 0 !important;
                margin-left: 1cm !important;
                margin-right: 1cm !important;
                margin-bottom: 0 !important;
                font-size: 16px !important;
                font-weight: bold !important;
                padding: 0px;
            }
            @page {
                header: page-header;
                footer: page-footer;
                margin-bottom: 0px;
            }
			
			.rowtd{
				padding-left:5px;
				height:25px;
				border-right:1px solid;
			}
			img.logo{
				-webkit-filter: grayscale(100%); /* Chrome, Safari, Opera */
				filter: grayscale(100%);
			}
        </style>
    </head>
    <body>

        	<div class="row">
            <div class="row" name="page-header">
                <div class="row">
                    <div class="col-xs-9">
                        <span style="font-size:70px;">ส่ง</span>
                    </div>
					<div class="col-xs-2">
						<table width="100%">
							<tr style="padding:10px;">
								<td align="center"><span style="font-size:50px;margin-top:40px;">
									{{ $sub[0]->selling_inv }}
								</span></td>
							</tr>
						</table>
					</div>
                </div>
                <div class="row">
                	<div class="col-xs-8" style="float: left;padding-right:45px;">
	                    <div class="col-xs-12" style="margin-top:-20px;">
	                        <span style="font-size:45px">ชื่อ </span>  <span style="font-size:45px;"> {{ $data[0]['cname'] }} </span>
	                    </div>
						<div class="col-xs-12" style="margin-top:-10px;height:300px;">
	                        <span style="font-size:45px;">ที่อยู่ </span>  
	                        <span style="font-size:45px;padding: 10px auto ;"> {{ $data[0]['caddr'] }} </span>
	                        <!-- <span style="font-size:50px;margin-top: 50px auto ;"> {{ $data[0]['address1'] }} </span>
	                        <span style="font-size:50px;margin-top: 510px auto ;"> {{ $data[0]['address2'] }} </span>
	                        <span style="font-size:50px;margin-top: -10px auto ;"> {{ $data[0]['address3'] }} </span>
	                        <span style="font-size:50px;margin-top: -10px auto ;"> {{ $data[0]['address4'] }} </span>
	                        <span style="font-size:50px;margin-top: -10px auto ;"> {{ $data[0]['address5'] }} </span>
	                        <span style="font-size:50px;margin-top: -10px auto ;"> {{ $data[0]['address6'] }} </span> -->
	                        <br>
	                        <span style="font-size:45px;">โทร  </span>  <span style="font-size:45px;"> {{ $data[0]['ctel']}} </span>
	                    </div>
						<!-- <div class="col-xs-12" style="margin-top:-10px;">
	                        <span style="font-size:30px;">จำนวน : </span>  <span style="font-size:30px;"> {{ $total }}</span>
	                    </div> -->
					</div>
					<div class="col-xs-3" style="float: right;text-align: right;">
						<div style="text-align:center;">
							<img  src="data:image/png;base64,{{ $qrcode }}"  alt="barcode" class="barcode" />
						</div>
						<br>
						<br>
					</div>
					<br>
                </div>
                {{-- <div class="row" style="margin-top:0px;"> --}}
                	
					<div class="col-xs-7">
						<br>
						<table width="100%">
							<tr>
								<td align="center" >
									<img class="logo" src="{{asset('assets/images/setting/logopoll.png')}}" width="140px" alt="">
									
								</td>
								<td align="left">
									<span style="font-size:30px;margin-top:20px;">{{$setting->set_name}}</span><br>
									<span style="font-size:30px;margin-top:30px;">{{$setting->set_address}}</span>
								</td>
							</tr>
						</table>
					</div>
					<div class="col-xs-4" style="width:400px;float: right;text-align: right;padding-left: 0px;">
	                	<table width="100%" style="font-size:35px;">
	                		<tr>
								<td align="left" style="padding-left:30px;font-size:60px;">
									<b>จำนวนรวม {{ $total }} รายการ</b>
								</td>
							</tr>
	                		@if($boxunit1 != 0)
							<tr>
								<td align="left" style="padding-left:30px">
									{{ $boxunit1 }} กล่อง
								</td>
							</tr>
							@endif
							@if($boxunit2 != 0)
							<tr>
								<td align="left" style="padding-left:30px">
									{{ $boxunit2 }} ห่อ
								</td>
							</tr>
							@endif
							@if($boxunit3 != 0)
							<tr>
								<td align="left" style="padding-left:30px">
									{{ $boxunit3 }} มัด
								</td>
							</tr>
							@endif
							@if($boxunit4 != 0)
							<tr>
								<td align="left" style="padding-left:30px">
									{{ $boxunit4 }} กส.
								</td>
							</tr>
							<!-- @endif -->
						</table>
					</div>
                {{-- </div> --}}
            </div>
        	</div>
        	<!-- <div style="page-break-after: always"></div> -->
    </body>
</html>