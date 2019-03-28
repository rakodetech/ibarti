  <fieldset class="fieldset">
  <legend>DATOS ADICCIONALES <?php echo $titulo;?> </legend>
     <table width="80%" align="center">
  	        	    
    <tr>
      <td class="etiqueta">Campo adiccional 01: </td>
      <td id="campo01"><input type="text" name="campo01" id="campo01" maxlength="60" style="width:300px" 
                              value="<?php echo $campo01;?>" /><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Campo adiccional 02: </td>
      <td id="campo02"><input type="text" name="campo02" id="campo02" maxlength="60" style="width:300px" 
                              value="<?php echo $campo02;?>" /><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Campo adiccional 03: </td>
      <td id="campo03"><input type="text" name="campo03" id="campo03" maxlength="60" style="width:300px" 
                              value="<?php echo $campo03;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr> 
    <tr>
      <td class="etiqueta">Campo adiccional 04: </td>
      <td id="campo04"><input type="text" name="campo04" id="campo04" maxlength="60" style="width:300px" 
                              value="<?php echo $campo04;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>           
	 <tr> 
         <td height="8" colspan="2" align="center"><hr></td>
     </tr>	
  </table>
<span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="button" name="salvar"  id="salvar" value="Guardar" onclick="guardar_registro()" class="readon art-button" /> 
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
  </fieldset>
<script type="text/javascript">
	var campo01  = new Spry.Widget.ValidationTextField("campo01", "none", {validateOn:["blur", "change"],isRequired:false});
	var campo02  = new Spry.Widget.ValidationTextField("campo02", "none", {validateOn:["blur", "change"],isRequired:false});
	var campo03  = new Spry.Widget.ValidationTextField("campo03", "none", {validateOn:["blur", "change"],isRequired:false});
	var campo04  = new Spry.Widget.ValidationTextField("campo04", "none", {validateOn:["blur", "change"],isRequired:false});
</script>