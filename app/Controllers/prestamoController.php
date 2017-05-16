<?php namespace app\Controllers;
	use app\Models\Prestamo;
	use app\includes\Redirect;
	use app\includes\Validate;

	class prestamoController{
		private $_prestamo, $_validate;
		private static $_instance = null;

		public function __construct(){
			if($_SESSION['type'] == 'admin'){
				$this->_prestamo = Prestamo::getInstance();
				$this->_validate = Validate::getInstance();
			}else{
				Redirect::to(403);
			}
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new prestamoController();
			}
			return self::$_instance;
		}

		public function index(){
			return array('alumnos' => $this->_prestamo->listar('alumno'), 'maestros' => $this->_prestamo->listar('maestro'));
		}

		public function material_prestado(){
			return $this->_prestamo->listar_material_prestado();
		}

		public function detalles($solicitante, $codigo, $id){
			$info = $this->_prestamo->getCodigo($solicitante, $codigo);
			$prestamo = $this->_prestamo->listar($solicitante, $id);
			$materiales = $this->_prestamo->listar_material_prestado($solicitante, $id);
			return array('solicitante' => $solicitante, 'info' => $info, 'prestamo' => $prestamo, 'materiales' => $materiales);
		}

		public function recibir_alumno(){
			if($_POST){
				$this->_validate->check($_POST, array(
					'codigo' => array(
						'type' => 'string',
						'required' => true
					)
				));
				if($this->_validate->passed()){
					if($this->_prestamo->getCodigo('alumno',$_POST['codigo'])){
						Redirect::to(URL . 'prestamo/recibir_material/alumno/' . $_POST['codigo']);
					}else{
						return array('codigo' => array('Alumno no encontrado'));
					}
				}else{
					return $this->_validate->errors();
				}
			}
		}

		public function recibir_maestro(){
			if($_POST){
				$this->_validate->check($_POST, array(
					'codigo' => array(
						'type' => 'string',
						'required' => true
					)
				));
				if($this->_validate->passed()){
					if($this->_prestamo->getCodigo('maestro',$_POST['codigo'])){
						Redirect::to(URL . 'prestamo/recibir_material/maestro/' . $_POST['codigo']);
					}else{
						return array('codigo' => array('Maestro no encontrado'));
					}
				}else{
					return $this->_validate->errors();
				}
			}
		}

		public function ver($solicitante, $codigo){
			return array('solicitante' => $solicitante, 'info' => $this->_prestamo->getCodigo($solicitante, $codigo), 'prestamos' => $this->_prestamo->prestamos($solicitante, $codigo));
		}

		public function material_danado(){
			return $this->_prestamo->dañado();
		}

		public function recibir_material($solicitante, $codigo){
			if($this->_prestamo->getCodigo($solicitante,$codigo)){
				return $this->_prestamo->recibir($solicitante, $codigo);
			}else{
				Redirect::to(URL . 'prestamo/solicitar');
			}
		}

		public function solicitar_alumno(){
			if($_POST){
				$this->_validate->check($_POST, array(
					'codigo' => array(
						'type' => 'string',
						'required' => true
					)
				));
				if($this->_validate->passed()){
					if($alumno = $this->_prestamo->getCodigo('alumno', $_POST['codigo'])){
						if(!$alumno['sancion']){
							Redirect::to(URL . 'prestamo/material/alumno/' . $_POST['codigo']);
						}else{
							return array('type' => 'sancion', 'alumno' => $alumno);
						}
					}else{
						return array('type' => 'errors', 'results' => array('codigo' => array('Alumno no encontrado')));
					}
				}else{
					return array('type' => 'errors', 'results' => $this->_validate->errors());
				}
			}
		}

		public function solicitar_maestro(){
			if($_POST){
				$this->_validate->check($_POST, array(
					'codigo' => array(
						'type' => 'string',
						'required' => true
					)
				));
				if($this->_validate->passed()){
					if($alumno = $this->_prestamo->getCodigo('maestro', $_POST['codigo'])){
						if(!$alumno['sancion']){
							Redirect::to(URL . 'prestamo/material/maestro/' . $_POST['codigo']);
						}else{
							return array('type' => 'sancion', 'alumno' => $alumno);
						}
					}else{
						return array('type' => 'errors', 'results' => array('codigo' => array('Maestro no encontrado')));
					}
				}else{
					return array('type' => 'errors', 'results' => $this->_validate->errors());
				}
			}
		}

		public function material($solicitante, $codigo){
			if(!$this->_prestamo->getCodigo($solicitante, $codigo)){
				Redirect::to(URL . 'prestamo/solicitar_' . $solicitante);
			}else{
				if($this->_prestamo->getCodigo($solicitante, $codigo)['sancion']){
					return 'sancion';
				}
			}
		}
	}
?>