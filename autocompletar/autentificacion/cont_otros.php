	<table width="80%" align="center">
         <tr valign="top">
		     <td height="23" colspan="2" class="etiqueta_title" align="center">OTROS CONTROLES </td>
         </tr>
         <tr><td height="8" colspan="2" align="center"><hr></td></tr>
      <tr>
	<td  width="40%"class="etiqueta">Activar <?php echo $leng['cliente']?> Campo 04:</td>
	<td width="60%">SI<input type = "radio" name="cl_campo_04"  value = "T"  style="width:auto" <?php echo CheckX($cl_campo_04_act, "T");?> /> NO<input type = "radio" name="cl_campo_04"  value = "F" style="width:auto" <?php echo CheckX($cl_campo_04_act, "F");?>  /></td>
    </tr>
    <tr>
      <td class="etiqueta">Descripcion <?php echo $leng['cliente']?>  <?php echo $leng['ubicacion']?>. Campo 04:</td>
      <td id="input_3_01"><input type="text" name="cl_campo_04_d" maxlength="30" size="40" value="<?php echo $cl_campo_04_desc;?>" />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta">Url De Documentos:</td>
      <td id="input_3_02"><input type="text" name="url_doc" maxlength="60" size="40" value="<?php echo $url_doc;?>" />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
	 </tr>
     <tr>
      <td class="etiqueta">Nota De Uniformes :</td>
      <td id="textarea_3_01"><textarea  name="nota_unif" cols="50" rows="3"><?php echo $nota_unif;?></textarea>
        <span id="Counterror_mess2" class="texto">&nbsp;</span><br />
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 120.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta">Nota De Documentos :</td>
      <td id="textarea_3_02"><textarea  name="nota_doc" cols="50" rows="3"><?php echo $nota_doc;?></textarea>
        <span id="Counterror_mess2" class="texto">&nbsp;</span><br />
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 120.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta">Reporte Operacional (Meses Activos):</td>
      <td id="textarea_3_02"><input type="number" name="rop_meses"  required value="<?php echo $rop_meses;?>" maxlength="6" min="2"></td>
	 </tr>


	 <tr><td height="8" colspan="2" align="center"><hr></td></tr>
   </table>
   <div align="center"><span class="art-button-wrapper">
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
 </div>
<script type="text/javascript">
var textarea_3_01 = new Spry.Widget.ValidationTextarea("textarea_3_01", {maxChars:255, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess1", useCharacterMasking:false});
var textarea_3_02 = new Spry.Widget.ValidationTextarea("textarea_3_02", {maxChars:255, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess1", useCharacterMasking:false});
</script>
