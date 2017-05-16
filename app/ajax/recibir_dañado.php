<?php
	if($_POST){
		require_once 'include.php';
		$recibir = $_ajax->recibir($_POST['codigo'], $_POST['id'], 'dañado');
		$sancion = $_ajax->sancion($_POST['alumno'], $_POST['codigo']);
		echo ($recibir && $sancion) ? true : false;
	}
?>