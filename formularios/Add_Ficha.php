<?php
	$Nmenu = 409;
	$codigo = $_GET['codigo'];
	$archivo = "Ficha&Nmenu=".$Nmenu."&codigo=".$codigo."";
	require_once('autentificacion/aut_verifica_menu.php');
?>
<form action="scripts/sc_Ficha.php" method="post" name="add" id="add">
  <fieldset class="fieldset">
  <legend>Modificar Datos B&aacute;sicos <?php echo $leng["trabajador"];?> </legend>
     <table width="80%" align="center">
   <tr>
      <td class="etiqueta">Codigo:</td>
      <td>
      	<input type="text" name="codigo" value="<?php echo $codigo;?>" readonly="true" style="width:120px"/></td>
    </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng["ficha"];?>:</td>
      <td id="input03"><input type="text" name="cod_emp" maxlength="17" style="width:120px" />
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span> </td>
	 </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng["ci"];?>:</td>
      <td id="input02"><input type="text" name="cedula" maxlength="12" style="width:120px" />
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta">Apellidos y Nombres:</td>
      <td id="input01"><input type="text" name="nombre" maxlength="60" style="width:250px" />
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
	 </tr>
	 <tr>
      <td class="etiqueta">Fecha de Nacimiento:</td>
      <td id="fecha02">
          	<input type="text" name="fecha_nac" />
            <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
            <span class="textfieldRequiredMsg">La Fecha Es Requerida.</span>
            <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Fotos Carnet (jpeg):</td>
      <td id="input07"><input type="file" name="file" id="file" style="width:355px"/>
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta">Posee Carnet:</td>
      <td id="radio01" class="texto">SI
            <input type = "radio" name="carnet"  value = "S" style="width:auto" />
          NO<input type = "radio" name="carnet"  value = "N" style="width:auto" />															 	         <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/>
            <span class="radioRequiredMsg">Debe seleccionar un Campo.</span>
        </td>
    </tr>
    <tr>
      <td class="etiqueta">Fecha Vencimiento Carnet:</td>
      <td id="fecha04">
          	<input type="text" name="fecha_carnet" value="<?php echo $date;?>"/>
            <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
            <span class="textfieldRequiredMsg">La Fecha Es Requerida.</span>
            <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Fecha de Ingreso:</td>
      <td id="fecha01">
          	<input type="text" name="fecha_ing" />
            <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
            <span class="textfieldRequiredMsg">La Fecha Es Requerida.</span>
            <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Sexo:</td>
      <td id="radio02" class="texto">
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
      <input type="texto" name="telefono" style="width:350px" maxlength="55"/>
      <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
      <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 11 caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Direcci&oacute;n De Habitaci&oacute;n:</td>
      <td id="textarea01"><textarea  name="direccion" cols="45" rows="3"></textarea>
        <span id="Counterror_mess1" class="texto">&nbsp;</span>
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 10 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
    </tr>
   <tr>
      <td class="etiqueta">Cargo:</td>
      	<td id="select01"><select name="cargo" style="width:220px">
							<option value="">Seleccione...</option>
          <?php
						$query05 = mysql_query("SELECT cargos.id, cargos.descripcion FROM cargos
                                                 WHERE cargos.status = '1' ORDER BY 2 ASC",$cnn);
						  while($row05=mysql_fetch_array($query05)){
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	</tr>
   <tr>
      <td class="etiqueta"><?php echo $leng["contrato"];?>:</td>
      	<td id="select02"><select name="contracto" style="width:220px">
							<option value="">Seleccione...</option>
          <?php
						$query05 = mysql_query("SELECT co_cont, des_cont FROM nomina WHERE tip_cont = 2
						                         ORDER BY des_cont ASC",$cnn);
						  while($row05=mysql_fetch_array($query05))
						  {
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	</tr>
    <tr>
      <td class="etiqueta"><?php echo $leng["region"];?>:</td>
      	<td id="select03"><select name="departamento" style="width:220px">
							<option value="">Seleccione...</option>
          <?php
						$query05 = mysql_query("SELECT * FROM regiones WHERE status = 1 ORDER BY 2 ASC",$cnn);
						  while($row05=mysql_fetch_array($query05))
						  {
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	</tr>
   <tr>
      <td class="etiqueta">Banco:</td>
      	<td id="select04"><select name="banco" style="width:220px">
							<option value="">Seleccione...</option>
          <?php
						$query05 = mysql_query("SELECT bancos.id, bancos.descripcion FROM bancos
						                         WHERE bancos.status = '1' ORDER BY 2 ASC",$cnn);
						  while($row05=mysql_fetch_array($query05))
						  {
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	</tr>
	 <tr>
      <td class="etiqueta">Cta. Banco:</td>
      <td id="input05"><input type="text" name="cta_banco" maxlength="20" style="width:200px" />
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir 20 caracteres.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng["psic_fec"];?>:</td>
      <td>
			<span id="fecha03">
          	<input type="text" name="fec_psi" />&nbsp;&nbsp; Apto
			</span>
			<span id="radio02">
			<input name="psi_apto" type="radio" value="S" style="width:auto"  disabled="disabled"/>&nbsp;&nbsp; No Apto
			<input name="psi_apto" type="radio" value="N" style="width:auto"  disabled="disabled"/>&nbsp;&nbsp; Condicional
			<input name="psi_apto" type="radio" value="C" style="width:auto"  disabled="disabled"/>
      		<span class="radioRequiredMsg">Seleccione...</span>
			</span>
	  </td>
    </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng["pol_fec"];?>:</td>
      <td>
		  <span id="fecha04">
          	<input type="text" name="fec_pol" readonly="true"/>&nbsp;&nbsp; Apto
			</span>
			<span id="radio03">
			<input name="pol_apto" type="radio"  value="S" style="width:auto" disabled="disabled"/>&nbsp;&nbsp; No Apto
			<input name="pol_apto"  type="radio" value="N" style="width:auto" disabled="disabled" />
			<span class="radioRequiredMsg">Seleccione...</span>
			</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Fecha de Recepcion Profit:</td>
      <td id="fecha05">
	      	<input type="text" name="fec_profit" readonly="true"/>
      </td>
    </tr>
<?php
/*
	<tr>
	     <td height="20" class="etiqueta">Status:</td>
	     <td  id="select01">
			   <select name="status" style="width:120px;">
			   		   <option value="<?php echo $row01[12];?>"><?php echo statuscal($row01[12]);?></option>
     				   <option value="1"> Activo </option>
                       <option value="2"> Inactivo </option>
	           </select><img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
*/?>
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
		    <input name="archivo" type="hidden"  value="agregar" />
	        <input name="href" type="hidden" value="../inicio.php?area=pestanas/Mod_<?php echo $archivo ?>" />
			<input type="hidden"  name="usuario" id="usuario" value="<?php echo $usuario;?>"/>
		     </td>
	   </tr>
  </table>
  </fieldset>
</form>

<script type="text/javascript">
var input01 = new Spry.Widget.ValidationTextField("input01", "none", {minChars:4, validateOn:["blur", "change"]});
var input02 = new Spry.Widget.ValidationTextField("input02", "none", {minChars:4, validateOn:["blur", "change"]});
var input03 = new Spry.Widget.ValidationTextField("input03", "none", {minChars:2, validateOn:["blur", "change"], isRequired:false});

var input05 = new Spry.Widget.ValidationTextField("input05", "integer", {minChars:20, validateOn:["blur", "change"], isRequired:false});

var fecha01 = new Spry.Widget.ValidationTextField("fecha01", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAA",
    validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});

var fecha02 = new Spry.Widget.ValidationTextField("fecha02", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAA",
    validateOn:["blur", "change"], useCharacterMasking:true});
var fecha03 = new Spry.Widget.ValidationTextField("fecha03", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAA",
    validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});
var fecha04 = new Spry.Widget.ValidationTextField("fecha04", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAA",
    validateOn:["blur", "change"], useCharacterMasking:true});

var radio01 = new Spry.Widget.ValidationRadio("radio01", { validateOn:["change", "blur"]});
var radio02 = new Spry.Widget.ValidationRadio("radio02", { validateOn:["change", "blur"]});


var telefono01  = new Spry.Widget.ValidationTextField("telefono01", "none", {minChars:11, validateOn:["blur", "change"]});

var textarea01 = new Spry.Widget.ValidationTextarea("textarea01", {maxChars:255, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess1", useCharacterMasking:false});

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});
var select03 = new Spry.Widget.ValidationSelect("select03", {validateOn:["blur", "change"]});
var select04 = new Spry.Widget.ValidationSelect("select04", {validateOn:["blur", "change"]});
</script>
