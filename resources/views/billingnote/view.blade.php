@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- <div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Selling - Export / Create
				</h4>
			</div>
		</div>
	</div>-->
	<!-- /page header -->
	<style type="text/css">
		.classbillingnote{
			background: rgb(199,199,199,0.3);
		}
		.formcheck{
			display: none;
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
						
						<!-- Vertical form options -->
						<div class="row">
							<div class="col-md-12">
								<!-- Basic layout-->
									<div class="panel panel-flat">
										<div class="panel-heading">
											<h5 class="panel-title">รายละเอียดใบเก็บเงิน</h5>
											<div class="heading-elements">
												<ul class="icons-list">
													<li><a data-action="collapse"></a></li>
													<li><a data-action="reload"></a></li>
													<li><a data-action="close"></a></li>
												</ul>
											</div>
										</div>
										<div class="panel-body">
											<div class="row">
												<div class="col-md-12">
													<form id="myForm">
														<input type="hidden" name="billingnoteid" value="{{ $data[0]->billingnote_id }}">
														{{ csrf_field() }}
														<table id="myTable" class="table table-bordered">
															<thead>
																<tr>
																	<th class="text-center">ลำดับ</th>
																	<th class="text-center">เลขที่ออเดอร์</th>
																	<th class="text-center">วันที่</th>
																	<th class="text-center">ชื่อลูกค้า</th>
																	<th class="text-center">สถานะ</th>
																	<th class="text-center">รวม</th>
																	<th class="text-center" onclick="checkall()">เลือก</th>
																	<th class="text-center">#</th>
																</tr>
															</thead>
															@if(!empty($data))
															<tbody id="rowdata">
																@foreach($data as $key => $value)
																@php
																if($value -> selling_status == '7'){
																	$status = 'ยังไม่ได้ชำระเงินตามใบเก็บเงิน';
																}else if($value -> selling_status == '8'){
																	$status = 'ชำระเงินตามใบเก็บเงินเรียบร้อย';
																}else{
																	$status = 'ยกเลิกการชำระเงิน';
																}
																if($value->billingnotedata_status == 0){
																	$disabled = 'disabled';
																	$cancel = 'disabled';
																}else if($value -> selling_status == '8'){
																	$disabled = 'disabled';
																	$cancel = '';
																}else{
																	$disabled = '';
																	$cancel = '';
																}
																@endphp
																<tr class="rowbody">
																	<td align="center">{{ $key+1 }}</td>
																	<td align="center">{{ $value -> selling_inv }}</td>
																	<td align="center">{{ $value -> selling_date }}</td>
																	<td align="center">{{ $value -> selling_customername }}</td>
																	<td align="center">{{ $status }}</td>
																	<td align="center">{{ number_format($value -> selling_totalpayment,2) }}</td>
																	<td align="center"><input type="checkbox" name="check[]" id="check{{$value->selling_id}}" value="{{$value->selling_id}}" {{ $disabled }}></td>
																	<td align="center">
																		<button {{ $cancel }} type="button" class="btn btn-warning" onclick="canceldata('{{$value->selling_id}}')">ยกเลิก</button>
																		{{-- <button {{ $disabled }} type="button" class="btn btn-primary" onclick="uploadfile('{{$value->selling_id}}')">อัพไฟล์</button> --}}
																		<button {{ $cancel }} type="button" class="btn btn-primary" onclick="uploadfileonly('{{$value->selling_id}}')">อัพไฟล์</button>
																	</td>
																</tr>
																@endforeach
															</tbody>
															<tfoot id="rowfoot">
																<tr class="rowfoot">
																	<td colspan="3"></td>
																	<td>รวมทั้งหมด</td>
																	<td align="right">{{ number_format($data[0] -> billingnote_total,2)}}</td>
																	<td align="center" rowspan="3" colspan="3">
																		<button type="button" class="btn btn-primary" onclick="paymoney();">ชำระเงิน</button>
																		{{-- <button type="button" class="btn btn-success" onclick="printpaper('{{ $data[0]->billingnote_id }}');">พิมพ์</button> --}}
																	</td>
																</tr>
																<tr class="rowfoot">
																	<td colspan="3"></td>
																	<td>ชำระแล้ว</td>
																	<td align="right">{{ number_format($data[0] -> billingnote_pay,2)}}</td>
																</tr>
																<tr class="rowfoot">
																	<td colspan="3"></td>
																	<td>คงเหลือ</td>
																	<td align="right">{{ number_format($data[0] -> billingnote_balance,2)}}</td>
																</tr>
															</tfoot>
															@else

															<tbody id="rowdata">
																<tr id="firstauto">
																	<td colspan="10" align="center">-- No data --</td>
																</tr>
															</tbody>
															<tfoot id="rowfoot"></tfoot>
															@endif
														</table>
													</form>
												</div>
											</div>
										</div>
									</div>
								<!-- /basic layout -->
								@if(!empty($data))
								<div class="panel panel-flat" style="display: none;">
									<form method="post" action="{{url('/billingnote/update')}}" enctype="multipart/form-data" onsubmit="return checkdata();">
										{{ csrf_field() }}
										<input type="hidden" name="billingnoteid" value="{{ $data[0]->billingnote_id }}">
										<div class="panel-body">
											<div class="row">
												<div class="col-md-12">
													<div class="row">
														<div class="col-md-6 col-md-6 col-md-offset-3">
															<fieldset>
																<legend class="text-semibold"></legend>
																<div class="form-group">
																	<label>จำนวนเงินที่ชำระ :</label>
																	<div class="input-control">
																		<input type="text" class="form-control" name="pay" id="pay">
																	</div>
																</div>
																<br>
																<div class="form-group">
																	<label>จ่ายอื่นๆ :</label>
																	<div class="input-control">
																		<input type="text" class="form-control" name="payother" id="payother">
																	</div>
																</div>
																<br>
																<div class="form-group">
																	<label>แนบไฟล์ :</label>
																	<input type="file" id="input-44" name="uploadcover[]" multiple >
																	{{-- class="file-input" --}}
																</div>
																<br>
																<div class="text-right">
																	<a href="{{url('/billingnote')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
																	<button type="submit" class="btn btn-primary"><i class="icon-floppy-disk"></i>  บันทึก</button>
																</div>
															</fieldset>
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
								@endif
							</div>
						</div>
						<!-- /vertical form options -->
					</div>
				</div>
			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
	
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document" id="myModalform">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">ชำระเงิน</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="post" action="{{url('/billingnote/update')}}" id="formuploadfile" enctype="multipart/form-data" onsubmit="return checkimg()">
							<input type="hidden" class="form-control" name="uploadimagecheck" id="uploadimagecheck">
							<input type="hidden" class="form-control" name="uploadimage" id="uploadimage">
							{{ csrf_field() }}
							<input type="hidden" name="billingnoteid" value="{{ $data[0]->billingnote_id }}">
							<input type="hidden" name="check" id="check">
							<div class="form-group">
								<label>ยอดที่ต้องชำระ :</label>
								<input type="text" class="form-control" name="payamount" id="payamount" readonly>
							</div>
							<button type="button" onclick="test();">test</button>
							<div class="form-group">
								<label>วิธีการชำระเงิน :</label>
								<select class="form-control" name="typepay" id="typepay" onchange="changetype(this.value);">
									<option value="1">เงินสด</option>
									<option value="2">โอน</option>
									<option value="3">เช็ค</option>
								</select>
							</div>
							<div class="form-group formcheck">
								<label>ธนาคาร :</label>
								<input type="text" class="form-control" name="checkbank" id="checkbank">
							</div>
							<div class="form-group formcheck">
								<label>เลขที่เช็ค :</label>
								<input type="text" class="form-control" name="checkno" id="checkno">
							</div>
							<div class="form-group">
								<label>จำนวนเงินที่ชำระ :</label>
								<input type="number" class="form-control" name="pay" id="pay" required min="0" step="0.1">
							</div>
							<div class="form-group formcheck">
								<label>ไฟล์เช็ค :</label>
								<input type="file" id="imagecheck" class="imagecheck" name="imagecheck[]">
							</div>
							<div class="form-group">
								<label>จ่ายอื่นๆ :</label>
								<input type="number" class="form-control" name="payother" id="payother">
							</div>
							<div class="form-group">
								<label>แนบไฟล์ :</label>
								<input type="file" id="imagefile" class="imagefile" name="uploadcover[]" multiple>
							</div>
							<div class="form-group">
								<label>เงินหักอื่นๆ :</label>
								<input type="number" class="form-control" name="discount" id="discount">
							</div>
							<div class="form-group">
								<label>แนบไฟล์เงินหัก :</label>
								<input type="file" id="input-44" name="uploaddiscount[]" multiple>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">ปิด</button>
						<button type="submit" form="formuploadfile" class="btn btn-primary waves-effect waves-light ">บันทึก</button>
					</div>
				</div>
			</div>
			<div class="modal-dialog" role="document" id="myModalshowsignature" style="display: none;width: 70%">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">ตรวจเช็ค</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="post" action="{{url('/billingnote/uploadfileonly')}}" id="formuploadfilecheck" enctype="multipart/form-data" onsubmit="return checkfile();">
							{{ csrf_field() }}
							<div class="col-md-6">
								<h3>ตัวอย่างเช็ค</h3>
								<div class="form-group" id="showsignature">

								</div>
							</div>
							<div class="col-md-6">
								<h3>เช็คที่ได้จากลูกค้า</h3>
								<div class="form-group" id="showimageupload">

								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger waves-effect " onclick="cancelcheck();">ยกเลิก</button>
						<button type="button" class="btn btn-primary waves-effect waves-light " onclick="savecheck()">บันทึก</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="myModaluploadfile" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">เพิ่มไฟล์</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="post" action="{{url('/billingnote/uploadfileonly')}}" id="formuploadfileonly" enctype="multipart/form-data" onsubmit="return checkfile();">
							{{ csrf_field() }}
							<input type="hidden" name="billingnoteid" value="{{ $data[0]->billingnote_id }}">
							<input type="hidden" name="sellingid" id="sellingid">
							<div class="form-group">
								<label>แนบไฟล์ :</label>
								<input type="file" name="uploadfile[]" multiple id="uploadfile">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">ปิด</button>
						<button type="submit" form="formuploadfileonly" class="btn btn-primary waves-effect waves-light ">บันทึก</button>
					</div>
				</div>
			</div>
		</div>

<script>
	var checkimage = false;
	var checkimagecheck = false;
	
	var imageadd = [];
	$(document).on('ready', function() {
	    $("#input-44,#uploadcover,#uploadfile").fileinput({
	        uploadUrl: '../../billingnote/file-upload',
	        uploadAsync: true,
		    uploadExtraData: function() {

                return {
                    _token: $("input[name='_token']").val(),

                };

            },
	        maxFilePreviewSize: 10240,
	        showUpload: false,
	        uploadAsync: true,
	    });
	  //   $("#imagefile").fileinput({
			// showUpload: true,
			// fileActionSettings: {
			// 	showRemove: false,
			// 	showZoom: true,
			// 	showUpload: false,
			// 	showCaption: false,
			// 	showSize: false,
			// },
   //  		// initialPreview:shopdata,
   //  		initialPreviewAsData: true,
   //  		// initialPreviewConfig:configimages,
	  //       uploadUrl: '../../billingnote/file-upload/',
	  //       uploadAsync: true,
		 //    uploadExtraData: function() {

   //              return {
   //              	updateid: $("input[name='updateid']").val(),
   //                  _token: $("input[name='_token']").val(),

   //              };

   //          },
	  //       maxFilePreviewSize: 10240,
	  //       maxFileCount: 8,
	  //       maxFileSize: 1024,
	  //       slugCallback: function (data) {
	  //       	checkimage = true;
   //              return data;

   //          }
	  //   }).on('filebatchuploadcomplete', function(event, preview, config, tags, extraData) {
	  //       // console.log('File Batch Uploaded', preview, config, tags, extraData);
	  //       if(!checkimage){
	  //       	checkimage = true;
	  //       	alert();
	  //       	// $("#formuploadfile").submit();
	  //       }
	        
	  //   });

	  	$("#imagecheck").fileinput({
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
	        uploadUrl: '../../billingnote/file-uploadcheck',
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
		    var response = data.response.uploaded;
		    imageadd.push(response);
	        
	        var count = $("#imagecheck").fileinput("getFilesCount");
	        if(count == 1){
	        	console.log($("#imagecheck").val())
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
	        console.log('File Batch Uploaded', preview, config, tags, extraData);
	        console.log(event);
	        console.log(imageadd)
        	$("#uploadimagecheck").val(imageadd);
        	checkimagecheck = true;
        	// $("#formuploadfile").submit();
        	// uploadiamge();
	    });

	    $("#imagefile").fileinput({
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
	        uploadUrl: '../../billingnote/file-upload',
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
		    var response = data.response.uploaded;
		    imageadd.push(response);
	        
	        var count = $("#imagefile").fileinput("getFilesCount");
	        if(count == 1){
	        	console.log($("#imagefile").val())
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
	        console.log('File Batch Uploaded', preview, config, tags, extraData);
	        console.log(event);
	        console.log(imageadd)
        	$("#uploadimage").val(imageadd);
        	checkimage = true;
        	// $("#formuploadfile").submit();
        	// uploadiamge();
	    });
	});
	function checkdata() {
		var pay = $("#pay").val();
		var pic = $(".file-caption-name i").length;
		if(pic == 0 && pay == ''){
			Lobibox.notify('error',{
				msg: 'กรุณาใส่ข้อมูล!',
				buttonsAlign: 'center',
				closeOnEsc: true,  
			});
			return false;
		}else{
			return true;
		}
		
	}

	function canceldata(id){
		var billingnoteid = $("input[name='billingnoteid']").val();
		bootbox.confirm({
			title: "ยืนยัน?",
			message: "คุณต้องการลบรายการนี้ หรือไม่?",
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
					$.post('{{ url('billingnote/update/cancel') }}',{'id':id,'billingnoteid':billingnoteid,'_token': "{{ csrf_token() }}"}, function(data) {
						// Lobibox.notify('error',{
						// 	msg: 'ยกเลิกข้อมูลเรียบร้อย',
						// 	buttonsAlign: 'center',
						// 	closeOnEsc: true,
						// });
						window.location.reload();
					});
				}
			}
		});
	}

	function uploadfile(id){
		var billid = $("#myForm input[name='billingnoteid']").val();
		$.post("{{url('billingnote/getdatapay')}}", {'id':id,'billid':billid,'_token': "{{ csrf_token() }}"}, function(data, textStatus, xhr) {
				$("#payamount").val(data.summoney);
				$("#formuploadfile #check").val(data.txt);
				$("#myModal").modal('show');
			});
		$("#myModal").modal('show');
	}

	function paymoney(){
		var checkclick = $("input[name='check[]']").is(":checked");
		if(checkclick){
			var myForm = $("#myForm").serialize();
			
			$.post("{{url('billingnote/getdatapays')}}", myForm, function(data, textStatus, xhr) {
				$("#payamount").val(data.summoney);
				$("#formuploadfile #check").val(data.txt);
				$("#myModal").modal('show');
			});
		}else{
			Lobibox.notify('error',{
				msg: 'ไม่ได้เลือกข้อมูล',
				buttonsAlign: 'center',
				closeOnEsc: true,
			});
			return false;
		}
	}

	function uploadfileonly(id){
		$("#formuploadfileonly #sellingid").val(id);
		$("#myModaluploadfile").modal('show');
	}

	function checkfile(){
		// alert();
		var files = $("#uploadfile").val();
		if(files == ""){
			Lobibox.notify('error',{
				msg: 'กรุณาเลือกไฟล์ข้อมูลก่อนกดปุ่มบันทึก',
				buttonsAlign: 'center',
				closeOnEsc: true,
			});
			return false;
		}else{
			return true;
		}
		
	}

	function printpaper(id){
		window.open("{{url('billingnote/print')}}/"+id);
	}
	function changetype(data){
		if(data == 3){
			$(".formcheck").fadeIn(800);
			$("#checkbank").prop('required',true);
			$("#checkno").prop('required',true);
			// $("input[name='imagecheck']").prop('required',true);
			$('input[name="uploadcover[]"]').prop('required',false);
		}else{
			$(".formcheck").fadeOut(800);
			$("#checkbank").prop('required',false);
			$("#checkno").prop('required',false);
			// $("input[name='imagecheck']").prop('required',false);
			$('input[name="uploadcover[]"]').prop('required',true);
		}
		if(data == 2){
			$('input[name="uploadcover[]"]').prop('required',true);
		}
	}
	
	function checkimg(){
		if($("#formuploadfile #payamount").val().indexOf(',') > 0){
			var payamount = $("#formuploadfile #payamount").val().replace(',');
		}else{
			var payamount = $("#formuploadfile #payamount").val();
		}
		var pay = $("#formuploadfile #pay").val();
		uploadiamge();
		if(parseFloat(pay) > parseFloat(payamount)){
			console.log(pay)
			Lobibox.notify('error',{
				msg: 'กรุณาตรวจสอบยอดเงินที่ชำระ เนื่องจากมีจำนวนมากกว่ายอดที่ต้องชำระ',
				buttonsAlign: 'center',
				closeOnEsc: true,
			});
			$("#formuploadfile #pay").focus();
			return false;
		}
		// return false; 
		var typepay = $("#formuploadfile #typepay").val();
		var billingnoteid = $("#formuploadfile input[name='billingnoteid']").val();
		console.log(billingnoteid)
		if(typepay == '3'){
			var imgup = $("showimageupload img").attr('src');
			if($(".file-preview-frame").length > 0){
				$('#showimageupload').empty().append("<img src='"+$(".file-preview-frame").find('img').attr('src')+"' style='width: 100%;'>");
			}
			$.post("{{url('billingnote/getdataimgcheck')}}", {billingnoteid:billingnoteid,'_token': "{{ csrf_token() }}"}, function(data, textStatus, xhr) {
				$("#showsignature").empty().append("<img src='"+"{{asset('assets/images/customer')}}/"+data.customer_imagesignature+"' style='width: 100%;'>");
				$("#myModalform").fadeOut()
				$("#myModalshowsignature").fadeIn();
				$("#formuploadfile").removeAttr('onsubmit');

			});
			return false;
		}else{
			uploadiamge();
			// return true;
		}
	}

	function cancelcheck(){
		$("#myModalform").fadeIn();
		$("#myModalshowsignature").fadeOut();
		$("#formuploadfilecheck").attr('onsubmit','return checkimg()');
	}
	function savecheck(){
		// $("#formuploadfile").removeAttr('onsubmit')
		// $("#formuploadfilecheck").submit();
		$("#formuploadfile").submit();
	}
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#showimageupload').empty().append("<img src='"+e.target.result+"' style='width: 100%;'>");
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	$(".imagecheck").change(function() {
		readURL(this);
	});
	var checkclickall = false;
	function checkall(){
		if(!checkclickall){
			checkclickall = true;
			$('input[name="check[]"]:not(:disabled)').prop('checked',true);
		}else{
			checkclickall = false;
			$('input[name="check[]"]:not(:disabled)').prop('checked',false);
		}
		
	}
	function uploadiamge(){
    	
    	console.log($(".file-preview-frame").length)

    	if($(".file-preview-frame").length == 0){
    		return true;
    	}else{
    		console.log(checkimage)
    		if(!checkimagecheck){
    			$("#imagecheck").fileinput('upload');
    			return false;
    		}

    		if(!checkimage){
    			$("#imagefile").fileinput('upload');
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