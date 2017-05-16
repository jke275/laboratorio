<?php
	if($_POST){
		require_once 'include.php';
		if($_ajax->eliminarCodigo($_POST['codigo'], $_POST['id'])){
			echo true;
		}else{
			echo false;
		}
	}
?>