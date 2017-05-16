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
				if(count($row) == 6){
					$valores = array(
						'nombre' => trim(mb_strtolower($row[0])),
						'cantidad' => trim(mb_strtolower($row[1])),
						'compra' => trim(mb_strtolower($row[2])),
						'caducidad' => trim(mb_strtolower($row[3])),
						'caracteristicas' => trim(mb_strtolower($row[4])),
						'codigo' => trim(mb_strtolower($row[5]))
					);
					foreach ($valores as $key => $value) {
						if(!pattern($value)){
							$error[$valores['codigo']][$key]['pattern'] = "Solo puede contener letras, números, espacios, \"/\" y \"-\".";
						}
						if($key == 'codigo'){
							if($_ajax->get('inventario', 'codigo_inv', mb_strtoupper($value))){
								$error[$valores['codigo']][$key]['unique'] = 'Este código ya fue ingresado';
							}
						}
					}
					if(!count($error)>0){
							$codigos[$valores['nombre']] = array(
								'cantidad' => $valores['cantidad'],
								'compra' => $valores['compra'],
								'caducidad' => $valores['caducidad'],
					    		'caracteristicas' => $valores['caracteristicas'],
					    		'codigo' => $valores['codigo']
						);
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
		//print_r($codigos);
		if(count($codigos) > 0){
			$_ajax->agregarConsumibles($codigos);
		}
		if(count($errores) > 0){
			echo json_encode(array('errores' => $errores));
		}else{
			echo json_encode(array('errores' => $codigos));
		}
	}
?>
