<!DOCTYPE html> 
<html lang="en">
    <head>
        <style>
            body{
                font-family:"thaisarabun" , "microsoft sans serif";
                font-size :21px;
            }
            table{
                font-size :21px;
                border-spacing: 8px 2px;
            }
            div{
                font-size :21px;
            }
            .barcode{
                width: 100%;
                font-size: 16px;
                padding: 2px;
                text-align: center;
            }
            td{
                height: 2.7cm;
                width: 3.5cm;
                border: 1px solid;
                padding-top: 2px;
                font-size :25px;
                text-align: center;
            }
            td img{
                padding: -10px;
                width: 2.6cm;
                height: 1.2cm;

            }
            @page {
                margin: 5px;
            }
            
        </style>
    </head>
    <body>
        <div class="col-md-12" style="text-align: center;">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <div class="col-md-12 barcode" >
                                <img src="data:image/png;base64,{{ $genbarcode }}" style="width: 2.6cm;height: 1.2cm;" alt="barcode" class="barcode" />
                                <span class="barcode">{{ $barcode }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 barcode" >
                                <img src="data:image/png;base64,{{ $genbarcode }}" style="width: 2.6cm;height: 1.2cm;" alt="barcode" class="barcode" />
                                <span class="barcode">{{ $barcode }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 barcode" >
                                <img src="data:image/png;base64,{{ $genbarcode }}" style="width: 2.6cm;height: 1.2cm;" alt="barcode" class="barcode" />
                                <span class="barcode">{{ $barcode }}</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            
        </div>
    </body>
</html>