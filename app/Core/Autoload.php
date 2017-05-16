<?php namespace app\Core;

	class Autoload{

		public function __construct(){
			spl_autoload_register(function($class){
				$ruta = str_replace('\\', '/', $class) . '.php';
				include_once $ruta;
			});
		}

	}

?>