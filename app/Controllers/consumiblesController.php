<?php namespace app\Controllers;
	use app\Models\Consumibles;
	use app\includes\Redirect;
	use app\includes\Validate;

	class consumiblesController{
		private $_consumibles, $_validate;
		private static $_instance = null;
		private $check = array(
			'nombre' => array(
				'type' => 'string',
				'required' => true
			),
			'cantidad' => array(
				'min' => 1,
				'type' => 'number',
				'required' => true
			),
			'compra' => array(
				'type' => 'date',
				'required' => true
			),
			'caducidad' => array(
				'type' => 'date',
				'required' => true
			),
			'caracteristicas' => array(
				'required' => true
			)
		);

		public function __construct(){
			if($_SESSION['type'] == 'admin' && $_SESSION['privilegios'] == 1){
				$this->_consumibles = Consumibles::getInstance();
				$this->_validate = Validate::getInstance();
			}else{
				Redirect::to(403);
			}
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new consumiblesController();
			}
			return self::$_instance;
		}

		public function index($codigo = null){
			return $this->_consumibles->listar();
		}

		public function agregar(){
			if($_POST){
				$this->check['codigo_inv'] = array(
					'type' => 'string',
					'required' => true,
					'unique' => true
				);
				$this->_validate->check($_POST,  $this->check, 'inventario', 'codigo_inv');

				if($this->_validate->passed()){
					$this->_consumibles->add();
					Redirect::to(URL . 'consumibles');
				}else{
					return $this->_validate->errors();
				}
			}
		}

		public function editar($codigo){
			if($_POST){
				if($_POST['codigo_inv'] == $codigo){
					$this->check['codigo_inv'] = array(
						'type' => 'string',
						'required' => true,
					);
				}else{
					$this->check['codigo_inv'] = array(
						'type' => 'string',
						'required' => true,
						'unique' => true
					);
				}
				$this->_validate->check($_POST, $this->check, 'inventario', 'codigo_inv');
				if($this->_validate->passed()){
					$this->_consumibles->actualizar($codigo);
					Redirect::to(URL . 'consumibles');
				}else{
					return $this->_validate->errors();
				}
			}else{
				return $this->_consumibles->listar($codigo);
			}
		}

		public function drop($consumibles){
			$this->_consumibles->drop($consumibles);
			Redirect::to(URL . 'consumibles');
		}
	}
?>