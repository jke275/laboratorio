<?php namespace app\Models;
	class Inventario{
		private static $_instance = null;
		private $_db;

		public function __construct(){
			$this->_db = DB::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new Inventario();
			}
			return self::$_instance;
		}

		public function getEquipo($codigo = null){
			if(!$codigo){
				$sql = "SELECT t1.*, t2.* FROM inventario t1 INNER JOIN equipo t2 ON t1.codigo_inv = t2.inventario_codigo_inv WHERE t1.tipo = ? ORDER BY t1.nombre_inv ASC";
				return $this->_db->query($sql, array('equipo'))->results();
			}else{
				$sql = "SELECT t1.*, t2.* FROM inventario t1 INNER JOIN equipo t2 ON t1.codigo_inv = t2.inventario_codigo_inv WHERE t1.codigo_inv = ?";
				return $this->_db->query($sql, array($codigo))->results();
			}
		}

		public function getInstrumentos($codigo = null){
			if(!$codigo){
				$sql = "SELECT t1.*, t2.* FROM inventario t1 INNER JOIN material t2 ON t1.codigo_inv = t2.inventario_codigo_inv WHERE t1.tipo = ? ORDER BY t1.nombre_inv ASC";
				return $this->_db->query($sql, array('material'))->results();
			}else{
				$sql = "SELECT t1.*, t2.* FROM inventario t1 INNER JOIN material t2 ON t1.codigo_inv = t2.inventario_codigo_inv WHERE t1.codigo_inv = ?";
				return $this->_db->query($sql, array($codigo))->results();
			}
		}

		public function getConsumibles($codigo = null){
			if(!$codigo){
				$sql = "SELECT t1.*, t2.* FROM inventario t1 INNER JOIN consumibles t2 ON t1.codigo_inv = t2.inventario_codigo_inv WHERE t1.tipo = ? ORDER BY t1.nombre_inv ASC";
				return $this->_db->query($sql, array('consumibles'))->results();
			}else{
				$sql = "SELECT t1.*, t2.* FROM inventario t1 INNER JOIN consumibles t2 ON t1.codigo_inv = t2.inventario_codigo_inv WHERE t1.codigo_inv = ?";
				return $this->_db->query($sql, array($codigo))->results();
			}
		}

		public function search($nombre){
			$sql = "SELECT * FROM inventario WHERE nombre_inv = ? ORDER BY nombre_inv ASC";
			return $this->_db->query($sql, array($nombre))->first();

		}
	}
?>