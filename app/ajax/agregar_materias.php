<?php
	if($_FILES){
		require_once 'include.php';
		$materias = array();
		$errores = array();
		$file = fopen($_FILES['upload']['tmp_name'], "r");
		if ($file){
			while(($line = fgets($file)) !== false){
				$error = array();
				$row = explode(',', $line);
				if(count($row) == 2){
					$valores = array(
						'codigo' => trim(mb_strtolower($row[0])),
						'nombre' => trim(mb_strtolower($row[1])),
					);
					foreach ($valores as $key => $value) {
						if(!pattern($value)){
							$error[$key]['pattern'] = "Solo puede contener letras, números, espacios, \"/\" y \"-\".";
						}
						if($key == 'codigo'){
							if($_ajax->get('materia', 'id_materia', $value)){
								$error[$value]['unique'] = array($valores['nombre'], 'Esta materia ya fue ingresada');
							}
						}
					}
					if(!count($error)>0){
						if(!array_key_exists($valores['codigo'], $materias)){
							$materias[$valores['codigo']] = array(
					    		'nombre' => $valores['nombre'],
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
		if(count($materias) > 0){
			$_ajax->agregarMaterias($materias);
		}
		if(count($errores) > 0){
			echo json_encode(array('errores' => $errores));
		}else{
			echo json_encode(array('errores' => false));
		}
	}
?>
