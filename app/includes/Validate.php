<?php namespace app\includes;

	use app\Models\DB;

	class Validate{
		private static $_instance = null;
		private $_passed = false,
						$_errors = array(),
						$_db;

		private function __construct(){
			$this->_db = DB::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new Validate();
			}
			return self::$_instance;
		}

		public function check($source, $items = array(), $table = '', $id = ''){
			foreach($items as $item => $rules){
				foreach ($rules as $rule => $rule_value){

					$value = trim($source[$item]);
					$item = $this->escape($item);

					if($rule === 'required' && empty($value)){
						$this->addError($item, 'Este valor es requerido');
					}elseif(!empty($value)){
						switch ($rule) {
							case 'min':
								if(is_numeric($value) && $value < $rule_value){
									$this->addError($item, "La cantidad debe ser mayor a {$rule_value}");
								}
								break;
							case 'max':
								if(strlen($value) > $rule_value){
									$this->addError($item, "La cantidad debe ser menor a {$rule_value}");
								}
								break;
							case 'type':
								if($rule_value == 'string'){
									if(!$this->pattern($value)){
										$this->addError($item, "Solo puede contener letras, números, espacios, \"/\" y \"-\".");
									}
								}elseif($rule_value == 'number'){
									if(!is_numeric($value)){
										$this->addError($item, "Este valor debe ser un numero");
									}
								}elseif($rule_value == 'time'){
									$var = explode(':', $value);
									if(strlen($var[0]) == 2 && strlen($var[1]) == 2){
										$date = \DateTime::createFromFormat('H:i', $value);
										$date_errors = \DateTime::getLastErrors();
										if(!$date){
											$this->addError($item, "La fecha debe ser en el formato HH:ii (24 horas)");
										}else{
											if($date_errors['warning_count'] + $date_errors['error_count'] > 0){
												$this->addError($item, "Hora invalida");
											}
										}
									}else{
										$this->addError($item, "La fecha debe ser en el formato HH:ii (24 horas)");
									}
								}elseif($rule_value == 'date'){
									$var = explode('-', $value);
									if(strlen($var[0]) == 2 && strlen($var[1]) == 2 && strlen($var[2]) == 4){
										$date = \DateTime::createFromFormat('d-m-Y', $value);
										$date_errors = \DateTime::getLastErrors();
										if(!$date){
											$this->addError($item, "La fecha debe ser en el formato DD-MM-YYYY");
										}else{
											if($date_errors['warning_count'] + $date_errors['error_count'] > 0){
												$this->addError($item, "Fecha invalida");
											}
										}
									}else{
										$this->addError($item, "La fecha debe ser en el formato DD-MM-YYYY");
									}
								}
								break;
							case 'unique':
								$value = strtoupper($value);
								$this->_db->get($table, array($id, '=', $value));
								if($this->_db->results()){
									if($table == 'usuarios'){
										$this->addError($item, 'Este usuario no esta disponible');
									}else{
										$this->addError($item, 'Este código ya esta registrado');
									}
								}
								break;
						}
					}
				}
			}
			if(empty($this->_errors)){
				$this->_passed = true;
			}
			return $this;
		}

		public function addError($item,$error){
			$this->_errors[$item][0] = $error;
		}

		public function escape($string){
			return htmlentities($string, ENT_QUOTES, 'UTF-8');
		}

		public function pattern($val){
			return (bool)preg_match("/^([\/\p{L}- 0-9])+$/ui", $val);
		}

		public function errors(){
			return $this->_errors;
		}

		public function passed(){
			return $this->_passed;
		}
	}
?>