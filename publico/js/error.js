function addError(elemento, mensaje){



  var span2 = document.createElement('span');
  span2.setAttribute('id', 'inputError2Status');
  span2.setAttribute('class', 'sr-only');
  t = document.createTextNode('(error)');
  span2.appendChild(t);

  var span3 = document.createElement('span');
  span3.setAttribute('class', 'help-block');
  span3.nodeValue = '';
  t2 = document.createTextNode(mensaje);
  span3.appendChild(t2);


  //elemento.appendChild(span1);
  elemento.appendChild(span2);
  elemento.appendChild(span3);
  elemento.className += " has-feedback has-error is-focused";
}

/*function removeError(key){
  var errorClass = document.getElementById('inputError2Status');
  var input = document.getElementById(key + '-input');
      //var element = document.getElementById(key + '-input');
  //var mensaje = errors[key];
  //element = input.parentNode;
  if(input.contains(errorClass)){
    input.className = 'form-group col-lg-4 form-group-lg';
    console.log(input);
    var span = document.getElementsByTagName('span');
    for(x = 0; x < span.length; x++){
      input.removeChild(span[0]);
    }
  }
  //element.className = element.className.replace( /(?:^|\s)'has-feedback'(?!\S)/g , '' );
  //$(element).removeClass('has-feedback');
  //var parent = span.parentNode;
  //console.log(element);
  /*if(input.contains(errorClass)){
    var span = document.getElementsByTagName('span');
    for(x = 0; x <= span.length; x++){
      element.removeChild(span[0]);
    }
  }*/
  //document.getElementById("MyElement").className =
  //document.getElementById("MyElement").className.replace( /(?:^|\s)MyClass(?!\S)/g , '' )
//}