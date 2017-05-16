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
			    		'marca' => trim(mb_strtolower($row[1])),
			    		'modelo' => trim(mb_strtolower($row[2])),
			    		'no_serie' => trim(mb_strtolower($row[3])),
			    		'caracteristicas' => trim(mb_strtolower($row[4])),
			    		'codigo' => trim(mb_strtolower($row[5]))
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
					$id = str_replace('/', '-', $valores['marca']) . '-' . str_replace('/', '-', $valores['modelo']);
					if(!count($error)>0){
						if(!array_key_exists($id, $codigos)){
					    	$codigos[$id] = array(
					    		'nombre' => trim(mb_strtolower($row[0])),
					    		'marca' => trim(mb_strtolower($row[1])),
					    		'modelo' => trim(mb_strtolower($row[2])),
					    		'no_serie' => array(trim(mb_strtolower($row[3]))),
					    		'caracteristicas' => trim(mb_strtolower($row[4])),
					    		'codigos' => array(trim(mb_strtolower($row[5])))
					    	);
			    		}else{
			    			$codigos[$id]['codigos'][] = trim(mb_strtolower($row[5]));
			    			$codigos[$id]['no_serie'][] = trim(mb_strtolower($row[3]));
			    		}
					}else{
						if(!array_key_exists($id, $errores)){
							$errores[$id] = $error;
						}else{
							$key = key($error);
							$errores[$id][$key] = $error[$key];
						}
					}
				}else{
				}
			}
			fclose($file);
		}
		if(count($codigos) > 0){
			$_ajax->agregarEquipo($codigos);
		}
		if(count($errores) > 0){
			echo json_encode(array('errores' => $errores));
		}else{
			echo json_encode(array('errores' => false));
		}
	}
?>
