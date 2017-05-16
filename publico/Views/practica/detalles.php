<?php
	$practica = $datos[0];
	$alumnos = $datos[1];
?>
<div class="container">
		<div class="col-lg-2 col-lg-offset-8">
			<form action="<?php echo URL ?>pdf.php" method="POST" id="pdf">
				<input type="hidden" name="info" id="info">
				<input type="hidden" name="name" id="name" value="Reporte de Practica">
				<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="" data-original-title="Descargar" onclick="pdf()"><i class="material-icons prefix">file_download</i></button>
			</form>
		</div>
		<a href="<?php echo URL, 'practica' ?>"><button class="btn">Regresar</button></a>
	<div class="col-lg-9" id="details">
		<div class="row">
			<div class="col-lg-12">
				<strong class="big-font">Nombre de la practica: </strong>
				<span class="big-font"><?php echo ucwords($practica['nombre_practica'])?></span>
			</div>
		</div>
		<div class="divider"></div>
		<div class="row">
			<div class="col-lg-12">
				<strong class="big-font">Maestro: </strong>
				<span class="big-font"><?php echo ucwords($practica['nombre_maestro']), ' ', ucwords($practica['apellidos_maestro']); ?></span>
			</div>
		</div>
		<div class="divider"></div>
		<div class="row">
			<div class="col-lg-6">
				<strong class="big-font">Materia: </strong>
				<span class="big-font"><?php echo ucwords($practica['nombre_materia']) ?></span>
			</div>
			<div class="col-lg-6">
				<strong class="big-font">Alumnos: </strong>
				<span class="big-font"><?php echo count($alumnos) . '/' . $practica['numero_alumnos_practica'] ?></span>
			</div>
		</div>
		<div class="divider"></div>
		<div class="row">
			<div class="col-lg-6">
				<strong class="big-font">Fecha: </strong>
				<span class="big-font"><?php echo translateDate($practica['fecha_practica']) ?></span>
			</div>
			<div class="col-lg-6">
				<strong class="big-font">Hora: </strong>
				<span class="big-font"><?php echo date("h:i a", strtotime($practica['hora_practica'])) ?></span>
			</div>
		</div>
	</div>
</div>
<div class="divider"></div>
<div class="container">
	<div class="row">
		<div class="table-responsive" id="list">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Código del alumno</th>
						<th>Nombre del alumno</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($alumnos as $alumno) {
							echo '<tr>';
							echo '<td>', $alumno['codigo_alumno'], '</td>';
							echo '<td>', ucwords($alumno['nombre_alumno']), ' ', ucwords($alumno['apellidos_alumno']), '</td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	function pdf(){
		var table = document.getElementById('list').innerHTML;
		var details = document.getElementById('details').innerHTML;
		table = table.replace('table class="table table-hover"', 'table class="table table-bordered"');
		var table = table.replace('<th>Detalles</th>', '');
		table = table.split('<tr>');
		for(x = 1; x<table.length; x++){
			table[x] = table[x].replace(/<td><a href.*td>/, '');
		}
		details = details.replace(new RegExp('col-lg', 'g'), 'col-xs');
		//details = details.replace('col-lg', 'col-xs');
		table = '<div class="row" style="background-color: #888888;"><div class="col-xs-6 col-xs-offset-3"><h3 class="header">Reporte de Practica</h3></div></div><br>' + details + '<br><div class="row" style="background-color: #888888;"><div class="col-xs-6 col-xs-offset-3"><h4 class="header">Ingresos</h4></div></div><br>' + table.join('<tr>');
		var form = document.getElementById('pdf');
		document.getElementById('info').value = table;
		//console.log(details);
		form.submit();
	}
</script>