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
												<table id="myTable" class="table table-bordered">
													<thead>
														<tr>
															<th class="text-center">ลำดับ</th>
															<th class="text-center">เลขที่ออเดอร์</th>
															<th class="text-center">วันที่</th>
															<th class="text-center">สถานะ</th>
															<th class="text-center">รวม</th>
														</tr>
													</thead>
													<tbody id="rowdata">
														@foreach($data as $key => $value)
															<tr class="rowbody">
																<td align="center">{{ $key+1 }}</td>
																<td align="center">{{ $value -> selling_inv }}</td>
																<td align="center">{{ $value -> selling_date }}</td>
																<td align="center">{{ ($value -> selling_status == '7'?'ยังไม่ชำระเงิน':'ชำระเรียบร้อย') }}</td>
																<td align="center">{{ $value -> selling_totalpayment }}</td>
															</tr>
														@endforeach
													</tbody>
													<tfoot id="rowfoot">
														<tr class="rowfoot">
															<td colspan="3"></td>
															<td>รวมทั้งหมด</td>
															<td align="right">0</td>
														</tr>
														<tr class="rowfoot">
															<td colspan="3"></td>
															<td>ชำระแล้ว</td>
															<td align="right">{{ $data[0] -> billingnote_pay}}</td>
														</tr>
														<tr class="rowfoot">
															<td colspan="3"></td>
															<td>คงเหลือ</td>
															<td align="right">{{ $data[0] -> billingnote_balance}}</td>
														</tr>
													</tfoot>
												</table>
											</div>
										</div>
									</div>
								</div>
								<!-- /basic layout -->
								<div class="panel panel-flat">
									<div class="panel-heading">
										<h5 class="panel-title">รายละเอียดการชำระเงิน</h5>
									</div>
									<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
												<table id="myTable" class="table table-bordered">
													<thead>
														<tr>
															<th class="text-center">ลำดับ</th>
															<th class="text-center">วันที่</th>
															<th class="text-center">ยอดก่อนชำระ</th>
															<th class="text-center">จำนวนเงิน</th>
															<th class="text-center">คงเหลือ</th>
														</tr>
													</thead>
													<tbody id="rowdata">
														
														@if(count($datapay) == 0)
															<tr id="firstauto">
																<td colspan="5" align="center">-- No data --</td>
															</tr>
														@elseif(!empty($datapay))
															@foreach($datapay as $key => $value)
															<tr class="rowbody">
																<td align="center">{{ $key+1 }}</td>
																<td align="center">{{ $value -> billingnotepay_date }}</td>
																<td align="center">{{ $value -> billingnotepay_oldbalance }}</td>
																<td align="center">{{ $value -> billingnotepay_money }}</td>
																<td align="center">{{ $value -> billingnotepay_balance-$value ->billingnotepay_discount }}</td>
															</tr>
															@endforeach
														@endif
													</tbody>
													
												</table>
											</div>
										</div>
									</div>
								</div>

								<div class="panel panel-flat">
									<div class="panel-heading">
										<h5 class="panel-title">ข้อมูลไฟล์</h5>
									</div>
									<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
												<table id="myTable" class="table table-bordered">
													<thead>
														<tr>
															<th class="text-center">ลำดับ</th>
															<th class="text-center">วันที่</th>
															<th class="text-center">รูป</th>
															{{-- <th class="text-center">สถานะ</th> --}}
														</tr>
													</thead>
													<tbody id="rowdata">
														@if(count($datafile) == 0)
															<tr class="rowbody">
																<td colspan="3" align="center">-- No data --</td>
															</tr>
														@elseif(!empty($datafile))
															@foreach($datafile as $key => $value2)
															<tr class="rowbody">
																<td align="center">{{ $key+1 }}</td>
																<td align="center">{{ $value2 -> billingnoteimage_date }}</td>
																@php
																$expload = explode('.', $value2->billingnoteimage_name);
																@endphp
																@if(in_array('pdf',$expload))
																<td align="center"><embed width="200px" height="200px" src="{{ asset('assets/images/billingnote') }}/{{ $value2 -> billingnoteimage_name }}"></td>
																@else
																<td align="center"><img style="width: 200px;height: 200px;" src="{{ asset('assets/images/billingnote') }}/{{ $value2 -> billingnoteimage_name }}"></td>
																@endif
																{{-- <td align="center">{{ $value2 -> billingnoteimage_status }}</td> --}}
															</tr>
															@endforeach
														@endif
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
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
<script>
</script>
@stop