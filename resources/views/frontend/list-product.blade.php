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
            <div class="row">
            <div class="bg-whiteBl p-2" id="divFilter-mobile">
                <div class="p-1" id="Filter-mobile">
                    <b class="font24">ตัวกรอง</b>
                    <a href="javascript:void(0)" onclick="document.getElementById('divFilter-mobile').style.display='none';document.getElementById('fade').style.display='none'" class="float-right"><i class="material-icons text-dark">close</i></a>
                    <hr style="margin-top:10px;margin-bottom:10px">
                </div>
                <div id="divFilter" style="overflow-y:scroll;height:300px;">
                <div class="bold font18" id="btn-minorcategory" onclick="collapseMinorCate()">หมวดหมู่ย่อย <i class="fa fa-angle-down float-right"></i></div>
                <div id="div-minorcategory" class="visible">
                    <ul class="none-liststyle">
                        <li>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" value=""> กระดาษ
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" value=""> ของชำร่วย
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" value=""> ดอกไม้
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" value=""> ด้าย/สายสินจญ์/เชือก
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" value=""> แผ่นโลหะ
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" value=""> พระโลหะ
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" value=""> ธูป
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" value=""> เทียน
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" value=""> ผ้าดิบ
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" value=""> พลาสติก
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" value=""> สังฆทาน
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" value=""> รองเท้า
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" value=""> พวงมาลัย
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" value=""> เครื่องเจ้า
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" value=""> เครื่องศาล
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" value=""> เครื่องบวช
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" value=""> สีย้อมผ้า
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="bold font18" id="btn-color" onclick="collapsecolor()">สี <i class="fa fa-angle-down float-right"></i></div>
                    <div id="div-color" class="visible">
                        <ul class="none-liststyle">
                            <li>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value=""> สีxxxxx
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value=""> สีxxxxx
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value=""> สีxxxxx
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value=""> สีxxxxx
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>    
                <div class="bold font18" id="btn-price" onclick="collapseprice()">ราคา <i class="fa fa-angle-down float-right"></i></div>
                    <div id="div-price" class="visible">
                        <ul class="none-liststyle">
                            <li>
                                <div class="checkbox">
                                    <label>
                                          <input type="checkbox" value=""> ฿ 1 - ฿ 199
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value=""> ฿ 200 - ฿ 299
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value=""> ฿ 300 - ฿ 499 
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value=""> ฿ 500 -  ฿ 999 
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value=""> ฿ 1000 ขึ้นไป
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            </div> 
            <div class="row">
            <div class="bg-whiteBl p-2" id="divsort-mobile">
                <div class="p-1" id="Filter-mobile">
                    <b class="font24">เรียงโดย</b>
                    <a href="javascript:void(0)" onclick="document.getElementById('divsort-mobile').style.display='none';document.getElementById('fade').style.display='none'" class="float-right"><i class="material-icons text-dark">close</i></a>
                    <hr style="margin-top:10px;margin-bottom:10px">
                </div>
                <div id="divFilter">
                <div id="div-sort" class="visible">
                    <ul class="none-liststyle">
                        <li>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value=""> สินค้าขายดี
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value=""> สินค้าใหม่ล่าสุด
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value=""> ราคา: ต่ำ - สูง
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value=""> ราคา: สูง - ต่ำ
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
                </div>
            </div>
            </div>    
            <div id="fade" class="black_overlay"></div>
            <div class="bg-gray" id="contentPage">
                <div class="container">
                    <div class="col-sm-12 p-0">
                        <div class="row p-3">
                            <p class="text-left"><a href="index.php"><i class="fa fa-home text-dark"></i></a> > <a href="" class="text-dark">ชื่อหมวดหมู่สินค้า</a></p>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-sm-3 mb-5">
                        <div class="bg-whiteBl p-2" id="buttonFilter-desktop">
                        <p class="font24 bold">ตัวกรอง</p>
                        </div>
                        <div class="bg-whiteBl p-2" id="buttonFilter-mobile" onclick="opendivfilter()">
                        <p class="font24 bold">ตัวกรอง</p>
                        </div>
                        <div class="bg-whiteBl p-2" id="divFilter-desktop">
                            <div class="bold font18" id="btn-minorcategory" onclick="collapseMinorCateD()">หมวดหมู่สินค้า <i class="fa fa-angle-down float-right"></i></div>
                            <div id="div-minorcategoryD" class="visible">
                                <ul class="none-liststyle">
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> กระดาษ
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> ของชำร่วย
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> ดอกไม้
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> ด้าย/สายสินจญ์/เชือก
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> แผ่นโลหะ
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> พระโลหะ
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> ธูป
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> เทียน
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> ผ้าดิบ
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> พลาสติก
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> สังฆทาน
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> รองเท้า
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> พวงมาลัย
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> เครื่องเจ้า
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> เครื่องศาล
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> เครื่องบวช
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> สีย้อมผ้า
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="bold font18" id="btn-color" onclick="collapsecolorD()">สี <i class="fa fa-angle-down float-right"></i></div>
                            <div id="div-colorD" class="visible">
                                <ul class="none-liststyle">
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> สีxxxxxxx
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> สีxxxxxxx
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> สีxxxxxxx
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" value=""> สีxxxxxxx
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="bold font18" id="btn-price" onclick="collapsepriceD()">ราคา <i class="fa fa-angle-down float-right"></i></div>
                            <div id="div-priceD" class="visible">
                                <ul class="none-liststyle">
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                                  <input type="checkbox" value=""> ฿ 1 - ฿ 199
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value=""> ฿ 200 - ฿ 299
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value=""> ฿ 300 - ฿ 499 
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value=""> ฿ 500 -  ฿ 999 
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value=""> ฿ 1000 ขึ้นไป
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="bg-whiteBl p-2" id="buttonSort" onclick="opendivsort()">
                        <p class="font24 bold">เรียงโดย</p>
                        </div>
                    </div>
                    <div class="col-sm-9 p-0 p-sm-2" style="margin-bottom:100px">
                        <div class="row px-sm-3 px-2">
                            <div class="col-sm-6 col-12">
                                <h4 class="bold font24">ชื่อหมวดหมู่สินค้า <span>(0)</span></h4>
                            </div>
                            <div class="col-sm-3 col-12 py-sm-0 py-2">
                                <span class="font14 float-right" id="sort-product">เรียงโดย:
                                    <select>
                                        <option value="">สินค้าขายดี</option>
                                        <option value="">สินค้าใหม่ล่าสุด</option>
                                        <option value="">ราคา: ต่ำ-สูง</option>
                                        <option value="">ราคา: สูง-ต่ำ</option>
                                    </select>
                                </span>
                            </div>  
                            <div class="col-sm-3 col-12"> 
                                <nav aria-label="Page navigation example">
                                  <ul class="pagination pagination-sm justify-content-end">
                                    <li class="page-item disabled">
                                      <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                      <a class="page-link" href="#">Next</a>
                                    </li>
                                  </ul>
                                </nav>
                            </div>
                        </div>      
                        <div class="col-sm-12 nopadding-mobile">
                            <hr style="margin-top:10px;margin-bottom:10px">
                            <div class="row bg-gray py-sm-3">
							
								
                                <div class="col-sm px-3 py-1">
                                    <div class="bg-white text-center p-2" id="item-product">
                                        <img src="//placehold.it/300x350?text=Image Product" class="item-img-product">
                                        <p class="bold font24 mt-2">Product name</p>
                                        <p class="text-secondary font14 mb-3">Category > Category</p>
                                        <a href="{{url('/detail-product')}}" class="btn btn-lg btn-yellow w-100"><span><i class="fa fa-shopping-cart float-left" style="padding-top:5px"></i> 0.00 บาท</span></a>
                                    </div>
                                </div>
								                          
								

                            </div>
                        </div>    
                    </div>
                    </div>    
                </div>

            </div> 
        </div>
    </div>
     @include('frontend/footer')     
  </body>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>    
<script type="text/javascript" src="{{asset('assetsfrontend/js/jquery-migrate-1.2.1.min.js')}}"></script>  

  
<script>
function collapseMinorCate() {
    if ($('#div-minorcategory').hasClass("visible")) {
        $('#div-minorcategory').removeClass("visible").addClass("hidden");
        $('#btn-minorcategory i').removeClass("fa-angle-down").addClass("fa-angle-up");
    } else if ($('#div-minorcategory').hasClass("hidden")){
        $('#div-minorcategory').removeClass("hidden").addClass("visible");
        $('#btn-minorcategory i').removeClass("fa-angle-up").addClass("fa-angle-down");
    }
}
function collapseprice() {
    if ($('#div-price').hasClass("visible")) {
        $('#div-price').removeClass("visible").addClass("hidden");
        $('#btn-price i').removeClass("fa-angle-down").addClass("fa-angle-up");
    } else if ($('#div-price').hasClass("hidden")){
        $('#div-price').removeClass("hidden").addClass("visible");
        $('#btn-price i').removeClass("fa-angle-up").addClass("fa-angle-down");
    }
}   
function collapsecolor() {
    if ($('#div-color').hasClass("visible")) {
        $('#div-color').removeClass("visible").addClass("hidden");
        $('#btn-color i').removeClass("fa-angle-down").addClass("fa-angle-up");
    } else if ($('#div-color').hasClass("hidden")){
        $('#div-color').removeClass("hidden").addClass("visible");
        $('#btn-color i').removeClass("fa-angle-up").addClass("fa-angle-down");
    }
}    
function collapseMinorCateD() {
    if ($('#div-minorcategoryD').hasClass("visible")) {
        $('#div-minorcategoryD').removeClass("visible").addClass("hidden");
        $('#btn-minorcategoryD i').removeClass("fa-angle-down").addClass("fa-angle-up");
    } else if ($('#div-minorcategoryD').hasClass("hidden")){
        $('#div-minorcategoryD').removeClass("hidden").addClass("visible");
        $('#btn-minorcategoryD i').removeClass("fa-angle-up").addClass("fa-angle-down");
    }
}
function collapsepriceD() {
    if ($('#div-priceD').hasClass("visible")) {
        $('#div-priceD').removeClass("visible").addClass("hidden");
        $('#btn-priceD i').removeClass("fa-angle-down").addClass("fa-angle-up");
    } else if ($('#div-priceD').hasClass("hidden")){
        $('#div-priceD').removeClass("hidden").addClass("visible");
        $('#btn-priceD i').removeClass("fa-angle-up").addClass("fa-angle-down");
    }
}   
function collapsecolorD() {
    if ($('#div-colorD').hasClass("visible")) {
        $('#div-colorD').removeClass("visible").addClass("hidden");
        $('#btn-colorD i').removeClass("fa-angle-down").addClass("fa-angle-up");
    } else if ($('#div-colorD').hasClass("hidden")){
        $('#div-colorD').removeClass("hidden").addClass("visible");
        $('#btn-colorD i').removeClass("fa-angle-up").addClass("fa-angle-down");
    }
}     
function opendivfilter() {
    document.getElementById('divFilter-mobile').style.display='block';
    document.getElementById('fade').style.display='block';
}
function opendivsort() {
    document.getElementById('divsort-mobile').style.display='block';
    document.getElementById('fade').style.display='block';
}     
  
</script>     
</html>