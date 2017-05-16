<?php
	$step = isset( $_GET['step'] ) ? (int) $_GET['step'] : -1;
	$errors = array();
	$require_php_version = '5.5.0';
	$require_apache_version = '2.4.18';
	$require_mysql_version = '5.0.12';
	$found_php_version = phpversion();
	$ver = explode('/', apache_get_version());
	$ver = explode(' ', $ver[1]);
	$found_apache_version = $ver[0];
	$found_mysql_version = mysqli_get_client_version();
	$php_version = version_compare($found_php_version, $require_php_version, '>=');
	$apache_version = version_compare($found_apache_version, '2.4.18', '>=');
	$mysql_version = version_compare($found_mysql_version, $require_mysql_version, '>=');
	$modulo_rewrite = in_array('mod_rewrite', apache_get_modules());
	$funcion_utf8 = function_exists('utf8_encode');

	$initFile = '../../init.php';
	function setup_config_display_header() {
		header( 'Content-Type: text/html; charset=utf-8' );
		?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<meta charset="UTF-8">
				<title>Crear archivo de configuración</title>
				<link rel="stylesheet" type="text/css" href="../../publico/css/bootstrap.min.css">
				<link rel="stylesheet" type="text/css" href="../../publico/css/bootstrap-material-design.min.css">
				<link rel="stylesheet" type="text/css" href="../../publico/css/icon.css">
				<link rel="stylesheet" type="text/css" href="../../publico/css/roboto.css">
				<link rel="stylesheet" type="text/css" href="../../publico/css/main.css">
			</head>
			<body>
		<?php
	}
	if(file_exists($initFile)){
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
							<p>El archivo init.php ya existe, elimine el archivo si desea volver a realizar la instalación.</p>
							<a class="btn btn-raised" href="../../">Continuar</a>
						</div>
					</div>
			</div>
<?php
		die;
	}

	function pattern($val){
		return (bool)preg_match("/^([\/\p{L}-_ 0-9])+$/ui", $val);
	}

?>
<?php
	switch ($step) {
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
							<p>Requerimientos necesarios para el funcionamiento del sistema.</p>
								<p class="<?php echo ($php_version) ? 'text-success' : 'text-danger' ?>"><i class="material-icons"><?php echo ($php_version) ? 'done' : 'clear' ?></i><strong>Versión de PHP.</strong></p>
									<ul>
										<li>Versión Requerida: <?php echo $require_php_version ?></li>
										<li>Versión Encontrada: <?php echo explode('-', $found_php_version)[0] ?></li>
									</ul>
								<p class="<?php echo ($apache_version) ? 'text-success' : 'text-danger' ?>"><i class="material-icons"><?php echo ($apache_version) ? 'done' : 'clear' ?></i><strong>Versión de Apache.</strong></p>
									<ul>
										<li>Versión Requerida: <?php echo $require_apache_version ?></li>
										<li>Versión Encontrada: <?php echo $found_apache_version ?></li>
									</ul>
								<p class="<?php echo ($mysql_version) ? 'text-success' : 'text-danger' ?>"><i class="material-icons"><?php echo ($mysql_version) ? 'done' : 'clear' ?></i><strong>Versión de MYSQL.</strong></p>
									<ul>
										<li>Versión Requerida: <?php echo $require_mysql_version ?></li>
										<li>Versión Encontrada: <?php echo $found_mysql_version ?></li>
									</ul>
								<p class="<?php echo ($modulo_rewrite) ? 'text-success' : 'text-danger' ?>"><i class="material-icons"><?php echo ($modulo_rewrite) ? 'done' : 'clear' ?></i><strong>Modulo mod_rewrite.</strong></p>
								<p class="<?php echo ($funcion_utf8) ? 'text-success' : 'text-danger' ?>"><i class="material-icons"><?php echo ($funcion_utf8) ? 'done' : 'clear' ?></i><strong>Función utf_encode.</strong></p>
							<p>Si uno o mas de los requrimentos no se cumplen el sistema no funcionara correctamente, por lo que debera corregir los problemas y volver a intentar.</p>
							<?php if($php_version && $apache_version && $mysql_version && $modulo_rewrite && $funcion_utf8){ ?>
								<a class="btn btn-raised" href="setup.php?step=1">Continuar</a>
							<?php } ?>
						</div>
					</div>
			</div>
<?php
			break;
		case 1:
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
							<p>Antes de comenzar, se necesita información sobre la base de datos. Necesitaras saber lo siguiente antes de continuar.</p>
							<ul>
								<li>Dirección Ip/URL.</li>
								<li>Host De la Base de Datos.</li>
								<li>Usuario de la Base de Datos.</li>
								<li>Contraseña de la Base de Datos.</li>
								<li>Nombre de la Base de Datos.</li>
								<li>Nombre del Laboratorio.</li>
							</ul>
							<p></p>
							<p>Se va usar esta información para crear un archivo init.php. Si la creación automática de este archivo falla, solo abre el archivo init-example.php, ingresa la información y guardalo como init.php.</p>
							<p><strong>*La base de datos debe de estar creada (collation utf8_general_ci)<br>
								*El usuario debe tener privilegios para crear y eliminar tablas. Si se desea el usuario puede cambiarse editando el archivo init.php</strong></p>
							<a class="btn btn-raised" href="setup.php?step=2">Continuar</a>
						</div>
					</div>
			</div>
<?php
			break;
		case 2:
			setup_config_display_header();
?>
			<div class="container">
				<div class="col-lg-10 col-lg-offset-1">
					<br/>
					<br/>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="text-center">Por favor ingresa la información para la creación del archivo init.php</h3>
						</div>
						<div class="panel-body">
							<form action="setup.php?step=3" method="POST" class="bs-component">
								<div class="row input">
									<div class="col-lg-4">
										<span class="big-font">Dirección IP(URL)</span>
									</div>
									<div class="col-lg-8">
										<input type="text" id="ip" name="ip" class="form-control" value="<?php echo $_POST['ip'] ?>">
									</div>
								</div>
								<div class="row input">
									<div class="col-lg-4">
										<span class="big-font">Host de la Base de datos</span>
									</div>
									<div class="col-lg-8">
										<input type="text" id="host" name="host" class="form-control" value="<?php echo $_POST['host'] ?>">
									</div>
								</div>
								<div class="row input">
									<div class="col-lg-4">
										<span class="big-font">Nombre de la Base de Datos</span>
									</div>
									<div class="col-lg-8">
										<input type="text" id="nombre-bd" name="nombre-bd" class="form-control" value="<?php echo $_POST['nombre-bd'] ?>">
									</div>
								</div>
								<div class="row input">
									<div class="col-lg-4">
										<span class="big-font">Usuario de la Base de Datos</span>
									</div>
									<div class="col-lg-8">
										<input type="text" id="usuario-bd" name="usuario-bd" class="form-control" value="<?php echo $_POST['usuario-bd'] ?>">
									</div>
								</div>
								<div class="row input">
									<div class="col-lg-4">
										<span class="big-font">Contraseña de la Base de Datos</span>
									</div>
									<div class="col-lg-8">
										<input type="password" id="psw-bd" name="psw-bd" class="form-control" value="<?php echo $_POST['psw-bd'] ?>">
									</div>
								</div>
								<div class="row input">
									<div class="col-lg-4">
										<span class="big-font">Nombre del laboratorio</span>
									</div>
									<div class="col-lg-8">
										<input type="text" id="nombre-lab" name="nombre-lab" class="form-control" value="<?php echo $_POST['nombre-lab'] ?>">
									</div>
								</div>
								<button class="btn btn-raised" type="submit">Guardar</button>
							</form>
						</div>
					</div>
				</div>
			</div>
<?php
			break;
		case 3:
			$empty_elements = array();
			$invalid_char = array();
			$data = array(
				'ip' => mb_strtolower($_POST['ip']),
				'host' => mb_strtolower($_POST['host']),
				'nombre de la base de datos' => mb_strtolower($_POST['nombre-bd']),
				'usuario de la base de datos' => mb_strtolower($_POST['usuario-bd']),
				'contraseña de la base de datos' => $_POST['psw-bd'],
				'nombre del laboratorio' => mb_strtolower($_POST['nombre-lab']),
			);
			foreach ($data as $key => $value) {
				if(empty($value)){
					$empty_elements[] = $key;
				}
				if(!pattern($value)){
					$invalid_char[] = $key;
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
								<a class="btn btn-raised" href="setup.php?step=2">Intentar de nuevo</a>
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
								<a class="btn btn-raised" href="setup.php?step=2">Intentar de nuevo</a>
							</div>
						</div>
					</div>
				</div>
<?php
				exit;
			}else{
				$error = false;
				if($file = fopen($initFile,'w')){
					$file_content = 	'<?php
	session_start();
	define(\'DS\', DIRECTORY_SEPARATOR);
	define(\'ROOT\', __DIR__ . DS);
	define(\'URL\', \'http://' . $data['ip'] . '/\');

	$GLOBALS[\'config\'] = array(
		\'mysql\' => array(
			\'host\' => \'' . $data['host'] . '\',
			\'user\' => \'' . $data['usuario de la base de datos'] . '\',
			\'password\' => \'' . $data['contraseña de la base de datos'] . '\',
			\'db\' => \'' . $data['nombre de la base de datos'] . '\'
		),
		\'laboratorio\' => \'' . $data['nombre del laboratorio'] . '\'
	);
?>';
					fwrite($file, $file_content);
					fclose($file);
				}else{
					$error = true;
				}

				if(!$error){
					$message = 'El archivo init.php se creo correctamente.';
				}else{
					$message = 'El archivo init.php no se pudo crear. Tendrá que crearlo manualmente o volver a ejecutar el asistente';
				}
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
								<p><?php echo $message ?></p>
								<a class="btn btn-raised" href="user.php">Continuar</a>
							</div>
						</div>
				</div>
<?php
			}
			break;
	}
?>

	</body>
</html>

