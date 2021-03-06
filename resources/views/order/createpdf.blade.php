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
                font-size :18px;
            }
            table{
                font-size :18px;
            }
            div{
                font-size :18px;
            }
            @page {
                footer: page-footer;
                margin-top: 0px;
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
        <br>
        <div class="row">
            <div class="col-md-9" style="width: 75%;float: left;">
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
            <div class="col-md-3" style="width: 24%;float: right;">
                <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;"> 
                    <thead>
                        <tr>
                            <td style="border:hidden;text-align:right;line-height:10px;line-height:10px" >
                                <h4>ต้นฉบับใบส่งสินค้าชั่วคราว</h4>
                            </td>
                        </tr>
                        <tr>
                            <td style="border:hidden;text-align:right;line-height:10px;line-height:10px" >
                                <h4>ORIGINAL DELIVERY ORDER</h4>
                            </td>
                        </tr>
                        <tr><td >&nbsp;</td></tr>
                        <tr style="margin-top: 10px;">
                            <td height="17" colspan="2" style="border:hidden;text-align:left;line-height:15px;" >
                                เลขที่   {{ $data[0] -> export_inv }}
                                <br>
                                Bill No.
                            </td>
                        </tr>
                        <tr style="margin-top: 10px;">
                            <td height="17" colspan="2" style="border:hidden;text-align:left;line-height:15px;" >
                                วันที่   {{ $data[0] -> export_date }}
                                <br>
                                Date.
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <br>
        <div style="border:1px solid;border-radius: 2%;padding: 15px 10px;">
            <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;">
                <thead style="">
                    {{-- <tr><td colspan="7">&nbsp;</td></tr> --}}
                    {{-- <tr><td colspan="7" style="border:1px solid;height:35px;vertical-align: middle;background: #e2e2e291;"><b>&nbsp;&nbsp;รายละเอียดการสั่งซื้อ</b></td></tr> --}}
                    <tr style="margin-top: 20px;">
                        <td height="17" width="100" colspan="1" style="border:hidden;text-align:left;line-height:15px;" >
                            นามลูกค้า
                        </td>
                        <td colspan="6" rowspan="2" style="border:hidden;text-align:left;line-height:15px;vertical-align: top;">{{ $data[0] -> customer_name }}</td>
                    </tr>
                    <tr style="margin-top: 5px;">
                        <td height="17" width="100" colspan="1" style="border:hidden;text-align:left;line-height:15px;" >
                            Customer Name
                        </td>
                    </tr> 
                    {{-- <tr><td colspan="7">&nbsp;</td></tr> --}}
                    <tr style="margin-top: 40px;">
                        <td height="17" width="100" colspan="1" style="border:hidden;text-align:left;line-height:25px;" >
                            ที่อยู่
                            <br>
                        </td>
                        <td colspan="6" rowspan="2" style="border:hidden;text-align:left;line-height:25px;vertical-align: top;">{{ $data[0] -> customer_address1 }} {{ $data[0] -> customer_address2 }} {{ $data[0] -> customer_address2 }} {{ $data[0] -> customer_address3}} {{ $data[0] -> customer_address4}} {{ $data[0] -> customer_address5 }}</td>
                    </tr>
                    <tr style="margin-top: 5px;">
                        <td height="17" width="100" colspan="1" style="border:hidden;text-align:left;line-height:15px;" >
                            Address
                        </td>
                    </tr> 
                </thead>
            </table>
        </div>
        <div style="margin-top: 12px;"></div>
        {{-- <br> --}}
        <div style="border:1px solid;border-radius: 2%;">
            <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;">
                <thead>
                    {{-- <tr><td colspan="7">&nbsp;</td></tr> --}}
                    {{-- border-top-left-radius: 2%; --}}
                    <tr>
                        <td colspan="1" style="border-right:1px solid;height:35px;vertical-align: middle;background: #e2e2e291;text-align: center;">&nbsp;&nbsp;<b>ลำดับ<br>Item</b></td>
                        <td colspan="3" style="border-right:1px solid;height:35px;vertical-align: middle;background: #e2e2e291;text-align: center;">&nbsp;&nbsp;<b>รายการสินค้า<br>Description of Goods</b></td>
                        <td colspan="1" style="border-right:1px solid;height:35px;vertical-align: middle;background: #e2e2e291;text-align: center;">&nbsp;&nbsp;<b>จำนวน<br>Quantity</b></td>
                        <td colspan="1" style="border-right:1px solid;height:35px;vertical-align: middle;background: #e2e2e291;text-align: center;">&nbsp;&nbsp;<b>ราคาต่อหน่วย<br>Unit Price</b></td>
                        <td colspan="1" style="height:35px;vertical-align: middle;background: #e2e2e291;text-align: center;">&nbsp;&nbsp;<b>จำนวนเงิน<br>Amount</b></td>
                    </tr>
                    @php
                    $total = 0;
                    $ratesend = 0;
                    @endphp
                    @foreach($data as $key => $item)
                    @php
                    // $total  =  $total + ($item -> order_qty * $item -> order_price);
                    @endphp
                    <tr>
                        {{-- <td style="border:1px solid;height:60px;" colspan="1" >
                            <img width="100" src="{{asset('assets/images/product')}}/{{ $item -> product_picture }}">
                        </td> --}}
                        <td width="10%" style="border-right:1px solid;height:30px;text-align: center;">{{ $key + 1 }}</td>
                        <td width="45%" style="border-right:1px solid;height:30px;" colspan="3" >
                            &nbsp;&nbsp;{{ $item -> product_name }}
                        </td>
                        <td width="15%" style="border-right:1px solid;height:30px;text-align: center;" colspan="1" >
                            &nbsp;&nbsp;{{ $item -> order_qty }}
                        </td>
                        <td width="15%" style="border-right:1px solid;height:30px;text-align: center;" colspan="1" >
                            &nbsp;&nbsp;{{ number_format($item -> order_price,2) }}
                        </td>
                        <td width="15%" style="height:30px;text-align: right;" colspan="1" >
                           {{ number_format($item -> order_qty * $item -> order_price ,2) }}&nbsp;&nbsp;
                        </td>
                    </tr>
                    @endforeach
                    @for($x = count($data);$x < 14;$x++)
                    <tr>
                        <td width="10%" style="border-right:1px solid;height:30px;text-align: center;" colspan="1" ></td>
                        <td width="45%" style="border-right:1px solid;height:30px;" colspan="3" ></td>
                        <td width="15%" style="border-right:1px solid;height:30px;text-align: center;" colspan="1" ></td>
                        <td width="15%" style="border-right:1px solid;height:30px;text-align: center;" colspan="1" ></td>
                        <td width="15%" style="height:30px;text-align: right;" colspan="1" ></td>
                    </tr>
                    @endfor
                    <tr>
                        <td colspan="7" style="border-bottom:1px solid;border-top:1px solid;height:35px;vertical-align: middle;text-align: center;">&nbsp;&nbsp;หมายเหตุ : บัญชี<b>คุณเพ็ญศรี  ด่านวัฒนาศิริ</b> ธนาคารกสิกรไทย สาขาวงแหวนรอบนอก <b>728-1-02164-2<br> </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="border-right:1px solid;border-top:1px solid;height:35px;vertical-align: middle;text-align: left;background: #e2e2e291;">&nbsp;&nbsp;จำนวนเงิน(ตัวอักษร) {{ tranfer($data[0] -> export_totalpayment) }}</td>
                        <td colspan="1" style="border-right:1px solid;border-top:1px solid;height:35px;vertical-align: middle;text-align: center;">&nbsp;&nbsp;รวมทั้งสิน<br>Grand Total</td>
                        <td colspan="1" style="border-top:1px solid;height:35px;vertical-align: middle;text-align: right;background: #e2e2e291;">{{ number_format($data[0] -> export_totalpayment,2) }}&nbsp;&nbsp;</td>
                    </tr>
                </thead>
            </table>
        </div>
        <div style="margin-top: 12px;"></div>
        <div style="border:1px solid;border-radius: 2%;">
            <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;">
                <thead>
                    <tr>
                        <td width="20%" colspan="1" style="padding:5px;border-right:1px solid;height:35px;vertical-align: middle;text-align: center;">
                            &nbsp;<br>
                            ................................................<br>
                            ผู้เปิดบิล<br>
                            วันที่.........................................
                        </td>
                        <td width="20%" colspan="1" style="padding:5px;border-right:1px solid;height:35px;vertical-align: middle;text-align: center;">
                            &nbsp;<br>
                            ................................................<br>
                            ผู้เช็คสินค้า<br>
                            วันที่.........................................
                        </td>
                        <td width="20%" colspan="1" style="padding:5px;border-right:1px solid;height:35px;vertical-align: middle;text-align: center;">
                            &nbsp;<br>
                            ................................................<br>
                            ผู้ส่งสินค้า<br>
                            วันที่.........................................
                        </td>
                        <td width="20%" colspan="1" style="padding:5px;border-right:1px solid;height:35px;vertical-align: middle;text-align: center;">
                            &nbsp;<br>
                            ................................................<br>
                            ผู้รับสินค้า<br>
                            วันที่.........................................
                        </td>
                        <td width="20%" colspan="1" style="padding:5px;height:35px;vertical-align: middle;text-align: center;">
                            &nbsp;<br>
                            ................................................<br>
                            ผู้รับเงิน<br>
                            วันที่.........................................
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
        <div style="margin-top: 12px;"></div>
        <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;">
            <thead>
                <tr>
                    <td>หมายเหตุ</td>
                    <td rowspan="4"><img src="data:image/png;base64,{{ $barcode }}"  alt="barcode" class="barcode" /></td>
                </tr>
                <tr>
                    <td>1.สินค้าชำรุดหรือเสียหายโปรดแจ้งบริษัทภายใน 3 วัน มิฉะนั้นทางบริษัทฯ จะถือว่าลูกค้ายินยอมรับสินค้า</td>
                </tr>
                <tr>
                    <td>2.ได้สั่งซื้อและตรวจสินค้าตามราคาและจำนวนดังระบุข้างต้นไว้ครบถ้วนตามสภาพเรียบร้อยดีและถูกต้องทุกประการ</td>
                </tr>
                <tr>
                    <td>3.สินค้าตามใบส่งสินค้านี้แม้จะได้ส่งมอบแก่ผู้ซื้อแล้ว ยังคงเป็นทรัพย์สินของผู้ขาย จนกว่าผู้ซื้อได้ชำระเงินเสร็จเรียบร้อยแล้ว</td>
                </tr>
            </thead>
        </table>
    </body>
</html>