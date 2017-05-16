<div class="container">
	<div class="col-lg-8 col-lg-offset-2">
		<form action="" method="POST" class="bs-component">
			<div class="form-group form-group-lg" id="codigo-input">
				<label for="codigo" class="control-label">Código de la Materia</label>
				<input type="text" id="codigo" name="codigo" class="form-control" value="<?php echo ($datos['id_materia']) ?  strtoupper($datos['id_materia']) : $_POST['codigo'] ?>">
			</div>
			<div class="form-group form-group-lg" id="nombre-input">
				<label for="nombre" class="control-label">Nombre de la Materia</label>
				<input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo ($datos['nombre_materia']) ?  ucwords($datos['nombre_materia']) : $_POST['nombre'] ?>">
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