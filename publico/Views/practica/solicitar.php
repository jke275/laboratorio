<?php
  use app\Models\DB;
  $_db = DB::getInstance();
  $maestros = $_db->query("SELECT * FROM maestros")->results();
  $materias = $_db->query("SELECT * FROM materia ORDER BY nombre_materia ASC")->results();
?>
<div class="container">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<form action="" method="POST" class="bs-component" id='practica'>
				<div class="form-group col-lg-4 form-group-lg" id="fecha-input">
					<label for="fecha" class="control-label">Fecha</label>
					<input type="text" id="fecha" name="fecha" class="form-control date" value="<?php echo $_POST['fecha'] ?>">
				</div>
				<div class="form-group col-lg-4 form-group-lg" id="hora-input">
               <label for="hora" class="control-label">Hora</label>
               <input type="text" id="hora" name="hora" class="form-control time" value="<?php echo $_POST['hora'] ?>">
            </div>
            <div class="form-group col-lg-2 form-group-lg" id="duracion_horas-input">
               <label class="control-label">Duración</label>
                  <select name="duracion_horas" id="duracion_horas" class="form-control">
                     <option selected="" disabled="">Horas</option>
                     <option <?php if ($_POST['duracion_horas'] == '1') { ?>selected="true" <?php }; ?> value="1">1</option>
                     <option <?php if ($_POST['duracion_horas'] == '2') { ?>selected="true" <?php }; ?> value="2">2</option>
                     <option <?php if ($_POST['duracion_horas'] == '3') { ?>selected="true" <?php }; ?> value="3">3</option>
                     <option <?php if ($_POST['duracion_horas'] == '4') { ?>selected="true" <?php }; ?> value="4">4</option>
                     <option <?php if ($_POST['duracion_horas'] == '5') { ?>selected="true" <?php }; ?> value="5">5</option>
                     <option <?php if ($_POST['duracion_horas'] == '6') { ?>selected="true" <?php }; ?> value="6">6</option>
                     <option <?php if ($_POST['duracion_horas'] == '7') { ?>selected="true" <?php }; ?> value="7">7</option>
                     <option <?php if ($_POST['duracion_horas'] == '8') { ?>selected="true" <?php }; ?> value="8">8</option>
                  </select>
            </div>
            <div class="form-group col-lg-2 form-group-lg" id="duracion_minutos-input">
               <label class="control-label"> j</label>
                  <select name="duracion_minutos" id="duracion_minutos" class="form-control">
                     <option selected="" disabled="">Minutos</option>
                     <option <?php if ($_POST['duracion_minutos'] == '00') { ?>selected="true" <?php }; ?> value="00">00</option>
                     <option <?php if ($_POST['duracion_minutos'] == '30') { ?>selected="true" <?php }; ?> value="30">30</option>
                  </select>
						<!--<input type="string" id="duracion" name="duracion" class="form-control" value="<?php //echo $_POST['duracion'] ?>">-->
            </div>
				<div class="row" id="button">
					<div class="col-lg-4 col-lg-offset-4">
						<br>
						<button type="button" class="btn btn-raised btn-primary" onclick="ajax_json_data()">Revisar Disponibilidad</button>
					</div>
            </div>
         </form>
      </div>
   </div>
</div>





<script type="text/javascript">
	$(document).ready(function(){
		$('.date').bootstrapMaterialDatePicker({
      time: false,
      clearButton: true,
      format: 'DD-MM-YYYY',
      nowButton: true,
      cancelText: 'Cancelar',
      okText: 'Aceptar',
      clearText: 'Limpiar',
      nowText: "Hoy",
      lang: 'es',
      switchOnClick: true
    });
    $('.time').bootstrapMaterialDatePicker({
    	date: false,
			shortTime: false,
			format: 'HH:mm',
			clearButton: true,
			clearText: 'Limpiar',
			cancelText: 'Cancelar',
      okText: 'Aceptar',
    });

	});

	var template2 = '<div class="form-group col-lg-12 form-group-lg" id="nombre_practica-input">' +
                    '<label for="nombre_practica" class="control-label">Nombre de la practica</label>' +
                    '<input type="text" id="nombre_practica" name="nombre_practica" class="form-control" value="' + <?php echo ($_POST['nombre_practica']) ? json_encode($_POST['nombre_practica']) : json_encode(''); ?> + '">' +
                  '</div>' +
                  '<div class="form-group col-lg-12 form-group-lg" id="cantidad_alumnos-input">' +
                    '<label for="cantidad_alumnos" class="control-label">Cantidad de alumnos</label>' +
                    '<input type="number" id="cantidad_alumnos" name="cantidad_alumnos" class="form-control" value="' + <?php echo ($_POST['cantidad_alumnos']) ? json_encode($_POST['cantidad_alumnos']) : json_encode(''); ?> + '">' +
                  '</div>' +
                  '<div class="form-group col-lg-12 form-group-lg" id="materia_practica-input">' +
                    '<label for="materia_practica" class="control-label">Materia</label>' +
                    '<select name="materia_practica" id="materia_practica" class="form-control" value="">' +
                      '<option value="" selected>------------------------</option>' +
                     <?php
                        $option_materia = '';
                        foreach ($materias as $materia) {
                           $option_materia .= '<option value="' . $materia['id_materia'] . '"';
                           if($_POST['materia_practica']){
                              $option_materia .= 'selected = "selected" ';
                           }
                           $option_materia .=  '>' . ucfirst($materia['nombre_materia']) . '</option>';
                        }
                        echo json_encode($option_materia);
                     ?>
                     + '</select>' +
                  '</div>' +
                    <?php
                      if($_SESSION['type'] == 'admin'){
                        $select_maestros = '<div class="form-group col-lg-12 form-group-lg" id="maestro_practica-input"><label for="maestro_practica" class="control-label">Maestro que solicita</label><select name="maestro_practica" id="maestro_practica" class="form-control" value=""><option value="" selected>------------------------</option>';
                        foreach ($maestros as $maestro) {
                          $option_maestro = '<option value="' . $maestro['codigo_maestro'] . '"';
                          if($_POST['maestro_practica']){
                              $option_maestro .= 'selected = "selected" ';
                           }
                          $option_maestro .= '>' . ucfirst($maestro['nombre_maestro']) . ' ' . ucwords($maestro['apellidos_maestro']) . '</option>';
                          $select_maestros .= $option_maestro;
                        }
                        $select_maestros .= '</select></div>';
                        echo json_encode($select_maestros);
                        echo '+';
                      }
                    ?>
                  '<div class="form-group col-lg-12 form-group-lg" id="material-input">' +
                    '<div class="checkbox">'+
                      '<label>' +
                        '<input type="checkbox" name="material">' +
                        '<span class="checkbox-material">' +
                          '<span class="check"></span>' +
                        '</span>' +
                        ' Necesito material para la practica' +
                      '</label>' +
                    '</div>' +
                  '</div>' +
                  '<div class="row">' +
                    '<div class="col-lg-6 col-lg-offset-3">' +
                      '<button type="submit" class="btn btn-raised btn-primary">Solicitar</button>' +
                      '<a href="<?php echo URL ?>practica/solicitar"><button type="button" class="btn btn-raised btn-primary">Cancelar</button></a>' +
                    '</div>' +
                  '</div>';

	function errors(errors){
		for (var key in errors) {
			var errorClass = document.getElementById('inputError2Status');
      var input = document.getElementById(key + '-input');
			var mensaje = errors[key];
      if(input.classList.contains('has-feedback')){
    		input.lastChild.innerHTML = mensaje;
    		input.className += ' has-error is-focused';
    	}else{
  			addError(input, mensaje);
    	}
		}
	}

	function addForm(){
		var button = document.getElementById('button');
		var form = button.parentNode;
		form.removeChild(button);
		form.insertAdjacentHTML( 'beforeend', template2 );
	}

	function ajax_json_data(){
    var date = document.getElementById("fecha").value;
    var hora = document.getElementById("hora").value;
    var duracion_horas = (document.getElementById("duracion_horas").value == "Horas") ? "" : document.getElementById("duracion_horas").value;
    var duracion_minutos = (document.getElementById("duracion_minutos").value == "Minutos") ? "" : document.getElementById("duracion_minutos").value;
    var ajax = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>disponibilidad_practica.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function() {
      if(ajax.readyState == 4 && ajax.status == 200){
      	var response = JSON.parse(ajax.responseText);
        var error = document.getElementById('error');
        if(error){
          error.parentNode.removeChild(error);
        }
      	if(typeof response === 'object'){
      		if(response.type == 'errors'){
      			errors(response.results);
      		}else if(response.type == 'hours'){
               var mensaje =  '<div class="col-lg-4" id="error">' +
                                 '<div class="panel panel-danger">' +
                                    '<div class="panel-heading">' +
                                       '<h3 class="panel-title">Estos horarios <strong>NO</strong> esta disponibles</h3>' +
                                    '</div>' +
                                    '<div class="panel-body"><ul>';
                                       for(x in response.results){
                                          mensaje += '<li>' + response.results[x].startHour + '-' + response.results[x].finishHour + '</li>';
                                       }
                                    mensaje += '</ul></div>' +
                                 '</div>' +
                              '</div>';

               document.getElementById('button').innerHTML += mensaje;
      		}
      	}else{
      		addForm();
      	}
      }
    }
    ajax.send('fecha='+date+'&hora='+hora+'&duracion_horas='+duracion_horas+'&duracion_minutos='+duracion_minutos);
  }
</script>

<?php
  if(is_array($datos)){
    foreach($datos as $errors => $nose){
      foreach($nose as $error){
        ?>
        <script type="text/javascript">
        var element = document.getElementById('<?php echo $errors ?>-input');
        var mensaje = '<?php echo $error; ?>';

        addError(element, mensaje);
        </script>
        <?php
      }
    }
  }elseif(is_bool($datos) && $datos == true){
?>
  <script type="text/javascript">
    sweetAlertInitialize();
    swal({
      title: "Practica solicitada correctamente",
      type: "success",
      confirmButtonText: "Continuar",
    },
    function(){
      window.location = '<?php echo URL .'practica'?>';
    });
  </script>
<?php
  }
?>