<?php
	use app\Models\DB;
	$db = DB::getInstance();
	$prestamos = $datos['prestamos'];
	$info = $datos['info'];
	$solicitante = $datos['solicitante'];
?>
<div class="container">
	<div class="row">
		<div class="col-lg-4">
			<a href="<?php echo URL, 'prestamo' ?>" class="btn btn-raised">Regresar</a>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<strong class="big-font">Código del Alumno: </strong>
			<span class="big-font"><?php echo ($info['codigo_alumno']) ? mb_strtoupper($info['codigo_alumno']) : mb_strtoupper($info['codigo_maestro']) ?></span>
		</div>
	</div>
	<div class="divider"></div>
	<div class="row">
		<div class="col-lg-6">
			<strong class="big-font">Nombre del Alumno: </strong>
			<span class="big-font"><?php echo ($info['codigo_alumno']) ? ucwords($info['nombre_alumno'] . ' ' . $info['apellidos_alumno']) : ucwords($info['nombre_maestro'] . ' ' . $info['apellidos_maestro']) ?></span>
		</div>
	</div>
	<br>
	<div class="divider"></div>
	<br>
	<div class="row">
		<div class="table-responsive" id="list">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Fecha Préstamo</th>
						<th>Fecha Devolución</th>
						<th>Material Entregado</th>
						<th>Detalles</th>
						<?php if($_SESSION['type'] == 'admin' && $_SESSION['privilegios'] == 1){ ?>
						<th>Eliminar</th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($prestamos as $prestamo){
						echo '<tr>';
						echo '<td>', ($info['codigo_alumno']) ? translateDate($prestamo['fecha_prestamo']) : translateDate($prestamo['fecha_prestamo_maestro']), '</td>';
						echo '<td>', ($info['codigo_alumno']) ? translateDate($prestamo['fecha_entrega']) : translateDate($prestamo['fecha_entrega_maestro']), '</td>';
						if($solicitante == 'alumno'){
							$id = $prestamo['id_prestamo'];
							echo '<td>', $db->query("SELECT * FROM prestamo_material WHERE prestamos_id_prestamo = ? AND recibido = ?", array($id, 1))->count(), '/', $db->get('prestamo_material', array('prestamos_id_prestamo', '=', $id))->count(), '</td>';
						}else if($solicitante = 'maestro'){
							$id = $prestamo['id_prestamos_maestro'];
							echo '<td>', $db->query("SELECT * FROM prestamo_material_maestro WHERE prestamos_maestro_id_prestamos_maestro = ? AND recibido_maestro = ?", array($id, 1))->count(), '/', $db->get('prestamo_material_maestro', array('prestamos_maestro_id_prestamos_maestro', '=', $id))->count(), '</td>';
						}
						if($solicitante == 'alumno'){
							echo '<td><a href = "' . URL . 'prestamo/detalles/alumno/' . $prestamo['alumnos_codigo_alumno'] . '/' . $prestamo['id_prestamo'] . '"><i class="material-icons prefix">forward</i></a></td>';
						}else if($solicitante == 'maestro'){
							echo '<td><a href = "' . URL . 'prestamo/detalles/maestro/' . $prestamo['maestros_codigo_maestro'] . '/' . $prestamo['id_prestamos_maestro'] . '"><i class="material-icons prefix">forward</i></a></td>';
						}
						if($_SESSION['type'] == 'admin' && $_SESSION['privilegios'] == 1){
							if($solicitante == 'alumno'){
								echo '<td><a href="" data-toggle="tooltip" data-placement="rigth" title="" data-original-title="Eliminar"  onclick="eliminar(this, \'alumno\', \'' . $prestamo['id_prestamo'] . '\', event)"><i class="material-icons prefix">delete</i></a></td>';
							}else if($solicitante == 'maestro'){
								echo '<td><a href="" data-toggle="tooltip" data-placement="rigth" title="" data-original-title="Eliminar"  onclick="eliminar(this, \'maestro\', \'' . $prestamo['id_prestamos_maestro'] . '\', event)"><i class="material-icons prefix">delete</i></a></td>';
							}
						}
						echo '</tr>';
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	<?php if($_SESSION['type'] == 'admin' && $_SESSION['privilegios'] == 1){ ?>
		function eliminar(element, solicitante, idPrestamo, evt){
			evt.preventDefault();
			swal({
		      title: '¡Eliminar Prestamo!',
		      text: '¿Estas seguro? Se eliminara toda la información de este prestamo. Esta acción no se puede deshacer.',
		      type: "warning",
		      showCancelButton: true
		      }, function() {
					ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>eliminar_prestamo.php", true);
				   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				   ajax.onreadystatechange = function() {
					   if(ajax.readyState == 4 && ajax.status == 200){
					   	if(ajax.responseText){
								equipo = element.parentNode.parentNode;
								document.querySelector('tbody').removeChild(equipo);
							}else{
								console.log('error');
							}
					   }
				   }
				   ajax.send('solicitante='+solicitante+'&id='+idPrestamo);
				});
		}
	<?php } ?>
</script>