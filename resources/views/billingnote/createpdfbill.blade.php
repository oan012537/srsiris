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
        {{-- @if(!empty($sheet))  เอาไว้เช็คจำนวน --}}
        {{-- @foreach($sheet as $key => $value) --}}
        <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;">
            <thead>
                <tr>
                    <td height="15" colspan="5" style="border:hidden;text-align:left;line-height:10px;line-height:10px" >
                        {{date("Y-m-d")}}
                    </td>
                    <td height="15" colspan="1" style="border:hidden;text-align:right;line-height:10px;line-height:10px" >
                        {{-- หน้า  --}}
                    </td>
                </tr>
            </thead>
        </table>
        <div style="margin-top: 5px;"></div>
        <table style="width:100%;border-collapse: collapse;border-spacing: 0 1em;">
            <thead>
                <tr>
                    <td height="15" colspan="6" style="border:hidden;text-align:left;line-height:10px;line-height:10px;font-size: 16px;" >เฉพาะ วันที่ : @if(!empty($datestart)){{$datestart}}@else{{$data[0]->data[0]->billingnote_date}}@endif - @if(!empty($dateend)){{$dateend}}@else{{$data[count($data)-1]->data[count($data[count($data)-1]->data)-1]->billingnote_date}}@endif 
                    </td>
                </tr>
                <tr>
                    <td height="15" colspan="6" style="border:hidden;text-align:left;line-height:10px;line-height:10px;font-size: 16px;" >เฉพาะ สถานะบิล : @if(!empty($staus)){{ $staus}} @else - @endif
                    </td>
                </tr>
                <tr>
                    <td height="15" colspan="6" style="border:hidden;text-align:left;line-height:10px;line-height:10px;font-size: 16px;" >เฉพาะ สถานะบิล : @if(!empty($staus)){{ $staus}} @else - @endif
                    </td>
                </tr>
                <tr>
                    <td height="15" colspan="6" style="border:hidden;text-align:left;line-height:10px;line-height:10px;font-size: 16px;" >เฉพาะ หมวดลูกค้า : @if(!empty($area)){{ $area->area_name}} @else - @endif
                    </td>
                </tr>
                <tr>
                    <td height="15" colspan="5" style="border:hidden;text-align:left;line-height:10px;line-height:10px;font-size: 16px;" >เลขที่ : {{$data[0]->data[0]->billingnote_inv}}&nbsp;&nbsp; ถึง : {{$data[count($data)-1]->data[count($data[count($data)-1]->data)-1]->billingnote_inv}}
                    </td>
                    <td height="15" colspan="1" style="border:hidden;text-align:right;line-height:10px;line-height:10px;font-size: 16px;" > &nbsp;&nbsp; ณ วันที่ : {{ date("d/m/Y") }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td height="15" colspan="6" style="border:hidden;text-align:left;line-height:10px;line-height:10px;font-size: 16px;" >[D1] ใบส่งสินค้าชั่วคราว
                    </td>
                </tr>
            </thead>
        </table>
        <div style="margin-top: 12px;"></div>
        <table style="border:1px solid;width:100%;border-collapse: collapse;border-spacing: 0 1em;">
            <thead>
                <tr>
                    <td width="8%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">หมวด/เลขที่</td>
                    <td width="6%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">วันที่</td>
                    <td width="6%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">อ้างถึง</td>
                    <td width="20%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">รายการ</td>
                    <td width="9%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">เงินรวม/ค้างจ่าย</td>
                    <td width="6%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">ขนส่ง</td>
                    <td width="10%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">ธนาคาร</td>
                    <td width="8%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">วันที่เช็ค</td>
                    <td width="9%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">เลขที่เช็ค</td>
                    <td width="8%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">จำนวนเงิน</td>
                    <td width="10%" style="border:1px solid;height:25px;vertical-align: middle;text-align: center;">หมายเหตุ</td>
                </tr>
            </thead>
            <tbody>
                @php
                
                $ratesend = 0;
                $a = 1;
                @endphp
                @foreach($data as $key => $item)
                @php
                $x = 0;
                $total = 0;
                $a++;
                @endphp
                <tr>
                    <td width="8%" style="height:25px;text-align: center;">&nbsp;</td>
                    <td width="6%" style="height:25px;" >&nbsp;</td>
                    <td width="6%" style="height:25px;text-align: center;">&nbsp;</td>
                    <td width="20%" style="height:25px;text-align: center;" >
                        <b>{{ $item -> selling_customername }}</b>
                    </td>
                    <td width="9%" style="height:25px;text-align: right;" >&nbsp;</td>
                    <td width="6%" style="height:25px;text-align: center;" >&nbsp;</td>
                    <td width="10%" style="height:25px;text-align: center;" >&nbsp;</td>
                    <td width="8%" style="height:25px;text-align: center;" >&nbsp;</td>
                    <td width="9%" style="height:25px;text-align: center;" >&nbsp;</td>
                    <td width="8%" style="height:25px;text-align: center;" >&nbsp;</td>
                    <td width="10%" style="height:25px;text-align: center;" >&nbsp;</td>
                </tr>
                @foreach($item->data as $keys => $items)
                @php
                $border = '';

                if($keys == count($item->data)-1){
                    $border = "border-bottom:1px solid;";
                }
                $total  =  $total + $items -> billingnote_total;
                $a++;
                @endphp
                <tr>
                    {{-- <td style="border:1px solid;height:60px;" colspan="1" >
                        <img width="100" src="{{asset('assets/images/product')}}/{{ $item -> product_picture }}">
                    </td> --}}
                    <td width="8%" style="height:25px;text-align: center;">{{ $items -> billingnote_inv }}</td>
                    <td width="6%" style="height:25px;" >
                        {{ $items -> billingnote_date }}
                    </td>
                    <td width="6%" style="height:25px;text-align: center;">
                        &nbsp;&nbsp;
                    </td>
                    <td width="20%" style="height:25px;text-align: center;" >
                        {{ $items -> selling_customername }}
                    </td>
                    <td width="9%" style="height:25px;text-align: right;" >
                        {{ number_format($items -> billingnote_total,2) }} &nbsp;-&nbsp;
                    </td>
                    <td width="6%" style="height:25px;text-align: center;" >
                        &nbsp;
                    </td>
                    <td width="10%" style="height:25px;text-align: center;" >
                        &nbsp;
                    </td>
                    <td width="8%" style="height:25px;text-align: center;" >
                        &nbsp;
                    </td>
                    <td width="9%" style="height:25px;text-align: center;" >
                        &nbsp;
                    </td>
                    <td width="8%" style="height:25px;text-align: center;" >
                        &nbsp;
                    </td>
                    <td width="10%" style="height:25px;text-align: center;" >
                        &nbsp;
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td width="8%" style="height:25px;{{$border}}text-align: center;">&nbsp;</td>
                    <td width="6%" style="height:25px;{{$border}}" >&nbsp;</td>
                    <td width="6%" style="height:25px;{{$border}}text-align: center;">&nbsp;</td>
                    <td width="20%" style="height:25px;{{$border}}text-align: center;" >
                        [ รวม {{ $item -> selling_customername }} พักยอด]
                    </td>
                    <td width="9%" style="height:25px;{{$border}}text-align: right;" >{{number_format($total,2)}} &nbsp;-&nbsp;</td>
                    <td width="6%" style="height:25px;{{$border}}text-align: center;" >&nbsp;</td>
                    <td width="10%" style="height:25px;{{$border}}text-align: center;" >&nbsp;</td>
                    <td width="8%" style="height:25px;{{$border}}text-align: center;" >&nbsp;</td>
                    <td width="9%" style="height:25px;{{$border}}text-align: center;" >&nbsp;</td>
                    <td width="8%" style="height:25px;{{$border}}text-align: center;" >&nbsp;</td>
                    <td width="10%" style="height:25px;{{$border}}text-align: center;" ></td>
                </tr>
                @php
                $a++;
                @endphp
                @endforeach
                
                @for($x = count($data);$x < 18;$x++)
                
                <tr>
                    <td width="8%" style="height:25px;text-align: center;" ></td>
                    <td width="6%" style="height:25px;text-align: center;" ></td>
                    <td width="6%" style="height:25px;text-align: center;" ></td>
                    <td width="20%" style="height:25px;text-align: center;" ></td>
                    <td width="9%" style="height:25px;text-align: center;" ></td>
                    <td width="6%" style="height:25px;text-align: center;" ></td>
                    <td width="10%" style="height:25px;text-align: center;" ></td>
                    <td width="8%" style="height:25px;text-align: center;" ></td>
                    <td width="9%" style="height:25px;text-align: center;" ></td>
                    <td width="8%" style="height:25px;text-align: center;" ></td>
                    <td width="10%" style="height:25px;text-align: center;" ></td>
                </tr>
                @php
                $a++;
                @endphp
                @if($a%23 == 0)
                {{-- </tbody> --}}
                {{-- </table> --}}
                <div class="page-break">xxxxxxxxxxxxxxxxxxxxxxxxx</div>
                @endif
                @endfor
                
            </tbody>
        </table>
        {{-- @endforeach --}}
        {{-- @endif --}}
    </body>
</html>