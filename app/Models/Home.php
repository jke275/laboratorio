<?php namespace app\Models;
	class Home{
		private static $_instance = null;
		private $_db;

		public function __construct(){
			$this->_db = DB::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new Home();
			}
			return self::$_instance;
		}

		public function getPracticasAprobacion($user = null){
			if(!$user){
				$sql = "SELECT t1.id_practica, t1.fecha_practica,t1.hora_practica, t2.nombre_materia, t3.nombre_maestro FROM practica t1 INNER JOIN materia t2 ON t1.materia_id_materia = t2.id_materia INNER JOIN maestros t3 ON t1.maestros_codigo_maestro = t3.codigo_maestro WHERE t1.estado = ?";
				return $this->_db->query($sql, array('pendiente'))->results();
			}else{
				$sql = "SELECT t1.id_practica, t1.fecha_practica,t1.hora_practica, t2.nombre_materia, t3.nombre_maestro FROM practica t1 INNER JOIN materia t2 ON t1.materia_id_materia = t2.id_materia INNER JOIN maestros t3 ON t1.maestros_codigo_maestro = t3.codigo_maestro WHERE t1.estado = ? AND t1.maestros_codigo_maestro = ?";
				return $this->_db->query($sql, array('pendiente', $user))->results();
			}
		}

		public function getPracticasPendientes($user = null){
			if(!$user){
				$sql = "SELECT t1.id_practica, t1.hora_practica, t2.nombre_materia, t3.nombre_maestro FROM practica t1 INNER JOIN materia t2 ON t1.materia_id_materia = t2.id_materia INNER JOIN maestros t3 ON t1.maestros_codigo_maestro = t3.codigo_maestro WHERE t1.estado = ? AND t1.fecha_practica = ?";
				return $this->_db->query($sql, array('aceptada', date('Y-m-d')))->results();
			}else{
				$sql = "SELECT t1.id_practica, t1.hora_practica, t2.nombre_materia, t3.nombre_maestro FROM practica t1 INNER JOIN materia t2 ON t1.materia_id_materia = t2.id_materia INNER JOIN maestros t3 ON t1.maestros_codigo_maestro = t3.codigo_maestro WHERE t1.estado = ? AND t1.fecha_practica = ? AND t1.maestros_codigo_maestro = ?";
				return $this->_db->query($sql, array('aceptada', date('Y-m-d'), $user))->results();
			}
		}

		public function getConsumiblesCaducidad(){
			$caducidad = date('Y-m-d', strtotime(date("Y-m-d") . ' + 7 days'));
			$sql = "SELECT t1.caducidad_consumibles,t2.codigo_inv,t2.nombre_inv FROM consumibles t1 INNER JOIN inventario t2 ON t1.inventario_codigo_inv = t2.codigo_inv WHERE t1.caducidad_consumibles < ?";
			return $this->_db->query($sql, array($caducidad))->results();
		}

		public function getConsumiblesTerminados(){
			$sql = "SELECT codigo_inv,nombre_inv,cantidad_inv FROM inventario WHERE tipo = ? AND cantidad_inv < ?";
			return $this->_db->query($sql, array('consumibles', 10))->results();
		}
	}
?>