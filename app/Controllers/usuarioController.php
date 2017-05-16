<?php namespace app\Controllers;
	use app\Models\Administrar;
	use app\includes\Redirect;
	use app\includes\Validate;
	use app\Core\Config;

	class usuarioController{
		private $_administrar, $_validate;
		private static $_instance = null;
		public function __construct(){
			if($_SESSION['type'] == 'admin'){
				$this->_administrar = Administrar::getInstance();
				$this->_validate = Validate::getInstance();
			}else{
				Redirect::to(403);
			}
		}

		public static function getInstance(){
			if(!isset(self::$_instance)){
				self::$_instance = new usuarioController();
			}
			return self::$_instance;
		}

		public function administrar(){
			if($_POST){
				$this->_validate->check($_POST, array(
					'psw-actual' => array(
						'required' => true
					),
					'psw-nueva' => array(
						'required' => true
					),
					'repetir-psw-nueva' => array(
						'required' => true
					),
				));
				if($this->_validate->passed()){
					$usuario = $this->_administrar->getUsuario();
					if(password_verify($_POST['psw-actual'], $usuario['password'])){
						if($_POST['psw-nueva'] != $_POST['repetir-psw-nueva']){
							return array('repetir-psw-nueva' => array('Las nuevas contraseñas no coinciden'));
						}else{
							if($_POST['psw-nueva'] == $_POST['psw-actual']){
								return array('psw-nueva' => array('Por favor ingresa una contraseña diferente a la actual'));
							}else{
								return !$this->_administrar->updatePassword();
							}
						}
					}else{
						return array('psw-actual' => array('Contraseña Incorrecta'));
					}
				}else{
					return $this->_validate->errors();
				}
			}
		}

		public function manual(){

		}

		public function ingresos(){
			if($_SESSION['type'] == 'admin' && $_SESSION['privilegios'] == 1){
				return $this->_administrar->verIngresos();
			}else{
				Redirect::to(403);
			}
		}

		public function respaldar(){
			if($_SESSION['type'] == 'admin' && $_SESSION['privilegios'] == 1){
				$host = Config::get('mysql/host');
				$user = Config::get('mysql/user');
				$pass = Config::get('mysql/password');
				$name = Config::get('mysql/db');
				$tables=false;
				set_time_limit(3000);
				$mysqli = new \mysqli($host,$user,$pass,$name);
				$mysqli->select_db($name);
				$mysqli->query("SET NAMES 'utf8'");
				$queryTables = $mysqli->query('SHOW TABLES');
				while($row = $queryTables->fetch_row()){
					$target_tables[] = $row[0];
				}
				if($tables !== false){
					$target_tables = array_intersect($target_tables, $tables);
				}
				$content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `".$name."`\r\n--\r\n\r\n\r\n";
				foreach($target_tables as $table){
					if(empty($table)){
						continue;
					}
					$result = $mysqli->query('SELECT * FROM `'.$table.'`');
					$fields_amount=$result->field_count;
					$rows_num=$mysqli->affected_rows;
					$res = $mysqli->query('SHOW CREATE TABLE '.$table);
					$TableMLine=$res->fetch_row();
					$content .= "\n\n".$TableMLine[1].";\n\n";
					for($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter=0){
						while($row = $result->fetch_row()){ //when started (and every after 100 command cycle):
							if($st_counter%100 == 0 || $st_counter == 0 ){
								$content .= "\nINSERT INTO ".$table." VALUES";
							}
							$content .= "\n(";
							for($j=0; $j<$fields_amount; $j++){
								$row[$j] = str_replace("\n","\\n", addslashes($row[$j]) );
								if(isset($row[$j])){
									$content .= '"'.$row[$j].'"' ;
								}else{
									$content .= '""';
								}
								if($j<($fields_amount-1)){
									$content.= ',';
								}
							}
							$content .=")";
		               //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
							if((($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num){
								$content .= ";";
							}else{
								$content .= ",";
							}
							$st_counter=$st_counter+1;
						}
					}
					$content .="\n\n\n";
				}
				$content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
				$backup_name = 'backup-' . Config::get('laboratorio') . '-' . date('d-m-Y');
				ob_get_clean();
				header('Content-Type: application/octet-stream');
				header("Content-Transfer-Encoding: Binary");
				header("Content-disposition: attachment; filename=\"".$backup_name."\"");
				echo $content;
				exit;
			}else{
				Redirect::to(403);
			}
		}

		public function agregar(){
			if($_SESSION['type'] == 'admin' && $_SESSION['privilegios'] == 1){
				if($_POST){
					$this->_validate->check($_POST, array(
						'usuario' => array(
							'type' => 'string',
							'unique' => true,
							'required' => true
						),
						'nombre' => array(
							'type' => 'string',
							'required' => true
						),
						'apellidos' => array(
							'type' => 'string',
							'required' => true
						),
						'psw' => array(
							'required' => true
						),
						'psw2' => array(
							'required' => true
						),
					), 'usuarios', 'user');
					if($this->_validate->passed()){
						if($_POST['psw'] != $_POST['psw2']){
							return array('psw2' => array('Las contraseñas no coinciden'));
						}else{
							return !$this->_administrar->addUser();
							//Redirect::to(URL . 'equipo/agregar2/' . $_POST['cantidad']);
						}
					}else{
						return $this->_validate->errors();
					}
				}
			}else{
				Redirect::to(403);
			}
		}
	}
?>