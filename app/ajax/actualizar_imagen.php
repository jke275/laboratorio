<?php
	if($_POST){
		require_once 'include.php';
		if($_FILES['upload']['error'] == 0){
			$formatos_admitidos = array("image/jpeg", "image/png", "image/gif", "image/jpg");
			$size = 1000000; //tamaño en bytes
			if(in_array($_FILES['upload']['type'], $formatos_admitidos)){
				if($_FILES['upload']['size'] >= $size){
					echo json_encode(array('error' => array('El archivo excede el tamaño permitido.')));
				}else{
					$imagen = explode('.', $_FILES['upload']['name']);
					$formato = end($imagen);
					$nombre_imagen = $_POST['codigo'] . '.' . $formato;
					$_ajax->updateImagen($_POST['codigo'], $nombre_imagen);
					$ruta = ROOT . 'publico' . DS . 'img' . DS . 'inventario' . DS . $nombre_imagen;
					move_uploaded_file($_FILES['upload']['tmp_name'], $ruta);
					echo json_encode(array('type' => 'success', 'imagen' => $nombre_imagen));
				}
			}else{
				echo json_encode(array('type' => 'error', 'mensaje' => array('El archivo tiene un formato incorrecto.')));
			}
		}else{
			echo json_encode(array('type' => 'error', 'mensaje' => array('Hubo un error al subir el archivo.')));
		}
	}
?>