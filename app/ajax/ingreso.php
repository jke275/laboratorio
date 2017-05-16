<?php
	require_once 'include.php';
	if($_POST){
		$hora = date('H:i:s');
		$fecha = date('Y-m-d');
		$alumno = $_ajax->getAlumno($_POST['codigo']);
		if($alumno){
			if(!$_ajax->checkIngreso($_POST['codigo'])){
				$_ajax->agregarIngreso($_POST['codigo'], $fecha, $hora);
				$element =  '<td>' . $alumno['codigo_alumno'] . '</td>' .
								'<td>' . ucwords($alumno['nombre_alumno']) . ' ' . ucwords($alumno['apellidos_alumno']) . '</td>' .
								'<td>' . date('H:i a', strtotime($hora)) . '</td>' .
								'<td><button onclick="salir_ajax(this, \'' . $alumno['codigo_alumno'] . '\', \'' . $fecha . '\', \'' . $hora . '\')">Salir</button></td>';
				$result = array('type' => 'success', 'element' => $element);
				echo json_encode($result);
			}else{
				echo json_encode(array('type' => 'error', 'message' => 'Este Alumno ya Ingreso'));
			}
		}else{
			echo json_encode(array('type' => 'error', 'message' => 'Alumno no encontrado'));
		}
	}
?>