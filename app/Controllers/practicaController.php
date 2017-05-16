<?php namespace app\Controllers;

	use app\Models\Practica;
	use app\includes\Redirect;
	use app\includes\Validate;

	class practicaController{
		private static $_instance = null;
		private $_practica, $_validate;

		public function __construct(){
			$this->_practica = Practica::getInstance();
			$this->_validate = Validate::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new practicaController();
			}
			return self::$_instance;
		}

		public function aprobar($id){
			if($_SESSION['type'] == 'admin'){
				$practica = $this->_practica->ver($id);
				if($practica['estado'] == 'pendiente'){
					return array('detalles' => $practica, 'materiales' => $this->_practica->detallesMateriales($id));
				}else{
					Redirect::to(URL);
				}
			}else{
				Redirect::to(403);
			}
		}

		public function ver($id){
			$practica = $this->_practica->listar()[0];
			if($practica['estado'] == 'aceptada'){
				return array('detalles' => $practica, 'materiales' => $this->_practica->detallesMateriales($id));
			}else{
				Redirect::to(URL);
			}
		}

		public function solicitar(){
			$values = array(
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
				),
				'nombre_practica' => array(
					'type' => 'string',
					'required' => true
				),
				'cantidad_alumnos' => array(
					'min' => 1,
					'type' => 'number',
					'required' => true
				),
				'materia_practica' => array(
					'type' => 'string',
					'required' => true
				)
			);
			if($_SESSION['type'] == 'admin'){
				$values['maestro_practica'] = array(
						'type' => 'string',
						'required' => true
					);
			}
			if($_POST){
				$this->_validate->check($_POST,$values);
				if($this->_validate->passed()){
					$available = true;
					$resultHours = array();
					$results = $this->_practica->checkAvailable(date("Y-m-d", strtotime($_POST['fecha'])));
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
						$name = explode(' ', trim($_POST['nombre_practica']));
						$id = (count($name) > 1) ? mb_strtolower($name[0]) . '-' . mb_strtolower($name[1]) . '-' . uniqid() : mb_strtolower($name[0]) . '-' . uniqid();
						$this->_practica->add($id);
						if($_POST['material']){
							Redirect::to(URL . 'practica/material/' . $id);
						}else{
							return true;
						}
					}else{
						return array('hora' => array('Esta hora y esta duración no estan disponibles'));
					}
				}else{
					return $this->_validate->errors();
				}
			}
		}

		public function material($id){
			if($this->_practica->get('id_practica', $id)['estado'] == 'realizada'){
				Redirect::to(URL . 'practica');
			}
		}

		public function detalles($id){
			if($this->_practica->get('id_practica', $id)[estado] == 'realizada'){
				return $this->_practica->detalles($id);
			}else{
				Redirect::to(URL . 'practica');
			}
		}

		public function index(){
			if($_SESSION['type'] == 'admin'){
				return $this->_practica->listar();
			}else{
				return $this->_practica->listar($_SESSION['username']);
			}
		}

		public function ingreso($id){
			$id_practica = $this->_practica->get('id_practica', $id);
			if($id_practica){
				if(!($id_practica['estado'] == 'aceptada')){
					Redirect::to(URL . 'practica');
				}
				return $this->_practica->getIngresos($id);
			}else{
				Redirect::to(URL . 'practica');
			}
		}
	}
?>