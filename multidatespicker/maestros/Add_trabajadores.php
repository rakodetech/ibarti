<?php
mysql_select_db($bd_cnn, $cnn);

$id = $_GET['codigo'];
$archivo = 'agregar';
$query01 = mysql_query(" SELECT control.eventuales +1 FROM control ", $cnn);
$row01   = mysql_fetch_array($query01);
$href    = "../inicio.php?area=maestros/Cons_Trabajadores&Nmenu=".$_GET['Nmenu']."";
?>
<form action="sc_maestros/Trabajadores.php" method="post" name="add" id="add"> 
  <fieldset class="fieldset">
  <legend>Datos B&aacute;sicos Trabajador </legend>
     <table width="80%" align="center"> 
    <tr>
      <td class="etiqueta">Codigo:</td>
      <td id="input01"><input type="text" name="codigo" maxlength="11" readonly="true" style="width:120px"
                              value="E<?php echo $row01[0];?>"/>
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span> 
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
	 </tr>     
    <tr>
      <td class="etiqueta">C&eacute;dula:</td>
      <td id="input02"><input type="text" name="cedula" maxlength="11" value="" style="width:120px" />
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span> 
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta">Nombres:</td>
      <td id="input03"><input type="text" name="nombre" maxlength="120" style="width:250px" />
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span> 
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta">Sexo:</td>
      <td id="radio01" class="texto">
		 <?php  $sex = $sexo;
				if ($sex =='M'){
				$M='checked="checked"';
				}elseif ($sex=='F'){
				$F='checked="checked"';
				}?>	  
	  <img src="imagenes/femenino.gif" width="25" height="15" />
            <input type = "radio" name="sexo"  value = "F" style="width:auto" <?php echo  $F; ?> />
            <img src="imagenes/masculino.gif" width="25" height="15" />
            <input type = "radio" name="sexo"  value = "M" style="width:auto" <?php echo  $M; ?> />															 	         <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/>
            <span class="radioRequiredMsg">Debe seleccionar un Sexo.</span>
        </td>
    </tr>
    <tr>
      <td class="etiqueta">Tel&eacute;fono:</td>
      <td id="telefono01">
      <input type="texto" name="telefono" style="width:250px" maxlength="55"/>
      <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br /> 
      <span class="textfieldRequiredMsg">El Campo es Requerido.</span> 
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 11 caracteres.</span></td>
    </tr>

    <tr>
      <td class="etiqueta">Contracto:</td>
      	<td id="select01">
      		<select name="contracto" style="width:250px">
			<option value="">Seleccione...</option> 
          <?php
		           $query02 = mysql_query("SELECT nomina.co_cont, nomina.des_cont FROM nomina
                                            WHERE nomina.tip_cont = 2 ORDER BY 2 ",$cnn);
						  while($row02=mysql_fetch_array($query02)){
			    		  echo '<option value="'.$row02[0].'">'.$row02[1].'</option>'; 	 
				   }?>
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span>       </td>
    </tr>
    <tr>
      <td class="etiqueta">Region:</td>
      	<td id="select02">
      		<select name="region" style="width:250px">
			<option value="">Seleccione...</option> 
          <?php
		           $query02 = mysql_query("SELECT id, descripcion FROM regiones  WHERE status = 1 ORDER BY 2",$cnn);
						  while($row02=mysql_fetch_array($query02)){			    		
							  echo '<option value="'.$row02[0].'">'.$row02[1].'</option>'; 				  
				   }?>
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span>       </td>
    </tr>
    <tr>
      <td class="etiqueta">Fecha de Nacimiento:</td>
      <td id="fecha01">
          	<input type="text" name="fecha_nac" />
            <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
            <span class="textfieldRequiredMsg">La Fecha Es Requerida.</span>
            <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Fecha de Ingreso:</td>
      <td id="fecha02">
          	<input type="text" name="fecha_ing" />
            <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
            <span class="textfieldRequiredMsg">La Fecha Es Requerida.</span>
            <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span>
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
		    <input name="archivo" type="hidden"  value="<?php echo $archivo;?>" />
            <input name="usuario" type="hidden"  value="<?php echo $usuario;?>" />            
	        <input name="href" type="hidden" value="<?php echo $href;?>"/>		   			
		     </td>
	   </tr>
  </table>
  </fieldset>
</form>
</body>
</html>
<script type="text/javascript">

var input01  = new Spry.Widget.ValidationTextField("input01", "none", {minChars:4, validateOn:["blur", "change"]});
var input02  = new Spry.Widget.ValidationTextField("input02", "none", {minChars:4, validateOn:["blur", "change"]});
var input03  = new Spry.Widget.ValidationTextField("input03", "none", {minChars:4, validateOn:["blur", "change"]});
var input04  = new Spry.Widget.ValidationTextField("input04", "none", {minChars:4, validateOn:["blur", "change"]});

<!--var email    = new Spry.Widget.ValidationTextField("email", "email", {minChars:4, validateOn:["blur"]});-->
var radio01 = new Spry.Widget.ValidationRadio("radio01", { validateOn:["change", "blur"]});

var telefono01  = new Spry.Widget.ValidationTextField("telefono01", "none", {minChars:11, validateOn:["blur", "change"]});

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});

var fecha01 = new Spry.Widget.ValidationTextField("fecha01", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAA", 
    validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});	
var fecha02 = new Spry.Widget.ValidationTextField("fecha02", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAA", 
    validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});	
</script>