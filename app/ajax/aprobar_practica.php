<?php
	require_once 'include.php';
	if($_POST){
		if($_ajax->checkPracticaHora($_POST['fecha'], $_POST['hora'])){
			echo false;
		}else{
			if($_ajax->aprobarPractica($_POST['id'])){
				echo true;
			}
		}
	}
?>