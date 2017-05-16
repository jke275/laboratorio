<?php
	require_once 'include.php';
	if($_POST){
		$activo = ($_POST['estado'] == 'activos') ? 1 : 0;
		$datos = $_ajax->getAllAlumnos($activo);
		$table = '<table class="table table-hover">';
		$table .= '<thead>';
		$table .= '<tr>';
		$table .= '<th>Código</th>';
		$table .= '<th>Nombre</th>';
		$table .= '<th>Carrera</th>';
		$table .= '<th>Sanción</th>';
		$table .= '<th>Editar</th>';
		$table .= '</tr>';
		$table .= '</thead>';
		$table .= '<tbody>';
						foreach($datos as $alumno){
							$table .= '<tr>';
								$table .= '<td>' . strtoupper($alumno['codigo_alumno']) . '</td>';
								$table .= '<td>' . ucwords($alumno['nombre_alumno'] . ' ' . $alumno['apellidos_alumno']) . '</td>';
								$table .= '<td>' . ucwords($alumno['carrera']) . '</td>';
								$table .= '<td>';
								$table .= ($alumno['sancion']) ? translateDate($alumno['sancion']) : 'Sin sanción';
								$table .= '</td>';
								$table .= '<td>';
								$table .= '<a data-toggle="tooltip" data-placement="left" title="" data-original-title="Editar"  href = "' . URL . 'alumnos/editar/' . $alumno['codigo_alumno'] . '" class="drop" ><i class="material-icons">mode_edit</i></a>';
								if($alumno['activo']){
										$table .= '<button onclick="cambiar_estado(this, ' . $alumno['codigo_alumno'] . ', 0)">Dar de Baja</button>';
								}else{
										$table .= '<button onclick="cambiar_estado(this, ' . $alumno['codigo_alumno'] . ', 1)">Dar de Alta</button>';
								}
								$table .= '</td>';
							$table .= '</tr>';
							}
				$table .= '</tbody></table>';
				echo $table;
	}
?>