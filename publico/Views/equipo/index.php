<?php use app\Core\Config; ?>
<div class="container">
	<div class="row">
		<div class="col-lg-4">
			<select class="form-control" onchange="view(this.value)">
				<option value="comprimido">Comprimido</option>
				<option value="extendido">Extendido</option>
			</select>
		</div>
		<div class="col-lg-2 col-lg-offset-6">
			<form action="<?php echo URL ?>pdf.php" method="POST" id="pdf">
				<input type="hidden" name="info" id="info">
				<input type="hidden" name="name" id="name" value="inventario_equipo">
				<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="" data-original-title="Descargar" onclick="pdf()"><i class="material-icons prefix">file_download</i></button>
			</form>
		</div>
	</div>
</div>
<div class="container">
	<div class="table-responsive" id="list">
	<?php echo comprimido($datos); ?>
	</div>
</div>
<?php
	function comprimido($datos){
		$table = '';
		$table .= '<table class="table table-hover">';
		$table .= '<thead>';
		$table .= '<tr>';
		$table .= '<th>Nombre</th>';
		$table .= '<th>Cantidad</th>';
		$table .= '<th>Marca</th>';
		$table .= '<th>Modelo</th>';
		$table .= '<th>Características</th>';
		$table .= '<th>Detalles</th>';
		$table .= '</tr>';
		$table .= '</thead>';
		$table .= '<tbody>';
		foreach($datos as $fila){
			$table .= '<tr>';
			$table .= '<td>' . ucfirst($fila['nombre_inv']) . '</td>';
			$table .= '<td>' . $fila['cantidad_inv'] . '</td>';
			$table .= '<td>' . ucfirst($fila['marca_equipo']) . '</td>';
			$table .= '<td>' . strtoupper($fila['modelo_equipo']) . '</td>';
			$table .= '<td>' . ucfirst($fila['carac_equipo']) . '</td>';
			$table .= '<td><a href = "' . URL. 'equipo/ver/' . $fila['codigo_inv'] . '"><i class="material-icons prefix">forward</i></a></td>';
			$table .= '</tr>';
		}
		$table .= '</tbody>';
		$table .= '</table>';
		return $table;
	}
?>

<script type="text/javascript">
	function view(value){
		if(value === 'extendido'){
		   ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>inventario.php", true);
		   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		   ajax.onreadystatechange = function() {
			   if(ajax.readyState == 4 && ajax.status == 200){
					$('table').remove();
					document.getElementById('list').innerHTML=ajax.responseText;
			   }
		   }
		   ajax.send('table=equipo');
		}else{
			$('table').remove();
			document.getElementById('list').innerHTML='<?php echo comprimido($datos) ?>';
		}
	}
	function pdf(){
		var table = document.getElementById('list').innerHTML;
		table = table.replace('table class="table table-hover"', 'table class="table table-bordered"');
		var table = table.replace('<th>Detalles</th>', '');
		table = table.split('<tr>');
		for(x = 1; x<table.length; x++){
			table[x] = table[x].replace(/<td><a href.*td>/, '');
		}
		table = '<div class="row" style="background-color: #888888;"><div class="col-xs-10"><strong><h3 class="header">Inventario de Equipo del Laboratorio de <?php echo ucwords(Config::get("laboratorio")) ?></h3></strong></div></div><br>' + table.join('<tr>');
		var form = document.getElementById('pdf');
		document.getElementById('info').value = table;
		form.submit();
	}

	function eliminar(element, codigo_etiqueta, codigo_inv, evt){
		evt.preventDefault();
	 	swal({
      title: '¡Eliminar Código!',
      text: '¿Estas seguro? Esta acción no se puede deshacer.',
      type: "warning",
      showCancelButton: true
      }, function() {
			ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>eliminar_codigo.php", true);
		   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		   ajax.onreadystatechange = function() {
			   if(ajax.readyState == 4 && ajax.status == 200){
			   	if(ajax.responseText){
						equipo = element.parentNode.parentNode;
						document.querySelector('tbody').removeChild(equipo);
					}
			   }
		   }
		   ajax.send('codigo='+codigo_etiqueta+'&id='+codigo_inv);
      });
	}
</script>