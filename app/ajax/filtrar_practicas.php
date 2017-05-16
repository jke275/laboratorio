<?php
	if($_POST){
		require_once 'include.php';
		$practicas = $_ajax->filtrarPracticas($_POST['mes']);

		$table = '';
		$table .= '<table class="table table-hover">';
		$table .= '<thead>';
		$table .= '<tr>';
		$table .= '<th>Fecha</th>';
		$table .= '<th>Hora</th>';
		$table .= '<th>Nombre</th>';
		$table .= '<th>Materia</th>';
		if($_SESSION['type'] == 'admin'){
			$table .= '<th>Maestro</th>';
		}
		$table .= '<th>Estado</th>';
		$table .= '<th>Ingresos</th>';
		$table .= '<th>Detalles</th>';
		$table .= '</tr>';
		$table .= '</thead>';
		$table .= '<tbody>';
		foreach($practicas as $practica){
			$table .= '<tr>';
			$table .= '<td>' . translateDate($practica['fecha_practica']) . '</td>';
			$table .= '<td>' . date('h:i a', strtotime($practica['hora_practica'])) . '</td>';
			$table .= '<td>' . ucfirst($practica['nombre_practica']) . '</td>';
			$table .= '<td>' . ucfirst($practica['nombre_materia']) . '</td>';
			if($_SESSION['type'] == 'admin'){
				$table .= '<td>' . ucfirst($practica['nombre_maestro']) . ' ' . ucwords($practica['apellidos_maestro']) . '</td>';
			}
			$table .= '<td>' . ucfirst($practica['estado']) . '</td>';
			if($practica['estado'] == 'aceptada'){
				$table .= '<td><a href = "' . URL . 'practica/ingreso/' . $practica['id_practica'] . '"><i class="material-icons prefix">forward</i></a></td>';
			}else if($practica['estado'] == 'realizada'){
				$table .= '<td>' . $db->get('ingreso_practica', array('practica_id_practica', '=', $practica['id_practica']))->count() . '/' . $practica['numero_alumnos_practica'] . '</td>';
				$table .= '<td><a href = "' . URL . 'practica/detalles/' . $practica['id_practica'] . '"><i class="material-icons prefix">forward</i></a></td>';
			}
			$table .= '<td><a data-toggle="tooltip" data-placement="rigth" title="" data-original-title="Eliminar"  onclick="eliminar(\'' . $practica['id_practica'] . '\', event)"><i class="material-icons prefix">delete</i></a></td></tr>';
			$table .= '</tr>';
		}
		$table .= '</tbody>';
		$table .= '</table>';
		echo $table;
	}
?>