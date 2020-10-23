<!doctype html>
<html lang="th">
  <head>      
     <link rel="icon" href="{{asset('assetsfrontend/image/logo.png')}}">  
    <title>SR-SIRI</title>
    @include('frontend/header')  
  </head>
  <body>
	@include('frontend/navbar')     
    <div id="section1">  
        <div class="container">
            <div class="row bg-yellow py-5 ">
                <div class="col text-center">
                <h1 class="font-weight-bold">วิธีการสั่งซื้อสินค้า</h1>
                </div>
            </div>
        </div>
    </div>  
    <div id="section2">  
        <div class="container">
            <div class="row bg-white py-5">
                <div class="col-sm">
                    <div>
                        <ol id="numOrder">
                            <li>ขั้นแรกเมื่อเจอสินค้าที่ต้องการแล้ว ให้กดที่ปุ่มตามรูปเพื่อไปหน้ารายละเอียดสินค้า<br><img  src="{{asset('assetsfrontend/image/howto/00.png')}}" class="mw-100 w-50"></li>
                            <li>เมื่อเข้ามาในหน้ารายละเอียดสินค้านั้นๆแล้ว กดจำนวนสินค้าที่ต้องการสั่งซื้อ จากนั้นหากต้องการซื้อสินค้าตัวนี้อย่างเดียว สามาถกดไปที่ปุ่ม"ซื้อเลย"เพื่อไปหน้าสั่งซื้อสินค้า แต่หากยังมีสินค้าอื่นๆที่ต้องการซื้อสามารถกดที่ปุ่ม"ใส่รถเข็น"ก่อนได้<br><img {{asset('assetsfrontend/image/howto/01.png')}} class="mw-100 "></li>
                            <li>ในกรณีที่เป็นเลือกสินค้าใส่รถเข็น เมื่อได้สินค้าครบตามที่ต้องการแล้วสามารถไปดูที่หน้า"รถเข็น" แล้วค่อยกดปุ่ม"ดำเนินการสั่งซื้อ" <i>จากนั้นสามารถดูวิธี <a href="howtopay.php">วิธีการชำระเงิน</a></i><br><img {{asset('assetsfrontend/image/howto/02.png')}} class="mw-100 w-50"></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('frontend/footer')     
  </body>
</html>