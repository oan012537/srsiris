@extends('../template')

@section('content')

<style type="text/css">
	.main-section{
		margin:0 auto;
		padding: 20px;
		margin-top: 20px;
		background-color: #fff;
		box-shadow: 0px 0px 10px #c1c1c1;
	}
		.fileinput-remove,
		.fileinput-upload{
		display: none;
	}
</style>

	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
				<div class="row">
					<div class="col-md-12">
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
							
							<div class="panel-body">
								<form class="form-horizontal" action="#">
									<div class="form-group">
										<div class="col-lg-12">
											<div class="row">
												

												<div class="pull-right">
													<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"><i class="icon-plus-circle2"></i> เพิ่มรูปภาพแบนเนอร์</button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
							
							<?php $number = 0; ?>
							
							<div class="table-responsive">
								<table class="table table-bordered" id="datatables">
									<thead>
										<tr>
											<th class="text-center" width="5%">ลำดับ</th>
											<th class="text-center" width="50%">ภาพแบนเนอร์</th>
											<th class="text-center" width="30%">#</th>
										</tr>
										
										@foreach($databanner as $item)
										<?php $number = $number+1; ?>
										<tr>
											<td class="text-center">{{$number}}<t/td>
											<td class="text-center"><img src="{{asset('storage/banner/'.$item->picture_benner)}}"  alt="your image" style="height:150px; width:250px;" ></td>
											<td class="text-center">
												<button type="button" class="btn btn-success btn-rounded edit-gallery" data-id="{{ $item->id_fn_benner }}" data-toggle="modal" data-target="#modalchang_image" aria-hidden="true"><i class="icon-upload"></i> เปลี่ยน</button>
												<button type="button" class="btn btn-danger btn-rounded" onclick="del('{{$item->id_fn_benner}}')"><i class="icon-trash"></i> ลบ</button>
											</td>
										</tr>										
										@endforeach
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	
	
<!-- Modal Add Banner -->
<form method="post" action="{{ url('store_banner') }}" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden"  name="idmain" id="idmain" >
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog modal-lg" >
		  <!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="glyphicon glyphicon-camera"></i>&nbsp; เพิ่มรูปภาพแบนเนอร์</h4>
				</div>
				<div class="modal-body">
									
					<div class="row">
						<div class="col-md-2"></div>
						<div class="col-lg-8 col-sm-8 col-12 main-section">
							<label>เพิ่มรูปภาพแบนเนอร์  ( สูงสุดครั้งละ 5 รูป )</label>
							<div class="form-group">
								<div class="file-loading">
									<input id="gallery" type="file" name="gallery[]" multiple class="file" onchange="ModalSize()" required>
								</div>
							</div>
						</div>
					</div>					
					
					
					<div class="row">
						<div class="col-md-2"></div>
						<div class="col-md-8"><br>
							<b><p style="color:red;">ขนาดรูปภาพ -- *-- </p></b>
							<b><p style="color:red;">อัพโหลดไฟล์รูปภาพได้ไม่เกินรูปละ 4 MB || 4194304 Bytes *</p></b>							
						</div>
					</div>					
					
					<div class="row">
						
						<div class="col-md-2"></div>
						<div class="col-md-8"><legend style="border-bottom:1px solid #a2a0a0"> </legend></div>											
					</div>		
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
				  <button type="submit" class="btn btn-primary">  บันทึก</button>
				</div>
			</div>
		</div>
	</div>
</form>
<!-- /Modal Add Banner -->	

<!-- Model Chang Image In Banner -->
<div class="modal fade" id="modalchang_image" role="dialog" >
	<form class="form-horizontal" action="{{ url('update_banner') }}"  method="POST" enctype="multipart/form-data" >
	{{ csrf_field() }}
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title ">แก้ไขรูปภาพแบเนเนอร์ </h4> 
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4"></div>
						<img src="" id="image_pictues" class="img-fluid img-responsive" style="height:250px; width:350px;" >
					</div>
					<br>
					
					<div class="row">
						<div class="col-md-2"></div>
						<div class="col-md-8">
							<p id="demo"></p>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-2"></div>
						<div class="col-md-8">
							<input type="file" id="pictuesfilechoose" name="pictuesfilechoose" class="form-control" onchange='readURL1(this);'  required> 									
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-2"></div>
						<div class="col-md-8"><br>
							<b><p style="color:red;">ขนาดรูปภาพ -- * --</p></b>
							<b><p style="color:red;">อัพโหลดไฟล์รูปภาพได้ไม่เกินรูปละ 4 MB || 4194304 Bytes *</p></b>
						</div>
					</div>
					
					<input type="hidden" name="id_banner" id="id_banner" value=""> <!-- id -->
					<input type="hidden" name="picturebenner" id="picturebenner" value=""> <!-- id filechoose -->
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
					<button type="submit" class="btn btn-primary"> บันทึก</button>
				</div>				
			</div>
		</div>
	</form>
</div>
<!-- /Model Chang Image In Banner -->

	
<script type="text/javascript">
	$("#gallery").fileinput({
		theme: 'fa',
	//	uploadUrl: "#",
		allowedFileExtensions: ['jpg', 'png', 'gif'],
		overwriteInitial: false,
		maxFilesNum: 10,
		slugCallback: function (filename) {
		  return filename.replace('(', '_').replace(']', '_');
		}
	});
</script>	

<!-- Script Modal Add Gallery -->
<script>
function ModalSize(){
  var x = document.getElementById("gallery");
  var txt = "";
  if ('files' in x) {
    if (x.files.length == 0) {
      txt = "Select one or more files.";
    } else {
      for (var i = 0; i < x.files.length; i++) {		  
        txt += "<br><strong>"+ (i+1) + ". file </strong>";
        var file = x.files[i];
		
		if(file.size > 4194304){
			alert( +file.size + " Bytes" + " over file upload !!");
			x.value = "";
		}else{
			if ('name' in file) {
			  txt += "name: " + file.name + " ";
			}
			if ('size' in file) {
			  txt += "size: " + file.size + " bytes <br>";
			}			
		}
      }
    }
  } 
  else {
    if (x.value == "") {
      txt += "Select one or more files.";
    } else {
      txt += "The files property is not supported by your browser!";
      txt  += "<br>The path of the selected file: " + x.value;
    }
  }
 
}
</script>

<!-- Script Chang Image gallery -->
<script>
function ImageTitle(){
  var x = document.getElementById("pictuesfilechoose");
  var txt = "";

  if ('files' in x) {
    if (x.files.length == 0) {
      txt = "Select one or more files.";
    } else {
      for (var i = 0; i < x.files.length; i++) {		  
        txt += "<br><strong>"+ (i+1) + ". file </strong>";
        var file = x.files[i];
		
		if(file.size > 4194304){
			alert( +file.size + " Bytes" + " over file upload !!");
			x.value = "";
		}else{
			if ('name' in file) {
			  txt += "name: " + file.name + " ";
			}
			if ('size' in file) {
			  txt += "size: " + file.size + " bytes <br>";
			}			
		}
      }
    }
  } 
  else {
    if (x.value == "") {
      txt += "Select one or more files.";
    } else {
      txt += "The files property is not supported by your browser!";
      txt  += "<br>The path of the selected file: " + x.value; 
    }
  }
  document.getElementById("demo").innerHTML = txt;
}
</script>


<script>
	$( document ).ready(function() {
	    $(".edit-gallery").on('click', function() {
			var id_pic = $(this).attr('data-id');

			$("#image_pictues").attr('src',"");
			document.getElementById("id_banner").value="";
			document.getElementById("picturebenner").value="";
		
			$.ajax({ 
				url:"{{ url('ajax_bannerdata') }}",
				data:{"_token": "{{ csrf_token() }}",'id_pic':id_pic},
				type:"POST",
				
				success:function(data){ 
					var obj = jQuery.parseJSON(data);					
					$("#image_pictues").attr('src',"{{asset('storage/banner')}}/"+obj.databanner.picture_benner);
					document.getElementById("picturebenner").value=obj.databanner.picture_benner;
					document.getElementById("id_banner").value=obj.databanner.id_fn_benner;
				},
				error:function(){
					alert('error');
				}
			});
	    });
	});

	function readURL1(input) {
		if (input.files && input.files[0]) {
			
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#image_pictues')
					.attr('src', e.target.result);
			};

			reader.readAsDataURL(input.files[0]);
			ImageTitle();
		}
	}
</script>

<script>
	function del(id){
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
					var urldelte = "{{url('/destroy_banner')}}"+"/"+id;
					window.location.href=""+urldelte+"";
				}
			}
		});
	}	
</script>


	

@stop