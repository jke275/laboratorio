<?php
	require_once 'include.php';
	if($_POST){
		if($_ajax->terminarPractica($_POST['id'])){
			echo true;
		}else{
			echo false;
		}
	}
?>