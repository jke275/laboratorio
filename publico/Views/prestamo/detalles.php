<?php
use app\Core\Config;
	$solicitante = $datos['solicitante'];
	$info = $datos['info'];
	$prestamo = $datos['prestamo'];
	$materiales = $datos['materiales'];
?>
<div class="container">
	<div class="row">
		<div class="col-lg-4">
			<a href="<?php echo URL, 'prestamo/ver/', $solicitante, '/', ($info['codigo_alumno']) ? $info['codigo_alumno'] : $info['codigo_maestro'] ?>" class="btn btn-raised">Regresar</a>
		</div>
		<div class="col-lg-2 col-lg-offset-6">
			<form action="<?php echo URL ?>publico/firmar.php" method="POST" id="pdf">
				<input type="hidden" name="alumno" id="alumno">
				<input type="hidden" name="prestamo" id="prestamo">
				<input type="hidden" name="materiales" id="materiales">
				<input type="hidden" name="root" id="root" value="<?php echo ROOT ?>">
				<input type="hidden" name="laboratorio" id="laboratorio" value="<?php echo Config::get('laboratorio') ?>">
				<input type="hidden" name="name" id="name" value="reporte prestamo">
				<button type="button" class="btn btn-raised" data-toggle="tooltip" data-placement="left" title="" data-original-title="Descargar" onclick="pdf()">Descargar Reporte</button>
			</form>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-lg-6">
			<strong class="big-font"><?php echo ucwords($solicitante) ?>: </strong>
			<span class="big-font"><?php echo ($info['codigo_alumno']) ? ucwords($info['nombre_alumno']) . ' ' . ucwords($info['apellidos_alumno']) : ucwords($info['nombre_maestro']) . ' ' . ucwords($info['apellidos_maestro'])?></span>
		</div>
		<?php if($solicitante == 'alumno'){ ?>
		<div class="col-lg-6">
			<strong class="big-font">Carrera: </strong>
			<span class="big-font"><?php echo ucwords($info['carrera']); ?></span>
		</div>
		<?php } ?>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col-lg-6">
			<strong class="big-font">Fecha Prestamo: </strong>
			<span class="big-font"><?php echo translateDate($prestamo['fecha_prestamo']); ?></span>
		</div>
		<div class="col-lg-6">
			<strong class="big-font">Fecha Entrega: </strong>
			<span class="big-font"><?php echo translateDate($prestamo['fecha_entrega']); ?></span>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col-lg-12">
			<strong class="big-font">Responsable del Prestamo: </strong>
			<span class="big-font"><?php echo ucwords($prestamo['responsable_prestamo']); ?></span>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Código Etiqueta</th>
						<th>Nombre Material</th>
						<th>Estado</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($materiales as $material){
							?>
							<tr>
								<td><?php echo $material['tb_codigo_inventario_codigo_etiqueta'] ?> </td>
								<td><?php echo $material['nombre_inv'] ?></td>
								<td><?php echo ($material['recibido']) ? 'Recibido' : 'Prestado' ?></td>
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
	function pdf(){
		var form = document.getElementById('pdf');
		document.getElementById('alumno').value = '<?php echo json_encode($info) ?>';
		document.getElementById('prestamo').value = '<?php echo json_encode($prestamo) ?>';
		document.getElementById('materiales').value = '<?php echo json_encode($materiales) ?>';
		form.submit();
	}
</script>