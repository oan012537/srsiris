{{-- Main navbar --> --}}
	@php
		$setting = DB::table('setting')->where('set_id',1)->first();
	@endphp
	<style>
		.navbar-inverse {
			background-color: {{$setting->set_nav}};
			/*border-color: #164962;*/
		}
		
		.navbar-brand {
			color: {{$setting->set_navfont}} !important;
		}
		
		.navbar-inverse 
		.navbar-nav > li > a {
			color: {{$setting->set_navfont}} !important;
		}
		
		.navbar-default 
		.navbar-nav > li > a {
			color: {{$setting->set_menu}} !important;
		}
		.not-active {
		  	pointer-events: none;
		  	cursor: default;
		  	text-decoration: none;
		  	color: black;
		  	background: black;
		  	margin-right: 1px;
		  	margin-left: 1px;
		  	width: 5px;
		}
		.showalert,.showalertupload{
			position: absolute;
			background: red;
			border-bottom-left-radius: 50%;
			border-top-left-radius: 50%;
			display: inline-flex;
			height: 14px;
			line-height: 1;
			border-top-right-radius: 50%;
			font-weight: 500;
			min-width: 14px;
			border-bottom-right-radius: 50%;
			-webkit-tap-highlight-color: transparent;
			text-align: inherit;
			font-size: 0.8rem;
			margin-left: -4px;
			margin-top: -5px;
		}
		.showdata,.showalertuploaddata{
			position: absolute;
			justify-content: center;
			padding-bottom: 0;
			padding-left: 5px;
			display: inline-flex;
			color: white;
			width: 100%;
			padding-right: 5px;
			padding-top: 0px;
			align-items: center;
			height: 100%;
			line-height: 1;
		}
		.showalert-mobile{
			position: absolute;
			background: red;
			border-bottom-left-radius: 50%;
			border-top-left-radius: 50%;
			display: inline-flex;
			height: 14px;
			line-height: 1;
			border-top-right-radius: 50%;
			font-weight: 500;
			min-width: 14px;
			border-bottom-right-radius: 50%;
			-webkit-tap-highlight-color: transparent;
			text-align: inherit;
			font-size: 0.8rem;
			margin-left: -4px;
			margin-top: -5px;
		}
		.showdata-mobile{
			position: absolute;
			justify-content: center;
			padding-bottom: 0;
			padding-left: 5px;
			display: inline-flex;
			color: white;
			width: 100%;
			padding-right: 5px;
			padding-top: 0px;
			align-items: center;
			height: 100%;
			line-height: 1;
		}
		/*.badge{
			border-radius: 10px;
			    padding: 3px 7px;
		}
		.bg-c-pink{
			background: linear-gradient(45deg, #FF5370, #ff869a);
		}*/
		/*.dataTable td{
			white-space:pre-wrap; 
		}*/
		
	</style>
	@php
	$menu = DB::table('permission')->select('permission_menu_id')->where('permission_position_id',Auth::user()->position)->get();
	$permission = [];
	foreach ($menu as $value) {
		$permission[] = $value->permission_menu_id;
	}
	@endphp
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-header">
			<img src="{{asset('assets/images/setting')}}/{{$setting->set_logo}}" alt="" style="float: left;margin: 6px;border-radius: 50%;margin-left: 10px;margin-right: -10px;">
			<a class="navbar-brand" href="{{url('dashboard')}}">
				
				{{$setting->set_name}}
			</a>

			<p class="navbar-text navbar-brand" style="padding-left: 5px;"><span class="label bg-success-400">ออนไลน์</span></p>
			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a href="{{url('/detailorderhnotproduct')}}" ><i class="icon-bell3"><span class="showalerts"><span class="showdatas">&nbsp;</span></span></i></a></li>
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			

			<ul class="nav navbar-nav navbar-right">
				{{-- <li class="dropdown language-switch">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="{{asset('assets/images/flags/gb.png')}}" class="position-left" alt="">
						English
						<span class="caret"></span>
					</a>

					<ul class="dropdown-menu">
						<li><a class="thai"><img src="{{asset('assets/images/flags/th.png')}}" alt=""> Thai</a></li>
						<li><a class="english"><img src="{{asset('assets/images/flags/gb.png')}}" alt=""> English</a></li>
					</ul>
				</li> --}}
				
				<li class="dropdown hidden-xs hidden-sm hidden-md">
					<a href="{{url('/detailorderhnotproduct')}}" >
						<i class="icon-bell3"><span class="showalerts"><span class="showdatas">&nbsp;</span></span></i>
						{{-- <span class="visible-xs-inline-block position-right"><i class="icon-bell2"></i></span> --}}
						{{-- <span class="caret"></span> --}}
					</a>
				</li>
				<li class="dropdown dropdown-user">
					<p class="navbar-text"><span class="" style="color: black;">{{Auth::user()->name }}</span></p>
				</li>
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						@if(Auth::user()->image)
						<img src="{{asset('assets/images/user')}}/{{Auth::user()->image}}" alt="" id="imageuser">
						@else
						<img src="{{asset('assets/images/placeholder.jpg')}}" alt="" id="imageuser">
						@endif
						<span><?php echo Session::get('FullName');?></span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="{{url('logout')}}"><i class="icon-switch2"></i> ออกจากระบบ</a></li>
					</ul>
				</li>
				
				@if(in_array('14',$permission))
				<li class="dropdown navbar-right">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-cog3"></i>
						<span class="visible-xs-inline-block position-right">Setting</span>
						<span class="caret"></span>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						{{-- <li><a href="{{url('backoffice/banner')}}"><i class="icon-home position-left"></i> แบนเนอร์</a></li> --}}
						{{-- <li><a href="{{url('groupcustomer')}}"><i class="icon-database position-left"></i> กลุ่มลูกค้า</a></li> --}}
						<li><a href="{{url('category')}}"><i class="icon-database position-left"></i> หมวดหมู่สินค้า</a></li>
						<li><a href="{{url('driver')}}"><i class="icon-users4 position-left"></i> พนักงานขับรถ</a></li>
						<li><a href="{{url('car')}}"><i class="icon-car position-left"></i> รถยนต์</a></li>
						<li><a href="{{url('area')}}"><i class="icon-car position-left"></i> เขตพื้นที่ลูกค้า</a></li>
						<li><a href="{{url('unit')}}"><i class="icon-database position-left"></i> หน่วย</a></li>
						<li><a href="{{url('logsystem')}}"><i class="icon-gear position-left"></i> log system</a></li>
						<li><a href="{{url('setheaderbill')}}"><i class="icon-profile position-left"></i> แก้ไขที่อยู่หัวบิล</a></li>
						<li><a href="{{url('percendiscount')}}"><i class="icon-percent position-left"></i> เปอร์เซ็นลดเงิน</a></li>
						{{-- <li><a href="{{url('logscanboxputtingcar')}}"><i class="icon-database position-left"></i> การสแกนขึ้นรถ</a></li> --}}
						<li><a href="{{url('setting')}}"><i class="icon-gear position-left"></i> การตั้งค่า</a></li>
						{{-- <li><a href="{{url('users')}}"><i class="icon-gear position-left"></i> กำหนดการใช้งาน</a></li> --}}
					</ul>
				</li>
				@endif
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Second navbar -->
	<div class="navbar navbar-default" id="navbar-second">
		<ul class="nav navbar-nav no-border visible-xs-block">
			<li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle"><i class="icon-menu7"></i></a></li>
		</ul>
		<div class="navbar-collapse collapse" id="navbar-second-toggle">
			<ul class="nav navbar-nav">
				

				@if(in_array('1',$permission))
				<li class="classdashboard"><a href="{{url('dashboard')}}"><i class="icon-display4 position-left"></i> หน้าแรก</a></li>
				@endif
				@if(in_array('2',$permission))
				<li class="dropdown classproduct">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-cart position-left"></i> สินค้า <span class="caret"></span><span class="badge bg-c-pink"></span>
					</a>
					
					<ul class="dropdown-menu width-200">
						<li><a href="{{url('product')}}"> สินค้าทั้งหมด</a></li>
						<li><a href="{{url('manufacture')}}"> ผลิตเอง</a></li>
						<li><a href="{{url('buyproduct')}}"> สินค้าที่ต้องซื้อ</a></li>
					</ul>
				</li>
				@endif
				@if(in_array('3',$permission))
				<li class="dropdown classcategory">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-list"></i> หมวดหมู่สินค้า <span class="caret"></span>
					</a>

					<ul class="dropdown-menu width-200" style="height: auto;max-height: 400px;overflow-x: hidden;">
						{{-- <li><a href="{{url('category')}}"> หมวดหมู่สินค้า</a></li> --}}
						{{-- <li><a href="{{url('subcategory')}}"> หมวดหมู่สินค้าย่อย</a></li> --}}
						{{-- <li><a href="{{url('unit')}}"> หน่วย</a></li> --}}

						@php
							$category = DB::table('category')->orderBy('category_name','asc')->get();
							$cate 		= [];
							$subcate 	= [];
							if($category){
								foreach($category as $rs){
									$subc = DB::table('subcategory')->where('sub_ref',$rs->category_id)->get();
									if(count($subc) > 0){
										@endphp
											<li class="dropdown-submenu">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown"> {{$rs->category_name}}</a>
												<ul class="dropdown-menu">
										@php
										foreach($subc as $ar){
											@endphp
													<li><a href="{{url('product')}}/{{$rs->category_id}}/{{$ar->sub_id}}">{{$ar->sub_name}}</a></li>
											@php
										}
										@endphp
												</ul>
											</li>
										@php
									}else{
										@endphp
											<li><a href="{{url('product')}}/category/{{$rs->category_id}}"> {{$rs->category_name}}</a></li>
										@php
									}
								}
							}
							
							
						@endphp
					</ul>
				</li>
				@endif
				<li class="not-active"><a href="#" class="disabled"> &nbsp;</a></li>
				@if(in_array('5',$permission))
				<li class="classcustomer"><a href="{{url('customer')}}"><i class="icon-users4 position-left"></i> ลูกค้า</a></li>
				@endif
				{{-- <li class="classorder"><a href="{{url('order')}}"><i class="icon-cart position-left"></i> ออเดอร์</a></li> --}}
				@if(in_array('6',$permission))
				<li class="classexport"><a href="{{url('export')}}"><i class="icon-cart position-left"></i> ออเดอร์</a></li>
				@endif
				@if(in_array('7',$permission))
				<li class="classselling"><a href="{{url('selling')}}"><i class="icon-coin-dollar position-left"></i> การขาย</a></li>
				@endif
				@if(in_array('8',$permission))
				<li class="classpacking"><a href="{{url('packing')}}"><i class="icon-box position-left"></i> แพ็คของ</a></li>
				@endif
				@if(in_array('9',$permission))
				<li class="classtransport"><a href="{{url('transport')}}"><i class="icon-truck position-left"></i> การขนส่ง</a></li>
				@endif
				@if(in_array('10',$permission))
                <li class="classbillingnote"><a href="{{url('billingnote')}}"><i class="icon-cash4 position-left"></i> การเก็บเงิน</a></li>
                @endif
                @if(in_array('15',$permission))
				<li class="classuploadslippay"><a href="{{url('uploadslippay')}}"><i class="icon-box-add text-left"></i> แจ้งการอัพโหลดสลิป<span class="showalertuploads"><span class="showalertuploaddatas">&nbsp;</span></span></a></li>
				@endif
                <li class="not-active"><a href="#" class="disabled"> &nbsp;</a></li>
				@if(in_array('4',$permission))
				<li class="classsupplier"><a href="{{url('supplier')}}"><i class="icon-users4 position-left"></i> ซัพพลายเออร์</a></li>
				@endif
				{{-- <li><a href="{{url('exp')}}"><i class="icon-box-remove position-left"></i> นำออก</a></li> --}}
				@if(in_array('11',$permission))
                <li class="classimports"><a href="{{url('imports')}}"><i class="icon-box-add text-left"></i> การนำเข้า</a></li>
                @endif
                <li class="not-active"><a href="#" class="disabled"> &nbsp;</a></li>
                {{-- <li><a href="{{url('pos')}}"><i class="icon-cart position-left"></i> POS</a></li> --}}
                @if(in_array('12',$permission))
				<li class="dropdown classreport">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-stack4 position-left"></i> รายงาน <span class="caret"></span>
					</a>

					<ul class="dropdown-menu width-200">
						<li><a href="{{url('reportcustomer')}}"> รายงานลูกค้า</a></li>
						{{-- <li><a href="{{url('reportexport')}}"> รายงานนำออก</a></li> --}}
						{{-- <li><a href="{{url('reportsale')}}"> รายงานการขาย</a></li> --}}

						<li><a href="{{url('reportsupplier')}}"> รายงานซัฟฟลายเออร์</a></li>
						<li><a href="{{url('reportstock')}}"> รายงานสต๊อก</a></li>
						<li><a href="{{url('reportsell')}}"> รายงานขาย</a></li>
						<li><a href="{{url('reporttrans')}}"> รายงานการจัดส่ง </a></li>
						<li><a href="{{url('reportorder')}}"> รายงานออเดอร์ </a></li>
					</ul>
				</li>
				@endif
				<li class="not-active"><a href="#" class="disabled"> &nbsp;</a></li>
				@if(in_array('13',$permission))
				<li class="dropdown classuser">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-users4 position-left"></i> ผู้ใช้งาน <span class="caret"></span>
					</a>

					<ul class="dropdown-menu width-200">
						<li><a href="{{url('users')}}"> ผู้ใช้งานทั้งหมด</a></li>
						<li><a href="{{url('position')}}"> จัดการตำแหน่ง</a></li>
						{{-- <li><a href="{{url('permission')}}"> กำหนดสิทธิ์</a></li> --}}
					</ul>
				</li>
				@endif
				{{-- <li class="not-active"><a href="#" class="disabled"> &nbsp;</a></li> --}}
				
			</ul>
			{{-- <ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-cog3"></i>
						<span class="visible-xs-inline-block position-right">Setting</span>
						<span class="caret"></span>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="{{url('groupcustomer')}}"><i class="icon-database position-left"></i> กลุ่มลูกค้า</a></li>
						<li><a href="{{url('category')}}"><i class="icon-database position-left"></i> หมวดหมู่สินค้า</a></li>
						<li><a href="{{url('driver')}}"><i class="icon-users4 position-left"></i> พนักงานขับรถ</a></li>
						<li><a href="{{url('car')}}"><i class="icon-car position-left"></i> รถยนต์</a></li>
						<li><a href="{{url('area')}}"><i class="icon-car position-left"></i> เขตพื้นที่ลูกค้า</a></li>
						<li><a href="{{url('unit')}}"><i class="icon-database position-left"></i> หน่วย</a></li>
						<li><a href="{{url('setheaderbill')}}"><i class="icon-profile position-left"></i> แก้ไขที่อยู่หัวบิล</a></li>
						<li><a href="{{url('logscanboxputtingcar')}}"><i class="icon-database position-left"></i> การสแกนขึ้นรถ</a></li>
						<li><a href="{{url('setting')}}"><i class="icon-gear position-left"></i> การตั้งค่า</a></li>
						<li><a href="{{url('users')}}"><i class="icon-gear position-left"></i> กำหนดการใช้งาน</a></li>
						<li class="dropdown ">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-stack4 position-left"></i> กำหนดการใช้งาน <span class="caret"></span>
							</a>
							<ul class="dropdown-menu width-200">
								<li><a href="{{url('reportimport')}}"> รายงานนำเข้า</a></li>
								<li><a href="{{url('reportexport')}}"> รายงานนำออก</a></li>
								<li><a href="{{url('reportsale')}}"> รายงานการขาย</a></li>
							</ul>
						</li>
					</ul>
				</li>
			</ul> --}}

		</div>
	</div>
	<script>
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			$(".not-active").remove();
		}
		var navbar = $('.navbar-nav li a').width();
		var wid = $(".navbar-brand").width()-25;
		console.log(navbar)
		$('.navbar-header img').css({'width': wid+'px'});
	</script>
	<!-- /second navbar