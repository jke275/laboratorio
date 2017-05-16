<?php
	require_once 'include.php';
	if($_POST){
		//echo $_POST['codigo'];
		echo $_ajax->salir($_POST['codigo'], $_POST['fecha'], $_POST['hora']);
	}
?>