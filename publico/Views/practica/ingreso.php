<br>
<div class="container">
	<div class="row">
		<div class="col-lg-3">
			<div class="row">
				<div class="form-group label-floating form-group-lg is-empty" id="codigo-input">
					<label>Por favor ingresa el código del alumno (9 digitos). Click en terminar después de ingresar todos los alumnos.</label>
	      		<input class="form-control" id="codigo" onkeyup="request()" autofocus></input>
	      		<p class="help-block" id="help"></p>
	      	</div>
	      </div>
			<div class="row">
				<button type="button" class="btn btn-raised" id="terminar">Terminar</button>
			</div>
	   </div>

	<div class="col-lg-6 col-lg-offset-3">
	<div class="table-responsive">
		<table class="table table-hover">
			<tbody>
				<?php foreach($datos as $ingreso){
					echo '<tr>';
					echo '<td>', $ingreso['codigo_alumno'], '</td>';
					echo '<td>', ucwords($ingreso['nombre_alumno']), ' ', ucwords($ingreso['apellidos_alumno']), '</td>';
					echo '</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
	</div>
	</div>
</div>

<script type="text/javascript">
	var url = window.location.href.split('/');
	var id = url[url.length-1];
	document.getElementById('terminar').addEventListener('click', function(evt){
		swal({
	      title: '¡Terminar Practica!',
	      text: '¿Estas seguro? Se terminara de registrar ingresos a esta practica',
	      type: "warning",
	      showCancelButton: true
	      }, function() {
				var url = window.location.href.split('/');
			   ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>terminar_practica.php", true);
			   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			   ajax.onreadystatechange = function() {
				   if(ajax.readyState == 4 && ajax.status == 200) {
				      if(ajax.responseText){
				      	window.location.href = '<?php echo URL, 'practica/detalles/'?>'+id;
				      }
				   }
			   }
			   ajax.send('id='+id);
			});
	});

	document.getElementById('codigo').addEventListener('keypress',function(evt){
    	if(this.value.length == 9 && evt.which > 31){
    		evt.preventDefault();
    	}
    	if(this.value.length < 10){
    		document.getElementById('help').innerHTML = '';
    	}
	});

	function ajax_json_data(){
	   var user = document.getElementById("codigo").value;
	   ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>ingreso_practica.php", true);
	   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	   ajax.onreadystatechange = function() {
		   if(ajax.readyState == 4 && ajax.status == 200) {
		      var alumno = JSON.parse(ajax.responseText);
		      if(alumno.type === 'success'){
		   		var tr = document.createElement('tr');
		   		tr.innerHTML = alumno.element;
					var table = document.querySelector("tbody");
					table.appendChild(tr);
		         document.getElementById("codigo").value = '';
		         document.getElementById('help').innerHTML = '';
		      }else if(alumno.type === 'error'){
		      	var codigoInput = document.getElementById("codigo-input");
		      	codigoInput.className += ' has-error';
		      	document.getElementById('help').innerHTML = alumno.message;
		      }
		   }
	   }
	   ajax.send('codigo='+user+'&id='+id);
	}

  	function request(){
   	var str = document.getElementById("codigo").value.length;
   	if(str === 9){
      	ajax_json_data();
    	}
  	}
</script>