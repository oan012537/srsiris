@extends('../template')

@section('content')
	<!-- Page header -->
	<!--<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Supplier / Create
				</h4>
			</div>
		</div>
	</div>-->
	<!-- /page header -->
    <style type="text/css">
        .classsupplier{
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
							
							<form method="post" action="{{url('supplier_update')}}" enctype="multipart/form-data">
							{{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$data->supplier_id}}">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6 col-md-6 col-md-offset-3">
										<fieldset>
											<legend class="text-semibold">ข้อมูลผู้ผลิต</legend>
                                            <div class="form-group">
                                                <label>ชื่อผู้ผลิต :</label>
                                                <div class="input-control">
                                                    <input type="text" class="form-control" name="name" id="name" required value="{{$data->supplier_name}}">
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label>ที่อยู่ :</label>
                                                <div class="input-control">
                                                    <input class="col-sm-12 form-control" id="location" name="location" type="text" required value="{{$data->location}}">
                                                    <input type="hidden" id="mapsLat" name="lat" value="{{$data->lat}}">
                                                    <input type="hidden" id="mapsLng" name="lng" value="{{$data->lng}}">
                                                    <div id="map" style="width:100%;height:200px;border:1px solid f1f1f1"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>ละติจูดและลองจิจูด :</label>
                                                <div class="input-control">
                                                    <input type="text" class="form-control" name="latandlong" id="latandlong" onkeypress="return false" value="{{$data->lat}},{{$data->lng}}">
                                                </div>
                                            </div>
											<div class="form-group">
												<label>เบอร์ติดต่อ :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="tel" id="tel" maxlength="10" required value="{{$data->supplier_tel}}">
												</div>
											</div>
											<div class="form-group">
												<label>อีเมล์ :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="email" id="email" required value="{{$data->supplier_email}}">
												</div>
											</div>
                                            <div class="form-group">
												<label>เลขประจำตัวผู้เสียภาษี :</label>
												<div class="input-control">
													<input type="text" class="form-control" name="tax" id="tax" required value="{{$data->supplier_tax}}">
												</div>
											</div>
                                            <!--<div class="form-group">
												<label>ที่อยู่ :</label>
												<div class="input-control">
                                                    <textarea name="address" class="form-control" required style="resize: vertical;" rows="3">{{$data->supplier_address}}</textarea>
												</div>
											</div>-->
											<br>
											<div class="text-right">
												<a href="{{url('supplier')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
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
</script>
@stop