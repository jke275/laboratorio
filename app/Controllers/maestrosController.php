<?php namespace app\Controllers;
	use app\includes\Redirect;
	use app\includes\Validate;
	use app\Models\Maestros;

	class maestrosController{
		private $_maestros, $_validate;
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
			)
		);

		public function __construct(){
			if($_SESSION['type'] == 'admin' && $_SESSION['privilegios'] == 1){
				$this->_maestros = Maestros::getInstance();
				$this->_validate = Validate::getInstance();
			}else{
				Redirect::to(403);
			}
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new maestrosController();
			}
			return self::$_instance;
		}
		public function index(){
			return $this->_maestros->listar();
		}

		public function editar($codigo){
			if($_POST){
				$this->_validate->check($_POST, $this->check);
				if($this->_validate->passed()){
					$this->_maestros->actualizar($codigo);
					Redirect::to(URL . 'maestros');
				}
				else{
					return $this->_validate->errors();
				}
			}else{
				return $this->_maestros->listar($codigo);
			}
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
					)
				), 'maestros', 'codigo_maestro');
				if($this->_validate->passed()){
					if($this->_maestros->add()){
						Redirect::to(URL . 'maestros');
					}
				}else{
					return $this->_validate->errors();
				}
			}
		}
	}
?>