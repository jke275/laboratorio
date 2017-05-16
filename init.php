<?php
	session_start();
	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', __DIR__ . DS);
	define('URL', 'http://localhost/laboratorio/');

	$GLOBALS['config'] = array(
		'mysql' => array(
			'host' => 'localhost',
			'user' => 'root',
			'password' => 'AGarcia',
			'db' => 'laboratorio'
		),
		'laboratorio' => 'electronica'
	);
?>