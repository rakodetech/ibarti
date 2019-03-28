<script language="javascript">
function Centrar(){
	iz=(screen.width-document.body.clientWidth) / 2;
	de=(screen.height-document.body.clientHeight) / 3;
	moveTo(iz,de);
	}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>

<link rel="stylesheet" type="text/css" href="../css/style2.css">
<link rel="stylesheet" type="text/css" href="../css/validation.css">
<link href="../spry/widgets/textfieldvalidation/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../spry/widgets/textfieldvalidation/SpryValidationTextField.js"></script>
<script src="../spry/includes/SpryEffects.js" type="text/javascript"></script>
<script type="text/javascript" src="../funciones/funciones.js"></script>


</head>
<body onLoad="Centrar()">
<br />
<form id="clientes" name="clientes" action="sc_Pusuarios.php" method="post">
	<fieldset>
	<legend>Ingresar Usuario:  </legend>	
    <table width="750" border="0" align="center">  	
       <tr>
              <td class="etiqueta" width="40%">Introduzca la cedula Del Usuario:</td>
              <td id="cedulas" width="60%">
			  <input type="text" name="cedula"   id="cedula"  maxlength="10" style="width:150px"/>			   			   
			  <img src="../imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
	  		  <span class="textfieldRequiredMsg">El Valor es Requerido.</span>
	  		  <span class="textfieldInvalidFormatMsg">El Formato es Invalido</span>
			  <span class="textfieldMinCharsMsg">Debe de tener por lo menos 4 caracteres.</span>
			  </td>
      </tr>	    
   </table>		
	
	</fieldset>
	 <br />
     <div align="center">
            <input name="submit" type="submit" value="Guardar"  class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')"/>	 &nbsp;
            <input name="reset" type="reset" value="Restablecer"   class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')"/>	
			<input name="archivo" type="hidden"  value="agregar" />
 		    <input type="hidden" name="Nmenu" value="<?php echo $_GET['Nmenu']; ?>"/>	
  </div>
</form>	
</body>
<script type="text/javascript">
var cedulas = new Spry.Widget.ValidationTextField("cedulas", "none", {minChars:4, validateOn:["change"]});
//var input01 = new Spry.Widget.ValidationTextField("input01", "none", {minChars:4, validateOn:["blur", "change"]});
</script>
</html>