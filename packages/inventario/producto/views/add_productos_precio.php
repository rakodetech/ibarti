  <fieldset class="fieldset">
    <legend>Precio Producto</legend>
    <table width="80%" align="center"> 	        	        
     <tr>
      <td class="etiqueta" style="width:25%">Precio Unitario 1: </td>
      <td id="input30" style="width:25%"><input type="text" name="prec_vta1" id="prec_vta1" maxlength="12" style="width:120px" value="<?php echo $prod['prec_vta1'];?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
      <td class="etiqueta" style="width:25%">Fecha Precio 1: </td>
      <td id="fecha20" style="width:25%"><input type="text" name="fec_prec_v1" id="fec_prec_v1" maxlength="60" style="width:120px" value="<?php echo $prod['fec_prec_v1'];?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>     
    <tr>
      <td class="etiqueta">Precio Unitario 2: </td>
      <td id="input31"><input type="text" name="prec_vta2" id="prec_vta2" maxlength="12" style="width:120px" 
        value="<?php echo $prod['prec_vta2'];?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
      <td class="etiqueta">Fecha Precio 2: </td>
      <td id="fecha20"><input type="text" name="fec_prec_v2" id="fec_prec_v2" maxlength="60" style="width:120px" 
        value="<?php echo $prod['fec_prec_v2'];?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>    	        	    
    <tr>
      <td class="etiqueta">Precio Unitario 3: </td>
      <td id="input32"><input type="text" name="prec_vta3" id="prec_vta3" maxlength="12" style="width:120px" 
        value="<?php echo $prod['prec_vta3'];?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
      <td class="etiqueta">Fecha Precio 3: </td>
      <td id="fecha20"><input type="text" name="fec_prec_v3" id="fec_prec_v3" maxlength="60" style="width:120px" 
        value="<?php echo $prod['fec_prec_v3'];?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>    	        	    
    <tr>
      <td class="etiqueta">Precio Unitario 4: </td>
      <td id="input33"><input type="text" name="prec_vta4" id="prec_vta4" maxlength="12" style="width:120px" 
        value="<?php echo $prod['prec_vta4'];?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
      <td class="etiqueta">Fecha Precio 4: </td>
      <td id="fecha20"><input type="text" name="fec_prec_v4" id="fec_prec_v4" maxlength="60" style="width:120px" 
        value="<?php echo $prod['fec_prec_v4'];?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr> 
    <tr>
      <td class="etiqueta">Precio Unitario 5: </td>
      <td id="input34"><input type="text" name="prec_vta5" id="prec_vta5" maxlength="12" style="width:120px" 
        value="<?php echo $prod['prec_vta5'];?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
      <td class="etiqueta">Fecha Precio 5: </td>
      <td id="fecha20"><input type="text" name="fec_prec_v5" id="fec_prec_v5" maxlength="60" style="width:120px" 
        value="<?php echo $prod['fec_prec_v5'];?>"/><br />
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
  </span>
</div>  
</fieldset>
<script type="text/javascript">
  var input30  = new Spry.Widget.ValidationTextField("input30", "currency", {format:"comma_dot", validateOn:["blur", "change"], useCharacterMasking:true ,isRequired:false}); 
  var input31  = new Spry.Widget.ValidationTextField("input31", "currency", {format:"comma_dot", validateOn:["blur", "change"], useCharacterMasking:true ,isRequired:false}); 
  var input32  = new Spry.Widget.ValidationTextField("input32", "currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});
  var input33  = new Spry.Widget.ValidationTextField("input33", "currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});
  var input34  = new Spry.Widget.ValidationTextField("input34", "currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});
</script>