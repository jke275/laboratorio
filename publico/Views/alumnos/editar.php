<div class="container">
	<div class="col-lg-8 col-lg-offset-2">
		<form action="" method="POST" class="bs-component">
			<div class="form-group form-group-lg" id="codigo-input">
				<label for="codigo" class="control-label">Código</label>
				<input type="text" id="codigo" name="codigo" class="form-control" value="<?php echo ($datos['codigo_alumno']) ?  ucwords($datos['codigo_alumno']) : $_POST['codigo'] ?>">
			</div>
			<div class="form-group form-group-lg" id="nombre-input">
				<label for="nombre" class="control-label">Nombre</label>
				<input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo ($datos['nombre_alumno']) ?  ucwords($datos['nombre_alumno']) : $_POST['nombre'] ?>">
			</div>
			<div class="form-group form-group-lg" id="apellidos-input">
				<label for="apellidos" class="control-label">Apellidos</label>
				<input type="text" id="apellidos" name="apellidos" class="form-control" value="<?php echo ($datos['apellidos_alumno']) ?  ucwords($datos['apellidos_alumno']) : $_POST['apellidos'] ?>">
			</div>
			<div class="form-group form-group-lg" id="carrera-input">
				<label for="carrera" class="control-label">Carrera</label>
				<input type="text" id="carrera" name="carrera" class="form-control" value="<?php echo ($datos['carrera']) ?  ucwords($datos['carrera']) : $_POST['carrera'] ?>">
			</div>
			<br>
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3">
					<button type="submit" class="btn btn-raised btn-primary">Guardar</button>
					<a href="<?php echo URL, 'alumnos' ?>"><button type="button" class="btn btn-raised btn-primary">Cancelar</button></a>
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