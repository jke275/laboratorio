<div class="container">
	<div class="row">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Código del Material</th>
						<th>Nombre del Material</th>
						<th>Código del Alumno</th>
						<th>Nombre del Alumno</th>
						<th>Fecha</th>
						<th>Estado</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($datos as $material){
							?>
							<tr>
								<td><?php echo mb_strtoupper($material['codigo_etiqueta']) ?> </td>
								<td><?php echo ucwords($material['nombre_inv']) ?></td>
								<td><?php echo $material['codigo_alumno'] ?></td>
								<td><?php echo ucwords($material['nombre_alumno']), ' ', ucwords($material['apellidos_alumno']) ?></td>
								<td><?php echo translateDate($material['fecha_danado']) ?></td>
								<td><?php echo ($material['repuesto']) ? 'Repuesto' : 'Dañado' ?></td>
								<td>
									<?php if(!$material['repuesto']){ ?>
										<button onclick="recibir(this, '<?php echo $material['tb_codigo_inventario_codigo_etiqueta']?>', '<?php echo $material['alumnos_codigo_alumno'] ?>')">Recibir</button>
									<?php } ?>
								</td>
							</tr>
							<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	function recibir(element, codigo, alumno){
		swal({
		      title: 'Recibir Material!',
		      text: '¿Estas seguro. Deseas recibir este el repuesto de este material?',
		      type: "warning",
		      showCancelButton: true
		      }, function() {
					ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>material_danado.php", true);
				   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				   ajax.onreadystatechange = function() {
					   if(ajax.readyState == 4 && ajax.status == 200){
					   	if(ajax.responseText){
					   		//var childCount = buttonTd.parentNode.childElementCount;
					   		var buttonTd = element.parentNode;
					   		buttonTd.innerHTML = '';
					   		buttonTd.previousSibling.previousSibling.innerHTML = 'Repuesto';
					   	}
					   }
				   }
				   ajax.send('codigo='+codigo+'&alumno='+alumno);
				});

	}
</script>