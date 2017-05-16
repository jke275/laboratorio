<?php
	if($_POST){
		require_once 'include.php';
		if($_ajax->quitar_sancion($_POST['codigo'])){
			echo true;
		}else{
			echo false;
		}
	}
?>