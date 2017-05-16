<?php
	require_once 'include.php';
	$elements = $_ajax->getElementosPractica();
	$nombres = array();
	foreach ($elements as $element){
		foreach ($element as $key => $value) {
			$nombres[] = array($value);
		}
	}
	echo json_encode($nombres);
?>