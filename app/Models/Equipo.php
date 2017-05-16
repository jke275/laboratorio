<?php namespace app\Models;
	use app\includes\Redirect;

	class Equipo{
		private static $_instance = null;
		private $_db;

		public function __construct(){
			$this->_db = DB::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new Equipo();
			}
			return self::$_instance;
		}

		public function getCodigo($codigo){
			return $this->_db->get('tb_codigo_inventario', array('codigo_etiqueta', '=', $codigo))->first();
		}

		public function detalles($codigo){
			$sql = "SELECT t1.*,t2.*,t3.numero_serie FROM inventario t1 INNER JOIN equipo t2 on t1.codigo_inv = t2.inventario_codigo_inv INNER JOIN tb_codigo_inventario t3 on t1.codigo_inv = t3.inventario_codigo_inv WHERE t1.codigo_inv = ?";
				return $this->_db->query($sql, array($codigo))->first();
		}

		public function listar($codigo = null){
			if(!$codigo){
				$sql = "SELECT t1.*,t2.* FROM inventario t1 INNER JOIN equipo t2 on t1.codigo_inv = t2.inventario_codigo_inv ORDER BY t1.nombre_inv ASC";
				$this->_db->query($sql);
				return $this->_db->results();
			}else{
				$sql = "SELECT t1.*,t2.* FROM inventario t1 INNER JOIN equipo t2 on t1.codigo_inv = t2.inventario_codigo_inv WHERE t1.codigo_inv = ?";
				$this->_db->query($sql, array($codigo));
				return $this->_db->first();
			}
		}

		public function actualizar_codigo($codigo){
			$this->_db->update('tb_codigo_inventario', 'codigo_etiqueta', $codigo, array(
				'codigo_etiqueta' => $_POST['codigo'],
				'numero_serie' => $_POST['serie']
			));
		}

		public function add($cantidad, $id, $nombre_imagen){
			$this->_db->insert('inventario', array(
				'codigo_inv' => $id,
				'nombre_inv' => mb_strtolower($_POST['nombre']),
				'cantidad_inv' => $cantidad,
				'tipo' => 'equipo',
				'imagen' => $nombre_imagen
			));

			$this->_db->insert('equipo', array(
				'marca_equipo' => mb_strtolower($_POST['marca']),
				'modelo_equipo' => mb_strtolower($_POST['modelo']),
				'carac_equipo' => mb_strtolower($_POST['caracteristicas']),
				'inventario_codigo_inv' => $id
			));

			for($x = 1; $x <= $cantidad; $x++){
				$this->_db->insert('tb_codigo_inventario', array(
					'codigo_etiqueta' => mb_strtolower($_POST['codigo' . $x]),
					'estado' => 'disponible',
					'numero_serie' =>  $_POST['serie' . $x],
					'inventario_codigo_inv' => $id
				));
			}
		}

		public function actualizar($codigo){
			$this->_db->update('inventario', 'codigo_inv', $codigo, array(
				'nombre_inv' => mb_strtolower($_POST['nombre']),
			));
			$this->_db->update('equipo', 'inventario_codigo_inv', $codigo, array(
				'marca_equipo' => mb_strtolower($_POST['marca']),
				'modelo_equipo' => mb_strtolower($_POST['modelo']),
				'carac_equipo' => mb_strtolower($_POST['caracteristicas'])
			));
		}

		public function ver($codigo){
			$this->_db->get('tb_codigo_inventario', array('inventario_codigo_inv', '=', $codigo));
			return $this->_db->results();

		}

		public function delete($equipo, $codigo){
			$sql = "DELETE FROM tb_codigo_inventario WHERE codigo_etiqueta = ?  AND inventario_codigo_inv = ?";
			$this->_db->query($sql, array($codigo, $equipo));
			$this->substract($equipo, 1);
		}

		public function drop($equipo){
			$codes = '';
			$results = $this->_db->get('tb_codigo_inventario', array('inventario_codigo_inv', '=', $equipo))->results();
			$x = 1;
			foreach($results as $result){
				$sql = "DELETE FROM tb_codigo_inventario WHERE codigo_etiqueta = ? AND inventario_codigo_inv = ?";
				$this->_db->query($sql, array($result['codigo_etiqueta'], $equipo));
			}
			$sql2 = "DELETE FROM equipo WHERE inventario_codigo_inv = ?";
			$this->_db->query($sql2, array($equipo));
			$sql3 = "DELETE FROM inventario WHERE codigo_inv = ?";
			$this->_db->query($sql3, array($equipo));
		}

		public function more($codigo){
			$cantidad = (int)$this->_db->get('inventario', array('codigo_inv', '=', $codigo))->first()['cantidad_inv'];
			$nuevaCantidad = $cantidad + count($_POST)/2;
			for($x = 1; $x <= (count($_POST)/2); $x++){
				$this->_db->insert('tb_codigo_inventario', array(
					'codigo_etiqueta' => mb_strtoupper($_POST['codigo' . $x]),
					'estado' => 'disponible',
					'numero_serie' =>  $_POST['serie' . $x],
					'inventario_codigo_inv' => $codigo
				));
			}
			$this->_db->update('inventario', 'codigo_inv', $codigo, array(
				'cantidad_inv' => $nuevaCantidad
			));
		}

		private function substract($equipo, $cant){
			$total = (int)$this->_db->get('inventario', array('codigo_inv', '=', $equipo))->first()['cantidad_inv'];
			$total -= $cant;
			$this->_db->update('inventario', 'codigo_inv', $equipo, array(
				'cantidad_inv' => $total
			));
		}
	}

?>