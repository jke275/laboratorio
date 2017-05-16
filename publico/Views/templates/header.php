<?php use app\Core\Config; ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="<?php echo URL ?>publico/css/roboto.css">
    <link rel="stylesheet" href="<?php echo URL ?>publico/css/icon.css"/>
    <link rel="stylesheet" href="<?php echo URL ?>publico/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo URL ?>publico/css/bootstrap-material-design.min.css"/>
    <link rel="stylesheet" href="<?php echo URL ?>publico/css/ripples.min.css"/>
    <link rel="stylesheet" href="<?php echo URL ?>publico/css/bootstrap-material-datetimepicker.css"/>
    <link rel="stylesheet" href="<?php echo URL ?>publico/css/sweet-alert.css"/>
    <link rel="stylesheet" href="<?php echo URL ?>publico/css/main.css"/>
    <script type="text/javascript" src=" <?php echo URL; ?>publico/js/ajax.js"></script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src=" <?php echo URL; ?>publico/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src=" <?php echo URL; ?>publico/js/bootstrap.min.js"></script>
    <script type="text/javascript" src=" <?php echo URL; ?>publico/js/material.min.js"></script>
    <script type="text/javascript" src=" <?php echo URL; ?>publico/js/ripples.min.js"></script>
    <script type="text/javascript" src=" <?php echo URL; ?>publico/js/typeahead.bundle.min.js"></script>
    <script type="text/javascript" src=" <?php echo URL; ?>publico/js/moment-with-locales.min.js"></script>
    <script type="text/javascript" src=" <?php echo URL; ?>publico/js/bootstrap-material-datetimepicker.js"></script>
    <script type="text/javascript" src=" <?php echo URL; ?>publico/js/sweet-alert.min.js"></script>
    <script type="text/javascript" src=" <?php echo URL; ?>publico/js/alert.js"></script>
    <script type="text/javascript" src=" <?php echo URL; ?>publico/js/error.js"></script>
    <script type="text/javascript">
      $.material.init();
      $(function () {
        $('[data-toggle="popover"]').popover();
    })
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
    </script>
    <title>Laboratorio CUNorte</title>
  </head>
  <body>
    <?php if($_SESSION['laboratorio'] == Config::get('mysql/db')){?>
      <nav class="navbar lead">
        <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <i class="material-icons">view_headline</i>
            </button>
            <a href="<?php echo URL; ?>" class="navbar-brand"><i class="large material-icons">home</i></a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse navbar-responsive-collapse " id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Practica<i class="material-icons">expand_more</i></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo URL ?>practica">Listar</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="<?php echo URL ?>practica/solicitar">Solicitar</a></li>
                </ul>
              </li>
              <?php if($_SESSION['type'] == 'admin'){ ?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Prestamos<i class="material-icons">expand_more</i></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo URL ?>prestamo">Listar</a></li>
                    <li role="separator" class="divider"></li>
                     <li><a href="<?php echo URL ?>prestamo/material_prestado">Material Prestado</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo URL ?>prestamo/recibir_alumno">Recibir Alumno</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo URL ?>prestamo/recibir_maestro">Recibir Maestro</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo URL ?>prestamo/solicitar_alumno">Solicitar Alumno</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo URL ?>prestamo/solicitar_maestro">Solicitar Maestro</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo URL ?>prestamo/material_danado">Material Dañado</a></li>
                  </ul>
                </li>
                <?php if($_SESSION['type'] == 'admin' && $_SESSION['privilegios'] == 1){ ?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Instrumentos<i class="material-icons">expand_more</i></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo URL ?>instrumentos">Listar</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo URL ?>instrumentos/agregar">Agregar</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Equipo<i class="material-icons">expand_more</i></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo URL ?>equipo">Listar</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo URL ?>equipo/agregar">Agregar</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mobiliario<i class="material-icons">expand_more</i></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo URL ?>mobiliario">Listar</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo URL ?>mobiliario/agregar">Agregar</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Consumibles<i class="material-icons">expand_more</i></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo URL ?>consumibles">Listar</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo URL ?>consumibles/agregar">Agregar</a></li>
                  </ul>
                </li>
                <?php } ?>
              <?php } ?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo ucfirst($_SESSION['username']) ?><i class="material-icons">expand_more</i></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo URL ?>sesion/salir">Salir</a></li>
                    <?php if($_SESSION['type'] == 'admin'){ ?>
                      <li role="separator" class="divider"></li>
                      <li><a href="<?php echo URL . 'usuario/administrar' ?>">Administrar</a></li>
                      <li role="separator" class="divider"></li>
                      <li><a href="<?php echo URL . 'publico/manual/administrador.php' ?>" target="_blank">Manual de Usuario</a></li>
                    <?php }else{ ?>
                      <li><a href="<?php echo URL . 'publico/manual/maestro.php' ?>" target="_blank">Manual de Usuario</a></li>
                    <?php } ?>
                  </ul>
                </li>
            </ul>
          </div><!-- .navbar-collapse -->
        </div><!-- .container-fluid -->
      </nav>
    <?php } ?>