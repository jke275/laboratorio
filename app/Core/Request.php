<?php namespace app\Core;

	use app\Models\User;

	class Request{
		private $controlador,
				$metodo,
				$argumento;

		public function __construct(){
			$ruta = explode('/', filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL));
			if($ruta[0] == 'inventario'){
				$this->controlador = 'inventario';
				$this->metodo = 'index';
			}else{
				if($_SESSION['laboratorio'] == Config::get('mysql/db')){
					if(isset($_GET['url'])){
						$this->controlador = strtolower(array_shift($ruta));
						$this->metodo = strtolower(array_shift($ruta));
						if(!$this->metodo){
							$this->metodo = 'index';
						}
						$this->argumento = $ruta;
					}else{
						$this->controlador = 'home';
						$this->metodo = 'index';
					}
				}else{
					$this->controlador = 'ingreso';
					$this->metodo = 'index';

				}
			}
		}

		public function getControlador(){
			return $this->controlador;
		}

		public function getMetodo(){
			return $this->metodo;
		}

		public function getArgumento(){
			return $this->argumento;
		}
	}
?>