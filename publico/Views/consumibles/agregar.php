<div class="container">
	<div class="bs-component col-lg-8 col-lg-offset-2">
		<ul class="nav nav-pills nav-justified" style="margin-bottom: 15px;">
			<li class="active"><a aria-expanded="true" href="#uno" data-toggle="tab">Agregar Un Material<div class="ripple-container"></div></a></li>
			<li class=""><a aria-expanded="false" href="#varios" data-toggle="tab">Agregar Varios Materiales<div class="ripple-container"></div></a></li>
		</ul>
		<div id="myTabContent" class="tab-content">
			<div class="tab-pane fade active in" id="uno">
				<div class="col-lg-12">
					<h2 class="text-center">Agregar nuevo Consumible</h2>
					<form action="" method="POST" class="bs-component">
						<div class="form-group form-group-lg" id="codigo_inv-input">
							<label for="codigo" class="control-label">Código</label>
							<input type="text" id="codigo" name="codigo_inv" class="form-control" value="<?php echo $_POST['codigo_inv'] ?>">
						</div>
						<div class="form-group form-group-lg" id="nombre-input">
							<label for="nombre" class="control-label">Nombre</label>
							<input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $_POST['nombre'] ?>">
						</div>
						<div class="form-group form-group-lg" id="cantidad-input">
							<label for="cantidad" class="control-label">Cantidad(gr/ml)</label>
							<input type="text" id="cantidad" name="cantidad" class="form-control" value="<?php echo $_POST['cantidad'] ?>">
						</div>
						<div class="form-group form-group-lg" id="compra-input">
							<label for="compra" class="control-label">Fecha de Compra/Fabricación</label>
							<input type="date" id="compra" name="compra" class="form-control date" value="<?php echo $_POST['compra'] ?>">
						</div>
						<div class="form-group form-group-lg" id="caducidad-input">
							<label for="caducidad" class="control-label">Fecha de Caducidad</label>
							<input type="date" id="caducidad" name="caducidad" class="form-control date" value="<?php echo $_POST['caducidad'] ?>">
						</div>
						<div class="form-group form-group-lg" id="caracteristicas-input">
							<label for="caracteristicas" class="control-label">Características</label>

							<textarea id="caracteristicas" name="caracteristicas" class="form-control" value="<?php echo $_POST['caracteristicas'] ?>"></textarea>
						</div>
						<br>
						<div class="col-lg-6 col-lg-offset-3">
							<button type="submit" class="btn btn-raised btn-primary">Agregar</button>
							<button type="reset" class="btn btn-raised btn-primary">Limpiar</button>
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
									<th>Nombre</th>
									<th>Cantidad</th>
									<th>Compra</th>
									<th>Caducidad</th>
									<th>Características</th>
									<th>Código</th>
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
		ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>agregar_consumibles.php", true);
		ajax.onreadystatechange = function(){
			if (ajax.readyState == 4 && ajax.status == 200){
	      	var result = JSON.parse(ajax.responseText);
	      	if(result.errores != false){
	      		var errores = document.getElementById('errores');
	      		if(errores){
	      			errores.parentNode.removeChild(errores);
	      		}
	      		var data = result.errores;
	      		var mensaje =  '<div class="col-lg-12" id="errores">' +
                                 '<div class="panel panel-danger">' +
                                    '<div class="panel-heading">' +
                                       '<h3 class="panel-title">Hubo un error al agregar estos elementos</h3>' +
                                    '</div>' +
                                    '<div class="panel-body">' +
                                    '<div class="list-group">';
								      		for(var name in data){
								      			mensaje += 	'<div class="list-group-item">' +
 																		'<div class="row-content">';
								      			var elements = data[name];
								      			//nombre del equipo
								      			mensaje += 	'<h4 class="list-group-item-heading">' + name + '</h4>' +
								      							'<p class="list-group-item-text">' +
								      							'<ul>';

								      			for(var element in elements){
								      				var errors = elements[element];
								      				mensaje += '<li><strong>' + element + '</strong><ul>';
								      				//elemento del equipo que tiene el error
								      				for(var error in errors){
								      					var message = errors[error];
								      					for(x in message){
								      						//tipo de error
								      						mensaje += '<li><p><strong>' + error + ': </strong>';
								      						//mensaje del error
								      						mensaje += message[x] + ': </p></li>';
								      					}
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
	$(document).ready(function(){
		var value;
      $('.date').bootstrapMaterialDatePicker({
        time: false,
        clearButton: true,
        format: 'DD-MM-YYYY',
        nowButton: true,
        cancelText: 'Cancelar',
        okText: 'Aceptar',
        clearText: 'Limpiar',
        nowText: "Hoy"
      });
      var element = document.getElementById('caducidad');
      element.addEventListener("focus", function(){
      	value = document.getElementById('compra').value;

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