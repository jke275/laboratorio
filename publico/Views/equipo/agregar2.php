<?php
	$var = explode('/', $_GET['url']);
	$cantidad = $var[2];
?>
<div class="container">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
		<h2 class="text-center">Agregar nuevo Equipo</h2>
		<form action="" method="POST" class="bs-component" enctype="multipart/form-data">
				<div class="form-group form-group-lg" id="nombre-input">
					<label for="nombre" class="control-label">Nombre</label>
					<input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $_POST['nombre'] ?>">
				</div>
				<div class="form-group form-group-lg" id="marca-input">
					<label for="marca"  class="control-label">Marca</label>
					<input type="text" id="marca" name="marca" class="form-control" value="<?php echo $_POST['marca'] ?>">
				</div>
				<div class="form-group form-group-lg" id="modelo-input">
					<label for="modelo"  class="control-label">Modelo</label>
					<input type="text" id="modelo" name="modelo" class="form-control" value="<?php echo $_POST['modelo'] ?>">
				</div>
				<div class="form-group form-group-lg" id="caracteristicas-input">
					<label for="caracteristicas"  class="control-label">Características</label>
					<input type="text" id="caracteristicas" name="caracteristicas" class="form-control" value="<?php echo $_POST['caracteristicas'] ?>">
				</div>
				<div class="form-group form-group-lg is-fileinput" id="imagen-input">
					<input class="form-control" type="text" placeholder="Subir Imagen(maximo 1 MB)" readonly="" >
					<input type="file" name="imagen" id="imagen">
				</div>
				<?php
					for($x = 1; $x<= $cantidad; $x++){
				?>
					<span>Equipo <?php echo $x;?></span>
					<div class="row">
						<div class="form-group form-group-lg col-lg-6" id="codigo<?php echo $x; ?>-input">
							<label for="codigo<?php echo $x; ?>" class="control-label">Código</label>
							<input type="text" id="codigo<?php echo $x; ?>" name="codigo<?php echo $x; ?>" class="form-control" value="<?php echo $_POST['codigo' . $x] ?>">
						</div>
						<div class="form-group form-group-lg col-lg-6" id="serie<?php echo $x; ?>-input">
							<label for="serie<?php echo $x; ?>" class="control-label">Número de serie</label>
							<input type="text" id="serie<?php echo $x; ?>" name="serie<?php echo $x; ?>" class="form-control" value="<?php echo $_POST['serie' . $x] ?>">
						</div>
					</div>
				<?php
					}
				?>
			</div>
			<br>
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3">
						<button type="submit" class="btn btn-raised btn-primary">Agregar</button>
						<button type="reset" class="btn btn-raised btn-primary">Limpiar</button>
				</div>
			</div>
		</form>
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
