<?php
	if($_POST){
		require_once 'include.php';
		echo !$_ajax->eliminarPrestamo($_POST['solicitante'], $_POST['id']);
	}
?>