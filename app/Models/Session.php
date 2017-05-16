<?php namespace app\Models;


	class Session{
		private static $_instance = null;
		private $_db;

		public function __construct(){
			$this->_db = DB::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new Session();
			}
			return self::$_instance;
		}

		public function login($user, $psw){
			$this->_db->get('usuarios', array('user', '=', $user));
			if($result = $this->_db->first()){

				if(password_verify($psw,$result['password'])){
					User::putSession($result['user'], 'admin', $result['nombre_usuario'] . ' ' . $result['apellidos_usuario'], $result['privilegios']);
					return 'success';
				}else{
					return 'noPsw';
				}
			}else{
				return 'noUser';
			}

		}

		public function login_maestro($codigo, $nombre){
			User::putSession($codigo, 'maestro', $nombre, 0);
			return 'success';
		}

		public function logout(){
			User::deleteSession();
			session_destroy();
		}

	}
?>