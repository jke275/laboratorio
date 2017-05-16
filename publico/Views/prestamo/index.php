<?php
	use app\Models\DB;
	$db = DB::getInstance();
	$alumnos = $datos['alumnos'];
	$maestros = $datos['maestros'];
?>
<div class="container">
	<ul class="nav nav-pills nav-justified" style="margin-bottom: 15px;">
		<li class="active"><a aria-expanded="true" href="#alumnos" data-toggle="tab">Alumnos<div class="ripple-container"></div></a></li>
		<li class=""><a aria-expanded="false" href="#maestros" data-toggle="tab">Maestros<div class="ripple-container"></div></a></li>
	</ul>
	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade active in" id="alumnos">
			<div class="col-lg-12">
				<div class="table-responsive" id="list">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Código Alumno</th>
								<th>Nombre Alumno</th>
								<th>Prestamos Realizados</th>
								<th>Detalles</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach($alumnos as $prestamo){
								echo '<tr>';
								echo '<td>', ucwords($prestamo['alumnos_codigo_alumno']), '</td>';
								echo '<td>', ucwords($prestamo['nombre_alumno'] . ' ' . $prestamo['apellidos_alumno']), '</td>';
								echo '<td>', $db->query("SELECT * FROM prestamos WHERE alumnos_codigo_alumno = ?", array($prestamo['alumnos_codigo_alumno']))->count(), '</td>';
								echo '<td><a href = "' . URL . 'prestamo/ver/alumno/' . $prestamo['alumnos_codigo_alumno'] . '"><i class="material-icons prefix">forward</i></a></td>';
								echo '</tr>';
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<div class="tab-pane fade" id="maestros">
			<div class="col-lg-12">
				<div class="table-responsive" id="list">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Código Maestro</th>
								<th>Nombre Maestro</th>
								<th>Prestamos Realizados</th>
								<th>Detalles</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach($maestros as $prestamo){
								echo '<tr>';
								echo '<td>', ucwords($prestamo['maestros_codigo_maestro']), '</td>';
								echo '<td>', ucwords($prestamo['nombre_maestro'] . ' ' . $prestamo['apellidos_maestro']), '</td>';
								echo '<td>', $db->query("SELECT * FROM prestamos_maestro WHERE maestros_codigo_maestro = ?", array($prestamo['maestros_codigo_maestro']))->count(), '</td>';
								echo '<td><a href = "' . URL . 'prestamo/ver/maestro/' . $prestamo['maestros_codigo_maestro'] . '"><i class="material-icons prefix">forward</i></a></td>';
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