<?php
	if($_POST){
		require_once 'include.php';
		$elements =  json_decode($_POST['elements'], true);
		$codigos = array();
		$errors = array();
		$x = 1;
		foreach ($elements as $element) {
			if($material = $_ajax->get('inventario', 'nombre_inv', $element['nombre'])){
				if($material['cantidad_inv'] > $element['cantidad']){
					$codigos[] = array(
						'codigo_inv' => $material['codigo_inv'],
						'cantidad' => $element['cantidad']
					);
				}else{
					$errors['elemento' . $x] = array('elemento' => $element['nombre'], 'error' => 'Cantidad insuficiente, solo hay ' . (string)($material['cantidad_inv'] - 1) . ' disponibles');
				}
			}else{
				$errors['elemento' . $x] = array('elemento' => $element['nombre'], 'error' => 'Material no encontrado');
			}
			$x++;
		}
		if(count($errors)<=0){
			echo $_ajax->materialPractica($_POST['id'], $codigos);
		}
		echo json_encode($errors);
	}
?>