@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- <div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Supplier
				</h4>
			</div>

		</div>
	</div>-->
	<!-- /page header -->
	<style type="text/css">
		.classsupplier{
			background: rgb(199,199,199,0.3);
		}
		.importsuccess{
			/*background: green;*/
			padding: 2px 5px;
		    border: 1px solid;
		    font-size: 0.5rem;
		    border-radius: 7px;
		    vertical-align:middle;
		    border-style: none;
		    /*color: #ffffff;*/
		    display: inline-block;
		    position: relative;
		    background-color: #58D68D ;

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
							
							
							<table class="table" id="datatables">
								<thead>
									<tr>
										<th class="text-center" width="8%">ลำดับ</th>
										<th class="text-center" width="10%">เลขที่ออเดอร์</th>
										<th class="text-center" width="15%">ชื่อลูกค้า</th>
										<th class="text-center" width="15%">ซัพพลายเออร์</th>
										<th class="text-center" width="20%">ชื่อสินค้า</th>
										<th class="text-center" width="12%">จำนวนที่ต้องการ</th>
										<th class="text-center" width="12%">จำนวนที่ขาด</th>
										<th class="text-center" width="10%">จำนวนที่มี</th>
										<th class="text-center" width="10%">ผู้อัพเดท</th>
										<th class="text-center" width="10%">หน่วย</th>
										<th class="text-center" width="7%">#</th>
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
<script>
	function formatNumber (x) {
		return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	var oTable;
	$(document).ready(function(){
		oTable = $('#datatables').DataTable({
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: false,
			ajax:{ 
				url : "{{url('detailorderhnotproductdatatables')}}",
			},
			columns: [
				{ 'className': "text-center", data: 'alertordernoproduct_id', name: 'alertordernoproduct_id' },
				{ data: 'export_inv', name: 'export.export_inv' },
				{ 'className': "text-center", data: 'export_customername', name: 'export.export_customername' },
				{ 'className': "text-center", data: 'export_empname', name: 'export.export_empname' },
				{ 'className': "text-center", data: 'product_name', name: 'product.product_name' },
				{ 'className': "text-center", data: 'alertordernoproduct_want', name: 'alertordernoproduct_want' },
				{ 'className': "text-center", data: 'alertordernoproduct_balance', name: 'alertordernoproduct_balance' },
				{ 'className': "text-center", data: 'alertordernoproduct_qty', name: 'alertordernoproduct_qty' },
				{ 'className': "text-center", data: 'alertordernoproduct_qty', name: 'alertordernoproduct_qty' },
				{ 'className': "text-center", data: 'unitname', name: 'unitname' },
				{ 'className': "text-center", data: 'alertordernoproduct_status', name: 'alertordernoproduct_status' },
			],
			order: [[8, 'ASC'],[0, 'ASC']],
			rowCallback: function(row,data,index ){
				$('td:eq(0)', row).html( parseInt(row)+1 );
				var disabldebtn = '';
				$('td:eq(8)', row).html('');
				if(data['alertordernoproduct_status'] == '2'){
					// $(row).addClass('importsuccess');
					$('td:eq(4)', row).append('&nbsp;&nbsp;&nbsp;<span class="importsuccess">สั่งแล้ว</span>');
					disabldebtn = "disabled";
					// $('td:eq(5)', row).remove();
					// $('td:eq(6)', row).remove();
					// $('td:eq(6)', row).attr('colspan', '2').html(data['alertordernoproduct_userupdate']+' ( '+data['updatedata']+' )');
					$('td:eq(8)', row).html(data['alertordernoproduct_userupdate']+' ( '+data['updatedata']+' )');
					
				}
				$('td:eq(10)', row).html( '<button '+disabldebtn+' onclick="approve(this.value)" value="'+data['alertordernoproduct_id']+'" type="button" class="btn btn-primary"><i class="icon-box-add text-left"></i></button>' );
				
                /*<a href="supplier/product/'+data['supplier_id']+'" class="btn btn-info btn-rounded"><i class="icon-display4"></i> รายการสินค้า</a>*/
			}
		});
		
		oTable.on( 'order.dt search.dt', function(){
			oTable.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell, i){
				cell.innerHTML = i+1;
			} );
		}).draw();
	});

	function approve(id){
		bootbox.confirm({
			title: "ยืนยัน?",
			message: "คุณต้องอีพเดทว่าสั่งสินค้านี้แล้ว หรือไม่?",
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
					$.get('{{url('detailorderhnotproduct/approve')}}/'+id, function(data) {
						oTable.draw( false );
					});
					// window.location.href="detailorderhnotproduct/approve/"+id+"";
					
				}
			}
		});
		
	}

</script>
@stop