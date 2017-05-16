<div class="container">
	<div class="col-lg-8 col-lg-offset-2">
		<h2 class="text-center">Agregar Nuevo Usuario</h2>
		<form action="" method="POST" class="bs-component">
			<div class="form-group form-group-lg" id="usuario-input">
				<label for="usuario" class="control-label">Usuario</label>
				<input type="text" id="usuario" name="usuario" class="form-control" value="<?php echo $_POST['usuario'] ?>">
			</div>
			<div class="form-group form-group-lg" id="nombre-input">
				<label for="nombre" class="control-label">Nombre</label>
				<input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $_POST['nombre'] ?>">
			</div>
			<div class="form-group form-group-lg" id="apellidos-input">
				<label for="apellidos" class="control-label">Apellidos</label>
				<input type="text" id="apellidos" name="apellidos" class="form-control" value="<?php echo $_POST['apellidos'] ?>">
			</div>
			<div class="form-group form-group-lg" id="psw-input">
				<label for="psw" class="control-label">Contraseña</label>
				<input type="password" id="psw" name="psw" class="form-control" value="<?php echo $_POST['psw'] ?>">
			</div>
			<div class="form-group form-group-lg" id="psw2-input">
				<label for="psw2" class="control-label">Repetir Contraseña</label>
				<input type="password" id="psw2" name="psw2" class="form-control" value="<?php echo $_POST['psw2'] ?>">
			</div>
			<div class="form-group form-group-lg" id="privilegios-input">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="privilegios">
						<span class="checkbox-material">
							<span class="check"></span>
						</span>
						Usuario con todos los privilegios
					</label>
				</div>
			</div>
			<br>
			<div class="col-lg-6 col-lg-offset-3">
				<button type="submit" class="btn btn-raised btn-primary">Agregar</button>
				<a class="btn btn-raised btn-primary" href="<?php echo URL . 'usuario/administrar' ?>">Cancelar</a>
			</div>
		</form>
	</div>
</div>
<?php
	if(is_array($datos)){
		foreach($datos as $errors => $nose){
			foreach($nose as $error){
				?>
				<script type="text/javascript">
				var element = document.getElementById('<?php echo $errors ?>-input');
				var mensaje = '<?php echo $error; ?>';

				addError(element, mensaje);
				</script>
				<?php
			}
		}
	}elseif(is_bool($datos) && $datos == true){
?>
	<script type="text/javascript">
		sweetAlertInitialize();
		swal({
			title: "Usuario agregado correctamente",
			type: "success",
			confirmButtonText: "Continuar",
		},
		function(){
			window.location = '<?php echo URL .'usuario/administrar'?>';
		});
	</script>
<?php
	}
?>