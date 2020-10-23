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
    </head>
    <body>

        @if(count($data) > 0)
        <div style="margin-top: 5px;"></div>
        <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;text-align: center;">
            <thead>
                <tr>
                    <td><h3>รายงานซัฟฟลายเออร์</h3></td>
                </tr>
            </thead>
        </table>
        <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;">
            <thead>
                <tr>
                    <td height="15" colspan="6" style="border:hidden;text-align:left;line-height:10px;line-height:10px;font-size: 16px;" > วันที่ : @if(!empty($datestart)) {{$datestart}} @else {{date("d/m/Y",strtotime($data[0]['date']))}} @endif - @if(!empty($dateend)) {{$dateend}} @else {{ date("d/m/Y",strtotime($data[count($data)-1]['date']))}} @endif
                    </td>
                </tr>
                <tr>
                    <td height="15" colspan="6" style="border:hidden;text-align:left;line-height:10px;line-height:10px;font-size: 16px;" > ชื่อ : {{$data[0]->supplier_name}} ถึง {{$data[count($data)-1]->supplier_name}}
                    </td>
                </tr>
            </thead>
        </table>
        <div style="margin-top: 12px;"></div>
        <table style="border:1px solid;width:100%;border-collapse: collapse;border-spacing: 0 1em;">
            <thead>
                <tr>
                    <td width="7%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">ลำดับที่</td>
                    <td width="10%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">ชื่อผู้ผลิต</td>
                    <td width="6%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">ละติจูดและลองจิจูด</td>
                    <td width="10%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">เบอร์ติดต่อ</td>
                    <td width="15%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">อีเมล์</td>
                    <td width="10%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">เลขประจำตัวผู้เสียภาษี</td>
                    <td width="10%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">ชำระ</td>
                    <td width="8%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">ยอดซื้อทั้งหมด</td>
                </tr>
            </thead>
            <tbody>
                @if(!empty($data))
                @foreach($data as $key => $value)
                    <tr>
                        <td style="text-align: center;border-right:1px solid;">{{ $key+1 }}</td>
                         <td style="border-right:1px solid;">{{ $value->supplier_name }}</td>
                         <td style="border-right:1px solid;">{{ $value->lat.','.$value->lng }}</td>
                         <td style="border-right:1px solid;">{{ $value->supplier_tel }}</td>
                         <td style="border-right:1px solid;">{{ $value->supplier_email }}</td>
                         <td style="border-right:1px solid;">{{ $value->supplier_tax }}</td>
                         <td style="border-right:1px solid;text-align: right;">{{ $value->notpay }} - </td>
                         <td style="text-align: right;">{{ $value->total }} - </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        @else
        <div style="margin-top: 5px;"></div>
        <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;text-align: center;">
            <thead>
                <tr>
                    <td><h1>ไม่มีข้อมูล</h1></td>
                </tr>
            </thead>
        </table>
        @endif
    </body>
</html>