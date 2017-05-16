<?php namespace app\Models;
	class Administrar{
		private static $_instance = null;
		private $_db;

		public function __construct(){
			$this->_db = DB::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new Administrar();
			}
			return self::$_instance;
		}

		public function getUsuario(){
			return $this->_db->get('usuarios', array('user', '=', $_SESSION['username']))->first();
		}

		public function verIngresos(){
			$sql = "SELECT t1.*,t2.* FROM ingresos t1 INNER JOIN alumnos t2 ON t1.alumnos_codigo_alumno = t2.codigo_alumno ORDER BY fecha_ingreso, hora_ingreso";
			return $this->_db->query($sql)->results();
		}

		public function updatePassword(){
			$options = [
				'cost' => 11,
			];
			$this->_db->update('usuarios', 'user', $_SESSION['username'], array(
				'password' => password_hash($_POST['psw-nueva'], PASSWORD_BCRYPT, $options)
			));
			return $this->_db->error();
		}

		public function addUser(){
			$options = [
				'cost' => 11,
			];
			$this->_db->insert('usuarios', array(
				'user' => mb_strtolower($_POST['usuario']),
				'nombre_usuario' => mb_strtolower($_POST['nombre']),
				'apellidos_usuario' => mb_strtolower($_POST['apellidos']),
				'password' => password_hash($_POST["psw"], PASSWORD_BCRYPT, $options),
				'privilegios' => ($_POST['privilegios']) ? 1 : 0
			));
			return $this->_db->error();
		}
	}
?>