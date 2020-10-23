<!doctype html>
<html lang="th">
  <head>      
    <link rel="icon" href="image/ico-logo.png">  
    <title>SR-SIRI</title>
    <?php require('header.php'); ?>  
    <link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen">  
    <script type="text/javascript" src="js/modernizr.js"></script>  
    <script type="text/javascript" src="js/jquery.flexslider.js"></script>    
  </head>
  <body>
    <?php require('navbar.php'); ?>    
    <div id="section1">  
        <div class="container">
            <div class="row bg-gray py-3 ">
                <div class="col">
                <p><a href="index.php" class="text-dark">หน้าแรก</a> > <a href="" class="text-dark">ชื่อหมวดหมู่สินค้า</a> > <a href="" class="text-dark">ชื่อสินค้า</a></p>
                </div>
            </div>
        </div>
    </div>  
    <div id="section2">  
        <div class="container">
            <div class="row bg-white py-5"> 
                <div class="col-sm-5 p-2">
                   <div class="flexslider">
                      <ul class="slides">
                        <li data-thumb="image/picture.png">
                          <img src="image/picture.png" />
                        </li>
                        <li data-thumb="image/picture.png">
                          <img src="image/picture.png" />
                        </li>
                        <li data-thumb="image/picture.png">
                          <img src="image/picture.png" />
                        </li>
                        <li data-thumb="image/picture.png">
                          <img src="image/picture.png" />
                        </li>
                      </ul>
                    </div>
                </div>
                <div class="col-sm-7">
                   <h1 class="bold">ชื่อสินค้า</h1>
                   <p class="text-secondary">หมวดหมู่สินค้า: <span>ชื่อหมวดหมู่สินค้า</span></p>
                   <hr>
                    <p class="line-height50"><b>ยี่ห้อ:</b> <span>xxxxxxxxxxxxxxxxxxx</span></p>
                    <p class="line-height50"><b>SKU:</b> <span>xxxxxxxxxxxxxxxxxxx</span></p>
                    <p class="line-height50"><b>รุ่น:</b> <span>xxxxxxxxxxxxxxxxxxx</span></p>
                    <p class="line-height50"><b>ประเภท:</b> <span>xxxxxxxxxxxxxxxxxxx</span></p>
                    <p class="line-height50"><b>รายละเอียดสินค้า:</b></p> 
                    <p class="line-height24 text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                    <p class="line-height50"><b>ราคา:</b> <span class="font30">0.00</span>บาท</p>    
                    <p class="line-height50"><b>จำนวน:</b></p>
                    <form id="quantityForm">
                      <div class="value-button" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
                      <input type="number" id="number" value="0" />
                      <div class="value-button" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
                    </form>
                    <a class="btn btn-yellow btn-lg my-4 mr-3 px-5 py-3" href="payment.php">ซื้อเลย</a><a class="btn btn-borderBlack btn-lg my-4 px-5 py-3" href="cart.php"><i class="fa fa-shopping-cart"></i> ใส่รถเข็น</a>
                </div>
            </div>
        </div>
    </div>
    <div id="section3">  
        <div class="container">
            <div class="row bg-gray py-sm-5 py-2">
                <div class="col">
                    <h1 class="text-center bold">สินค้าใกล้เคียง</h1>
                </div>        
            </div>
            <div class="row bg-gray py-2 pb-sm-5">
                <div class="col-sm px-3 py-1">
                    <div class="bg-white text-center p-2" id="item-product">
                        <img src="//placehold.it/300x350?text=Image Product" class="item-img-product">
                        <p class="bold font24 mt-2">Product name</p>
                        <p class="text-secondary font14 mb-3">Category > Category</p>
                        <a href="detail-product.php" class="btn btn-lg btn-yellow w-100"><span><i class="fa fa-shopping-cart float-left" style="padding-top:5px"></i> 0.00 บาท</span></a>
                    </div>
                </div>
                <div class="col-sm px-3 py-1">
                    <div class="bg-white text-center p-2" id="item-product">
                        <img src="//placehold.it/300x350?text=Image Product" class="item-img-product">
                        <p class="bold font24 mt-2">Product name</p>
                        <p class="text-secondary font14 mb-3">Category > Category</p>
                        <a href="detail-product.php" class="btn btn-lg btn-yellow w-100"><span><i class="fa fa-shopping-cart float-left" style="padding-top:5px"></i> 0.00 บาท</span></a>
                    </div>
                </div>
                <div class="col-sm px-3 py-1">
                    <div class="bg-white text-center p-2" id="item-product">
                        <img src="//placehold.it/300x350?text=Image Product" class="item-img-product">
                        <p class="bold font24 mt-2">Product name</p>
                        <p class="text-secondary font14 mb-3">Category > Category</p>
                        <a href="detail-product.php" class="btn btn-lg btn-yellow w-100"><span><i class="fa fa-shopping-cart float-left" style="padding-top:5px"></i> 0.00 บาท</span></a>
                    </div>
                </div>
                <div class="col-sm px-3 py-1">
                    <div class="bg-white text-center p-2" id="item-product">
                        <img src="//placehold.it/300x350?text=Image Product" class="item-img-product">
                        <p class="bold font24 mt-2">Product name</p>
                        <p class="text-secondary font14 mb-3">Category > Category</p>
                        <a href="detail-product.php" class="btn btn-lg btn-yellow w-100"><span><i class="fa fa-shopping-cart float-left" style="padding-top:5px"></i> 0.00 บาท</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>   
    <?php require('footer.php'); ?>      
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
<script>    
$(document).ready(function() {
  $('.flexslider').flexslider({
    animation: "slide",
    controlNav: "thumbnails"
  });
});    
</script>    
</html>