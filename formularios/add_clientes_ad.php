  <fieldset class="fieldset">
  <legend>Datos Adiccionales <?php echo $leng['cliente'];?> </legend>
     <table width="100%" align="center">

   <tr>
      <td width="18%" class="etiqueta">Limite de Credito: </td>
      <td width="32%" id="input10"><input type="text" name="limite_cred" maxlength="60" size="20" value="<?php echo $limite_cred;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>

      <td width="18%" class="etiqueta">Dias Plazo Pago: </td>
      <td width="32%" id="input11"><input type="text" name="plazo_pago" maxlength="60" size="20" value="<?php echo $plazo_pago;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
   <tr>
      <td class="etiqueta">Descuento Pronto Pago: </td>
      <td id="input12"><input type="text" name="desc_p_pago" maxlength="60" size="20" value="<?php echo $desc_p_pago;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
      <td class="etiqueta">Descuento Global: </td>
      <td id="input13"><input type="text" name="desc_global" maxlength="60" size="20" value="<?php echo $desc_global;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Direcci&oacute;n de Entrega:</td>
      <td id="textarea03"><textarea  name="dir_entrega" cols="35" rows="4"><?php echo $dir_entrega;?></textarea>
        <span id="Counterror_mess3" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 300.</span></td>

      <td class="etiqueta">Dias de Visitas: </td>
      <td id="input05">
      	<table width="100%" border="0">
          <tr>
            <td width="50%" >Lunes:<input type="checkbox" name="lunes"  <?php echo statusCheck("$lunes");?> value="T" /></td>
            <td width="50%">Martes:<input type="checkbox" name="martes"  <?php echo statusCheck("$martes");?> value="T" /></td>
          </tr>
          <tr>
            <td>Miercoles: <input name="miercoles" type="checkbox"  <?php echo statusCheck("$miercoles");?> value="T" /></td>
            <td>jueves: <input name="jueves" type="checkbox"  <?php echo statusCheck("$jueves");?> value="T" /></td>
          </tr>
          <tr>
            <td>Viernes: <input name="viernes" type="checkbox"  <?php echo statusCheck("$viernes");?> value="T" /></td>
            <td>Sabado: <input name="sabado" type="checkbox"  <?php echo statusCheck("$sabado");?> value="T" /></td>
          </tr>
          <tr>
            <td colspan="2">Domingo: <input name="domingo" type="checkbox"  <?php echo statusCheck("$domingo");?> value="T" /></td>
          </tr>
		</table>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Campo adiccional 01: </td>
      <td id="campo01"><input type="text" name="campo01" maxlength="60" size="35" value="<?php echo $campo01;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>

      <td class="etiqueta">Campo adiccional 02: </td>
      <td id="campo02"><input type="text" name="campo02" maxlength="60" size="35" value="<?php echo $campo02;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Campo adiccional 03: </td>
      <td id="campo03"><input type="text" name="campo03" maxlength="60" size="35" value="<?php echo $campo03;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
      <td class="etiqueta">Campo adiccional 04: </td>
      <td id="campo04"><input type="text" name="campo04" maxlength="60" size="35" value="<?php echo $campo04;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
	 <tr>
         <td height="8" colspan="4" align="center"><hr></td>
     </tr>
  </table>
<div align="center">
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
                <input type="button" id="volver" value="Volver" onClick="Vinculo('<?php echo $inicio;?>')" class="readon art-button" />
                </span>
</div>
  </fieldset>
</form>

<script type="text/javascript">

var input01  = new Spry.Widget.ValidationTextField("input10", "currency", {format:"comma_dot", validateOn:["blur", "change"], useCharacterMasking:true ,isRequired:false });
var input11  = new Spry.Widget.ValidationTextField("input11", "integer", {validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});
var input12  = new Spry.Widget.ValidationTextField("input12", "currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});
var input13  = new Spry.Widget.ValidationTextField("input13","currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});

var textarea03 = new Spry.Widget.ValidationTextarea("textarea03", {maxChars:300, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess3", useCharacterMasking:false ,isRequired:false});

var campo01  = new Spry.Widget.ValidationTextField("campo01", "none", {validateOn:["blur", "change"],isRequired:false});
var campo02  = new Spry.Widget.ValidationTextField("campo02", "none", {validateOn:["blur", "change"],isRequired:false});
var campo03  = new Spry.Widget.ValidationTextField("campo03", "none", {validateOn:["blur", "change"],isRequired:false});
var campo04  = new Spry.Widget.ValidationTextField("campo04", "none", {validateOn:["blur", "change"],isRequired:false});
</script>
