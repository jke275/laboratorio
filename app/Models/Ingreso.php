<?php namespace app\Models;
	class Ingreso{
		private $_db;
		private static $_instance = null;

		public function __construct(){
			$this->_db = DB::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new Ingreso();
			}
			return self::$_instance;
		}

		public function listar(){
			$sql = "SELECT t1.*,t2.* FROM ingresos t1 INNER JOIN alumnos t2 ON t1.alumnos_codigo_alumno = t2.codigo_alumno WHERE hora_salida IS null ORDER BY t1.hora_ingreso";
			return $this->_db->query($sql)->results();
		}
	}
?>