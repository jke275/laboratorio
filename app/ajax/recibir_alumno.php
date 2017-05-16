<?php
	require_once 'include.php';
	if($_POST){
		echo ($_ajax->recibir($_POST['codigo'], $_POST['id'], 'disponible')) ? true : false;
	}
?>