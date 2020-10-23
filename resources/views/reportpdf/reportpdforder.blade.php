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
        @if(!empty($results))
        <div style="margin-top: 5px;"></div>
        <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;text-align: center;">
            <thead>
                <tr>
                    <td><h3>รายงานออเดอร์</h3></td>
                </tr>
            </thead>
        </table>
        <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;">
            <thead>
                <tr>
                    <td height="15" colspan="6" style="border:hidden;text-align:left;line-height:10px;line-height:10px;font-size: 16px;" > วันที่ : @if(!empty($datestart)) {{$datestart}} @else {{date("d/m/Y",strtotime($results[0]['date']))}} @endif - @if(!empty($dateend)) {{$dateend}} @else {{ date("d/m/Y",strtotime($results[count($results)-1]['date']))}} @endif
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ประเภทสินค้า : {{$showtype}}
                    </td>
                </tr>
            </thead>
        </table>
        <div style="margin-top: 12px;"></div>
        <table style="border:1px solid;width:100%;border-collapse: collapse;border-spacing: 0 1em;">
            <thead>
                <tr>
                    <td width="6%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">ลำดับ</td>
                    <td width="10%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">รหัสสินค้า</td>
                    <td width="20%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">ชื่อสินค้า</td>
                    <td width="8%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">ประเภท</td>
                    <td width="15%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">ชื่อซัฟพลายเออร์</td>
                    <td width="9%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">เบอร์</td>
                    <td width="10%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">จำนวนหน่วยใหญ่</td>
                    <td width="10%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">จำนวนหน่วยย่อย</td>
                    <td width="7%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">วันที่สั่ง</td>
                    <td width="7%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">วันที่ส่ง</td>
                    <td width="7%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">จำนวนทั้งหมด</td>
                </tr>
            </thead>
            <tbody>
                @php
                
                $count = 2;
                @endphp
                @foreach($results as $key => $item)
                    @php
                    
                    $suppliername= '';
                    $suppliertel= '';
                    @endphp
                    @foreach($item['supplier_name'] as $keys => $items)
                        @if($items->supplier_name)
                            @php
                            $suppliername .= $items->supplier_name;
                            $suppliertel .= $items->supplier_tel;
                            @endphp
                            @if($keys != count($results)-1)
                                @php
                                $suppliername .= ' , ';
                                $suppliertel .= ' , ';
                                @endphp
                            @endif
                        @endif

                    @endforeach
                    <tr>
                        <td style="text-align: center;border-right:1px solid;">{{ $key+1 }}</td>
                        <td style="text-align: center;border-right:1px solid;">{{ $item['code'] }}</td>
                        <td style="border-right:1px solid;">{{ $item['name'] }}</td>
                        <td style="border-right:1px solid;">{{ $item['typeproduct'] }}</td>
                        <td style="border-right:1px solid;">{{ $suppliername }}</td>
                        <td style="border-right:1px solid;">{{ $suppliertel }}</td>
                        <td style="text-align: center;border-right:1px solid;">{{ $item['bigunit'] }}</td>
                        <td style="text-align: center;border-right:1px solid;">{{ $item['smallunit'] }}</td>
                        <td style="border-right:1px solid;"></td>
                        {{-- <td style="border-right:1px solid;"></td> --}}
                        <td style="text-align: center;border-right:1px solid;">{{ $item['product_qty'] }}</td>
                    </tr>
                @if($key%32 == 0)
                    {{-- <div class="page-break"></div> --}}
                    {{-- @php $count = 0; @endphp --}}
                @endif
                @php $count++; @endphp
                @endforeach
                @if($count%32 != 0)
                    @for($x=$count%32;$x<=32;$x++)
                        <tr>
                            <td style="border-right:1px solid;">&nbsp;</td>
                            <td style="border-right:1px solid;"></td>
                            <td style="border-right:1px solid;"></td>
                            <td style="border-right:1px solid;"></td>
                            <td style="border-right:1px solid;"></td>
                            <td style="border-right:1px solid;"></td>
                            <td style="border-right:1px solid;"></td>
                            <td style="border-right:1px solid;"></td>
                            <td style="border-right:1px solid;"></td>
                        </tr>
                    @endfor
                @endif
            </tbody>
        </table>
        {{-- @endforeach --}}
        @endif
    </body>
</html>