<div class="container">
	<div class="bs-component col-lg-2">
		<ul class="nav nav-stacked" style="margin-bottom: 15px;">
			<li><a href="<?php echo URL . 'maestros/agregar'; ?>">Agregar</a></li>
			<li><a href="<?php echo URL . 'usuario/administrar'; ?>">Regresar</a></li>
		</ul>
	</div>
	<div class="col-lg-10">
		<div class="row">
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Código</th>
							<th>Nombre</th>
							<th>Editar</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($datos as $maestro){
								?>
								<tr>
									<td><?php echo strtoupper($maestro['codigo_maestro']) ?> </td>
									<td><?php echo ucwords($maestro['nombre_maestro'] . ' ' . $maestro['apellidos_maestro']) ?></td>
									<td><a data-toggle="tooltip" data-placement="left" title="" data-original-title="Editar" href = "<?php echo URL, 'maestros/editar/', $maestro['codigo_maestro']?>" class="drop" ><i class="material-icons">mode_edit</i></a></td>
								</tr>
								<?php
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>