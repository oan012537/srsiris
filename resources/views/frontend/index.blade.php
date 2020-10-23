<!doctype html>
<html lang="th">
	<head>      
		<link rel="icon" href="{{asset('assetsfrontend/image/logo.png')}}">  
		<title>SR-SIRI</title>
		@include('frontend/header')
	</head>
	<body>
	@include('frontend/navbar')
    <div id="banner">  
        <div class="container">
            <div class="row bg-gray">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
					@foreach($databanner As $key  => $item_banner)
					@if($key == 0)
					<li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}" class="active"></li>
					@else
					<li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}"></li>
					@endif
					
					@endforeach	
                    

                  </ol>
                  <div class="carousel-inner">
						
						
					
						@foreach($databanner As $key => $item_banner)
							@if($key == 0)
							<div class="carousel-item active">
								<img class="d-block w-100 img-fluid" src="{{('storage/banner/'.$item_banner->picture_benner)}}" alt="First slide">
							</div>							
							@else
							<div class="carousel-item">
								<img class="d-block w-100 img-fluid" src="{{('storage/banner/'.$item_banner->picture_benner)}}" alt="First slide">
							</div>								
							@endif
					
						@endforeach	
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
            </div>
        </div>  
    </div>

    <div id="section1">  
        <div class="container">
            <div class="row bg-gray py-sm-5">
                <div class="col-sm-4 text-right">
                    <img  src="{{asset('assetsfrontend/image/newProduct.png')}}" class="mw-100">
                </div>
				
				@foreach($dataproductnew As $itemnew)
                <div class="col-sm px-3 py-1">
                    <div class="bg-white text-center p-2" id="item-product">
                        <img src="{{asset('assets/images/product/'.$itemnew->product_picture)}}" class="item-img-product mw-100">
                        <p class="bold font24 mt-2">{{$itemnew->product_name}}</p>
                        <p class="text-secondary font14 mb-3">Category > {{$itemnew->category_name}}</p>
                        <a href="{{url('/detail-product')}}" class="btn btn-lg btn-yellow w-100"><span><i class="fa fa-shopping-cart float-left" style="padding-top:5px"></i> {{$itemnew->product_promotion}} บาท</span></a>
                    </div>
                </div>
				@endforeach
            </div>
        </div>
    </div>	
	
	
    <div id="section2" class="bg-white">  
        <div class="container pb-5">
            <div class="row bg-yellow">
                <div class="col-sm text-center">
                    <h1 class="bold mt-2">สินค้าขายดี</h1>
                </div>
            </div>
            <div class="row bg-gray py-sm-5">
			
				@for($i=0; $i< 4; $i++)
                <div class="col-sm px-3 py-1">
                    <div class="bg-white text-center p-2" id="item-product">
                        <img src="//placehold.it/300x350?text=Image Product" class="item-img-product">
                        <p class="bold font24 mt-2">Product name</p>
                        <p class="text-secondary font14 mb-3">Category > Category</p>
                        <a href="{{url('/detail-product')}}" class="btn btn-lg btn-yellow w-100"><span><i class="fa fa-shopping-cart float-left" style="padding-top:5px"></i> 0.00 บาท</span></a>
                    </div>
                </div>
				@endfor

            </div>
			
			
			
        </div>
    </div>
	
	@include('frontend/footer')
	</body>
</html>







