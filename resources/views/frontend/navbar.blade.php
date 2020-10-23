<div id="top-navbar" class="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
      <div class="container px-3">    
          <a class="navbar-brand" href="{{url('/')}}">
            <img src="{{asset('assetsfrontend/image/logo.png')}}" class="mw-100" alt="">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  สินค้า
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="#">กระดาษ</a>
                  <a class="dropdown-item" href="#">ของชำร่วย</a>
                  <a class="dropdown-item" href="#">ดอกไม้</a>
                  <a class="dropdown-item" href="#">ด้าย/สายสินจญ์/เชือก</a>    
                  <a class="dropdown-item" href="#">แผ่นโลหะ</a>
                  <a class="dropdown-item" href="#">พระโลหะ</a>
                  <a class="dropdown-item" href="#">ธูป</a>
                  <a class="dropdown-item" href="#">เทียน</a>
                  <a class="dropdown-item" href="#">ผ้าดิบ</a>
                  <a class="dropdown-item" href="#">พลาสติก</a>
                  <a class="dropdown-item" href="#">สังฆทาน</a>
                  <a class="dropdown-item" href="#">รองเท้า</a>
                  <a class="dropdown-item" href="#">พวงมาลัย</a>
                  <a class="dropdown-item" href="#">เครื่องเจ้า</a>    
                  <a class="dropdown-item" href="#">เครื่องศาล</a>
                  <a class="dropdown-item" href="#">เครื่องบวช</a>
                  <a class="dropdown-item" href="#">สีย้อมผ้า</a>  
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{url('aboutus')}}">เกี่ยวกับเรา</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{url('contactus')}}">ติดต่อเรา</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  ช่วยเหลือ
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{url('howtoorder')}}">วิธีการสั่งซื้อสินค้า</a>
                  <a class="dropdown-item" href="{{url('howtopay')}}">วิธีการชำระเงิน</a>
                </div>
              </li>    
            </ul>
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
              <li class="nav-item">
              <a class="nav-link" href="{{url('/frontend/login')}}"><i class="fa fa-user-circle-o"></i></a>
              </li>
              <!-- after login
              <li class="nav-item active">
                <a class="nav-link" href="account.php"><i class="fa fa-user-circle-o"></i></a>
              </li>-->
              <li class="nav-item">
              <a class="nav-link" href="{{url('/cart')}}"><i class="fa fa-shopping-cart"></i> <span>0</span></a>
              </li>
              <li class="nav-item">
                <div id="search-bar" class=" containerSB">
                    <button class="search-icon" onclick=expandSearchBar()><svg style="width:24px;height:24px" viewBox="0 0 24 24"> <path d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z"
                    />
                    </svg></button>
                    <form role="search" id="searchform"submit="https://www.google.com/search?q=form+submit&ie=utf-8&oe=utf-8&client=firefox-b-ab">
                       <input type="search" id="search-input" name="q" aria-label="Search through site content" onblur=minSearchBar()>
                    </form>
                </div>  
              </li>    
            </ul>
          </div>
      </div>
    </nav>
</div>
<script>
function expandSearchBar() {
  $('#search-bar').addClass('expanded');
  $('#search-input').focus();
}

function minSearchBar() {
  $('#search-bar').removeClass('expanded');
}  
</script>