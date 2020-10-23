<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Datatables;
use File;
use DateTime;
use Session;
use Response;


class BannerController extends Controller{
	
	public function index(){
		return view('banner/index');
	}
	
}

?>