<div class="container">
	<div class="row">
		<div class="col-lg-3 col-lg-offset-3">
			<a class="btn btn-primary" href="<?php echo URL . 'inventario' ?>">Ver Inventario</a>
		</div>
		<div class="col-lg-3">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#iniciar-sesion">Iniciar sesión</button>
		</div>
		<div class="col-lg-3">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#solicitar-practica">Solicitar Practica</button>
		</div>
	</div>
	<div id="iniciar-sesion" class="modal fade" style="display: none;" tabindex="-1">
	  	<div class="modal-dialog">
	    	<div class="modal-content">
	      	<div class="modal-body">
	      		<form action="" method="POST" class="bs-component">
						<div class="form-group label-floating form-group-lg" id="user-input">
  							<div class="input-group">
    							<span class="input-group-addon"><i class="material-icons">account_circle</i></span>
								<span class="big-font">Usuario</span>
						  		<input class="form-control" name="user" id="user" type="text" autofocus>
						  		<p class="help-block" id="user-help"></p>
						  	</div>
						</div>

						<div class="form-group label-floating form-group-lg" id="password-input">
  							<div class="input-group">
    							<span class="input-group-addon"><i class="material-icons">vpn_key</i></span>
								<span class="big-font">Contraseña</span>
							  	<input class="form-control" name="password" id="password" type="password">
							  	<p class="help-block" id="password-help"></p>
							</div>
						</div><br>
						<button type="submit" class="btn btn-primary btn-raised" id="iniciar_sesion">Iniciar Sesión</button>
					</form>
	      	</div>
	    	</div>
	  	</div>
	</div>
	<div id="solicitar-practica" class="modal fade" style="display: none;" tabindex="-1">
	  	<div class="modal-dialog">
	    	<div class="modal-content">
	      	<div class="modal-body">
	      		<form action="" method="POST" class="bs-component">
						<div class="form-group label-floating form-group-lg" id="maestro-input">
							<span class="big-font">Por favor ingresa el código del maestro</span>
						  	<input class="form-control" name="maestro" id="maestro" type="text" autofocus>
						  	<p class="help-block" id="maestro-help"></p>
						</div>
						<button type="submit" class="btn btn-primary btn-raised" id="solicitar">Solicitar</button>
					</form>
	      	</div>
	    	</div>
	  	</div>
	</div>

	<div class="row">
		<div class="col-lg-3 col-lg-offset-4">
			<span class="big-font">Ingresar código (9 digitos)</span>
			<div class="form-group label-floating form-group-lg is-empty" id="codigo-input">
				<div class="input-group">
	      		<input class="form-control" id="codigo" onkeyup="request()" autofocus></input>
	      		<p class="help-block" id="help"></p>
	      	</div>
	      </div>
	   </div>
	</div>
</div>
<div class="divider"></div>
<div class="container">
	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Código</th>
					<th>Alumno</th>
					<th>Hora Ingreso</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($datos as $alumno){
						echo '<tr>';
						echo '<td>', $alumno['codigo_alumno'], '</td>';
						echo '<td>', ucwords($alumno['nombre_alumno']), ' ', ucwords($alumno['apellidos_alumno']), '</td>';
						echo '<td>', date('h:i a', strtotime($alumno['hora_ingreso'])), '</td>';
						echo '<td><button onclick="salir_ajax(this,\'', $alumno['codigo_alumno'], '\', \'', $alumno['fecha_ingreso'],'\', \'', $alumno['hora_ingreso'], '\')">Salir</button></td>';
						echo '</tr>';
					}
				?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	document.querySelector('#iniciar_sesion').addEventListener('click',function(evt){
		evt.preventDefault();
		var usuario = document.querySelector('#user').value;
		var psw = document.querySelector('#password').value;
		var userInput = document.querySelector('#user-input');
		var passwordInput = document.querySelector('#password-input');
		var p = document.querySelector('#user-help');
		p.innerHTML = '';
		if(usuario.length > 0 && psw.length > 0){
			ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>sesion.php", true);
		   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		   ajax.onreadystatechange = function() {
			   if(ajax.readyState == 4 && ajax.status == 200){
			   	if(ajax.responseText == 'success'){
			   		window.location.href = '<?php echo URL ?>';
			   	}if(ajax.responseText == 'noUser'){
			   		p.innerHTML = 'Usuario no encontrado';
						userInput.className += ' has-error is-focused';
			   	}else if(ajax.responseText == 'noPsw'){
			   		document.querySelector('#password-help').innerHTML = 'Contraseña incorrecta';
						passwordInput.className += ' has-error is-focused';
			   	}
			   }
		   }
		   ajax.send('usuario='+usuario+'&psw='+psw);
		}else{
			p.innerHTML = 'Ingresa usuario';
			userInput.className += ' has-error is-focused';
		}
	});

	//ingreso maestro
	document.querySelector('#solicitar').addEventListener('click',function(evt){
		evt.preventDefault();
		var maestro = document.querySelector('#maestro').value;
		var maestroInput = document.querySelector('#maestro-input');
		var p = document.querySelector('#maestro-help');
		var userInput = document.querySelector('#maestro-input');
		p.innerHTML = '';
		if(maestro.length > 0){
			ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>sesion_maestro.php", true);
		   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		   ajax.onreadystatechange = function() {
			   if(ajax.readyState == 4 && ajax.status == 200){
			   	if(ajax.responseText == 'success'){
			   		window.location.href = '<?php echo URL ?>';
			   	}if(ajax.responseText == 'noUser'){
			   		p.innerHTML = 'Maestro no encontrado';
						userInput.className += ' has-error is-focused';
			   	}
			   }
		   }
		   ajax.send('maestro='+maestro);
		}else{
			p.innerHTML = 'Ingresa usuario';
			userInput.className += ' has-error is-focused';
		}
	});

  	document.getElementById('codigo').addEventListener('keypress',function(evt){
    	if(this.value.length == 9 && evt.which > 31){
    		evt.preventDefault();
    	}
    	if(this.value.length < 10){
    		document.getElementById('help').innerHTML = '';
    	}
	});
	function ingreso_ajax(){
	   var codigo = document.getElementById("codigo").value;
	   ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>ingreso.php", true);
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
	   ajax.send('codigo='+codigo);
	}
  	function request(){
   	var str = document.getElementById("codigo").value.length;
   	if(str === 9){
      	ingreso_ajax();
    	}
  	}


  	function salir_ajax(element, codigo, fecha, hora){
  		var alumno = element.parentNode.parentNode;
  		ajax.open("POST", "<?php echo URL . 'app/ajax/' ?>salir.php", true);
	   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	   ajax.onreadystatechange = function() {
		   if(ajax.readyState == 4 && ajax.status == 200) {
		   	alumno.parentNode.removeChild(alumno);
		   }
	   }
	   ajax.send('codigo='+codigo+'&fecha='+fecha+'&hora='+hora);
  	}
</script>