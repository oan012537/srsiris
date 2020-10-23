@extends('../template')

@section('content')
	<!-- Page header -->
	<!--<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Import Goods
				</h4>
			</div>

		</div>
	</div>-->
	<!-- /page header -->
	<style type="text/css">
		.classimports{
			background: rgb(199,199,199,0.3);
		}
		.forcheck,.forbank{
			display: none;
		}
		.notclick{
			pointer-events: none;
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
							
							<div class="panel-body">
								<form class="form-horizontal col-md-10" action="#">
									<div class="form-group">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-md-2">
													<div class="form-group">
														<input type="text" name="noorder" id="noorder" class="form-control" placeholder="เลขที่ออเดอร์">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<input type="text" name="datestart" id="datestart" class="form-control datepicker-dates" placeholder="วันที่เริ่มต้น" value="{{ $startdate }}">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<input type="text" name="dateend" id="dateend" class="form-control datepicker-dates" placeholder="วันที่สิ้นสุด" value="{{ $lastdate }}">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<select name="supplier" class="form-control" id="supplier">
															<option value=""> - </option>
															@foreach($supplier as $key => $val)
															<option value="{{$val->supplier_id}}">{{$val->supplier_name}}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<select name="status" class="form-control" id="status">
															<option value=""> - </option>
															<option value="1">ชำระเรียบร้อย</option>
															<option value="0">ยังไม่ชำระ</option>
															{{-- <option value="1">จัดส่งเรียบร้อย</option> --}}
														</select>
													</div>
												</div>
												<div class="col-md-1">
													<div class="form-group">
														<button type="button" id="searchdata" class="btn btn-primary"><i class="icon-folder-search"></i> ค้นหา</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
								<div class="col-md-1">
									<button type="button" onclick="confirmselect();" class="btn btn-primary"><i class="icon-coin-dollar"></i> ชำระเงิน</button>
								</div>
								<div class="col-md-1 pull-right">
									@if(Auth::user()->actionadd != '')
									<a href="{{url('imports/create')}}"<button type="button" class="btn btn-success"><i class="icon-plus-circle2"></i> เพิ่ม</button></a>
									@endif
								</div>
								<input type="hidden" name="saveid" id="saveid">
							</div>
							
							<table class="table" id="datatables">
								<thead>
									<tr>
										<th class="text-center" width="10%">#</th>
										<th class="text-center" width="10%">เลขที่ออเดอร์</th>
										<th class="text-center" width="10%">วันที่</th>
										<th class="text-center" width="15%">ซัพพลายเออร์</th>
										<th class="text-center" width="15%">ผู้ใช้งาน</th>
										<th class="text-center" width="10%">จำนวนเงิน</th>
										<th class="text-center" width="8%">จ่ายเงิน</th>
										<th class="text-center" width="10%">สถานะ</th>
										<th class="text-center" width="10%">#</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
							
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
	<div id="myModal" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">

		<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">กรองข้อมูลที่ต้องการชำระเงิน</h4>
				</div>
				<div class="modal-body">
					{{-- <div class="form-inline"> --}}
					<div class="form-group">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="startdate">วันที่เริ่ม:</label>
										<input type="text" class="form-control datepicker-dates" id="seaechstartdate" placeholder="" name="seaechstartdate" value="{{ $startdate }}">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="enddate">วันที่สิ้นสุด:</label>
										<input type="text" class="form-control datepicker-dates" id="seaechenddate" placeholder="" name="seaechenddate" value="{{ $lastdate }}">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="seaechsupplier">ซัพพลายเออร์:</label>
										<div class="form-group">
											<select name="seaechsupplier" class="form-control" id="seaechsupplier">
												<option value=""> - </option>
												@foreach($supplier as $key => $val)
												<option value="{{$val->supplier_id}}">{{$val->supplier_name}}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<label for="searchdatapay">&nbsp;</label>
										<button type="button" id="searchdatapay" class="btn btn-default">ค้นหา</button>
									</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<label for="searchdatapay">&nbsp; </label>
										<button type="button" id="confirmpay" class="btn btn-primary">ชำระเงิน</button>
									</div>
								</div>
							</div>
						</div>
						<br>
					</div>
					<div id="rowdata" style="display:none;">
					  	<table class="table">
							<thead>
								<tr>
									<th class="text-center" width="10%">ลำดับ</th>
									<th class="text-center" width="15%">เลขที่บิล</th>
									<th class="text-center" width="15%">วันที่</th>
									<th class="text-center" width="20%">ยอดเงิน(บาท)</th>
									<th class="text-center" width="40%">หมายเหตุ</th>
								</tr>
							</thead>
							<tbody id="rowdatas">
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div id="roworder" class="modal fade modal-child" role="dialog" data-backdrop-limit="1" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-modal-parent="#myModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">จำนวนเงินที่ต้องจ่าย</h4>
				</div>
				<div class="modal-body">
					<form id="myform" method="post" action="{{url('imports/pay')}}" enctype="multipart/form-data" onsubmit="return checkcashpay();">
						{{ csrf_field() }}
						<input type="hidden" name="saveimportid" id="saveimportid">
		                <div class="row">
							<div class="col-md-12 col-md-12">
								<div class="form-group">
									<label>จำนวนเงินที่ต้องชำระ :</label>
									<input type="text" name="calmoney" id="calmoney" readonly class="form-control">
								</div>
								<div class="form-group">
									<label>วิธีชำระเงิน :</label>
									<select class="form-control" name="type" id="type" onchange="changetype(this.value)">
										<option value="1">เงินสด</option>
										<option value="2">โอน</option>
										<option value="3">เช็ค</option>
									</select>
								</div>
								<div class="form-group">
									<label>จำนวนเงินที่ชำระ :</label>
									<input type="text" name="paymoney" id="paymoney" class="form-control" required="" autocomplete="off">
								</div>
								<div class="form-group forcheck">
									<label>เลขที่บัญชี :</label>
									<input type="text" name="account" id="account" class="form-control">
								</div>
								<div class="form-group forbank">
									<label>ธนาคาร :</label>
									<input type="text" name="bank" id="bank" class="form-control">
								</div>
								<div class="form-group">
									<label>แนบไฟล์ :</label>
									<input type="file" class="file-input" name="uploadfile" id="uploadfile">
								</div>
								<div class="form-group">
									<label>วันที่ :</label>
									<input type="text" name="date" id="date" class="form-control datepicker-dates" required="" autocomplete="off">
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
				  <button type="submit" class="btn btn-primary" form="myform">บันทึก</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
				</div>
			</div>
		</div>
	</div>
<script>
	$('#seaechstartdate,#seaechenddate,#date,#datestart,#dateend').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('.modal-child').on('show.bs.modal', function () {
	    var modalParent = $(this).attr('data-modal-parent');
	    $(modalParent).css('opacity', 0);
	});
 
	$('.modal-child').on('hidden.bs.modal', function () {
	    var modalParent = $(this).attr('data-modal-parent');
	    $(modalParent).css('opacity', 1);
	});
	function formatNumber (x) {
		return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	var arrayselectbox = [];
	var txtselectbox = '';
	$(document).ready(function(){
		var oTable = $('#datatables').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: false,
			ajax:{ 
				url : "{{url('importsdatatables')}}",
				data: function (d) {
					d.noorder = $('#noorder').val();
					d.datestart = $('#datestart').val();
					d.dateend = $('#dateend').val();
					d.supplier = $('#supplier').val();
					d.status = $('#status').val();
				},
			},
			columns: [
				{ 'className': "text-center", data: 'imp_id', name: 'imp_id' },
				{ 'className': "text-center", data: 'imp_no', name: 'imp_no' },
				{ 'className': "text-center", data: 'imp_date', name: 'imp_date' },
				{ 'className': "text-center", data: 'supplier_name', name: 'supplier_name' },
				{ 'className': "text-center", data: 'user_id', name: 'user_id' },
				{ 'className': "text-center", data: 'money', name: 'money' },
				{ 'className': "text-center", data: 'user_id', name: 'user_id' },
				{ 'className': "text-center", data: 'impt_status', name: 'impt_status' },
				{ 'className': "text-center", data: 'updated_at', name: 'updated_at' },
			],
			order: [[0, 'desc']],
			rowCallback: function(row,data,index ){
				var checkdata = '';
				var statustxt = '';
				var clickbtn = '';
				var clickcancelpay = '';
				if(data['impt_status'] == 1){
					checkdata = "checked disabled";
					statustxt = 'ชำระแล้ว';
					clickbtn = 'notclick';
				}else if(data['impt_status'] == 2){
					statustxt = 'ยกเลิก';
					clickbtn = 'notclick';
					clickcancelpay = 'notclick';
				}
				var btndel = '';
                var permissiondel = "{{Auth::user()->actiondelete}}";
                var permissionedit = "{{Auth::user()->actionedit}}";
                if( permissiondel != ''){
                	btndel = '  <i class="icon-trash '+clickbtn+'" onclick="del('+data['imp_id']+');" data-popup="tooltip" title="Delete"></i>';
                }
                var btnedit = '';
                if(permissionedit !=''){
                	btnedit = ' <a href="imports/update/'+data['imp_id']+'" class="'+clickbtn+'"><i class="icon-pencil7" data-popup="tooltip" title="Update"></i></a>';
                }
				$('td:eq(6)', row).html('<input class="'+clickbtn+'" type="checkbox" '+checkdata+' name="select[]" id="import'+data['imp_id']+'" value="'+data['imp_id']+'" onclick="chooseorder('+"'"+data['imp_id']+"'"+')"><input type="hidden" id="supplier'+data['imp_id']+'" value="'+data['supplier_id']+'">');
				$('td:eq(7)', row).html(statustxt);
				$('td:eq(8)', row).html( btnedit+btndel+' <i class="icon-diff-renamed '+clickcancelpay+'" onclick="cancelpay('+data['imp_id']+');" data-popup="tooltip" title="ยกเลิกการชำระ"></i>' );
			}
		});
		
		oTable.on( 'order.dt search.dt', function(){
			oTable.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell, i){
				cell.innerHTML = i+1;
			} );
		}).draw();
		$('#searchdata').click(function(e){
			oTable.draw();
			e.preventDefault();
		});
		$("#noorder").keyup(function(e){
			oTable.draw();
			e.preventDefault();
		});
		oTable.on( 'page.dt', function () {
			var info = oTable.page.info();
			setTimeout(function(){ 
				var explodearray = txtselectbox.split(',');
				explodearray.forEach(function(index, el) {
					$("#import"+index).prop( "checked", true );
					var xxx= $("#import"+index).val();
					// $("#import"+index).parent().parent().css({'background': '#ff0000ad'});
				});
			}, 300);
		}).draw();
	});

	function del(id){
		bootbox.confirm({
			title: "ยืนยัน?",
			message: "คุณต้องการยกเลิกรายการนี้ หรือไม่?",
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
					window.location.href="imports/del/"+id+"";
				}
			}
		});
	}
	var supplierbefor = '';
	function chooseorder(id){
		var saveid = $("#saveid").val();
		var chooseorder = $("#import"+id).is(':checked');
		var supplier = $("#supplier"+id).val();
		var arraydata = saveid.split(',');
		var txt = '';
		if(supplierbefor != ''){
			if(supplierbefor != supplier){
				alert('ซัพพลายเออร์ไม่ตรงกัน');
				$("#import"+id).prop('checked',false);
				return false;
			}
		}else{
			supplierbefor = supplier;
		}
		if(chooseorder){
			// $("#import"+id).parent().parent().css({'background': '#ff0000ad'});
			if(arraydata.indexOf(id) < 0){
				// txt += saveid+id+',';
				if(saveid.length == 0){
					txt += id+',';
				}else{
					txt += saveid+','+id+',';
				}
			}
		}else{
			if(arraydata.indexOf(id) >= 0){
				arraydata.splice(arraydata.indexOf(id),1);
				// arrayselectbox[id] = '';
			}
			arraydata.forEach(function(index, el) {
				txt += index+',';
			});
		}
		var len = txt.length-1;
		txt = txt.substr(0,len);
		$("#saveid").val(txt);
		txtselectbox = txt;
		console.log(len)
		if(len < 0){
			supplierbefor = '';
		}
	}
	function confirmselect(){
		var explodearray = txtselectbox.split(',');
		var saveid = $("#saveid").val();
		if(saveid.length > 0){
			$.post("{{ url('imports/getpay') }}", {id: explodearray,'_token': "{{ csrf_token() }}"}, function(data, textStatus, xhr) {
				$("#calmoney").val(data);
				$('#roworder').modal('show');
				$("#saveimportid").val(saveid);
			});
		}else{
			$('#myModal').modal('show');
		}
	}
	function changetype(value){
		if(value == 1){
			$(".forcheck").css('display', 'none');
			$(".forbank").css('display', 'none');;
			$("#myform #account").prop('required',false)
			$("#myform #bank").prop('required',false)
			$("#myform #uploadfile").prop('required',false)
		}else if(value == 2){
			$(".forcheck").css('display', 'none');
			$(".forbank").css('display', 'block');;
			$("#myform #account").prop('required',false);
			$("#myform #bank").prop('required',true);
			$("#myform #uploadfile").prop('required',true);
		}else{
			$(".forcheck").css('display', 'block');
			$(".forbank").css('display', 'block');
			$("#myform #account").prop('required',true);
			$("#myform #bank").prop('required',true);
			$("#myform #uploadfile").prop('required',true);
		}
	}

	$('#searchdatapay').click(function(){
		var supplier = $('#seaechsupplier').val();
		if(supplier == ''){
			Lobibox.notify('warning',{
				msg: 'กรุณาเลือกข้อมูลซัพพลายเออร์ ก่อนกดปุ่มค้นหา!',
				buttonsAlign: 'center',
				closeOnEsc: true, 
			});
			return false;
		}
		$.ajax({
		'type': 'post',
		'url': "{{url('imports/checkdatapay')}}",
		'dataType': 'json',
		'data': {
			'startdate': $('#seaechstartdate').val(),
			'enddate': $('#seaechenddate').val(),
			'supplier': supplier,
			'_token': "{{ csrf_token() }}"
		},
			'success': function (data){
				if(data.status == 'Y'){
					$("#saveid").val(data.txt);
					$("#saveimportid").val(data.arraytxt);
					$("#calmoney").val(data.money);
					if(data.data.length > 0){
						var text = '';
						var num = 1;
						$.each(data.data,function(key,item){
							var note = '';
							if(item.impt_note != null){
								note = item.impt_note
							}
							text += '<tr class="rowbody" >'
								+'<td align="center">'+num+'</td>'
								+'<td align="left">'+item.imp_no+'</td>'
								+'<td align="center">'+item.imp_date+'</td>'
								+'<td align="center">'+item.cal+'</td>'
								+'<td align="center">'+ note +'</td>';
								+'</tr>';
							num++;
						});
						text += '<tr class="rowbody" >'
							+'<td align="center"></td>'
							+'<td align="left"></td>'
							+'<td align="center"></td>'
							+'<td align="center">'+data.money+'</td>'
							+'<td align="center"></td>';
							+'</tr>';
						$('#rowdatas').append(text);
						$('#rowdata').show();
					}else{
						$('#rowdatas').append(text);
					}
				}else{
					Lobibox.notify('warning',{
						msg: 'ไม่มีข้อมูลที่ต้องการ',
						buttonsAlign: 'center',
						closeOnEsc: true, 
					});
					$('#rowdatas').append(text);
					return false;
				}
			}
		});
	});

	$("#confirmpay").click(function(event) {
		var saveid  = $("#saveid").val()
		if(saveid.length != 0){
			$('#roworder').modal('show');
		}else{
			Lobibox.notify('warning',{
				msg: 'ไม่มีข้อมูลที่ต้องการ',
				buttonsAlign: 'center',
				closeOnEsc: true, 
			});
			return false;
		}
		
	});
	function cancelpay(id){
		bootbox.confirm({
			title: "ยืนยัน?",
			message: "คุณต้องการยกเลิกการชำระเงินรายการนี้ หรือไม่?",
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
					window.location.href="imports/cancelpay/"+id+"";
				}
			}
		});
	}
	function checkcashpay(){
		
		var calmoney = $("#calmoney").val();
		var paymoney = $("#paymoney").val();
		
		if(parseFloat(calmoney) > parseFloat(paymoney)){
			bootbox.alert({
				title: "ยืนยัน?",
				message: "ยอดชำระไม่เท่ากับยอดที่คุณต้องชำระ กรุณาตรวจสอบที่ชำระอีกครั้ง",
			});
			return false;
		}else{
			return true;
		}
	}
</script>
@stop