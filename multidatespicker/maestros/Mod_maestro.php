<?php 
$id      = $_GET['id'];
$titulo  = $_GET['titulo']; 
$archivo = $_GET['archivo'];
$tabla   = $_GET['tabla'];
$Nmenu   = $_GET['Nmenu'];
$metodo  = "Modificar";
require_once('autentificacion/aut_verifica_menu.php');

mysql_query("SET NAMES utf8");
$result01 = mysql_query("SELECT descripcion, status FROM $tabla  WHERE codigo = '$id'", $cnn);  
$row01    = mysql_fetch_array($result01);
?>
<form action="sc_maestros/sc_maestros.php" method="post" name="add" id="add" accept-charset="UTF-8"> 
     <table width="70%" align="center">
         <tr valign="top">                    
		     <td height="23" colspan="2" class="etiqueta_title" align="center"> MODIFICAR <?php echo $colores;?></td>
         </tr>
         <tr> 
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>	 
    <tr>
      <td class="etiqueta" width="25%">C&oacute;digo:</td>
      <td id="input01" width="75%"><input type="text" name="codigo" maxlength="12" style="width:120px" value="<?php echo $id;?>" readonly="true"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span></td>
    </tr>
    <tr>
      <td class="etiqueta" width="25%">Descripci&oacute;n:</td>
      <td id="input02" width="75%"><input type="text" name="descripcion" maxlength="60" style="width:300px" value="<?php echo utf8_decode($row01[0]);?>"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>		
     <tr>
	     <td height="20" class="etiqueta">Status:</td>
	     <td  id="select01">		    
			   <select name="status" style="width:120px;">	 
     				   <option value="<?php echo $row01[1];?>"> <?php echo statuscal($row01[1]);?> </option>
					   <option value="1"> Activo </option>
                       <option value="2"> Inactivo </option>    
	           </select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>	
          <tr>
              <td colspan="2" align="center"><hr></td>
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
			<input type="hidden" name="metodo" value="<?php echo $metodo;?>" />
			<input type="hidden" name="tabla" value="<?php echo $tabla;?>" />
			<input type="hidden" name="usuario" value="<?php echo $usuario;?>" />	
			<input type="hidden" name="id" value="<?php echo $id; ?>"/>		
			<input type="hidden" name="href" value="../inicio.php?area=maestros/Cons_<?php echo $archivo?>&Nmenu=<?php echo $_GET["Nmenu"];?>"/> 					   			
		     </td>
	   </tr>
  </table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
var input01 = new Spry.Widget.ValidationTextField("input01", "none", {validateOn:["blur", "change"]});
var input02 = new Spry.Widget.ValidationTextField("input02", "none", {minChars:2, validateOn:["blur", "change"]});
var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
</script>