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
            <div class="row bg-gray py-3 ">
                <div class="col px-5">
                    <h1 class="font-topicpage">รถเข็นของฉัน( <span>1</span> ชิ้น)</h1>
                    <div class="row">
                        <div class="col bg-white p-sm-5 p-2 mb-5">
                            <table id="cartTable">
                                <thead>
                                  <tr>
                                    <th>รายการ</th>
                                    <th>สินค้า</th>
                                    <th>ราคา</th>
                                    <th>จำนวน</th>
                                    <th>รวมราคา</th>
                                    <th>ลบ</th>  
                                  </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td data-label="รายการ" class="textinTable-center">1</td>
                                    <td data-label="สินค้า" class="textinTable-left">
                                        <img src="//placehold.it/50x50?text=Img" class="img-fluid" alt="Responsive image">
                                        <span>ชื่อสินค้า</span>
                                    </td>
                                    <td data-label="ราคา" class="textinTable-center">0.00 บาท</td> 
                                    <td data-label="จำนวน">
                                        <form id="quantityForm" class="elementinTable">
                                            <div class="value-button" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
                                            <input type="number" id="number" value="0" />
                                            <div class="value-button" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
                                        </form>
                                    </td>
                                    <td data-label="รวมราคา" class="textinTable-center">0.00 บาท</td> 
                                    <td data-label="ลบ" class="textinTable-center"><a class="text-dark font18"><i class="material-icons">&#xe5cd;</i></a></td> 
                                </tr> 
                                <tr>
                                    <td data-label="รายการ" class="textinTable-center">2</td>
                                    <td data-label="สินค้า" class="textinTable-left">
                                        <img src="//placehold.it/50x50?text=Img" class="img-fluid" alt="Responsive image">
                                        <span>ชื่อสินค้า</span>
                                    </td>
                                    <td data-label="ราคา" class="textinTable-center">0.00 บาท</td> 
                                    <td data-label="จำนวน">
                                        <form id="quantityForm" class="elementinTable">
                                            <div class="value-button" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
                                            <input type="number" id="number" value="0" />
                                            <div class="value-button" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
                                        </form>
                                    </td>
                                    <td data-label="รวมราคา" class="textinTable-center">0.00 บาท</td> 
                                    <td data-label="ลบ" class="textinTable-center"><a class="text-dark font18"><i class="material-icons">&#xe5cd;</i></a></td> 
                                </tr> 
                                <tr>
                                    <td data-label="รายการ" class="textinTable-center">3</td>
                                    <td data-label="สินค้า" class="textinTable-left">
                                        <img src="//placehold.it/50x50?text=Img" class="img-fluid" alt="Responsive image">
                                        <span>ชื่อสินค้า</span>
                                    </td>
                                    <td data-label="ราคา" class="textinTable-center">0.00 บาท</td> 
                                    <td data-label="จำนวน">
                                        <form id="quantityForm" class="elementinTable">
                                            <div class="value-button" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
                                            <input type="number" id="number" value="0" />
                                            <div class="value-button" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
                                        </form>
                                    </td>
                                    <td data-label="รวมราคา" class="textinTable-center">0.00 บาท</td> 
                                    <td data-label="ลบ" class="textinTable-center"><a class="text-dark font18"><i class="material-icons">&#xe5cd;</i></a></td> 
                                </tr>     
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-borderBlack my-2">ลบสินค้าทั้งหมด</button>
                            <div class="row justify-content-end px-3">
                                <div class="col-sm-4 bg-gray">
                                    <p>รวมราคา<span class="float-right">0.00 บาท</span><p>
                                    <p>+ค่าจัดส่ง<span class="float-right">0.00 บาท</span><p>
                                    <p>ราคารวมทั้งหมด<span class="float-right font24">0.00 บาท</span></p>
                                </div>
                            </div>    
                            <a href="{{url('/payment')}}" class="btn btn-lg btn-yellow my-2 px-5 py-2 float-right">ดำเนินการสั่งซื้อ</a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>  
    @include('frontend/footer')     
  </body>
<script>
function increaseValue() {
  var value = parseInt(document.getElementById('number').value, 10);
  value = isNaN(value) ? 0 : value;
  value++;
  document.getElementById('number').value = value;
}

function decreaseValue() {
  var value = parseInt(document.getElementById('number').value, 10);
  value = isNaN(value) ? 0 : value;
  value < 1 ? value = 1 : '';
  value--;
  document.getElementById('number').value = value;
}    
</script>    
</html>