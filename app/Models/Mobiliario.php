<?php namespace app\Models;

	class Mobiliario{
		private static $_instance = null;
		private $_db;

		public function __construct(){
			$this->_db = DB::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new Mobiliario();
			}
			return self::$_instance;
		}

		public function listar($codigo = null){
			if(!$codigo){
				$sql = "SELECT t1.*,t2.* FROM inventario t1 INNER JOIN mobiliario t2 on t1.codigo_inv = t2.inventario_codigo_inv";
				$this->_db->query($sql);
				return $this->_db->results();
			}else{
				$sql = "SELECT t1.*,t2.* FROM inventario t1 INNER JOIN mobiliario t2 on t1.codigo_inv = t2.inventario_codigo_inv WHERE t1.codigo_inv = ?";
				$this->_db->query($sql, array($codigo));
				return $this->_db->first();
			}
		}

		public function getCodigo($codigo){
			return $this->_db->get('tb_codigo_inventario', array('codigo_etiqueta', '=', $codigo))->first();
		}

		public function actualizar_codigo($codigo){
			$this->_db->update('tb_codigo_inventario', 'codigo_etiqueta', $codigo, array(
				'codigo_etiqueta' => $_POST['codigo']
			));
		}

		public function more($codigo){
			$cantidad = (int)$this->_db->get('inventario', array('codigo_inv', '=', $codigo))->first()['cantidad_inv'];
			$nuevaCantidad = $cantidad + count($_POST);
			for($x = 1; $x <= (count($_POST)); $x++){
				$this->_db->insert('tb_codigo_inventario', array(
					'codigo_etiqueta' => mb_strtolower($_POST['codigo' . $x]),
					'estado' => 'disponible',
					'inventario_codigo_inv' => $codigo
				));
			}
			$this->_db->update('inventario', 'codigo_inv', $codigo, array(
				'cantidad_inv' => $nuevaCantidad
			));
		}

		public function add($cantidad, $codigo, $nombre_imagen){
			$this->_db->insert('inventario', array(
				'codigo_inv' => $codigo,
				'nombre_inv' => mb_strtolower($_POST['nombre']),
				'cantidad_inv' => $cantidad,
				'tipo' => 'mobiliario',
				'imagen' => $nombre_imagen
			));

			$this->_db->insert('mobiliario', array(
				'carac_mobiliario' => mb_strtolower($_POST['caracteristicas']),
				'inventario_codigo_inv' => $codigo
			));

			for($x = 1; $x <= $cantidad; $x++){
				$this->_db->insert('tb_codigo_inventario', array(
					'codigo_etiqueta' => mb_strtolower($_POST['codigo' . $x]),
					'estado' => 'disponible',
					'inventario_codigo_inv' => $codigo
				));
			}
		}

		public function actualizar($codigo){
			$this->_db->update('inventario', 'codigo_inv', $codigo, array(
				'nombre_inv' => mb_strtolower($_POST['nombre'])
			));
			$this->_db->update('mobiliario', 'inventario_codigo_inv', $codigo, array(
				'carac_mobiliario' => mb_strtolower($_POST['caracteristicas'])
			));
		}

		public function ver($codigo){
			$this->_db->get('tb_codigo_inventario', array('inventario_codigo_inv', '=', $codigo));
			return $this->_db->results();
		}

		public function delete($mobiliario, $codigo){
			$sql = "DELETE FROM tb_codigo_inventario WHERE codigo_etiqueta = ?  AND inventario_codigo_inv = ?";
			$this->_db->query($sql, array($codigo, $mobiliario));
			$this->substract($mobiliario, 1);
		}

		public function drop($mobiliario){
			$codes = '';
			$results = $this->_db->get('tb_codigo_inventario', array('inventario_codigo_inv', '=', $mobiliario))->results();
			$x = 1;
			foreach($results as $result){
				$sql = "DELETE FROM tb_codigo_inventario WHERE codigo_etiqueta = ? AND inventario_codigo_inv = ?";
				$this->_db->query($sql, array($result['codigo_etiqueta'], $mobiliario));
			}
			$sql2 = "DELETE FROM mobiliario WHERE inventario_codigo_inv = ?";
			$this->_db->query($sql2, array($mobiliario));
			$sql3 = "DELETE FROM inventario WHERE codigo_inv = ?";
			$this->_db->query($sql3, array($mobiliario));
		}

		private function substract($mobiliario, $cant){
			$total = (int)$this->_db->get('inventario', array('codigo_inv', '=', $mobiliario))->first()['cantidad_inv'];
			$total -= $cant;
			$this->_db->update('inventario', 'codigo_inv', $mobiliario, array(
				'cantidad_inv' => $total
			));
		}
	}

?>