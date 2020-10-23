<!doctype html>
<html lang="th">
  <head>      
    <link rel="icon" href="image/ico-logo.png">  
    <title>SR-SIRI</title>
    <?php require('header.php'); ?>  
  </head>
  <body>
    <?php require('navbar.php'); ?>    
    <div id="section1">  
        <div class="container">
            <div class="row bg-gray py-3 ">
                <div class="col px-sm-5 px-4">
                    <h1 class="font-topicpage">สั่งซื้อสินค้า</h1>
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
                            <div class="row justify-content-end px-3 mt-3">
                                <div class="col-sm-4 bg-gray">
                                    <p>รวมราคา<span class="float-right">0.00 บาท</span><p>
                                    <p>+ค่าจัดส่ง<span class="float-right">0.00 บาท</span><p>
                                    <p>ราคารวมทั้งหมด<span class="float-right font24">0.00 บาท</span></p>
                                </div>
                            </div>   
                            <div class="row px-3 mt-3">
                                <div class="col-sm">
                                    <hr>
                                    <h2 class="text-center">ชื่อและที่อยู่จัดส่ง</h2>
                                    <form action="" method="" class="col-md-8 offset-md-2 bg-yellow px-sm-5 py-sm-3 p-2">
                                      <div class="form-row">
                                        <div class="form-group col-md-6">
                                          <label for="inputEmail4">ชื่อ</label>
                                          <input type="text" class="form-control" id="inputEmail4">
                                        </div>
                                        <div class="form-group col-md-6">
                                          <label for="inputPassword4">นามสกุล</label>
                                          <input type="text" class="form-control" id="inputPassword4" >
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="inputAddress">อีเมล์</label>
                                        <input type="email" class="form-control" id="inputAddress">
                                      </div>
                                      <div class="form-group">
                                        <label for="inputAddress2">เบอร์โทรติดต่อ</label>
                                        <input type="text" class="form-control" id="inputAddress2">
                                      </div>
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
                                    </form>
                                </div>
                            </div>  
                            <div class="row px-3 mt-3">
                                <div class="col-sm">
                                    <hr>
                                    <h2 class="text-left">เลือกประเภทการชำระเงิน</h2>
                                    <form action="" method="" class="">
                                      <ul class="none-liststyle"> 
                                        <li>
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                              <label class="form-check-label" for="exampleRadios1">
                                                ชำระเงินโดยตัดบัตรเครดิต<br>
                                                <div class="form-inline">
                                                    <label for="email" class="mr-sm-2">หมายเลขบัตรเครดิต:</label>
                                                      <input type="text" class="form-control mb-2 mr-sm-2" id="email">
                                                      <label for="pwd" class="mr-sm-2">ccv:</label>
                                                      <input type="text" class="form-control mb-2 mr-sm-2" id="pwd">
                                                </div>  
                                              </label>
                                            </div>  
                                        </li>
                                        <li>
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1">
                                              <label class="form-check-label" for="exampleRadios1">
                                                ชำระเงินโดยโอนเงินผ่านธนาคาร<br>  
                                              </label>
                                                <div class="row bg-gray p-2">
                                                    <div class="col-sm">ธนาคารกสิกร</div>
                                                    <div class="col-sm">คุณวงศ์วริศ สุทธิจิราวัฒน์</div>
                                                    <div class="col-sm">สาขาบางบอน</div>
                                                    <div class="col-sm">055-111-3566</div>  
                                                </div>
                                            </div>  
                                        </li>  
                                      </ul>
                                    </form>
                                </div>
                            </div>
                            <div class="row py-4">
                                <div class="col-sm text-center">
                                    <a href="confirm-payment.php" class="btn btn-lg btn-yellow my-2 px-5 py-2">ชำระเงิน</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>  
    <?php require('footer.php'); ?>      
  </body> 
</html>