<!doctype html>
<html>
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="robot" content="noindex, nofollow" />
<meta name="generator" content="Brackets">
<meta name='copyright' content='Orange Technology Solution co.,ltd.'>
<meta name='designer' content='David M.'>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link type="image/ico" rel="shortcut icon" href="{{asset('assets/pos/images/favicon.ico')}}">

<link href="{{asset('assets/pos/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/pos/css/jquery-ui.min.css')}}" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="{{asset('assets/pos/css/layout.css')}}"/>
<link href="https://fonts.googleapis.com/css?family=Prompt:400,500|Roboto:400,500" rel="stylesheet">

<script src="{{asset('assets/pos/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/pos/js/popper.min.js')}}"></script>
<script src="{{asset('assets/pos/js/tether.min.js')}}"></script>
<script src="{{asset('assets/pos/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/pos/flexslider/js/modernizr.js')}}"></script>

<link rel="stylesheet" href="{{asset('assets/pos/owlcarousel/assets/owl.carousel.min.css')}}">
<script src="{{asset('assets/pos/owlcarousel/owl.carousel.min.js')}}"></script>

<link rel="stylesheet" href="{{asset('assets/pos/flexslider/flexslider.css')}}" type="text/css" media="screen" />
<script defer src="{{asset('assets/pos/flexslider/jquery.flexslider.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/pos/flexslider/js/shCore.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/pos/flexslider/js/shBrushJScript.js')}}"></script>
<script src="{{ asset('assets/js/bootbox.min.js') }}"></script>
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script type="text/javascript" language="javascript" src="{{asset('assets/pos/dotdotdot-master/src/js/jquery.dotdotdot.js')}}"></script>
	
	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="{{asset('assets/pos/fancybox/lib/jquery.mousewheel-3.0.6.pack.js')}}"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="{{asset('assets/pos/fancybox/source/jquery.fancybox.js?v=2.1.5')}}"></script>
	<link rel="stylesheet" type="text/css" href="{{asset('assets/pos/fancybox/source/jquery.fancybox.css?v=2.1.5')}}" media="screen" />

	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/pos/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5')}}" />
	<script type="text/javascript" src="{{asset('assets/pos/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5')}}"></script>

	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/pos/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7')}}" />
	<script type="text/javascript" src="{{asset('assets/pos/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7')}}"></script>

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="{{asset('assets/pos/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/pos/scrollbar-plugin/jquery.mCustomScrollbar.css')}}">
    <script src="{{asset('assets/pos/scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>   
    <script src="{{asset('assets/js/calculator.js')}}"></script>   
</head>
<body>
<div class="container-fluid">

    <style>
		.bg_menu{
			background-color: #fbbb12;
			height: 50px;
		}
		.logo{
			max-height: 50px;
			max-width: 100%;
			display: block;
		}
		.wrap_btn_menu{
				display: inline-block;
				text-align: left;
				padding-top: 12px;
				padding-bottom: 8px;
				padding-left: 0;
				padding-right: 0;
				color: #FFF;
				font-size: 14px;
				line-height: 26px;
				vertical-align: middle;
				width: 90px;
				cursor: pointer;
			}
			.btn_menu{
				display: inline-block;
				width: 24px;
				vertical-align: middle;
				padding-bottom: 4px;
				padding-right: 2px;
			}
			.btn_menu span{
				height: 3px;
				background-color: #FFF;
				display: block;
				position: relative;
				margin-top: 3px;
				border-radius: 5px;
				-webkit-transition: all  0.5s ease-in-out;
				-moz-transition:all  0.5s ease-in-out;
				-o-transition: all  0.5s ease-in-out;
				transition: all  0.5s ease-in-out;
			}
		.wrap_btn_top{
			text-align: right;
			position: relative;
		}
		.btn_menu span:nth-child(1){
				width: 80%;
			}
			.btn_menu span:nth-child(2){
				width: 60%;
			}
			.btn_menu span:nth-child(3){
				width: 100%;
			}
			.submenu li:first-child{
				padding-top: 10px;
			}
			.wrap_btn_menu.active .btn_menu span:nth-child(1){
				width: 100%;
				-ms-transform: rotate(45deg); /* IE 9 */
				-webkit-transform: rotate(45deg); /* Safari */
				transform: rotate(45deg);
				top: 6px;
			}
			.wrap_btn_menu.active .btn_menu span:nth-child(2){
				width: 100%;
				-ms-transform: rotate(45deg); /* IE 9 */
				-webkit-transform: rotate(45deg); /* Safari */
				transform: rotate(45deg);
				top: 0px;
			}
			.wrap_btn_menu.active .btn_menu span:nth-child(3){
				width: 100%;
				-ms-transform: rotate(-45deg); /* IE 9 */
				-webkit-transform: rotate(-45deg); /* Safari */
				transform: rotate(-45deg);
				top: -6px;
			}
			.mainmenu{
				padding-bottom: 15px;
				padding-top: 15px;
				padding-left: 15px;
				padding-right: 15px;
				display: none;
				background-color: #FFF;
				width: 200px;
				z-index: 999;
				right: 0;
				top: 100%;
				position: absolute;
				-webkit-border-bottom-right-radius: 5px;
				-webkit-border-bottom-left-radius: 5px;
				-moz-border-radius-bottomright: 5px;
				-moz-border-radius-bottomleft: 5px;
				border-bottom-right-radius: 5px;
				border-bottom-left-radius: 5px;
			}
			.mainmenu > li{
				display: block;
			}
			.mainmenu > li a{
				display: block;
				color: #333;
				font-weight: 500;
				font-size: 1.3rem;
				text-decoration: none;
				line-height: 1.2;
				padding-top: 10px;
				padding-bottom: 10px;
			}
	</style>
	<nav class="row bg_menu">
		<div class="col-12 col-md-4">
			<img class="logo" src="{{asset('assets/pos/images/orange_pos_logo.png')}}">
		</div>
		<!-- <div class="col-12 col-md-8 wrap_btn_top">
			<div class="wrap_btn_menu"><div class="btn_menu"><span></span><span></span><span></span></div> MENU</div>
			<ul class="col-12 mainmenu">
						<li><a href="#">Menu 1</a>
						<li><a href="#">Menu 2</a></li>
					</ul>
		</div> -->
	</nav>

    
    <div class="row page_relative">
        <div class="col-12 col-md-7 col-xl-8 wrap_product">
            <div class="input-group searchbox">
                <input type="text" class="form-control" id="searchproduct" placeholder="Search...">
                <div class="search_button">
                  <button type="button"></button>
                </div>
            </div>
            <div class="wrap_productcate">
                <div class="owl-carousel owl-productcate">
                    <div class="item_category active" onclick="category('0')"><a class="btn_tab" href="#all">All</a></div>
					@php
						if($categorys){
							foreach($categorys as $cate){
								@endphp
									<div class="item_category" onclick="category({{$cate->category_id}})"><a class="btn_tab" href="#">{{$cate->category_name}}</a></div>
								@php
							}
						}
					@endphp
                </div>
            </div>
            <div class="product_scroll mCustomScrollbar" id="all">
                <div class="row" id="rowdataproduct">
					@php
						if($data){
							foreach($data as $rs){
								@endphp
								<div class="col-6 col-sm-4 col-md-4 col-xl-3 item_product">
									<a href="#"><span onclick="addcart({{$rs['productid']}})">
										<figure><img src="{{asset('assets/images/product')}}/{{$rs['productpicture']}}"></figure>
										<figcaption>{{number_format($rs['productprice'],2).'   บาท  |  '.$rs['productname']}}</figcaption>
									</span></a>
								</div>
								@php
							}
						}
					@endphp
                </div>
            </div>
        </div>
        <div class="col-12 col-md-5 col-xl-4 wrap_right_content">
            <div class="wrap_order">
                <div class="wrap_owlorder">
                    <div class="owl-carousel owl-order">
                        <div class="item_order active"><a class="btn_order" href="#">1 <span>10:00</span></a></div>
                        <div class="item_order"><a class="btn_order" href="#">2 <span>10:05</span></a></div>
                        <div class="item_order"><a class="btn_order" href="#">3 <span>10:16</span></a></div>
                        <div class="item_order"><a class="btn_order" href="#">4 <span>10:32</span></a></div>
                    </div>
                    <button class="btn_addorder">+</button>
                    <button class="btn_deleteorder">-</button>
                </div>
            </div>
            <div class="wrap_client">
                <input type="text" class="form-control" placeholder="Client">
            </div>
            <div class="wrap_barcode input-group">
                <input type="text" class="form-control" id="searchbarcode" placeholder="Barcode Scanner">
                <div class="barcode_button">
                  <button type="button">Add</button>
                </div>
            </div>
            <div class="head_product_add">
                PRODUCT
            </div>
            <div class="productadd_scroll mCustomScrollbar">
				<div id="rowitem">
				
				</div>
			</div>
            <div class="wrap_promo input-group">
                <input type="text" class="form-control" placeholder="Gift card or discount code">
                <div class="promo_button">
                  <button type="button">Apply</button>
                </div>
            </div>
            <div class="wrap_total subtotal">
                <div class="text_total01">Subtotal</div><div class="text_total02"><span id="countcart"></span> items</div><div class="total_price_no">฿ <span id="subtotal"></span></div>
            </div>
            <div class="wrap_total vat">
                <div class="text_total01">Vat</div><div class="text_total02">7%</div><div class="total_price_no">฿ <span id="vat"></span></div>
            </div>
            <div class="wrap_total discounts">
                <div class="text_total01">Discounts</div><div class="text_total02">0</div><div class="total_price_no">0</div>
            </div>
            <div class="wrap_total_price">
                <div class="text_total01">Total</div><div class="last_total_price_no">฿ <span id="total"></span></div>
            </div>
            <div class="wrap_btn_added_item">
                <a href="{{url('postreset')}}"><button class="btn_cancel">Cancel</button></a> <button class="btn_payment">Payment</button>
            </div>
        </div>
        <div class="wrap_payment">
            <div class="row">
                <div class="col-12 col-md-3">
                </div>
                <div class="col-12 col-md-5">
                    <div class="payment_total">
                        <div class="text_total01">Subtotal</div><div class="text_total02"><span id="countpaycart"> items</div><div class="total_price_no">฿ <span id="paysubtotal"></span></div>
                    </div>
                    <div class="payment_total">
                        <div class="text_total01">Vat</div><div class="text_total02">7%</div><div class="total_price_no">฿ <span id="payvat"></span></div>
                    </div>
                    <div class="payment_total">
                        <div class="text_total01">Discounts</div><div class="text_total02">0</div><div class="total_price_no">0</div>
                    </div>
                    <div class="payment_total last_paymnet_total">
                        <div class="text_total01">Total</div><div class="last_total_price_no">฿ <span id="paytotal"></span></div>
                    </div>
                    <button class="btn_back">Back</button>
                </div>
                <div class="col-12 col-md-4">
                    <div class="input_payment">
                        <input type="text" class="form-control" name="calc_result" id="calc_result" placeholder="0.00" readonly>
                    </div>
                    <div class="wrap_numpad">
                        <div class="creditcard"><span>Credit<br>Card</span></div><div class="number"><span onclick="javascript:add_calc('calc',7);">7</span></div><div class="number"><span onclick="javascript:add_calc('calc',8);">8</span></div><div class="number"><span onclick="javascript:add_calc('calc',9);">9</span></div><div><span onclick="javascript:f_calc('calc','+');">+</span></div><div class="number"><span onclick="javascript:add_calc('calc',4);">4</span></div><div class="number"><span onclick="javascript:add_calc('calc',5);">5</span></div><div class="number"><span onclick="javascript:add_calc('calc',6);">6</span></div><div><span onclick="javascript:f_calc('calc','-');">-</span></div><div class="number"><span onclick="javascript:add_calc('calc',1);">1</span></div><div class="number"><span onclick="javascript:add_calc('calc',2);">2</span></div><div class="number"><span onclick="javascript:add_calc('calc',3);">3</span></div><div><span onclick="javascript:f_calc('calc','ce');">C</span></div><div><span onclick="javascript:f_calc('calc','=');">=</span></div><div class="number"><span onclick="javascript:add_calc('calc',0);">0</span></div><div class="number"><span onclick="javascript:add_calc('calc','.');">.</span></div>
                    </div>
                    <div class="wrap_btn_cash"><button class="btn_cash" id="paymentcash">CASH</button></div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<div class="flash-message">
	@if(Session::has('alert-insert'))
		<button type="button" id="miniSuccessTitle_insert" class="btn btn-raised btn-success miniSuccessTitle" style="display:none"></button>
	@elseif(Session::has('alert-update'))
		<button type="button" id="miniSuccessTitle_update" class="btn btn-raised btn-success miniSuccessTitle" style="display:none"></button>
	elseif(Session::has('alert-approve'))
		<button type="button" id="miniSuccessTitle_approve" class="btn btn-raised btn-success miniSuccessTitle" style="display:none"></button>
	@elseif(Session::has('alert-delete'))
		<button type="button" id="miniSuccessTitle_delete" class="btn btn-raised btn-success miniSuccessTitle" style="display:none"></button>
	@endif
</div>
    
<script>
$('#paymentcash').click(function(){
	bootbox.confirm({
		title: "ยืนยัน?",
		message: "คุณต้องการยืนยันบันทึกรายการนี้ หรือไม่?",
		buttons:{
			cancel: {
				label: '<i class="fa fa-times"></i> ยกเลิก',
				className: 'btn-danger'
			},
			confirm:{
				label: '<i class="fa fa-check"></i> ยืนยัน',
				className: 'btn-success'
			}
		},
		callback: function (result){
			if(result == true){
				window.location.href="pospayment";
			}
		}
	});
});

$(document).ready(function(){
	$( ".miniSuccessTitle:first" ).trigger( "click" );
});
	
function formatNumber (x) {
	return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}

function category(id){
	$.ajax({
	'dataType': 'json',
	'type': 'post',
	'url': "{{url('poscategory')}}",
	'data': {
		'cateid' : id,
		'_token': "{{ csrf_token() }}"
	},
		'success': function (data) {
			$('.item_product').remove();
			$.each(data,function(key,item){
				$('#rowdataproduct').append('<div class="col-6 col-sm-4 col-md-4 col-xl-3 item_product">'
					+'<a href="#"><span onclick="addcart('+item.productid+')">'
					+'<figure><img src="{{asset("assets/images/product")}}/'+item.productpicture+'"></figure>'
					+'<figcaption>'+formatNumber(item.productprice)+'   บาท  |  '+item.productname+'</figcaption>'
					+'</span></a>'
				+'</div>');
			});
		}
	});
}

$('#searchproduct').keyup(function(){
	$.ajax({
	'dataType': 'json',
	'type': 'post',
	'url': "{{url('poskeyword')}}",
	'data': {
		'keyword' : $(this).val(),
		'_token': "{{ csrf_token() }}"
	},
		'success': function (data) {
			$('.item_product').remove();
			$.each(data,function(key,item){
				$('#rowdataproduct').append('<div class="col-6 col-sm-4 col-md-4 col-xl-3 item_product">'
					+'<a href="#"><span onclick="addcart('+item.productid+')">'
					+'<figure><img src="{{asset("assets/images/product")}}/'+item.productpicture+'"></figure>'
					+'<figcaption>'+formatNumber(item.productprice)+'   บาท  |  '+item.productname+'</figcaption>'
					+'</span></a>'
				+'</div>');
			});
		}
	});
});

$(document).ready(function(){
	$.ajax({
	'dataType': 'json',
	'type': 'post',
	'url': "{{url('querycarts')}}",
	'data': {
		'_token': "{{ csrf_token() }}"
	},
		'success': function (data) {
			$('.added_item').remove();
			$.each(data.value,function(key,item){
                $('#rowitem').append('<div class="added_item"><figure><img src="{{asset("assets/images/product/")}}/'+item.picture+'"></figure>'
					+'<figcaption><span>'+item.name+'</span><div class="item_price">฿ '+formatNumber(item.price.toFixed(2))+'<input type="hidden" name="price" id="price'+item.rowid+'" value="'+item.price+'"></div><div class="item_qty">'
                            +'<div class="sp-quantity">'
                                +'<div class="sp-minus" onclick="minus(\''+item.rowid+'\')"> <div class="btnquantity">-</div>'
                                +'</div><div class="sp-input">'
                                    +'<input type="text" class="quntity-input" name="qty" id="qty'+item.rowid+'" value="'+item.qty+'" />'
                                +'</div><div class="sp-plus" onclick="plus(\''+item.rowid+'\')"> <div class="btnquantity">+</div>'
                                +'</div>'
                            +'</div>'
                        +'</div><div class="total_price">฿ '+formatNumber(parseFloat(item.price*item.qty).toFixed(2))+'<input type="hidden" name="total" id="total'+item.rowid+'" value="'+parseFloat(item.price*item.qty)+'"></div>'
                    +'</figcaption>'
                    +'<button class="btn_remove" onclick="delcart(\''+item.rowid+'\')">X</button>'
                +'</div>');
			});
			
			$('#countcart').text(data.value.length);
			$('#subtotal').text(data.totals['subtotal']);
			$('#vat').text(data.totals['tax']);
			$('#total').text(data.totals['total']);
			$('#countpaycart').text(data.value.length);
			$('#paysubtotal').text(data.totals['subtotal']);
			$('#payvat').text(data.totals['tax']);
			$('#paytotal').text(data.totals['total']);
		}
	});
	
	$(".fancybox-frame").fancybox({
		maxWidth: 900,
		width: '100%',
		height: '100%'
	});
	
	$('.fancybox').fancybox();
			
	$('.dotmaster').dotdotdot({
		watch: 'window'
	});
				
	$( '.wrap_btn_menu' ).click(function (event) {
	  if (  $( ".mainmenu" ).is( ":hidden" ) ) {
			$(this).addClass("active");
			$('.mainmenu').slideDown();
	  } else {
		  $('.mainmenu').slideUp();
		  $(this).removeClass("active");
	  }
	  event.stopPropagation();
	});
	
	$( 'html' ).click(function (event) {
		
	});
		
    $('.owl-productcate').on('initialized.owl.carousel', function(event){ 
        var psh = $( window ).height() - ($('.bg_menu').outerHeight(true) + $('.searchbox').outerHeight(true) + $('.wrap_productcate').outerHeight(true)) - 15;
        $('.product_scroll').css('height', psh);
    });
    $(".owl-productcate").owlCarousel({
        loop:false,
        margin:0,
        nav:false,
        dots:false,
        autoplay:false,
        autoplayTimeout:6000,
        slideBy: 1,
        autoWidth:true,
        responsive:{
            0:{
                items:4
                //margin:10,
                //slideBy: 3
            },
            768:{
                items:6
            },
            992:{
                items:7
            },
            1300:{
                items:7
            }
        }
    });
    
    $('.owl-order').on('initialized.owl.carousel', function(event){ 
        var pdah = $( window ).height() - ($('.bg_menu').outerHeight(true) + $('.wrap_order').outerHeight(true) + $('.wrap_client').outerHeight(true) + $('.wrap_barcode').outerHeight(true) + $('.head_product_add').outerHeight(true) + $('.wrap_promo').outerHeight(true) + $('.subtotal').outerHeight(true) + $('.vat').outerHeight(true) + $('.discounts').outerHeight(true) + $('.wrap_total_price').outerHeight(true) + $('.wrap_btn_added_item').outerHeight(true) + 8);
        $('.productadd_scroll').css('height', pdah);
    });
    $(".owl-order").owlCarousel({
        loop:false,
        margin:2,
        nav:false,
        dots:false,
        autoplay:false,
        autoplayTimeout:6000,
        slideBy: 1,
        autoWidth:true,
        responsive:{
            0:{
                items:3
                //margin:10,
                //slideBy: 3
            },
            768:{
                items:3
            },
            992:{
                items:3
            },
            1300:{
                items:3
            }
        }
    });
    
     $(window).on('load', function () {
          setTimeout(function(){ $('.owl-productcate').trigger('refresh.owl.carousel'); }, 100);
     });
    
});    

$(".btn_payment").on("click", function () {    
    $('.wrap_payment').fadeIn();
});
$(".btn_back").on("click", function () {    
    $('.wrap_payment').fadeOut();
});    
    
$(".btnquantity").on("click", function () {

    var $button = $(this);
    var oldValue = $button.closest('.sp-quantity').find("input.quntity-input").val();

    if ($button.text() == "+") {
        var newVal = parseFloat(oldValue) + 1;
    } else {
        // Don't allow decrementing below zero
        if (oldValue > 1) {
            var newVal = parseFloat(oldValue) - 1;
        } else {
            newVal = 1;
        }
    }

    $button.closest('.sp-quantity').find("input.quntity-input").val(newVal);

});

$('#searchbarcode').keypress(function(e){
	if(e.which == 13){
		$.ajax({
		'dataType': 'json',
		'type': 'post',
		'url': "{{url('posbarcode')}}",
		'data': {
			'barcode' : $(this).val(),
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data) {
				$('.added_item').remove();
				$.each(data.value,function(key,item){
					$('#rowitem').append('<div class="added_item"><figure><img src="{{asset("assets/images/product/")}}/'+item.picture+'"></figure>'
						+'<figcaption><span>'+item.name+'</span><div class="item_price">฿ '+formatNumber(item.price.toFixed(2))+'<input type="hidden" name="price" id="price'+item.rowid+'" value="'+item.price+'"></div><div class="item_qty">'
								+'<div class="sp-quantity">'
									+'<div class="sp-minus" onclick="minus(\''+item.rowid+'\')"> <div class="btnquantity">-</div>'
									+'</div><div class="sp-input">'
										+'<input type="text" class="quntity-input" name="qty" id="qty'+item.rowid+'" value="'+item.qty+'" />'
									+'</div><div class="sp-plus" onclick="plus(\''+item.rowid+'\')"> <div class="btnquantity">+</div>'
									+'</div>'
								+'</div>'
							+'</div><div class="total_price">฿ '+formatNumber(parseFloat(item.price*item.qty).toFixed(2))+'<input type="hidden" name="total" id="total'+item.rowid+'" value="'+parseFloat(item.price*item.qty)+'"></div>'
						+'</figcaption>'
						+'<button class="btn_remove" onclick="delcart(\''+item.rowid+'\')">X</button>'
					+'</div>');
				});
				
				$('#countcart').text(data.value.length);
				$('#subtotal').text(data.totals['subtotal']);
				$('#vat').text(data.totals['tax']);
				$('#total').text(data.totals['total']);
				$('#countpaycart').text(data.value.length);
				$('#paysubtotal').text(data.totals['subtotal']);
				$('#payvat').text(data.totals['tax']);
				$('#paytotal').text(data.totals['total']);
				
				$('#searchbarcode').val(' ');
				$('#searchbarcode').focus();
			}
		});
	}
});

function addcart(id){
	$.ajax({
	'dataType': 'json',
	'type': 'post',
	'url': "{{url('addcarts')}}",
	'data': {
		'productid' : id,
		'_token': "{{ csrf_token() }}"
	},
		'success': function (data) {
			$('.added_item').remove();
			$.each(data.value,function(key,item){
                $('#rowitem').append('<div class="added_item"><figure><img src="{{asset("assets/images/product/")}}/'+item.picture+'"></figure>'
					+'<figcaption><span>'+item.name+'</span><div class="item_price">฿ '+formatNumber(item.price.toFixed(2))+'<input type="hidden" name="price" id="price'+item.rowid+'" value="'+item.price+'"></div><div class="item_qty">'
                            +'<div class="sp-quantity">'
                                +'<div class="sp-minus" onclick="minus(\''+item.rowid+'\')"> <div class="btnquantity">-</div>'
                                +'</div><div class="sp-input">'
                                    +'<input type="text" class="quntity-input" name="qty" id="qty'+item.rowid+'" value="'+item.qty+'" />'
                                +'</div><div class="sp-plus" onclick="plus(\''+item.rowid+'\')"> <div class="btnquantity">+</div>'
                                +'</div>'
                            +'</div>'
                        +'</div><div class="total_price">฿ '+formatNumber(parseFloat(item.price*item.qty).toFixed(2))+'<input type="hidden" name="total" id="total'+item.rowid+'" value="'+parseFloat(item.price*item.qty)+'"></div>'
                    +'</figcaption>'
                    +'<button class="btn_remove" onclick="delcart(\''+item.rowid+'\')">X</button>'
                +'</div>');
			});
			
			$('#countcart').text(data.value.length);
			$('#subtotal').text(data.totals['subtotal']);
			$('#vat').text(data.totals['tax']);
			$('#total').text(data.totals['total']);
			$('#countpaycart').text(data.value.length);
			$('#paysubtotal').text(data.totals['subtotal']);
			$('#payvat').text(data.totals['tax']);
			$('#paytotal').text(data.totals['total']);
		}
	});
}

function minus(id){
	var qty 		= $('#qty'+id).val()||0;
	var sumqty		= parseInt(qty-1);
	$('#qty'+id).val(sumqty);

	$.ajax({
	'dataType': 'json',
	'type': 'post',
	'url': "{{url('updatecarts')}}",
	'data': {
		'rowId' : id,
		'qty' : sumqty,
		'_token': "{{ csrf_token() }}"
	},
		'success': function (data) {
			$('.added_item').remove();
			$.each(data.value,function(key,item){
                $('#rowitem').append('<div class="added_item"><figure><img src="{{asset("assets/images/product/")}}/'+item.picture+'"></figure>'
					+'<figcaption><span>'+item.name+'</span><div class="item_price">฿ '+formatNumber(item.price.toFixed(2))+'<input type="hidden" name="price" id="price'+item.rowid+'" value="'+item.price+'"></div><div class="item_qty">'
                            +'<div class="sp-quantity">'
                                +'<div class="sp-minus" onclick="minus(\''+item.rowid+'\')"> <div class="btnquantity">-</div>'
                                +'</div><div class="sp-input">'
                                    +'<input type="text" class="quntity-input" name="qty" id="qty'+item.rowid+'" value="'+item.qty+'" />'
                                +'</div><div class="sp-plus" onclick="plus(\''+item.rowid+'\')"> <div class="btnquantity">+</div>'
                                +'</div>'
                            +'</div>'
                        +'</div><div class="total_price">฿ '+formatNumber(parseFloat(item.price*item.qty).toFixed(2))+'<input type="hidden" name="total" id="total'+item.rowid+'" value="'+parseFloat(item.price*item.qty)+'"></div>'
                    +'</figcaption>'
                    +'<button class="btn_remove" onclick="delcart(\''+item.rowid+'\')">X</button>'
                +'</div>');
			});
			
			$('#countcart').text(data.value.length);
			$('#subtotal').text(data.totals['subtotal']);
			$('#vat').text(data.totals['tax']);
			$('#total').text(data.totals['total']);
			$('#countpaycart').text(data.value.length);
			$('#paysubtotal').text(data.totals['subtotal']);
			$('#payvat').text(data.totals['tax']);
			$('#paytotal').text(data.totals['total']);
		}
	});
}

function plus(id){
	var qty 		= $('#qty'+id).val()||0;
	var sumqty		= parseInt(qty) + (1);
	$('#qty'+id).val(sumqty);

	$.ajax({
	'dataType': 'json',
	'type': 'post',
	'url': "{{url('updatecarts')}}",
	'data': {
		'rowId' : id,
		'qty' : sumqty,
		'_token': "{{ csrf_token() }}"
	},
		'success': function (data) {
			$('.added_item').remove();
			$.each(data.value,function(key,item){
                $('#rowitem').append('<div class="added_item"><figure><img src="{{asset("assets/images/product/")}}/'+item.picture+'"></figure>'
					+'<figcaption><span>'+item.name+'</span><div class="item_price">฿ '+formatNumber(item.price.toFixed(2))+'<input type="hidden" name="price" id="price'+item.rowid+'" value="'+item.price+'"></div><div class="item_qty">'
                            +'<div class="sp-quantity">'
                                +'<div class="sp-minus" onclick="minus(\''+item.rowid+'\')"> <div class="btnquantity">-</div>'
                                +'</div><div class="sp-input">'
                                    +'<input type="text" class="quntity-input" name="qty" id="qty'+item.rowid+'" value="'+item.qty+'" />'
                                +'</div><div class="sp-plus" onclick="plus(\''+item.rowid+'\')"> <div class="btnquantity">+</div>'
                                +'</div>'
                            +'</div>'
                        +'</div><div class="total_price">฿ '+formatNumber(parseFloat(item.price*item.qty).toFixed(2))+'<input type="hidden" name="total" id="total'+item.rowid+'" value="'+parseFloat(item.price*item.qty)+'"></div>'
                    +'</figcaption>'
                    +'<button class="btn_remove" onclick="delcart(\''+item.rowid+'\')">X</button>'
                +'</div>');
			});
			
			$('#countcart').text(data.value.length);
			$('#subtotal').text(data.totals['subtotal']);
			$('#vat').text(data.totals['tax']);
			$('#total').text(data.totals['total']);
			$('#countpaycart').text(data.value.length);
			$('#paysubtotal').text(data.totals['subtotal']);
			$('#payvat').text(data.totals['tax']);
			$('#paytotal').text(data.totals['total']);
		}
	});
}

function delcart(id){
	$.ajax({
	'dataType': 'json',
	'type': 'post',
	'url': "{{url('delcarts')}}",
	'data': {
		'rowId' : id,
		'_token': "{{ csrf_token() }}"
	},
		'success': function (data) {
			$('.added_item').remove();
			$.each(data.value,function(key,item){
                $('#rowitem').append('<div class="added_item"><figure><img src="{{asset("assets/images/product/")}}/'+item.picture+'"></figure>'
					+'<figcaption><span>'+item.name+'</span><div class="item_price">฿ '+formatNumber(item.price.toFixed(2))+'<input type="hidden" name="price" id="price'+item.rowid+'" value="'+item.price+'"></div><div class="item_qty">'
                            +'<div class="sp-quantity">'
                                +'<div class="sp-minus" onclick="minus(\''+item.rowid+'\')"> <div class="btnquantity">-</div>'
                                +'</div><div class="sp-input">'
                                    +'<input type="text" class="quntity-input" name="qty" id="qty'+item.rowid+'" value="'+item.qty+'" />'
                                +'</div><div class="sp-plus" onclick="plus(\''+item.rowid+'\')"> <div class="btnquantity">+</div>'
                                +'</div>'
                            +'</div>'
                        +'</div><div class="total_price">฿ '+formatNumber(parseFloat(item.price*item.qty).toFixed(2))+'<input type="hidden" name="total" id="total'+item.rowid+'" value="'+parseFloat(item.price*item.qty)+'"></div>'
                    +'</figcaption>'
                    +'<button class="btn_remove" onclick="delcart(\''+item.rowid+'\')">X</button>'
                +'</div>');
			});
			
			$('#countcart').text(data.value.length);
			$('#subtotal').text(data.totals['subtotal']);
			$('#vat').text(data.totals['tax']);
			$('#total').text(data.totals['total']);
			$('#countpaycart').text(data.value.length);
			$('#paysubtotal').text(data.totals['subtotal']);
			$('#payvat').text(data.totals['tax']);
			$('#paytotal').text(data.totals['total']);
		}
	});
}

window.onload = function() {
	init_calc('calc');
}
</script>

</body>
</html>