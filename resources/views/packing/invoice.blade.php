@php
function utf8_strlen($s) {
	$xxxx = preg_replace('[^่้๊๋ิีึืุูั์]','',$s); // ตัดทุกอย่างนอกเหนือขอบเขตที่ระบุไว้ทิ้ง
	$s = str_replace('ั','',$s);
	$s = str_replace('ิ','',$s);
	$s = str_replace('ี','',$s);
	$s = str_replace('ึ','',$s);
	$s = str_replace('ื','',$s);
	$s = str_replace('ุ','',$s);
	$s = str_replace('ู','',$s);
	$s = str_replace('่','',$s);
	$s = str_replace('้','',$s);
	$s = str_replace('๊','',$s);
	$s = str_replace('๋','',$s);
	$s = str_replace('ำ',' ',$s);
	$s = str_replace('์','',$s);

	$c = strlen($s); $l = 0;
	for ($i = 0; $i < $c; ++$i) if ((ord($s[$i]) & 0xC0) != 0x80) ++$l;
		return $l;
}

// echo $data[0]['cname'].'<br>';
// echo utf8_strlen('บริษัท ตั้งงี่สุนซูปเปอร์สโตร์ จำกัด สาขา โพธิ์ศร');
if(utf8_strlen($data[0]['cname']) <= 16){
	$fontsize = 130;
}else if(utf8_strlen($data[0]['cname']) <= 22){
	$fontsize = 110;
}else if(utf8_strlen($data[0]['cname']) <= 28){
	$fontsize = 90;
}else if(utf8_strlen($data[0]['cname']) <= 34){
	$fontsize = 70;
}else if(utf8_strlen($data[0]['cname']) <= 40){
	$fontsize = 55;
}
echo $fontsize;
exit();
@endphp
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
            .absolute1 {
			  position: absolute;
			  left: 200px;
			  top: 0px;
			  font-size: {{$fontsize.'px'}};
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
    		{{-- <br> --}}
        	<div class="row">
            <div class="row" name="page-header">
            	<htmlpageheader name="page-header">
                <div class="row">
                    <div class="col-xs-9">
                        <span style="font-size:70px;">ผู้รับ</span>
                    </div>
					<div class="col-xs-2">
						<table width="100%">
							<tr style="border:3px solid;padding:10px;">
								<td align="center"><span style="font-size:40px;margin-top:30px;">
									{{date('d/m/Y',strtotime($value->box_date))}}
								</span></td>
							</tr>
						</table>
					</div>
                </div>
                </htmlpageheader>
                <br>
                <div class="row" style="margin-top: -20px;">
                	<div class="col-xs-12" style="float: left;">
	                    <div class="col-xs-12" style="margin-top:10px;">
	                        <span style="font-size:54px;position: relative">ชื่อร้าน </span>  <span class="absolute1"> 	บริษัท ตั้งงี่สุนซูปเปอร์สโตร์ จำกัด สาขา โพธิ์ศร</span>
	                    </div>
	                </div>
                </div>
                <div class="row">
                	<div class="col-xs-7" style="float: left;height: 440px;width: 660px;">
	                    {{-- <div class="col-xs-12" style="margin-top:-30px;">
	                        <span style="font-size:54px;position: relative">ชื่อร้าน </span>  <span class="absolute1">  {{$data[0]['cname']}}</span>
	                    </div> --}}
						<div class="col-xs-12" style="margin-top:-40px;">
	                        <span style="font-size:50px;">ที่อยู่ </span>  <span style="font-size:50px;padding: 10px auto ;">  {{$data[0]['caddr']}}</span>
	                    </div>
						<div class="col-xs-12" style="margin-top:-20px;">
	                        <span style="font-size:50px;">Tel :</span>  <span style="font-size:40px;">  {{$data[0]['ctel']}}</span>
	                    </div>
						<div class="col-xs-12" style="margin-top:-15px;">
	                        <span style="font-size:30px;">จำนวนบิล :</span>  <span style="font-size:30px;">  {{count($data)}}</span>
	                    </div>
						<div class="col-xs-12" style="margin-top:-10px;">
						@php
							if($data){
								foreach($data as $keyinv => $rs){
									if($keyinv < 3){
									@endphp
										<p style="font-size:30px;padding-top: -10px;display: inline;">{{$rs['inv']}}</p>
									@php
									}
								}
							}
						@endphp
						@for($countinv= count($data);$countinv<3 ;$countinv++)
							<p style="font-size:30px;padding-top: -25px;display: inline;">&nbsp;</p>
						@endfor
						</div>
					</div>
					<div class="col-xs-4" style="float: right;text-align: right;margin-top: 0px;">
						<div style="font-size: 130px;margin-top: -70px;">
							<img  src="data:image/png;base64,{{ $value->genbarcode }}"  alt="barcode" class="barcode" />
							{{ $value->box_no }}0/{{  count($databoxs) }}0
							{{-- @if(count($value->datacat) > 0) --}}

							<div style="margin-top: -30px">
								{{-- <p style="text-indent: 30px;text-align: left;font-size: 40px;padding-top: -20px">จำนวนสินค้า [ {{ $value->sum }} ] รายการ</p> --}}
								<p style="text-indent: 30px;text-align: left;font-size: 40px;padding-top: -20px">จำนวนสินค้า [ {{ $totaldetail }} ] รายการ</p>
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
							{{-- @endif --}}
							
						</div>
					</div>
					{{-- <br> --}}
					<div class="col-xs-12" style="margin-top:-100px;">
						<div class="col-xs-12">
							<div style="text-align: center;">
								@php
									$str = str_replace('<?xml version="1.0" standalone="no"?>','',DNS1D::getBarcodeSVG($value->box_tax, "C39",4,70));
								@endphp
								{!!$str!!}
								<p style="margin-top: -15px;"><span style="font-size:35px;margin-top:20px;">{{$value->box_tax}}</span></p>
							</div>
							
						</div>
					</div>
					{{-- <br> --}}
					<div class="col-xs-12" style="margin-top:-25px;">
						<div class="col-xs-1">
							<table width="100%">
								<tr style="border:3px solid;padding:10px;">
									<td align="center"><span style="font-size:40px;margin-top:30px;">QC</span></td>
								</tr>
							</table>
						</div>
						{{-- <div class="col-xs-1">
							<table width="100%">
								<tr >
									<td align="center"><span style="font-size:40px;margin-top:30px;"> &nbsp;</span></td>
								</tr>
							</table>
						</div> --}}
						<div class="col-xs-10">
							<table width="100%">
								<tr>
									<td align="left">
										<span style="font-size:40px;margin-top:30px;">{{$setting->set_name}}</span><br>
										<span style="font-size:30px;margin-top:30px;">{{$setting->set_address}}</span>
									</td>
								</tr>
							</table>
						</div>
						{{-- <div class="col-xs-5">
							<div>
								@php
									$str = str_replace('<?xml version="1.0" standalone="no"?>','',DNS1D::getBarcodeSVG($value->box_tax, "C39",3,80));
								@endphp
								{!!$str!!}
								<span style="font-size:35px;margin-top:20px;">{{$value->box_tax}}</span>
							</div>
						</div> --}}
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