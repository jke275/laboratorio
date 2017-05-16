<?php
	$var = explode('/', $_GET['url']);
	$equipo = $var[2];
	$tipo = $datos['type'];
	$results = $datos['results'];
?>
<div class="container">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<h2 class="text-center">Editar Código Equipo</h2>
			<form action="" method="POST" class="bs-component">
				<div class="form-group form-group-lg" id="codigo-input">
					<label for="codigo" class="control-label">Código</label>
					<input type="text" id="codigo" name="codigo" class="form-control" value="<?php echo ($results['codigo_etiqueta']) ?  $results['codigo_etiqueta'] : $_POST['codigo']?>">
				</div>
				<div class="form-group form-group-lg" id="serie-input">
					<label for="serie" class="control-label">Número de serie</label>
					<input type="text" id="serie" name="serie" class="form-control" value="<?php echo ($results['numero_serie']) ?  $results['numero_serie'] : $_POST['serie']?>">
				</div>
				<br>
				<div class="row">
					<div class="col-lg-6 col-lg-offset-3">
							<button type="submit" class="btn btn-raised btn-primary">Agregar</button>
							<a href="<?php echo URL, 'equipo/ver/', $equipo ?>"><button type="button" class="btn btn-raised btn-primary">Cancelar</button></a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
	if($tipo == 'error'){
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
