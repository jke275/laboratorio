<?php
	require_once 'include.php';
	if($_POST){
		if($_POST['table'] == 'equipo'){
			echo extendidoEquipo($_ajax->view($_POST['table']));
		}elseif ($_POST['table'] == 'material' || $_POST['table'] == 'mobiliario') {
			echo extendido($_ajax->view($_POST['table']));
		}
	}

	function extendidoEquipo($datos){
		$table = '<table class="table table-hover">
						<thead>
							<tr>
								<th>Código</th>
								<th>Nombre</th>
								<th>Marca</th>
								<th>Modelo</th>
								<th>Número de Serie</th>
								<th>Características</th>
								<th>Estado</th>
							</tr>
						</thead>
						<tbody>';
		foreach($datos as $fila){
			$table .= '<tr>';
			$table .= '<td>' . mb_strtoupper($fila['codigo_etiqueta']) . '</td>';
			$table .= '<td>' . ucfirst($fila['nombre_inv']) . '</td>';
			$table .= '<td>' . ucfirst($fila['marca_equipo']) . '</td>';
			$table .= '<td>' . mb_strtoupper($fila['modelo_equipo']) . '</td>';
			$table .= '<td>' . ucfirst($fila['numero_serie']) . '</td>';
			$table .= '<td>' . ucfirst($fila['carac_equipo']) . '</td>';
			$table .= '<td>' . ucfirst($fila['estado']) . '</td>';
			$table .= '<td><a href = "' . URL . 'equipo/editar_codigo/' . $fila['codigo_inv'] . '/' . str_replace(' ', '_', $fila['codigo_etiqueta']) . '" data-toggle="tooltip" data-placement="left" title="" data-original-title="Editar código"><i class="material-icons prefix">mode_edite</i></a>';
			$table .= '<a data-toggle="tooltip" data-placement="rigth" title="" data-original-title="Eliminar" onclick="eliminar(this, \'' . $fila['codigo_etiqueta'] . '\', \'' . $fila['codigo_inv'] . '\', event)" href=""><i class="material-icons prefix">delete</i></a></td>';
			$table .= '</tr>';
		}
		$table .= 	'</tbody>
						</table>';
		return $table;
	}

	function extendido($datos){
		$table = '<table class="table table-hover">
						<thead>
							<tr>
								<th>Código</th>
								<th>Nombre</th>
								<th>Características</th>
								<th>Estado</th>
							</tr>
						</thead>
						<tbody>';
		foreach($datos as $fila){
			$table .= '<tr>';
			$table .= '<td>' . mb_strtoupper($fila['codigo_etiqueta']) . '</td>';
			$table .= '<td>' . ucfirst($fila['nombre_inv']) . '</td>';
			$table .= '<td>';
			$table .= ($fila['carac_material']) ? ucfirst($fila['carac_material']) : ucfirst($fila['carac_mobiliario']);
			$table .= '</td>';
			$table .= '<td>' . ucfirst($fila['estado']) . '</td>';
			$table .= '<td><a href = "' . URL . (($fila['tipo'] == 'material') ? 'instrumentos' : $fila['tipo']) . '/editar_codigo/' . $fila['codigo_inv'] . '/' . str_replace(' ', '_', $fila['codigo_etiqueta']) . '" data-toggle="tooltip" data-placement="left" title="" data-original-title="Editar código"><i class="material-icons prefix">mode_edite</i></a>';
			$table .= '<a data-toggle="tooltip" data-placement="rigth" title="" data-original-title="Eliminar" onclick="eliminar(this, \'' . $fila['codigo_etiqueta'] . '\', \'' . $fila['codigo_inv'] . '\', event)" href=""><i class="material-icons prefix">delete</i></a></td>';
			$table .= '</tr>';
		}
		$table .= '</tbody></table>';
		return $table;
	}
?>