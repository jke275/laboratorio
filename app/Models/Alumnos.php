<?php namespace app\Models;
	class Alumnos{
		private static $_instance = null;
		private $_db;

		public function __construct(){
			$this->_db = DB::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new Alumnos();
			}
			return self::$_instance;
		}

		public function listar($codigo = null){
			if($codigo){
				return $this->_db->query("SELECT * FROM alumnos WHERE codigo_alumno = ?", array($codigo))->first();
			}else{
				return $this->_db->query("SELECT * FROM alumnos")->results();
			}
		}

		public function add(){
			if($this->_db->insert('alumnos', array(
				'codigo_alumno' => mb_strtolower($_POST['codigo']),
				'nombre_alumno' => mb_strtolower($_POST['nombre']),
				'apellidos_alumno' => mb_strtolower($_POST['apellidos']),
				'carrera' => mb_strtolower($_POST['carrera'])
			))){
				return true;
			}
		}

		public function actualizar($codigo){
			$this->_db->update('alumnos', 'codigo_alumno', $codigo, array(
				'codigo_alumno' => mb_strtolower($_POST['codigo']),
				'nombre_alumno' => mb_strtolower($_POST['nombre']),
				'apellidos_alumno' => mb_strtolower($_POST['apellidos']),
				'carrera' => mb_strtolower($_POST['carrera'])
			));
		}
	}
?>