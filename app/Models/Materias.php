<?php namespace app\Models;
	class Materias{
		private static $_instance = null;
		private $_db;

		public function __construct(){
			$this->_db = DB::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new Materias();
			}
			return self::$_instance;
		}

		public function listar($id = null){
			if($id){
				return $this->_db->query("SELECT * FROM materia WHERE id_materia = ?", array($id))->first();
			}else{
				return $this->_db->query("SELECT * FROM materia")->results();
			}
		}

		public function add(){
			if($this->_db->insert('materia', array(
				'id_materia' => mb_strtolower($_POST['codigo']),
				'nombre_materia' => mb_strtolower($_POST['nombre'])
			))){
				return true;
			}
		}

		public function actualizar($id){
			$this->_db->update('materia', 'id_materia', $id, array(
				'id_materia' => mb_strtolower($_POST['codigo']),
				'nombre_materia' => mb_strtolower($_POST['nombre']),
			));
		}
	}
?>