<div class="container">
	<div class="row">
		<div class="col-lg-4">
			<select class="form-control" onchange="view(this.value)">
				<option value="todos">Todos</option>
				<option value="activos">Activos</option>
				<option value="inactivos">Inactivos</option>
			</select>
		</div>
	</div>
</div>
<div class="container">
	<div class="bs-component col-lg-2">
		<ul class="nav nav-stacked" style="margin-bottom: 15px;">
			<li><a href="<?php echo URL . 'alumnos/agregar'; ?>">Agregar</a></li>
			<li><a href="<?php echo URL . 'usuario/administrar'; ?>">Regresar</a></li>
		</ul>
	</div>
	<div class="col-lg-10">
		<div class="row">
			<div class="table-responsive" id="list">
			<?php echo todos($datos) ?>
			</div>
		</div>
	</div>
</div>
<?php
	function todos($datos){
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
				return $table;
	}
?>
<script type="text/javascript">
	function view(value){
		if(value === 'todos'){
			$('table').remove();
			document.getElementById('list').innerHTML='<?php echo todos($datos) ?>';
		}else{
			ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>alumnos.php", true);
		   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		   ajax.onreadystatechange = function() {
			   if(ajax.readyState == 4 && ajax.status == 200){
					$('table').remove();
					document.getElementById('list').innerHTML=ajax.responseText;
			   }
		   }
		   ajax.send('estado='+value);
		}
	}

	function cambiar_estado(button, codigo, estado){
		ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>dar_baja_alumno.php", true);
		   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		   ajax.onreadystatechange = function() {
			   if(ajax.readyState == 4 && ajax.status == 200){
					if(estado){
						var changeButton = '<button onclick="cambiar_estado(this, ' + codigo + ', ' + 0 + ')">Dar de Baja</button>';
					}else{
						var changeButton = '<button onclick="cambiar_estado(this, ' + codigo + ', ' + 1 + ')">Dar de Alta</button>';
					}
					var parent = button.parentNode
					parent.removeChild(button);
					parent.innerHTML += changeButton;
			   }
		   }
		   ajax.send('codigo='+codigo+'&estado='+estado);
	}
</script>