<?php
	use app\Models\DB;
	use app\Core\Config;
	$db = DB::getInstance();

	function todas($datos){

		return $table;
	}
?>
<div class="container">
	<div class="row">
		<div class="col-lg-3">
			<div class="input-group">
				<select class="form-control" id="filtrar">
					<option value="todas">Todas</option>
					<option value="01">Enero</option>
					<option value="02">Febrero</option>
					<option value="03">Marzo</option>
					<option value="04">Abril</option>
					<option value="05">Mayo</option>
					<option value="06">Junio</option>
					<option value="07">Julio</option>
					<option value="08">Agosto</option>
					<option value="09">Septiembre</option>
					<option value="10">Octubre</option>
					<option value="11">Noviembre</option>
					<option value="12">Diciembre</option>
				</select>
				<span class="input-group-btn">
					<button type="button" class="btn btn-raised btn-sm" onclick="filtrar()">Filtrar</button>
				</span>
			</div>
		</div>
		<div class="col-lg-2 col-lg-offset-7">
			<form action="<?php echo URL ?>pdf.php" method="POST" id="pdf">
				<input type="hidden" name="info" id="info">
				<input type="hidden" name="name" id="name" value="Bitácora de Practicas">
				<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="" data-original-title="Descargar" onclick="pdf()"><i class="material-icons prefix">file_download</i></button>
			</form>
		</div>
	</div>
	<div class="table-responsive" id="list">
	<?php echo todas($datos); ?>
	</div>
</div>
<script type="text/javascript">
	var table = '<table class="table table-hover">' +
						'<thead>' +
							'<tr>' +
								'<th>Fecha</th>' +
								'<th>Hora</th>' +
								'<th>Nombre</th>' +
								'<th>Materia</th>' +
								<?php if($_SESSION['type'] == 'admin'){ ?>
									'<th>Maestro</th>' +
								<?php } ?>
								'<th>Estado</th>' +
								'<th>Ingresos</th>' +
								'<th>Detalles</th>' +
								<?php if($_SESSION['type'] == 'admin' && $_SESSION['privilegios'] == 1){ ?>
									'<th>Eliminar</th>' +
								<?php } ?>
							'</tr>' +
						'</thead>' +
						'<tbody>' +
						<?php foreach($datos as $practica){ ?>
							'<tr>' +
							'<td><?php echo translateDate($practica['fecha_practica']) ?></td>' +
							'<td><?php echo date('h:i a', strtotime($practica['hora_practica'])) ?></td>' +
							'<td><?php echo ucfirst($practica['nombre_practica']) ?></td>' +
							'<td><?php echo ucfirst($practica['nombre_materia']) ?></td>' +
							<?php if($_SESSION['type'] == 'admin'){ ?>
								'<td><?php echo ucfirst($practica['nombre_maestro']) . ' ' . ucwords($practica['apellidos_maestro'])?></td>'+
							<?php } ?>
							'<td><?php echo ucfirst($practica['estado'])?></td>' +
							<?php if($practica['estado'] == 'aceptada'){ ?>
								'<td><a href = "<?php echo URL . 'practica/ingreso/' . $practica['id_practica'] ?>"><i class="material-icons prefix">forward</i></a></td><td></td>' +
							<?php }else if($practica['estado'] == 'realizada'){ ?>
								'<td class="ingreso"><?php echo $db->get('ingreso_practica', array('practica_id_practica', '=', $practica['id_practica']))->count() . '/' . $practica['numero_alumnos_practica'] ?></td>' +
								'<td><a href = "<?php echo URL . 'practica/detalles/' . $practica['id_practica'] ?>"><i class="material-icons prefix">forward</i></a></td>' +
							<?php }else{ ?>
								'<td><a href="<?php echo URL . 'practica/aprobar/' . $practica['id_practica'] ?>"><i class="material-icons prefix">forward</i></a></td><td></td>' +
							<?php }
							if($_SESSION['type'] == 'admin' && $_SESSION['privilegios'] == 1){ ?>
							'<td><a href="" data-toggle="tooltip" data-placement="rigth" title="" data-original-title="Eliminar"  onclick="eliminar(\'<?php echo $practica['id_practica'] ?>\', this, event)"><i class="material-icons prefix">delete</i></a></td></tr>' +
						<?php }
						} ?>
						'</tbody>' +
					'</table>';
	$(document).ready(function(){
		document.getElementById('list').innerHTML = table;
	});

	function filtrar(){
		var mes = document.getElementById('filtrar').value;
		if(mes == 'todas'){
			$('table').remove();
			document.getElementById('list').innerHTML=table;
		}else{
			ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>filtrar_practicas.php", true);
		   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		   ajax.onreadystatechange = function() {
			   if(ajax.readyState == 4 && ajax.status == 200){
					$('table').remove();
					document.getElementById('list').innerHTML=ajax.responseText;
			   }
		   }
		   ajax.send('mes='+mes);
		}
	}
	function pdf(){
		var table = document.getElementById('list').innerHTML;
		table = table.replace('table class="table table-hover"', 'table class="table table-bordered"');
		var table = table.replace('<th>Detalles</th><th>Eliminar</th>', '');
		table = table.split('<tr>');
		for(x = 1; x<table.length; x++){
			console.log(table[x]);
			if(table[x].indexOf('class="ingreso"') == -1){
				table[x] = table[x].replace(/<td><a href.*td>/, '<td></td>');
				console.log('no hay ingreso');
			}else{
				table[x] = table[x].replace(/<td><a href.*td>/, '');
				console.log('ya hay ingreso');
			}
			console.log(table[x]);
		}
		table = '<div class="row" style="background-color: #888888;"><div class="col-xs-10"><h3 class="header">Bitácora de Practicas del Laboratorio de <?php echo ucwords(Config::get("laboratorio")) ?></h3></div></div><br>' + table.join('<tr>');
		var form = document.getElementById('pdf');
		document.getElementById('info').value = table;
		form.submit();
	}
	<?php if($_SESSION['type'] == 'admin' && $_SESSION['privilegios'] == 1){ ?>
		function eliminar(idPractica, element, evt){
			var row = element.parentNode.parentNode;
			evt.preventDefault();
			swal({
		      title: '¡Eliminar Practica!',
		      text: '¿Estas seguro? Se eliminara toda la información de esta practica. Esta acción no se puede deshacer.',
		      type: "warning",
		      showCancelButton: true
		      }, function() {
		      	ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>eliminar_practica.php", true);
				   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				   ajax.onreadystatechange = function() {
					   if(ajax.readyState == 4 && ajax.status == 200){
							if(ajax.responseText){
								document.querySelector('tbody').removeChild(row);
							}
					   }
				   }
				   ajax.send('id='+idPractica);
				});
		}
	<?php } ?>
</script>