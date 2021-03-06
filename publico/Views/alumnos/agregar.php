<div class="container">
	<div class="bs-component col-lg-2">
		<ul class="nav nav-stacked" style="margin-bottom: 15px;">
			<li><a href="<?php echo URL . 'alumnos'; ?>">Listar</a></li>
			<li><a href="<?php echo URL . 'usuario/administrar'; ?>">Regresar</a></li>
		</ul>
	</div>
	<div class="bs-component col-lg-10">
		<ul class="nav nav-pills nav-justified" style="margin-bottom: 15px;">
			<li class="active"><a aria-expanded="true" href="#uno" data-toggle="tab">Agregar Un Alumno<div class="ripple-container"></div></a></li>
			<li class=""><a aria-expanded="false" href="#varios" data-toggle="tab">Agregar Varios Alumnos<div class="ripple-container"></div></a></li>
		</ul>
		<div id="myTabContent" class="tab-content">
			<div class="tab-pane fade active in" id="uno">
				<div class="col-lg-12">
					<form action="" method="POST" class="bs-component">
						<div class="form-group form-group-lg" id="codigo-input">
							<label for="codigo" class="control-label">Código</label>
							<input type="text" id="codigo" name="codigo" class="form-control" value="<?php echo $_POST['codigo'] ?>">
						</div>
						<div class="form-group form-group-lg" id="nombre-input">
							<label for="nombre" class="control-label">Nombre</label>
							<input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $_POST['nombre'] ?>">
						</div>
						<div class="form-group form-group-lg" id="apellidos-input">
							<label for="apellidos" class="control-label">Apellidos</label>
							<input type="text" id="apellidos" name="apellidos" class="form-control" value="<?php echo $_POST['apellidos'] ?>">
						</div>
						<div class="form-group form-group-lg" id="carrera-input">
							<label for="carrera" class="control-label">Carrera</label>
							<input type="text" id="carrera" name="carrera" class="form-control" value="<?php echo $_POST['carrera'] ?>">
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
			<div class="tab-pane fade" id="varios">
				<div class="row">
					<div class="text-center col-lg-12">
						<strong><span class="big-font">El archivo debe tener este orden</span></strong>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="table-responsive col-lg-12" id="list">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Código</th>
									<th>Nombre</th>
									<th>Apellidos</th>
									<th>Carrera</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<form action="" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group is-fileinput">
			        			<input class="form-control" type="text" placeholder="Examinar" readonly="" >
								<input type="file" name="file" id="file">
							</div>
	    				</div>
	    			</div>
    				<div class="row" id="button">
						<div class="col-lg-2 col-lg-offset-4">
    						<button type="button" class="btn btn-raised btn-primary" onclick="upload()">Enviar</button>
    					</div>
    				</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function upload(){
      var file = document.getElementById("file");
      /* Create a FormData instance */
      var formData = new FormData();
      /* Add the file */
      formData.append("upload", file.files[0]);
		ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>agregar_alumnos.php", true);
	   ajax.onreadystatechange = function(){
	      if (ajax.readyState == 4 && ajax.status == 200){
	      	var result = JSON.parse(ajax.responseText);
	      	console.log(result.errores);
	      	if(result.errores != false){
	      		var errores = document.getElementById('errores');
	      		if(errores){
	      			errores.parentNode.removeChild(errores);
	      		}
	      		var data = result.errores;
	      		var mensaje =  '<div class="col-lg-12" id="errores">' +
                                 '<div class="panel panel-danger">' +
                                    '<div class="panel-heading">' +
                                       '<h3 class="panel-title">Hubo un error al agregar estos alumnos</h3>' +
                                    '</div>' +
                                    '<div class="panel-body">' +
                                    '<div class="list-group">';
								      		for(var name in data){
								      			mensaje += 	'<div class="list-group-item">' +
 																		'<div class="row-content">';
								      			var elements = data[name];
								      			//codigo del alumno
								      			mensaje += 	'<h4 class="list-group-item-heading">' + name + '</h4>' +
								      							'<p class="list-group-item-text">' +
								      							'<ul>';

								      			for(var element in elements){
								      				var errors = elements[element];
								      				mensaje += '<li><strong>' + element + '</strong><ul>';
								      				//elemento del equipo que tiene el error
								      				for(var error in errors){
								      					var message = errors[error];
								      						//tipo de error
								      						mensaje += '<li><p><strong>' + error + ': </strong>';
								      						//mensaje del error
								      						mensaje += message + ': </p></li>';
								      				}
								      				mensaje += '</ul></li>';
								      			}
								      			mensaje += 	'</ul>' +
								      							'</p>' +
								      							'</div>' +
																		'</div>' +
																		'<div class="divider"></div>';
								      		}
                                    mensaje += '</div>' +
                                   	'</div>' +
                                 '</div>' +
                              '</div>';
               document.getElementById('varios').innerHTML += mensaje;
	      	}
	      }
	   }
      ajax.send(formData);
   }
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