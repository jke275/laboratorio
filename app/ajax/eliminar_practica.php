<?php
	if($_POST){
		require_once 'include.php';
		echo $_ajax->eliminarPractica($_POST['id']);
	}
?>