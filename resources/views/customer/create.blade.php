@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- <div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Customer / Create
				</h4>
			</div>
		</div>
	</div>-->
	<!-- /page header -->
	<style type="text/css">
		.classcustomer{
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
							
							<form method="post" action="{{url('customer_create')}}" id="formcustomer" enctype="multipart/form-data" onsubmit="return uploadiamge();">
							{{ csrf_field() }}
							<input type="hidden" class="form-control" name="uploadimage" id="uploadimage">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6 col-md-6 col-md-offset-3">
										<fieldset>
											<legend class="text-semibold">ข้อมูลลูกค้า</legend>
											<div class="form-group">
												<label>ชื่อลูกค้า * :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="name" id="name" required>
												</div>
											</div>
											<div class="form-group">
												<label>รูปร้าน :</label>
												<div class="file-loading"> 
													<input type="file" id="imageshop" name="imageshop[]" multiple >
												</div>
												<span class="help-block">ขนาดรูป : 305 x 425px</span>
											</div>
											<div class="form-group">
                                                <label>ที่อยู่ :</label>
                                                <div class="input-control">
                                                    <input class="col-sm-12 form-control" id="location" name="location" type="text" required>
                                                    <input type="hidden" id="mapsLat" name="lat" value="">
                                                    <input type="hidden" id="mapsLng" name="lng" value="">
                                                    <div id="map" style="width:100%;height:200px;border:1px solid f1f1f1"></div>
                                                </div>
                                            </div>
											<div class="form-group">
												<label>ละติจูดและลองจิจูด * :</label>
												<div class="col-md-12" style="padding-left: 0px;padding-right: 0px;">
												<div class="input-control col-md-8" style="padding-left: 0px;">
													<input type="text" class="form-control" name="latandlong" id="latandlong" onkeypress="return false" required>
												</div>
												<div class="col-md-4">
													<button type = "button" id="btnsearchlocation" class="btn btn-default">ค้นหา</button>
													<button type = "button" id="btngetlocation" class="btn btn-default">Get Location</button>
												</div>
												</div>
											</div>
											<br>
											<br>
											<div class="form-group">
												<label>เลขประจำตัวผู้เสียภาษีอากร :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="idtax" id="idtax">
												</div>
											</div>
											<div class="form-group">
												<label>รูปผู้ใช้งาน * :</label>
												<input type="file" class="file-input" name="imageuser" required>
												<span class="help-block">ขนาดรูป : 305 x 425px</span>
											</div>
											<div class="form-group">
												<label>เบอร์ติดต่อ * :</label>
												<div class="input-control">
													<input type="text" class="form-control number" name="tel" id="tel" maxlength="10" required>
												</div>
											</div>
											<div class="form-group">
												<label>เบอร์บ้าน * :</label>
												<div class="input-control">
													<input type="text" class="form-control number" name="telhome" id="telhome" >
												</div>
											</div>
											<div class="form-group">
												<label>อีเมล์ * :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="email" id="email" required>
												</div>
											</div>
											<div class="form-group">
												<label>เครดิต :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="credit" id="credit">
												</div>
											</div>
											<div class="form-group">
												<label>เครดิตเงินที่ค้างได้ :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="creditmoney" id="creditmoney">
												</div>
											</div>
											<div class="form-group">
												<label>รูปลายเซนต์เช็ค * :</label>
												<input type="file" class="file-input" name="imagesignature" required>
												<span class="help-block">ขนาดรูป : 305 x 425px</span>
											</div>
											<br>
											<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<label>บ้านเลขที่ - ซอย * :</label>
														<div class="input-control">
															<input type="text" class="form-control" name="address1" id="address1" required>
														</div>
													</div>
												</div>
												
												<div class="col-md-4 col-md-offset-1">
													<div class="form-group">
														<label>ถนน * :</label>
														<div class="input-control">
															<input type="text" class="form-control" name="address2" id="address2" required>
														</div>
													</div>
												</div>

												<div class="col-md-3 col-md-offset-1">
													<div class="form-group" id="divdistricts">
														<label>แขวง / ตำบล * :</label>
														<div class="input-control">
															<input type="hidden" class="form-control" name="address3" id="address3" required>
															<select class="form-control" name="districts" onchange="getzidcode(this.value);" id="districts" required>
																<option value="">แขวง / ตำบล</option>
															</select>
														</div>
													</div>
												</div>

												<div class="col-md-3 ">
													<div class="form-group" id="divamphures">
														<label>เขต / อำเภอ * :</label>
														<div class="input-control">
															<input type="hidden" class="form-control" name="address4" id="address4" required>
															<select class="form-control" name="amphures" id="amphures" onchange="getdistricts(this.value);" required>
																<option value="">เขต / อำเภอ</option>
															</select>
														</div>
													</div>
												</div>
												
												<div class="col-md-4 col-md-offset-1">
													<div class="form-group" id="divprovinces">
														<label>จังหวัด * :</label>
														<div class="input-control">
															<input type="hidden" class="form-control" name="address5" id="address5" required>
															<select class="form-control" name="provinces" id="provinces" onchange="getamphures(this.value);" required>
																<option value="" hidden="">จังหวัด</option>
																@if(!empty($provinces))
																@foreach($provinces as $data)
																<option value="{{ $data->id }}">{{ $data->name_th }}</option>
																@endforeach
																@endif
															</select>
														</div>
													</div>
												</div>
												
												<div class="col-md-3 col-md-offset-1">
													<div class="form-group">
														<label>รหัสไปรษณย์ * :</label>
														<div class="input-control">
															<input type="text" class="form-control" name="address6" id="address6" required>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>กลุ่มลูกค้า :</label>
												<div class="input-control">
													<select class="form-control" name="groupcustomer" id="groupcustomer">
														<option value="">ไม่ระบุ</option>
														@if(!empty($area))
														@foreach($area as $item)
														<option value="{{ $item->area_id }}">{{ $item->area_name }}</option>
														@endforeach
														@endif
														
													</select>
												</div>
											</div>
											<div class="form-group">
												<label>ภาษี :</label>
												<div class="input-control">
													<div class="radio">
														<label>
															<input type="radio" class="styled" name="vat" id="vat1" value="0" checked="checked">No Vat
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" class="styled" name="vat" id="vat2" value="1">Exclude Vat
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" class="styled" name="vat" id="vat2" value="2">Include Vat
														</label>
													</div>
												</div>
											</div>
											</br>
											<div class="form-group">
												<label>วิธีการส่งสินค้า :</label>
												<div class="input-control">
													<select class="form-control" name="typedelivery" id="typedelivery">
														<option value="">ไม่ระบุ</option>
														@if(!empty($deliverytype))
														@foreach($deliverytype as $data)
														<option value="{{ $data->deliverytype_id }}">{{ $data->deliverytype_name }}</option>
														@endforeach
														@endif
													</select>
												</div>
											</div>
											</br>
											<div class="form-group">
												<label>เกรดราคาขายส่ง :</label>
												<div class="input-control">
													<div class="radio">
														<label>
															<input type="radio" class="styled" name="rate" id="rate1" value="1" checked="checked">เกรด 1
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" class="styled" name="rate" id="rate2" value="2">เกรด 2
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" class="styled" name="rate" id="rate3" value="3">เกรด 3
														</label>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>ค่าจัดส่ง :</label>
												<div class="input-control">
													<div class="radio">
														<label>
															<input type="radio" class="styled" name="rateshiping" id="rateshiping1" value="1" checked="checked">จ่ายเต็ม
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" class="styled" name="rateshiping" id="rateshiping2" value="0.5">จ่ายครึ่ง
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" class="styled" name="rateshiping" id="rateshiping3" value="0">ฟรี
														</label>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label>การขนส่ง :</label>
												<div class="input-control">
													<div class="col-md-10" style="padding-left: 0px;">
														<input type="text" name="destination[]" value="" class="form-control">
													</div>
													<div class="col-md-2">
														<button type="button" class="btn btn-primary" onclick="addtextbox()"><i class="fa fa-plus-square"></i>  เพิ่ม</button>
													</div>
													<div class="formaddto"></div>
												</div>

											</div>
											<br>
                                            <!--<div class="form-group">
												<label>ที่อยู่ :</label>
												<div class="input-control">
                                                    <textarea name="address" class="form-control" required style="resize: vertical;" rows="3"></textarea>
												</div>
											</div>-->
											<div class="form-group">
												<label>หมายเหตุ :</label>
												<div class="input-control">
                                                    <textarea name="note" class="form-control" style="resize: vertical;" rows="3"></textarea>
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
        geocoder = new google.maps.Geocoder();
        
        
        
        var Position = new google.maps.LatLng(13.658949, 100.41608100000001);
        var mapOptions = {
            center: Position, //ตำแหน่งแสดงแผนที่เริ่มต้น
            zoom: 13, //ซูมเริ่มต้น คือ 8
            zoomControl: true,
            mapTypeControl: true,
            scaleControl: true,
            streetViewControl: true,
            rotateControl: true,
            fullscreenControl: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP //ชนิดของแผนที่
        };
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
        var input = document.getElementById('location');
        infowindow = new google.maps.InfoWindow();
        marker = new google.maps.Marker({
            position: Position,
            draggable: true,
        });
        
        marker.setMap(map);//แสดงตัวปักหมุด!!
        //ระบุตำแหน่ง
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            Position = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            infowindow.setPosition(pos);
            // console.log(pos)
            infowindow.setContent('ตำแหน่งปัจจุบัน');
            infowindow.open(map);
            map.setCenter(pos);
            infowindow.open(map, marker);
            infowindow.open(map, marker);
            marker.setPosition(Position);//setตำแหน่งใหม่ที่ค้นหา
        	// marker.setVisible(true);//แสดงหมุดในตำแหน่งใหม่ที่ค้นหา
        	// marker.setMap(map);//แสดงตัวปักหมุด!!
            showMapVal(position.coords.latitude,position.coords.longitude);
            $("#latandlong").val(position.coords.latitude+', '+position.coords.longitude);

          }, function() {
            handleLocationError(true, infowindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infowindow, map.getCenter());
        }
        //ระบุตำแหน่ง

        showMapVal(Position.jb, Position.kb);
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {//ทำงานเมื่อคลิกที่รายการค้นหา

            infowindow.close();
            marker.setVisible(false);
            input.className = '';
            place = autocomplete.getPlace();
            if (!place.geometry) {
                input.className = 'col-sm-12 form-control';
                alert('ไม่มีข้อมูล')
                return false;
            }
            var loca = place.geometry.location.toString().split(/[(,)]/);
            showMapVal(loca[1], $.trim(loca[2]));
            $("#latandlong").val(loca[1]+', '+$.trim(loca[2]));
            //showMapVal(place.geometry.location.jb, place.geometry.location.kb);
            
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
            var latlng = new google.maps.LatLng(lat, lng);
            $("#latandlong").val(lat+', '+lng);
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

        var latandlong = document.getElementById('latandlong');
        google.maps.event.addDomListener(latandlong, 'keyup', function (e) {
        	e.preventDefault();
        	var latandlong = $(this).val();
        	console.log(e.which);
        	// marker.setMap(null);
        	// marker.setMap(map);
        	if (e.key === "Enter") {
        		// marker.setMap(null);
        		latandlong = latandlong.split(',');
        		var lat = latandlong[0];
        		var lng = latandlong[1];
        		$("#mapsLat").val(lat);//textfield ที่ค่า id="mapsLat"
        		$("#mapsLng").val(lng);
	        	Position = new google.maps.LatLng({lat:+lat, lng:+lng});
	        	geocoder.geocode({'latLng': Position}, function(results, status) {
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
		        map.setCenter(Position);//Set Center ของแผนที่ตามตำแหน่งที่ค้นหา
                map.setZoom(13);//กำหนดซูมแผนที่ขยายเป็น 1

		        marker.setPosition(Position);//setตำแหน่งใหม่ที่ค้นหา
            	marker.setVisible(true);//แสดงหมุดในตำแหน่งใหม่ที่ค้นหา
            	marker.setMap(map);//แสดงตัวปักหมุด!!
        	}
		});
		var btnsearchlocation = document.getElementById('btnsearchlocation');
		google.maps.event.addDomListener(btnsearchlocation, 'click', function (e) {
        	// e.preventDefault();
        	var latandlong = $("#latandlong").val();
        	if (latandlong != "") {
        		// marker.setMap(null);
        		latandlong = latandlong.split(',');
        		var lat = latandlong[0];
        		var lng = latandlong[1];
        		$("#mapsLat").val(lat);//textfield ที่ค่า id="mapsLat"
        		$("#mapsLng").val(lng);
	        	Position = new google.maps.LatLng({lat:+lat, lng:+lng});
	        	geocoder.geocode({'latLng': Position}, function(results, status) {
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
		        map.setCenter(Position);//Set Center ของแผนที่ตามตำแหน่งที่ค้นหา
                map.setZoom(13);//กำหนดซูมแผนที่ขยายเป็น 1

		        marker.setPosition(Position);//setตำแหน่งใหม่ที่ค้นหา
            	marker.setVisible(true);//แสดงหมุดในตำแหน่งใหม่ที่ค้นหา
            	marker.setMap(map);//แสดงตัวปักหมุด!!
        	}
		});
		var btngetlocation = document.getElementById('btngetlocation');
		google.maps.event.addDomListener(btngetlocation, 'click', function (e) {
        	// e.preventDefault();
        	if (navigator.geolocation) {
        		navigator.geolocation.getCurrentPosition(function(position) {
        			var pos = {
        				lat: position.coords.latitude,
        				lng: position.coords.longitude
        			};
        			var lat= position.coords.latitude;
        			var lng= position.coords.longitude;
		            // Position = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		            // infowindow.setPosition(pos);
		            // console.log(pos)
		            // infowindow.setContent('ตำแหน่งปัจจุบัน');
		            // infowindow.open(map);
		            // map.setCenter(pos);
		            // infowindow.open(map, marker);
		            // infowindow.open(map, marker);
		            // marker.setPosition(Position);//setตำแหน่งใหม่ที่ค้นหา
		        	// marker.setVisible(true);//แสดงหมุดในตำแหน่งใหม่ที่ค้นหา
		        	// marker.setMap(map);//แสดงตัวปักหมุด!!
		            // showMapVal(position.coords.latitude,position.coords.longitude);
		            $("#latandlong").val(position.coords.latitude+', '+position.coords.longitude);


		    		$("#mapsLat").val(lat);//textfield ที่ค่า id="mapsLat"
		    		$("#mapsLng").val(lng);
		        	Position = new google.maps.LatLng({lat:+lat, lng:+lng});
		        	geocoder.geocode({'latLng': Position}, function(results, status) {
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
			        map.setCenter(Position);//Set Center ของแผนที่ตามตำแหน่งที่ค้นหา
		            map.setZoom(13);//กำหนดซูมแผนที่ขยายเป็น 1

			        marker.setPosition(Position);//setตำแหน่งใหม่ที่ค้นหา
		        	marker.setVisible(true);//แสดงหมุดในตำแหน่งใหม่ที่ค้นหา
		        	marker.setMap(map);//แสดงตัวปักหมุด!!
		        }, function() {
		            handleLocationError(true, infowindow, map.getCenter());
		        });
        	} else {
        		// Browser doesn't support Geolocation
        		handleLocationError(false, infowindow, map.getCenter());
        	}
        	//ระบุตำแหน่ง
		});

        google.maps.event.addListener(map, 'zoom_changed', function(ev) {//ซูมแผนที่
            zoomLevel = map.getZoom();//เรียกเมธอด getZoom จะได้ค่าZoomที่เป็นตัวเลข
            $('#mapsZoom').val(zoomLevel);//เอาค่า Zoom Level ไปแสดงที่ textfield ที่มี id="mapsZoom"
        });
    }
    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    	console.log(pos)
    	console.log(browserHasGeolocation)
    	console.log(infoWindow)
	    infoWindow.setPosition(pos);
	    infoWindow.setContent(browserHasGeolocation ?
	        'Error: The Geolocation service failed.' :
	        'Error: Your browser doesn\'t support geolocation.');
	}
    function showMapVal(lat, lng) {//ฟังก์ชั่นแสดงละติจูดกับลองติจูดใน textfield
        $("#mapsLat").val(lat);//textfield ที่ค่า id="mapsLat"
        $("#mapsLng").val(lng);//textfield ที่ค่า id="mapsLng"
        
    }
    google.maps.event.addDomListener(window, 'load', initialize);//ทำงานตอนหน้านี้โหลดเสร็จแล้วให้ไปเรียกฟังก์ชั่น initialize

    var checkimage = false;
    var imageadd = [];
    $(document).ready(function() {
    	// $.ajax({
    	// 	url: '{{ url('customer/datagroupcustomer') }}',
    	// 	success:function(result){
    	// 		var txt = '<option value="">ไม่ระบุ</option>';
    	// 		if(result.length > 0){
    	// 			for(var x=0;x<result.length;x++){
    	// 				txt += '<option value="'+result[x].groupcustomer_id+'">'+result[x].groupcustomer_text+'</option>';
    	// 			}

    	// 		}
    	// 		$("#groupcustomer").empty().append(txt);
    	// 	}
    	// });

    	$('#districts').select2({dropdownParent:$('#divdistricts')});
    	$('#amphures').select2({dropdownParent:$('#divamphures')});
    	$('#provinces').select2({dropdownParent:$('#divprovinces')});
    	
    	
    	$("#imageshop").fileinput({
	        maxFilePreviewSize: 10240,
	        // showUpload: false,
	        maxFileCount: 8,
	        showUpload: false,
			fileActionSettings: {
				showRemove: false,
				showZoom: true,
				showUpload: false,
				showCaption: false,
				showSize: false,
			},
			append: true,
    		// initialPreview:shopdata,
    		initialPreviewAsData: true,
    		// initialPreviewConfig:configimages,
	        uploadUrl: '../customer/file-upload/add',
	        uploadAsync: true,
		    uploadExtraData: function() {

                return {
                    _token: $("input[name='_token']").val(),

                };

            },
	        maxFilePreviewSize: 10240,
	        maxFileCount: 8,
	        maxFileSize: 1024,
	        slugCallback: function (data) {
                return data;

            }
	    }).on('fileuploaded', function(event, data, previewId, index) {
	    	// console.log(event)
	    	// console.log(data)
	    	// console.log(previewId)
	    	// console.log(index)
		    var response = data.response;
		    imageadd.push(response);
	        
	        var count = $("#imageshop").fileinput("getFilesCount");
	        if(count == 1){
	        	console.log($("#imageshop").val())
	        	// alert();
	        	// console.log(imageadd)
	        	// $("#uploadimage").val(imageadd);
	        	// checkimage = true;
	        	// uploadiamge();
	        }
		    
		}).on('fileclear', function(event) {
			imageadd = [];
		    console.log("fileclear");
		}).on('filebatchuploadcomplete', function(event, preview, config, tags, extraData) {
	        // console.log('File Batch Uploaded', preview, config, tags, extraData);
	        
        	$("#uploadimage").val(imageadd);
        	checkimage = true;
        	$("#formcustomer").submit();
        	// uploadiamge();
	    });
    });

    function addtextbox(){
    	var txt = '<label>&nbsp;</label><div class="input-control"><input type="text" name="destination[]" value="" class="form-control"></div>';
    	$(".formaddto").append(txt);
    }
    function getamphures(id){
    	var name = $("#provinces option:selected").text();
    	$("#address5").val(name);
    	
    	$.post('{{ url('customer/amphures') }}', {'_token': "{{ csrf_token() }}",'id':id}, function(data, textStatus, xhr) {
    		
    		var txtop = '<option value="">เขต / อำเภอ</option>';
    		$.each(data,function(key,item){
    			txtop += '<option value="'+item.id+'">'+item.name_th+'</option>';
    		});
    		$("#amphures").empty().append(txtop);
    		// $('#amphures').select2();
    	});
    	
    }
    function getdistricts(id){
    	var name = $("#amphures option:selected").text();
    	$("#address4").val(name);
    	
    	$.post('{{ url('customer/districts') }}', {'_token': "{{ csrf_token() }}",'id':id}, function(data, textStatus, xhr) {
    		var txtop = '<option value="">แขวง / ตำบล</option>';
    		$.each(data,function(key,item){
    			txtop += '<option value="'+item.id+'">'+item.name_th+'</option>';
    		});
    		$("#districts").empty().append(txtop);
    	});
    }
    function getzidcode(id){
    	var name = $("#districts option:selected").text();
    	$("#address3").val(name);
    	
    	$.post('{{ url('customer/zidcode') }}', {'_token': "{{ csrf_token() }}",'id':id}, function(data, textStatus, xhr) {
    		
    		$("#address6").val(data);
    	});
    }
    function uploadiamge(){
    	
    	console.log($(".file-preview-frame").length)
    	if($(".file-preview-frame").length == 0){
    		return true;
    	}else{
    		console.log(checkimage)
    		if(!checkimage){
    			$("#imageshop").fileinput('upload');
    			console.log($(".file-preview-frame").length)
    			return false;
    		}else{
    			// alert('msg');
    			console.log(imageadd)
    			return checkimage;
    		}
    		
    		// return false;
    	}
    	
    }
</script>
@stop