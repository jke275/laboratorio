<?php namespace app\Models;
	use app\Models\DB;
	use app\Models\Session;
	use app\Core\Config;
	class Ajax{

		private static $_instance = null;
		private $_db, $_session;

		private function __construct(){
				$this->_db = DB::getInstance();
				$this->_session = Session::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new Ajax();
			}
			return self::$_instance;
		}

		public function getAllAlumnos($activo){
			return $this->_db->query("SELECT * FROM alumnos WHERE activo = ?", array($activo))->results();
		}

		public function materialDisponible($codigo){
			$sql = "SELECT * FROM tb_codigo_inventario WHERE codigo_etiqueta = ?";
			return $this->_db->query($sql, array($codigo))->first();
		}

		public function eliminarPrestamo($solicitante, $id){
			if($solicitante == 'alumno'){
				$materiales = $this->_db->get('prestamo_material', array('prestamos_id_prestamo', '=', $id))->results();
				foreach ($materiales as $material){
					$codigo = $material['tb_codigo_inventario_codigo_etiqueta'];
					$this->_db->update('tb_codigo_inventario', 'codigo_etiqueta', $codigo, array(
						'estado' => 'disponible'
					));
				}
				$sql = "DELETE FROM prestamos WHERE id_prestamo = ?";
				return $this->_db->query($sql, array($id))->error();
			}else if($solicitante == 'maestro'){
				$materiales = $this->_db->get('prestamo_material_maestro', array('prestamos_maestro_id_prestamos_maestro', '=', $id))->results();
				foreach ($materiales as $material){
					$codigo = $material['tb_codigo_inventario_codigo_etiqueta'];
					$this->_db->update('tb_codigo_inventario', 'codigo_etiqueta', $codigo, array(
						'estado' => 'disponible'
					));
				}
				$sql = "DELETE FROM prestamos_maestro WHERE id_prestamos_maestro = ?";
				return $this->_db->query($sql, array($id))->error();
			}
		}

		public function recibirdanado($codigo, $alumno){
			$sql = "UPDATE material_danado SET repuesto = ? WHERE tb_codigo_inventario_codigo_etiqueta = ? AND alumnos_codigo_alumno = ?";
			$dañado = $this->_db->query($sql, array(1, $codigo, $alumno));
			$etiqueta = $this->_db->update('tb_codigo_inventario', 'codigo_etiqueta', $codigo, array(
				'estado' => 'disponible'
			));
			if($dañado && $etiqueta){
				return true;
			}else{
				return false;
			}
		}

		public function updateImagen($codigo, $nombre_imagen){
			$this->_db->update('inventario', 'codigo_inv', $codigo, array(
				'imagen' => $nombre_imagen
			));
		}

		public function eliminarCodigo($codigo, $materialInv){
			$total = (int)$this->_db->get('inventario', array('codigo_inv', '=', $materialInv))->first()['cantidad_inv'];
			$total -= 1;
			$this->_db->update('inventario', 'codigo_inv', $materialInv, array(
				'cantidad_inv' => $total
			));
			$sql = "DELETE FROM tb_codigo_inventario WHERE codigo_etiqueta = ?  AND inventario_codigo_inv = ?";
			return $this->_db->query($sql, array($codigo, $materialInv));
		}

		public function eliminarPractica($id){
			$sql = "DELETE FROM practica WHERE id_practica = ?";
			$this->_db->delete('practica', array('id_practica', '=', $id));
			return true;
		}

		public function quitar_sancion($codigo){
			return $this->_db->update('alumnos', 'codigo_alumno', $codigo, array(
				'sancion' => NULL
			));
		}

		public function sesion($usuario, $psw){
			return $this->_session->login($usuario, $psw);
		}

		public function sesion_maestro($codigo, $nombre){
			return $this->_session->login_maestro($codigo, $nombre);
		}

		public function aprobarPractica($id){
			return $this->_db->update('practica', 'id_practica', $id, array(
					'estado' => 'aceptada'
				));
		}

		public function dar_baja_alumno($codigo, $estado){
			$this->_db->update('alumnos', 'codigo_alumno', $codigo, array(
				'activo' => $estado
			));
		}

		public function filtrarPracticas($mes){
			$sql = "SELECT t1.*, t2.*, t3.* FROM practica t1 INNER JOIN materia t2 ON t1.materia_id_materia = t2.id_materia INNER JOIN maestros t3 ON t1.maestros_codigo_maestro = t3.codigo_maestro WHERE MONTH(fecha_practica) = ? ORDER BY fecha_practica, hora_practica";
			return $this->_db->query($sql, array($mes))->results();
		}

		public function filtrarIngresos($fecha){
			$sql = "SELECT t1.*,t2.* FROM ingresos t1 INNER JOIN alumnos t2 ON t1.alumnos_codigo_alumno = t2.codigo_alumno WHERE t1.fecha_ingreso = ? ORDER BY fecha_ingreso, hora_ingreso";
			return $this->_db->query($sql, array(date("Y-m-d", strtotime($fecha))))->results();
		}

		public function getElementosPrestamo(){
			$sql = "SELECT t1.*,t2.* FROM tb_codigo_inventario t1 INNER JOIN inventario t2 ON t1.inventario_codigo_inv = t2.codigo_inv WHERE t1.estado = 'disponible'";
			return $this->_db->query($sql)->results();
		}

		public function getAlumno($codigo){
			return $this->_db->query("SELECT * FROM alumnos WHERE codigo_alumno = ? AND activo = true", array($codigo))->first();
		}

		public function getElementosPractica(){
			return $this->_db->query("SELECT nombre_inv FROM inventario")->results();
		}

		public function agregarAlumnos($alumnos){
			foreach ($alumnos as $alumno => $value) {
				$this->_db->insert('alumnos', array(
					'codigo_alumno' => mb_strtolower($alumno),
					'nombre_alumno' => mb_strtolower($value['nombre']),
					'apellidos_alumno' => mb_strtolower($value['apellidos']),
					'carrera' => mb_strtolower($value['carrera'])
				));
			}
		}

		public function agregarMaterias($materias){
			foreach ($materias as $materia => $value) {
				$this->_db->insert('materia', array(
					'id_materia' => mb_strtolower($materia),
					'nombre_materia' => mb_strtolower($value['nombre'])
				));
			}
		}

		public function agregarMaestros($maestros){
			foreach ($maestros as $maestro => $value) {
				$this->_db->insert('maestros', array(
					'codigo_maestro' => mb_strtolower($maestro),
					'nombre_maestro' => mb_strtolower($value['nombre']),
					'apellidos_maestro' => mb_strtolower($value['apellidos'])
				));
			}
		}

		public function agregarMaterial($materiales){
			foreach ($materiales as $material => $value) {
				$name = explode(' ', trim($material));
				$id = (count($name) > 1)? $name[0]. '-'. $name[1]. '-'. uniqid() : $name[0]. '-'. uniqid();
				$id = mb_strtolower($id);
				$this->_db->insert('inventario', array(
					'codigo_inv' => $id,
					'nombre_inv' => $material,
					'cantidad_inv' => count($value['codigos']),
					'tipo' => 'material'
				));
				$this->_db->insert('material', array(
					'carac_material' => $value['caracteristicas'],
					'inventario_codigo_inv' => $id
				));
				foreach ($value['codigos'] as $codigo) {
					$this->_db->insert('tb_codigo_inventario',array(
						'codigo_etiqueta' => mb_strtoupper($codigo),
						'estado' => 'disponible',
						'inventario_codigo_inv' => $id
					));
				}
			}
		}

		public function agregarConsumibles($materiales){
			foreach ($materiales as $material => $value) {
				$this->_db->insert('inventario', array(
					'codigo_inv' => $value['codigo'],
					'nombre_inv' => $material,
					'cantidad_inv' => $value['cantidad'],
					'tipo' => 'consumibles'
				));

				$this->_db->insert('consumibles', array(
					'compra_consumibles' => date("Y-m-d", strtotime($value['compra'])),
					'caducidad_consumibles' => date("Y-m-d", strtotime($value['caducidad'])),
					'carac_consumibles' => $value['caracteristicas'],
					'inventario_codigo_inv' => $value['codigo']
				));
			}
		}

		public function agregarMobiliario($materiales){
			foreach ($materiales as $material => $value) {
				$name = explode(' ', trim($material));
				$id = (count($name) > 1)? $name[0]. '-'. $name[1]. '-'. uniqid() : $name[0]. '-'. uniqid();
				$id = mb_strtolower($id);
				$this->_db->insert('inventario', array(
					'codigo_inv' => $id,
					'nombre_inv' => $material,
					'cantidad_inv' => count($value['codigos']),
					'tipo' => 'mobiliario'
				));
				$this->_db->insert('mobiliario', array(
					'carac_mobiliario' => $value['caracteristicas'],
					'inventario_codigo_inv' => $id
				));
				foreach ($value['codigos'] as $codigo) {
					$this->_db->insert('tb_codigo_inventario',array(
						'codigo_etiqueta' => mb_strtoupper($codigo),
						'estado' => 'disponible',
						'inventario_codigo_inv' => $id
					));
				}
			}
		}

		public function agregarEquipo($materiales){
			foreach ($materiales as $material => $value) {
				$name = explode(' ', trim($value['nombre']));
				$id = (count($name) > 1)? $name[0]. '-'. $name[1]. '-'. uniqid() : $name[0]. '-'. uniqid();
				$id = str_replace('/', '-', $id);
				$id = mb_strtolower($id);
				$this->_db->insert('inventario', array(
					'codigo_inv' => $id,
					'nombre_inv' => $value['nombre'],
					'cantidad_inv' => count($value['codigos']),
					'tipo' => 'equipo'
				));
				$this->_db->insert('equipo', array(
					'marca_equipo' => $value['marca'],
					'modelo_equipo' => $value['modelo'],
					'carac_equipo' => $value['caracteristicas'],
					'inventario_codigo_inv' => $id
				));
				$x = 0;
				foreach ($value['codigos'] as $codigo) {
					$this->_db->insert('tb_codigo_inventario',array(
						'codigo_etiqueta' => mb_strtoupper($codigo),
						'estado' => 'disponible',
						'numero_serie' => $value['no_serie'][$x],
						'inventario_codigo_inv' => $id
					));
					$x++;
				}
			}
		}

		public function get($table, $row, $value){
			return $this->_db->get($table, array($row, '=', $value))->first();
		}

		public function viewPrestamos($form){
			$sql = "SELECT t1.*, t2.*, t3.nombre_alumno, t3.apellidos_alumno, t4.inventario_codigo_inv, t5.nombre_inv FROM prestamos t1 INNER JOIN prestamo_material t2 INNER JOIN tb_codigo_inventario t4 INNER JOIN alumnos t3 INNER JOIN inventario t5 ON t1.alumnos_codigo_alumno = t3.codigo_alumno AND t1.id_prestamo = t2.prestamos_id_prestamo AND t4.codigo_etiqueta = t2.tb_codigo_inventario_codigo_etiqueta AND t5.codigo_inv = t4.inventario_codigo_inv WHERE t2.recibido = ?";
			return $this->_db->query($sql,array($form))->results();
		}

		public function materialPrestamo($elements = array()){
			if($_POST['solicitante'] == 'alumno'){
				$codigos = json_decode($elements['materiales'], true);
				$id = $_POST['codigo'] . '-'. uniqid();
				$this->_db->insert('prestamos', array(
					'id_prestamo' => $id,
					'responsable_prestamo' => $_SESSION['username'],
					'fecha_prestamo' => date('Y-m-d'),
					'fecha_entrega' => date("Y-m-d", strtotime($_POST['fecha-entrega'])),
					'objetivo_prestamo' => $_POST['objetivo'],
					'alumnos_codigo_alumno' => $_POST['codigo']
				));
				for($x = 0; $x < count($codigos); $x++){
					$this->_db->insert('prestamo_material', array(
						'tb_codigo_inventario_codigo_etiqueta' => $codigos[$x],
						'prestamos_id_prestamo' => $id,
						'recibido' => 0
					));
					$this->_db->update('tb_codigo_inventario', 'codigo_etiqueta', $codigos[$x], array(
						'estado' => 'prestado'
					));
				}
				return $id;
			}else if($_POST['solicitante'] == 'maestro'){
				$codigos = json_decode($elements['materiales'], true);
				$id = $_POST['codigo'] . '-'. uniqid();
				$this->_db->insert('prestamos_maestro', array(
					'id_prestamos_maestro' => $id,
					'responsable_prestamo' => $_SESSION['username'],
					'fecha_prestamo_maestro' => date('Y-m-d'),
					'fecha_entrega_maestro' => date("Y-m-d", strtotime($_POST['fecha-entrega'])),
					'objetivo_prestamo_maestro' => $_POST['objetivo'],
					'maestros_codigo_maestro' => $_POST['codigo']
				));
				for($x = 0; $x < count($codigos); $x++){
					$this->_db->insert('prestamo_material_maestro', array(
						'tb_codigo_inventario_codigo_etiqueta' => $codigos[$x],
						'prestamos_maestro_id_prestamos_maestro' => $id,
						'recibido_maestro' => 0
					));
					$this->_db->update('tb_codigo_inventario', 'codigo_etiqueta', $codigos[$x], array(
						'estado' => 'prestado'
					));
				}
				return $id;
			}
		}

		public function materialPractica($id, $materiales = array()){
			foreach ($materiales as $material){
				$this->_db->insert('practica_inventario', array(
					'practica_id_practica' => $id,
					'inventario_codigo_inv' => $material['codigo_inv'],
					'cantidad' => $material['cantidad']
				));
			}
			return true;
		}

		public function recibir($codigo, $id, $estado){
			$sql = "UPDATE prestamo_material SET recibido = 1 WHERE tb_codigo_inventario_codigo_etiqueta = ? AND prestamos_id_prestamo = ?";
			if($this->_db->query($sql, array($codigo, $id))->count() == 1){
				$this->_db->update('tb_codigo_inventario', 'codigo_etiqueta', $codigo, array(
					'estado' => $estado
				));
				return true;
			}else{
				return false;
			}
		}

		public function sancion($alumno,$codigo){
			$sancion = $this->_db->update('alumnos', 'codigo_alumno', $alumno, array(
				'sancion' => date('Y-m-d')
			));
			$dañado = $this->_db->insert('material_danado', array(
				'tb_codigo_inventario_codigo_etiqueta' => $codigo,
				'alumnos_codigo_alumno' => $alumno,
				'fecha_danado' => date('Y-m-d')
			));
			if($sancion && $dañado){
				return true;
			}
		}

		public function view($table){
			$sql = "SELECT t1.*,t2.*,t3.* FROM tb_codigo_inventario t1 INNER JOIN inventario t2 INNER JOIN {$table} t3 on t1.inventario_codigo_inv = t2.codigo_inv AND t1.inventario_codigo_inv = t3.inventario_codigo_inv ORDER BY t1.codigo_etiqueta, t2.nombre_inv";
			return $this->_db->query($sql, array($table))->results();
		}

		public function salir($codigo, $fecha, $hora){
			$sql = "UPDATE ingresos SET hora_salida = ? WHERE fecha_ingreso = ? AND hora_ingreso = ? AND alumnos_codigo_alumno = ?";
			if($this->_db->query($sql, array(date('H:i:s'), $fecha, $hora, $codigo))){
				return true;
			}
		}

		public function checkAvailable($fecha){
			return $this->_db->get('practica', array('fecha_practica', '=', date("Y-m-d", strtotime($fecha))))->results();
		}

		public function checkPracticaHora($fecha, $hora){
			$sql = "SELECT * FROM practica WHERE fecha_practica = ? AND hora_practica = ? AND estado = ?";
			return $this->_db->query($sql, array($fecha, $hora, 'aceptada'))->first();
		}

		public function terminarPractica($id){
			return $this->_db->update('practica', 'id_practica', $id, array('estado' => 'realizada'));
		}

		public function checkIngresoPractica($codigo, $id){
			$sql = "SELECT * FROM ingreso_practica WHERE alumnos_codigo_alumno = ? AND practica_id_practica = ?";
			return $this->_db->query($sql, array($codigo, $id))->first();
		}

		public function checkIngreso($codigo){
			$sql = "SELECT * FROM ingresos WHERE alumnos_codigo_alumno = ? AND hora_salida IS NULL";
			return $this->_db->query($sql, array($codigo))->first();
		}

		public function agregarIngreso($codigo, $fecha, $hora){
				$this->_db->insert('ingresos', array(
					'fecha_ingreso' => $fecha,
					'hora_ingreso' => $hora,
					'alumnos_codigo_alumno' => $codigo
				));
		}

		public function ingresoPractica($codigo, $practica){
			$this->_db->insert('ingreso_practica', array(
				'fecha_ingreso_practica' => date('Y-m-d'),
				'hora_ingreso_practica' => date('H:i:s'),
				'alumnos_codigo_alumno' => $codigo,
				'practica_id_practica' => $practica
			));
		}
	}
?>