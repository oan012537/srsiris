@extends('../template')

@section('content')
	<!-- Page header -->
	<!-- <div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4>
					<i class="icon-arrow-left52 position-left"></i>
					<span class="text-semibold">Home</span> - Product
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
							
							<div class="panel-body">
								<form class="form-horizontal" action="#">
									<div class="form-group">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-md-2">
													<div class="form-group">
														<select name="category" id="category" class="select">
															<option value="">ทั้งหมด</option>
															<?php
																if($category){
																	foreach($category as $cate){
																		echo '<option value="'.$cate->category_id.'">'.$cate->category_name.'</option>';
																	}
																}
															?>
														</select>
													</div>
												</div>

												<div class="col-md-2">
													<div class="form-group">
														<input type="text" name="keyword" id="keyword" class="form-control" placeholder="ค้นหาชื่อสินค้า">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<input type="text" name="product_code" id="product_code" class="form-control" placeholder="ค้นหารหัสสินค้า">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<input type="text" name="product_exp" id="product_exp" class="form-control datepicker-dates" placeholder="วันที่สินค้าหมดอายุ">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<button type="button" id="searchdata" class="btn btn-primary"><i class="icon-folder-search"></i> ค้นหา</button>
													</div>
												</div>
												@if(Auth::user()->actionadd != '')
												<div class="pull-right">
													<a href="{{url('product-create')}}"><button type="button" class="btn btn-primary btn-lg"><i class="icon-plus-circle2"></i> เพิ่มสินค้า</button></a>
												</div>
												@endif
											</div>
										</div>
									</div>
								</form>
							</div>
							
							<div class="table-responsive">
								<table class="table table-bordered" id="datatables">
									<thead>
										<tr>
											<th class="text-center" width="5%">ลำดับ</th>
											<th class="text-center" width="20%">รหัสสินค้า</th>
											<th class="text-center" width="30%">สินค้า</th>
											<th class="text-center" width="10%">ราคาขาย</th>
											<th class="text-center" width="10%">ราคาซื้อ</th>
											<th class="text-center" width="15%">จำนวน</th>
											<th class="text-center" width="10%">หน่วย</th>
											<th class="text-center" width="15%">วันที่อัพเดท</th>
											<th class="text-center" width="10%">#</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
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
<div class="modal inmodal" id="stock" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" style="width:70%">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-center">สต๊อกสินค้า</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">ราคา</th>
                            <th class="text-center">จำนวน</th>
                            {{-- <th class="text-center">ไซส์</th> --}}
                        </tr>
                    </thead>
                    <tbody id="alllist">
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal" >ปิด</button>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal" id="import" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" style="width:70%">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-center">นำเข้าสินค้า</h4>
            </div>
            <form id="myForm" method="post" action="{{url('product/imports_create')}}">
                <div class="modal-body">
				    {{ csrf_field() }}
                    <input type="hidden" name="proid">
                    <input type="hidden" name="userid" value="{{Auth::user()->id}}">
                    <input type="hidden" name="suppliername">
                    <!-- <div class="row" style="margin-top:1%">
                        <label class="control-label col-sm-2 col-xs-12">ชื่อซัพพลายเออร์ :</label>
                        <div class="col-sm-10 col-xs-12">
                            <select name="supplier" class="form-control" required onchange="changename(this)">
                                <option value="">-- เลือก ซัพพลายเออร์ --</option> --}}
                                <?php
                                    //if($supplier){
                                        //foreach($supplier as $val){
                                            //echo '<option value="'.$val->supplier_id.'">'.$val->supplier_name.'</option>';
                                        //}
                                    //}
                                ?>
                            </select>
                        </div>
                    </div> -->
                    {{-- <div class="row" style="margin-top:1%">
                        <label class="control-label col-sm-2 col-xs-12">ไซส์ :</label>
                        <div class="col-sm-10 col-xs-12">
                            <input type="text" class="form-control" name="size" required>
                        </div>
                    </div> --}}
                    <div class="row" style="margin-top:1%">
                        <label class="control-label col-sm-2 col-xs-12">จำนวนที่นำเข้า :</label>
                        <div class="col-sm-10 col-xs-12">
                            <input type="number" class="form-control" name="qty" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top:1%">
                        <label class="control-label col-sm-2 col-xs-12">หน่วยนับ :</label>
                        <div class="col-sm-10 col-xs-12">
                            <select class="form-control" name="unit" required>
                                <option value="">-- เลือกหน่วยนับ --</option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="row" style="margin-top:1%">
                        <label class="control-label col-sm-2 col-xs-12">ราคาทุน :</label>
                        <div class="col-sm-10 col-xs-12">
                            <input type="number" class="form-control" name="capital" required>
                        </div>
                    </div> --}}
                    {{-- <div class="row" style="margin-top:1%">
                        <label class="control-label col-sm-2 col-xs-12">ราคาขาย :</label>
                        <div class="col-sm-10 col-xs-12">
                            <input type="number" class="form-control" name="cost" required>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer" style="margin-top:3%">
                    <button type="button" class="btn btn-primary" onclick="addimport();">บันทึก</button>
                    <button type="button" class="btn btn-white" data-dismiss="modal" >ปิด</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal inmodal" id="history" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" style="width:70%">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-center">ประวัติสต๊อกสินค้า</h4>
            </div>
            <div class="modal-body">
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> การนำเข้าสินค้า</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-2"> การขายสินค้า</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-3"> การนำออกสินค้า</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="tab-1" class="tab-pane active">
                            <div class="panel-body table-responsive" id="importdata">
                                
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-2" class="tab-pane">
                            <div class="panel-body table-responsive" id="saledata">
                               
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-3" class="tab-pane">
                            <div class="panel-body table-responsive" id="exportdata">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="margin-top:3%">
                <button type="button" class="btn btn-white" data-dismiss="modal" >ปิด</button>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal" id="printbarcode" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" style="width:70%">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-center">พิมพ์บาร์โค้ด</h4>
            </div>
            <div class="modal-body">
                <div class="row">
					<div class="col-md-6 col-md-6 col-md-offset-3">
						<fieldset>
							<legend class="text-semibold">รายละเอียดสินค้า</legend>
							<form method="post" action="{{url('product-barcode')}}" enctype="multipart/form-data" id="formgenbarcode" target="_blank">
							{{ csrf_field() }}
								<div class="form-group">
									<label>รหัสสินค้า :</label>
									<input type="text" class="form-control" name="productcode" id="productcode" placeholder="รหัสบาร์โค้ด" required>
									<input type="hidden" name="productid" id="productid">
								</div>
								<div class="form-group">
									<label>กว้าง :</label>
									<input type="text" class="form-control" name="width" id="width" placeholder="Width" required>
								</div>
								<div class="form-group">
									<label>ยาว :</label>
									<input type="text" class="form-control" name="height" id="height" placeholder="Height" required>
								</div>
							</form>
						</fieldset>
					</div>
				</div>
            </div>
            <div class="modal-footer" style="margin-top:3%">
                <button type="submit" form="formgenbarcode" class="btn btn-primary"  >พิมพ์</button>
                <button type="button" class="btn btn-white" data-dismiss="modal" >ปิด</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="cate" value="{{$cates}}">
<input type="hidden" id="subcate" value="{{$subcate}}">
<script>
	function formatNumber (x) {
		return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	var oTable = '';
	$(document).ready(function(){
        
		oTable = $('#datatables').DataTable({
			processing: true,
			serverSide: true,
			searching: false,
			lengthChange: false,
			ajax:{ 
				url : "{{url('productdatatables')}}",
				data: function (d) {
					d.cate = $('#cate').val();
					d.subcate = $('#subcate').val();
					d.category = $('#category').val();
					d.keyword = $('#keyword').val();
					d.product_code = $('#product_code').val();
					d.product_exp = $('#product_exp').val();
				},
			},
			columns: [
				{ 'className': "text-center", data: 'product_id', name: 'product_id' },
				{ data: 'product_code', name: 'product_code' },
				{ data: 'product_name', name: 'product_name' },
				{ 'className': "text-center", data: 'product_retail', name: 'product_retail' },
				{ 'className': "text-center", data: 'product_buy', name: 'product_buy' },
				{ 'className': "text-center", data: 'product_qty', name: 'product_qty' },
				{ 'className': "text-center", data: 'unitname', name: 'unitname' },
				{ 'className': "text-center", data: 'updated_at', name: 'updated_at' },
				{ 'className': "text-center", data: 'created_at', name: 'created_at' },
			],
			order: [[0, 'asc']],
			rowCallback: function(row,data,index ){
				var qty = data['qty'];
				var min = data['min'];
				
				// min = min.replace(',','');
				console.log(qty);
				if(parseFloat(qty) < parseFloat(min)){
					$('td:eq(0)', row).addClass('bg-danger');
					$('td:eq(1)', row).addClass('bg-danger');
					$('td:eq(2)', row).addClass('bg-danger');
					$('td:eq(3)', row).addClass('bg-danger');
					$('td:eq(4)', row).addClass('bg-danger');
					$('td:eq(5)', row).addClass('bg-danger');
					$('td:eq(6)', row).addClass('bg-danger');
				}
				
                var amount = $('td:eq(5)',row).text();
                var btndel = '';
                var permissiondel = "{{Auth::user()->actiondelete}}";
                var permissionedit = "{{Auth::user()->actionedit}}";
                if({{Auth::user()->position}} != '1'){
                	btndel = '';
                }
                if( permissiondel != ''){
                	btndel = '<i class="icon-trash" onclick="del('+data['product_id']+');" data-popup="tooltip" title="Delete"></i> <i class="icon-import" onclick="showaddstock('+data['product_id']+');" data-popup="tooltip" title="เอาสินค้าเข้า"></i>';
                }
                var btnedit = '';
                if(permissionedit !=''){
                	btnedit = ' <a href="{{url("product-update")}}/'+data['product_id']+'"><i class="icon-pencil7" data-popup="tooltip" title="Update"></i></a>';
                }
                $('td:eq(5)',row).html('<a href="javascript:;" onclick="showstock('+data['product_id']+')">'+amount+'</a>');
				$('td:eq(7)', row).html( '<i class="icon-barcode2" data-popup="tooltip" title="Barcode"  onclick="genbarcode('+data['product_id']+');"></i> '+ btnedit +btndel+' &nbsp;' );
			}
		});
		$('#datatables tbody').on( 'click', 'tr', function () {
			oTable.$('tr.selectedx').removeClass('selectedx');
            $(this).addClass('selectedx');
		});
		
		// oTable.on( 'order.dt search.dt', function(){
		// 	oTable.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell, i){
		// 		cell.innerHTML = i+1;
		// 	} );
		// }).draw();
		
		$('#searchdata').click(function(e){
			oTable.draw();
			e.preventDefault();
		});
	});

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
					// window.location.href="product-delete/"+id+"";
					
					$.get("{{url('product-cancel')}}/"+id, function(data) {
						if(data == 'Y'){
							Lobibox.notify('error',{
								title:'Successfully',
								msg: 'Data has been delete to database successfully.',
								buttonsAlign: 'center',
								closeOnEsc: true,  
							});
							oTable.row('.selectedx').remove().draw( false );
						}else{
							Lobibox.notify('warning',{
								msg: 'ไม่สามารถลบข้อมูลได้เนื่องจากมีข้อมูลอยู่ในการขาย',
								buttonsAlign: 'center',
								closeOnEsc: true,  
							});
						}
						
					});
				}
			}
		});
	}
    
    function showstock(id){
        $.get('{!! url("findstock") !!}',{'id':id},function(data){
            var row = '';
            $(data).each(function(index,val){
                row+='<tr>';
                row+='<td class="text-center">'+val['sale']+'</td>';
                row+='<td class="text-center">'+val['amt']+'</td>';
                // row+='<td class="text-center">'+val['size']+'</td>';
                row+='</tr>';
            });
            $('#alllist').html(row);
            $('#stock').modal('show');
        });
    }
    
    function showaddstock(id){
        $('input[name="proid"]').val(id);
        $('#import').modal('show');
        $.get("{!! url('product/findunit') !!}",{'id':id},function(data){
            $('select[name="unit"]').html(data);
        });
    }
    
    function showhistory(id){
        $.get("{!! url('product/hisimport') !!}",{'id':id},function(impdata){
            $('#importdata').html(impdata);
        });
        
        $.get("{!! url('product/hissale') !!}",{'id':id},function(saledata){
            $('#saledata').html(saledata);
        });
        
        $.get("{!! url('product/hisexport') !!}",{'id':id},function(exportdata){
            $('#exportdata').html(exportdata);
        });
        
        $('#history').modal('show');
    }
    function genbarcode(id){
    	window.open('getbarcode/'+id);
    	// $.ajax({
    	// 	url : "{{url('getbarcode')}}/"+id,
    	// 	dataType:'json',
    	// 	success:function(data){
    	// 		if(data.product_barcode != ''){
    	// 			$("#productcode").val(data.product_barcode);
    	// 			$("#productid").val(data.product_id);
    	// 			$('#printbarcode').modal('show');
    	// 		}else{
    	// 		}

    	// 	}
    	// });
    }
    function genbarcode_(){
    	var productid = $("#productid").val();
    	var width = $("#width").val();
    	var height = $("#height").val();
    	window.open('product-barcode/'+productid+'/'+width+'/'+height);
    }
    function changename(e){
    	var supplier = $("select[name='supplier'] option:selected" ).text();
    	$("input[name='suppliername']").val(supplier);
    }
    function addimport(){
    	// var supplier = $("select[name='supplier']").val();
    	var qty = $("input[name='qty']").val();
    	var unit = $("select[name='unit']").val();
    	// var capital = $("input[name='capital']").val();
   //  	if(supplier == ''){
   //  		$("select[name='supplier']").focus();
   //  		Lobibox.notify('error',{
			// 	msg: 'ไม่สามารถลบข้อมูลได้เนื่องจากใส่ข้อมูลไม่ครบ',
			// 	buttonsAlign: 'center',
			// 	closeOnEsc: true,  
			// });
   //  		return false;
   //  	}else 
    	if(qty == ''){
    		$("select[name='qty']").focus();
    		Lobibox.notify('error',{
				msg: 'ไม่สามารถลบข้อมูลได้เนื่องจากใส่ข้อมูลไม่ครบ',
				buttonsAlign: 'center',
				closeOnEsc: true,  
			});
    		return false;
    	}else if(unit == ''){
    		$("select[name='unit']").focus();
    		Lobibox.notify('error',{
				msg: 'ไม่สามารถลบข้อมูลได้เนื่องจากใส่ข้อมูลไม่ครบ',
				buttonsAlign: 'center',
				closeOnEsc: true,  
			});
    		return false;
   //  	}else if(capital == ''){
   //  		$("select[name='capital']").focus();
   //  		Lobibox.notify('error',{
			// 	msg: 'ไม่สามารถลบข้อมูลได้เนื่องจากใส่ข้อมูลไม่ครบ',
			// 	buttonsAlign: 'center',
			// 	closeOnEsc: true,  
			// });
   //  		return false;
    	}
    	$.post("{{url('product/imports_create')}}", $("#myForm").serialize() , function(data, textStatus, xhr) {
    		$('#import').modal('hide');
    		if(data == "Y"){
    			Lobibox.notify('success',{
					msg: 'Data has been update to database successfully.',
					buttonsAlign: 'center',
					closeOnEsc: true,  
				});
				$("select[name='supplier']").val('');
    			$("input[name='qty']").val('');
    			$("select[name='unit']").val('');
    			$("input[name='capital']").val('');
				oTable.draw( false );
    		}else{
    			Lobibox.notify('warning',{
					msg: 'เกิดข้อผิดพลาดในการนำเข้าสินค้า',
					buttonsAlign: 'center',
					closeOnEsc: true,  
				});
    		}
    	});
    }
</script>
@stop