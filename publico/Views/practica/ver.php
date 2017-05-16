<?php
	$detalles = $datos['detalles'];
	$materiales = $datos['materiales'];
?>
<div class="container">
	<div class="row">
		<div class="col-lg-3 col-lg-offset-9">
			<a href = "<?php echo URL ?>" class="btn btn-raised">Regresar</a>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<strong class="big-font">Nombre de la Practica: </strong>
			<span class="big-font"><?php echo ucwords($detalles['nombre_practica']); ?></span>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col-lg-12">
			<strong class="big-font">Cantidad de Alumnos: </strong>
			<span class="big-font"><?php echo ucfirst($detalles['numero_alumnos_practica']) ?></span>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col-lg-12">
			<strong class="big-font">Materia: </strong>
			<span class="big-font"><?php echo ucfirst($detalles['nombre_materia']) ?></span>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col-lg-12">
			<strong class="big-font">Maestro: </strong>
			<span class="big-font"><?php echo ucwords($detalles['nombre_maestro'] . ' ' . $detalles['apellidos_maestro']) ?></span>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col-lg-6">
			<strong class="big-font">Fecha: </strong>
			<span class="big-font"><?php echo translateDate($detalles['fecha_practica']) ?></span>
		</div>
		<div class="col-lg-6">
			<strong class="big-font">Hora: </strong>
			<span class="big-font"><?php echo date('h:i a', strtotime($detalles['hora_practica'])) ?></span>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col-lg-12">
			<strong class="big-font">Solicitante: </strong>
			<span class="big-font"><?php echo ucfirst($detalles['usuario_solicitante']) ?></span>
		</div>
	</div>
	<div class="divider"></div>
</div>

<div class="container">
	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Material</th>
					<th>Cantidad</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach($materiales as $material){
					echo '<tr>';
					echo '<td>', ucwords($material['nombre_inv']), '</td>';
					echo '<td>', $material['cantidad'], '</td>';
					echo '</tr>';
				}
			?>
		</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	document.getElementById('aprobar').addEventListener('click', function(){
		ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>aprobar_practica.php", true);
	   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	   ajax.onreadystatechange = function() {
		   if(ajax.readyState == 4 && ajax.status == 200) {
		   	if(ajax.responseText){
		   		window.location = '<?php echo URL ?>';
		   	}
		   }
	   }
	   ajax.send('id=' + '<?php echo $detalles['id_practica'] ?>');
	})
</script>