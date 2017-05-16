<?php
	use app\Models\Prestamo;
	$var = explode('/', $_GET['url']);
	$id = $var[2];
?>
<div class="conntainer">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<div class="col-lg-6">
				<div class="row">
					<div class="col-lg-12 form-group" id="nombre-input">
						<span class="big-font">Ingresa el nombre del material</span>
						<input type="text" name="nombre" id="nombre" class="form-control" autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 form-group" id="cantidad-input">
						<span class="big-font">Ingresa la cantidad</span>
						<input type="text" name="cantidad" id="cantidad" class="form-control">
					</div>
				</div>
				<button id="agregar" onclick="agregar()">Agregar</button>
				<button id="terminar" onclick="terminar()">Terminar</button>
				<br><br>
				<span class="text-danger" id="errores"></span>
			</div>
			<div class="col-lg-6" id="elements">
				<div class="table-responsive" id="list">
			      <table class="table table-hover">
				      <thead>
				        <tr>
				          <th>Nombre</th>
				          <th>Cantidad</th>
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
	var materiales = new Bloodhound({
	  	datumTokenizer: Bloodhound.tokenizers.whitespace,
	  	queryTokenizer: Bloodhound.tokenizers.whitespace,
	  	prefetch: {
	  		cache: false,
	  		url: '<?php echo URL . 'app/ajax/' ?>elements_practica.php'
	  	}
	});

	// passing in `null` for the `options` arguments will result in the default
	// options being used
	$('#nombre').typeahead(null, {
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

	function agregar(){
		var elemento = document.getElementById('nombre').value;
		var cantidad = document.getElementById('cantidad').value;
		if(elemento.length > 0 && cantidad.length > 0 && (/^\d+$/.test(cantidad))){
			var tableElement = 	'<tr>' +
						            '<td class="nombreElement">' + elemento + '</td>' +
						            '<td class="cantidadElement">' + cantidad + '</td>' +
						            '<td><i class="material-icons prefix" onclick="eliminar(this)" style="cursor: pointer">clear</i></td>' +
						         '</tr>';
			document.querySelector('tbody').innerHTML += tableElement;
			$('#nombre').typeahead('val', '');
			document.getElementById('cantidad').value = '';
		}
	}

	function eliminar(evt){
		var tr = evt.parentNode.parentNode;
		var parent = tr.parentNode;
		parent.removeChild(tr);

	}

	function terminar(){
		var nombreElements = document.getElementsByClassName('nombreElement');
		var cantidadElements = document.getElementsByClassName('cantidadElement');
		var elements = {};
		for(x = 0; x<nombreElements.length; x++){
			elements[x] = {
				'nombre' : nombreElements[x].innerHTML,
				'cantidad' : cantidadElements[x].innerHTML
			};
		}
		if(Object.keys(elements).length > 0){
			ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>material_practica.php", true);
		   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		   ajax.onreadystatechange = function() {
			   if(ajax.readyState == 4 && ajax.status == 200){
			   	if(ajax.responseText){
			   		var data;
						try {
						    data = JSON.parse(ajax.responseText);
						} catch(e) {
							data = false;
						}
						if(data){
				   		var mensaje = 	'<p>Hubo un error con los siguientes elementos</p>' + '<ul>';
				   		for(x in data){
							   	mensaje += '<li>' +
							   	'<strong>' + data[x].elemento + ':</strong> ' + data[x].error +
							   	'</li>';
							}
							 mensaje += '<ul>';
							 document.getElementById('errores').innerHTML = mensaje;
						}else{
							sweetAlertInitialize();
						   swal({
						      title: "Material solicitado correctamente",
						      type: "success",
						      confirmButtonText: "Continuar",
						   },
						   function(){
						      window.location = '<?php echo URL .'practica'?>';
						   });
						}
			   	}
			   }
		   }
		   ajax.send('elements=' + JSON.stringify(elements) + '&id=' + '<?php echo $id ?>');
		}
	}
</script>