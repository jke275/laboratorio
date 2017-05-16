<div class="container">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
				<h3 class="text-center">Ingresa el código del maestro</h3>
			<form action="" method="POST" class="bs-component" id='practica'>
				<div class="form-group col-lg-12 form-group-lg" id="codigo-input">
					<input type="text" id="codigo" name="codigo" class="form-control date" value="<?php echo $_POST['codigo'] ?>">
				</div>
				<br>
				<div class="row">
					<div class="col-lg-6 col-lg-offset-3">
						<button type="submit" class="btn btn-raised btn-primary">Revisar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
	if($datos['type'] == 'sancion'){
?>
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3">
					<div class="panel panel-warning">
					  <div class="panel-heading">
					    <h3 class="panel-title"><strong>Alumno Sancionado</strong></h3>
					  </div>
					  <div class="panel-body">
					   	<?php echo 'El alumno ', ucwords($datos['alumno']['nombre_alumno'] . ' ' . $datos['alumno']['apellidos_alumno']), ' fue sancionado el dia <strong>', translateDate($datos['alumno']['sancion']), '.</strong>' ?>
					   	<br><br><p>Desea quitar la sanción:</p>
					   	<button type="button" class="btn btn-raised" onclick="quitar_sancion('<?php echo $datos['alumno']['codigo_alumno'] ?>')">Quitar Sanción</button>
					   	<a href="<?php echo URL ?>prestamo/solicitar" class="btn btn-raised">Cancelar</a>
					  </div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	if($datos['type'] == 'errors'){
		foreach($datos['results'] as $errors => $nose){
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
	function quitar_sancion(codigo){
		swal({
      title: '¡Quitar Sanción!',
      text: '¿Estas seguro de querer quitar la sanción? Esta acción no se puede deshacer.',
      type: "warning",
      showCancelButton: true
      }, function() {
			ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>quitar_sancion.php", true);
		   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		   ajax.onreadystatechange = function() {
			   if(ajax.readyState == 4 && ajax.status == 200){
			   	if(ajax.responseText){
			   		window.location = '<?php echo URL, 'prestamo/material/' ?>' + codigo;
			   	}
			   }
		   }
		   ajax.send('codigo='+codigo);
		});
	}
</script>