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
                font-size :16px;
            }
            table{
                font-size :16px;
            }
            div{
                font-size :16px;
            }
            @page {
                footer: page-footer;
                margin-top: 15px;
                margin-left: 20px;
                margin-right: 20px;
                margin-bottom: 34px;
            }
            .page-break {
                page-break-before: always;
            }
        </style>
        {{-- <title>{{ $data[0] -> order_no }}</title> --}}
    </head>
    <body>
        {{-- <div class="page-break">kkkkkkkkk</div> --}}
        @php
        $totalall = 0;
        @endphp
        @if(!empty($data))
        <div style="margin-top: 5px;"></div>
        <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;text-align: center;">
            <thead>
                <tr>
                    <td><h3>รายงานสต๊อก</h3></td>
                </tr>
            </thead>
        </table>
        <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;">
            <thead>
                <tr>
                    <td height="15" colspan="6" style="border:hidden;text-align:left;line-height:10px;line-height:10px;font-size: 16px;" > วันที่ : @if(!empty($datestart)) {{$datestart}} @else {{date("d/m/Y",strtotime($results[0]['date']))}} @endif - @if(!empty($dateend)) {{$dateend}} @else {{ date("d/m/Y",strtotime($results[count($results)-1]['date']))}} @endif
                    </td>
                </tr>
            </thead>
        </table>
        <div style="margin-top: 12px;"></div>
        <table style="border:1px solid;width:100%;border-collapse: collapse;border-spacing: 0 1em;">
            <thead>
                <tr>
                    <td width="6%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">ลำดับ</td>
                    <td width="20%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">ชื่อสินค้า</td>
                    <td width="10%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">หมวดหมู่</td>
                    <td width="8%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">วันที่</td>
                    <td width="15%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">เลขที่บิล</td>
                    <td width="9%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">ราคาขาย</td>
                    <td width="10%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">ต้นทุนสินค้า</td>
                    <td width="10%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">กำไร</td>
                    <td width="7%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">จำนวนที่ซื้อเข้า</td>
                    <td width="7%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">จำนวนที่ขายออก</td>
                    <td width="7%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">เปอร์เซ็นกำไร</td>
                </tr>
            </thead>
            <tbody>
                @php $a = 3 @endphp
                @foreach($data as $key => $item)
                <tr>
                    <td style="text-align: center;border-right: 1px solid;margin-left: 5px;">{{ $key+1 }}</td>
                    <td style="border-right: 1px solid;margin-left: 5px;">{{ $item['name'] }}</td>
                    <td style="border-right: 1px solid;margin-left: 5px;">{{ $item['category'] }}</td>
                    <td style="border-right: 1px solid;margin-left: 5px;">{{ $item['date'] }}</td>
                    <td style="border-right: 1px solid;margin-left: 5px;">{{ $item['bill'] }}</td>
                    <td style="border-right: 1px solid;margin-right: 10px;text-align: right;">{{ $item['price'] }}</td>
                    <td style="border-right: 1px solid;margin-right: 10px;text-align: right;">{{ $item['capital'] }}</td>
                    <td style="border-right: 1px solid;margin-right: 10px;text-align: right;">{{ $item['profit'] }}</td>
                    <td style="border-right: 1px solid;margin-right: 10px;text-align: right;">{{ $item['amount'] }}</td>
                    <td style="border-right: 1px solid;margin-right: 10px;text-align: right;">{{ $item['out'] }}</td>
                    <td style="margin-right: 10px;text-align: right;">{{ $item['percen'] }}</td>
                </tr>
                @php $a++ @endphp
                @endforeach
                @for($x = $a%35;$x < 35;$x++)
                <tr>
                    <td style="border-right: 1px solid;color: white;">x </td>
                    <td style="border-right: 1px solid;"></td>
                    <td style="border-right: 1px solid;"></td>
                    <td style="border-right: 1px solid;"></td>
                    <td style="border-right: 1px solid;"></td>
                    <td style="border-right: 1px solid;"></td>
                    <td style="border-right: 1px solid;"></td>
                    <td style="border-right: 1px solid;"></td>
                    <td style="border-right: 1px solid;"></td>
                    <td style="border-right: 1px solid;"></td>
                    <td style=""></td>
                </tr>
                @endfor
            </tbody>
        </table>
        {{-- @endforeach --}}
        @endif
    </body>
</html>