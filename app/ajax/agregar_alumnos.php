<?php
	if($_FILES){
		require_once 'include.php';
		$alumnos = array();
		$errores = array();
		$file = fopen($_FILES['upload']['tmp_name'], "r");
		if ($file){
			while(($line = fgets($file)) !== false){
				$error = array();
				$row = explode(',', $line);
				if(count($row) == 4){
					$valores = array(
						'codigo' => trim(mb_strtolower($row[0])),
						'nombre' => trim(mb_strtolower($row[1])),
						'apellidos' => trim(mb_strtolower($row[2])),
						'carrera' => trim(mb_strtolower($row[3]))
					);
					foreach ($valores as $key => $value) {
						if(!pattern($value)){
							$error[$key]['pattern'] = "Solo puede contener letras, números, espacios, \"/\" y \"-\".";
						}
						if($key == 'codigo'){
							if($_ajax->get('alumnos', 'codigo_alumno', $value)){
								$error[$key]['unique'] = 'Este código ya fue ingresado';
							}
						}
					}
					if(!count($error)>0){
						if(!array_key_exists($valores['codigo'], $alumnos)){
							$alumnos[$valores['codigo']] = array(
					    		'nombre' => $valores['nombre'],
								'apellidos' => $valores['apellidos'],
								'carrera' => $valores['carrera']
							);
						}
					}else{
						if(!array_key_exists($valores['codigo'], $errores)){
							$errores[$valores['codigo']] = $error;
						}else{
							$key = key($error);
							$errores[$valores['codigo']][$key] = $error[$key];
						}
					}
				}else{
				}
			}
			fclose($file);
		}
		if(count($alumnos) > 0){
			$_ajax->agregarAlumnos($alumnos);
		}
		if(count($errores) > 0){
			echo json_encode(array('errores' => $errores));
		}else{
			echo json_encode(array('errores' => false));
		}
	}
?>
