<div class="container">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<h2 class="text-center">Código del maestro</h2>
			<form action="" method="POST" class="bs-component">
				<div class="form-group form-group-lg" id="codigo-input">
					<input type="text" id="codigo" name="codigo" class="form-control" value="<?php echo $_POST['codigo'] ?>">
				</div>
				<div class="row">
					<div class="col-lg-6 col-lg-offset-3">
						<button type="submit" class="btn btn-raised btn-primary">Recibir</button>
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