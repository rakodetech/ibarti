  <fieldset class="fieldset">
  <legend>DATOS ADICCIONALES <?php echo $titulo;?> </legend>
     <table width="80%" align="center">

    <tr>
      <td class="etiqueta">Campo adiccional 01: </td>
      <td ><input type="text" name="campo01" id="campo01" maxlength="60" size="35"
                              value="<?php echo $campo01;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Campo adiccional 02: </td>
      <td ><input type="text" name="campo02" id="campo02" maxlength="60" size="35"
                              value="<?php echo $campo02;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Campo adiccional 03: </td>
      <td ><input type="text" name="campo03" id="campo03" maxlength="60" size="35"
                              value="<?php echo $campo03;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Campo adiccional 04: </td>
      <td><input type="text" name="campo04" id="campo04" maxlength="60" size="35"
                              value="<?php echo $campo04;?>"/><br />
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
                <input type="button" id="volver" value="Volver" onClick="CloseModal();" class="readon art-button" />
                </span></div>

  </fieldset>
  </form>
