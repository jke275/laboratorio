<?php
	require_once 'include.php';
	if($_POST){
		$_validate->check($_POST, array(
			'fecha' => array(
				'type' => 'date',
				'required' => true
			),
			'hora' => array(
				'type' => 'time',
				'required' => true
			),
			'duracion_horas' => array(
				'type' => 'number',
				'required' => true
			),
			'duracion_minutos' => array(
				'type' => 'number',
				'required' => true
			)
		));
		if($_validate->passed()){
			$available = true;
			$resultHours = array();
			$results = $_ajax->checkAvailable(date("Y-m-d", strtotime($_POST['fecha'])));
			$x = 0;
			//Ingresar en un array las horas que ya esten ingresadas en la base de datos
			foreach ($results as $result){
				$time = explode(':', $result['hora_practica']);
				$resultHours[$x] = array(
					'startHour' => $time[0] . ':' . $time[1],
					'finishHour' => $time[0] + $result['duracion_practica'] . ':' . $time[1],
				);
				$x++;
			}
			//Divide la hora solicitada en hora y minutos
			$askedTime = explode(':', $_POST['hora']);
			$askedHour = $askedTime[0];
			$askedMinutes = $askedTime[1];
			//Calcula la hora en que finaliza la practica solicitada sumando la duracion
			$finishHour = $askedHour + $_POST['duracion_horas'];
			if($askedMinutes + $_POST['duracion_minutos'] == 60){
				$finishAskedHour = (string)($finishHour + 1) .':'.(string)(00);
			}else{
				$finishAskedHour = (string)$finishHour .':'.(string)($askedMinutes + $_POST['duracion_minutos']);
			}

			foreach ($resultHours as $hour){
				if((strtotime($_POST['hora']) >= strtotime($hour['startHour']) && strtotime($_POST['hora']) < strtotime($hour['finishHour'])) ||
					(strtotime($finishAskedHour) > strtotime($hour['startHour']) && strtotime($finishAskedHour) < strtotime($hour['finishHour'])) ||
					(strtotime($finishAskedHour) >= strtotime($hour['finishHour']) && strtotime($_POST['hora']) < strtotime($hour['finishHour'])) ){
					$available = false;
					break;
				}
			}

			if($available){
				echo true;
			}else{
				$result = array('type' => 'hours', 'results' => $resultHours);
				echo json_encode($result);
			}
		}else{
			$result = array('type' => 'errors', 'results' => $_validate->errors());
			echo json_encode($result);
		}
	}
?>

