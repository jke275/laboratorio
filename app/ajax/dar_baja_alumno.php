<?php
	require_once 'include.php';
	if($_POST){
		if($_ajax->dar_baja_alumno($_POST['codigo'], $_POST['estado'])){
			echo true;
		}else{
			echo false;
		}
	}
?>