<?php 
	$metodo = $_GET['metodo'];
	$mod   = $_GET['mod'];
	$Nmenu = $_GET['Nmenu'];
    $titulo = "Usuario de Sistema";
	$vinculo = "../index.php";
	if(isset($_GET['codigo'])){ //== ''


	}else{
	$codigo     = '';
	$cedula     = '';
    $titulo     = " Agregar ".$titulo."";	
	$nombre     = '';
	$apellido   = '';
	$email      = '';	
	$login      = '';	
	$cod_perfil = '';
	$perfil     = 'Seleccione...';
	$status     = '';
	$disabled   = ' ';
	$metodo     = 'registro';
	}

?>
<form action="autentificacion/sc_Usuarios.php" method="post" name="mod_usuarios" id="mod_usuarios"> 
  <fieldset class="fieldset">
  <legend><?php echo $titulo;?> </legend>
     <table width="80%" align="center">
 <tr>
      <td class="etiqueta">C&eacute;dula:</td>
      <td id="input01"><input type="text" name="cedula" maxlength="15" value="<?php echo $cedula;?>" style="width:120px"/>
        Activo: <input name="status" type="checkbox" checked="checked" value="T"/>
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta">Nombres:</td>
      <td id="input02"><input type="text" name="nombre" maxlength="120" style="width:200px" value="<?php echo $nombre;?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta">Apellidos: </td>
      <td id="input03"><input type="text" name="apellido" maxlength="120" style="width:200px" value="<?php echo $apellido;?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span></td>
    </tr>
	<tr>
      <td class="etiqueta">Email:</td>
      <td id="email"><input name="email" type="text" maxlength="60" style="width:250px" value="<?php echo $email;?>"><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span></td>
    </tr>	
	<tr>
      <td class="etiqueta">Login:</td>
      <td id="input04"><input name="login" type="text" maxlength="15" style="width:120px" value="<?php echo $login;?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Password:</td>
      <td><input name="check"  id"check" type="checkbox"  value="ON"/>
<span id="input05">
<input name="password1" id="password1" type="password" style="width:120px" maxlength="11" value=""/><br>
          	<span class="textfieldRequiredMsg">El Valor es Requerido.</span>
          	<span class="textfieldMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
	  </span>
</span>	  
	  </td>
    </tr>	   
    <tr>
      <td class="etiqueta">Password (repitalo):</td>
      <td id="input06">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	          <input name="password2" id="password2" type="password" style="width:120px" maxlength="11"><br>
          	<span class="textfieldRequiredMsg">El Valor es Requerido.</span>
          	<span class="textfieldMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
     </td>
    </tr> 	
	 <tr> 
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>	
         <tr> 
		     <td colspan="2" align="center">
      		<input  type="submit" name="salvar"  id="salvar" value="Guardar" class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	&nbsp;
		    <input type="reset"     id="limpiar"  value="Restablecer" class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	&nbsp;
		    <input type="button"   id="volver"  value="Volver" onClick="history.back(-1);"  class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">
		    <input name="metodo" type="hidden"  value="<?php echo $metodo;?>"/>
             <input name="passOLD" type="hidden"  value=""/>
		    <input name="usuario" id="usuario" type="hidden"  value="<?php echo $usuario;?>" />
	        <input name="href" type="hidden" value="<?php echo $vinculo;?>"/>		   			
		     </td>
	   </tr>
  </table>
  </fieldset>
</form>
</body>
</html>
<script type="text/javascript">
var input01  = new Spry.Widget.ValidationTextField("input01", "integer", {validateOn:["blur", "change"]});
var input02  = new Spry.Widget.ValidationTextField("input02", "none", {validateOn:["blur", "change"]});
var input03  = new Spry.Widget.ValidationTextField("input03", "none", {validateOn:["blur", "change"]});
var input04  = new Spry.Widget.ValidationTextField("input04", "none", {minChars:4, validateOn:["blur", "change"]});
var input05  = new Spry.Widget.ValidationTextField("input05", "none", {minChars:4, validateOn:["blur"], isRequired:false} );
var input06  = new Spry.Widget.ValidationTextField("input06", "none", {minChars:4, validateOn:["blur"], isRequired:false});


var email    = new Spry.Widget.ValidationTextField("email", "email", {validateOn:["blur"]});
</script>