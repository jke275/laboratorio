<?php namespace app\Controllers;
	use app\Models\Ingreso;
	class ingresoController{
		private $ingreso, $session;
		private static $_instance = null;

		public function __construct(){
			$this->ingreso = Ingreso::getInstance();
			$this->session = sesionController::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new ingresoController();
			}
			return self::$_instance;
		}

		public function index(){
			if($_POST){
				if($this->session->index()){
				}
			}else{
				return $this->ingreso->listar();
			}
		}
	}
?>