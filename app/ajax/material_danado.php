<?php
	if($_POST){
		require_once 'include.php';
		echo $_ajax->recibirDanado($_POST['codigo'], $_POST['alumno']);
	}
?>