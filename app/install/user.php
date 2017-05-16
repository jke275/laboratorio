<?php
	require_once '../Models/DB.php';
	require_once '../Core/Config.php';
	use app\Models\DB;
	use app\Core\Config;
	$step = isset( $_GET['step'] ) ? (int) $_GET['step'] : -1;
	function setup_config_display_header() {
		header( 'Content-Type: text/html; charset=utf-8' );
		?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<meta charset="UTF-8">
				<title>Crear Base de Datos y Usuario</title>
				<link rel="stylesheet" type="text/css" href="../../publico/css/bootstrap.min.css">
				<link rel="stylesheet" type="text/css" href="../../publico/css/bootstrap-material-design.min.css">
				<link rel="stylesheet" type="text/css" href="../../publico/css/main.css">
			</head>
			<body>
		<?php
	}
	function pattern($val){
		return (bool)preg_match("/^([\/\p{L}-_ 0-9])+$/ui", $val);
	}
	switch($step){
		case -1:
			setup_config_display_header();
?>
			<div class="container">
				<br/>
				<br/>
				<br/>
				<br/>
				<div class="col-lg-10 col-lg-offset-1">
					<div class="panel panel-default">
						<div class="panel-body">
							<p>A continuación se creara la base de datos con los datos proporcionados en el archivo init.php</p>
							<a class="btn btn-raised" href="user.php?step=1">Continuar</a>
						</div>
					</div>
			</div>
<?php
			break;
		case 1:
			setup_config_display_header();
			if(file_exists('../../init.php')){
				require_once '../../init.php';
				try{
					/*$options = [
					    'cost' => 11,
					];
					$_db = DB::getInstance();*/
					$_db = new PDO('mysql:host=' . Config::get('mysql/host'), Config::get('mysql/user'), Config::get('mysql/password'));

					/*$_db->insert('usuarios', array(
						'user' => 'admin2',
						'nombre_usuario' => 'arturo',
						'apellidos_usuario' => 'garcia',
						'password' => password_hash("admin", PASSWORD_BCRYPT, $options)
					));*/
					$sql = file_get_contents('sql.sql');
					$sql = str_replace('laboratorio', Config::get('mysql/db'), $sql);
		   		$_db->exec($sql);
?>
					<div class="container">
						<br/>
						<br/>
						<br/>
						<br/>
						<div class="col-lg-10 col-lg-offset-1">
							<div class="panel panel-default">
								<div class="panel-body">
									<p>La base de datos fue creada con éxito</p>
									<p>A continuación se creara la cuenta de administrador</p>
									<a class="btn btn-raised" href="user.php?step=2">Continuar</a>
								</div>
							</div>
					</div>
<?php
				}catch(Exception $e){
?>
					<div class="container">
						<br/>
						<br/>
						<br/>
						<br/>
						<div class="col-lg-10 col-lg-offset-1">
							<div class="panel panel-default">
								<div class="panel-body">
									<p>Hubo un error al conectarse a la base de datos, por favor revisa el archivo init.php y vuelvelo a intentar.</p>
									<a class="btn btn-raised" href="user.php?step=1">Reintentar</a>
								</div>
							</div>
					</div>
<?php
				}
			}else{
?>
				<div class="container">
					<br/>
					<br/>
					<br/>
					<br/>
					<div class="col-lg-10 col-lg-offset-1">
						<div class="panel panel-default">
							<div class="panel-body">
								<p>No se encontro el archivo init.php. Es necesario crear el archivo antes de continuar</p>
								<a class="btn btn-raised" href="setup.php">Crear archivo</a>
							</div>
						</div>
				</div>
<?php
			}
			break;
		case 2:
			setup_config_display_header();
?>
			<div class="container">
				<br/>
				<br/>
				<br/>
				<br/>
				<div class="col-lg-10 col-lg-offset-1">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="center-block">Creación de la cuenta de adminstrador</h3>
						</div>
						<div class="panel-body">
							<form action="user.php?step=3" method="POST" class="bs-component">
								<div class="row">
									<div class="col-lg-4">
										<label for="user-admin" class="control-label" style="font-size: 16px;">Usuario Adminstrador</label>
									</div>
									<div class="col-lg-8">
										<input type="text" id="user-admin" name="user-admin" class="form-control" value="">
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<label for="nombre-admin" class="control-label" style="font-size: 16px;">Nombre Adminstrador</label>
									</div>
									<div class="col-lg-8">
										<input type="text" id="nombre-admin" name="nombre-admin" class="form-control" value="">
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<label for="apellidos-admin" class="control-label" style="font-size: 16px;">Apellidos Adminstrador</label>
									</div>
									<div class="col-lg-8">
										<input type="text" id="apellidos-admin" name="apellidos-admin" class="form-control" value="">
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<label for="psw-admin" class="control-label" style="font-size: 16px;">Contraseña Adminstrador</label>
									</div>
									<div class="col-lg-8">
										<input type="password" id="psw-admin" name="psw-admin" class="form-control" value="">
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<label for="repeat-psw-admin" class="control-label" style="font-size: 16px;">Repetir Contraseña Adminstrador</label>
									</div>
									<div class="col-lg-8">
										<input type="password" id="repeat-psw-admin" name="repeat-psw-admin" class="form-control" value="">
									</div>
								</div>
								<button class="btn btn-raised" type="submit">Guardar</button>
							</form>
						</div>
					</div>
			</div>
<?php
			break;
		case 3:
			$empty_elements = array();
			$invalid_char = array();
			$data = array(
				'usuario' => mb_strtolower($_POST['user-admin']),
				'nombre' => mb_strtolower($_POST['nombre-admin']),
				'apellidos' => mb_strtolower($_POST['apellidos-admin']),
				'contraseña' => mb_strtolower($_POST['psw-admin']),
				'repetir contraseña' => $_POST['repeat-psw-admin']
			);
			foreach ($data as $key => $value) {
				if(empty($value)){
					$empty_elements[] = $key;
				}
				if(!($key == 'contraseña' || $key == 'repetir contraseña')){
					if(!pattern($value)){
						$invalid_char[] = $key;
					}
				}
			}
			if($empty_elements){
				setup_config_display_header();
?>
				<div class="container">
					<div class="col-lg-10 col-lg-offset-1">
						<br/>
						<br/>
						<div class="panel panel-default">
							<div class="panel-body">
								Los siguientes datos no fueron ingresados.
								<ul>
<?php
									foreach ($empty_elements as $element) {
										echo '<li>', $element, '</li>';
									}
?>
								</ul>
								Debes Ingresar todos los datos.
								<br>
								<a class="btn btn-raised" href="setup.php?step=1">Intentar de nuevo</a>
							</div>
						</div>
					</div>
				</div>
<?php
				exit;
			}elseif($invalid_char){
				setup_config_display_header();
?>
				<div class="container">
					<div class="col-lg-10 col-lg-offset-1">
						<br/>
						<br/>
						<div class="panel panel-default">
							<div class="panel-body">
								Los siguientes datos tienen caracteres invalidos.
								<ul>
<?php
									foreach ($invalid_char as $element) {
										echo '<li>', $element, '</li>';
									}
?>
								</ul>
								Solo puede contener letras, números, espacios, "/" y "-".
								<br>
								<a class="btn btn-raised" href="setup.php?step=1">Intentar de nuevo</a>
							</div>
						</div>
					</div>
				</div>
<?php
				exit;
			}elseif($data['contraseña'] != $data['repetir contraseña']){
				setup_config_display_header();
?>
				<div class="container">
					<div class="col-lg-10 col-lg-offset-1">
						<br/>
						<br/>
						<div class="panel panel-default">
							<div class="panel-body">
								Las contraseñas ingresadas no coinciden.
								<br>
								<a class="btn btn-raised" href="user.php?step=2">Intentar de nuevo</a>
							</div>
						</div>
					</div>
				</div>
<?php
				exit;
			}else{
				setup_config_display_header();
				try{
					require_once '../../init.php';
					$options = [
					    'cost' => 11,
					];
					$_db = DB::getInstance();
					$_db->insert('usuarios', array(
						'user' => mb_strtolower($data['usuario']),
						'nombre_usuario' => mb_strtolower($data['nombre']),
						'apellidos_usuario' => mb_strtolower($data['apellidos']),
						'password' => password_hash($data["contraseña"], PASSWORD_BCRYPT, $options),
						'privilegios' => 1
					));
?>
					<div class="container">
						<br/>
						<br/>
						<br/>
						<br/>
						<div class="col-lg-10 col-lg-offset-1">
							<div class="panel panel-default">
								<div class="panel-body">
									<p>La cuenta de administrador fue creada con éxito</p>
									<a class="btn btn-raised" href="../../">Continuar</a>
								</div>
							</div>
					</div>
<?php
				}catch(Exception $e){
?>
					<div class="container">
						<br/>
						<br/>
						<br/>
						<br/>
						<div class="col-lg-10 col-lg-offset-1">
							<div class="panel panel-default">
								<div class="panel-body">
									<p>Hubo un error al crear la cuenta, por favor vuelva a intentar. Si el error continua contacte con el administrador del sistema. <?php echo $e->getMessage() ?></p>
									<a class="btn btn-raised" href="user.php?step=2">Reintentar</a>
								</div>
							</div>
					</div>
<?php
				}
			}
			break;
	}

?>