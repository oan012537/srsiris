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
                <div class="col px-sm-5 px-4">
                    <h1 class="font-topicpage text-center">บัญชีของฉัน</h1>
                    <div class="row">
                        <div class="col-md-6 offset-md-3 pt-sm-5 pb-sm-3 p-2">
                            <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">ข้อมูลของฉัน</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">รายการสั่งซื้อ</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">สถานะการจัดส่ง</a>
                              </li>
                            </ul>
                        </div>    
                    </div>
                    <div class="row">
                        <div class="col-md-6 offset-md-3 bg-white p-sm-3 p-2 mb-5">
                            <div class="tab-content" id="pills-tabContent">
                              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">รหัสผ่าน</label>
                                    <div class="col-sm-10">
                                      <button type="button" class="btn btn-sm btn-borderBlack" data-toggle="modal" data-target="#changePassModal">เปลี่ยนรหัสผ่าน</button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">ที่อยู่</label>
                                    <div class="col-sm-10">
                                      <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                                      <button type="button" class="btn btn-sm btn-borderBlack mt-2" data-toggle="modal" data-target="#changeAddressModal">เปลี่ยนที่อยู่</button>    
                                    </div>
                                </div>  
                              </div>
                              <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <table id="cartTable">
                                    <thead>
                                      <tr>
                                        <th>รายการ</th>
                                        <th>เลขที่เอกสาร</th>
                                        <th>สถานะ</th>
                                        <th>วันที่อัพเดท</th>  
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                     <td data-label="รายการ" class="textinTable-center">1</td>
                                     <td data-label="เลขที่เอกสาร" class="textinTable-center">SR1234545432 <a data-toggle="modal" data-target="#listProductOrder"><i class="fa fa-search"></i></a></td>
                                     <td data-label="สถานะ" class="textinTable-center text-danger">ยังไม่ชำระเงิน</td> 
                                     <td data-label="วันที่อัพเดท" class="textinTable-center">วว/ดด/ปปปป</td>     
                                    </tr>
                                    <tr>
                                     <td data-label="รายการ" class="textinTable-center">1</td>
                                     <td data-label="เลขที่เอกสาร" class="textinTable-center">SR1234545432 <a data-toggle="modal" data-target="#listProductOrder"><i class="fa fa-search"></i></a></td>
                                     <td data-label="สถานะ" class="textinTable-center">ชำระเงินแล้ว</td> 
                                     <td data-label="วันที่อัพเดท" class="textinTable-center">วว/ดด/ปปปป</td>     
                                    </tr>
                                    <tr>
                                     <td data-label="รายการ" class="textinTable-center">1</td>
                                     <td data-label="เลขที่เอกสาร" class="textinTable-center">SR1234545432 <a data-toggle="modal" data-target="#listProductOrder"><i class="fa fa-search"></i></a></td>
                                     <td data-label="สถานะ" class="textinTable-center">ชำระเงินแล้ว</td> 
                                     <td data-label="วันที่อัพเดท" class="textinTable-center">วว/ดด/ปปปป</td>     
                                    </tr>
                                    </tbody>
                                  </table>
                                  <nav aria-label="Page navigation example" class="my-2">
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
                              <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                <table id="cartTable">
                                    <thead>
                                      <tr>
                                        <th>รายการ</th>
                                        <th>เลขที่เอกสาร</th>
                                        <th>สถานะ</th>
                                        <th>วันที่อัพเดท</th>  
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                     <td data-label="รายการ" class="textinTable-center">1</td>
                                     <td data-label="เลขที่เอกสาร" class="textinTable-center">SR1234545432 <a data-toggle="modal" data-target="#listProductOrderD"><i class="fa fa-search"></i></a></td>
                                     <td data-label="สถานะ" class="textinTable-center">กำลังแพ็คสินค้า</td> 
                                     <td data-label="วันที่อัพเดท" class="textinTable-center">วว/ดด/ปปปป</td>     
                                    </tr>
                                    <tr>
                                     <td data-label="รายการ" class="textinTable-center">1</td>
                                     <td data-label="เลขที่เอกสาร" class="textinTable-center">SR1234545432 <a data-toggle="modal" data-target="#listProductOrderD"><i class="fa fa-search"></i></a></td>
                                     <td data-label="สถานะ" class="textinTable-center">เตรียมขนส่ง</td> 
                                     <td data-label="วันที่อัพเดท" class="textinTable-center">วว/ดด/ปปปป</td>     
                                    </tr>
                                    <tr>
                                     <td data-label="รายการ" class="textinTable-center">1</td>
                                     <td data-label="เลขที่เอกสาร" class="textinTable-center">SR1234545432 <a data-toggle="modal" data-target="#listProductOrderD"><i class="fa fa-search"></i></a></td>
                                     <td data-label="สถานะ" class="textinTable-center">จัดส่งแล่ว<br><a data-toggle="modal" data-target="#imageBillModal">บิลขนส่ง</a></td> 
                                     <td data-label="วันที่อัพเดท" class="textinTable-center">วว/ดด/ปปปป</td>     
                                    </tr>
                                    </tbody>
                                  </table>
                                  <nav aria-label="Page navigation example" class="my-2">
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
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>  
    @include('frontend/footer')      
  </body>
    <!-- Modal -->
    <div class="modal fade" id="changePassModal" tabindex="-1" role="dialog" aria-labelledby="changePassModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="changePassModalLabel">เปลี่ยนรหัสผ่าน</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Code from email</span>
              </div>
              <input type="text" class="form-control" aria-label="CodeFromEmail" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">New password</span>
              </div>
              <input type="text" class="form-control" aria-label="newPass" aria-describedby="basic-addon1">
            </div>  
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>    
    <!-- Modal -->
    <div class="modal fade" id="changeAddressModal" tabindex="-1" role="dialog" aria-labelledby="changeAddressModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="changeAddressModalLabel">เปลี่ยนที่อยู่</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label for="inputAddress2">ที่อยู่</label>
                <input type="text" class="form-control" id="inputAddress2">
            </div>    
            <div class="form-row">
                <div class="form-group col-sm">
                  <label for="inputCity">จังหวัด</label>
                  <select id="inputCity" class="form-control">
                    <option selected>เลือก...</option>
                    <option value="1">กระบี่</option>
                    <option value="2">กรุงเทพมหานคร</option>
                    <option value="3">กาญจนบุรี</option>
                    <option value="4">กาฬสินธุ์</option>
                    <option value="5">กำแพงเพชร</option>
                    <option value="6">ขอนแก่น</option>
                    <option value="7">จันทบุรี</option>
                    <option value="8">ฉะเชิงเทรา</option>
                    <option value="9">ชลบุรี</option>
                    <option value="10">ชัยนาท</option>
                    <option value="11">ชัยภูมิ</option>
                    <option value="12">ชุมพร</option>
                    <option value="13">ตรัง</option>
                    <option value="14">ตราด</option>
                    <option value="15">ตาก</option>
                    <option value="16">นครนายก</option>
                    <option value="17">นครปฐม</option>
                    <option value="18">นครพนม</option>
                    <option value="19">นครราชสีมา</option>
                    <option value="20">นครศรีธรรมราช</option>
                    <option value="21">นครสวรรค์</option>
                    <option value="22">นนทบุรี</option>
                    <option value="23">นราธิวาส</option>
                    <option value="24">น่าน</option>
                    <option value="25">บึงกาฬ</option>
                    <option value="26">บุรีรัมย์</option>
                    <option value="27">ปทุมธานี</option>
                    <option value="28">ประจวบคีรีขันธ์</option>
                    <option value="29">ปราจีนบุรี</option>
                    <option value="30">ปัตตานี</option>
                    <option value="31">พระนครศรีอยุธยา</option>
                    <option value="32">พะเยา</option>
                    <option value="33">พังงา</option>
                    <option value="34">พัทลุง</option>
                    <option value="35">พิจิตร</option>
                    <option value="36">พิษณุโลก</option>
                    <option value="37">ภูเก็ต</option>
                    <option value="38">มหาสารคาม</option>
                    <option value="39">มุกดาหาร</option>
                    <option value="40">ยะลา</option>
                    <option value="41">ยโสธร</option>
                    <option value="42">ระนอง</option>
                    <option value="43">ระยอง</option>
                    <option value="44">ราชบุรี</option>
                    <option value="45">ร้อยเอ็ด</option>
                    <option value="46">ลพบุรี</option>
                    <option value="47">ลำปาง</option>
                    <option value="48">ลำพูน</option>
                    <option value="49">ศรีสะเกษ</option>
                    <option value="50">สกลนคร</option>
                    <option value="51">สงขลา</option>
                    <option value="52">สตูล</option>
                    <option value="53">สมุทรปราการ</option>
                    <option value="54">สมุทรสงคราม</option>
                    <option value="55">สมุทรสาคร</option>
                    <option value="56">สระบุรี</option>
                    <option value="57">สระแก้ว</option>
                    <option value="58">สิงห์บุรี</option>
                    <option value="59">สุพรรณบุรี</option>
                    <option value="60">สุราษฎร์ธานี</option>
                    <option value="61">สุรินทร์</option>
                    <option value="62">สุโขทัย</option>
                    <option value="63">หนองคาย</option>
                    <option value="64">หนองบัวลำภู</option>
                    <option value="65">อำนาจเจริญ</option>
                    <option value="66">อุดรธานี</option>
                    <option value="67">อุตรดิตถ์</option>
                    <option value="68">อุทัยธานี</option>
                    <option value="69">อุบลราชธานี</option>
                    <option value="70">อ่างทอง</option>
                    <option value="71">เชียงราย</option>
                    <option value="72">เชียงใหม่</option>
                    <option value="73">เพชรบุรี</option>
                    <option value="74">เพชรบูรณ์</option>
                    <option value="75">เลย</option>
                    <option value="76">แพร่</option>
                    <option value="77">แม่ฮ่องสอน</option>
                  </select>
                </div>
                <div class="form-group col-sm">
                  <label for="inputState">ตำบล/แขวง</label>
                  <select id="inputState" class="form-control">
                    <option selected>เลือก...</option>
                    <option value="">...</option>
                  </select>
                </div>   
                <div class="form-group col-sm">
                  <label for="inputState">อำเภอ/เขต</label>
                  <select id="inputState" class="form-control">
                    <option selected>เลือก...</option>
                    <option value="">...</option>
                  </select>
                </div> 
                <div class="form-group col-sm">
                  <label for="inputZip">รหัสไปรษณีย์</label>
                  <input type="text" class="form-control" id="inputZip">
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>    
    </div>    
  <!-- Modal -->
    <div class="modal fade" id="listProductOrder" tabindex="-1" role="dialog" aria-labelledby="listProductOrderLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="listProductOrderLabel">รายการสินค้า</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table id="cartTable">
                <thead>
                  <tr>
                    <th>รายการ</th>
                    <th>สินค้า</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th>รวมราคา</th>
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
                    <td data-label="จำนวน" class="textinTable-center">1</td>
                    <td data-label="รวมราคา" class="textinTable-center">0.00 บาท</td>  
                  </tr> 
                  <tr>
                    <td data-label="รายการ" class="textinTable-center">2</td>
                    <td data-label="สินค้า" class="textinTable-left">
                        <img src="//placehold.it/50x50?text=Img" class="img-fluid" alt="Responsive image">
                        <span>ชื่อสินค้า</span>
                    </td>
                    <td data-label="ราคา" class="textinTable-center">0.00 บาท</td> 
                    <td data-label="จำนวน" class="textinTable-center">1</td>
                    <td data-label="รวมราคา" class="textinTable-center">0.00 บาท</td> 
                  </tr> 
                  <tr>
                    <td data-label="รายการ" class="textinTable-center">3</td>
                    <td data-label="สินค้า" class="textinTable-left">
                        <img src="//placehold.it/50x50?text=Img" class="img-fluid" alt="Responsive image">
                        <span>ชื่อสินค้า</span>
                    </td>
                    <td data-label="ราคา" class="textinTable-center">0.00 บาท</td> 
                    <td data-label="จำนวน" class="textinTable-center">1</td>
                    <td data-label="รวมราคา" class="textinTable-center">0.00 บาท</td> 
                  </tr>     
                </tbody>
            </table>
            <div class="row px-3 mt-3">
                <div class="col-sm-12 bg-gray py-2">
                    <p>ราคารวมทั้งหมด<span class="float-right font24">0.00 บาท</span></p>
                </div>
            </div>    
          </div>
        </div>
      </div>
    </div> 
<!-- Modal -->
    <div class="modal fade" id="listProductOrderD" tabindex="-1" role="dialog" aria-labelledby="listProductOrderDLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="listProductOrderDLabel">รายการสินค้า</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table id="cartTable">
                <thead>
                  <tr>
                    <th>รายการ</th>
                    <th>สินค้า</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th>รวมราคา</th>
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
                    <td data-label="จำนวน" class="textinTable-center">1</td>
                    <td data-label="รวมราคา" class="textinTable-center">0.00 บาท</td>  
                  </tr> 
                  <tr>
                    <td data-label="รายการ" class="textinTable-center">2</td>
                    <td data-label="สินค้า" class="textinTable-left">
                        <img src="//placehold.it/50x50?text=Img" class="img-fluid" alt="Responsive image">
                        <span>ชื่อสินค้า</span>
                    </td>
                    <td data-label="ราคา" class="textinTable-center">0.00 บาท</td> 
                    <td data-label="จำนวน" class="textinTable-center">1</td>
                    <td data-label="รวมราคา" class="textinTable-center">0.00 บาท</td> 
                  </tr> 
                  <tr>
                    <td data-label="รายการ" class="textinTable-center">3</td>
                    <td data-label="สินค้า" class="textinTable-left">
                        <img src="//placehold.it/50x50?text=Img" class="img-fluid" alt="Responsive image">
                        <span>ชื่อสินค้า</span>
                    </td>
                    <td data-label="ราคา" class="textinTable-center">0.00 บาท</td> 
                    <td data-label="จำนวน" class="textinTable-center">1</td>
                    <td data-label="รวมราคา" class="textinTable-center">0.00 บาท</td> 
                  </tr>     
                </tbody>
            </table>
            <div class="row px-3 mt-3">
                <div class="col-sm-12 bg-gray py-2">
                    <p>ราคารวมทั้งหมด<span class="float-right font24">0.00 บาท</span></p>
                </div>
            </div>    
          </div>
        </div>
      </div>
    </div>         
    <!-- Modal -->
    <div class="modal fade" id="imageBillModal" tabindex="-1" role="dialog" aria-labelledby="imageBillModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="imageBillModalLabel">บิลจัดส่ง</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <img src="image/picture.png" class="mw-100">
          </div>
        </div>
      </div>
    </div>
</html>