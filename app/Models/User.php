<?php namespace app\Models;
	use app\Core\Config;

	class User{
		public static function putSession($username, $user, $name, $privilegios){
			$_SESSION['username'] = $username;
			$_SESSION['type'] = $user;
			$_SESSION['name'] = $name;
			$_SESSION['privilegios'] = $privilegios;
			$_SESSION['laboratorio'] = Config::get('mysql/db');
		}

		public static function deleteSession(){
			unset($_SESSION['username']);
			unset($_SESSION['type']);
			unset($_SESSION['name']);
			unset($_SESSION['laboratorio']);
		}
	}
?>