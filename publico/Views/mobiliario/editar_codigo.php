<?php
	$var = explode('/', $_GET['url']);
	$mobiliario = $var[2];
	$tipo = $datos['type'];
	$results = $datos['results'];
?>

<div class="container">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<h2 class="text-center">Editar Código Mobiliario</h2>
			<form action="" method="POST" class="bs-component">
				<div class="form-group form-group-lg" id="codigo-input">
					<label for="codigo" class="control-label">Código</label>
					<input type="text" id="codigo" name="codigo" class="form-control codigo" value="<?php echo ($results['codigo_etiqueta']) ?  mb_strtoupper($results['codigo_etiqueta']) : $_POST['codigo']?>">
				</div>
				<br>
				<div class="row">
					<div class="col-lg-6 col-lg-offset-3">
							<button type="submit" class="btn btn-raised btn-primary">Agregar</button>
							<a href="<?php echo URL, 'mobiliario/ver/', $mobiliario ?>"><button type="button" class="btn btn-raised btn-primary">Cancelar</button></a>
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
<script type="text/javascript">
		var input = document.getElementsByClassName('codigo');
		input.onkeyup = function(){
		    this.value = this.value.toUpperCase();
		}
</script>