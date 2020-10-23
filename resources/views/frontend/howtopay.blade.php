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
                <h1 class="font-weight-bold">วิธีการชำระเงิน</h1>
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
                            <li>เริ่มจากหน้าสั่งซื้อสินค้า หน้าที่จะต่อมาจากการกดปุ่ม"ซื้อเลย"ในหน้ารายละเอียดสินค้า หรือจากการกดปุ่ม"ดำเนินการสั่งซื้อ"จากหน้ารถเข็น เช็คยอดเงินที่ต้องชำระ<br><img  src="{{asset('assetsfrontend/image/howto/03.png')}}" class="mw-100 w-50"></li>
                            <li>จากนั้นสำหรับบุคคลทั่วไปที่ไม่มีบัญชีล็อกอินจะต้องกรอกรายละเอียดของตนเอง ชื่อ, ที่อยู๋ในการจัดส่งสินค้า, อีเมล์ และ เบอร์โทรติดต่อ ให้เรียบร้อยก่อนชำระเงิน<br><img  src="{{asset('assetsfrontend/image/howto/04.png')}}" class="mw-100 w-50"></li>
                            <li>เมื่อกรอกรายละเอียดแล้ว หรือสำหรับคนที่มีบัญชีล็อกอินแล้ว ให้ทำการเลือกประเภทวิธีการชำระเงิน<br>1.หากเลือกวิธีชำระเงินโดยตัดผ่านบัตรเครดิต ให้ใส่หมายเลขบัตรเครดิต รวมทั้งเลขรหัสสามตัวหลังบัตร<br>2.หากเลือกวิธีชำระเงินโดยโอนเงินผ่านธนาคาร ให้จดเลขที่บัญชี, ชื่อบัญชี, สาขา เพื่อทำการโอนเงิน จากนั้นกดปุ่ม"ชำระเงิน" <br>เมื่อโอนเงินเรียบร้อยแล้วให้เก็บใบเสร็จ, รูปภาพใบเสร็จ ไว้เป็นหลักฐาน<br><img src="{{asset('assetsfrontend/image/howto/05.png')}}" class="mw-100 w-50"></li>
                            <li>หลังจากกดปุ่มชำระเงินแล้ว สำหรับคนที่เลือกชำระเงินโดยการโอนเงินผ่านธนาคาร<br>ทางระบบจะส่งอีเมล์ไปให้ เพื่อที่จะได้ทำการยืนยันการชำระเงิน แจ้งให้ทางบริษัททราบ<br>โดยกดที่ลิ้งค์ในอีเมล์เพื่อมาที่หน้า"ยืนยันการชำระเงิน" ตามรูปด้านล่าง เมื่อเข้ามาแล้วให้กรอก วันและเวลาที่โอน พร้อมอัพโหลดรูปหลักฐาน<br><img src="{{asset('assetsfrontend/image/howto/06.png')}}" class="mw-100 w-50"></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('frontend/footer')      
  </body>
</html>