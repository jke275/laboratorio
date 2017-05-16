<?php
	if($_FILES){
		require_once 'include.php';
		//var_dump($_POST['fle']);
		//var_dump($gestor);
		//$gestor = fopen($_FILES['upload']['tmp_name'], "r");
		//var_dump($gestor);
		//print_r($_FILES['upload']['tmp_name']);
		/*$fila = 1;
		if (($gestor = fopen($_FILES['upload']['tmp_name'], "r")) !== FALSE) {
		    while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
		        $numero = count($datos);
		        echo "$numero de campos en la línea $fila:\n";
		        $fila++;
		        for ($c=0; $c < $numero; $c++) {
		            echo $datos[$c] . "\n";
		        }
		    }
		    fclose($gestor);
		}*/
		//$materiales = array_map('str_getcsv', file($_FILES['upload']['tmp_name']));
		//var_dump($csv);
		/*$codigos = array();
		foreach($materiales as $material){
			$codigos[] = $material;
		}
		print_r($codigos);*/
		$codigos = array();
		$errores = array();
		$file = fopen($_FILES['upload']['tmp_name'], "r");
		if ($file){
			while(($line = fgets($file)) !== false) {
				$error = array();
				// process the line read.
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
					/*$_validate->check($valores, array(
						'nombre' => array(
							'type' => 'string',
							'reuqire' => true
						),
						'codigo' => array(
							'type' => 'string',
							'reuqire' => true
						),
						'caracteristicas' => array(
							'type' => 'string',
							'reuqire' => true
						)
					));
					print_r($_validate->errors());
					//var_dump($_validate->passed());*/
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
							//$errores[$valores['nombre']] = $error;
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
			$_ajax->agregarMaterial($codigos);
		}
		if(count($errores) > 0){
			echo json_encode(array('errores' => $errores));
		}else{
			echo json_encode(array('errores' => false));
		}
	    	/*$id = $valores[1] . '-' . $valores[2];
	    	if(count($valores) == 6){
	    		if(!array_key_exists($id, $codigos)){
			    	$codigos[$id] = array(
			    		'nombre' => trim(mb_strtolower($valores[0])),
			    		'marca' => trim(mb_strtolower($valores[1])),
			    		'modelo' => trim(mb_strtolower($valores[2])),
			    		'no_serie' => array(trim(mb_strtolower($valores[3]))),
			    		'caracteristicas' => trim(mb_strtolower($valores[4])),
			    		'codigos' => array(trim(mb_strtolower($valores[5])))
			    	);
	    		}else{
	    			$codigos[$id]['codigos'][] = trim(mb_strtolower($valores[5]));
	    			$codigos[$id]['no_serie'][] = trim(mb_strtolower($valores[3]));
	    			//$cantidad++;
	    		}
	    	}else{
	    	}*/
	}
?>
