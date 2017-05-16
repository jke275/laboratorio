<?php use app\Core\Config; ?>
<div class="container">
	<div class="row">
		<div class="col-lg-2 col-lg-offset-10">
			<form action="<?php echo URL ?>pdf.php" method="POST" id="pdf">
				<input type="hidden" name="info" id="info">
				<input type="hidden" name="name" id="name" value="inventario_consumibles">
				<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="" data-original-title="Descargar" onclick="pdf()"><i class="material-icons prefix">file_download</i></button>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="table-responsive" id="list">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Código</th>
						<th>Nombre</th>
						<th>Cantidad</th>
						<th>Fecha de Compra</th>
						<th>Fecha de Caducidad</th>
						<th>Características</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($datos as $fila){
							echo '<tr>';
							echo '<td>', mb_strtoupper($fila['codigo_inv']), '</td>';
							echo '<td>', ucwords($fila['nombre_inv']), '</td>';
							echo '<td>', $fila['cantidad_inv'], '</td>';
							echo '<td>', translateDate($fila['compra_consumibles']), '</td>';
							echo '<td>', translateDate($fila['caducidad_consumibles']), '</td>';
							echo '<td>', ucfirst($fila['carac_consumibles']), '</td>';
							echo '<td><a data-toggle="tooltip" data-placement="left" title="" data-original-title="Editar" href = "', URL, 'consumibles/editar/', $fila['codigo_inv'], '"><i class="material-icons">mode_edit</i></a>';
							echo '<a data-toggle="tooltip" data-placement="rigth" title="" data-original-title="Eliminar" href = "', URL, 'consumibles/drop/', $fila['codigo_inv'], '" class="drop"><i class="material-icons">delete</i></a></td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
  $('.drop').click(function(e) {
    e.preventDefault();
    var linkURL = $(this).attr("href");
    var title = "¡Eliminar <?php echo ucfirst($fila['nombre_inv']) ?>!";
    var text = "¿Estas seguro? Esta acción no se puede deshacer.";
    warnBeforeRedirect(title, text, linkURL);
  });
  function pdf(){
		var table = document.getElementById('list').innerHTML;
		table = table.replace('table class="table table-hover"', 'table class="table table-bordered"');
		//var table = table.replace('<th>Detalles</th>', '');
		//table = table.replace(/<td><a href.*td>/, '');
		table = table.split('<tr>');
		for(x = 1; x<table.length; x++){
			table[x] = table[x].replace(/<td><a href.*td>/, '');
		}
		table = '<div class="row" style="background-color: #888888;"><div class="col-xs-10"><strong><h3 class="header">Inventario de Consumibles del Laboratorio de <?php echo ucwords(Config::get("laboratorio")) ?></h3></strong></div></div><br>' + table.join('<tr>');
		var form = document.getElementById('pdf');
		document.getElementById('info').value = table;
		form.submit();
	}
</script>