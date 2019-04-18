  <fieldset class="fieldset">
    <legend>DATOS ADICCIONALES</legend>
    <table width="80%" align="center">

     <tr>
      <td class="etiqueta">Garantia: </td>
      <td id="input10"><input type="text" name="garantia" id="garantia" maxlength="60" style="width:150px"
        value="<?php echo $prod['garantia'];?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
   <!-- <tr>
      <td class="etiqueta">Talla: </td>
      <td id="input11"><input type="text" name="talla" id="talla" maxlength="60" style="width:150px"
        value="<?php //echo $prod['talla'];?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>-->
    <tr>
      <td class="etiqueta">Peso: </td>
      <td id="input12"><input type="text" name="peso" id="peso" maxlength="60" style="width:150px"
        value="<?php echo $prod['peso'];?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Piecubico: </td>
      <td id="input13"><input type="text" name="piecubico" id="piecubico" maxlength="60" style="width:150px"
        value="<?php echo $prod['piecubico'];?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Vencimiento: </td>
      <td id="radio11" class="texto">SI
        <input type = "radio" name="venc" value = "T" style="width:auto" <?php echo CheckX($prod['vencimiento'], 'T') ?> />
        NO<input type = "radio" name="venc" value = "F" style="width:auto" <?php echo CheckX($prod['vencimiento'], 'F') ?> />
        <span class="radioRequiredMsg">Debe seleccionar un Campo.</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Fecha Vencimiento: </td>
      <td id="fecha11">
       <input type="text" name="fec_venc" id="fec_venc" value="<?php echo $prod['fec_vencimiento'];?>"/><br />
       <span class="textfieldRequiredMsg">La Fecha Es Requerida.</span>
       <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span>
     </td>
   </tr>
   <tr>
    <td class="etiqueta">Campo adiccional 01: </td>
    <td><input type="text" name="campo01" id="campo01" maxlength="60" style="width:300px"
      value="<?php echo $prod['campo01'];?>"/><br />
      <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
    </td>
  </tr>
  <tr>
    <td class="etiqueta">Campo adiccional 02: </td>
    <td><input type="text" name="campo02" id="campo02" maxlength="60" style="width:300px"
      value="<?php echo $prod['campo02'];?>"/><br />
      <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
    </td>
  </tr>
  <tr>
    <td class="etiqueta">Campo adiccional 03: </td>
    <td><input type="text" name="campo03" id="campo03" maxlength="60" style="width:300px"
      value="<?php echo $prod['campo03'];?>"/><br />
      <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
    </td>
  </tr>
  <tr>
    <td class="etiqueta">Campo adiccional 04: </td>
    <td><input type="text" name="campo04" id="campo04" maxlength="60" style="width:300px"
      value="<?php echo $prod['campo04'];?>"/><br />
      <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
    </td>
  </tr>
  <tr>
   <td height="8" colspan="2" align="center"><hr></td>
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
  var input10  = new Spry.Widget.ValidationTextField("input10", "none", {validateOn:["blur", "change"], isRequired:false});
  var input11  = new Spry.Widget.ValidationTextField("input11", "none", {validateOn:["blur", "change"], isRequired:false});
  var input12  = new Spry.Widget.ValidationTextField("input12","currency", {format:"comma_dot", validateOn:["blur", "change"], useCharacterMasking:true ,isRequired:false});
  var input13  = new Spry.Widget.ValidationTextField("input13","currency", {format:"comma_dot", validateOn:["blur", "change"], useCharacterMasking:true ,isRequired:false});

  var radio11 = new Spry.Widget.ValidationRadio("radio11", { validateOn:["change", "blur"]});

  var fecha11 = new Spry.Widget.ValidationTextField("fecha11", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA",
    validateOn:["blur", "change"], useCharacterMasking:true});

  var campo01  = new Spry.Widget.ValidationTextField("campo01", "none", {validateOn:["blur", "change"],isRequired:false});
  var campo02  = new Spry.Widget.ValidationTextField("campo02", "none", {validateOn:["blur", "change"],isRequired:false});
  var campo03  = new Spry.Widget.ValidationTextField("campo03", "none", {validateOn:["blur", "change"],isRequired:false});
  var campo04  = new Spry.Widget.ValidationTextField("campo04", "none", {validateOn:["blur", "change"],isRequired:false});
</script>
