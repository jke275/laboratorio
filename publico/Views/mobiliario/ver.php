<?php
	$info = $datos[0];
	$codigos = $datos[1];
?>
<div class="container">
	<div class="col-lg-3 col-lg-offset-9">
		<div class="form-group is-empty">
			<label for="cantidad">Cantidad</label>
			<div class="input-group">
				<input type="text" name="" id="cantidad" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-raised btn-sm" onclick="add()">Añadir más</button>
				</span>
			</div>
		</div>
	</div>
</div>
<div id="modal"></div>
<div class="container">
	<div class="col-lg-9">
		<div class="row">
			<div class="col-lg-12">
				<strong class="big-font">Nombre:  </strong>
				<span class="big-font"><?php echo ucfirst($info['nombre_inv']); ?></span>
			</div>
		</div>
		<div class="divider"></div>
		<div class="row">
			<div class="col-lg-12">
				<strong class="big-font">Características: </strong>
				<span class="big-font"><?php echo ucfirst($info['carac_mobiliario']) ?></span>
			</div>
		</div>
		<div class="divider"></div>
		<div class="row">
			<div class="btn-group btn-group-raised">
				<a href = "<?php echo URL, 'mobiliario/editar/', $info['codigo_inv']; ?>" class="btn">Editar</a>
				<a href = "<?php echo URL, 'mobiliario/drop/', $info['codigo_inv']; ?>" class="btn drop">Eliminar</a>
				<a href = "<?php echo URL, 'mobiliario'; ?>" class="btn">Regresar</a>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<div id="imagen-inv">
			<img class="inventario" id="ruta-imagen" src="../../publico/img/inventario/<?php echo ($info['imagen']) ? $info['imagen'] : 'sin_imagen.png' ?>">
		</div>
		<div class="form-group form-group-lg is-fileinput" id="imagen-input">
			<input class="form-control" type="text" placeholder="Cambiar Imagen(maximo 1 MB)" readonly="" >
			<input type="file" name="imagen" id="imagen">
		</div>
		<input type="button" name="" value="Actualizar" class="btn btn-raised" onclick="actualizar()">
	</div>
</div>

<div class="container">
	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Código</th>
					<th>Estado</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach($codigos as $codigo){
					echo '<tr>';
					echo '<td>', $codigo['codigo_etiqueta'], '</td>';
					echo '<td>', ucfirst($codigo['estado']), '</td>';
					//echo '<td>', $codigo['disponible'], '</td>';
					echo '<td>';
					echo '<a data-toggle="tooltip" data-placement="left" title="" data-original-title="Editar Código" href = "', URL, 'mobiliario/editar_codigo/' . str_replace(' ', '_', $info['codigo_inv']) . '/' . $codigo['codigo_etiqueta'] . '"><i class="material-icons prefix">mode_edit</i></a>';
					echo '<a data-toggle="tooltip" data-placement="rigth" title="" data-original-title="Eliminar" href = "', URL, 'mobiliario/eliminar/' . $info['codigo_inv'] . '/' . $codigo['codigo_etiqueta'] . '" class="eliminar"><i class="material-icons prefix">delete</i></a>';
					echo '</td>';
					echo '</tr>';
				}
			?>
		</tbody>
		</table>
	</div>
</div>

<script>
	function add(button){
		var element = document.getElementById('cantidad');
		var cantidad = parseFloat(element.value);
		if(cantidad){
			document.getElementById('modal').innerHTML = createModal(cantidad);
			$('#new').modal('show');
		}else{
			var mensaje = 'Este valor es requerido';
			addError(element, mensaje);
		}
	}

	function actualizar(){
		var element = document.getElementById('imagen-input');
		var file = document.getElementById("imagen");
      if(file.files[0]){
	      var formData = new FormData();
	      formData.append("upload", file.files[0]);
	      formData.append("codigo", '<?php echo $info['codigo_inv'] ?>');
	      ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>actualizar_imagen.php", true);
	   	ajax.onreadystatechange = function(){
	   		if (ajax.readyState == 4 && ajax.status == 200){
					var result = JSON.parse(ajax.responseText);
					if(result.type == 'success'){
						window.location = '';
					}else{
						addError(element, result.mensaje)
					}
	   		}
	   	}
	   	ajax.send(formData);
      }else{
			var mensaje = 'Porfavor selecciona una imagen';
			addError(element, mensaje)
      }
	}

	function createModal(cantidad){
		var modal = '<div id="new" class="modal fade" style="display: none;" tabindex="-1">' +
	  						'<div class="modal-dialog">' +
	    						'<div class="modal-content">' +
	      						'<div class="modal-body">' +
	      							'<form action="" method="POST" class="bs-component"><div class="row">';
	   for(x = 1; x<=cantidad; x++){
	   	modal +=	'<div class="form-group form-group-lg col-lg-6">' +
							'<label for="codigo' + x + '" class="control-label">Código</label>' +
							'<input type="text" id="codigo' + x + '" name="codigo' + x + '" class="form-control" value="">' +
						'</div>' ;
	   }
		modal += '</div><div class="row"><div class="col-lg-3 col-lg-offset-4"><button type="submit" class="btn btn-primary btn-raised">Agregar</button></div></div>' +
					'</form>' +
	   			'</div>' +
	   			'</div>' +
	  				'</div>' +
					'</div>';
		return modal;
	}

  $('.eliminar').click(function(e) {
    e.preventDefault();
    var linkURL = $(this).attr("href");
    var title = '¡Eliminar Código!';
    var text = '¿Estas seguro? Esta acción no se puede deshacer.';
    warnBeforeRedirect(title, text, linkURL);
  });
  $('.drop').click(function(e) {
    e.preventDefault();
    var linkURL = $(this).attr("href");
    var title = "¡Eliminar <?php echo ucfirst($info['nombre_inv']) ?>!";
    var text = "¿Estas seguro? Se eliminaran <?php echo $info['cantidad_inv'] ?> elementos y esta acción no se puede deshacer.";
    warnBeforeRedirect(title, text, linkURL);
    //console.log(title);
  });
</script>
