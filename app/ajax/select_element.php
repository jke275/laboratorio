<?php
	require_once 'include.php';
	$arr = $_ajax->getElementosPrestamo();
	$elements = array();
	foreach ($arr as $key) {
		$elements[] = array(
			$key['codigo_etiqueta'] . ' / ' . ucwords($key['nombre_inv'])
		);
	}
	echo json_encode($elements);
?>