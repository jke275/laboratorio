<?php
	use app\Models\Prestamo;
	$var = explode('/', $_GET['url']);
	$solicitante = $var[2];
	$codigo = $var[3];
	$prestamo = Prestamo::getInstance();
	$info = $prestamo->getCodigo($solicitante, $codigo);
	$nombre = ($solicitante == 'alumno') ? $info['nombre_alumno'] . ' ' . $info['apellidos_alumno'] : $info['nombre_maestro'] . ' ' . $info['apellidos_maestro'] ;
?>
<div class="container">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<div class="col-lg-6">
				<strong class="big-font"><?php echo ucwords($solicitante) ?>: </strong>
				<span class="big-font"><?php echo ucwords($nombre)?></span>
			</div>
			<?php if($solicitante == 'alumno'){ ?>
			<div class="col-lg-6">
				<strong class="big-font">Carrera: </strong>
				<span class="big-font"><?php echo ucwords($info['carrera']); ?></span>
			</div>
			<?php } ?>
		</div>
		<div class="divider"></div>
	</div>

	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<div class="form-group col-lg-12 form-group-lg" id="objetivo-input">
				<span class="big-font">Objetivo</span>
				<input type="text" id="objetivo" name="objetivo" class="form-control" value="<?php echo $_POST['objetivo'] ?>">
				<p class="help-block" id="objetivo-help"></p>
			</div>
			<div class="form-group col-lg-12 form-group-lg" id="fecha-entrega-input">
				<span class="big-font">Fecha programada para devolución</span>
				<input type="text" id="fecha-entrega" name="fecha-entrega" class="form-control date" value="<?php echo $_POST['fecha-entrega'] ?>">
				<p class="help-block" id="fecha-entrega-help"></p>
			</div>
		</div>
	</div>
	<div class="row">
			<div class="divider"></div>
	</div>
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<div class="col-lg-6">
				<div class="row">
					<div class="col-lg-12 form-group" id="codigo-input">
						<span class="big-font">Ingresa el código del material</span>
						<input type="text" name="codigo" id="codigo" class="form-control" autocomplete="off">
					</div>
				</div>
				<button id="terminar" onclick="terminar()">Terminar</button>
				<div id="noDisponible">

				</div>
			</div>
			<div class="col-lg-6" id="elements">
				<p class="help-block text-danger" id="codigo-help"></p>
				<div class="table-responsive" id="list">
			      <table class="table table-hover">
				      <thead>
				        <tr>
				          <th>Código</th>
				          <th>Nombre</th>
				          <th>Eliminar</th>
				        </tr>
				      </thead>
			        	<tbody>
			        	</tbody>
			      </table>
			   </div>
	      </div>
	   </div>
  </div>
</div>

<script type="text/javascript">
	sweetAlertInitialize();
	$(document).ready(function(){
		$('.date').bootstrapMaterialDatePicker({
	      time: false,
	      clearButton: true,
	      format: 'DD-MM-YYYY',
	      nowButton: true,
	      cancelText: 'Cancelar',
	      okText: 'Aceptar',
	      clearText: 'Limpiar',
	      nowText: "Hoy",
	      lang: 'es'
	   });
	});

	function eliminar(evt){
		var tr = evt.parentNode.parentNode;
		var parent = tr.parentNode;
		parent.removeChild(tr);

	}

	var materiales = new Bloodhound({
	  	datumTokenizer: Bloodhound.tokenizers.whitespace,
	  	queryTokenizer: Bloodhound.tokenizers.whitespace,
	  	prefetch: {
	  		cache: false,
	  		url: '<?php echo URL . 'app/ajax/' ?>select_element.php'
	  	}
	});

	// passing in `null` for the `options` arguments will result in the default
	// options being used
	$('#codigo').typeahead(null, {
	  	hint: false,
	  	name: 'countries',
	  	source: materiales,
	  	templates: {
	    	empty: [
	      	'<div class="empty-message">',
	        		'Elemento no Encontrado',
	      	'</div>'
	    	].join('\n'),
		}
	});

	$('#codigo').bind('typeahead:select', function(ev, suggestion){
	  	var element = suggestion.split(' / ');
	  	var tableElement = 	'<tr>' +
						            '<td class="id">' + element[0] + '</td>' +
						            '<td>' + element[1] + '</td>' +
						            '<td><i class="material-icons prefix" onclick="eliminar(this)" style="cursor: pointer">clear</i></td>' +
						         '</tr>';
		document.querySelector('tbody').innerHTML += tableElement;
		$('#codigo').typeahead('val', '');
	});

	function errors(errors){
		for(var key in errors){
	      var input = document.getElementById(key + '-input');
			var mensaje = errors[key];
			var error = document.getElementById(key + '-help');
			error.innerHTML = '';
			error.innerHTML = mensaje;
			input.className += ' has-error is-focused'
		}
	}

	function terminar(){
		var idEelements = document.getElementsByClassName('id');
		var codigos = {};
		var objetivo = document.querySelector('#objetivo').value;
		var fechaEntrega = document.querySelector('#fecha-entrega').value;
		for(x = 0; x<idEelements.length; x++){
			codigos[x] = idEelements[x].innerHTML;
		}
		ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>material_prestamo.php", true);
	   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	   ajax.onreadystatechange = function() {
		   if(ajax.readyState == 4 && ajax.status == 200){
		   	var response = JSON.parse(ajax.responseText);
		   	if(response.type != 'success'){
		   		document.getElementById('noDisponible').innerHTML = '';
		      	if(typeof response === 'object'){
		      		if(response.type == 'errors'){
		      			errors(response.results);
		      		}
		      		if(response.type == 'noDisponible'){
							var mensaje =  '<div class="panel panel-danger">' +
                                    '<div class="panel-heading">' +
                                       '<h3 class="panel-title">Estos elementos <strong>NO</strong> se encuentran disponibles</h3>' +
                                    '</div>' +
                                    '<div class="panel-body">' +
                                    '<ul>';
	                                    for(x in response.results){
						                        mensaje +=  '<li>' + response.results[x] + '</li>';
						                     }
                                    mensaje += '</ul></div>' +
                                 '</div>';
							document.getElementById('noDisponible').innerHTML = mensaje;
		      		}
		      		if(response.type == 'repetido'){
							var mensaje =  '<div class="panel panel-danger">' +
                                    '<div class="panel-heading">' +
                                       '<h3 class="panel-title">Estos códigos se encuentra repetidos</h3>' +
                                    '</div>' +
                                    '<div class="panel-body">' +
                                    '<ul>';
	                                    for(x in response.results){
						                        mensaje +=  '<li>' + response.results[x] + '</li>';
						                     }
                                    mensaje += '</ul></div>' +
                                 '</div>';
							document.getElementById('noDisponible').innerHTML = mensaje;
		      		}
		      		if(response.codigos == false){
							document.getElementById('codigo-help').innerHTML = 'Debes ingresar mínimo un elemento';
		      		}
		      	}
		   	}else{
		   		swal({
					  title: "Préstamo realizado correctamente",
					  type: "success",
					  confirmButtonText: "Continuar",
					},
					function(){
	      			window.location = '<?php echo URL .'prestamo/detalles/' . $solicitante . '/' . $codigo .'/' ?>' + response.id;
					});
	      	}
		   }
	   }
	   ajax.send('codigo=' + <?php echo $codigo ?> + '&objetivo=' + objetivo + '&fecha-entrega=' + fechaEntrega + '&solicitante=<?php echo $solicitante ?>' + '&materiales=' + JSON.stringify(codigos));
	}
</script>

<?php
	if($datos){
?>
	<script type="text/javascript">
		swal({
			title: "Alumno Sancionado",
			text: "Este alumno tiene una sanción y no se le permite solicitar prestamos",
			type: "error",
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Continuar",
		  closeOnConfirm: false
		}, function(){
			window.location = '<?php echo URL .'prestamo/solicitar' ?>';
		});
	</script>
<?php
	}
?>