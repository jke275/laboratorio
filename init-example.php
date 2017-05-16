<?php
	session_start();
	define('URL', 'Tu dirección IP');

	$GLOBALS['config'] = array(
		'mysql' => array(
			'host' => 'Tu dirección IP',
			'user' => 'Usuario mysql',
			'password' => 'Password mysql',
			'db' => 'Base de Datos'
		),
		'laboratorio' => 'nombre del laboratorio'
	);
?>