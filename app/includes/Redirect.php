<?php namespace app\includes;
	use app\includes\errors\Error403;
	use app\includes\errors\Error404;
	class Redirect{
		public static function to($location = null){

			if($location){
				if(is_numeric($location)){
					switch ($location) {
						case 403:
							header('HTTP/1.0 403 Forbidden');
							include_once (ROOT . 'publico/Views/errors/403.php');
							die();
						case 404:
							header('HTTP/1.0 404 Not Found');
							include_once (ROOT . 'publico/Views/errors/404.php');
							die();
					}
				}else{
					header('Location: ' . $location);


				}
			}
		}
	}
?>