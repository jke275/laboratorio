<?php
include("publico/mpdf/mpdf.php");
$header = '<div class="row">
				<div class="col-xs-4">
					<img src="publico/img/udg.jpg" style="width: 70px; height: 90px; margin: 0;"/>
				</div>
				<div class="col-xs-4 col-xs-offset-4">
					<img src="publico/img/cunorte.png" style="width: 170px; height: 90px; margin: 0;"/>
				</div>
			</div>
			<br>';

$mpdf=new mPDF('c','A4','12','');
$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 1;	// 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet
$tableCSS = file_get_contents('publico/css/pdf.css');
$grid = file_get_contents('publico/css/bootstrap.min.css');
$mpdf->WriteHTML($grid,1);
$mpdf->WriteHTML($tableCSS,1);


$mpdf->WriteHTML($header . $_POST['info'],2);
$mpdf->Output($_POST['name'] . '.pdf','I');
exit;
?>