<?php namespace app\Controllers;
	use app\Models\Inventario;
	use app\includes\Validate;

	class inventarioController{
		private $_inventario;
		private static $_instance = null;
		public function __construct(){
			$this->_inventario = Inventario::getInstance();
			$this->_validate = Validate::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new inventarioController();
			}
			return self::$_instance;
		}

		public function index(){
			if($_POST){
				$this->_validate->check($_POST, array(
					'nombre' => array(
						'type' => 'string',
						'required' => true
					)
				));
				if($this->_validate->passed()){
					if($this->_inventario->search($_POST['nombre'])){
						$codigo = $this->_inventario->search($_POST['nombre'])['codigo_inv'];
						$tipo = $this->_inventario->search($_POST['nombre'])['tipo'];
						switch($tipo){
							case 'equipo':
								return array('type' => 'search', 'results' => $this->_inventario->getEquipo($codigo));
								break;
							case 'material':
								return array('type' => 'search', 'results' => $this->_inventario->getInstrumentos($codigo));
								break;
							case 'consumibles':
								return array('type' => 'search', 'results' => $this->_inventario->getConsumibles($codigo));
								break;
						}
					}else{
						return false;
					}
				}else{
					return array('type' => 'errors', 'results' => $this->_inventario->listar(), 'errors' => $this->_validate->errors());
				}
			}else{
				return array(
					'type' => 'results',
					'results' => array(
						'equipo' => $this->_inventario->getEquipo(),
						'instrumentos' => $this->_inventario->getInstrumentos(),
						'consumibles' => $this->_inventario->getConsumibles()
					)
				);
			}
		}
	}
?>