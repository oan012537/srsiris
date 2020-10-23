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
            <div class="row bg-gray pt-sm-5 pb-sm-3 py-2">
                <div class="col text-center">
                <h1 class="font-weight-bold">เข้าสู่ระบบ</h1>
                </div>
            </div>
            <div class="row bg-gray px-sm-5 px-2 pb-5">
                <div class="col">
                    <div class="box-center mw-100">
                    <div class="bg-white p-3">
                        <form action="" method="">
                          <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="inputID"><i class="fa fa-user"></i></span>
                              </div>
                              <input type="text" class="form-control" placeholder="ไอดี" aria-label="Username" aria-describedby="inputID">
                          </div>
                          <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="inputPass"><i class="fa fa-lock"></i></span>
                              </div>
                              <input type="text" class="form-control" placeholder="รหัสผ่าน" aria-label="Username" aria-describedby="inputPass">
                          </div>    
                          <div class="form-group">
                            <a class="text-warning" data-toggle="modal" data-target="#modalForgotpass">ลืมรหัสผ่าน</a>
                          </div>
                          <div class="form-group">
                            <button type="submit" class="btn btn-yellow w-100">เข้าสู่ระบบ</button>
                          </div>    
                        </form>
                    </div>
                    </div>    
                </div>
            </div>    
        </div>
    </div>  
    <!-- Modal -->
    <div class="modal fade" id="modalForgotpass" tabindex="-1" role="dialog" aria-labelledby="modalForgotpassLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalForgotpassLabel">ลืมรหัสผ่าน</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="material-icons">&#xe5cd;</i></span>
            </button>
          </div>
          <div class="modal-body">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputEmail">อีเมล์</span>
              </div>
              <input type="email" class="form-control" aria-label="emailForget" aria-describedby="inputEmail">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputIDforgot">ไอดี</span>
              </div>
              <input type="text" class="form-control" aria-label="idForget" aria-describedby="inputIDforgot">
            </div>  
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-dark"><i class="fa fa-send"></i> ส่ง</button>
          </div>
        </div>
      </div>
    </div>
   @include('frontend/footer')      
  </body>
</html>