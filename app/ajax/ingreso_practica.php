<?php
	require_once 'include.php';
	if($_POST){
		$alumno = $_ajax->getAlumno($_POST['codigo']);
		if($alumno){
			if(!($_ajax->checkIngresoPractica($_POST['codigo'], $_POST['id']))){
				$_ajax->ingresoPractica($_POST['codigo'], $_POST['id']);
				$element =  '<td>' . $alumno['codigo_alumno'] . '</td>' .
								'<td>' . ucwords($alumno['nombre_alumno']) . ' ' . ucwords($alumno['apellidos_alumno']) . '</td>';
				$result = array(
					'type' => 'success',
					'element' => $element
				);
				echo json_encode($result);
			}else{
				echo json_encode(array('type' => 'error', 'message' => 'Este Alumno ya Ingreso'));
			}
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'Alumno no encontrado'));
		}
	}
?>