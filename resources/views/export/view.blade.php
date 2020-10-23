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
		.classexport{
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
										<li><a data-action="move" onclick="newpage();"></a></li>
										<li><a data-action="close"></a></li>
									</ul>
								</div>
							</div>
							
							<input type="hidden" name="exportid" value="{{ $export->export_id }}">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6">
										<fieldset>
											<legend class="text-semibold"><i class="icon-stack2"></i> ข้อมูลหลัก</legend>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>เลขที่ออเดอร์ :</label>
														<input type="text" class="form-control" name="invoice" id="invoice" placeholder="เลขที่ใบรับสินค้า" value="{{ $export->export_inv}}" disabled>
													</div>
												</div>

												
											</div>
										
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>วันที่ :</label>
														<div class="input-group">
															<input type="text" name="docdate" id="docdate" placeholder="วันที่" class="form-control" onkeydown="return false;" autocomplete="off" value="{{ $export->export_date}}" disabled>
														</div>
													</div>
												</div>
												
												<div class="col-md-6">
													<div class="form-group">
														<label>พนักงานขาย :</label>
														<div class="input-group">
															<input type="text" name="empsalename" id="empsalename" class="form-control" onkeydown="return false;" autocomplete="off" value="<?php echo Auth::user()->name;?>" disabled>
															<input type="hidden" name="empsaleid" id="empsaleid" class="form-control" onkeydown="return false;" autocomplete="off" value="<?php echo Auth::user()->id;?>" disabled>
														</div>
													</div>
												</div>
											</div>
										</fieldset>
									</div>
									
									<div class="col-md-6">
										<fieldset>
											<legend class="text-semibold"><i class="icon-info22"></i> รายละเอียด ลูกค้า</legend>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>ชื่อลูกค้า :</label>
														<input type="text" class="form-control" name="customername" id="customername" placeholder="ชื่อลูกค้า" autocomplete="new-password" value="{{ $customer->customer_name }}" disabled>
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<label>เลขประจำตัวผู้เสียภาษีอากร :</label>
														<input type="text" class="form-control" name="customertax" id="customertax" placeholder="เลขประจำตัวผู้เสียภาษีอากร" autocomplete="off" value="{{ $customer->customer_idtax }}" disabled>
													</div>
													<input type="hidden" name="customerid" id="customerid" value="{{ $customer->customer_id }}" disabled>
												</div>
											</div>

											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label>ที่อยู่ :</label>
														<textarea name="customeraddr" id="customeraddr" rows="2" class="form-control" placeholder="ที่อยู่" disabled>{{ $customer->location }}</textarea>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>เบอร์โทรศัพท์ :</label>
														<input type="text" class="form-control number" name="customercontel" id="customercontel" placeholder="เบอร์โทรศัพท์" value="{{ $customer->customer_tel }}" disabled>
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label>หมายเหตุ :</label>
														<textarea name="note" id="note" rows="2" class="form-control" placeholder="หมายเหตุ" disabled>{{ $customer->customer_note }}</textarea>
													</div>
												</div>
											</div>
										</fieldset>
									</div>
						
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<!-- Basic layout-->
										<div class="panel panel-flat">
											<div class="panel-heading">
												<h5 class="panel-title">รายการออเดอร์</h5>
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
														<br><br>
														<div class="table-responsive">
															<table id="myTable" class="table table-framed">
																<thead>
																	<tr>
																		<th class="text-center">รหัสสินค้า</th>
																		<th class="text-center">รายการสินค้า</th>
																		<th class="text-center">จำนวน</th>
																		<th class="text-center" style="width:150px;">หน่วยนับ</th>
																		<th class="text-center" style="width:100px;">ราคาขาย</th>
																		<th class="text-center">รวม</th>
																	</tr>
																</thead>
																<tbody id="rowdata">
																	@if(!empty($order))
																		@foreach($order as $key => $dataorder)
																		<tr class="rowproduct" id="row{{ $dataorder->product_id }}">
																			<td align="center">{{ $dataorder->product_code }}</td>
																			<td>{{ $dataorder->product_name }}</td>
																			<td align="center">{{ $dataorder->order_qty }}</td>
																			<td align="center">
																				{{-- {{ $dataorder->unit_name }} --}}
																				<select class="form-control" id="unit{{ $dataorder->product_id }}" onchange="changeunit(this)" name="unit[]" required style="width:150px;">
																				@if(count($dataorder->unitdata) > 0)
																				@foreach($dataorder->unitdata as $item2)
																				
																					<option value="1,{{$item2->unit_unitfirst}}" @if($dataorder->order_unit == $item2->unit_unitfirst && $dataorder->order_typeunit == 1) selected @else hidden @endif>{{$item2->unit_name}}</option>
																					<option value="2,{{$item2->unit_unitsec}}" @if($dataorder->order_unit == $item2->unit_unitsec && $dataorder->order_typeunit == 2) selected @else hidden @endif>{{$item2->unitsub_name}}</option>

																				@endforeach
																				@else
																				<option value="1,{{$dataorder->order_unit}}" selected>{{$dataorder->unit_name}}</option>
																				@endif

																				</select>
																			</td>
																			<td align="right">{{ $dataorder->order_price }}</td>
																			
																			<td align="right"><span id="totalprosp{{ $dataorder->product_id }}">{{ $dataorder->order_total }}</span></td>
																		</tr>
																		@endforeach
																	@endif
																</tbody>
															</table>
														</div>
													</div>
												</div>
												<br><br>
												<div class="row">
													<div class="col-md-12">
														<div class="col-md-4"></div>
														<div class="col-md-4"></div>
														<div class="col-md-4">
															<div class="form-group">
																<label class="control-label col-md-4" style="top:8px;"><b>มูลค่า</b></label>
																<div class="col-md-8">
																	<input type="text" id="sumtotalsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{ $export->export_total }}" autocomplete="off">
																	<input type="hidden" class="form-control" name="sumtotal" id="sumtotal" readonly value="{{ $export->export_total }}">
																</div>
															</div>
														</div>
													</div>
												</div>
												<br>
												<div class="row" style="display: none">
													<div class="">
														<div class="col-md-12">
															<div class="col-md-4"></div>
															<div class="col-md-4">
																<div class="form-group">
																	<label class="control-label col-md-4">ส่วนลด</label>
																	<div class="col-md-8">
																		<?php 
																			$discount = array(5,10,15,20,25,30);
																		?>
																		<select name="discount" id="discount" class="form-control">
																			<option value="0">ไม่มีส่วนลด</option>
																			<?php
																				foreach($discount as $dis){
																					echo '<option value="'.$dis.'">'.$dis.' %</option>';
																				}
																			?>
																		</select>
																	</div>
																</div>
															</div>
															
															<div class="col-md-4">
																<div class="form-group">
																	<label class="control-label col-md-4"><span id="fontdis"></span></label>
																	<div class="col-md-8">
																		<input type="text" id="sumdiscountsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{ $export->export_discountsum }}" autocomplete="off">
																		<input type="hidden" class="form-control" name="sumdiscount" id="sumdiscount" value="{{ $export->export_discountsum }}" readonly>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<br>
												<div class="row" style="display: none">
													<div class="">
														<div class="col-md-12">
															<div class="col-md-4"></div>
															<div class="col-md-4">
																<div class="form-group">
																	<label class="control-label col-md-4">ภาษี</label>
																	<div class="col-md-8">
																		<div class="radio">
																			<label>
																				<input type="radio" class="styled vat" name="vat" id="vat1" value="0" checked="checked">No Vat
																			</label>
																		</div>
																		<div class="radio">
																			<label>
																				<input type="radio" class="styled vat" name="vat" id="vat2" value="1">Exclude Vat
																			</label>
																		</div>
																		<div class="radio">
																			<label>
																				<input type="radio" class="styled vat" name="vat" id="vat3" value="2">Include Vat
																			</label>
																		</div>
																	</div>
																</div>
															</div>
															
															<div class="col-md-4">
																<div class="form-group">
																	<label class="control-label col-md-4"><span id="fontvat"><strong>ภาษีมูลค่าเพิ่ม</strong></span></label>
																	<div class="col-md-8">
																		<input type="text" id="sumvatsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{ $export->export_vat }}" autocomplete="off">
																		<input type="hidden" class="form-control" name="sumvat" id="sumvat" value="{{ $export->export_vat }}" readonly>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<br>
												<div class="row" style="display: none">
													<div class="">
														<div class="col-md-12">
															<div class="col-md-4"></div>
															<div class="col-md-4">
																<div class="form-group">
																	<label class="control-label col-md-4">การชำระเงิน</label>
																	<div class="col-md-8">
																		<?php 
																			$payment = array('เงินสด','เครดิต','เครดิต 15 วัน','เครดิต 30 วัน');
																		?>
																		<select name="payment" id="payment" class="form-control">
																			<?php
																				foreach($payment as $pay){
																					echo '<option value="'.$pay.'">'.$pay.'</option>';
																				}
																			?>
																		</select>
																	</div>
																</div>
															</div>
															
															<div class="col-md-4">
																<div class="form-group">
																	<label class="control-label col-md-4"><span><strong>รวมทั้งสิ้น</strong></span></label>
																	<div class="col-md-8">
																		<input type="text" id="sumpaymentsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{ $export->export_totalall }}" autocomplete="off">
																		<input type="hidden" class="form-control" name="sumpayment" id="sumpayment" value="{{ $export->export_totalall }}" readonly>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<br>
												<div class="row" style="display: none">
													<div class="">
														<div class="col-md-12">
															<div class="col-md-4"></div>
															<div class="col-md-4">
																<div class="form-group">
																	<label class="control-label col-md-4">ส่วนลดท้ายบิล</label>
																	<div class="col-md-8">
																		<input type="text" class="form-control number" name="discountlastbill" id="discountlastbill">
																	</div>
																</div>
															</div>
															
															<div class="col-md-4">
																<div class="form-group">
																	<label class="control-label col-md-4"><span><strong><font color="green">ยอดชำระ</font></strong></span></label>
																	<div class="col-md-8">
																		<input type="text" id="sumtotalallsp" class="form-control summary-box textshow" onkeydown="return false;" value="{{ $export->export_totalpayment }}" autocomplete="off">
																		<input type="hidden" class="form-control" name="sumtotalall" id="sumtotalall" value="{{ $export->export_totalpayment }}" readonly>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<br>
												<div class="text-right">
													<a href="{{url('export')}}"><button type="button" class="btn btn-danger"><i class="icon-rotate-ccw3"></i>  ยกเลิก</button></a>
												</div>
											</div>
										</div>
									<!-- /basic layout -->
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /main content -->

			</div>
		<!-- /page content -->
		</div>
	</div>
	<!-- /page container -->
	
	
<style>
	.textshow{
		font-size:18px;
		border: none;
		text-align: right;
		margin-bottom: 8px;
	}
</style>

@stop