<?php namespace app\Controllers;
	use app\Models\Home;
	class homeController{
		private static $_instance = null;
		private $_home;

		public function __construct(){
			$this->_home = Home::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new homeController();
			}
			return self::$_instance;
		}
		public function index(){
			if($_SESSION['type'] == 'admin'){
				$practicas_aprobacion = $this->_home->getPracticasAprobacion();
				$practicas_pendientes = $this->_home->getPracticasPendientes();
				$caducidad_consumibles = $this->_home->getConsumiblesCaducidad();
				$terminados = $this->_home->getConsumiblesTerminados();
				return array('aprobacion' => $practicas_aprobacion, 'pendientes' => $practicas_pendientes, 'caducidad' => $caducidad_consumibles, 'terminados' => $terminados);
			}else{
				$practicas_aprobacion = $this->_home->getPracticasAprobacion($_SESSION['username']);
				$practicas_pendientes = $this->_home->getPracticasPendientes($_SESSION['username']);
				return array('aprobacion' => $practicas_aprobacion, 'pendientes' => $practicas_pendientes);
			}
		}
	}
?>