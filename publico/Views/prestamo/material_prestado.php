 <?php
	function todos($prestamos){
		$table = '';
		$table .= '<table class="table table-hover">';
		$table .= '<thead>';
		$table .= '<tr>';
		$table .= '<th>Fecha Préstamo</th>';
		$table .= '<th>Fecha Devolución</th>';
		$table .= '<th>Código Alumno</th>';
		$table .= '<th>Nombre Alumno</th>';
		$table .= '<th>Código Material</th>';
		$table .= '<th>Nombre Material</th>';
		$table .= '<th>Estado</th>';
		$table .= '</tr>';
		$table .= '</thead>';
		$table .= '<tbody>';
		foreach($prestamos as $prestamo){
			$table .= '<tr>';
			$table .= '<td>' . translateDate($prestamo['fecha_prestamo']) . '</td>';
			$table .= '<td>' . translateDate($prestamo['fecha_entrega']) . '</td>';
			$table .= '<td>' . $prestamo['alumnos_codigo_alumno'] . '</td>';
			$table .= '<td>' . ucwords($prestamo['nombre_alumno']) . ' ' . ucwords($prestamo['apellidos_alumno']) . '</td>';
			$table .= '<td>' . mb_strtoupper($prestamo['tb_codigo_inventario_codigo_etiqueta']) . '</td>';
			$table .= '<td>' . ucwords($prestamo['nombre_inv']) . '</td>';
			$table .= '<td>';
			($prestamo['recibido']) ? $table .= '<p class="bg-success">Recibido' : $table .= '<p class="bg-danger">Prestado';
			$table .= '</p></td>';
		}
		$table .= '</tbody>';
		$table .= '</table>';
		return $table;
	}

?>
<div class="container">
	<div class="row">
		<div class="col-lg-4">
			<select class="form-control" onchange="view(this.value)">
				<option value="todos">Todos</option>
				<option value="prestados">Prestados</option>
				<option value="recibidos">Recibidos</option>
			</select>
		</div>
		<div class="col-lg-2 col-lg-offset-6">
			<form action="<?php echo URL ?>pdf.php" method="POST" id="pdf">
				<input type="hidden" name="info" id="info">
				<input type="hidden" name="name" id="name" value="prestamos">
				<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="" data-original-title="Descargar" onclick="pdf()"><i class="material-icons prefix">file_download</i></button>
			</form>
		</div>
	</div>
</div>
<div class="container">
	<div class="table-responsive" id="list">
	<?php
		echo todos($datos);
	?>
	</div>
</div>

<script type="text/javascript">
	function view(value){
		if(value === 'todos'){
			$('table').remove();
			document.getElementById('list').innerHTML='<?php echo todos($datos) ?>';
		}else{
			ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>prestamos.php", true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.onreadystatechange = function() {
				if(ajax.readyState == 4 && ajax.status == 200){
					$('table').remove();
					document.getElementById('list').innerHTML=ajax.responseText;
				}
		   }
		   ajax.send('table=' + value);
		}
	}

	function pdf(){
		var table = document.getElementById('list').innerHTML;
		var info = table.replace('table class="table table-hover"', 'table class="table table-bordered"');
		var form = document.getElementById('pdf');
		var input = document.getElementById('info').value = info;
		form.submit();
	}
</script>