<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<script language="javascript">

function Activar01(valorX){
	
	 if(document.getElementById("cita").checked == true){
		document.getElementById("cita").value = "S";
		document.getElementById("Contenedor02").style.display="";
		document.getElementById("cita_fecha").disabled = false;
		document.getElementById("cita_hora").disabled = false;
		
	 }else{
		document.getElementById("cita").value = "N";		
		document.getElementById("Contenedor02").style.display="none";
		document.getElementById("cita_fecha").disabled = true;
		document.getElementById("cita_hora").disabled = true;
	}
}
</script>

<?php 
$Nmenu    = $_GET['Nmenu'];
$titulo   = " AGREGAR FOROS RENGLON ";
$archivo  = "foros";
$archivo2 = "foros_renglon";
$metodo   = "agregar_renglon";
$codigo   = $_GET['codigo'];
require_once('autentificacion/aut_verifica_menu.php');
?>

<form action="scripts/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add"> 

     <table width="80%" align="center">
         <tr valign="top">                    
		     <td height="23" colspan="2" class="etiqueta_title" align="center"><?php echo $titulo;?></td>
         </tr>
         <tr> 
    	       <td height="8" colspan="2" align="center"><hr></td>    
     	</tr>
    <tr>
      <td class="etiqueta" width="30%">Asunto o Titulo:</td>
      <td id="input01" width="70%"><input type="text" name="asunto" maxlength="60" style="width:350px" />
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Mensaje:</td>
      <td id="textarea01"><textarea  name="mensaje" cols="50" rows="5"></textarea>
        <span id="Counterror_mess2" class="texto">&nbsp;</span> 
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 300.</span></td>
    </tr>	
    <tr>
      <td class="etiqueta">Cita o Notificaci&oacute;n: </td>
      <td id="textarea01"><input name="cita" id="cita" type="checkbox"  value="N" onchange="Activar01()"  />
        <span id="Counterror_mess2" class="texto">&nbsp;</span> 
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 300.</span></td>
    </tr>	
    <tr><td colspan="2">
	     <table width="100%" align="center" id="Contenedor02"style="display:none">    

    <tr>
      <td class="etiqueta">Fecha Notificaci&oacute;n:</td>
      <td id="fecha01"><input type="text" name="cita_fecha" id="cita_fecha"  style="width:100px" 
                              value="<?php echo $date;?>" disabled="disabled" />
            <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
            <span class="textfieldRequiredMsg">La Fecha Es Requerida.</span>
            <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Hora Notificaci&oacute;n:</td>
      <td id="time01"><input type="text" name="cita_hora" id="cita_hora" style="width:100px" disabled="disabled" />
            <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
            <span class="textfieldRequiredMsg">La Fecha Es Requerida.</span>
            <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span></td>
    </tr>
    </table>
        
    </td></tr>    

         <tr> 
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>	
         <tr> 
		     <td colspan="2" align="center">
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="submit" name="salvar"  id="salvar" value="Guardar" class="readon art-button" />	
                </span>&nbsp;
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="reset" id="limpiar" value="Restablecer" class="readon art-button" />	
                </span>&nbsp;
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="button" id="volver" value="Volver" onClick="history.back(-1);" class="readon art-button" />	
                </span>
		    <input name="metodo" type="hidden"  value="<?php echo $metodo;?>" />
			<input name="usuario" type="hidden"  value="<?php echo $usuario;?>" />
            <input name="codigo" id="codigo" type="hidden"  value="<?php echo $codigo;?>" />	       
            <input name="href" type="hidden" value="../inicio.php?area=formularios/Cons_<?php echo $archivo2."&Nmenu=".$Nmenu."&codigo=".$codigo.""?>"/>	   			
		     </td>
	   </tr>
  </table>
</form>
</body>
</html>
<script type="text/javascript">
var fecha01 = new Spry.Widget.ValidationTextField("fecha01", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAA", validateOn:["blur", "change"], useCharacterMasking:true, isRequired:true});

var input01 = new Spry.Widget.ValidationTextField("input01", "none", {validateOn:["blur", "change"]});
var input02 = new Spry.Widget.ValidationTextField("input02", "none", {validateOn:["blur", "change"]});

var time01 = new Spry.Widget.ValidationTextField("time01", "time", {format:"hh:mm:ss tt", hint:"hh:mm:ss tt", validateOn:["blur", "change"], useCharacterMasking:true});

var textarea01 = new Spry.Widget.ValidationTextarea("textarea01", {minChars:4, maxChars:2000, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess2", useCharacterMasking:false ,isRequired:false});

//var select10 = new Spry.Widget.ValidationSelect("select10", {validateOn:["blur", "change"]});
</script>