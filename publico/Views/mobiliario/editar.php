<?php
	$var = explode('/', $_GET['url']);
	$codigo = $var[2];
?>

<div class="container">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<h2 class="text-center">Editar <?php echo $datos['nombre_inv'] ?></h2>
			<form action="" method="POST" class="bs-component">
				<div class="form-group form-group-lg" id="nombre-input">
					<label for="nombre" class="control-label">Nombre</label>
					<input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo ($datos['nombre_inv']) ?  $datos['nombre_inv'] : $_POST['nombre']?>">
				</div>
				<div class="form-group form-group-lg" id="caracteristicas-input">
					<label for="caracteristicas" class="control-label">Características</label>
					<input type="text" id="caracteristicas" name="caracteristicas" class="form-control" value="<?php echo ($datos['carac_mobiliario']) ?  $datos['carac_mobiliario'] : $_POST['caracteristicas']?>">
				</div>
				<div class="row">
					<div class="col-lg-6 col-lg-offset-3">
						<button type="submit" class="btn btn-raised btn-primary">Actualizar</button>
						<a href="<?php echo URL, 'mobiliario/ver/', $codigo ?>"><button type="button" class="btn btn-raised btn-primary">Cancelar</button></a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
	if($datos){
		foreach($datos as $errors => $nose){
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
