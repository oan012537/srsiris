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
                <form id="myForm" method="post" action="{{url('reportstock')}}">
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
                                           <i class="icon-stack2"></i> รายงานสต๊อก
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
                                                    <input type="text" name="productname" id="productname" class="form-control" autocomplete="off">
                                                    <input type="hidden" name="productnameid" id="productnameid">
                                                    {{-- <select class="form-control select2" name="productname" id="productname">
                                                        <option value="" selected>ชื่อ</option>
                                                        @if(!empty($product))
                                                        @foreach($product as $item)
                                                            <option value="{{ $item->product_id}}">{{ $item->product_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ถึง :</label>
                                                    <input type="text" name="productnameto" id="productnameto" class="form-control" autocomplete="off">
                                                    <input type="hidden" name="productnametoid" id="productnametoid">
                                                    {{-- <select class="form-control select2" name="productnameto" id="productnameto">
                                                        <option value="" selected>ชื่อ</option>
                                                        @if(!empty($product))
                                                        @foreach($product as $item)
                                                            <option value="{{ $item->product_id}}">{{ $item->product_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>
                                                        <div class="pretty p-default">
                                                            <input type="checkbox" name="checkcategory" id="checkcategory" value="หมวดหมู่สินค้า" />
                                                            <div class="state p-primary">
                                                                <label>หมวดหมู่สินค้า : </label>
                                                            </div>
                                                        </div>
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
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="checkin" id="checkin" value="จำนวนที่ซื้อเข้า" />
                                                        <div class="state p-primary">
                                                            <label>จำนวนที่ซื้อเข้า</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="checkout" id="checkout" value="จำนวนที่ขายออก" />
                                                        <div class="state p-primary">
                                                            <label>จำนวนที่ขายออก</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="checkdate" id="checkdate" value="วันที่" />
                                                        <div class="state p-primary">
                                                            <label>วันที่</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="billno" id="billno" value="เลขที่บิล" />
                                                        <div class="state p-primary">
                                                            <label>เลขที่บิล</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="col-md-4" style="padding-left: 0px;">
                                                        <label>
                                                            <div class="pretty p-default">
                                                                <input type="checkbox" name="checkprice" id="checkprice" value="ราคาขาย" />
                                                                <div class="state p-primary">
                                                                    <label>ราคาขาย : </label>
                                                                </div>
                                                            </div>
                                                         </label>
                                                     </div>
                                                     <div class="col-md-4">
                                                         <select class="form-control" name="typeprice" id="typeprice">
                                                             <option value=">">มากกว่า</option>
                                                             <option value="=">เท่ากับ</option>
                                                             <option value="<">น้อยกว่า</option>
                                                         </select>
                                                     </div>
                                                     <div class="col-md-4">
                                                         <input type="text" placeholder="ถึง" class="form-control" name="moneyprice" id="moneyprice" value="">
                                                     </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="col-md-4" style="padding-left: 0px;">
                                                        <label>
                                                            <div class="pretty p-default">
                                                                <input type="checkbox" name="checkstandardprice" id="checkstandardprice" value="ต้นทุนสินค้า" />
                                                                <div class="state p-primary">
                                                                    <label>ต้นทุนสินค้า : </label>
                                                                </div>
                                                            </div>
                                                         </label>
                                                     </div>
                                                     <div class="col-md-4">
                                                         <select class="form-control" name="typestandardprice" id="typestandardprice">
                                                             <option value=">">มากกว่า</option>
                                                             <option value="=">เท่ากับ</option>
                                                             <option value="<">น้อยกว่า</option>
                                                         </select>
                                                     </div>
                                                     <div class="col-md-4">
                                                         <input type="text" placeholder="ถึง" class="form-control" name="moneystandardprice" id="moneystandardprice" value="">
                                                     </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="col-md-4" style="padding-left: 0px;">
                                                        <label>
                                                            <div class="pretty p-default">
                                                                <input type="checkbox" name="checkprofit" id="checkprofit" value="กำไร" />
                                                                <div class="state p-primary">
                                                                    <label>กำไร(ส่วนต่าง) : </label>
                                                                </div>
                                                            </div>
                                                         </label>
                                                     </div>
                                                     <div class="col-md-4">
                                                         <select class="form-control" name="typeprofit" id="typeprofit">
                                                             <option value=">">มากกว่า</option>
                                                             <option value="=">เท่ากับ</option>
                                                             <option value="<">น้อยกว่า</option>
                                                         </select>
                                                     </div>
                                                     
                                                     <div class="col-md-4">
                                                         <input type="text" placeholder="ถึง" class="form-control" name="moneyprofit" id="moneyprofit" value="">
                                                     </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <div class="pretty p-default">
                                                        <input type="checkbox" name="percen" id="percen" value="เปอร์เซ็นกำไร" />
                                                        <div class="state p-primary">
                                                            <label>เปอร์เซ็นกำไร</label>
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
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <button class="btn btn-primary" type="button" onclick="search();">
                                                       <i class="fa fa-search"></i>  ค้นหา
                                                    </button>
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
        $.post("{{url('reportstock')}}", $("#myForm").serialize(), function(data, textStatus, xhr) {
            var txt = '';
            var txthead = '';
            if(oTable != ''){
                oTable.destroy();
            }
            data.head.forEach(function(item,index) {
                txthead += '<th>'+item+'</th>';
            });
            $("#headdata tr").empty().append(txthead);
            // console.log(data.data)
            data.data.forEach(function(item,index) {
                txt += '<tr>';
                for(var x=0;x<data.head.length;x++){
                    if(x == 0){
                        txt += '<td>'+(index+1)+'</td>';
                    }else{
                        if(item[x] == null){
                            txt += '<td> </td>';
                        }else{
                            txt += '<td>'+item[x]+'</td>';
                        }
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
        $("#myForm").attr('action', '{{url('reportstockexcel')}}');
        $("#myForm").submit();
        $("#myForm").removeAttr('target');
        $("#myForm").attr('action', '{{url('reportstock')}}');
    }
    function reportpdf(){
        $("#myForm").attr('target', '_blank');
        $("#myForm").attr('action', '{{url('reportstockpdf')}}');
        $("#myForm").submit();
        $("#myForm").removeAttr('target');
        $("#myForm").attr('action', '{{url('reportstock')}}');
    }
    $('#datestart,#dateend').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('#productname,#productnameto').keyup(function(){
        $(this).autocomplete({
            source: "{{url('searchproductname/autocomplete')}}",
            minLength: 1,
            select: function(event, ui){
                $("#"+$(this).attr('id')+'id').val(ui.item.id)
            }
        })
        .autocomplete("instance")._renderItem = function(ul, item) {
            return $("<li>").append("<span class='text-semibold'>" + item.label + '</span>').appendTo(ul);
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