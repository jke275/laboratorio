<?php namespace app\Models;
	class Maestros{
		private static $_instance = null;
		private $_db;

		public function __construct(){
			$this->_db = DB::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new Maestros();
			}
			return self::$_instance;
		}

		public function listar($codigo = null){
			if($codigo){
				return $this->_db->query("SELECT * FROM maestros WHERE codigo_maestro = ?", array($codigo))->first();
			}else{
				return $this->_db->query("SELECT * FROM maestros")->results();
			}
		}

		public function add(){
			if($this->_db->insert('maestros', array(
							'codigo_maestro' => mb_strtolower($_POST['codigo']),
							'nombre_maestro' => mb_strtolower($_POST['nombre']),
							'apellidos_maestro' => mb_strtolower($_POST['apellidos'])
						))){
				return true;
			}
		}

		public function actualizar($codigo){
			$this->_db->update('maestros', 'codigo_maestro', $codigo, array(
				'codigo_maestro' => mb_strtolower($_POST['codigo']),
				'nombre_maestro' => mb_strtolower($_POST['nombre']),
				'apellidos_maestro' => mb_strtolower($_POST['apellidos'])
			));
		}
	}
?>