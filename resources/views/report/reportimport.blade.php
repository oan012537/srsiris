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
        </style>
    </head>
    <body>
        <div class="row">
            <div class="row" name="page-header">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h2><u>รายการนำเข้าสินค้า</u></h2>
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
                        วันที่สืบค้น : {{$datestart}} - {{$dateend}}
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:1%">
                <div class="col-xs-12">
                    <table style="width:100%;border-collapse: collapse;border:1px solid;">
                        <thead>
                            <tr>
                                <th class="text-center" style="height:30px;border-right:1px solid;">
                                    #
                                </th>
                                <th class="text-center" style="height:30px;border-right:1px solid;">
                                    วันที่
                                </th>
                                <th class="text-center" style="height:30px;border-right:1px solid;">
                                    ซัพพลายเออร์
                                </th>
                                <th class="text-center" style="height:30px;border-right:1px solid;">
                                    เลขที่
                                </th>
                                <th class="text-center" style="height:30px;border-right:1px solid;">
                                    ชื่อสินค้า
                                </th>
                                <th class="text-center" style="height:30px;border-right:1px solid;">
                                    จำนวน
                                </th>
                                <th class="text-center" style="height:30px;border-right:1px solid;">
                                    ราคาทุน
                                </th>
                                <th class="text-center" style="height:30px;border-right:1px solid;">
                                    ราคาขาย
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($import))
                                @php
                                    $row = 1;
                                @endphp
                                @foreach($import AS $val)
                                    <tr>
                                        <td class="text-center" style="border-right:1px solid;border-top:1px solid;">
                                            {{$row}}
                                        </td>
                                        <td class="text-center" style="border-right:1px solid;border-top:1px solid;">
                                            {{date('d/m/Y',strtotime($val->imp_date))}}
                                        </td>
                                        <td class="text-left" style="border-right:1px solid;border-top:1px solid;">
                                            &nbsp;
                                            @if($val->supplierdata)
                                                {{$val->supplierdata->supplier_name}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-left" style="border-right:1px solid;border-top:1px solid;">
                                            &nbsp;
                                            {{$val->imp_no}}
                                        </td>
                                        <td class="text-left" style="border-right:1px solid;border-top:1px solid;">
                                            &nbsp;
                                            @if($val->firstproduct)
                                                @if($val->firstproduct->productdata)
                                                    {{$val->firstproduct->productdata->product_name}}
                                                @else
                                                    -
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-right" style="border-right:1px solid;border-top:1px solid;">
                                            
                                            @if($val->firstproduct)
                                                @if($val->firstproduct->productdata)
                                                    {{number_format($val->firstproduct->amount)}}
                                                @else
                                                    0
                                                @endif
                                            @else
                                                0
                                            @endif
                                            &nbsp;
                                        </td>
                                        <td class="text-right" style="border-right:1px solid;border-top:1px solid;">
                                            @if($val->firstproduct)
                                                @if($val->firstproduct->productdata)
                                                    {{number_format($val->firstproduct->product_capital,2)}}
                                                @else
                                                    0
                                                @endif
                                            @else
                                                0
                                            @endif
                                            &nbsp;
                                        </td>
                                        <td class="text-right" style="border-right:1px solid;border-top:1px solid;">
                                            @if($val->firstproduct)
                                                @if($val->firstproduct->productdata)
                                                    {{number_format($val->firstproduct->product_sale,2)}}
                                                @else
                                                    0
                                                @endif
                                            @else
                                                0
                                            @endif
                                            &nbsp;
                                        </td>
                                    </tr>
                                    @if($val->allproduct)
                                        @php
                                            $subrow = 1;
                                        @endphp
                                        @foreach($val->allproduct AS $subval)
                                            @if($subrow > 1)
                                                <tr>
                                                    <td class="text-center" style="border-right:1px solid;border-top:1px solid;">
                                                        &nbsp;
                                                    </td>
                                                    <td class="text-center" style="border-right:1px solid;border-top:1px solid;">
                                                        &nbsp;
                                                    </td>
                                                    <td class="text-left" style="border-right:1px solid;border-top:1px solid;">
                                                        &nbsp;
                                                    </td>
                                                    <td class="text-left" style="border-right:1px solid;border-top:1px solid;">
                                                        &nbsp;
                                                    </td>
                                                    <td class="text-left" style="border-right:1px solid;border-top:1px solid;">
                                                        &nbsp;
                                                        
                                                        @if($subval->productdata)
                                                            {{$subval->productdata->product_name}}
                                                        @else
                                                            -
                                                        @endif
                                                       
                                                    </td>
                                                    <td class="text-right" style="border-right:1px solid;border-top:1px solid;">

                                                        @if($subval->productdata)
                                                            {{number_format($subval->amount)}}
                                                        @else
                                                            0
                                                        @endif
                                                        
                                                        &nbsp;
                                                    </td>
                                                    <td class="text-right" style="border-right:1px solid;border-top:1px solid;">
                                                        @if($subval->productdata)
                                                            {{number_format($subval->product_capital,2)}}
                                                        @else
                                                            0
                                                        @endif
                                                        
                                                        &nbsp;
                                                    </td>
                                                    <td class="text-right" style="border-right:1px solid;border-top:1px solid;">
                                                        @if($subval->productdata)
                                                            {{number_format($subval->product_sale,2)}}
                                                        @else
                                                            0
                                                        @endif
                                                        
                                                        &nbsp;
                                                    </td>
                                                </tr>
                                            @endif
                                            @php
                                                $subrow++;
                                            @endphp
                                        @endforeach
                                    @endif
                                    @php
                                        $row++;
                                    @endphp
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </body>
</html>