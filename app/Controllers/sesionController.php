<?php namespace app\Controllers;
	use app\Models\Session;
	use app\includes\Redirect;

	class sesionController{
		private static $_instance = null;

		public function __construct(){
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new sesionController();
			}
			return self::$_instance;
		}

		public function salir(){
			Session::logout();
			Redirect::to(URL);
		}
	}
?>