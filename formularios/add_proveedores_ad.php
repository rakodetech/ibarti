  <fieldset class="fieldset">
  <legend>DATOS ADICCIONALES <?php echo $titulo;?> </legend>
     <table width="80%" align="center">
   	        
   <tr>
      <td class="etiqueta">Dias de Creditos: </td>
      <td id="input10"><input type="text" name="dias_credito" maxlength="60" style="width:150px" 
                              value="<?php echo $dias_credito;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>   
   <tr>
      <td class="etiqueta">Limite de Credito: </td>
      <td id="input11"><input type="text" name="lim_credito" maxlength="60" style="width:150px" 
                              value="<?php echo $lim_credito;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>    	        	    
   <tr>
      <td class="etiqueta">Dias Plazo Pago: </td>
      <td id="input12"><input type="text" name="plazo_pago" maxlength="60" style="width:150px" 
                              value="<?php echo $plazo_pago;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>    	        	    
   <tr>
      <td class="etiqueta">Descuento Pronto Pago: </td>
      <td id="input13"><input type="text" name="desc_pago" maxlength="60" style="width:150px" 
                              value="<?php echo $desc_pago;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>    	        	    
   <tr>
      <td class="etiqueta">Descuento Global: </td>
      <td id="input14"><input type="text" name="desc_global" maxlength="60" style="width:150px" 
                              value="<?php echo $desc_global;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>    	        	    
    </tr>    	        	    
    <tr>
      <td class="etiqueta">Campo adiccional 01: </td>
      <td id="campo01"><input type="text" name="campo01" maxlength="60" style="width:300px" 
                              value="<?php echo $campo01;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Campo adiccional 02: </td>
      <td id="campo02"><input type="text" name="campo02" maxlength="60" style="width:300px" 
                              value="<?php echo $campo02;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Campo adiccional 03: </td>
      <td id="campo03"><input type="text" name="campo03" maxlength="60" style="width:300px" 
                              value="<?php echo $campo03;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr> 
    <tr>
      <td class="etiqueta">Campo adiccional 04: </td>
      <td id="campo04"><input type="text" name="campo04" maxlength="60" style="width:300px" 
                              value="<?php echo $campo04;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>           
	 <tr> 
         <td height="8" colspan="2" align="center"><hr></td>
     </tr>	
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
  </fieldset>

  <script type="text/javascript">
var input10  = new Spry.Widget.ValidationTextField("input10", "integer", {validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});
var input11  = new Spry.Widget.ValidationTextField("input11", "currency", {format:"comma_dot", validateOn:["blur", "change"], useCharacterMasking:true ,isRequired:false}); 
var input12  = new Spry.Widget.ValidationTextField("input12", "integer", {validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});
var input13  = new Spry.Widget.ValidationTextField("input13", "currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});
var input14  = new Spry.Widget.ValidationTextField("input14","currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});
 
var campo01  = new Spry.Widget.ValidationTextField("campo01", "none", {validateOn:["blur", "change"],isRequired:false});
var campo02  = new Spry.Widget.ValidationTextField("campo02", "none", {validateOn:["blur", "change"],isRequired:false});
var campo03  = new Spry.Widget.ValidationTextField("campo03", "none", {validateOn:["blur", "change"],isRequired:false});
var campo04  = new Spry.Widget.ValidationTextField("campo04", "none", {validateOn:["blur", "change"],isRequired:false});
</script>

