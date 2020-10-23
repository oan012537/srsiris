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
                <form id="myForm" method="post" action="{{url('reporttrans')}}">
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
                                           <i class="icon-stack2"></i> รายงานการจัดส่ง
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
                                                    <label>เลขที่บิลจัดส่ง :</label>
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
                                                    <label>สถานะ :</label>
                                                    <select class="form-control" name="status" id="status">
                                                        <option value="">ทั้งหมด</option>
                                                        <option value="1">เปิดบิล</option>
                                                        <option value="2">แพ็คแล้ว</option>
                                                        <option value="3">ขึ้นรถ</option>
                                                        <option value="4">จัดส่งแล้ว</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>วันที่ :</label>
                                                    <input type="text" placeholder="วันที่" class="form-control datepicker-dates" name="datestatus" id="datestatus" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {{-- <label>&nbsp;</label><br> --}}
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="showdate" id="showdate" value="วันที่ส่งของ" />
                                                        <div class="state p-primary">
                                                            <label>วันที่ส่งของ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="showsellingbill" id="showsellingbill" value="เลขที่บิลขาย" />
                                                        <div class="state p-primary">
                                                            <label>เลขที่บิลขาย</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="showcustomername" id="showcustomername" value="ชื่อลูกค้า" />
                                                        <div class="state p-primary">
                                                            <label>ชื่อลูกค้า</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="showdetailts" id="showdetailts" value="ข้อมูลรถจัดส่ง" />
                                                        <div class="state p-primary">
                                                            <label>ข้อมูลรถจัดส่ง</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="showunit" id="showunit" value="จำนวน(หน่วย)" />
                                                        <div class="state p-primary">
                                                            <label>จำนวน(หน่วย)</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="showstatus" id="showstatus" value="สถานะ" />
                                                        <div class="state p-primary">
                                                            <label>สถานะ</label>
                                                        </div>
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
        // $('body').waitMe({
        //     effect : 'bounce'
        // });
        $.post("{{url('reporttrans')}}", $("#myForm").serialize(), function(data, textStatus, xhr) {
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
        $("#myForm").attr('action', '{{url('reporttransexcel')}}');
        $("#myForm").submit();
        $("#myForm").removeAttr('target');
        $("#myForm").attr('action', '{{url('reporttrans')}}');
    }
    function reportpdf(){
        $("#myForm").attr('target', '_blank');
        $("#myForm").attr('action', '{{url('reporttranspdf')}}');
        $("#myForm").submit();
        $("#myForm").removeAttr('target');
        $("#myForm").attr('action', '{{url('reporttrans')}}');
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