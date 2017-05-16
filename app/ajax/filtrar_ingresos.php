<?php
	if($_POST){
		require_once 'include.php';
		$ingresos = $_ajax->filtrarIngresos($_POST['fecha']);
		$table = '';
		$table .= '<table class="table table-hover">';
		$table .= '<thead>';
		$table .= '<tr>';
		$table .= '<th>Fecha</th>';
		$table .= '<th>Hora de Ingreso</th>';
		$table .= '<th>Hora de Salida</th>';
		$table .= '<th>Código Alumno</th>';
		$table .= '<th>Nombre Alumno</th>';
		$table .= '</tr>';
		$table .= '</thead>';
		$table .= '<tbody>';
		foreach($ingresos as $ingreso){
			$table .= '<tr>';
			$table .= '<td>' . translateDate($ingreso['fecha_ingreso']) . '</td>';
			$table .= '<td>' . date('h:i a', strtotime($ingreso['hora_ingreso'])) . '</td>';
			$table .= '<td>' . date('h:i a', strtotime($ingreso['hora_salida'])) . '</td>';
			$table .= '<td>' . mb_strtoupper($ingreso['codigo_alumno']) . '</td>';
			$table .= '<td>' . ucwords($ingreso['nombre_alumno'] . ' ' . $ingreso['apellidos_alumno']) . '</td>';
			$table .= '</tr>';
		}
		$table .= '</tbody>';
		$table .= '</table>';
		echo $table;
	}
?>