<?php
	$info = $datos['info'];
	$results = $datos['results'];
	$solicitante = $datos['solicitante'];
?>
<div class="container">
	<div class="row">
		<div class="col-lg-4">
			<a href="<?php echo URL, 'prestamo' ?>" class="btn">Regresar</a>
		</div>
		<div class="col-lg-2 col-lg-offset-6">
			<form action="<?php echo URL ?>publico/firmar.php" method="POST" id="pdf">
				<input type="hidden" name="info" id="info">
				<input type="hidden" name="name" id="name" value="inventario_equipo">
				<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="" data-original-title="Descargar" onclick="pdf()"><i class="material-icons prefix">file_download</i></button>
			</form>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<strong class="big-font"><?php echo ucfirst($solicitante) ?>: </strong>
			<span class="big-font"><?php echo ($solicitante == 'alumno') ? ucwords($info['nombre_alumno']) . ' ' . ucwords($info['apellidos_alumno']) : ucwords($info['nombre_maestro']) . ' ' . ucwords($info['apellidos_maestro'])?></span>
		</div>
	</div>
	<?php if($solicitante == 'alumno'){ ?>
	<div class="divider"></div>
	<div class="row">
		<div class="col-lg-12">
			<strong class="big-font">Carrera: </strong>
			<span class="big-font"><?php echo ucwords($info['carrera']); ?></span>
		</div>
	</div>
	<?php } ?>
	<div class="divider"></div>
	<div class="row">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Código Etiqueta</th>
						<th>Fecha de Préstamo</th>
						<th>Fecha de Entrega</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($results as $result){
							?>
							<tr>
								<td><?php echo $result['tb_codigo_inventario_codigo_etiqueta'] ?> </td>
								<td><?php echo ($solicitante == 'alumno') ? translateDate($result['fecha_prestamo']) : translateDate($result['fecha_prestamo_maestro']) ?></td>
								<td><?php echo ($solicitante == 'alumno') ? translateDate($result['fecha_entrega']) : translateDate($result['fecha_entrega_maestro']) ?></td>
								<td>
									<button type="button" class="btn btn-raised btn-primary btn-sm eliminar" onclick="ajax_json_data(this, '<?php echo $result['tb_codigo_inventario_codigo_etiqueta']?>', '<?php echo $result['prestamos_id_prestamo'] ?>')">Recibir</button>
								<button type="button" class="btn btn-raised btn-primary btn-sm eliminar" onclick="dañado(this, '<?php echo $result['tb_codigo_inventario_codigo_etiqueta']?>', '<?php echo $result['prestamos_id_prestamo'] ?>')">Dañado</button>
								</td>
							</tr>
							<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	function ajax_json_data(element, codigo, id){
 		ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>recibir_alumno.php", true);
 		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		swal({
		  	title: "Recibir Material",
		  	text: "¿Seguro que quieres recibir este material?",
		  	type: "warning",
		  	showCancelButton: true,
		  	confirmButtonColor: "#DD6B55",
		  	confirmButtonText: "Recibir!",
		  	cancelButtonText: "Cancelar",
		  	closeOnConfirm: true
		},
		function(){
	    	ajax.onreadystatechange = function() {
				if(ajax.readyState == 4 && ajax.status == 200) {
					if(ajax.responseText == true){
						element.parentNode.parentNode.remove(element.parentNode);
					}
	      	}
	    	}
	    	ajax.send('codigo='+codigo+'&id='+id);
		});
	}
	function dañado(element, codigo, id){
		ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>recibir_dañado.php", true);
 		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		swal({
		  	title: "Recibir Material Dañado",
		  	text: "¿Seguro que quieres registrar este material como dañado, se ponndra sanción al alumno?",
		  	type: "warning",
		  	showCancelButton: true,
		  	confirmButtonColor: "#DD6B55",
		  	confirmButtonText: "Recibir!",
		  	cancelButtonText: "Cancelar",
		  	closeOnConfirm: true
		},
		function(){
	    	ajax.onreadystatechange = function() {
				if(ajax.readyState == 4 && ajax.status == 200) {
					if(ajax.responseText == true){
						element.parentNode.parentNode.remove(element.parentNode);
					}
	      	}
	    	}
	    	ajax.send('codigo='+codigo+'&id='+id+'&alumno='+'<?php echo $info['codigo_alumno'] ?>');
		});
	}
	function pdf(){
		var form = document.getElementById('pdf');
		document.getElementById('info').value = '<?php echo json_encode($info) ?>';
		form.submit();
	}
</script>