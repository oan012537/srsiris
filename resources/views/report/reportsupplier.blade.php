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
    </style>

    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">
        
            <!-- Main content -->
            <div class="content-wrapper">
                {{-- <form id="myForm" method="post" target="_blank" action="{{url('reportimportpdf')}}"> --}}
                <form id="myForm" method="post" action="{{url('reportsupplier')}}">
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
                                           <i class="icon-stack2"></i> รายงานซัพพลายเออร์
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
                                                    <label>ชื่อผู้ผลิต :</label>
                                                    {{-- <input type="text" placeholder="ชื่อ" class="form-control" name="customername" id="customername" value=""> --}}
                                                    <select class="form-control select2" name="name" id="name">
                                                        <option value="" selected>ชื่อ</option>
                                                        @if(!empty($data))
                                                        @foreach($data as $item)
                                                            <option value="{{ $item->supplier_id}}">{{ $item->supplier_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ถึง :</label>
                                                    {{-- <input type="text" placeholder="ถึง" class="form-control" name="customernameto" id="customernameto" value=""> --}}
                                                    <select class="form-control select2" name="nameto" id="nameto">
                                                        <option value="" selected>ชื่อ</option>
                                                        @if(!empty($data))
                                                        @foreach($data as $item)
                                                            <option value="{{ $item->supplier_id}}">{{ $item->supplier_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>วิธีการชำระเงิน :</label>
                                                    <select class="form-control" name="typepay" id="typepay">
                                                        <option value="">ไม่เลือก</option>
                                                        <option value="1">เงินสด</option>
                                                        <option value="2">โอน</option>
                                                        <option value="3">เช็ค</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 checkboxs">
                                                <div class="form-group">
                                                    <label>&nbsp;</label><br>
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="latlong" id="latlong" value="ละติจูดและลองจิจูด" />
                                                        <div class="state p-primary">
                                                            <label>ละติจูดและลองจิจูด</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 ">
                                                <div class="form-group">
                                                    {{-- <label>&nbsp;</label><br> --}}
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="tel" id="tel" value="เบอร์ติดต่อ" />
                                                        <div class="state p-primary">
                                                            <label>เบอร์ติดต่อ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 ">
                                                <div class="form-group">
                                                    {{-- <label>&nbsp;</label><br> --}}
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="email" id="email" value="อีเมล์" />
                                                        <div class="state p-primary">
                                                            <label>อีเมล์</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 ">
                                                <div class="form-group">
                                                    {{-- <label>&nbsp;</label><br> --}}
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" class="checkbox" name="tax" id="tax" value="เลขประจำตัวผู้เสียภาษี" />
                                                        <div class="state p-primary">
                                                            <label>เลขประจำตัวผู้เสียภาษี</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {{-- <label>&nbsp;</label><br> --}}
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
                                                         <input type="text" placeholder="0" class="form-control" name="moneynotpay" id="moneynotpay" value="">
                                                     </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {{-- <label>&nbsp;</label><br> --}}
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="total" id="total" value="ยอดซื้อทั้งหมด" />
                                                        <div class="state p-primary">
                                                            <label>ยอดซื้อทั้งหมด</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>
                                                        {{-- <div class="pretty p-default">
                                                            <input type="checkbox" name="checkcategory" id="checkcategory" value="หมวดหมู่สินค้า" />
                                                            <div class="state p-primary">
                                                                <label>หมวดหมู่สินค้า : </label>
                                                            </div>
                                                        </div> --}}
                                                        หมวดหมู่สินค้า : 
                                                    </label>
                                                    <select class="form-control select2" name="category[]" id="category" multiple="">
                                                        @if(!empty($category))
                                                        @foreach($category as $item)
                                                            <option value="{{ $item->category_id}}">{{ $item->category_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-primary" type="button" onclick="selectall();">
                                                        เลือกทั้งหมด
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-warning" type="button" onclick="notselectall();">
                                                         ล้างที่เลือก
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-primary" type="button" onclick="search();">
                                                       <i class="fa fa-search"></i>  ค้นหา
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>&nbsp;</label><br>
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
                                <div class="table-responsive">
                                    <table class="table" id="datatables">
                                        <thead id="headdata">
                                            <tr>
                                                {{-- <th class="text-center" width="7%">ลำดับที่</th>
                                                <th class="text-center" width="15%">ชื่อผู้ผลิต</th>
                                                <th class="text-center" width="10%">เลขประจำตัวผู้เสียภาษีอากร</th>
                                                <th class="text-center" width="20%">ละติจูดและลองจิจูด</th>
                                                <th class="text-center" width="8%">เบอร์ติดต่อ</th>
                                                <th class="text-center" width="10%">อีเมล์</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody id="show">
                                            {{-- @if(!empty($data))
                                            @foreach($data as $key => $value)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$value->supplier_name}}</td>
                                                <td>{{$value->supplier_tax}}</td>
                                                <td>{{$value->lat}},{{$value->lng}}</td>
                                                <td>{{$value->supplier_tel}}</td>
                                                <td>{{$value->supplier_email}}</td>
                                            </tr>
                                            @endforeach
                                            @endif --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> 
            </div>

        </div>

    </div>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        var heights = $("#datestart").parents().parents().height();
        $(".checkboxs").css('height',heights+'px');
        
    });
    $('#datestart,#dateend').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    var oTable = '';
    function search(){
        // $('body').waitMe({
        //     effect : 'bounce'
        // });
        $.post("{{url('reportsupplier')}}", $("#myForm").serialize(), function(data, textStatus, xhr) {
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
        $("#myForm").attr('action', '{{url('reportsupplierexcel')}}');
        $("#myForm").submit();
        $("#myForm").removeAttr('target');
        $("#myForm").attr('action', '{{url('reportsupplier')}}');
    }
    function reportpdf(){
        $("#myForm").attr('target', '_blank');
        $("#myForm").attr('action', '{{url('reportsupplierpdf')}}');
        $("#myForm").submit();
        $("#myForm").removeAttr('target');
        $("#myForm").attr('action', '{{url('reportsupplier')}}');
    }
    function selectall(){
        $("input[type='checkbox']").prop('checked',true);
    }
    function notselectall(){
        $("input[type='checkbox']").prop('checked',false);
    }
</script>
@stop