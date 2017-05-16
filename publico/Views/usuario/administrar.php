<div class="container">
	<div class="bs-component col-lg-12">
		<div class="bs-component col-lg-2">
			<ul class="nav nav-stacked" style="margin-bottom: 15px;">
				<li class="active"><a aria-expanded="true" href="#cambiar" data-toggle="tab">Cambiar Contraseña<div class="ripple-container"></div></a></li>
				<?php if($_SESSION['type'] == 'admin' && $_SESSION['privilegios'] == 1){?>
					<li><a href="<?php echo URL . 'usuario/agregar'?>">Agregar Nuevo Usuario</a></li>
					<li><a href="<?php echo URL . 'usuario/ingresos'; ?>">Ver Ingresos</a></li>
					<li><a href="<?php echo URL . 'usuario/respaldar'; ?>">Respaldo base de datos</a></li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="bootstrap-elements.html" data-target="#">
							Materias<i class="material-icons">arrow_drop_down</i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo URL . 'materias'; ?>">Listar</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo URL . 'materias/agregar'; ?>">Agregar</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="bootstrap-elements.html" data-target="#">
							Maestros<i class="material-icons">arrow_drop_down</i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo URL . 'maestros'; ?>">Listar</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo URL . 'maestros/agregar'; ?>">Agregar</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="bootstrap-elements.html" data-target="#">
							Alumnos<i class="material-icons">arrow_drop_down</i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo URL . 'alumnos'; ?>">Listar</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo URL . 'alumnos/agregar'; ?>">Agregar</a></li>
						</ul>
					</li>
				<?php } ?>
			</ul>
		</div>
		<div class="bs-component col-lg-10">
			<div id="myTabContent" class="tab-content">
				<div class="tab-pane fade active in" id="cambiar">
					<div class="col-lg-6 col-lg-offset-3">
						<h2 class="text-center">Cambiar Contraseña</h2>
						<form action="" method="POST" class="bs-component">
							<div class="form-group form-group-lg" id="psw-actual-input">
								<label for="psw-actual" class="control-label">Ingresar Contraseña Actual</label>
								<input type="text" id="psw-actual" name="psw-actual" class="form-control" value="<?php echo $_POST['psw-actual'] ?>">
							</div>
							<div class="form-group form-group-lg" id="psw-nueva-input">
								<label for="psw-nueva" class="control-label">Ingresar Nueva Contraseña</label>
								<input type="text" id="psw-nueva" name="psw-nueva" class="form-control" value="<?php echo $_POST['psw-nueva'] ?>">
							</div>
							<div class="form-group form-group-lg" id="repetir-psw-nueva-input">
								<label for="repetir-psw-nueva" class="control-label">Repetir Nueva Contraseña</label>
								<input type="text" id="repetir-psw-nueva" name="repetir-psw-nueva" class="form-control" value="<?php echo $_POST['repetir-psw-nueva'] ?>">
							</div>
							<br>
							<div class="col-lg-10 col-lg-offset-1">
								<button type="submit" class="btn btn-raised btn-primary">Cambiar</button>
								<a class="btn btn-raised btn-primary" href="<?php echo URL . 'usuario/administrar' ?>">Cancelar</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
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
			title: "Contraseña cambiada correctamente",
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