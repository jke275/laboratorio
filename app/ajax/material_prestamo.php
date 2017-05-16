<?php
	require_once 'include.php';
	$noDisponible = array();
	$repetido = array();
	if($_POST){
		$codigos = json_decode($_POST['materiales'], true);
		$_validate->check($_POST, array(
			'objetivo' => array(
				'type' => 'string',
				'required' => true
			),
			'fecha-entrega' => array(
				'type' => 'date',
				'required' => true
			)
		));
		if($_validate->passed() && count($codigos) > 0){
			//Revisa si no hay codigos repetidos
			$elements = array_count_values($codigos);
			foreach ($elements as $element => $value) {
				if($value > 1){
					if(!in_array($element, $repetido)){
						$repetido[] = $element;
					}
				}
			}
			//Revisa si los codigos estan disponibles
			foreach($codigos as $codigo){
				if($_ajax->materialDisponible($codigo)['estado'] != 'disponible'){
					$noDisponible[] = $codigo;
				}
			}
			if(count($repetido) > 0){
				$result = array('type' => 'repetido', 'results' => $repetido);
				echo json_encode($result);
			}else{
				if(count($noDisponible) > 0){
					$result = array('type' => 'noDisponible', 'results' => $noDisponible);
					echo json_encode($result);
				}else{
					$id = $_ajax->materialPrestamo($_POST);
					$result = array('type' => 'success', 'id' => $id);
					echo json_encode($result);
				}
			}
		}else{
			$result = array('type' => 'errors', 'results' => $_validate->errors(), 'codigos' => $codigos);
			echo json_encode($result);
		}
	}
?>