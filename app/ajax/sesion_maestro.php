<?php
	if($_POST){
		require_once 'include.php';
		if($maestro = $_ajax->get('maestros', 'codigo_maestro',$_POST['maestro'])){
			echo $_ajax->sesion_maestro($maestro['codigo_maestro'], $maestro['nombre_maestro'] . ' ' . $maestro['apellidos_maestro']);
		}else{
			echo 'noUser';
		}
	}
?>