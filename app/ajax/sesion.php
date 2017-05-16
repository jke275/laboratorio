<?php
	require_once 'include.php';

	if($_POST){
		echo $_ajax->sesion($_POST['usuario'], $_POST['psw']);
	}
?>