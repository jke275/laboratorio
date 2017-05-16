<?php
	if($_POST){
		require_once 'include.php';
		if($_POST['table'] == 'prestados'){
			echo comprimido($_ajax->viewPrestamos(false));
		}else{
			echo comprimido($_ajax->viewPrestamos(true));
		}
	}
	function comprimido($form){
		$table = '<table class="table table-hover">
						<thead>
							<tr>
								<th>Fecha Préstamo</th>
								<th>Fecha Devolución</th>
								<th>Código Alumno</th>
								<th>Nombre Alumno</th>
								<th>Código Material</th>
								<th>Nombre Material</th>
							</tr>
						</thead>
						<tbody>';
		foreach($form as $prestamo){
			$table .= '<tr>';
			$table .= '<td>' . translateDate($prestamo['fecha_prestamo']) . '</td>';
			$table .= '<td>' . translateDate($prestamo['fecha_entrega']) . '</td>';
			$table .= '<td>' . $prestamo['alumnos_codigo_alumno'] . '</td>';
			$table .= '<td>' . ucwords($prestamo['nombre_alumno']) . ' ' . ucwords($prestamo['apellidos_alumno']) . '</td>';
			$table .= '<td>' . $prestamo['tb_codigo_inventario_codigo_etiqueta'] . '</td>';
			$table .= '<td>' . ucwords($prestamo['nombre_inv']) . '</td>';
		}
		$table .= '</tbody></table>';
		return $table;
	}
?>