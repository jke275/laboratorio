<?php
	function todos($datos){
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
		foreach($datos as $ingreso){
			$table .= '<tr>';
			$table .= '<td>' . translateDate($ingreso['fecha_ingreso']) . '</td>';
			$table .= '<td>' . date('h:i a', strtotime($ingreso['hora_ingreso'])) . '</td>';
			if($ingreso['hora_salida']){
				$table .= '<td>' . date('h:i a', strtotime($ingreso['hora_salida'])) . '</td>';
			}else{
				$table .= '<td>Sin salida</td>';
			}
			$table .= '<td>' . mb_strtoupper($ingreso['codigo_alumno']) . '</td>';
			$table .= '<td>' . ucwords($ingreso['nombre_alumno'] . ' ' . $ingreso['apellidos_alumno']) . '</td>';
			$table .= '</tr>';
		}
		$table .= '</tbody>';
		$table .= '</table>';
		return $table;
	}
?>
<div class="container">
	<div class="row">
		<div class="col-lg-3">
			<div class="input-group">
				<input type="date" id="fecha" name="fecha" class="form-control date">
				<span class="input-group-btn">
					<button type="button" class="btn btn-raised btn-sm" onclick="filtrar()">Filtrar</button>
				</span>
			</div>
		</div>
		<div class="col-lg-2 col-lg-offset-7">
			<form action="<?php echo URL ?>pdf.php" method="POST" id="pdf">
				<input type="hidden" name="info" id="info">
				<input type="hidden" name="name" id="name" value="bitacora_ingresos">
				<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="" data-original-title="Descargar" onclick="pdf()"><i class="material-icons prefix">file_download</i></button>
			</form>
		</div>
	</div>
</div>
<div class="container">
	<div class="bs-component col-lg-2">
		<ul class="nav nav-stacked" style="margin-bottom: 15px;">
			<li class="active"><a aria-expanded="true" href="#uno" data-toggle="tab">Info<div class="ripple-container"></div></a></li>
			<li class=""><a aria-expanded="false" href="#varios" data-toggle="tab">Modificar<div class="ripple-container"></div></a></li>
			<li><a href="<?php echo URL . 'usuario/ingresos'; ?>">Ver Ingresos</a></li>
			<li><a href="<?php echo URL . 'usuario/respaldar'; ?>">Respaldo base de datos</a></li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="bootstrap-elements.html" data-target="#">
					Materias<i class="material-icons">arrow_drop_down</i>
				</a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo URL . 'materias'; ?>">Listar</a></li>
					<li class="divider"></li>
					<li><a href="<?php echo URL . 'materias/agregar'; ?>">Agregar</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="bootstrap-elements.html" data-target="#">
					Maestros<i class="material-icons">arrow_drop_down</i>
				</a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo URL . 'maestros'; ?>">Listar</a></li>
					<li class="divider"></li>
					<li><a href="<?php echo URL . 'maestros/agregar'; ?>">Agregar</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="bootstrap-elements.html" data-target="#">
					Alumnos<i class="material-icons">arrow_drop_down</i>
				</a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo URL . 'alumnos'; ?>">Listar</a></li>
					<li class="divider"></li>
					<li><a href="<?php echo URL . 'alumnos/agregar'; ?>">Agregar</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<div class="bs-component col-lg-10">
		<div class="table-responsive" id="list">
			<?php echo todos($datos) ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
      $('.date').bootstrapMaterialDatePicker({
        time: false,
        clearButton: true,
        format: 'DD-MM-YYYY',
        nowButton: true,
        cancelText: 'Cancelar',
        okText: 'Aceptar',
        clearText: 'Limpiar',
        nowText: "Hoy"
      });
    });

	function filtrar(){
		var fecha = document.getElementById('fecha').value;
		ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>filtrar_ingresos.php", true);
	   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	   ajax.onreadystatechange = function() {
		   if(ajax.readyState == 4 && ajax.status == 200){
				$('table').remove();
				document.getElementById('list').innerHTML=ajax.responseText;
		   }
	   }
	   ajax.send('fecha='+fecha);
	}

	function pdf(){
		var table = document.getElementById('list').innerHTML;
		table = table.replace('table class="table table-hover"', 'table class="table table-bordered"');
		//var table = table.replace('<th>Detalles</th>', '');
		//table = table.replace(/<td><a href.*td>/, '');
		table = '<h2>Bitacora de Ingresos</h2>' + table;
		var form = document.getElementById('pdf');
		document.getElementById('info').value = table;
		form.submit();
	}
</script>