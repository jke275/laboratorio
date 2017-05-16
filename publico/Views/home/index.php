<?php
	$aprobacion = $datos['aprobacion'];
	$pendientes = $datos['pendientes'];
	$caducidad = $datos['caducidad'];
	$consumiblesTermidados = $datos['terminados'];
?>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#practicas-pendientes" aria-expanded="false" aria-controls="practicas-pendientes">
							Practicas Pendientes de Aprobación
							<span class="badge"><?php echo count($aprobacion) ?></span>
						</a>
					</h4>
				</div>
				<div id="practicas-pendientes" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-condensed table-hover">
								<thead>
									<tr>
										<th>Fecha</th>
										<th>Hora</th>
										<th>Materia</th>
										<th>Maestro</th>
										<?php if($_SESSION['type'] == 'admin'){ ?>
											<th>Revisar</th>
										<?php } ?>
									</tr>
								</thead>
									<?php
										foreach ($aprobacion as $practica) {
											echo '<tr>';
											echo '<td>', translateDate($practica['fecha_practica']), '</td>';
											echo '<td>', date('h:i a', strtotime($practica['hora_practica'])), '</td>';
											echo '<td>', ucwords($practica['nombre_materia']), '</td>';
											echo '<td>', ucwords($practica['nombre_maestro'] . ' ' . $practica['apellidos_maestro']), '</td>';
											if($_SESSION['type'] == 'admin'){
												echo '<td><a href = "' . URL. 'practica/aprobar/' . $practica['id_practica'] . '"><i class="material-icons prefix">forward</i></a></td>';
											}
											echo '</tr>';
										}
									?>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#practicas-realizar" aria-expanded="false" aria-controls="practicas-realizar">
							Practicas Para Realizar el <?php echo translateDate(date('Y-m-d')) ?>
							<span class="badge"><?php echo count($pendientes) ?></span>
						</a>
					</h4>
				</div>
				<div id="practicas-realizar" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-condensed table-hover">
								<thead>
									<tr>
										<th>Hora</th>
										<th>Materia</th>
										<?php if($_SESSION['type'] == 'admin'){ ?><th>Maestro</th> <?php }?>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach ($pendientes as $practica) {
											echo '<tr>';
											echo '<td>', date('h:i a', strtotime($practica['hora_practica'])), '</td>';
											echo '<td>', ucwords($practica['nombre_materia']), '</td>';
											if($_SESSION['type'] == 'admin'){
												echo '<td>', ucwords($practica['nombre_maestro'] . ' ' . $practica['apellidos_maestro']), '</td>';
											}
											echo '<td><a href = "' . URL. 'practica/ver/' . $practica['id_practica'] . '"><i class="material-icons prefix">forward</i></a></td>';
											echo '</tr>';
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php if($_SESSION['type'] == 'admin'){ ?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#consumibles-terminados" aria-expanded="false" aria-controls="practicas-realizar">
							Consumibles con poca cantidad
							<span class="badge"><?php echo count($consumiblesTermidados) ?></span>
						</a>
					</h4>
				</div>
				<div id="consumibles-terminados" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-condensed table-hover">
								<thead>
									<tr>
										<th>Código</th>
										<th>Nombre</th>
										<th>Cantidad</th>
										<th>Editar</th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach ($consumiblesTermidados as $terminado) {
											echo '<tr>';
											echo '<td>', strtoupper($terminado['codigo_inv']), '</td>';
											echo '<td>', ucwords($terminado['nombre_inv']), '</td>';
											echo '<td>', $terminado['cantidad_inv'], '</td>';
											echo '<td><a href = "' . URL. 'consumibles/editar/' . $terminado['codigo_inv'] . '"><i class="material-icons prefix">forward</i></a></td>';
											echo '</tr>';
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#caducidad" aria-expanded="false" aria-controls="practicas-realizar">
							Consumibles a punto de caducar
							<span class="badge"><?php echo count($caducidad) ?></span>
						</a>
					</h4>
				</div>
				<div id="caducidad" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-condensed table-hover">
								<thead>
									<tr>
										<th>Código</th>
										<th>Nombre</th>
										<th>Fecha de Caducidad</th>
										<th>Editar</th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach ($caducidad as $consumible) {
											echo '<tr>';
											echo '<td>', strtoupper($consumible['codigo_inv']), '</td>';
											echo '<td>', ucwords($consumible['nombre_inv']), '</td>';
											echo '<td>', translateDate($consumible['caducidad_consumibles']), '</td>';
											echo '<td><a href = "' . URL. 'consumibles/editar/' . $consumible['codigo_inv'] . '"><i class="material-icons prefix">forward</i></a></td>';
											echo '</tr>';
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>