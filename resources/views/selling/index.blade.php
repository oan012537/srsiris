@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- <div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Selling / Export
				</h4>
			</div>

		</div>
	</div>-->
	<!-- /page header -->
	<style type="text/css">
		.classselling{
			background: rgb(199,199,199,0.3);
		}
		.notclick{
			pointer-events: none;
		}
		.light-box{
			z-index: 999999 !important;
		}
		.chocolat-wrapper{
			z-index: 999999 !important;
		}
		.fancybox-close:after{
			content:none !important;
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
								<form class="form-horizontal" action="#">
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
														<input type="text" name="datestart" id="datestart" class="form-control datepicker-dates" placeholder="วันที่เริ่มต้น" autocomplete="off">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<input type="text" name="dateend" id="dateend" class="form-control datepicker-dates" placeholder="วันที่สิ้นสุด" autocomplete="off">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<select name="customername" class="form-control" id="customername">
															<option value=""> - </option>
															@if(!empty($customer))
															@foreach($customer as $value)
															<option value="{{ $value->customer_id }}"> {{ $value->customer_name }} </option>
															@endforeach
															@endif
														</select>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<select name="staus" class="form-control" id="staus">
															<option value=""> - </option>
															<option value="0">ยังไม่ทำรายการ</option>
															<!-- <option value="7">พิมพ์แล้ว</option> -->
															<option value="3">ยกเลิก</option>
															<option value="6">กำลังแพ็กของ</option>
															<option value="4">แพ็กของ</option>
															<option value="5">กำลังจัดส่ง</option>
															<option value="1">จัดส่งเรียบร้อย</option>
														</select>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<button type="button" id="searchdata" class="btn btn-primary"><i class="icon-folder-search"></i> ค้นหา</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
							
							<table class="table" id="datatables">
								<thead>
									<tr>
										<th class="text-center" width="10%">ลำดับ</th>
										<th class="text-center" width="20%">เลขที่ออเดอร์</th>
										<th class="text-center" width="10%">วันที่</th>
										<th class="text-center" width="20%">ลูกค้า</th>
										<th class="text-center" width="10%">สถานะ</th>
										<th class="text-center" width="13%">รวม</th>
										<th class="text-center" width="12%">#</th>
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
	<div class="modal inmodal" id="calculator" tabindex="-1" role="dialog"  aria-hidden="true">
	    <div class="modal-dialog" style="width:70%">
	        <div class="modal-content animated fadeIn">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title text-center">คำนวณ</h4>
	            </div>
	            <div class="modal-body">
	                <div class="row">
						<div class="col-md-10 col-md-10 col-md-offset-1">
							<fieldset>
								<legend class="text-semibold">รายละเอียดสินค้า</legend>
								<form method="post" action="{{url('selling/calmoney')}}" enctype="multipart/form-data" id="formpaymoney" target="_blank" onsubmit="printer();">
								{{ csrf_field() }}
									<div class="form-group">
										<label>ราคาทั้งหมด :</label>
										<input type="text" class="form-control" name="sumtotal" id="sumtotal"  required readonly>
										<input type="hidden" name="selling_id" id="selling_id">
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label col-md-4">ส่วนลด</label>
													<div class="col-md-8">
														<?php 
															//$discount = array(5,10,15,20,25,30);
														?>
														<select name="discount" id="discount" class="form-control">
															<option value="0">ไม่มีส่วนลด</option>
															<?php
																//foreach($discount as $dis){
																	//echo '<option value="'.$dis.'">'.$dis.' %</option>';
																//}
															?>
															@if(!empty($discount))
															@foreach($discount as $dis)
															<option value="{{ $dis->percendiscount_value}}">{{ $dis->percendiscount_value}} %</option>
															@endforeach
															@endif
														</select>
													</div>
												</div>
											</div>
											
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label col-md-4"><span id="fontdis"></span></label>
													<div class="col-md-8">
														<input type="text" id="sumdiscountsp" class="form-control summary-box textshow" onkeydown="return false;" value="0.00" autocomplete="off">
														<input type="hidden" class="form-control" name="sumdiscount" id="sumdiscount" value="0.00" readonly>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label col-md-4">ภาษี</label>
													<div class="col-md-8">
														<div class="radio">
															<label>
																<input type="radio" class="styled vat" name="vat" id="vat0" value="0" checked="checked">No Vat
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="styled vat" name="vat" id="vat1" value="1">Exclude Vat
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="styled vat" name="vat" id="vat2" value="2">Include Vat
															</label>
														</div>
													</div>
												</div>
											</div>
											
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label col-md-4"><span id="fontvat"><strong>ภาษีมูลค่าเพิ่ม</strong></span></label>
													<div class="col-md-8">
														<input type="text" id="sumvatsp" class="form-control summary-box textshow" onkeydown="return false;" value="0.00" autocomplete="off">
														<input type="hidden" class="form-control" name="sumvat" id="sumvat" value="0.00" readonly>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label col-md-4">การชำระเงิน</label>
													<div class="col-md-8">
														@php 
															// $payment = array('เงินสด','เครดิต','เครดิต 15 วัน','เครดิต 30 วัน');
															$payment = array('เงินสด','เช็ค','โอน');
														@endphp
														<select name="payment" id="payment" class="form-control" onchange="changepay(this.value)">
															@php
																foreach($payment as $pay){
																	echo '<option value="'.$pay.'">'.$pay.'</option>';
																}
															@endphp
														</select>
														<input type="text" class="form-control" name="noauccount" id="noauccount" style="display: none" placeholder="เลขที่บัญชี">
													</div>
												</div>
											</div>
											
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label col-md-4"><span><strong>รวมทั้งสิ้น</strong></span></label>
													<div class="col-md-8">
														<input type="text" id="sumpaymentsp" class="form-control summary-box textshow" onkeydown="return false;" value="0.00" autocomplete="off">
														<input type="hidden" class="form-control" name="sumpayment" id="sumpayment" value="0.00" readonly>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label col-md-4">ส่วนลดท้ายบิล</label>
													<div class="col-md-8">
														<input type="text" class="form-control number" name="discountlastbill" id="discountlastbill">
													</div>
												</div>
											</div>
											
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label col-md-4"><span><strong><font>หมายเหตุ</font></strong></span></label>
													<div class="col-md-8">
														<input type="text" id="notediscountlastbill" class="form-control summary-box textshow" name="notediscountlastbill">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label col-md-4"><span><strong><font color="green">ยอดชำระ</font></strong></span></label>
													<div class="col-md-8">
														<input type="text" id="sumtotalallsp" class="form-control summary-box textshow" onkeydown="return false;" value="0.00" autocomplete="off">
														<input type="hidden" class="form-control" name="sumtotalall" id="sumtotalall" value="0.00" readonly>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
							</fieldset>
						</div>
					</div>
	            </div>
	            <div class="modal-footer" style="margin-top:3%">
	                <button type="submit" form="formpaymoney" class="btn btn-primary"  >พิมพ์</button>
	                <button type="button" class="btn btn-white" data-dismiss="modal" >ปิด</button>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal inmodal" id="showfile" tabindex="-1" role="dialog"  aria-hidden="true">
	    <div class="modal-dialog" style="width:70%">
	        <div class="modal-content animated fadeIn">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title text-center">ดูข้อมูล</h4>
	            </div>
	            <div class="modal-body">
	                <div class="row">
						<div class="col-md-10 col-md-10 col-md-offset-1">
							{{-- <fieldset> --}}
								{{-- <legend class="text-semibold">ข้อมูลไฟล์</legend> --}}
								<div class="row">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>ชื่อไฟล์</th>
												<th>วันที่</th>
												{{-- <th>ประเภท</th> --}}
												<th>#</th>
											</tr>
										</thead>
										<tbody id="showdatafile">
										</tbody>
									</table>
								</div>
							{{-- </fieldset> --}}
						</div>
					</div>
	            </div>
	            <div class="modal-footer" style="margin-top:3%">
	                <button type="button" class="btn btn-danger" data-dismiss="modal" >ปิด</button>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal" data-backdrop="static" id="uploadfile" tabindex="-1" role="dialog"  aria-hidden="true">
	    <div class="modal-dialog" style="width:70%">
	        <div class="modal-content animated fadeIn">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title text-center">บันทึกไฟล์</h4>
	            </div>
	            <div class="modal-body">
	            	<form id="myformuploadfileselling" method="post" action="{{url('transport/uploadfileforselling')}}" enctype="multipart/form-data">
	            		<input type="hidden" id="sellingid" name="sellingid">
	            		<input type="hidden" id="transportid" name="transportid">
						{{ csrf_field() }}
		                <div class="row">
		                	<div class="col-md-12 col-md-12">
								<div class="form-group">
									<label>สถานที่ส่ง :</label>
									<select class="form-control" id="destination" name="destination">
									</select>
								</div>
							</div>
							<div class="col-md-12 col-md-12">
								<div class="form-group">
									<label>เลขที่จัดส่ง :</label>
									<input type="text" class="form-control" name="nodelivery" id="nodelivery" required>
								</div>
							</div>
		                	<div class="col-md-12 col-md-12">
								<div class="form-group">
									<label>ค่าขนส่ง :</label>
									<input type="number" class="form-control" name="shippingcost" id="shippingcost" required>
								</div>
							</div>
							<div class="col-md-12 col-md-12">
								<div class="form-group">
									<label>ไฟล์ :</label>
									<input type="file" class="file-input" name="uploadfileselling" id="uploadfileselling" required>
								</div>
							</div>
						</div>
					</form>
	            </div>
	            <div class="modal-footer" style="margin-top:3%">
	                <button type="submit" form="myformuploadfileselling" class="btn btn-white" >บันทึก</button>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal inmodal" id="printbillselling" tabindex="-1" role="dialog"  aria-hidden="true">
	    <div class="modal-dialog" style="width:70%">
	        <div class="modal-content animated fadeIn">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title text-center">พิมพ์ใบขาย</h4>
	            </div>
	            <div class="modal-body">
	            	<form method="post" action="{{url('selling/printbillselling')}}" enctype="multipart/form-data" id="formprintsellingbill" target="_blank" onsubmit="printer();">
								{{ csrf_field() }}
		                <div class="row">
							<div class="col-md-10 col-md-10 col-md-offset-1">
								<input type="hidden" name="selling_id" id="selling_id">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label">หมายเหตุ</label>
											<textarea name="commentprintselling" class="form-control" rows="3"></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
	            </div>
	            <div class="modal-footer" style="margin-top:3%">
	                <button type="button" class="btn btn-danger" data-dismiss="modal" >ปิด</button>
	                <button type="button" class="btn btn-primary" onclick="printbillselling();">พิมพ์</button>
	            </div>
	        </div>
	    </div>
	</div>

<script>
	function formatNumber (x) {
		return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	
	$(document).ready(function(){
		var oTable = $('#datatables').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: false,
			ajax:{ 
				url : "{{url('sellingdatatables')}}",
				data: function (d) {
					d.noorder = $('#noorder').val();
					d.datestart = $('#datestart').val();
					d.dateend = $('#dateend').val();
					d.staus = $('#staus').val();
					d.customername = $('#customername').val();
					d.keyword = $('#keyword').val();
				},
			},
			columns: [
				{ 'className': "text-center", data: 'selling_id', name: 'selling_id' },
				{ 'className': "text-center", data: 'selling_inv', name: 'selling_inv' },
				{ 'className': "text-center", data: 'selling_date', name: 'selling_date' },
				{ 'className': "text-center", data: 'selling_customername', name: 'selling_customername' },
				{ 'className': "text-center", data: 'selling_status', name: 'selling_status' },
				{ 'className': "text-center", data: 'selling_totalpayment', name: 'selling_totalpayment' },
				{ 'className': "text-center", data: 'updated_at', name: 'updated_at' },
			],
			order: [[0, 'desc']],
			rowCallback: function(row,data,index ){
				$('td:eq(0)', row).html(index+1);
				var status = '';
				var notclick = 'notclick';
				var clickpay = '';
				var viewfile = '';
				var btnupfile = '';
				var dates = moment().format("YYYY-MM-DD");
				var countdate = moment(data['created_at']).add(3, 'months').format("YYYY-MM-DD");
				// if(dates >= countdate){
				// 	$(row).css('background', '#ff5555');
				// }
				// console.log(dates+' >> << '+countdate);
				// if(data['product_status'] > 0){ //อันเก่า
				
				if(data['selling_status'] == 1){
					var status = '<span class="label bg-success-400">พิมพ์บิลแล้ว</span>';
					notclick = '';
					clickpay = 'notclick';
					var btn = '<i class="icon-printer2 '+notclick+'" data-popup="tooltip" title="พิมพ์" onclick="print('+data['selling_id']+');"></i>  <a href="{{url("selling/update")}}/'+data['selling_id']+'" class="'+notclick+'"> <i class="icon-pencil7" data-popup="tooltip" title="แก้ไข"></i></a>  <a href="{{url("selling/restore")}}/'+data['selling_id']+'" class="'+notclick+'"> <i class="icon-reload-alt" data-popup="tooltip" title="คืนสินค้า"></i></a>  <i class="icon-cancel-square" onclick="del('+data['selling_id']+');" data-popup="tooltip" title="Cancel"></i>';
				}else if(data['selling_status'] == 2){
					var status = '<span class="label bg-warning-400">บิลชั่วคราว</span>';
					var btn = '<i class="icon-printer2 '+notclick+'" data-popup="tooltip" title="พิมพ์" onclick="print('+data['selling_id']+');"></i>  <a href="{{url("selling/update")}}/'+data['selling_id']+'" class="'+notclick+'"> <i class="icon-pencil7" data-popup="tooltip" title="แก้ไข"></i></a>  <a href="{{url("selling/restore")}}/'+data['selling_id']+'" class="'+notclick+'"> <i class="icon-reload-alt" data-popup="tooltip" title="คืนสินค้า"></i></a> <i class="icon-cancel-square" onclick="del('+data['selling_id']+');" data-popup="tooltip" title="Cancel"></i>';
				}else if(data['selling_status'] == 3){
					var status = '<span class="label bg-danger-400">ยกเลิก</span>';
					var btn = ' <i class="icon-cancel-square" onclick="calceldel('+data['selling_id']+');" data-popup="tooltip" title="ยกเลิกการยกเลิก"></i>'
				}else if(data['selling_status'] == 4){
					var status = '<span class="label bg-primary-400">แพ็คของแล้ว</span>';
					notclick = '';
					clickpay = 'notclick';
					var btn = '<i class="icon-printer2 '+notclick+'" data-popup="tooltip" title="พิมพ์" onclick="print('+data['selling_id']+');"></i> <i class="icon-file-plus" onclick="btnupfile('+data['selling_id']+','+data['selling_customerid']+');" data-popup="tooltip" title="อัพไฟล์"></i> <a href="{{url("selling/update")}}/'+data['selling_id']+'" class="'+notclick+'"> <i class="icon-pencil7" data-popup="tooltip" title="แก้ไข"></i></a>  <a href="{{url("selling/restore")}}/'+data['selling_id']+'" class="'+notclick+'"> <i class="icon-reload-alt" data-popup="tooltip" title="คืนสินค้า"></i></a> <i class="icon-cancel-square" onclick="del('+data['selling_id']+');" data-popup="tooltip" title="Cancel"></i>';
				}else if(data['selling_status'] == 5){
					var status = '<span class="label bg-primary-400">จัดขนส่ง</span>';
					notclick = '';
					clickpay = 'notclick';
					var btn = '<i class="icon-printer2 '+notclick+'" data-popup="tooltip" title="พิมพ์" onclick="print('+data['selling_id']+');"></i> <a href="{{url("selling/restore")}}/'+data['selling_id']+'" class="'+notclick+'"> <i class="icon-reload-alt" data-popup="tooltip" title="คืนสินค้า"></i></a> <i class="icon-file-plus" onclick="btnupfile('+data['selling_id']+','+data['selling_customerid']+');" data-popup="tooltip" title="อัพไฟล์"></i> <i class="icon-cancel-square" onclick="del('+data['selling_id']+');" data-popup="tooltip" title="Cancel"></i>';
				}else if(data['selling_status'] == 6){
					var status = '<span class="label bg-warning-400">แพ็คของยังไม่ครบ</span>';
					notclick = '';
					clickpay = 'notclick';
					var btn = '<i class="icon-printer2 '+notclick+'" data-popup="tooltip" title="พิมพ์" onclick="print('+data['selling_id']+');"></i>  <a href="{{url("selling/update")}}/'+data['selling_id']+'" class="'+notclick+'"> <i class="icon-pencil7" data-popup="tooltip" title="แก้ไข"></i></a>  <a href="{{url("selling/restore")}}/'+data['selling_id']+'" class="'+notclick+'"> <i class="icon-reload-alt" data-popup="tooltip" title="คืนสินค้า"></i></a> <i class="icon-cancel-square" onclick="del('+data['selling_id']+');" data-popup="tooltip" title="Cancel"></i>';
				}else if(data['selling_status'] == 7){
					var status = '<span class="label bg-warning-400">จัดใบเก็บเงิน</span>';
					var btn = '<i class="icon-printer2 '+notclick+'" data-popup="tooltip" title="พิมพ์" onclick="print('+data['selling_id']+');"></i>  <a href="{{url("selling/update")}}/'+data['selling_id']+'" class="'+notclick+'"> <i class="icon-pencil7" data-popup="tooltip" title="แก้ไข"></i></a>  <a href="{{url("selling/restore")}}/'+data['selling_id']+'" class="'+notclick+'"> <i class="icon-reload-alt" data-popup="tooltip" title="คืนสินค้า"></i></a> <i class="icon-file-plus" onclick="btnupfile('+data['selling_id']+','+data['selling_customerid']+');" data-popup="tooltip" title="อัพไฟล์"></i> <i class="icon-files-empty2" onclick="view('+data['selling_id']+');" data-popup="tooltip" title="ดูไฟล์"></i> <i class="icon-cancel-square" onclick="del('+data['selling_id']+');" data-popup="tooltip" title="Cancel"></i>';
				}else if(data['selling_status'] == 8){
					var status = '<span class="label bg-success-400">ชำระเรียบร้อย</span>';
					var btn = '<i class="icon-file-plus" onclick="btnupfile('+data['selling_id']+','+data['selling_customerid']+');" data-popup="tooltip" title="อัพไฟล์"></i>  <i class="icon-files-empty2" onclick="view('+data['selling_id']+');" data-popup="tooltip" title="ดูไฟล์"></i>';
				}else{
					var btn = '<i class="icon-calculator3 '+clickpay+'" data-popup="tooltip" title="คำนวณ" onclick="calmoney('+data['selling_id']+');"></i> <i class="icon-printer2 '+notclick+'" data-popup="tooltip" title="พิมพ์" onclick="print('+data['selling_id']+');"></i>  <a href="{{url("selling/update")}}/'+data['selling_id']+'"> <i class="icon-pencil7" data-popup="tooltip" title="แก้ไข"></i></a>  <a href="{{url("selling/restore")}}/'+data['selling_id']+'" > <i class="icon-reload-alt" data-popup="tooltip" title="คืนสินค้า"></i></a> <i class="icon-cancel-square" onclick="del('+data['selling_id']+');" data-popup="tooltip" title="Cancel"></i>';
				}
				$('td:eq(4)', row).html(status);
				// $('td:eq(5)', row).html( '<i class="icon-mailbox" data-popup="tooltip" title="Mail" onclick="mail('+data['export_id']+');"></i> <i class="icon-magazine" data-popup="tooltip" title="Bill" onclick="openbill('+data['export_id']+');"></i> <a href="{{url("export-update")}}/'+data['export_id']+'"><i class="icon-pencil7" data-popup="tooltip" title="Update"></i></a> <i class="icon-trash" onclick="del('+data['export_id']+');" data-popup="tooltip" title="Delete"></i>' );
				$('td:eq(6)', row).html(btn);
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
		$("div.dataTables_filter").append(' <input type="text" name="keyword" id="keyword" placeholder="ค้นหาชื่อสินค้า">');
		$("#keyword").keyup(function (e) {
			if(e.keyCode == '13'){
				oTable.draw();
				e.preventDefault();
			}
		 });
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
					window.location.href="selling/cancel/"+id+"";
				}
			}
		});
	}
	function openbill(id){
		window.open("export-bill/"+id);
	}
	function mail(id){
		// window.open("export-mail/"+id);
		run_waitMe($('body'), 3, 'roundBounce');
		$.ajax({
			url : "{{url('export-mail')}}/"+id,
			// datatype:'json',
			success:function(data){
				// console.log(data)
				$('body').waitMe('hide');
				if(data == 'y'){
					Lobibox.notify('success',{
						msg: 'Success send email',
						buttonsAlign: 'center',
						closeOnEsc: true,  
					});
				}else{
					Lobibox.notify('error',{
						msg: 'Error send email',
						buttonsAlign: 'center',
						closeOnEsc: true,  
					});
				}
			}
		});
	}
	function calmoney(id){
		// checkproduct.blade.php
		// window.location.href="selling/getdatapay/"+id+"";
		$.post('{{url('selling/getdatapay')}}', {'id': id,'_token': "{{ csrf_token() }}",}, function(data, textStatus, xhr) {
			$(".vat").parent().removeClass('checked');
			$("#vat"+data.customer_vat).parent().addClass('checked').click();
			if(data.customer_vat == ''){
				$("#vat0").parent().addClass('checked').click();
			}
			
			$("#sumtotal").val(data.selling_totalall);
			$("#selling_id").val(id);
			var sumrowall = data.selling_totalall||0;
			$('#sumtotalsp').val(formatNumber(sumrowall.toFixed(2)));
			$('#sumtotal').val(sumrowall.toFixed(2));
			fncalmoney();
			$('#calculator').modal('show');
		});
	}
	// <!-- Vat Process -->
	$('input.vat').on('change', function() {
		fncalmoney();
	});
	// <!-- /Vat Process -->
	
	// <!-- Discount Process -->
	$('#discount').change(function(){
		fncalmoney();
	});
	// <!-- /Discount Process -->
	
	// <!-- Discountlastbill Process -->
	$('#discountlastbill').keyup(function(){
		var payment = $('#sumpayment').val()||0;
		var lastbill = $(this).val()||0;
		var payments =  parseFloat(payment)-parseFloat(lastbill);
		$('#sumtotalallsp').val(formatNumber(payments.toFixed(2)));
		$('#sumtotalall').val(payments.toFixed(2));
	});
	// <!-- /Discountlastbill Process -->

	function fncalmoney(){
		// alert();
		// <!-- คำนวณ ยอด -->
		var sumtotal 	= $('#sumtotal').val()||0;
		var discount 	= $('#discount').val()||0;
		var sumdiscount	= parseFloat((discount)*sumtotal)/100;
		var vat 		= $('.vat:checked').val();
		var discounts	= parseFloat(sumtotal-sumdiscount);
		var lastbill 	= $('#discountlastbill').val()||0;
		
		$('#fontdis').html('<strong> => </strong>');
		$('#sumdiscountsp').val(formatNumber(sumdiscount.toFixed(2)));
		$('#sumdiscount').val(sumdiscount.toFixed(2));
		
		if(vat == 0){
			$('#sumvatsp').val('0.00');
			$('#sumvat').val('0.00');
			$('#sumpaymentsp').val(formatNumber(discounts.toFixed(2)));
			$('#sumpayment').val(discounts.toFixed(2));
			$('#sumtotalallsp').val(formatNumber((discounts-lastbill).toFixed(2)));
			$('#sumtotalall').val((discounts-lastbill).toFixed(2));
		}else if(vat == 1){
			sumvat 		= parseFloat(discounts * 7)/(100);
			var payment = parseFloat(discounts+sumvat);
			$('#sumvatsp').val(formatNumber(sumvat.toFixed(2)));
			$('#sumvat').val(parseFloat(sumvat.toFixed(2)));
			$('#sumpaymentsp').val(formatNumber(payment.toFixed(2)));
			$('#sumpayment').val(payment.toFixed(2));
			$('#sumtotalallsp').val(formatNumber((payment-lastbill).toFixed(2)));
			$('#sumtotalall').val((payment-lastbill).toFixed(2));
		}else if(vat == 2){
			sumvat = parseFloat(discounts * 100)/(107);
			var sumvats = parseFloat(discounts-sumvat);
			$('#sumvatsp').val(formatNumber(sumvats.toFixed(2)));
			$('#sumvat').val(sumvats.toFixed(2));
			$('#sumpaymentsp').val(formatNumber(discounts.toFixed(2)));
			$('#sumpayment').val(discounts.toFixed(2));
			$('#sumtotalallsp').val(formatNumber((discounts-lastbill).toFixed(2)));
			$('#sumtotalall').val((discounts-lastbill).toFixed(2));
		}
		// <!-- /คำนวณ ยอด -->
	}
	function changepay(value){
		if(value == 'โอน'){
			$("#noauccount").css('display','block');
		}else{
			$("#noauccount").css('display','none')
		}
	}

	function print(id){
		$("#printbillselling").modal('show');
		$("#formprintsellingbill #selling_id").val(id);
		// window.open("sellingbill/"+id);
	}
	
	function printbillselling(){
		// var id = $("#formprintsellingbill #selling_id").val();
		$("#formprintsellingbill").submit();
		// window.open("sellingbill/"+id);
	}
	function printer(){
		setTimeout(function(){window.location.reload();},1000)
		
	}

	function view(id){
		$.post("{{url('selling/getdatafile')}}", {'id': id,'_token': "{{ csrf_token() }}"}, function(data, textStatus, xhr) {
			var txt = '';
			data.forEach(function(index, el) {
				txt += '<tr>';
				// txt += '<td>'+index.billingnoteimage_name+'</td>';
				// txt += '<td>'+index.billingnoteimage_date+'</td>';
				// if(index.billingnoteimage_type == '1'){
				// 	txt += '<td>ไฟล์ข้อมูลการชำระเงิน</td>';
				// }else{
				// 	txt += '<td>ไฟล์ข้อมูลการหักเงิน</td>';
				// }
				
				txt += '<td>'+index.upfiletransportforselling_file+'</td>';
				txt += '<td>'+index.created_at+'</td>';
				// txt += '<td><article><img alt="'+index.billingnoteimage_name+'" class="Lightbox" style="width:100px;height:100px;" src="{{asset('assets/images/billingnote/')}}/'+index.billingnoteimage_name+'"></article></td>';
				// txt += '<td><div class=""><a class="fancybox" href="{{asset('assets/images/billingnote/')}}/'+index.billingnoteimage_name+'" title="Image Caption">เปิด</a></div></td>';
				txt += '<td><div class=""><a class="fancybox" href="{{asset('assets/images/uploadtransport')}}/'+index.upfiletransportforselling_file+'" style="width:500px;">เปิด</a></div></td>';
				txt += '<tr>';
			});
			$("#showdatafile").empty().append(txt);
			$("#showfile").modal('show');
			// $("article").AutoLightbox({
			// 	// width: 500,
			// 	// height: 300,
			// 	dimBackground: false
			// });
			// $('.example').Chocolat({
			// 	loop           : false,
			// 	// fullWindow     : 'cover',
			// 	overlayOpacity : 0.1,
			// 	enableZoom     :true,
			// 	fullScreen        :false,

			// });
			$(".fancybox").fancybox({
				// openEffect: "none",
				// closeEffect: "none",
				type   :'iframe',
				titleShow:false,
				centerOnScroll:true,
				// width:'80%',
				// height:420,
				scrolling:'auto',
				fullScreenApi:true,
				iframe:true,

			});
		});
		
	}

	function btnupfile(id,customerid){
		$("#uploadfile #sellingid").val(id);
		$("#uploadfile").modal('show');
		$.post("{{url('selling/getdestination')}}", {id:id,customerid: customerid,'_token': "{{ csrf_token() }}"}, function(data, textStatus, xhr) {
			// console.log(data)
			$("#uploadfile #transportid").val(data.tran.sub_ref);
			var optiontxt = '<option value=""> - </option>';
			$.each(data.data,function(key,item){
				optiontxt += '<option value="'+item.destination_id+'"> '+item.destination_name+' </option>'
			});
			$("#destination").empty().append(optiontxt);
			
		});
	}

	$('#myformuploadfileselling').on('submit', function(e) {
        e.preventDefault(); 
        var formData = new FormData(this); // value total in form
        $.ajax({    
           	url:"{{url('uploadfileforselling')}}",
           	data:formData,
           	type:"POST",
           	async: false,
           	contentType: false,
           	processData: false,
           	success:function(data){
                if(data==true){
                	var sellingid = $("#sellingid").val();
                    Lobibox.notify('success',{
						msg: 'บันทึกเรียบร้อย',
						buttonsAlign: 'center',
						closeOnEsc: true,  
					});
					$("#myformuploadfileselling")[0].reset();
					$("#btncancel"+sellingid).prop('disabled',true);
					$("#uploadfile").modal('hide');
                }else if(data==false){
                    Lobibox.notify('warning',{
						msg: 'เกิดข้อผิดพลาด!',
						buttonsAlign: 'center',
						closeOnEsc: true,  
					});
                }else{
                    Lobibox.notify('error',{
						msg: 'เกิดข้อผิดพลาด!',
						buttonsAlign: 'center',
						closeOnEsc: true,  
					}); 
                }       
            },
            error:function(){
                Lobibox.notify('error',{
					msg: 'เกิดข้อผิดพลาด!',
					buttonsAlign: 'center',
					closeOnEsc: true,  
				}); 
            },
        });
    });

    function calceldel(id){
		bootbox.confirm({
			title: "ยืนยัน?",
			message: "คุณต้องการยกเลิกรายการที่ยกเลิกก่อนหน้านี้ หรือไม่?",
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
					window.location.href="selling/editcancel/"+id+"";
				}
			}
		});
	}

</script>
@stop