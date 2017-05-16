<?php
	date_default_timezone_set('America/Mexico_City');
	include_once '../../init.php';
	include_once '../Core/Config.php';
	include_once '../Models/DB.php';
	include_once '../Models/Session.php';
	include_once '../Models/User.php';
	include_once '../includes/Validate.php';
	include_once '../Models/Ajax.php';
	include_once '../../publico/Views/templates/translateDate.php';
	use app\Models\DB;
	$_ajax = app\Models\Ajax::getInstance();
	$_validate = app\includes\Validate::getInstance();
	$db = DB::getInstance();
	function pattern($val){
		return (bool)preg_match("/^([\/\p{L}- 0-9])+$/ui", $val);
	}
?>