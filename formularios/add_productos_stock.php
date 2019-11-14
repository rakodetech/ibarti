  <fieldset class="fieldset">
  <legend>SOCTK <?php echo $titulo;?> </legend>
     <table width="80%" align="center"> 	        	        
   <tr>
      <td class="etiqueta" style="width:25%">Costo Actual: </td>
      <td id="input20" style="width:25%"><input type="text" name="cos_actual" maxlength="12" style="width:120px" 
                              value="<?php echo $cos_actual;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
      <td class="etiqueta" style="width:25%">Fecha Costo Actual: </td>
      <td id="fecha20" style="width:25%"><input type="text" name="fec_cos_actual" maxlength="60" style="width:120px" 
                              value="<?php echo $fec_cos_actual;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>

    </tr>     
   <tr>
      <td class="etiqueta">Costo Promedio: </td>
      <td id="input21"><input type="text" name="cos_promedio" maxlength="12" style="width:120px" 
                              value="<?php echo $cos_promedio;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
      <td class="etiqueta">Fecha Costo Promedio: </td>
      <td id="fecha21"><input type="text" name="fec_cos_prom" maxlength="60" style="width:120px" 
                              value="<?php echo $fec_cos_prom;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>    	        	    
   <tr>
      <td class="etiqueta">Ultimo Costo: </td>
      <td id="input22"><input type="text" name="cos_ultimo" maxlength="12" style="width:120px" 
                              value="<?php echo $cos_ultimo;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
      <td class="etiqueta">Fecha Ultimo Costo: </td>
      <td id="fecha22"><input type="text" name="fec_cos_ultimo" maxlength="60" style="width:120px" 
                              value="<?php echo $fec_cos_ultimo;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr> 
   <tr>
      <td class="etiqueta">Stock Actual: </td>
      <td id="input23"><input type="text" name="stock_actual" maxlength="12" style="width:120px" 
                              value="<?php echo $stock_actual;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
      <td class="etiqueta">Stock Comprometido: </td>
      <td id="input24"><input type="text" name="stock_comp" maxlength="60" style="width:120px" 
                              value="<?php echo $stock_comp;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
     </tr>  
   <tr>
      <td class="etiqueta">Stock Por Llegar: </td>
      <td id="input25"><input type="text" name="stock_llegar" maxlength="12" style="width:120px" 
                              value="<?php echo $stock_llegar;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
      <td class="etiqueta">Punto De Pedido: </td>
      <td id="input26"><input type="text" name="punto_pedido" maxlength="12" style="width:120px" 
                              value="<?php echo $punto_pedido;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr> 
   <tr>
      <td class="etiqueta">Stock Maximo : </td>
      <td id="input27"><input type="text" name="stock_maximo" maxlength="12" style="width:120px" 
                              value="<?php echo $stock_maximo;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
      <td class="etiqueta">Stock Minimo: </td>
      <td id="input28"><input type="text" name="stock_minimo" maxlength="12" style="width:120px" 
                              value="<?php echo $stock_minimo;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr> 
	 <tr> 
         <td height="8" colspan="4" align="center"><hr></td>
     </tr>	
     <tr> 
         <td colspan="4" align="center">
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
         </td>
   </tr>
  </table>
  </fieldset>

  <script type="text/javascript">
var input20  = new Spry.Widget.ValidationTextField("input20","currency", {format:"comma_dot", validateOn:["blur", "change"], useCharacterMasking:true ,isRequired:false}); 
var input21  = new Spry.Widget.ValidationTextField("input21","currency", {format:"comma_dot", validateOn:["blur", "change"], useCharacterMasking:true ,isRequired:false}); 
var input22  = new Spry.Widget.ValidationTextField("input22","currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});
var input23  = new Spry.Widget.ValidationTextField("input23","currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});
var input24  = new Spry.Widget.ValidationTextField("input24","currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});
var input25  = new Spry.Widget.ValidationTextField("input25","currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});
var input26  = new Spry.Widget.ValidationTextField("input26","currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});
var input27  = new Spry.Widget.ValidationTextField("input27","currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});
var input28  = new Spry.Widget.ValidationTextField("input28","currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});

var fecha20 = new Spry.Widget.ValidationTextField("fecha20", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA", 
    validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});	
var fecha21 = new Spry.Widget.ValidationTextField("fecha21", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA", 
    validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});	
var fecha22 = new Spry.Widget.ValidationTextField("fecha22", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA", 
    validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});			
</script>

