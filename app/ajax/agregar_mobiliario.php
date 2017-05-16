<?php
	if($_FILES){
		require_once 'include.php';
		$codigos = array();
		$errores = array();
		$file = fopen($_FILES['upload']['tmp_name'], "r");
		if ($file){
			while(($line = fgets($file)) !== false) {
				$error = array();
				$row = explode(',', $line);
				if(count($row) == 3){
					$valores = array(
						'nombre' => trim(mb_strtolower($row[0])),
						'codigo' => trim(mb_strtolower($row[1])),
						'caracteristicas' => trim(mb_strtolower($row[2]))
					);
					foreach ($valores as $key => $value) {
						if(!pattern($value)){
							$error[$valores['codigo']][$key]['pattern'] = "Solo puede contener letras, números, espacios, \"/\" y \"-\".";
						}
						if($key == 'codigo'){
							if($_ajax->get('tb_codigo_inventario', 'codigo_etiqueta', mb_strtoupper($value))){
								$error[$valores['codigo']][$key]['unique'] = 'Este código ya fue ingresado';
							}
						}
					}
					if(!count($error)>0){
						if(!array_key_exists($valores['nombre'], $codigos)){
							$codigos[$valores['nombre']] = array(
					    		'caracteristicas' => $valores['caracteristicas'],
					    		'codigos' => array($valores['codigo'])
						);
			    		}else{
			    			$codigos[$valores['nombre']]['codigos'][] = $valores['codigo'];
			    		}
					}else{
						if(!array_key_exists($valores['nombre'], $errores)){
							$errores[$valores['nombre']] = $error;
						}else{
							$key = key($error);
							$errores[$valores['nombre']][$key] = $error[$key];
						}
					}
				}else{
				}
			}
			fclose($file);
		}
		if(count($codigos) > 0){
			$_ajax->agregarMobiliario($codigos);
		}
		if(count($errores) > 0){
			echo json_encode(array('errores' => $errores));
		}else{
			echo json_encode(array('errores' => false));
		}
	}
?>
