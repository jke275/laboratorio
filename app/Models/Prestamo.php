<?php namespace app\Models;
	class Prestamo{
		private static $_instance = null;
		private $_db;

		public function __construct(){
			$this->_db = DB::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new Prestamo();
			}
			return self::$_instance;
		}

		public function listar_material_prestado($solicitante, $id = null){
			if(!$id){
				$sql = "SELECT t1.*, t2.*, t3.nombre_alumno, t3.apellidos_alumno, t4.inventario_codigo_inv, t5.nombre_inv FROM prestamos t1 INNER JOIN prestamo_material t2 INNER JOIN tb_codigo_inventario t4 INNER JOIN alumnos t3 INNER JOIN inventario t5 ON t1.alumnos_codigo_alumno = t3.codigo_alumno AND t1.id_prestamo = t2.prestamos_id_prestamo AND t4.codigo_etiqueta = t2.tb_codigo_inventario_codigo_etiqueta AND t5.codigo_inv = t4.inventario_codigo_inv";
				return $this->_db->query($sql)->results();
			}else{
				if($solicitante == 'alumno'){
					$sql = "SELECT t2.*, t4.inventario_codigo_inv, t5.nombre_inv FROM prestamo_material t2 INNER JOIN tb_codigo_inventario t4 INNER JOIN inventario t5 ON t4.codigo_etiqueta = t2.tb_codigo_inventario_codigo_etiqueta AND t5.codigo_inv = t4.inventario_codigo_inv WHERE prestamos_id_prestamo = ?";
					return $this->_db->query($sql, array($id))->results();
				}else if($solicitante == 'maestro'){
					$sql = "SELECT t2.*, t4.inventario_codigo_inv, t5.nombre_inv FROM prestamo_material_maestro t2 INNER JOIN tb_codigo_inventario t4 INNER JOIN inventario t5 ON t4.codigo_etiqueta = t2.tb_codigo_inventario_codigo_etiqueta AND t5.codigo_inv = t4.inventario_codigo_inv WHERE prestamos_maestro_id_prestamos_maestro = ?";
					return $this->_db->query($sql, array($id))->results();
				}
			}
		}

		public function listar($solicitante, $id = null){
			if(!$id){
				if($solicitante == 'alumno'){
					$sql = "SELECT DISTINCT t1.alumnos_codigo_alumno,t2.nombre_alumno,t2.apellidos_alumno FROM prestamos t1 INNER JOIN alumnos t2 ON t1.alumnos_codigo_alumno = t2.codigo_alumno ORDER BY alumnos_codigo_alumno";
					return $this->_db->query($sql)->results();
				}else if($solicitante == 'maestro'){
					$sql = "SELECT DISTINCT t1.maestros_codigo_maestro,t2.nombre_maestro,t2.apellidos_maestro FROM prestamos_maestro t1 INNER JOIN maestros t2 ON t1.maestros_codigo_maestro = t2.codigo_maestro ORDER BY maestros_codigo_maestro";
					return $this->_db->query($sql)->results();
				}
			}else{
				if($solicitante == 'alumno'){
					$prestamo = $this->_db->query("SELECT t1.*,t2.nombre_usuario,t2.apellidos_usuario FROM prestamos t1 INNER JOIN usuarios t2 ON t1.responsable_prestamo = t2.user WHERE id_prestamo = ? ORDER BY alumnos_codigo_alumno", array($id))->first();
					return array('fecha_prestamo' => $prestamo['fecha_prestamo'], 'fecha_entrega' => $prestamo['fecha_entrega'], 'responsable_prestamo' => $prestamo['responsable_prestamo'], 'objetivo_prestamo' => $prestamo['objetivo_prestamo'], 'responsable' => $prestamo['nombre_usuario'] . ' ' . $prestamo['apellidos_usuario']);
				}else if($solicitante == 'maestro'){
					$prestamo = $this->_db->query("SELECT t1.*,t2.nombre_usuario,t2.apellidos_usuario FROM prestamos_maestro t1 INNER JOIN usuarios t2 ON t1.responsable_prestamo = t2.user WHERE id_prestamos_maestro = ? ORDER BY maestros_codigo_maestro", array($id))->first();
					return array('fecha_prestamo' => $prestamo['fecha_prestamo_maestro'], 'fecha_entrega' => $prestamo['fecha_entrega_maestro'], 'responsable_prestamo' => $prestamo['responsable_prestamo'], 'objetivo_prestamo' => $prestamo['objetivo_prestamo_maestro'], 'responsable' => $prestamo['nombre_usuario'] . ' ' . $prestamo['apellidos_usuario']);
				}
			}
		}

		public function prestamos($solicitante, $codigo){
			if($solicitante == 'alumno'){
				$sql = "SELECT * FROM prestamos WHERE alumnos_codigo_alumno = ?";
				return $this->_db->query($sql, array($codigo))->results();
			}else if($solicitante == 'maestro'){
				$sql = "SELECT * FROM prestamos_maestro WHERE maestros_codigo_maestro = ?";
				return $this->_db->query($sql, array($codigo))->results();
			}
		}

		public function getCodigo($table, $codigo){
			if($table == 'alumno'){
				return $this->_db->query("SELECT * FROM alumnos WHERE codigo_alumno = ? AND activo = true", array($codigo))->first();
			}else if($table == 'maestro'){
				return $this->_db->query("SELECT * FROM maestros WHERE codigo_maestro = ?", array($codigo))->first();
			}
		}

		public function dañado(){
			$sql = "SELECT t1.*,t2.codigo_etiqueta,t3.nombre_inv,t4.codigo_alumno,t4.nombre_alumno,t4.apellidos_alumno FROM material_danado t1 INNER JOIN tb_codigo_inventario t2 INNER JOIN inventario t3 INNER JOIN alumnos t4 ON t1.tb_codigo_inventario_codigo_etiqueta = t2.codigo_etiqueta AND t3.codigo_inv = t2.inventario_codigo_inv AND t4.codigo_alumno = t1.alumnos_codigo_alumno";
			return $this->_db->query($sql)->results();
		}

		public function recibir($solicitante, $codigo){
			if($solicitante == 'alumno'){
				$sql = "SELECT t1.*, t2.* FROM prestamo_material t1 INNER JOIN prestamos t2 ON t1.prestamos_id_prestamo = t2.id_prestamo WHERE t1.recibido = false AND t2.alumnos_codigo_alumno = ?";
				$results = $this->_db->query($sql, array($codigo))->results();
				$alumno = $this->_db->get('alumnos', array('codigo_alumno', '=', $codigo))->first();
				return array('solicitante' => $solicitante, 'info' => $alumno, 'results' => $results);
			}else if($solicitante == 'maestro'){
				$sql = "SELECT t1.*, t2.* FROM prestamo_material_maestro t1 INNER JOIN prestamos_maestro t2 ON t1.prestamos_maestro_id_prestamos_maestro = t2.id_prestamos_maestro WHERE t1.recibido_maestro = false AND t2.maestros_codigo_maestro = ?";
				$results = $this->_db->query($sql, array($codigo))->results();
				$maestro = $this->_db->get('maestros', array('codigo_maestro', '=', $codigo))->first();
				return array('solicitante' => $solicitante, 'info' => $maestro, 'results' => $results);
			}
		}

	}
?>