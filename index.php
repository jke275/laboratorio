<?php
	date_default_timezone_set('America/Mexico_City');
	require_once 'app/Core/Autoload.php';
	new app\Core\Autoload();
	if(file_exists('init.php')){
		require_once 'init.php';
		require_once 'publico/Views/templates/translateDate.php';
		new app\Core\Router(new app\Core\Request());
	}else{
		header('Location: app/install/setup.php');
	}
?>