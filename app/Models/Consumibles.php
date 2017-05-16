<?php namespace app\Models;

	class Consumibles{
		private static $_instance = null;
		private $_db;

		public function __construct(){
			$this->_db = DB::getInstance();
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new Consumibles();
			}
			return self::$_instance;
		}

		public function listar($codigo = null){
			if(!$codigo){
				$sql = "SELECT t1.*,t2.* FROM inventario t1 INNER JOIN consumibles t2 on t1.codigo_inv = t2.inventario_codigo_inv";
				$this->_db->query($sql);
				return $this->_db->results();
			}else{
				$sql = "SELECT t1.*,t2.* FROM inventario t1 INNER JOIN consumibles t2 on t1.codigo_inv = t2.inventario_codigo_inv WHERE t1.codigo_inv = ?";
				$this->_db->query($sql, array($codigo));
				return $this->_db->first();
			}
		}

		public function add(){
			$this->_db->insert('inventario', array(
				'codigo_inv' => mb_strtolower($_POST['codigo_inv']),
				'nombre_inv' => mb_strtolower($_POST['nombre']),
				'cantidad_inv' => $_POST['cantidad'],
				'tipo' => 'consumibles'
			));

			$this->_db->insert('consumibles', array(
				'compra_consumibles' => date("Y-m-d", strtotime($_POST['compra'])),
				'caducidad_consumibles' => date("Y-m-d", strtotime($_POST['caducidad'])),
				'carac_consumibles' => mb_strtolower($_POST['caracteristicas']),
				'inventario_codigo_inv' => $_POST['codigo_inv']
			));
		}

		public function actualizar($codigo){
			$this->_db->update('inventario', 'codigo_inv', $codigo, array(
				'codigo_inv' => mb_strtolower($_POST['codigo_inv']),
				'nombre_inv' => mb_strtolower($_POST['nombre']),
				'cantidad_inv' => $_POST['cantidad']
			));
			$this->_db->update('consumibles', 'inventario_codigo_inv', $codigo, array(
				'compra_consumibles' => $_POST['compra'],
				'caducidad_consumibles' => $_POST['caducidad'],
				'carac_consumibles' => mb_strtolower($_POST['caracteristicas'])
			));
		}

		public function drop($consumibles){
			$sql = "DELETE FROM consumibles WHERE inventario_codigo_inv = ?";
			$this->_db->query($sql, array($consumibles));
			$sql2 = "DELETE FROM inventario WHERE codigo_inv = ?";
			$this->_db->query($sql2, array($consumibles));
		}
	}

?>