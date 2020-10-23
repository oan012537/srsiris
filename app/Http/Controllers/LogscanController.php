<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Session;
use Response;
use Datatables;
use File;
use App\logscanboxputtingcar;
class LogscanController extends Controller
{
	function logscanboxputtingcar(){
		// $log = new logscanboxputtingcar;
		$data = logscanboxputtingcar::leftjoin('users','id','scanboxputtingcar_user')->select('scanboxputtingcar_date','scanboxputtingcar_ref','scanboxputtingcar_tax','scanboxputtingcar_count','name')->get();
		return view('logscandata/index',['data'=>$data]);
	}
}
