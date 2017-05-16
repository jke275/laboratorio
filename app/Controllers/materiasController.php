<?php namespace app\Controllers;
	use app\includes\Redirect;
	use app\includes\Validate;
	use app\Models\Materias;
	class materiasController{
		private $_materias, $_validate;
		private static $_instance = null;
		private $check = array(
			'codigo' => array(
				'type' => 'string',
				'required' => true
			),
			'nombre' => array(
				'type' => 'string',
				'required' => true
			)
		);

		public function __construct(){
			if($_SESSION['type'] == 'admin' && $_SESSION['privilegios'] == 1){
				$this->_materias = Materias::getInstance();
				$this->_validate = Validate::getInstance();
			}else{
				Redirect::to(403);
			}
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new materiasController();
			}
			return self::$_instance;
		}

		public function index(){
			return $this->_materias->listar();
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
					)
				), 'materia', 'id_materia');
				if($this->_validate->passed()){
					if($this->_materias->add()){
						Redirect::to(URL . 'materias');
					}
				}else{
					return $this->_validate->errors();
				}
			}
		}

		public function editar($id){
			if($_POST){
				$this->_validate->check($_POST, $this->check);
				if($this->_validate->passed()){
					$this->_materias->actualizar($id);
					Redirect::to(URL . 'materias');
				}
				else{
					return $this->_validate->errors();
				}
			}else{
				return $this->_materias->listar($id);
			}
		}
	}
?>