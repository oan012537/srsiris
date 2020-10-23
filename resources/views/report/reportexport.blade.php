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
            }
            @page {
                header: page-header;
                footer: page-footer;
            }
			
			.rowtd{
				padding-left:5px;
				height:25px;
				border-right:1px solid;
			}
        </style>
    </head>
    <body>
        <div class="row">
            <div class="row" name="page-header">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h2><u>รายการสินค้านำออก</u></h2>
                    </div>
                </div>
                <div class="row" style="border-top:1px solid;border-bottom:1px solid;">
                    <div class="col-xs-6" style="border-right:1px solid;">
                        <u>ที่อยู่บริษัท</u><br>
                        {{$setting->set_name}}<br>
                        {{$setting->set_address}}<br>
                        เบอร์โทร - Fax. -
                    </div>
                    <div class="col-xs-4">
                        <u>วันที่ออกรายงาน</u><br>
                        วันที่ : {{date('d/m/Y')}}<br>
                        วันที่สืบค้น : {{$date['start']}} - {{$date['end']}}
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:1%">
                <div class="col-xs-12">
                    <table style="width:100%;border-collapse: collapse;border:1px solid;">
                        <thead>
                            <tr>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="40px">
                                    #
                                </th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="100px">
                                    วันที่
                                </th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="100px">
                                    เลขที่
                                </th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;">
                                    ชื่อสินค้า
                                </th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="90px">
                                    จำนวน
                                </th>
                                <th class="text-center" style="height:30px;border-right:1px solid;border-bottom:1px solid;" width="90px">
                                    สถานะ
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
								$num = 1;
								if(count($data) > 0){
									foreach($data as $key => $rs){
										if(count($data[$key]) > 1){
											@endphp
											<tr>
												<td class="rowtd" align="center">{{$num}}</td>
												<td class="rowtd" align="center">{{$data[$key][0]['date']}}</td>
												<td class="rowtd" align="center">{{$data[$key][0]['inv']}}</td>
												<td class="rowtd">{{$data[$key][0]['name']}}</td>
												<td class="rowtd">{{$data[$key][0]['qty']}} {{$data[$key][0]['unit']}}</td>
												<td class="rowtd" align="center">{{$data[$key][0]['status']}}</td>
											</tr>
											@php
											for($x=1;$x<count($data[$key]);$x++){
											@endphp
												<tr>
													<td class="rowtd" align="center"></td>
													<td class="rowtd" align="center"></td>
													<td class="rowtd" align="center"></td>
													<td class="rowtd">{{$data[$key][$x]['name']}}</td>
													<td class="rowtd">{{$data[$key][$x]['qty']}} {{$data[$key][$x]['unit']}}</td>
													<td class="rowtd" align="center">{{$data[$key][$x]['status']}}</td>
												</tr>
											@php
											}
										}else{
											@endphp
											<tr style="border:1px solid;">
												<td class="rowtd" align="center">{{$num}}</td>
												<td class="rowtd" align="center">{{$data[$key][0]['date']}}</td>
												<td class="rowtd" align="center">{{$data[$key][0]['inv']}}</td>
												<td class="rowtd">{{$data[$key][0]['name']}}</td>
												<td class="rowtd">{{$data[$key][0]['qty']}} {{$data[$key][0]['unit']}}</td>
												<td class="rowtd" align="center">{{$data[$key][0]['status']}}</td>
											</tr>
											@php
										}
										$num++;
									}
								}else{
									@endphp
									<tr style="border:1px solid;">
										<td colspan="6" align="center">-- ไม่มีรายการที่ค้นหา --</td>
									</tr>
									@php
								}
							@endphp
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </body>
</html>