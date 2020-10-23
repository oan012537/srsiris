<?php
function savelog($menu,$text){
	$data = [
		'logsystem_menu' => $menu,
		'logsystem_text' => $text,
		'logsystem_adminid' => \Auth::id(),
		'created_at'	=>new DateTime(),
		'updated_at'	=>new DateTime()
	];
	DB::table('log_system')->insert($data);
}
