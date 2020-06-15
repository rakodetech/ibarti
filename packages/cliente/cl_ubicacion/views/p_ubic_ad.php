<script language="javascript">

$("#ub_form_ad").on('submit', function(evt){
	 evt.preventDefault();
	 save_ubic();
});
</script>
<form id="ub_form_ad" name="ub_form_ad" method="post">
<fieldset class="fieldset">
<legend>Adiccional<?php echo $titulo;?> </legend>
   <table width="80%" align="center">

  <tr>
    <td class="etiqueta">Campo adiccional 01: </td>
    <td ><input type="text" id="ub_campo01" maxlength="60" size="35"
                            value="<?php echo $ubic["campo01"];?>"/><br />
     <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
    </td>
  </tr>
  <tr>
    <td class="etiqueta">Campo adiccional 02: </td>
    <td ><input type="text"  id="ub_campo02" maxlength="60" size="35"
                            value="<?php echo $ubic["campo02"];?>"/><br />
     <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
    </td>
  </tr>
  <tr>
    <td class="etiqueta">Campo adiccional 03: </td>
    <td ><input type="text" id="ub_campo03" maxlength="60" size="35"
                            value="<?php echo $ubic["campo03"];?>"/><br />
     <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
    </td>
  </tr>
  <tr>
    <td class="etiqueta">Campo adiccional 04: </td>
    <td><input type="text" id="ub_campo04" maxlength="60" size="35"
                            value="<?php echo $ubic["campo04"];?>"/><br />
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
     <input type="submit" name="salvar2"  id="salvar2" value="Guardar" class="readon art-button" />
  </span>&nbsp;

              </span>&nbsp;
           <span class="art-button-wrapper">
                  <span class="art-button-l"> </span>
                  <span class="art-button-r"> </span>
              <input type="reset" id="limpiar" value="Restablecer" class="readon art-button" />
              </span>&nbsp;
           <span class="art-button-wrapper">
                  <span class="art-button-l"> </span>
                  <span class="art-button-r"> </span>
              <input type="button" value="Volver" onClick="CloseModal();" class="readon art-button" />
              </span></div>

</fieldset>
</form>
