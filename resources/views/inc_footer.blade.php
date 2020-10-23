				<!-- Footer -->
				<div class="footer text-muted">
					&copy; 2018. <a href="https://www.orange-thailand.com" target="_blank">Orange Technology Solution</a>
				</div>
				<!-- /footer -->

			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->
		<div class="modal fade" id="myModalshowlastorder" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">ข้อมูลออเดอร์ที่ยังไม่ได้ทำรายการ</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" style="max-height: 400px;overflow: auto;">
						<table class="table">
							<thead>
								<tr>
									<th>เลขที่ออเดอร์</th>
									<th>วันที่</th>
									<th>ลูกค้า</th>
									{{-- <th>พนักงาน</th> --}}
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default waves-effect " data-dismiss="modal">ปิด</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /page content -->

</div>
<!-- /page container -->

<div class="flash-message">
	@if(Session::has('alert-insert'))
		<button type="button" id="miniSuccessTitle_insert" class="btn btn-raised btn-success miniSuccessTitle" style="display:none"></button>
	@elseif(Session::has('alert-update'))
		<button type="button" id="miniSuccessTitle_update" class="btn btn-raised btn-success miniSuccessTitle" style="display:none"></button>
	@elseif(Session::has('alert-approve'))
		<button type="button" id="miniSuccessTitle_approve" class="btn btn-raised btn-success miniSuccessTitle" style="display:none"></button>
	@elseif(Session::has('alert-delete'))
		<button type="button" id="miniSuccessTitle_delete" class="btn btn-raised btn-success miniSuccessTitle" style="display:none"></button>
	@endif
</div>
<script>
	$(document).ready(function(){
		$( ".miniSuccessTitle:first" ).trigger( "click" );
		
		$('.number').keypress(function(event) {
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
		});
		$("input[type='number']").attr('inputmode','numeric');
		$.get('{{ url("showlastsellingorder") }}', function(data) {
			// console.log(data);
			// datas = parseJSON(data);
			var dataselling = data.selling;
			console.log(data)
			if(dataselling.length > 0){
				var txt = '';
				for (var i = 0; i < dataselling.length ; i++) {
					// console.log(data[i]);
					txt += '<tr>';
					txt += '<td>'+dataselling[i].selling_inv+'</td>';
					txt += '<td>'+dataselling[i].selling_date+'</td>';
					txt += '<td>'+dataselling[i].selling_empname+'</td>';
					// txt += '<td>'+data[i].selling_customername+'</td>';
					txt += '</tr>';
				}
				$("#myModalshowlastorder .table tbody").append(txt);
				$("#myModalshowlastorder").modal('show');
			}
			var orderalert = data.orderalert;
			if(orderalert.length > 0){
				$('.showalerts').addClass('showalert');
				$('.showdatas').addClass('showdata');
				$('.showdata').html(orderalert.length);
			}
			//uploadslip
			var uploadslip = data.uploadslip;
			console.log(uploadslip.length);
			if(uploadslip.length > 0){
				$('.showalertuploads').addClass('showalertupload');
				$('.showalertuploaddatas').addClass('showalertuploaddata');
				$('.showalertuploaddata').html(uploadslip.length);

			}
		});
	});
	function notkeystr(){
		$('.number').keypress(function(event) {
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
		});
	}
</script>