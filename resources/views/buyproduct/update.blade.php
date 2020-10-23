@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- <div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Customer / Update
				</h4>
			</div>
		</div>
	</div>-->
	<!-- /page header -->
	<style type="text/css">
		.classproduct{
			background: rgb(199,199,199,0.3);
		}
	</style>

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">
				<div class="row">
					<div class="col-md-12">
						<!-- Vertical form -->
						<div class="panel panel-flat">
							<div class="panel-heading">
								<div class="heading-elements">
									<ul class="icons-list">
										<li><a data-action="collapse"></a></li>
										<li><a data-action="reload"></a></li>
										<li><a data-action="close"></a></li>
									</ul>
								</div>
							</div>
							
							<form method="post" action="{{url('customer_update')}}">
							{{ csrf_field() }}
							<input type="hidden" name="updateid" value="{{$customer->customer_id}}">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6 col-md-6 col-md-offset-3">
										<fieldset>
											<legend class="text-semibold">ข้อมูลลูกค้า</legend>
											<div class="form-group">
												<label>รูปร้าน :</label>
												<div class="file-loading"> 
													<input type="file" id="imageshop" name="imageshop[]" multiple >
												</div>
												<span class="help-block">ขนาดรูป : 305 x 425px</span>
												@if(!empty($shopimage))
												<?php
												$txt = '';
													foreach($shopimage as $value){
														$txt .= $value->imageshopcustomer_name.',';
													}
													$txt = substr($txt, 0,-1);
													?>
												@endif
											</div>
											<div class="form-group">
                                                <label>ที่อยู่ :</label>
                                                <div class="input-control">
                                                    <input class="col-sm-12 form-control" id="location" name="location" type="text" required value="{{$customer->location}}">
                                                    <input type="hidden" id="mapsLat" name="lat" value="{{$customer->lat}}">
                                                    <input type="hidden" id="mapsLng" name="lng" value="{{$customer->lng}}">
                                                    <div id="map" style="width:100%;height:200px;border:1px solid f1f1f1"></div>
                                                </div>
                                            </div>
											<div class="form-group">
												<label>เลขประจำตัวผู้เสียภาษีอากร :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="idtax" id="idtax" value="{{$customer->customer_idtax}}" required="">
												</div>
											</div>
											<div class="form-group">
												<label>รูปผู้ใช้งาน :</label>
												<input type="file" class="file-input" name="imageuser" >
												<span class="help-block">ขนาดรูป : 305 x 425px</span>
												@if(!empty($customer->customer_imageuser))
													<img src="{{asset('assets/images/customer')}}/{{$customer->customer_imageuser}}" width="300px" class="img-thumbnail">
												@endif
											</div>
											<div class="form-group">
												<label>ชื่อลูกค้า :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="name" id="name" value="{{$customer->customer_name}}" required>
												</div>
											</div>
											<div class="form-group">
												<label>เบอร์ติดต่อ :</label>
												<div class="input-control">
													<input type="text" class="form-control number" name="tel" id="tel" value="{{$customer->customer_tel}}" maxlength="10" required>
												</div>
											</div>
											<div class="form-group">
												<label>อีเมล์ :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="email" id="email" value="{{$customer->customer_email}}" required>
												</div>
											</div>
											<div class="form-group">
												<label>เครดิต :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="credit" id="credit" value="{{$customer->customer_credit}}" required>
												</div>
											</div>
											<div class="form-group">
												<label>เครดิตเงินที่ค้างได้ :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="creditmoney" id="creditmoney" value="{{$customer->customer_creditmoney}}" required>
												</div>
											</div>
											<div class="form-group">
												<label>รูปลายเซนต์เช็ค :</label>
												<input type="file" class="file-input" name="imagesignature" >
												<span class="help-block">ขนาดรูป : 305 x 425px</span>
												@if(!empty($customer->customer_imagesignature))
													<img src="{{asset('assets/images/customer')}}/{{$customer->customer_imagesignature}}" width="300px" class="img-thumbnail">
												@endif
											</div>
											<br>
											<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<label>บ้านเลขที่ - ซอย :</label>
														<div class="input-control">
															<input type="text" class="form-control" name="address1" id="address1" value="{{$customer->customer_address1}}">
														</div>
													</div>
												</div>
												
												<div class="col-md-3 col-md-offset-1">
													<div class="form-group">
														<label>ถนน :</label>
														<div class="input-control">
															<input type="text" class="form-control" name="address2" id="address2" value="{{$customer->customer_address2}}">
														</div>
													</div>
												</div>
												
												<div class="col-md-3 col-md-offset-1">
													<div class="form-group">
														<label>เขต / อำเภอ :</label>
														<div class="input-control">
															<input type="text" class="form-control" name="address3" id="address3"  value="{{$customer->customer_address3}}">
														</div>
													</div>
												</div>
												
												<div class="col-md-4">
													<div class="form-group">
														<label>จังหวัด :</label>
														<div class="input-control">
															<input type="text" class="form-control" name="address4" id="address4"  value="{{$customer->customer_address4}}">
														</div>
													</div>
												</div>
												
												<div class="col-md-3 col-md-offset-1">
													<div class="form-group">
														<label>รหัสไปรษณย์ :</label>
														<div class="input-control">
															<input type="text" class="form-control" name="address5" id="address5"  value="{{$customer->customer_address5}}">
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>กลุ่มลูกค้า :</label>
												<div class="input-control">
													<select class="form-control" name="groupcustomer" id="groupcustomer">
														<option value="">ไม่ระบุ</option>
													</select>
												</div>
											</div>
											</br>
											<div class="form-group">
												<label>เกรดราคาขายส่ง :</label>
												<div class="input-control">
													<div class="radio">
														<label>
															@php
																if($customer->customer_rate == 1){
																	@endphp
																	<input type="radio" class="styled" name="rate" id="rate1" value="1" checked="checked">เกรด 1
																	@php
																}else{
																	@endphp
																	<input type="radio" class="styled" name="rate" id="rate1" value="1">เกรด 1
																	@php
																}
															@endphp
														</label>
													</div>
													<div class="radio">
														<label>
															@php
																if($customer->customer_rate == 2){
																	@endphp
																	<input type="radio" class="styled" name="rate" id="rate2" value="2" checked="checked">เกรด 2
																	@php
																}else{
																	@endphp
																	<input type="radio" class="styled" name="rate" id="rate2" value="2">เกรด 2
																	@php
																}
															@endphp
														</label>
													</div>
													<div class="radio">
														<label>
															@php
																if($customer->customer_rate == 2){
																	@endphp
																	<input type="radio" class="styled" name="rate" id="rate3" value="3" checked="checked">เกรด 3
																	@php
																}else{
																	@endphp
																	<input type="radio" class="styled" name="rate" id="rate3" value="3">เกรด 3
																	@php
																}
															@endphp
														</label>
													</div>
												</div>
											</div>
                                            <!--<div class="form-group">
												<label>ที่อยู่ :</label>
												<div class="input-control">
                                                    <textarea name="address" class="form-control" required style="resize: vertical;" rows="3">{{$customer->customer_detail}}</textarea>
												</div>
											</div>-->
											<div class="form-group">
												<label>หมายเหตุ :</label>
												<div class="input-control">
                                                    <textarea name="note" class="form-control" style="resize: vertical;" rows="3">{{$customer->customer_note}}</textarea>
												</div>
											</div>
											<br>
											<div class="text-right">
												<a href="{{url('customer')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
												<button type="submit" class="btn btn-primary"><i class="icon-floppy-disk"></i>  บันทึก</button>
											</div>
										</fieldset>
									</div>
								</div>
								</form>
							</div>
						</div>
						<!-- /vertical form -->
					</div>
				</div>
			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
<script>
	function initialize() {


        var geocoder;
        var infowindow;
        var place;
        var marker;
        var lat = $('input[name="lat"]').val();
        var lng = $('input[name="lng"]').val();
        
        if(lat == ''){
            lat = '13.723419';  
        }
        
        if(lng == ''){
            lng = '100.476232';  
        }
        
        geocoder = new google.maps.Geocoder();
        
        
        
        var Position = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            center: Position, //ตำแหน่งแสดงแผนที่เริ่มต้น
            zoom: 13, //ซูมเริ่มต้น คือ 8
            mapTypeId: google.maps.MapTypeId.ROADMAP //ชนิดของแผนที่
        };
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
        var input = document.getElementById('location');
        infowindow = new google.maps.InfoWindow();
        marker = new google.maps.Marker({
            position: Position,
            draggable: true
        });
        
        marker.setMap(map);//แสดงตัวปักหมุด!!
        showMapVal(Position.jb, Position.kb);
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {//ทำงานเมื่อคลิกที่รายการค้นหา

            infowindow.close();
            marker.setVisible(false);
            input.className = '';
            place = autocomplete.getPlace();
            
            var loca = place.geometry.location.toString().split(/[(,)]/);
            showMapVal(loca[1], $.trim(loca[2]));
            
            //showMapVal(place.geometry.location.jb, place.geometry.location.kb);
            if (!place.geometry) {
                input.className = 'notfound';
                
                return;
            }
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);//Set Center ของแผนที่ตามตำแหน่งที่ค้นหา
                map.setZoom(17);//กำหนดซูมแผนที่ขยายเป็น 17
            }
            marker.setPosition(place.geometry.location);//setตำแหน่งใหม่ที่ค้นหา
            marker.setVisible(true);//แสดงหมุดในตำแหน่งใหม่ที่ค้นหา
            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[3] && place.address_components[3].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join('');
            }
            infowindow.setContent('<div><strong>' + place.name + '</strong>' + address);
            
            infowindow.open(map, marker);
                $('.gmnoprint img').trigger('click');
                $('#location').addClass('form-control');
            // alert($('#gmimap0,#gmimap1').attr('name'));
        });
        
        google.maps.event.addListener(marker, 'dragend', function(ev) {//ทำงานเมื่อคลิกเคลื่อนย้ายหมุด (Marker)
            var location = ev.latLng;
            var lat = location.lat();
            var lng = location.lng();
            showMapVal(lat,lng);
            var latlng = new google.maps.LatLng(lat, lng)
            geocoder.geocode({'latLng': latlng}, function(results, status) {


                if (status == "OK") {
                    var address = '';
                    if (results[0].address_components) {
                        var address = [
                            (results[0].address_components[0] && results[0].address_components[0].short_name || ''),
                            (results[0].address_components[1] && results[0].address_components[1].short_name || ''),
                            (results[0].address_components[2] && results[0].address_components[2].short_name || ''),
                            (results[0].address_components[3] && results[0].address_components[3].short_name || ''),
                            (results[0].address_components[5] && results[0].address_components[5].short_name || ''),
                            (results[0].address_components[4] && results[0].address_components[4].short_name || '')
                        ].join(' ');
                        $('input[name="location"]').val(address);
                        infowindow.setContent(address);
                        infowindow.open(map, marker);
                        // $('#location').val(location);
                    }
                }
            });
        });
        google.maps.event.addListener(map, 'zoom_changed', function(ev) {//ซูมแผนที่
            zoomLevel = map.getZoom();//เรียกเมธอด getZoom จะได้ค่าZoomที่เป็นตัวเลข
            $('#mapsZoom').val(zoomLevel);//เอาค่า Zoom Level ไปแสดงที่ textfield ที่มี id="mapsZoom"
        });
    }


        
    function showMapVal(lat, lng) {//ฟังก์ชั่นแสดงละติจูดกับลองติจูดใน textfield
        $("#mapsLat").val(lat);//textfield ที่ค่า id="mapsLat"
        $("#mapsLng").val(lng);//textfield ที่ค่า id="mapsLng"
        
    }
    google.maps.event.addDomListener(window, 'load', initialize);//ทำงานตอนหน้านี้โหลดเสร็จแล้วให้ไปเรียกฟังก์ชั่น initialize

    $(document).ready(function() {
    	$.ajax({
    		url: '{{ url('customer/datagroupcustomer') }}',
    		success:function(result){
    			var txt = '<option value="">ไม่ระบุ</option>';
    			if(result.length > 0){
    				for(var x=0;x<result.length;x++){
    					txt += '<option value="'+result[x].groupcustomer_id+'">'+result[x].groupcustomer_text+'</option>';
    				}

    			}
    			$("#groupcustomer").empty().append(txt);
    		}
    	});
    	var shopdata = "<?php echo $txt;?>";
    	var shopdata = shopdata.split(','); //ยังไม่ได้ทำให้รูปแสดง
    	$("#imageshop").fileinput({
    		// initialPreview:shopdata,
    		// initialPreviewAsData: true,
	        uploadUrl: '/file-upload-batch/2',
	        maxFilePreviewSize: 10240,
	        maxFileCount: 8,
	    });
    	
    });
</script>
@stop