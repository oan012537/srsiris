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
                                           <i class="icon-stack2"></i> รายงานลูกค้า
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
                                                    <label>ชื่อ :</label>
                                                    {{-- <input type="text" placeholder="ชื่อ" class="form-control" name="customername" id="customername" value=""> --}}
                                                    <select class="form-control select2" name="customername" id="customername">
                                                        <option value="" selected>ชื่อ</option>
                                                        @if(!empty($customer))
                                                        @foreach($customer as $item)
                                                            <option value="{{ $item->customer_id}}">{{ $item->customer_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ถึง :</label>
                                                    {{-- <input type="text" placeholder="ถึง" class="form-control" name="customernameto" id="customernameto" value=""> --}}
                                                    <select class="form-control select2" name="customernameto" id="customernameto">
                                                        <option value="" selected>ชื่อ</option>
                                                        @if(!empty($customer))
                                                        @foreach($customer as $item)
                                                            <option value="{{ $item->customer_id}}">{{ $item->customer_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>วิธีการชำระเงิน :</label>
                                                    {{-- <input type="text" placeholder="วงเงิน" class="form-control" name="limitmoney" id="limitmoney" value=""> --}}
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
                                                            <option @if($customergroup == $item->area_id)selected @endif value="{{ $item->area_id}}">{{ $item->area_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {{-- <label>ที่อยู่ :</label> --}}
                                                    {{-- <input type="text" placeholder="ที่อยู่" class="form-control" name="address" id="address" value=""> --}}
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
                                                    {{-- <label>เบอร์ติดต่อ :</label>
                                                    <input type="text" placeholder="เบอร์ติดต่อ" class="form-control" name="tel" id="tel" value=""> --}}
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="tel" id="tel" value="เบอร์ติดต่อ" />
                                                        <div class="state p-primary">
                                                            <label>เบอร์ติดต่อ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {{-- <label>เลขประจำตัวผู้เสียภาษีอากร :</label>
                                                    <input type="text" placeholder="เลขประจำตัวผู้เสียภาษีอากร" class="form-control" name="idtax" id="idtax" value=""> --}}
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="idtax" id="idtax" value="เลขประจำตัวผู้เสียภาษีอากร" />
                                                        <div class="state p-primary">
                                                            <label>เลขประจำตัวผู้เสียภาษีอากร</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {{-- <label>ละติจูด :</label>
                                                    <input type="text" placeholder="ละติจูด" class="form-control" name="lat" id="lat" value=""> --}}
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="latlong" id="latlong" value="ละติจูด,ลองจิจูด" />
                                                        <div class="state p-primary">
                                                            <label>ละติจูด,ลองจิจูด</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {{-- <label>อีเมล์ :</label>
                                                    <input type="text" placeholder="อีเมล์" class="form-control" name="email" id="email" value=""> --}}
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="email" id="email" value="อีเมล์" />
                                                        <div class="state p-primary">
                                                            <label>อีเมล์</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {{-- <label>เครดิต :</label>
                                                    <input type="text" placeholder="เครดิต" class="form-control" name="credit" id="credit" value=""> --}}
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="credit" id="credit" value="เครดิต" />
                                                        <div class="state p-primary">
                                                            <label>เครดิต</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {{-- <label>เครดิตเงินที่ค้างได้ :</label>
                                                    <input type="text" placeholder="เครดิตเงินที่ค้างได้" class="form-control" name="creditmoney" id="creditmoney" value=""> --}}
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="creditmoney" id="creditmoney" value="เครดิตเงินที่ค้างได้" />
                                                        <div class="state p-primary">
                                                            <label>เครดิตเงินที่ค้างได้</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {{-- <label>ภาษี :</label>
                                                    <input type="text" placeholder="ภาษี" class="form-control" name="vat" id="vat" value=""> --}}
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="vat" id="vat" value="ภาษี" />
                                                        <div class="state p-primary">
                                                            <label>ภาษี</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {{-- <label>วิธีการส่งสินค้า :</label>
                                                    <input type="text" placeholder="วิธีการส่งสินค้า" class="form-control" name="typedelivery" id="typedelivery" value=""> --}}
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="typedelivery" id="typedelivery" value="วิธีการส่งสินค้า" />
                                                        <div class="state p-primary">
                                                            <label>วิธีการส่งสินค้า</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {{-- <label>เกรดราคาขายส่ง :</label>
                                                    <input type="text" placeholder="เกรดราคาขายส่ง" class="form-control" name="rate" id="rate" value=""> --}}
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="rate" id="rate" value="เกรดราคาขายส่ง" />
                                                        <div class="state p-primary">
                                                            <label>เกรดราคาขายส่ง</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {{-- <label>ค่าจัดส่ง :</label>
                                                    <input type="text" placeholder="ค่าจัดส่ง" class="form-control" name="rateshiping" id="rateshiping" value=""> --}}
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="rateshiping" id="rateshiping" value="ค่าจัดส่ง" />
                                                        <div class="state p-primary">
                                                            <label>ค่าจัดส่ง</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {{-- <label>หมายเหตุ :</label>
                                                    <input type="text" placeholder="หมายเหตุ" class="form-control" name="note" id="note" value=""> --}}
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="note" id="note" value="หมายเหตุ" />
                                                        <div class="state p-primary">
                                                            <label>หมายเหตุ</label>
                                                        </div>
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
                                                             <option value="1">มากกว่า</option>
                                                             <option value="2">เท่ากับ</option>
                                                             <option value="3">น้อยกว่า</option>
                                                         </select>
                                                     </div>
                                                     
                                                     <div class="col-md-4">
                                                         <input type="text" placeholder="ถึง" class="form-control" name="moneynotpay" id="moneynotpay" value="">
                                                     </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="total" id="total" value="ยอดซื้อทั้งหมด" />
                                                        <div class="state p-primary">
                                                            <label>ยอดซื้อทั้งหมด</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                                    <table class="table" id="datatables">
                                        <thead id="headdata">
                                            <tr>
                                                {{-- <th class="text-center" width="7%">ลำดับที่</th>
                                                <th class="text-center" width="15%">ชื่อลูกค้า</th>
                                                <th class="text-center" width="10%">เลขประจำตัวผู้เสียภาษีอากร</th>
                                                <th class="text-center" width="20%">ที่อยู่</th>
                                                <th class="text-center" width="8%">เบอร์ติดต่อ</th>
                                                <th class="text-center" width="10%">อีเมล์</th>
                                                <th class="text-center" width="8%">กลุ่มลูกค้า</th>
                                                <th class="text-center" width="8%">ภาษี</th>
                                                <th class="text-center" width="8%">ค่าจัดส่ง</th>
                                                <th class="text-center" width="15%">หมายเหตุ</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody id="show">
                                            {{-- @if(!empty($data))
                                            @foreach($data as $key => $value)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$value->customer_name}}</td>
                                                <td>{{$value->customer_idtax}}</td>
                                                <td>บ้านเลขที่ {{$value->customer_address1}} ถนน {{$value->customer_address2}} แขวง {{$value->customer_address3}} เขต {{$value->customer_address4}} จังหวัด {{$value->customer_address5}} รหัสไปรษณย์ {{$value->customer_address6}}</td>
                                                <td>{{$value->customer_tel}}</td>
                                                <td>{{$value->customer_email}}</td>
                                                <td>{{$value->area_name}}</td>
                                                <td> 
                                                    @if($value->customer_vat == 1) 
                                                    vatนอก 
                                                    @elseif($value->customer_vat == 2)
                                                     vatใน
                                                    @elseif($value->customer_vat == 0) 
                                                    ไม่มี 
                                                    @endif
                                                </td>
                                                <td>
                                                    @if( $value->customer_rateshiping == 1)
                                                    จ่ายเต็ม
                                                    @elseif($value->customer_rateshiping == 2)
                                                    จ่ายครึ่ง
                                                    @elseif($value->customer_rateshiping == 0)
                                                    ฟรี 
                                                    @endif
                                                </td>
                                                <td>{{$value->customer_note}}</td>
                                            </tr>
                                            @endforeach
                                            @endif --}}
                                        </tbody>
                                    </table>
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
	// $(document).ready(function(){
 //        var oTable = $('#datatables').DataTable({
 //            processing: true,
 //            serverSide: false,
 //            searching: false,
 //            lengthChange: false,
 //            ajax:{ 
 //                url : "{{url('reportcustomer/datatables')}}",
 //                data: function (d) {
 //                    d.datestart = $('#datestart').val();
 //                    d.dateend = $('#dateend').val();
 //                    d.customername = $('#customername').val();
 //                    d.province = $('#province').val();
 //                    d.amphure = $('#amphure').val();
 //                    d.district = $('#district').val();
 //                    d.zidcode = $('#zidcode').val();
 //                    d.customergroup = $('#customergroup').val();
 //                },
 //            },
            
 //            columns: [
 //                { 'className': "text-center", data: 'customer_id', name: 'customer_id' },
 //                { data: 'customer_name', name: 'customer_name' },
 //                { data: 'location', name: 'location' },
 //                { 'className': "text-center", data: 'customer_tel', name: 'customer_tel' },
 //                { data: 'customer_email', name: 'customer_email' },
 //            ],
 //            order: [[0, 'asc']],
 //            rowCallback: function(row,data,index ){
                
 //                /*<a href="supplier/product/'+data['driver_id']+'" class="btn btn-info btn-rounded"><i class="icon-display4"></i> รายการสินค้า</a>*/
 //            }
 //        });
        
 //        oTable.on( 'order.dt search.dt', function(){
 //            oTable.column(0,{search:'applied',order:'applied'}).nodes().each(function(cell, i){
 //                cell.innerHTML = i+1;
 //            } );
 //        }).draw();
 //    });

    $(document).ready(function() {
        $('.select2').select2();
    });
    var oTable = '';
    function search(){
        $('body').waitMe({
            effect : 'bounce'
        });
        $.post("{{url('reportcustomer')}}", $("#myForm").serialize(), function(data, textStatus, xhr) {
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
        $("#myForm").attr('action', '{{url('reportcustomerexcel')}}');
        $("#myForm").submit();
        $("#myForm").removeAttr('target');
        $("#myForm").attr('action', '{{url('reportcustomer')}}');
    }
    function reportpdf(){
        $("#myForm").attr('target', '_blank');
        $("#myForm").attr('action', '{{url('reportcustomerpdf')}}');
        $("#myForm").submit();
        $("#myForm").removeAttr('target');
        $("#myForm").attr('action', '{{url('reportcustomer')}}');
    }
    $('#datestart,#dateend').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#customername,#customernameto').keyup(function(){
        $(this).autocomplete({
            source: "{{url('searchcustomername/autocomplete')}}",
            minLength: 1,
            select: function(event, ui){
                console.log($(this).attr('id'))
            }
        })
        .autocomplete("instance")._renderItem = function(ul, item) {
            return $("<li>").append("<span class='text-semibold'>" + item.label + '</span>' + "<br>" + '<span class="text-muted text-size-small">' + item.attr + '</span>').appendTo(ul);
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