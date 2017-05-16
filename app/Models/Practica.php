<?php namespace app\Models;

	class Practica{
		private $_db;
		private static $_instance = null;

		public function __construct(){
			$this->_db = DB::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new Practica();
			}
			return self::$_instance;
		}

		public function getIngresos($id){
			return $this->_db->query("SELECT t1.*, t2.codigo_alumno, t2.nombre_alumno, t2.apellidos_alumno FROM ingreso_practica t1 INNER JOIN alumnos t2 ON t1.alumnos_codigo_alumno = t2.codigo_alumno WHERE t1.practica_id_practica = ?", array($id))->results();
		}

		public function detalles($id){
			$sql = "SELECT t1.*,t2.*,t3.* FROM practica t1 INNER JOIN materia t2 ON t1.materia_id_materia = t2.id_materia INNER JOIN maestros t3 ON t1.maestros_codigo_maestro = t3.codigo_maestro WHERE t1.id_practica = ?";
			$practica = $this->_db->query($sql, array($id))->first();
			$sql2 = "SELECT t1.*, t2.* FROM ingreso_practica t1 INNER JOIN alumnos t2 ON t1.alumnos_codigo_alumno = t2.codigo_alumno WHERE t1.practica_id_practica = ?";
			$alumnos = $this->_db->query($sql2, array($id))->results();
			return array($practica, $alumnos);
		}

		public function detallesMateriales($id){
			$sql = "SELECT t1.nombre_inv, t2.cantidad FROM inventario t1 INNER JOIN practica_inventario t2 ON t1.codigo_inv = t2.inventario_codigo_inv WHERE t2.practica_id_practica = ?";
			return $this->_db->query($sql, array($id))->results();
		}

		public function listar($user = null){
			if(!$user){
				$sql = "SELECT t1.*, t2.*, t3.* FROM practica t1 INNER JOIN materia t2 ON t1.materia_id_materia = t2.id_materia INNER JOIN maestros t3 ON t1.maestros_codigo_maestro = t3.codigo_maestro ORDER BY fecha_practica, hora_practica";
				return $this->_db->query($sql)->results();
			}else{
				$sql = "SELECT t1.*, t2.* FROM practica t1 INNER JOIN materia t2 ON t1.materia_id_materia = t2.id_materia WHERE t1.maestros_codigo_maestro = ?";
				return $this->_db->query($sql, array($user))->results();
			}
		}

		public function ver($id){
			$sql = "SELECT t1.*, t2.*, t3.* FROM practica t1 INNER JOIN materia t2 ON t1.materia_id_materia = t2.id_materia INNER JOIN maestros t3 ON t1.maestros_codigo_maestro = t3.codigo_maestro WHERE id_practica = ? ORDER BY fecha_practica, hora_practica";
			return $this->_db->query($sql, array($id))->first();
		}

		public function get($column, $value){
			return $this->_db->get('practica', array($column, '=', $value))->first();
		}

		public function add($id){
			$duracion = '0' . $_POST['duracion_horas'] . ':' . $_POST['duracion_minutos'];
			$this->_db->insert('practica', array(
				'id_practica' => mb_strtolower($id),
				'nombre_practica' => mb_strtolower($_POST['nombre_practica']),
				'numero_alumnos_practica' => $_POST['cantidad_alumnos'],
				'fecha_practica' => date("Y-m-d", strtotime($_POST['fecha'])),
				'hora_practica' => $_POST['hora'],
				'estado' => ($_SESSION['type'] == 'admin') ? 'aceptada' : 'pendiente',
				'duracion_practica' => $duracion,
				'usuario_solicitante' => $_SESSION['username'],
				'materia_id_materia' => $_POST['materia_practica'],
				'maestros_codigo_maestro' => ($_SESSION['type'] == 'admin') ? $_POST['maestro_practica'] : $_SESSION['username']
			));
		}

		public function checkAvailable($date){
			return $this->_db->get('practica', array('fecha_practica', '=', $date))->results();
		}
	}
?>