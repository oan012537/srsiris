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
        </style>
    </head>
    <body>
    	@if(!empty($databox))
    	@foreach($databox as $databoxs)
    		@foreach($databoxs as $key =>$value)
        	<div class="row">
            <div class="row" name="page-header">
                <div class="row">
                    <div class="col-xs-9">
                        <span style="font-size:70px;">ผู้รับ</span>
                    </div>
					<div class="col-xs-2">
						<table width="100%">
							<tr style="border:3px solid;padding:10px;">
								<td align="center">
									<span style="font-size:40px;margin-top:30px;">{{date('d/m/Y',strtotime($value->box_date))}}</span>
								</td>
							</tr>
						</table>
					</div>
                </div>
                <div class="row">
                	<div class="col-xs-7" style="float: left;padding-right:45px;">
	                    <div class="col-xs-12" style="margin-top:-30px;">
	                        <span style="font-size:60px">ชื่อร้าน </span>  <span style="font-size:60px;">  {{$data[0]['cname']}}</span>
	                    </div>
						<div class="col-xs-12" style="margin-top:-30px;">
	                        <span style="font-size:50px;">ที่อยู่ </span>  <span style="font-size:50px;padding: 10px auto ;">  {{$data[0]['caddr']}}</span>
	                    </div>
						<div class="col-xs-12" style="margin-top:-20px;">
	                        <span style="font-size:30px;">Tel :</span>  <span style="font-size:30px;">  {{$data[0]['ctel']}}</span>
	                    </div>
						<div class="col-xs-12" style="margin-top:-10px;">
	                        <span style="font-size:30px;">จำนวนบิล :</span>  <span style="font-size:30px;">  {{count($data)}}</span>
	                    </div>
						<div class="col-xs-12" style="margin-top:-10px;">
						@php
							if($data){
								foreach($data as $keyinv => $rs){
									if($keyinv < 3){
									@endphp
										<span style="font-size:30px;">{{$rs['inv']}}</span><br>
									@php
									}
								}
							}
						@endphp
						</div>
					</div>
					<div class="col-xs-4" style="float: right;text-align: right;">
						<div style="font-size: 170px;">
							<img  src="data:image/png;base64,{{ $value->genbarcode }}"  alt="barcode" class="barcode" />
							{{ $value->box_no }}/{{  count($databoxs) }}

							<div style="margin-top: -35px">
								<p style="text-indent: 30px;text-align: left;font-size: 40px;padding-top: -20px">จำนวนสินค้า [ {{ $value->sum }} ] รายการ</p>
								@foreach($value->datacat as $keydata => $datacat)
									@if($keydata < 3)
									{{-- @if($keydata == 0)
									<p style="text-indent: 40px;text-align: left;font-size: 30px;">{{$datacat}}</p>
									@else --}}
									<p style="text-indent: 30px;text-align: left;font-size: 40px;padding-top: -20px">{{$datacat}}</p>
									{{-- @endif --}}

									@endif
								@endforeach
								@for($countcat = count($value->datacat);$countcat<3 ;$countcat++)
								<p style="text-indent: 30px;text-align: left;font-size: 40px;padding-top: -20px">&nbsp;</p>
								@endfor
							</div>
						</div>
					</div>
					<br>
					<div class="col-xs-12" style="margin-top:-10px;">
						<div class="col-xs-1">
							<table width="100%">
								<tr style="border:3px solid;padding:10px;">
									<td align="center"><span style="font-size:40px;margin-top:30px;">QC</span></td>
								</tr>
							</table>
						</div>
						<div class="col-xs-1">
							<table width="100%">
								<tr >
									<td align="center"><span style="font-size:40px;margin-top:30px;"> &nbsp;{{-- {{ $value->sum }} --}}</span></td>
								</tr>
							</table>
						</div>
						<div class="col-xs-4">
							<table width="100%">
								<tr>
									<td align="left">
										<span style="font-size:40px;margin-top:20px;">{{$setting->set_name}}</span><br>
										<span style="font-size:30px;margin-top:30px;">{{$setting->set_address}}</span>
									</td>
								</tr>
							</table>
						</div>
						<div class="col-xs-5">
							<div>
								@php
									$str = str_replace('<?xml version="1.0" standalone="no"?>','',DNS1D::getBarcodeSVG($value->box_tax, "C39",3,80));
								@endphp
								{!!$str!!}
								<span style="font-size:35px;margin-top:20px;">{{$value->box_tax}}</span>
							</div>
						</div>
					</div>
                </div>
            </div>
        	</div>
        	@if(count($databoxs)-1 != $key)
        	<div style="page-break-after: always"></div>
        	@endif
        	@endforeach
        @endforeach
        @endif
    </body>
</html>