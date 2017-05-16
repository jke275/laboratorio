<?php
	if($datos['type'] == 'results'){
		$equipos = $datos['results']['equipo'];
		$instrumentos = $datos['results']['instrumentos'];
		$consumibles = $datos['results']['consumibles'];
	}

	function equipos($equipos){
		$table = '<div class="col-lg-12">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Marca</th>
										<th>Modelo</th>
										<th>Cantidad</th>
										<th>Características</th>
										<th>Imagen</th>
									</tr>
								</thead>
								<tbody>';
								foreach($equipos as $equipo){
										$table .= '<tr>';
										$table .= '<td>' . ucwords($equipo['nombre_inv']) . '</td>';
										$table .= '<td>' . ucwords($equipo['marca_equipo']) . '</td>';
										$table .= '<td>' . ucwords($equipo['modelo_equipo']) . '</td>';
										$table .= '<td>' . $equipo['cantidad_inv'] . '</td>';
										$table .= '<td>' . ucwords($equipo['carac_equipo']) . '</td>';
										$table .= '<td><a href="" data-toggle="modal" data-target="#exampleModal" data-whatever="';
										if($equipo['imagen']){
											$table .= $equipo['imagen'];
										}else{
											$table .= 'sin_imagen.png';
										}
										$table .= '">Ver Imagen</a></td></tr>';
									}
								$table .= '</tbody>
							</table>
						</div>
					</div>';
					return $table;
	}

	function instrumentos($instrumentos){
		$table = '<div class="col-lg-12">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Cantidad</th>
										<th>Características</th>
										<th>Imagen</th>
									</tr>
								</thead>
								<tbody>';
									foreach($instrumentos as $instrumento){
										$table .= '<tr>';
										$table .= '<td>' . ucwords($instrumento['nombre_inv']) . '</td>';
										$table .= '<td>' . $instrumento['cantidad_inv'] . '</td>';
										$table .= '<td>' . ucwords($instrumento['carac_material']) . '</td>';
										$table .= '<td><a href="" data-toggle="modal" data-target="#exampleModal" data-whatever="';
										if($instrumento['imagen']){
											$table .= $instrumento['imagen'];
										}else{
											$table .= 'sin_imagen.png';
										}
										$table .= '">Ver Imagen</a></td>
										</tr>';
									}
							$table .= '</tbody>
						</table>
					</div>
				</div>';
				return $table;
	}

	function consumibles($consumibles){
		$table = '<div class="col-lg-12">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Cantidad</th>
										<th>Características</th>
										<th>Imagen</th>
									</tr>
								</thead>
							</table>
							<tbody>';
								foreach($consumibles as $consumible){
									$table .= '<tr>';
									$table .= '<td>' . ucwords($consumible['nombre_inv']) . '</td>';
									$table .= '<td>' . $consumible['cantidad_inv'] . '</td>';
									$table .= '<td>' . ucwords($consumible['carac_consumible']) . '</td>';
									$table .= '<td><a href="" data-toggle="modal" data-target="#exampleModal" data-whatever="';
									if($consumible['imagen']){
										$table .= $consumible['imagen'];
									}else{
										$table .= 'sin_imagen.png';
									}
									$table .= '">Ver Imagen</a></td>
									</tr>';
								}
				$table .= '</tbody>
						</div>
					</div>';

		return $table;
	}
?>
<div class="container">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-4">
				<form action="" method="POST" class="bs-component">
					<div class="form-group form-group-lg" id="nombre-input">
						<label for="nombre" class="control-label">Buscar</label>
						<input type="text" name="nombre" class="form-control">
						<button type="submit" class="btn btn-raised">Buscar</button>
					</div>
				</form>
			</div>
			<div class="col-lg-4 col-lg-offset-4">
				<div class="btn-group btn-group-raised">
					<a class="btn" href="<?php echo URL, 'inventario' ?>">Ver todo</a>
					<a class="btn" href="<?php echo URL ?>">Regresar</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <img style="width: 100%; height: 20em;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="divider"></div>

<?php
	if($datos['type'] == 'results'){
?>
		<div class="container">
			<ul class="nav nav-pills nav-justified" style="margin-bottom: 15px;">
				<li class="active"><a aria-expanded="true" href="#equipo" data-toggle="tab">Equipo<div class="ripple-container"></div></a></li>
				<li class=""><a aria-expanded="false" href="#instrumentos" data-toggle="tab">Instrumentos<div class="ripple-container"></div></a></li>
				<li class=""><a aria-expanded="false" href="#consumibles" data-toggle="tab">Consumibles<div class="ripple-container"></div></a></li>
			</ul>
			<div id="myTabContent" class="tab-content">
				<div class="tab-pane fade active in" id="equipo">
					<?php echo equipos($equipos) ?>
				</div>
				<div class="tab-pane fade" id="instrumentos">
					<?php echo instrumentos($instrumentos) ?>
				</div>
				<div class="tab-pane fade" id="consumibles">
					<?php echo consumibles($consumibles) ?>
				</div>
			</div>
		</div>
<?php
	}else if($datos['type'] == 'search'){
?>
	<div class="container">
<?php
		switch($datos['results'][0]['tipo']){
			case 'equipo':
				echo equipos($datos['results']);
				break;
			case 'material':
				echo instrumentos($datos['results']);
				break;
			case 'consumibles':
				echo consumibles($datos['results']);
				break;
		}
?>
	</div>
<?php
	}else{
		echo '<div class="container" id="list">
						<div class="row">
							<div class="col-lg-8 col-lg-offset-2">
								<p>Resultados no encontrados. Por favor Realiza otra busqueda</p>
								<p><a href="', URL, 'inventario">Ver todo el material</a></p>
							</div>
						</div>
					</div>';
	}

	if($datos['type'] == 'errors'){
		//echo mostrar($datos['results']);
		foreach($datos['errors'] as $errors => $nose){
			foreach($nose as $error){
				?>
				<script type="text/javascript">
				var element = document.getElementById('<?php echo $errors ?>-input');
				var mensaje = '<?php echo $error; ?>'

				addError(element, mensaje);
				</script>
				<?php
			}
		}
	}
?>
<script type="text/javascript">
	$('#exampleModal').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var recipient = button.data('whatever') // Extract info from data-* attributes
	  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
	  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
	  var modal = $(this)
	  modal.find('.modal-body img').attr('src', '<?php echo URL ?>/publico/img/inventario/'+recipient);
	});
</script>