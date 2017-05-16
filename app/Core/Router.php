<?php namespace app\Core;
	use app\includes\Redirect;

	class Router{
		public function __construct($request){
			$controller = $request->getControlador() . 'Controller';
			$metodo = $request->getMetodo();
			$argumento = $request->getArgumento();

			$rutaController = ROOT . 'app/Controllers' . DS . $controller . '.php';
			if(is_readable($rutaController)){
				require_once $rutaController;
				$archivo = 'app\\Controllers\\' . $controller;
				$controlador = $archivo::getInstance();
				if(method_exists($controlador , $metodo)){
					if(isset($argumento)){
						$datos = call_user_func_array(array($controlador, $metodo), $argumento);
					}else{
						$datos = call_user_func(array($controlador, $metodo));
					}
					//Cargar las vistas
					$rutaVista = ROOT . 'publico' . DS . 'Views'. DS . $request->getControlador() . DS . $request->getMetodo() . '.php';
					$header = ROOT . 'publico' . DS . 'Views' . DS . 'templates/header.php';
					$footer = ROOT . 'publico' . DS . 'Views' . DS . 'templates/footer.php';
					//$ajax = ROOT . 'app' . DS . 'includes' . DS . 'ajax/practica.php';

					require_once $header;
					if(is_readable($rutaVista)){
						require_once $rutaVista;
						//require_once $ajax;
					}
					require_once $footer;
				}else{
					Redirect::to(404);
				}
			}else{
				Redirect::to(404);
			}
		}
	}
?>