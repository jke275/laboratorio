<?php namespace app\Controllers;
	use app\includes\Redirect;
	use app\includes\Validate;
	use app\Models\Alumnos;

	class alumnosController{
		private $_alumnos, $_validate;
		private static $_instance = null;
		private $check = array(
			'codigo' => array(
				'type' => 'string',
				'required' => true,
			),
			'nombre' => array(
				'type' => 'string',
				'required' => true
			),
			'apellidos' => array(
				'type' => 'string',
				'required' => true
			),
			'carrera' => array(
				'type' => 'string',
				'required' => true
			)
		);

		public function __construct(){
			if($_SESSION['type'] == 'admin' && $_SESSION['privilegios'] == 1){
				$this->_alumnos = Alumnos::getInstance();
				$this->_validate = Validate::getInstance();
			}else{
				Redirect::to(403);
			}
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new alumnosController();
			}
			return self::$_instance;
		}
		public function index(){
			return $this->_alumnos->listar();
		}

		public function agregar(){
			if($_POST){
				$this->_validate->check($_POST, array(
					'codigo' => array(
						'type' => 'string',
						'required' => true,
						'unique' => true
					),
					'nombre' => array(
						'type' => 'string',
						'required' => true
					),
					'apellidos' => array(
						'type' => 'string',
						'required' => true
					),
					'carrera' => array(
						'type' => 'string',
						'required' => true
					)
				), 'alumnos', 'codigo_alumno');
				if($this->_validate->passed()){
					if($this->_alumnos->add()){
						Redirect::to(URL . 'alumnos');
					}
				}else{
					return $this->_validate->errors();
				}
			}
		}

		public function editar($codigo){
			if($_POST){
				$this->_validate->check($_POST, $this->check);
				if($this->_validate->passed()){
					$this->_alumnos->actualizar($codigo);
					Redirect::to(URL . 'alumnos');
				}
				else{
					return $this->_validate->errors();
				}
			}else{
				return $this->_alumnos->listar($codigo);
			}
		}
	}
?>