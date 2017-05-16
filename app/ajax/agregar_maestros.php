<?php
	if($_FILES){
		require_once 'include.php';
		$maestros = array();
		$errores = array();
		$file = fopen($_FILES['upload']['tmp_name'], "r");
		if ($file){
			while(($line = fgets($file)) !== false){
				$error = array();
				$row = explode(',', $line);
				if(count($row) == 3){
					$valores = array(
						'codigo' => trim(mb_strtolower($row[0])),
						'nombre' => trim(mb_strtolower($row[1])),
						'apellidos' => trim(mb_strtolower($row[2]))
					);
					foreach ($valores as $key => $value) {
						if(!pattern($value)){
							$error[$key]['pattern'] = "Solo puede contener letras, números, espacios, \"/\" y \"-\".";
						}
						if($key == 'codigo'){
							if($_ajax->get('maestros', 'codigo_maestro', $value)){
								$error[$value]['unique'] = array($valores['nombre'].' '.$valores['apellidos'], 'Esta maestro ya fue ingresado');
							}
						}
					}
					if(!count($error)>0){
						if(!array_key_exists($valores['codigo'], $maestros)){
							$maestros[$valores['codigo']] = array(
					    		'nombre' => $valores['nombre'],
					    		'apellidos' => $valores['apellidos']
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
		if(count($maestros) > 0){
			$_ajax->agregarMaestros($maestros);
		}
		if(count($errores) > 0){
			echo json_encode(array('errores' => $errores));
		}else{
			echo json_encode(array('errores' => false));
		}
	}
?>
