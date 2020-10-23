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
        .classreport{
            background: rgb(199,199,199,0.3);
        }
        #headdata tr > th{
            min-width: 150px;
            /*max-width: 300px;*/
        }
    </style>

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">
		
			<!-- Main content -->
			<div class="content-wrapper">
                {{-- <form id="myForm" method="post" target="_blank" action="{{url('reportimportpdf')}}"> --}}
                <form id="myForm" method="post" action="{{url('reportcustomer')}}">
                    {{ csrf_field() }}
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
                                    <fieldset>
								        <legend class="text-semibold">
                                           <i class="icon-stack2"></i> รายงานขาย
                                        </legend>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ตั้งแต่วันที่ :</label>
                                                    <input type="text" placeholder="ตั้งแต่วันที่" class="form-control datepicker-dates" name="datestart" id="datestart" value="{{date('Y-m-d')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ถึงวันที่ :</label>
                                                    <input type="text" placeholder="ถึงวันที่" class="form-control datepicker-dates" name="dateend" id="dateend" value="{{date('Y-m-d')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>เลขที่บิล :</label>
                                                    <input type="text" placeholder="เลขที่บิล" class="form-control" name="billno" id="billno" value="">
                                                    {{-- <select class="form-control select2" name="customername" id="customername">
                                                        <option value="" selected>ชื่อ</option>
                                                        @if(!empty($customer))
                                                        @foreach($customer as $item)
                                                            <option value="{{ $item->customer_id}}">{{ $item->customer_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ถึง :</label>
                                                    <input type="text" placeholder="ถึง" class="form-control" name="billnoto" id="billnoto" value="">
                                                    {{-- <select class="form-control select2" name="customernameto" id="customernameto">
                                                        <option value="" selected>ชื่อ</option>
                                                        @if(!empty($customer))
                                                        @foreach($customer as $item)
                                                            <option value="{{ $item->customer_id}}">{{ $item->customer_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>วิธีการชำระเงิน :</label>
                                                    <select class="form-control" name="typepay" id="typepay">
                                                        <option value="">ไม่เลือก</option>
                                                        <option>เงินสด</option>
                                                        <option>โอน</option>
                                                        <option>เช็ค</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>จัดเรียง :</label>
                                                    <select class="form-control" name="typesort" id="typesort">
                                                        <option value="">ไม่เลือก</option>
                                                        <option value="selling_inv">หมวดบิล</option>
                                                        <option value="selling_customerid">ลูกค้า</option>
                                                        <option value="selling_empid">ผู้ขาย</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>
                                                        <div class="pretty p-default">
                                                            <input type="checkbox" name="checkcustomergroup" id="checkcustomergroup" value="กลุ่มลูกค้า" />
                                                            <div class="state p-primary">
                                                                <label>กลุ่มลูกค้า : </label>
                                                            </div>
                                                        </div>
                                                    </label>
                                                    <select class="form-control select2" name="customergroup[]" id="customergroup" multiple="">
                                                        {{-- <option value="" selected>กลุ่มลูกค้า</option> --}}
                                                        @if(!empty($area))
                                                        @foreach($area as $item)
                                                            <option value="{{ $item->area_id}}">{{ $item->area_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>กำหนดชำระ :</label> {{-- >วันที่ลูกค้าต้องชำระในแต่ละบิลครับ จากวันที่เปิดบิลบวกตามเครดิตที่ให้เจ้านั้นๆ --}}
                                                    <input type="text" placeholder="ตั้งแต่วันที่" class="form-control datepicker-dates" name="datestartduepay" id="datestartduepay" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ถึงวันที่ :</label>
                                                    <input type="text" placeholder="ถึงวันที่" class="form-control datepicker-dates" name="dateendduepay" id="dateendduepay" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ชำระล่าสุด :</label> {{-- >บิลไหนของลูกค้าเจ้านั้นชำระไปวันที่เท่า --}}
                                                    <input type="text" placeholder="ชำระล่าสุด" class="form-control datepicker-dates" name="datestartpay" id="datestartpay" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ถึงวันที่ :</label>
                                                    <input type="text" placeholder="ถึงวันที่" class="form-control datepicker-dates" name="dateendpay" id="dateendpay" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>&nbsp;</label><br>
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="send" id="send" value="ส่งของ" />
                                                        <div class="state p-primary">
                                                            <label>ส่งของ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="customer" id="customer" value="ชื่อลูกค้า" />
                                                        <div class="state p-primary">
                                                            <label>ชื่อลูกค้า</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="supplier" id="supplier" value="พนักงานขาย" />
                                                        <div class="state p-primary">
                                                            <label>พนักงานขาย</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="statusbill" id="statusbill" value="สถานะบิล" />
                                                        <div class="state p-primary">
                                                            <label>สถานะบิล</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="address" id="address" value="ที่อยู่" />
                                                        <div class="state p-primary">
                                                            <label>ที่อยู่</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="tel" id="tel" value="เบอร์โทรศัพท์" />
                                                        <div class="state p-primary">
                                                            <label>เบอร์โทรศัพท์</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="amount" id="amount" value="ราคาทั้งหมด" />
                                                        <div class="state p-primary">
                                                            <label>ราคาทั้งหมด</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="tax" id="tax" value="ภาษี" />
                                                        <div class="state p-primary">
                                                            <label>ภาษี</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="discount" id="discount" value="ส่วนลด" />
                                                        <div class="state p-primary">
                                                            <label>ส่วนลด</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="vat" id="vat" value="ภาษีมูลค่าเพิ่ม" />
                                                        <div class="state p-primary">
                                                            <label>ภาษีมูลค่าเพิ่ม</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="totalall" id="totalall" value="รวมทั้งสิ้น" />
                                                        <div class="state p-primary">
                                                            <label>รวมทั้งสิ้น</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="discountbill" id="discountbill" value="ส่วนลดท้ายบิล" />
                                                        <div class="state p-primary">
                                                            <label>ส่วนลดท้ายบิล</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="note" id="note" value="หมายเหตุ" />
                                                        <div class="state p-primary">
                                                            <label>หมายเหตุ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="profit" id="profit" value="กำไร" />
                                                        <div class="state p-primary">
                                                            <label>กำไร</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="cost" id="cost" value="ต้นทุน" />
                                                        <div class="state p-primary">
                                                            <label>ต้นทุน</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="sales" id="sales" value="ยอดขาย" />
                                                        <div class="state p-primary">
                                                            <label>ยอดขาย</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="col-md-4" style="padding-left: 0px;">
                                                        <label>
                                                            <div class="pretty p-default">
                                                                <input type="checkbox" name="totalpay" id="totalpay" value="ยอดชำระ" />
                                                                <div class="state p-primary">
                                                                    <label>ยอดชำระ : </label>
                                                                </div>
                                                            </div>
                                                         </label>
                                                     </div>
                                                     <div class="col-md-4">
                                                         <select class="form-control" name="typetotalpay" id="typetotalpay">
                                                             <option value=">">มากกว่า</option>
                                                             <option value="=">เท่ากับ</option>
                                                             <option value="<">น้อยกว่า</option>
                                                         </select>
                                                     </div>
                                                     
                                                     <div class="col-md-4">
                                                         <input type="text" placeholder="ถึง" class="form-control" name="moneytotalpay" id="moneytotalpay" value="">
                                                     </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="col-md-4" style="padding-left: 0px;">
                                                        <label>
                                                            <div class="pretty p-default">
                                                                <input type="checkbox" name="notpay" id="notpay" value="ค้างชำระ" />
                                                                <div class="state p-primary">
                                                                    <label>ค้างชำระ : </label>
                                                                </div>
                                                            </div>
                                                         </label>
                                                     </div>
                                                     <div class="col-md-4">
                                                         <select class="form-control" name="typenotpay" id="typenotpay">
                                                             <option value=">">มากกว่า</option>
                                                             <option value="=">เท่ากับ</option>
                                                             <option value="<">น้อยกว่า</option>
                                                         </select>
                                                     </div>
                                                     
                                                     <div class="col-md-4">
                                                         <input type="text" placeholder="ถึง" class="form-control" name="moneynotpay" id="moneynotpay" value="">
                                                     </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <button class="btn btn-primary" type="button" onclick="selectall();">
                                                        เลือกทั้งหมด
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <button class="btn btn-warning" type="button" onclick="notselectall();">
                                                         ล้างที่เลือก
                                                    </button>
                                                </div>
                                            </div>
                                        {{-- </div> --}}
                                        {{-- <div class="row"> --}}
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    {{-- <label>&nbsp;</label><br> --}}
                                                    <button class="btn btn-primary" type="button" onclick="search();">
                                                       <i class="fa fa-search"></i>  ค้นหา
                                                    </button>
												    {{-- <button class="btn btn-success">
                                                       <i class="fa fa-file-text-o"></i>  ออกรายงาน
                                                    </button> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    {{-- <label>&nbsp;</label><br> --}}
                                                    <button class="btn btn-success" type="button" onclick="report();">
                                                       <i class="fa fa-file-text-o"></i>  ออกรายงาน Excel
                                                    </button>
                                                    <button class="btn btn-success" type="button" onclick="reportpdf();">
                                                       <i class="fa fa-file-text-o"></i>  ออกรายงาน PDF
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div style="overflow-x:auto;">
                                    <div class="table-responsive">
                                        <table class="table" id="datatables">
                                            <thead id="headdata">
                                                <tr>
                                                </tr>
                                            </thead>
                                            <tbody id="show">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                            <!-- /vertical form -->

                            <!-- Vertical form options -->

                            <!-- /vertical form options -->
                </form>	
            </div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
    var oTable = '';
    function search(){
        $('body').waitMe({
            effect : 'bounce'
        });
        $.post("{{url('reportsell')}}", $("#myForm").serialize(), function(data, textStatus, xhr) {
            var txt = '';
            var txthead = '';
            if(oTable != ''){
                oTable.destroy();
            }
            data.head.forEach(function(item,index) {
                txthead += '<th>'+item+'</th>';
            });
            $("#headdata tr").empty().append(txthead);
            data.data.forEach(function(item,index) {
                txt += '<tr>';
                for(var x=0;x<data.head.length;x++){
                    if(item[x] == null){
                        txt += '<td> </td>';
                    }else{
                        txt += '<td>'+item[x]+'</td>';
                    }
                }
                
                txt += '</tr>';
            });
            $("#show").empty().append(txt);
            oTable = $('#datatables').DataTable({
                            processing: false,
                            serverSide: false,
                            searching: false,
                            lengthChange: false,
                            scrollX: true,
                            columnDefs: [
                                { 
                                    "targets": [0, 1]
                                }
                            ]
                        });
            $("body").waitMe('hide');
        });
    }
    function report(){
        $("#myForm").attr('target', '_blank');
        $("#myForm").attr('action', '{{url('reportsellexcel')}}');
        $("#myForm").submit();
        $("#myForm").removeAttr('target');
        $("#myForm").attr('action', '{{url('reportsell')}}');
    }
    function reportpdf(){
        $("#myForm").attr('target', '_blank');
        $("#myForm").attr('action', '{{url('reportsellpdf')}}');
        $("#myForm").submit();
        $("#myForm").removeAttr('target');
        $("#myForm").attr('action', '{{url('reportsell')}}');
    }
    $('#datestart,#dateend,.datepicker-dates').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#billno,#billnoto').keyup(function(){
        $(this).autocomplete({
            source: "{{url('searchbillno/autocomplete')}}",
            minLength: 1,
            select: function(event, ui){
                console.log($(this).attr('id'))
            }
        })
        .autocomplete("instance")._renderItem = function(ul, item) {
            return $("<li>").append("<span class='text-semibold'>" + item.value + '</span>' + "<br>" + '<span class="text-muted text-size-small">' + item.label + '</span>').appendTo(ul);
        };
    });

    function selectall(){
        $("input[type='checkbox']").prop('checked',true);
    }
    function notselectall(){
        $("input[type='checkbox']").prop('checked',false);
    }
</script>
@stop