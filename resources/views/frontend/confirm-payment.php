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
                    <h1 class="font-topicpage text-center">ยืนยันการชำระเงิน</h1>
                    <div class="row">
                        <div class="col-md-6 offset-md-3 bg-white p-sm-5 p-2 mb-5">
                           <form>
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="inputEmail4">วันและเวลาที่โอน</label>
                                  <input type="date" class="form-control" id="inputEmail4" >
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="inputPassword4">&nbsp;</label>
                                  <input type="time" class="form-control" id="inputPassword4" >
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputAddress">จำนวนเงินที่โอน</label>
                                <input type="text" class="form-control" id="inputAddress">
                              </div>
                              <div class="form-inline">
                                <label for="inputAddress2" class="mr-sm-2">หลักฐานการโอนเงิน</label>
                                <button type="button" class="btn btn-borderBlack">เลือกรูป</button>
                              </div>
                              <div class="form-group text-center">
                                <a href="" class="btn btn-lg btn-yellow my-4">ยืนยัน</a>
                              </div>   
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>  
    <?php require('footer.php'); ?>      
  </body>
   
</html>