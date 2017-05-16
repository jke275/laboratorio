<?php
include("mpdf/mpdf.php");
//include();
require_once $_POST['root'] . 'publico/Views/templates/translateDate.php';
$alumno = json_decode($_POST['alumno'], true);
$prestamo = json_decode($_POST['prestamo'], true);
$materiales = json_decode($_POST['materiales'], true);

$table .= '<div style="position:relative">
			<div class="row">
				<div class="col-xs-4">
					<img src="img/udg.jpg" style="width: 70px; height: 100px; margin: 0;"/>
				</div>
				<div class="col-xs-4 col-xs-offset-4">
					<img src="img/cunorte.png" style="width: 170px; height: 100px; margin: 0;"/>
				</div>
			</div>
			<br>
			<div class="row" style="background-color: #888888;">
				<div class="col-xs-8 col-xs-offset-2">
					<p class="title">Registro para préstampo de equipo o material</p>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<p><span class="element">Laboratorio:</span> ' . ucwords($_POST['laboratorio']) . '</p>
				</div>
				<div class="col-xs-4">
					<p><span class="element">Fecha:</span> ' . translateDate($prestamo['fecha_prestamo']) . '</p>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<p><span class="element">Nombre del responsable:</span> ' . ucwords($prestamo['responsable']) . '</p>
				</div>
			</div>
			<div class="large-divider"></div>
			<div class="row">
				<div class="col-xs-8 col-xs-offset-3">
					<p class="subtitle">Datos de la persona que solicita el equipo</p>
				</div>
			</div>
			<div class="medium-divider"></div>';
			if($alumno['codigo_alumno']){
			$table .= '<div class="row">
				<div class="col-xs-10">
					<p><span class="element">Nombre:</span> ' . ucwords($alumno['nombre_alumno']) . ' ' . ucwords($alumno['apellidos_alumno']) .
						'</p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<p><span class="element">Código:</span> ' . $alumno['codigo_alumno'] . '</p>
						</div>
						<div class="col-xs-6">
							<p><span class="element">Carrera:</span> ' . ucwords($alumno['carrera']) . '</p>
						</div>
					</div>';
			}else{
				$table .= '<div class="row">
					<div class="col-xs-6">
					<p><span class="element">Nombre:</span> ' . ucwords($alumno['nombre_maestro']) . ' ' . ucwords($alumno['apellidos_maestro']) .
						'</p>

					</div>
						<div class="col-xs-4">
							<p><span class="element">Código:</span> ' . $alumno['codigo_maestro'] . '</p>
						</div></div>';
			}
			$table .= '<div class="row">
				<div  class="col-xs-5 col-xs-offset-4">
					<p class="subtitle">Descripción del prestamo</p>
				</div>
			</div>
			<div class="medium-divider"></div>
			<div class="row">
				<div class="col-xs-10">
					<p><span class="element">Objetivo:</span> ' . ucwords($prestamo['objetivo_prestamo']) . '</p>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-10">
					<p><span class="element">Fecha programada para devolucion:</span> ' . translateDate($prestamo['fecha_entrega']) . '</p>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-10">
					<p class="subtitle">Equipo o material requerido</p>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>
										Código Etiqueta
									</th>
									<th>
										Nombre
									</th>
									<th>
										Estado
									</th>
								</tr>
							</thead>
							<tbody>';
							foreach($materiales as $material){
								$table .= '<tr><td>' . $material['tb_codigo_inventario_codigo_etiqueta'] . '</td><td>' . $material['nombre_inv'] . '</td><td></td></tr>';
								//$table .= '<tr><td></td><td></td><td></td><td></td></tr>';
							}
			$table .= '</tbody>
						</table>
					</div>
				</div>
			</div>
			<br>
			<br>
			<br>
			<div class="row" style="position:absolute; bottom:70">
				<div class="col-xs-7" style="border-style: dotted none dotted dotted;  border-width: 2px;">
					<h4 style="font-weight:bold;">Firmar al entregar</h4>
					<br>
					<br>
					<br>
					<div class="col-xs-4">
						<hr>
						Firma del alumno
					</div>
					<div class="col-xs-5">
						<hr>
						Firma del responsable
					</div>
				</div>
				<div class="col-xs-3" style="border-style: dotted dotted dotted dotted;  border-width: 2px;">
					<h4 style="font-weight:bold;">Firmar al recibir</h4>
					<br>
					<br>
					<br>
					<hr>
					Firma del responsable
				</div>
			</div>
			</div>
			';

$mpdf=new mPDF('c','A4','12','');
$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 1;	// 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet
//$stylesheet = file_get_contents('publico/css/bootstrap.min.css');
//$stylesheet = file_get_contents('publico/css/pdf.css');
$grid = file_get_contents('css/pdf.css');
$css = file_get_contents('css/bootstrap.min.css');
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($grid,1);

$mpdf->SetFooter('Al firmar me comprometo a regresar el material y equipo en el mismo estado en que fue recibido. Si sufre algún daño me comprometo a reponerlo en su totalidad o en su defecto cubrir el costo de recuperación del mismo');
$mpdf->WriteHTML($table, 2);
$mpdf->Output('table.pdf','I');
exit;
?>