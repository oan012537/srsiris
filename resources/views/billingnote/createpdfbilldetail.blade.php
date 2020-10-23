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

function trandate($year){
    return $year+543;

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
        {{-- <div style="border:1px solid;border-radius: 0%;padding: 20px 10px;"> --}}
            <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;">
                <thead style="">
                    <tr style="margin-top: 20px;">
                        <td width="26%" style="border:2px solid;border-right:0px;text-align:right;line-height:15px;vertical-align: top;padding: 10px;padding-right: 20px;"><img src="{{asset('assets/images/logo.png')}}" width="50px" height="30px"><br><h3> SR SIRI&nbsp;</h3></td>
                        <td width="41%" style="border:2px solid;border-left:0px;border-right: 1px solid;text-align:right;line-height:15px;vertical-align: middle;padding:25px 0px;padding-right: 50px;"><h1>รายการส่งสินค้า ณ วันที่</h1></td>
                        <td width="35%" style="border:2px solid;text-align:center;line-height:15px;vertical-align: middle;padding:20px 0px;"><h1>{{ date("d/m",strtotime($data[0]->billingnote_date)) }}/{{ trandate(date("Y",strtotime($data[0]->billingnote_date)))}}</h1></td>
                    </tr>
                </thead>
            </table>
        {{-- </div> --}}
        {{-- <div style="margin-top: 12px;"></div> --}}
        {{-- <br> --}}
        <div style="border:2px #ffff solid;border-bottom:2px #ffffff solid;border-radius: 0%;margin-top: -8px">
            <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;">
                <thead>
                    {{-- <tr><td colspan="7">&nbsp;</td></tr> --}}
                    {{-- border-top-left-radius: 2%; --}}
                    <tr>
                        <td width="10%" style="width:8px;border-left:2px solid;border-right:2px solid;border-bottom:2px solid;height:35px;vertical-align: middle;background: #ffffff;text-align: center;border-top:2px solid;">เลขที่บิล</td>
                        <td width="25%" style="width:25px;border-right:2px solid;border-bottom:2px solid;height:35px;vertical-align: middle;background: #ffffff;text-align: center;border-top:2px solid;">ชื่อลูกค้า</td>
                        <td width="8%" style="width:8px;border-right:2px solid;border-bottom:2px solid;height:35px;vertical-align: middle;background: #ffffff;text-align: center;border-top:2px solid;">กล่อง</td>
                        <td width="7%" style="width:8px;border-right:2px solid;border-bottom:2px solid;height:35px;vertical-align: middle;background: #ffffff;text-align: center;border-top:2px solid;">ห่อ</td>
                        <td width="7%" style="width:8px;border-right:2px solid;border-bottom:2px solid;height:35px;vertical-align: middle;background: #ffffff;text-align: center;border-top:2px solid;">มัด</td>
                        <td width="8%" style="width:8px;border-right:2px solid;border-bottom:2px solid;height:35px;vertical-align: middle;background: #ffffff;text-align: center;border-top:2px solid;">กส.</td>
                        <td width="20%" style="width:20px;border-right:2px solid;border-bottom:2px solid;height:35px;vertical-align: middle;background: #ffffff;text-align: center;border-top:2px solid;">ชื่อขนส่ง</td>
                        <td width="15%" style="width:15px;border-right:2px solid;height:35px;border-bottom:2px solid;vertical-align: middle;background: #ffffff;text-align: center;border-top:2px solid;">เลขที่บิลขนส่ง</td>

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
                        <td width="10%" style="border-left:2px solid;border-right:1px solid;border-bottom:1px solid;height:30px;text-align: center;">
                            {{ $item->selling_inv}}
                        </td>
                        <td width="25%" style="border-right:1px solid;border-bottom:1px solid;height:30px;" >
                            &nbsp;&nbsp;{{ $item->selling_customername}}
                        </td>
                        <td width="8%" style="border-right:1px solid;border-bottom:1px solid;height:30px;text-align: center;"  >
                            &nbsp;
                        </td>
                        <td width="7%" style="border-right:1px solid;border-bottom:1px solid;height:30px;text-align: center;" >
                            &nbsp;
                        </td>
                        <td width="7%" style="border-right:1px solid;border-bottom:1px solid;height:30px;text-align: center;"  >
                            &nbsp;
                        </td>
                        <td width="8%" style="border-right:1px solid;border-bottom:1px solid;height:30px;text-align: center;" >
                            &nbsp;
                        </td>
                        <td width="20%" style="border-right:1px solid;border-bottom:1px solid;height:30px;text-align: left;" >
                            &nbsp;{{ $item->trans_emp }}
                        </td>
                        <td width="15%" style="border-right:2px solid;height:30px;text-align: center;border-bottom:1px solid;" >
                           {{ $item->trans_invoice }}
                        </td>
                    </tr>
                    @endforeach
                    @for($x = count($data);$x < 26;$x++)
                    <tr>
                        <td width="8%" style="border-left:2px solid;border-right:1px solid;height:30px;text-align: center;" ></td>
                        <td width="25%" style="border-right:1px solid;height:30px;" ></td>
                        <td width="8%" style="border-right:1px solid;height:30px;text-align: center;" ></td>
                        <td width="8%" style="border-right:1px solid;height:30px;text-align: center;" ></td>
                        <td width="8%" style="border-right:1px solid;height:30px;text-align: center;" ></td>
                        <td width="8%" style="border-right:1px solid;height:30px;text-align: center;" ></td>
                        <td width="20%" style="border-right:1px solid;height:30px;text-align: center;" ></td>
                        <td width="15%" style="border-right:2px solid;height:30px;text-align: right;" ></td>
                    </tr>
                    @endfor
                    <tr>
                        <td colspan="1" style="border-top:2px solid;height:30px;vertical-align: middle;text-align: right;">&nbsp;&nbsp;</td>
                        <td colspan="1" style="border-right:1px solid;border-left:2px solid;border-top:1px solid;border-bottom:2px solid;height:30px;vertical-align: middle;text-align: center;">รวม</td>
                        <td colspan="1" style="border-right:1px solid;border-top:1px solid;border-bottom:2px solid;height:30px;vertical-align: middle;text-align: center;">&nbsp;</td>
                        <td colspan="1" style="border-right:1px solid;border-top:1px solid;border-bottom:2px solid;height:30px;vertical-align: middle;text-align: center;">&nbsp;</td>
                        <td colspan="1" style="border-right:1px solid;border-top:1px solid;border-bottom:2px solid;height:30px;vertical-align: middle;text-align: center;">&nbsp;</td>
                        <td colspan="1" style="border-right:2px solid;border-top:1px solid;border-bottom:2px solid;height:30px;vertical-align: middle;text-align: center;">&nbsp;</td>
                        <td colspan="2" style="border-top:2px solid;border-bottom:1px #ffffff solid;height:30px;vertical-align: middle;text-align: center;">&nbsp;</td>
                    </tr>
                </thead>
            </table>
        </div>
        <div style="margin-top: 18px;"></div>
        <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;">
            <thead>
                <tr>
                    <td width="100%" style="padding:0px 40px;height:35px;vertical-align: middle;text-align: left;">
                        จำนวนบิลที่ชมพูหลังออกส่งวันที่ปัจจุบัน..........................บิล...........................โพย&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลายเซ็น...................................................................................(แพ๊คสินค้า)
                    </td>
                </tr>
                <tr>
                    <td width="100%" style="padding:0px 40px;height:35px;vertical-align: middle;text-align: left;">
                        จำนวนบิลวันที่ปัจจุบันในคอม..........................บิล/บิลต้นฉบับ...........................โพย&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลายเซ็น...................................................................................(ออฟฟิต)
                    </td>
                </tr>
                <tr>
                    <td width="100%" style="padding:0px 40px;height:35px;vertical-align: middle;text-align: left;">
                        ค่าขนส่ง......................................เงินสดคงเหลือ......................................
                    </td>
                </tr>
                <tr>
                    <td width="100%" style="padding:0px;padding-right:100px;height:35px;vertical-align: middle;text-align: right;">
                        ผู้จัดการ...........................................................................
                    </td>
                </tr>
            </thead>
        </table>
    </body>
</html>