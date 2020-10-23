<!DOCTYPE html> 
<?php
function tranfer($tang){
    $txt1 = array('','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ');
    $txt2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
    $len = strlen($tang);
    $ans = '';
    for($i=0;$i<$len;$i++){
        $num = substr($tang,$i,1);
        if($num !=0 ){
        if($num == 1 && $i==($len-1)){
            $ans .='เอ็ด';
        }else if($num == 2 && $i == ($len-2)){
            $ans .= 'ยี่';
        }else if($num == 1 && $i == ($len-2)){
            $ans .= '';
        }else{
            $ans .= $txt1[$num] ;
        }
            $ans .= $txt2[$len-$i-1];
        }
    }
    $ans .='บาทถ้วน';
    return $ans;
}
?>
<html lang="en">
    <head>
        {{-- {{error_reporting(0)}} --}}
        <style>
            body{
                font-family:"thaisarabun" , "microsoft sans serif";
                font-size :22px;
            }
            table{
                font-size :18px;
            }
            div{
                font-size :18px;
            }
            @page {
                footer: page-footer;
                margin-top: 15px;
                margin-left: 20px;
                margin-right: 20px;
                margin-bottom: 34px;
            }
        </style>
        {{-- <title>{{ $data[0] -> order_no }}</title> --}}
    </head>
    <body>
        <div class="test-center">
            {{-- <img src="{{asset('assets/images/orderlogo/update 02 AW Logo C CHANNEL_Shopping_create-01.jpg')}}" width="100%" height="20%"> --}}
        </div>
        <div class="col-md-9" style="width: 78%;float: left;">
            <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;"> 
                <thead>
                    <tr>
                        <td rowspan="5" width="130" style="text-align: center;">
                            <img height="60" width="130" src="{{asset('assets/images/setting')}}/{{$settingbill->setheadbill_logo}}">
                            <b style="font-size: 20px;">{{ $settingbill->setheadbill_textlogo }}</b><br>
                            <span style="width: 100%;">สำนักงานใหญ่</span><br>
                            <span style="width: 100%;">Head Office</span> 
                        </td>
                        <td height="40" colspan="6" style="border:hidden;text-align:left;line-height:10px;line-height:10px" >
                            <h2>{{ $settingbill->setheadbill_title }}</h2>
                        </td>
                    </tr>
                    <tr style="margin-top: 20px;">
                        <td height="17"  colspan="7" style="border:hidden;text-align:left;line-height:15px;" >
                            {{-- 45/247 0-2472 ซอยดีเค 26 ถ.พระยามนธาตุ แขวงบางบอน เขตบางบอน กทม. 10150 --}}
                            {{ $settingbill->setheadbill_address_th }}
                        </td>
                    </tr>
                    <tr style="margin-top: 10px;">
                        <td height="17" colspan="7" style="border:hidden;text-align:left;line-height:15px;" >
                            {{-- 45/247 0-2472 Soi DK26 Phayamontha Rd., Bangbon Bangbon Bkk. 10150 --}}
                            {{ $settingbill->setheadbill_address_en }}
                        </td>
                    </tr>
                    <tr style="margin-top: 10px;">
                        {{-- <td style="border:hidden;text-align:center;line-height:15px;"><b>{{ $settingbill->setheadbill_textlogo }}</b></td> --}}
                        <td height="17" colspan="2" style="border:hidden;text-align:left;line-height:15px;" >
                            {{-- http://www.srsiri.com --}}
                            {{ $settingbill->setheadbill_web }}
                        </td>
                        <td height="17" colspan="2" style="border:hidden;text-align:left;line-height:15px;" >
                            {{-- Email:sr_siri@windowslive.com --}}
                            Email: {{ $settingbill->setheadbill_email }}
                        </td>
                    </tr>
                    <tr style="margin-top: 10px;">
                        {{-- <td style="border:hidden;text-align:center;line-height:15px;">สำนักงานใหญ่Head Office</td> --}}
                        <td height="17" colspan="2" style="border:hidden;text-align:left;line-height:15px;" >
                            {{-- Tel. 02-417-8515-6 --}}
                            Tel. {{ $settingbill->setheadbill_tel }}
                        </td>
                        <td height="17" colspan="2" style="border:hidden;text-align:left;line-height:15px;" >
                            {{-- Fax. 02-417-8510 --}}
                            Fax. {{ $settingbill->setheadbill_fax }}
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="col-md-3" style="width: 20%;float: right;">
            <br>
            <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;"> 
                <thead>
                    <tr>
                        <td style="text-align:right;line-height:10px;" >
                            <h2 style="border:2px solid;margin: 20px;">&nbsp;&nbsp;&nbsp;ใบวางบิล&nbsp;&nbsp;&nbsp;</h2>
                        </td>
                    </tr>
                    <tr><td >&nbsp;</td></tr>
                </thead>
            </table>
        </div>
        <br><br>
        {{-- <table style="border:1px solid;width:100%;border-collapse: collapse;border-spacing: 0 1em;">
            <thead>
                <tr>
                    <td height="40" colspan="6" style="border:hidden;text-align:left;line-height:10px;line-height:10px" >
                        <h2>ใบวางบิล</h2>
                    </td>
                </tr>
            </thead>
        </table> --}}
        <div style="margin-top: 12px;"></div>
        <table style="border:1px solid;width:100%;border-collapse: collapse;border-spacing: 0 1em;">
            <thead>
                <tr>
                    <td height="80" colspan="6" style="border:hidden;text-align:left;font-size: 20px;padding-top: 10px;vertical-align: top;" >ลูกค้า/ร้านค้า : {{$customer->customer_name}} บ้านเลขที่{{$customer->customer_address1}} ถนน{{$customer->customer_address2}} เขต{{$customer->customer_address3}} จังหวัด{{$customer->customer_address4}} บ้านเลขที่{{$customer->customer_address5}}   
                    </td>
                </tr>
            </thead>
        </table>
        <div style="margin-top: 12px;"></div>
        {{-- <br> --}}
        <table style="border:1px solid;width:100%;border-collapse: collapse;border-spacing: 0 1em;">
            <thead>
                <tr><td width="100%">ระยะเวลาตั้งแต่(Duration) :{{$data[0]->selling_date}} ถึง {{$data[count($data)-1]->selling_date}}</td></tr>
                <tr><td width="100%">วันกำหนดชำระเงิน(Due Date) : </td></tr>
            </thead>
        </table>
        <table style="border:1px solid;width:100%;border-collapse: collapse;border-spacing: 0 1em;">
            <thead>
                <tr>
                    <td width="10%" style="border:1px solid;height:35px;vertical-align: middle;text-align: center;">&nbsp;&nbsp;<b>ลำดับ(Order)</b></td>
                    <td width="10%" style="border:1px solid;height:35px;vertical-align: middle;text-align: center;">&nbsp;&nbsp;<b>วันที่(Date)</b></td>
                    <td width="15%" style="border:1px solid;height:35px;vertical-align: middle;text-align: center;">&nbsp;&nbsp;<b>เลขที่บิล(Bill)</b></td>
                    <td width="30%" style="border:1px solid;height:35px;vertical-align: middle;text-align: center;">&nbsp;&nbsp;<b>จำนวนเงิน(Amount)</b></td>
                    <td width="15%" style="border:1px solid;height:35px;vertical-align: middle;text-align: center;">&nbsp;&nbsp;<b>ค่าขนส่ง</b></td>
                    <td width="30%" style="border:1px solid;height:35px;vertical-align: middle;text-align: center;">&nbsp;&nbsp;<b>*หมายเหตุ(Mark)</b></td>
                </tr>
                @php
                $total = 0;
                $ratesend = 0;
                $totalshippingcost = 0;
                @endphp
                @foreach($data as $key => $item)
                @php
                $total  =  $total + $item->selling_totalpayment;
                $totalshippingcost += $item->selling_shippingcost;

                @endphp
                <tr>
                    {{-- <td style="border:1px solid;height:60px;" colspan="1" >
                        <img width="100" src="{{asset('assets/images/product')}}/{{ $item -> product_picture }}">
                    </td> --}}
                    <td width="10%" style="border:1px solid;height:30px;text-align: center;">{{ $key + 1 }}</td>
                    <td width="10%" style="border:1px solid;height:30px;" >
                        &nbsp;&nbsp;{{ $item -> selling_date }}
                    </td>
                    <td width="15%" style="border:1px solid;height:30px;" >
                        &nbsp;&nbsp;{{ $item -> selling_inv }}
                    </td>
                    <td width="30%" style="border:1px solid;height:30px;text-align: center;">
                        &nbsp;&nbsp;{{ number_format($item -> selling_totalpayment,2) }}
                    </td>
                    <td width="15%" style="border:1px solid;height:30px;text-align: center;">
                        &nbsp;&nbsp;{{ number_format($item -> selling_shippingcost,2) }}
                    </td>
                    <td width="30%" style="border:1px solid;height:30px;text-align: center;" >
                        &nbsp;
                    </td>
                </tr>
                @endforeach
                @for($x = count($data);$x < 21;$x++)
                <tr>
                    <td width="10%" style="border:1px solid;height:30px;text-align: center;" ></td>
                    <td width="10%" style="border:1px solid;height:30px;text-align: center;" ></td>
                    <td width="15%" style="border:1px solid;height:30px;text-align: center;" ></td>
                    <td width="30%" style="border:1px solid;height:30px;text-align: center;" ></td>
                    <td width="15%" style="border:1px solid;height:30px;text-align: center;" ></td>
                    <td width="30%" style="border:1px solid;height:30px;text-align: center;" ></td>
                </tr>
                @endfor
                <tr>
                    {{-- <td colspan="7" style="border-bottom:1px solid;border-top:1px solid;height:35px;vertical-align: middle;text-align: center;">&nbsp;&nbsp;หมายเหตุ : บัญชี<b>คุณเพ็ญศรี  ด่านวัฒนาศิริ</b> ธนาคารกสิกรไทย สาขาวงแหวนรอบนอก <b>728-1-02164-2<br> </td> --}}
                    <td colspan="7" style="border-bottom:1px solid;border-top:1px solid;height:35px;vertical-align: middle;text-align: center;">&nbsp;&nbsp;หมายเหตุ : บัญชี {{ $settingbill->setheadbill_selectaccount}} </td>
                </tr>
            </thead>
        </table>
        <table style="border:1px solid;border-top: 0px solid;width:100%;border-collapse: collapse;border-spacing: 0 1em;font-size: 16px;">
            <thead>
                <tr>
                    <td width="28%" style="height:30px;vertical-align: middle;text-align: left;">&nbsp;&nbsp;ผู้รับบิล </td>
                    <td width="28%" style="height:30px;vertical-align: middle;text-align: left;">&nbsp;&nbsp;ผู้รับเงิน </td>
                    <td width="24%"  style="border:1px solid;height:30px;vertical-align: middle;text-align: center;background: #e2e2e291;">&nbsp;&nbsp;รวมราคา(SUB TOTAL)</td>
                    <td width="20%" style="height:30px;vertical-align: middle;text-align: right;">{{ number_format($total,2) }}&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td width="28%" style="height:30px;vertical-align: middle;text-align: left;">&nbsp;&nbsp;Received by: _______________________ </td>
                    <td width="28%" style="height:30px;vertical-align: middle;text-align: left;">&nbsp;&nbsp;Received by: _______________________ </td>
                    <td width="24%"  style="border:1px solid;height:30px;vertical-align: middle;text-align: center;background: #e2e2e291;">&nbsp;&nbsp;ค่าจัดส่ง(SHIPPING&HANDLING FEE)</td>
                    <td width="20%" style="height:30px;vertical-align: middle;text-align: right;">{{ number_format($totalshippingcost,2) }}&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td width="28%" style="height:30px;vertical-align: middle;text-align: center;">&nbsp;&nbsp;(ลงลายมือชื่อและประทับตราถ้ามี) </td>
                    <td width="28%" style="height:30px;vertical-align: middle;text-align: center;">&nbsp;&nbsp;(ลงลายมือชื่อและประทับตราถ้ามี) </td>
                    <td width="24%"  style="border:1px solid;height:30px;vertical-align: middle;text-align: center;background: #e2e2e291;">&nbsp;&nbsp;รวมเงินทั้งสิ้น(TOTAL)</td>
                    <td width="20%" style="height:30px;vertical-align: middle;text-align: right;">{{ number_format($total+$totalshippingcost,2) }}&nbsp;&nbsp;</td>
                </tr>
            </thead>
        </table>
    </body>
</html>