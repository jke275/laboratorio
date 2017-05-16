<?php namespace app\Controllers;
	use app\Models\Mobiliario;
	use app\includes\Redirect;
	use app\includes\Validate;

	class mobiliarioController{
		private $_mobiliario, $_validate;
		private static $_instance = null;

		public function __construct(){
			if($_SESSION['type'] == 'admin' && $_SESSION['privilegios'] == 1){
				$this->_mobiliario = Mobiliario::getInstance();
				$this->_validate = Validate::getInstance();
			}else{
				Redirect::to(403);
			}
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new mobiliarioController();
			}
			return self::$_instance;
		}

		public function index(){
			return $this->_mobiliario->listar();
		}

		public function agregar(){
			if($_POST){
				$this->_validate->check($_POST, array(
					'cantidad' => array(
						'min' => 1,
						'type' => 'number',
						'required' => true
					)
				));
				if($this->_validate->passed()){
					Redirect::to(URL . 'mobiliario/agregar2/' . $_POST['cantidad']);
				}else{
					return $this->_validate->errors();
				}
			}
		}

		public function editar_codigo($mobiliario, $codigo){
			$codigo = str_replace('_', ' ', $codigo);
			if($_POST){
				$this->_validate->check($_POST, array(
					'codigo' => array(
						'required' => true,
						'type' => 'string',
						'unique' => true
					)
				), 'tb_codigo_inventario', 'codigo_etiqueta');
				if($this->_validate->passed()){
					$this->_mobiliario->actualizar_codigo($codigo);
					Redirect::to(URL . 'mobiliario/ver/' . $mobiliario);
				}
				else{
					return array('type' => 'error', 'errors' => $this->_validate->errors());
				}
			}else{
				return array('type' => 'codigo', 'results' => $this->_mobiliario->getCodigo($codigo));
			}
		}

		public function agregar2($cantidad){
			$values = array(
				'nombre' => array(
					'required' => true,
					'type' => 'string'
				),
				'caracteristicas' => array(
					'required' => true,
					'type' => 'string'
				)
			);
			for($x = 1; $x<= $cantidad; $x++){
				$values['codigo'.$x] = array(
					'required' => true,
					'type' => 'string',
					'unique' => true
				);
			}

			if($_POST){
				$this->_validate->check($_POST, $values,  'tb_codigo_inventario', 'codigo_etiqueta');
				if($this->_validate->passed()){
					$name = explode(' ', trim($_POST['nombre']));
					$codigo = (count($name) > 1)? $name[0]. '-'. $name[1]. '-'. uniqid() : $name[0]. '-'. uniqid();
					$codigo = mb_strtolower(str_replace('/', '-', $codigo));
					if($_FILES['imagen']['error'] == 0){
						$formatos_admitidos = array("image/jpeg", "image/png", "image/gif", "image/jpg");
						$size = 1000000; //tamaño en bytes
						$imagen = explode('.', $_FILES['imagen']['name']);
						$formato = end($imagen);
						if(in_array($_FILES['imagen']['type'], $formatos_admitidos)){
							if($_FILES['imagen']['size'] >= $size){
								return array('imagen' => array('El archivo excede el tamaño permitido'));
							}else{
								$nombre_imagen = $codigo . '.' . $formato;
								$ruta = ROOT . 'publico' . DS . 'img' . DS . 'inventario' . DS . $nombre_imagen;
								move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
								$this->_mobiliario->add($cantidad, $codigo, $nombre_imagen);
								Redirect::to(URL . 'mobiliario');
							}
						}else{
							return array('imagen' => array('El archivo tiene un formato incorrecto(solo se aceptan jpeg, png, gif y jpg)'));
						}
					}else{
						return array('imagen' => array('Hubo un error al subir el archivo'));
					}
				}else{
					return $this->_validate->errors();
				}
			}
		}

		public function editar($codigo){
			if($_POST){
				$this->_validate->check($_POST, array(
					'nombre' => array(
						'required' => true,
						'type' => 'string'
					),
					'caracteristicas' => array(
						'required' => true,
						'type' => 'string'
					)
				));
				if($this->_validate->passed()){
					$this->_mobiliario->actualizar($codigo);
					Redirect::to(URL . 'mobiliario/ver/' . $codigo);
				}else{
					return $this->_validate->errors();
				}
			}else{
				return $this->_mobiliario->listar($codigo);
			}
		}

		public function ver($codigo){
			if($_POST){
				$this->_mobiliario->more($codigo);
				Redirect::to(URL . 'mobiliario/ver/' . $codigo);
			}else{
				$item = array($this->_mobiliario->listar($codigo), $this->_mobiliario->ver($codigo));
				return $item;
			}
		}

		public function eliminar($material, $codigo){
			$this->_mobiliario->delete($material, $codigo);
			Redirect::to(URL . 'mobiliario/ver/'. $material);
		}

		public function drop($mobiliario){
			$this->_mobiliario->drop($mobiliario);
			Redirect::to(URL . 'mobiliario');
		}
	}
?>