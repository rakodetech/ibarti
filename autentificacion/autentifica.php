    
<script type="text/javascript">
  var us   = '';
  var l    = '';
  var t    = '';

  $(function() {
    var parametros = {};
    $.ajax({
      data:  parametros,
      url:   'autentificacion/captcha/captcha.php',
      type:  'post',
      success:  function (response) {
        $("#captcha").attr('src',response);
        captcha();
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);}
      });
  });

  function Ver_log(){
    l        = $("#log_us").val();
    var p    = $("#log_p").val();
    var cap  = $("#log_cap").val();
    var error = 0;
    var errorMessage = "";

    if(l.length <4){
      var error = 1;
      var errorMessage = "Debe Ingresar un login Valido";
    }

    if((p.length <2) && (error == 0)){
      var error = 1;
      var errorMessage = "Debe Ingresar una Contraseña";
    }

    if((removeSpaces(code) != cap ) && (error == 0)){
      var error = 1;
      var errorMessage = "Captcha Invalidad";
      captcha();
    }

    if (error == 0) {
      $("#submit").click();
    }else{
      alert(errorMessage);
    }
  }

  function crearCaptcha(texto) {
    var ctxCanvas = document.getElementById('captcha').getContext('2d');
    var fontSize = "30px";
    var fontFamily = "Arial";
    var width = 150;
    var height = 40;
    //tamaño
    ctxCanvas.canvas.width = width;
    ctxCanvas.canvas.height = height;
    //color de fondo
    ctxCanvas.fillStyle = "whitesmoke";
    ctxCanvas.fillRect(0, 0, width, height);
    //puntos de distorsion
    ctxCanvas.setLineDash([20, 5]);
    ctxCanvas.lineDashOffset = Math.random()*10;
    ctxCanvas.beginPath();
    var line;
    for (var i = 0; i < (width); i++) {
      line = i * Math.random()*10;
      ctxCanvas.moveTo(line, 0);
      ctxCanvas.lineTo(0, line);
    }
    ctxCanvas.stroke();
    //formato texto
    ctxCanvas.direction = 'ltr';
    ctxCanvas.font = fontSize + " " + fontFamily;
    //texto posicion
    var x = (width / 9);
    var y = (height / 3) * 2;
    //color del borde del texto
    ctxCanvas.strokeStyle = "yellow";
    ctxCanvas.strokeText(texto, x, y);
    //color del texto
    ctxCanvas.fillStyle = "#57743E";
    ctxCanvas.fillText(texto, x, y);
  }

  function removeSpaces(valorX){
    return valorX.split(' ').join('');
  }

  function captcha(){
    var alpha = new Array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
    var alpha02 = new Array('i','p');
    var i;
    for (i=0;i<6;i++){
      var a = alpha02[Math.floor(Math.random() * alpha02.length)];
      var b = alpha[Math.floor(Math.random() * alpha.length)];
      var c = alpha[Math.floor(Math.random() * alpha.length)];
      var d = alpha[Math.floor(Math.random() * alpha.length)];
      var e = alpha[Math.floor(Math.random() * alpha.length)];
    }
    code = a + ' ' + b + ' ' + c + ' ' + d + ' ' + e;
  crearCaptcha(code);
    $("#log_cap").val('');
  }
</script>

<form action="autentificacion/aut_verifica.inc.php" method="post" autocomplete="off" >  

  <!--            <form action="autentificacion/captcha/ejemplo/verificacion.php" method="post">  -->
    <?php
		// Mostrar error de Autentificaci&oacute;n.
    include ("autentificacion/aut_mensaje_error.inc.php");
    if (isset($_GET['error_login'])){
      $error=$_GET['error_login'];
      echo '<script language="javascript">
      alert("Error: '.$error_login_ms[$error].'");</script>';
    }
    ?>             

    <table width="450px" >
     <tr class="fondo00"><td colspan="3"><div class="art-postcontent" align="center"><h3>Acceso Al Sistema IBARTI.</h3></div></td>             </tr>
     <tr  class="fondo01"><td>Usuario:</td>
       <td><input name="login" id="log_us" type="text" class="campo_char" size="16" autocomplete="off" /></td>
       <td rowspan="5"> <img src="imagenes/PadlockUserControl.png" width="150" height="150" /></td>
     </tr>
     <tr  class="fondo01"><td>Clave:</td>
       <td><input name="pass" type="password" class="campo_char" id="log_p" size="16"/></td>
     </tr>
     <tr  class="fondo01"><td>Imagen De Verificacion:</td>
       <td><canvas id="captcha"></canvas></td>
     </tr>

     <tr  class="fondo01"><td>Codigo de Verificacion:</td>
       <td>	<input id="log_cap" type="text" size="16" name="captcha" /></td>
     </tr>

     <tr  class="fondo01"><td colspan="2"><div align="center"> 
      <span class="art-button-wrapper">
      <span class="art-button-l"> </span>
      <span class="art-button-r"> </span>
      <input type="button" value="Entrar" class="readon art-button" onclick="Ver_log()">	
      <input type="submit" name="submit" id="submit" hidden="hidden">
    </span>&nbsp;
    <span class="art-button-wrapper">
      <span class="art-button-l"> </span>
      <span class="art-button-r"> </span>
      <input name="reset" type="reset" value="Cancelar" class="readon art-button" />	
    </span></div>
  </td>             
  </tr>
</table>         
</form>
<br />
