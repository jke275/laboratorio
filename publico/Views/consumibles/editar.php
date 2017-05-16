<?php
	$var = explode('/', $_GET['url']);
	$codigo = $var[2];
?>

<div class="container">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<h2 class="text-center">Editar <?php echo $datos['nombre_inv'] ?></h2>
			<form action="" method="POST" class="bs-component">
				<div class="form-group form-group-lg" id="codigo_inv-input">
					<label for="codigo" class="control-label">Código</label>
					<input type="text" id="codigo" name="codigo_inv" class="form-control" value="<?php echo ($datos['codigo_inv']) ?  mb_strtoupper($datos['codigo_inv']) : $_POST['codigo_inv']?>">
				</div>
				<div class="form-group form-group-lg" id="nombre-input">
					<label for="nombre" class="control-label">Nombre</label>
					<input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo ($datos['nombre_inv']) ?  ucwords($datos['nombre_inv']) : $_POST['nombre']?>">
				</div>
				<div class="form-group form-group-lg" id="cantidad-input">
					<label for="cantidad" class="control-label">Cantidad</label>
					<input type="text" name="cantidad" id="cantidad" class="form-control" value="<?php echo ($datos['cantidad_inv']) ?  $datos['cantidad_inv'] : $_POST['cantidad']?>">
				</div>
				<div class="form-group form-group-lg" id="compra-input">
					<label for="compra" class="control-label">Fecha de Compra</label>
					<input type="date" name="compra" id="compra" class="form-control date" value="<?php echo ($datos['compra_consumibles']) ? date_format(date_create_from_format('Y-m-d', $datos['compra_consumibles']), 'd-m-Y') : $_POST['compra']?>">
				</div>
				<div class="form-group form-group-lg" id="caducidad-input">
					<label for="caducidad" class="control-label">Fecha de Caducidad</label>
					<input type="date" name="caducidad" id="caducidad" class="form-control date" value="<?php echo ($datos['caducidad_consumibles']) ? date_format(date_create_from_format('Y-m-d', $datos['caducidad_consumibles']), 'd-m-Y') : $_POST['caducidad']?>">
				</div>
				<div class="form-group form-group-lg" id="caracteristicas-input">
					<label for="caracteristicas" class="control-label">Características</label>
					<input type="text" name="caracteristicas" id="caracteristicas" class="form-control" value="<?php echo ($datos['carac_consumibles']) ?  ucwords($datos['carac_consumibles']) : $_POST['caracteristicas']?>">
				</div>
				<br>
				<div class="row">
					<div class="col-lg-6 col-lg-offset-3">
						<button type="submit" class="btn btn-raised btn-primary">Actualizar</button>
						<a href="<?php echo URL, 'consumibles'?>"><button type="button" class="btn btn-raised btn-primary">Cancelar</button></a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	 $(document).ready(function(){
      $('.date').bootstrapMaterialDatePicker
      ({
          time: false,
          clearButton: true,
          format: 'DD-MM-YYYY',
          nowButton: true,
          cancelText: 'Cancelar',
          okText: 'Aceptar',
          clearText: 'Limpiar',
          nowText: "Hoy"
        });
    });
</script>

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
