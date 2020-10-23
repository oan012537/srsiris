<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function(){
	Route::get('/dashboard','HomeController@dashboard');
	Route::post('/dashboard/data','DashboardController@datasale');
	Route::get('/dashboard/stock','DashboardController@stock');
	Route::post('/dashboard/stock','DashboardController@datastock');
	
	//Product
	Route::get('/product','ProductController@index');
	Route::get('/product/category/{cate}','ProductController@indexcate');
	// Route::get('/product/{cate}/{sub}','ProductController@indexsubcate');
	Route::get('/productdatatables','ProductController@datatable');
	Route::get('/product-create','ProductController@create');
	Route::post('product_create','ProductController@store');
	Route::post('product_category','ProductController@product_category');
	Route::get('/product-update/{id}','ProductController@edit');
	Route::post('product_update','ProductController@update');
	Route::post('/product-barcode','ProductController@barcode'); //เพิ่มใหม่
	Route::get('/product-delete/{id}','ProductController@destroy');
	Route::get('/product-cancel/{id}','ProductController@cancel');//เพิ่มใหม่
    Route::get('/findstock','ProductController@stock');
    Route::get('product/findunit','ProductController@findunit');
    Route::post('product/imports_create','ProductController@import');
    Route::get('product/hisimport','ProductController@historyimport');
    Route::get('product/hissale','ProductController@historysale');
    Route::get('product/hisexport','ProductController@historyexport');
    Route::post('product/deleteproc','ProductController@deleteproc');
    Route::post('product/saveproc','ProductController@saveproc');

    Route::get('/getbarcode/{id}','ProductController@getbarcode');
    Route::post('product/savecategory','ProductController@savecategory');
    Route::post('product/saveunit','ProductController@saveunit');
    Route::get('productchangecode/{producttype}','ProductController@productchangecode');
    Route::post('product/checkproductcode','ProductController@checkproductcode');
    Route::post('product/gencodeproduct','ProductController@gencodeproduct');
    Route::get('product/printbarcode/{id}','ProductController@printbarcode');
    Route::post('product/file-upload','ProductController@fileupload');



	//เพิ่มใหม่ manufacture ผลิตสินค้าเอง
	Route::get('/manufacture','ManufactureController@index');
	Route::get('/manufacturedatatables','ManufactureController@datatable');
	Route::get('/manufacture/create','ManufactureController@create');
	Route::post('/manufacture/create','ManufactureController@store');
	Route::get('/manufacture/edit/{id}','ManufactureController@edit');
	Route::post('/manufacture/update','ManufactureController@update');

	//เพิ่มใหม่ buyproduct สินค้าซื้อ
	Route::get('/buyproduct','BuyproductController@index');
	Route::get('/buyproductdatatables','BuyproductController@datatable');


	//Category
	Route::get('/category', 'CategoryController@index');
	Route::post('category_create', 'CategoryController@store');
	Route::post('editcategory', 'CategoryController@edit');
	Route::post('category_update', 'CategoryController@update');
	Route::get('/category-delete/{id}', 'CategoryController@destroy');
	
	//Sub Category
	Route::get('/subcategory', 'SubcategoryController@index');
	Route::post('subcategory_create', 'SubcategoryController@store');
	Route::post('editsubcategory', 'SubcategoryController@edit');
	Route::post('subcategory_update', 'SubcategoryController@update');
	Route::get('/subcategory-delete/{id}', 'SubcategoryController@destroy');
	
	//Unit
	Route::get('/unit', 'UnitController@index');
	Route::get('/unitdatatables', 'UnitController@datatable');
	Route::post('unit_create', 'UnitController@store');
	Route::post('editunit', 'UnitController@edit');
	Route::post('unit_update', 'UnitController@update');
	Route::get('/unit-delete/{id}', 'UnitController@destroy');
    Route::post('queryunit','UnitController@queryunit');
	
	//Groupcustomer
	Route::get('/groupcustomer','GroupcustomerController@index');
	Route::get('/groupcustomer/datatables','GroupcustomerController@datatable');
	Route::get('/groupcustomer/create','GroupcustomerController@create');
	Route::post('/groupcustomer/create','GroupcustomerController@store');
	Route::get('/groupcustomer/update/{id}','GroupcustomerController@edit');
	Route::get('/groupcustomer/delete/{id}','GroupcustomerController@destroy');
	Route::post('/groupcustomer/update','GroupcustomerController@update');


    //Supplier
    Route::get('/supplier','SupplierController@index');
    Route::get('/supplierdatatables','SupplierController@datatable');
    Route::get('/supplier/create','SupplierController@viewcreate');
    Route::post('supplier_create','SupplierController@createdata');
    Route::get('/supplier/update/{id}','SupplierController@viewupdate');
    Route::post('supplier_update','SupplierController@updatedata');
    Route::get('/supplier-delete/{id}','SupplierController@deldata');
    Route::get('/supplier/product/{id}','SupplierController@subpage');
	
	//Customer 
	Route::get('/customer','CustomerController@index');
	Route::get('/customerdatatables','CustomerController@datatable');
	Route::get('/customer/create','CustomerController@create');
	Route::post('customer_create','CustomerController@store');
	Route::get('/customer/update/{id}','CustomerController@edit');
	Route::post('customer_update','CustomerController@update');
	Route::get('/customer-delete/{id}','CustomerController@destroy');
	Route::get('customer/datagroupcustomer','CustomerController@datagroupcustomer');
	Route::post('customer/amphures','CustomerController@amphures');
	Route::post('customer/districts','CustomerController@districts');
	Route::post('customer/zidcode','CustomerController@zidcode');
	Route::get('customer/delete/image/{id}','CustomerController@deleteimage');
	Route::post('customer/file-upload','CustomerController@fileupload');
	Route::post('customer/file-upload/add','CustomerController@fileuploadadd');
	
	//Export
	Route::get('/export','ExportController@index');
	Route::get('/exportdatatables','ExportController@datatable');
	Route::get('/export/create','ExportController@create');
	Route::get('/export-delete/{id}','ExportController@destroy');
	Route::get('/export-cancel/{id}','ExportController@cancel');
	Route::post('export_create','ExportController@store');
	Route::get('/export-update/{id}','ExportController@edit');
	Route::post('export_update','ExportController@update');
	Route::get('/export-bill/{id}','ExportController@bill');
	Route::get('/export-mail/{id}','ExportController@email');
	Route::get('checkpay/{id}','ExportController@checkpay');
	Route::post('orderchangeunit','ExportController@changeunit');
	Route::post('getdataorder','ExportController@getdataorder');
	Route::get('export/checkdatapay/{id}','ExportController@checkdatapay');
	Route::post('calmoney','ExportController@calmoney');
	Route::post('export_pay','ExportController@export_pay');
	Route::post('export/checkstock','ExportController@checkstock');
	Route::post('export/checkviewbeforeorder','ExportController@checkviewbeforeorder');
	Route::get('export/view/{id}','ExportController@view');
	Route::get('export/checkorderinsell/{id}','ExportController@checkordersell');
	Route::post('export/checkorder','ExportController@checkorder');
	

	//Selling
	Route::get('/selling','SellingController@index');
	Route::get('/sellingdatatables','SellingController@datatable');
	Route::get('/showorders','SellingController@showorders');
	Route::post('searchexport','SellingController@searchexport');
	Route::post('searchproduct','SellingController@searchproduct');
	Route::get('/selling/create','SellingController@create');
	Route::get('/selling/update/{id}','SellingController@edit');
	Route::post('/selling/update/','SellingController@update');
	Route::get('/selling/cancel/{id}','SellingController@cancel');
	Route::post('sellinggrouporder','SellingController@store');
	Route::post('selling/getdatapay','SellingController@getdatapay');
	Route::get('/sellingbill/{id}','SellingController@bill');
	Route::post('selling/calmoney','SellingController@calmoney');
	Route::get('/export-mail/{id}','ExportController@email');
	Route::get('checkpay/{id}','ExportController@checkpay');
	Route::post('selling/getdatafile','SellingController@getdatafile');
	Route::get('selling/restore/{id}','SellingController@restore');
	Route::post('selling/restore','SellingController@saverestore');
	Route::post('selling/getdestination','SellingController@getdestination');
	Route::post('selling/printbillselling','SellingController@printbillselling');
	Route::get('/selling/editcancel/{id}','SellingController@editcancel');


	//เพิ่มใหม่Order
	Route::get('/order','OrderController@index');
	Route::get('/orderdatatables','OrderController@datatable');
	Route::get('/order/create','OrderController@create');
	Route::get('/export-delete/{id}','ExportController@destroy');
	Route::post('export_create','ExportController@store');

	Route::get('/export-update/{id}','ExportController@edit');
	Route::post('export_update','ExportController@update');
	Route::get('/export-bill/{id}','ExportController@bill');
	Route::get('/export-mail/{id}','ExportController@email');

	Route::get('checkpay/{id}','ExportController@checkpay');
	//เพิ่มใหม่
	
	//Exp
	Route::get('/exp','ExpController@index');
	Route::get('/expdatatables','ExpController@datatable');
	Route::get('/exp/create','ExpController@create');
	Route::post('exp_create','ExpController@store');
	Route::post('enterbarcodeex','ExpController@enterbarcodeex');
	
	//Autocomplete
	Route::get('/searchcustomername/autocomplete','AutocompleteController@searchcustomername');
	Route::get('/searchcustomertax/autocomplete','AutocompleteController@searchcustomertax');
	Route::get('/searchcustomertel/autocomplete','AutocompleteController@searchcustomertel');
	Route::post('enterbarcode','AutocompleteController@enterbarcode');
	Route::post('enterbarcodeselling','AutocompleteController@enterbarcodeselling');
	Route::post('enterproduct','AutocompleteController@enterproduct');
	Route::post('enterproductselling','AutocompleteController@enterproductselling');
	Route::get('/searchproductname/autocomplete','AutocompleteController@autocompleteproductname');
	Route::post('/searchproductname/autocompleteeditselling','AutocompleteController@autocompleteproductnameeditselling');
    Route::get('/searchsuppliername/autocomplete','AutocompleteController@searchsupplier');
    Route::get('/searchsuppliertax/autocomplete','AutocompleteController@searchsuppliertax');
    
    Route::post('enterimportsproduct','AutocompleteController@enterimportproduct');
    Route::post('enteimportsrbarcode','AutocompleteController@enterimportbarcodeproduct');

    Route::get('transport/autocompleteemp','AutocompleteController@transportemp');
    Route::get('transport/autocompletetruck','AutocompleteController@transporttruck');
    Route::get('/searchbillno/autocomplete','AutocompleteController@searchbillno');
    Route::get('/searchproductnameandemp/autocomplete','AutocompleteController@searchproductnameandemp');

    
    //Imports
    Route::get('/imports','ImportsController@index');
    Route::get('importsdatatables','ImportsController@datatable');
    Route::get('/imports/create','ImportsController@viewcreate');
    Route::post('imports_create','ImportsController@createdata');

    Route::get('/imports_checkprice/{id}','ImportsController@checkprice');
    Route::post('/imports/getpay','ImportsController@getpay');
    Route::post('/imports/checkdatapay','ImportsController@checkdatapay');
    Route::post('/imports/pay','ImportsController@payforimport');
    Route::get('/imports/del/{id}','ImportsController@destroy');
    Route::get('/imports/update/{id}','ImportsController@edit');
    Route::post('/imports/update','ImportsController@update');
    Route::get('/imports/cancelpay/{id}','ImportsController@cancelpay');
	
	//Report
	Route::get('/reportexport','ReportexportController@index');
	Route::post('reportdataexport','ReportexportController@reportdataexport');
	Route::post('exportpdf','ReportexportController@exportpdf');
	Route::get('exportexcel/{start}/{end}','ReportexportController@exportexcel');
	Route::get('reportsale','ReportsaleController@index');
	Route::post('reportdatasale','ReportsaleController@reportdatasale');
	Route::post('salepdf','ReportsaleController@salepdf');
	Route::get('saleexcel/{start}/{end}','ReportexportController@saleexcel');
	
	//POS
    Route::get('pos','PosController@index');
    Route::post('querycarts','PosController@querycarts');
    Route::post('addcarts','PosController@addcart');
    Route::post('updatecarts','PosController@updatecarts');
    Route::post('delcarts','PosController@delcarts');
    Route::post('poscategory','PosController@poscategory');
    Route::post('poskeyword','PosController@poskeyword');
    Route::post('posbarcode','PosController@posbarcode');
    Route::get('postreset','PosController@postreset');
    Route::get('pospayment','PosController@pospayment');
    
	//Transport
	Route::get('/transport','TransportController@index');
	Route::get('/trandata','TransportController@trandata');
	Route::get('/orderres','TransportController@datatable');
	Route::get('/transport/create','TransportController@create');
	Route::post('transt_create','TransportController@store');
	Route::get('/tran-delete/{id}','TransportController@destroy');
	Route::get('/transport/cancel/{id}','TransportController@cancel');
	Route::get('/tran-wait/{id}','TransportController@tranwait');
	Route::get('/tran-approve/{id}','TransportController@tranapprove');
	Route::get('/transport/invoice/{id}','TransportController@invoice');
	Route::post('checkdatatran','TransportController@checkdatatran');
	Route::post('viewdatatran','TransportController@viewdatatran');
	Route::post('orderdata','TransportController@orderdata');
	Route::post('transport/uploadfile','TransportController@uploadfile');
	Route::post('transport/entertransportemp','TransportController@entertransportemp');
	Route::post('/transport/getorderdata','TransportController@getdataorder');
    Route::get('transport/view/{inv}','TransportController@view');
    Route::post('transport/cancel/order','TransportController@cancelorder');
    Route::post('uploadfileforselling','TransportController@uploadfileforselling');
    Route::get('transport/scanbillfortranfer/{id}','TransportController@getdatascanbill'); //หน้าสแกนบิลก่อนเอากล่องขึ้นรถ
	Route::post('transport/scanbillfortranfer','TransportController@scanbillfortranfer'); //เช็คสแกนบิลเตรียมของรอขึ้นรถ

    Route::get('transport/ordertransport/{id}','TransportController@ordertransport');
    // Route::get('transport/ordertransport/{id}','TransportController@printbill');
    Route::post('transport/getdestination','TransportController@getdestination');
    Route::post('transport/expend','TransportController@expend');
    Route::post('transport/getexpen','TransportController@getexpen');
    Route::post('transport/getfileupload','TransportController@getfileupload');
    Route::get('transport/poll/{id}','TransportController@poll');
    Route::post('transport/create/scanbill','TransportController@createscanbill');
    Route::post('transport/scanwaitboxputtingcar','TransportController@scanwaitboxputtingcar');
    Route::post('transport/addpollintransport','TransportController@addpollintransport');

	
	//Setting
	Route::get('/setting','SettingController@index');
	Route::post('setting_update','SettingController@store');
	
    
    //Billing Note
    Route::get('/billingnote','BillingNoteController@index');
	Route::get('/billingnote/datatable','BillingNoteController@datatable');
	Route::get('//billingnote/delete/{id}','BillingNoteController@delete');
    Route::get('/billingnote/create','BillingNoteController@create');
    Route::post('/billingnote/reportdatasale','BillingNoteController@reportdatasale');
    Route::post('/billingnote/create','BillingNoteController@store');
    Route::get('/billingnote/update/{id}','BillingNoteController@viewpay');
    // Route::post('/billingnote/update','BillingNoteController@update'); //อันเก่า
    Route::post('/billingnote/update','BillingNoteController@updates');

    Route::get('/billingnote/view/{id}','BillingNoteController@viewdata');
    Route::get('/billingnote/pdf/{id}','BillingNoteController@pdf');
    Route::post('/billingnote/print','BillingNoteController@printall');

    Route::post('/billingnote/update/cancel','BillingNoteController@canceldataforbilling');
    Route::post('billingnote/viewmodal','BillingNoteController@viewmodal');
    Route::post('billingnote/getdatapay','BillingNoteController@getdatapay');
    Route::post('billingnote/getdatapays','BillingNoteController@getdatapays');
    Route::post('billingnote/uploadfileonly','BillingNoteController@uploadfileonly');
    Route::get('/billingnote/print/{id}','BillingNoteController@printbill');
    Route::post('billingnote/getdataimgcheck','BillingNoteController@getdataimgcheck');
    
	Route::post('billingnote/file-upload','BillingNoteController@fileupload');
	Route::post('billingnote/file-uploadcheck','BillingNoteController@fileuploadcheck');
    

	//Packing Note
    Route::get('/packing','PackingController@index');
    Route::get('/packing/{inv}','PackingController@inv');
	Route::get('/packing/datatable','PackingController@datatable');
	Route::get('//packing/delete/{id}','PackingController@delete');
	Route::post('/packing/changebox','PackingController@changebox');
	Route::get('/packing/invoice/{id}','PackingController@invoice');

    // Route::get('/packing/packingitem','PackingController@packingitem');
    Route::post('/packing/dataproduct/','PackingController@dataproduct');
    Route::post('/packing/scanbarcode/','PackingController@scanbarcode');
    Route::post('/packing/create','PackingController@store');
    Route::get('/packing/update/{id}','PackingController@viewpay');
    Route::post('/packing/update','PackingController@update');
    Route::get('/packing/view/{id}','PackingController@viewdata');
    Route::post('/packing/putinbox','PackingController@putinbox');

    //Report customer
    Route::get('/reportcustomer','ReportcustomerController@index');
    Route::post('/reportcustomer','ReportcustomerController@search');
    Route::get('/reportcustomer/datatables','ReportcustomerController@datatable');
    // Route::post('/reportimportpdf','ReportcustomerController@report');
    Route::post('/reportcustomerexcel' , 'ReportcustomerController@reportexcel');
    Route::post('/reportcustomerpdf' , 'ReportcustomerController@reportpdf');

    //Report supplier
    Route::get('/reportsupplier','ReportsupplierController@index');
    Route::post('/reportsupplier','ReportsupplierController@search');
    Route::get('/reportsupplier/datatables','ReportsupplierController@datatable');
    Route::post('/reportsupplierexcel' , 'ReportsupplierController@reportexcel');
    Route::post('/reportsupplierpdf' , 'ReportsupplierController@reportpdf');

    //Report stock
    Route::get('/reportstock','ReportstockController@index');
    Route::post('/reportstock','ReportstockController@search');
    Route::get('/reportstock/datatables','ReportstockController@datatable');
    Route::post('/reportstockexcel' , 'ReportstockController@reportexcel');
    Route::post('/reportstockpdf' , 'ReportstockController@reportpdf');

    //Report selling
    Route::get('/reportsell','ReportsellController@index');
    Route::post('/reportsell','ReportsellController@search');
    Route::get('/reportsell/datatables','ReportsellController@datatable');
    Route::post('/reportsellexcel' , 'ReportsellController@reportexcel');
    Route::post('/reportsellpdf' , 'ReportsellController@reportsellpdf');

    //Report trans
    Route::get('/reporttrans','ReporttranController@index');
    Route::post('/reporttrans','ReporttranController@search');
    Route::get('/reporttrans/datatables','ReporttranController@datatable');
    Route::post('/reporttransexcel' , 'ReporttranController@reportexcel');
    Route::post('/reporttranspdf' , 'ReporttranController@reportpdf');

    //Report reportorder
    Route::get('/reportorder','ReportorderController@index');
    Route::post('/reportorder','ReportorderController@search');
    Route::get('/reportorder/datatables','ReportorderController@datatable');
    Route::post('/reportorderexcel' , 'ReportorderController@reportexcel');
	Route::get('reportorderexportexcel/{start}/{end}/{producttype}/{namesupplier}','ReportorderController@exportexcel');
    Route::post('/reportorderpdf' , 'ReportorderController@reportpdf');
	
	//Banner
	Route::get('backoffice/banner','BannerController@index');

	//Setheadbill
	Route::get('/setheaderbill','SetheadbillControll@index');
	Route::get('/setting','SettingController@index');
	Route::post('setheaderbill/create','SetheadbillControll@store');

	//driver
	Route::get('/driver','DriverController@index');
    Route::get('/driver/datatables','DriverController@datatable');
    Route::get('/driver/create','DriverController@viewcreate');
    Route::post('driver/create','DriverController@createdata');
    Route::get('/driver/update/{id}','DriverController@viewupdate');
    Route::post('driver/update','DriverController@updatedata');
    Route::get('/driver/delete/{id}','DriverController@deldata');
    Route::get('/driver/product/{id}','DriverController@subpage');
	//car
	Route::get('/car','CarController@index');
    Route::get('/car/datatables','CarController@datatable');
    Route::get('/car/create','CarController@viewcreate');
    Route::post('car/create','CarController@createdata');
    Route::get('/car/update/{id}','CarController@viewupdate');
    Route::post('car/update','CarController@updatedata');
    Route::get('/car/delete/{id}','CarController@deldata');
    Route::get('/car/product/{id}','CarController@subpage');
    //Category
	Route::get('/area', 'AreaController@index');
	Route::post('/area/create', 'AreaController@store');
	Route::post('/area/edit', 'AreaController@edit');
	Route::post('/area/update', 'AreaController@update');
	Route::get('/area/delete/{id}', 'AreaController@destroy');

	//Logscandata
	Route::get('logscanboxputtingcar','LogscanController@logscanboxputtingcar');

	//User
	Route::get('users','UserController@index');
	Route::get('users/datatables','UserController@datatable');
	Route::get('users/create','UserController@create');
	Route::post('users/create','UserController@store');
	Route::get('users/remove/{id}','UserController@del');
	Route::get('users/update/{id}','UserController@edit');
	Route::post('users/update','UserController@update');

	// Position
	Route::get('position','PositionController@index');
	Route::post('position/create','PositionController@store');
	Route::post('position/edit','PositionController@edit');
	Route::post('position/update','PositionController@update');
	Route::get('position/cancel/{id}','PositionController@cancel');
	Route::get('position/del/{id}','PositionController@destroy');

	Route::get('permission/{id}','PermissionController@permission');
	Route::post('permission/create/','PermissionController@store');
	Route::get('permission/del/{id}','PermissionController@destroy');


	//โชว์รายการที่เปิดบิลแต่ยังไม่ได้ทำรายการ
	Route::get('showlastsellingorder','SellingController@showorderlastorder');

	//setpercendiscount
	Route::get('percendiscount', 'PercenDiscountController@index');
	Route::post('percendiscount/create', 'PercenDiscountController@store');
	Route::post('percendiscount/edit', 'PercenDiscountController@edit');
	Route::post('percendiscount/update', 'PercenDiscountController@update');
	Route::get('percendiscount/delete/{id}', 'PercenDiscountController@destroy');

	Route::get('logsystem','LogsystemController@index');
	Route::get('logsystemdata','LogsystemController@datatable');
	Route::get('logsystemdatalogsystem','HomeController@datalogsystem');
	Route::get('copytosellingdetail','HomeController@copytosellingdetail'); //copyorderใส่selling detail

	//Upload slip
	Route::get('uploadslippay','UploadSlippay@index');
	Route::get('uploadslippay/datatables','UploadSlippay@datatables');
	Route::get('uploadslippay/approve/{id}','UploadSlippay@approve');

	//แสดงรายงานออเดอร์ที่ไม่มีสินค้า
	Route::get('detailorderhnotproduct','OrderController@showordernotproduct');
	Route::get('detailorderhnotproductdatatables','OrderController@datatableordernotproduct');
	Route::get('detailorderhnotproduct/approve/{id}','OrderController@approve');
});


	## Front End ##
	Route::get('/','FrontEndController@index');
	Route::get('/checkstock','FrontEndController@checkstock'); //เปิดหน้าสแกนบิลเพื่อเอาของออกจากคลังรอลงกล่อง
	Route::post('/scanbill','FrontEndController@scanbill'); //สแกนบิลเอาของออกจากคลังรอลงกล่อง
	Route::post('/scanbarcode','FrontEndController@scanbarcode'); //สแกนเอาของออกจากคลังรอลงกล่อง
	Route::get('/checkproductinbox/{id}','FrontEndController@checkproductinbox'); //สแกนหน้ากล่องเพื่อดูรายการสินค้าในหล่อง
	Route::get('/checkboxbeforeputtingcar','FrontEndController@checkboxbeforeputtingcar'); //หน้าสแกนบิลก่อนเอากล่องขึ้นรถ
	Route::post('/scanbillfortranfer','FrontEndController@scanbillfortranfer'); //เช็คสแกนบิลเตรียมของรอขึ้นรถ
	Route::post('/scanwaitboxputtingcar','FrontEndController@scanwaitboxputtingcar'); //สแกนของขึ้นรถ
	Route::get('/scanboxbillputtingcar','FrontEndController@scanboxbillputtingcar'); //หน้าสแกนบิลเพื่อเอากล่องขึ้นรถ
	Route::post('/scancheckputtingcar','FrontEndController@scancheckputtingcar'); //สแกนของตามบิลรอขึ้นรถ
	Route::post('/scanboxputtingcar','FrontEndController@scanboxputtingcar'); //สแกนของขึ้นรถ
	//ไม่ได้ใช้เอามาลอง ใช้โทรศัพท์สแกน
	Route::get('qrLogin', 'QrLoginController@index');
	Route::post('qrLogin','QrLoginController@checkUser');
	Route::get('my-qrcode', 'QrLoginController@ViewUserQrCode');
	Route::post('qrLogin-autogenerate', 'QrLoginController@QrAutoGenerate');
	  



Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/backoffice', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('scanqrcode', 'HomeController@scanqrcode')->name('scanqrcode');
Route::get('/logout', 'HomeController@logout');
Route::group(['prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z]{2}'],'middleware' => 'setlocale'], function() {
	Route::get('/', function () {
		Session::put('locale', app()->getLocale());
		// dd(Session::get('locale'));
		return Redirect::back();
	    // return redirect(app()->getLocale());
	});
});
Route::get('backup', function(){
	Artisan::call('db:backup');
	return "Backup";
});
Route::get('notifications', function () {
	$data = App\product::all();

    return (new App\Notifications\OrderProduct)
                ->toArray($data);
});
Route::get('/cache', function() {
	Artisan::call('cache:clear');
	Artisan::call('view:clear');
	Artisan::call('config:cache');
	Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
Route::get('renameproduct', function () {
	$data = App\product::where('product_name','LIKE','%  %')->get();
	foreach ($data as $value) {

		$name = str_replace('  ',' ',$value->product_name);
		DB::table('product')->where('product_id',$value->product_id)->update(['product_name' => $name]);
		
	}
});
Route::get('/', function () {dd();});