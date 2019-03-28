<?php 
	$sql = " SELECT men_usuarios.login
               FROM men_usuarios
              WHERE men_usuarios.codigo = '$usuario' ";
    $query = $bd->consultar($sql);
    $datos=$bd->obtener_fila($query,0);
	 $proced      = "p_usuario"; 
	 $metodo      = "us_password";
	 	
	
?>
<form action="autentificacion/sc_usuarios.php" method="post" name="mod_usuarios" id="mod_usuarios"> 
  <fieldset class="fieldset">
  <legend>Cambiar Clave </legend>
     <table width="80%" align="center">
	<tr>
      <td class="etiqueta">Login:</td>
      <td id="input01"><input name="login" type="text" maxlength="15" style="width:120px" value="<?php echo $datos[0];?>" readonly="true">
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Clave Anterior :</td>
      <td id="input02"><input name="passOLD"  type="password" style="width:120px" maxlength="11"><br>
          	<span class="textfieldRequiredMsg">El Valor es Requerido.</span>
          	<span class="textfieldInvalidFormatMsg"> Minimo (2 Numeros, 2 numero alpha numerico), de 8 a 10  caracteres.</span>
	  </span>
	  </td>
    </tr>	   
    <tr>
      <td class="etiqueta">Clave Nueva:</td>
      <td id="customPasswordFunction"><input name="password1" id="password1" type="password" style="width:120px" maxlength="11"><br>
          	<span class="textfieldRequiredMsg">El Valor es Requerido.</span>
          	<span class="textfieldInvalidFormatMsg"> Minimo (2 Numeros, 2 numero alpha numerico), de 8 a 10  caracteres.</span>
	  </span>
	  </td>
    </tr>	   
    <tr>
      <td class="etiqueta">Repita Clave:</td>
      <td id="dupFunction"><input name="password2" id="password2" type="password" style="width:120px" maxlength="11"><br>
          	<span class="textfieldRequiredMsg">El Valor es Requerido.</span>
          	<span class="textfieldInvalidFormatMsg">El passwords  es diferente.</span>
     </td>
    </tr> 
	 <tr> 
            <td height="8" colspan="2" align="center"><hr></td>
       </tr>	
         <tr> 
		     <td colspan="2" align="center">
             
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
               <input  type="submit" name="salvar"  id="salvar" value="Guardar" class="readon art-button">
                </span>&nbsp; 
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="reset" id="limpiar" value="Restablecer" class="readon art-button" />	
      			</span>
                &nbsp;		   

            <input name="metodo" type="hidden"  value="<?php echo $metodo;?>"/>
		    <input name="codigo" type="hidden"  value="<?php echo $usuario;?>" />
            <input name="cedula" type="hidden"  value="" />
            <input name="usuario" type="hidden"  value="<?php echo $usuario;?>" />
            <input name="nombre" type="hidden"  value=""/>
            <input name="apellido" type="hidden"  value=""/>
            <input name="email" type="hidden"  value=""/>
            <input name="perfil" type="hidden"  value=""/>
            <input name="status" type="hidden"  value=""/>
            <input name="check" type="hidden"  value="S"/>
            <input name="asistencia_orden" type="hidden"  value=""/>
            <input name="proced" id="proced" type="hidden"  value="<?php echo $proced;?>" />
	        <input name="href" type="hidden" value="../autentificacion/aut_logout.php"/>            		   			
		     </td>
	   </tr>
  </table>
  </fieldset>
</form>

<script type="text/javascript">
<!--

var passwordStrength = function(value, options){

	if (value.length < 8 || value.length > 10)
		return false;

	if (value.match(/[0-9]/g).length < 2)
		return false;
	
	if (value.match(/[a-z]/g).length < 2)
		return false;
/*
	if (value.replace(/[0-9a-z]/g, '').length == 0)
		return false;  */
	return true;
}

var passwordTheSame = function(value, options){
	var other_value = document.getElementById('password1').value;
	if (value != other_value){
		return false;
	}
	return true;
}

var customFunction = new Spry.Widget.ValidationTextField("customPasswordFunction", "custom", {validation: passwordStrength, validateOn:["blur" ]});
var passwordDuplication = new Spry.Widget.ValidationTextField("dupFunction", "custom", {validation: passwordTheSame, validateOn:["blur"]});
//-->

	var input01  = new Spry.Widget.ValidationTextField("input01", "none", {minChars:4, validateOn:["blur"]});
	var input02  = new Spry.Widget.ValidationTextField("input02", "none", {minChars:4, validateOn:["blur"]});
</script>