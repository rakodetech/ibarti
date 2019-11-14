<?php require_once('autentificacion/aut_verifica_menu.php'); ?>
<fieldset class="fieldset">
  <legend>REFERENCIAS PERSONALES</legend>
  <table width="100%" align="center">
    <tr>
      <td class="etiqueta">Nombre:</td>
      <td id="input01_2"><input type="text" name="refp01_nombre" maxlength="120" size="22" value="<?php echo $refp01_nombre; ?>" /></td>
      <td class="etiqueta">Ocupación: </td>
      <td id="input02_2"><input type="text" name="refp01_ocupacion" maxlength="60" size="22" value="<?php echo $refp01_ocupacion; ?>" /></td>
    </tr>
    <tr>
      <td class="etiqueta">N. Telefono: </td>
      <td id="input03_2"><input type="text" name="refp01_telf" maxlength="60" size="20" value="<?php echo $refp01_telf; ?>" /></td>
      <td class="etiqueta">Parentesco: </td>
      <td id="input04_2"><input type="text" name="refp01_parentezco" maxlength="60" size="20" value="<?php echo $refp01_parentezco; ?>" /> </td>
    </tr>
    <tr>
      <td class="etiqueta">Dirección: </td>
      <td id="textarea01_2"><textarea name="refp01_direccion" cols="40" rows="2"><?php echo $refp01_direccion; ?></textarea>
        <span id="Counterror_mess01_2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
      <td class="etiqueta">Observaci&oacute;n: </td>
      <td id="textarea02_2"><textarea name="refp01_observacion" cols="40" rows="2" readonly="readonly"><?php echo $refp01_observacion; ?></textarea>
        <span id="Counterror_mess02_2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td class="etiqueta">Status: </td>
      <td id="radio01_2">&nbsp;&nbsp; <?php echo $leng["aceptado"]; ?>
        <input name="refp01_apto" type="radio" value="S" style="width:auto" <?php echo CheckX($refp01_apto, 'S'); ?> disabled="disabled" />&nbsp;&nbsp; <?php echo $leng["rechazado"]; ?>
        <input name="refp01_apto" type="radio" value="N" style="width:auto" <?php echo CheckX($refp01_apto, 'N'); ?> disabled="disabled" />&nbsp;&nbsp; <?php echo $leng["pendiente"]; ?>
        <input name="refp01_apto" type="radio" value="P" style="width:auto" <?php echo CheckX($refp01_apto, 'P'); ?> disabled="disabled" /><br /><span class="radioRequiredMsg">Seleccione...</span>
        <input type="hidden" name="refp01_apto" value="<?php echo $refp01_apto; ?>" /></td>
    <tr>
    <tr>
      <td height="8" colspan="6" align="center">
        <hr>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Nombre:</td>
      <td id="input05_2"><input type="text" name="refp02_nombre" maxlength="120" size="22" value="<?php echo $refp02_nombre; ?>" /></td>
      <td class="etiqueta">Ocupación: </td>
      <td id="input06_2"><input type="text" name="refp02_ocupacion" maxlength="60" size="22" value="<?php echo $refp02_ocupacion; ?>" /></td>
    </tr>
    <tr>
      <td class="etiqueta">N. Telefono: </td>
      <td id="input07_2"><input type="text" name="refp02_telf" maxlength="60" size="20" value="<?php echo $refp02_telf; ?>" /></td>
      <td class="etiqueta">Parentesco: </td>
      <td id="input08_2"><input type="text" name="refp02_parentezco" maxlength="60" size="20" value="<?php echo $refp02_parentezco; ?>" /> </td>
    </tr>
    <tr>
      <td class="etiqueta">Dirección:</td>
      <td id="textarea03_2"><textarea name="refp02_direccion" cols="40" rows="2"><?php echo $refp02_direccion; ?></textarea>
        <span id="Counterror_mess03_2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
      <td class="etiqueta">Observaci&oacute;n:</td>
      <td id="textarea04_2"><textarea name="refp02_observacion" cols="40" rows="2" readonly="readonly"><?php echo $refp02_observacion; ?></textarea>
        <span id="Counterror_mess04_2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td class="etiqueta">Status: </td>
      <td id="radio02_2">&nbsp;&nbsp; <?php echo $leng["aceptado"]; ?>
        <input name="refp02_apto" type="radio" value="S" style="width:auto" <?php echo CheckX($refp02_apto, 'S'); ?> disabled="disabled" />&nbsp;&nbsp; <?php echo $leng["rechazado"]; ?>
        <input name="refp02_apto" type="radio" value="N" style="width:auto" <?php echo CheckX($refp02_apto, 'N'); ?> disabled="disabled" />&nbsp;&nbsp; <?php echo $leng["pendiente"]; ?>
        <input name="refp02_apto" type="radio" value="P" style="width:auto" <?php echo CheckX($refp02_apto, 'P'); ?> disabled="disabled" /><br /><span class="radioRequiredMsg">Seleccione...</span>
        <input type="hidden" name="refp02_apto" value="<?php echo $refp02_apto; ?>" /></td>
    </tr>
    <tr>
      <td height="8" colspan="6" align="center">
        <hr>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Nombre: </td>
      <td id="input09_2"><input type="text" name="refp03_nombre" maxlength="120" size="22" value="<?php echo $refp03_nombre; ?>" /></td>
      <td class="etiqueta">Ocupación: </td>
      <td id="input10_2"><input type="text" name="refp03_ocupacion" maxlength="60" size="22" value="<?php echo $refp03_ocupacion; ?>" /></td>
    <tr>
    </tr>
    <td class="etiqueta">N. Telefono: </td>
    <td id="input11_2"><input type="text" name="refp03_telf" maxlength="60" size="20" value="<?php echo $refp03_telf; ?>" /></td>
    <td class="etiqueta">Parentesco: </td>
    <td id="input12_2"><input type="text" name="refp03_parentezco" maxlength="60" size="20" value="<?php echo $refp03_parentezco; ?>" /> </td>
    </tr>

    <tr>
      <td class="etiqueta">Dirección:</td>
      <td id="textarea05_2"><textarea name="refp03_direccion" cols="40" rows="2"><?php echo $refp03_direccion; ?></textarea>
        <span id="Counterror_mess05_2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
      <td class="etiqueta">Observaci&oacute;n:</td>
      <td id="textarea06_2"><textarea name="refp03_observacion" cols="40" rows="2" readonly="readonly"><?php echo $refp03_observacion; ?></textarea>
        <span id="Counterror_mess06_2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td class="etiqueta">Status: </td>
      <td id="radio03_2">&nbsp;&nbsp; <?php echo $leng["aceptado"]; ?>
        <input name="refp03_apto" type="radio" value="S" style="width:auto" <?php echo CheckX($refp03_apto, 'S'); ?> disabled="disabled" />&nbsp;&nbsp; <?php echo $leng["rechazado"]; ?>
        <input name="refp03_apto" type="radio" value="N" style="width:auto" <?php echo CheckX($refp03_apto, 'N'); ?> disabled="disabled" />&nbsp;&nbsp; <?php echo $leng["pendiente"]; ?>
        <input name="refp03_apto" type="radio" value="P" style="width:auto" <?php echo CheckX($refp03_apto, 'P'); ?> disabled="disabled" /><br /><span class="radioRequiredMsg">Seleccione...</span>
        <input type="hidden" name="refp03_apto" value="<?php echo $refp03_apto; ?>" /></td>
    </tr>
  </table>
</fieldset>
<fieldset class="fieldset">
  <legend>REFERENCIAS LABORALES</legend>
  <table width="99%" align="center">
    <tr>
      <td class="etiqueta">Empresa: </td>
      <td id="input13_2"><input type="text" name="refl01_empresa" maxlength="120" size="24" value="<?php echo $refl01_empresa; ?>" /></td>
      <td class="etiqueta">N. Telefono: </td>
      <td id="input14_2"><input type="text" name="refl01_telf" maxlength="60" size="20" value="<?php echo $refl01_telf; ?>" /></td>
      <td class="etiqueta">Fecha Ingreso:</td>
      <td id="fecha01_2"><input type="text" name="refl01_fec_ingreso" maxlength="60" size="12" value="<?php echo $refl01_fec_ingreso; ?>" /></td>
    </tr>
    <tr>
      <td class="etiqueta">Contacto:</td>
      <td id="input15_2"><input type="text" name="refl01_contacto" maxlength="60" size="24" value="<?php echo $refl01_contacto; ?>" /> </td>
      <td class="etiqueta">Cargo:</td>
      <td id="input16_2"><input type="text" name="refl01_cargo" maxlength="60" size="20" value="<?php echo $refl01_cargo; ?>" /> </td>

      <td class="etiqueta">Fecha Egreso:</td>
      <td id="fecha02_2"><input type="text" name="refl01_fec_egreso" maxlength="60" size="12" value="<?php echo $refl01_fec_egreso; ?>" /> </td>
    </tr>
    <tr>
      <td class="etiqueta">Sueldo Inicial:</td>
     <td id="input17_2"><input type="decimal" name="refl01_sueldo_inic" maxlength="60" size="16"
                             value="<?php echo $refl01_sueldo_inic;?>"/> </td>
      <td class="etiqueta">Sueldo Final:</td>
     <td id="input18_2"><input type="decimal" name="refl01_sueldo_fin" maxlength="60" size="16"
                             value="<?php echo $refl01_sueldo_fin;?>"/> </td>
      <td class="etiqueta" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td class="etiqueta">Dirección:</td>
      <td id="textarea07_2" colspan="2"><textarea name="refl01_direccion" cols="40" rows="2"><?php echo $refl01_direccion; ?></textarea>
        <span id="Counterror_mess07_2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
      <td class="etiqueta">Motivo Retiro:</td>
      <td id="textarea08_2" colspan="2"><textarea name="refl01_retiro" cols="40" rows="2"><?php echo $refl01_retiro; ?></textarea>
        <span id="Counterror_mess08_2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Observaci&oacute;n:</td>
      <td id="textarea09_2" colspan="2"><textarea name="refl01_observacion" cols="40" rows="2" readonly="readonly"><?php echo $refl01_observacion; ?></textarea>
        <span id="Counterror_mess09_2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
      <td class="etiqueta">Status: </td>
      <td id="radio04_2" colspan="2">&nbsp;&nbsp; <?php echo $leng["aceptado"]; ?>
        <input name="refl01_apto" type="radio" value="S" style="width:auto" <?php echo CheckX($refl01_apto, 'S'); ?> disabled="disabled" />&nbsp;&nbsp; <?php echo $leng["rechazado"]; ?>
        <input name="refl01_apto" type="radio" value="N" style="width:auto" <?php echo CheckX($refl01_apto, 'N'); ?> disabled="disabled" />&nbsp;&nbsp; <?php echo $leng["pendiente"]; ?>
        <input name="refl01_apto" type="radio" value="P" style="width:auto" <?php echo CheckX($refl01_apto, 'P'); ?> disabled="disabled" /><span class="radioRequiredMsg">Seleccione...</span>
        <input type="hidden" name="refl01_apto" value="<?php echo $refl01_apto; ?>" /></td>
    </tr>
    <tr>
      <td height="8" colspan="6" align="center">
        <hr>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Empresa: </td>
      <td id="input19_2"><input type="text" name="refl02_empresa" maxlength="120" size="24" value="<?php echo $refl02_empresa; ?>" /></td>
      <td class="etiqueta">N. Telefono: </td>
      <td id="input20_2"><input type="text" name="refl02_telf" maxlength="60" size="20" value="<?php echo $refl02_telf; ?>" /></td>
      <td class="etiqueta">Fecha Ingreso:</td>
      <td id="fecha03_2"><input type="text" name="refl02_fec_ingreso" maxlength="60" size="12" value="<?php echo $refl02_fec_ingreso; ?>" /> </td>
    </tr>
    <tr>
      <td class="etiqueta">Contacto:</td>
      <td id="input21_2"><input type="text" name="refl02_contacto" maxlength="60" size="24" value="<?php echo $refl02_contacto; ?>" /> </td>
      <td class="etiqueta">Cargo:</td>
      <td id="input22_2"><input type="text" name="refl02_cargo" maxlength="60" size="20" value="<?php echo $refl02_cargo; ?>" /> </td>
      <td class="etiqueta">Fecha Egreso:</td>
      <td id="fecha04_2"><input type="text" name="refl02_fec_egreso" maxlength="60" size="12" value="<?php echo $refl02_fec_egreso; ?>" /> </td>
    </tr>
    <tr>
      <td class="etiqueta">Sueldo Inicial:</td>
     <td id="input23_2"><input type="decimal" name="refl02_sueldo_inic" maxlength="60" size="16"
                             value="<?php echo $refl02_sueldo_inic;?>"/> </td>
      <td class="etiqueta">Sueldo Final:</td>
     <td id="input24_2"><input type="decimal" name="refl02_sueldo_fin" maxlength="60" size="16"
                             value="<?php echo $refl02_sueldo_fin;?>"/> </td>
      <td class="etiqueta" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td class="etiqueta">Dirección:</td>
      <td id="textarea10_2" colspan="2"><textarea name="refl02_direccion" cols="40" rows="2"><?php echo $refl02_direccion; ?></textarea>
        <span id="Counterror_mess10_2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
      <td class="etiqueta">Motivo Retiro:</td>
      <td id="textarea11_2" colspan="2"><textarea name="refl02_retiro" cols="40" rows="2"><?php echo $refl02_retiro; ?></textarea>
        <span id="Counterror_mess11_2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Observaci&oacute;n:</td>
      <td id="textarea12_2" colspan="2"><textarea name="refl02_observacion" cols="40" rows="2" readonly="readonly"><?php echo $refl02_observacion; ?></textarea>
        <span id="Counterror_mess12_2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
      <td class="etiqueta">Status: </td>
      <td id="radio05_2" colspan="2">&nbsp;&nbsp; <?php echo $leng["aceptado"]; ?>
        <input name="refl02_apto" type="radio" value="S" style="width:auto" <?php echo CheckX($refl02_apto, 'S'); ?> disabled="disabled" />&nbsp;&nbsp; <?php echo $leng["rechazado"]; ?>
        <input name="refl02_apto" type="radio" value="N" style="width:auto" <?php echo CheckX($refl02_apto, 'N'); ?> disabled="disabled" />&nbsp;&nbsp; <?php echo $leng["pendiente"]; ?>
        <input name="refl02_apto" type="radio" value="P" style="width:auto" <?php echo CheckX($refl02_apto, 'P'); ?> disabled="disabled" /><span class="radioRequiredMsg">Seleccione...</span>
        <input type="hidden" name="refl02_apto" value="<?php echo $refl01_apto; ?>" /></td>
    </tr>
    <tr>
      <td height="8" colspan="6" align="center">
        <hr>
      </td>
    </tr>
  </table>

</fieldset>

<!-------------------------------------------------------------------------------------------------------------------------->
<fieldset class="fieldset">
  <legend>REFERENCIAS FAMILIARES</legend>
  <table width="100%" align="center">
    <tr>
      <td class="etiqueta">Nombre:</td>
      <td id="input25_2"><input type="text" name="reff01_nombre" maxlength="120" size="22" value="<?php echo $reff01_nombre; ?>" /></td>
      <td class="etiqueta">Ocupación: </td>
      <td id="input26_2"><input type="text" name="reff01_ocupacion" maxlength="60" size="22" value="<?php echo $reff01_ocupacion; ?>" /></td>
    </tr>
    <tr>
      <td class="etiqueta">N. Telefono: </td>
      <td id="input27_2"><input type="text" name="reff01_telf" maxlength="60" size="20" value="<?php echo $reff01_telf; ?>" /></td>
      <td class="etiqueta">Parentesco: </td>
      <td id="input28_2"><input type="text" name="reff01_parentezco" maxlength="60" size="20" value="<?php echo $reff01_parentezco; ?>" /> </td>
    </tr>
    <tr>
      <td class="etiqueta">Dirección: </td>
      <td id="textarea13_2"><textarea name="reff01_direccion" cols="40" rows="2"><?php echo $reff01_direccion; ?></textarea>
        <span id="Counterror_mess13_2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
      <td class="etiqueta">Observaci&oacute;n: </td>
      <td id="textarea14_2"><textarea name="reff01_observacion" cols="40" rows="2" readonly="readonly"><?php echo $reff01_observacion; ?></textarea>
        <span id="Counterror_mess14_2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td class="etiqueta">Status: </td>
      <td id="radio01_2">&nbsp;&nbsp; <?php echo $leng["aceptado"]; ?>
        <input name="reff06_apto" type="radio" value="S" style="width:auto" <?php echo CheckX($reff01_apto, 'S'); ?> disabled="disabled" />&nbsp;&nbsp; <?php echo $leng["rechazado"]; ?>
        <input name="reff06_apto" type="radio" value="N" style="width:auto" <?php echo CheckX($reff01_apto, 'N'); ?> disabled="disabled" />&nbsp;&nbsp; <?php echo $leng["pendiente"]; ?>
        <input name="reff06_apto" type="radio" value="P" style="width:auto" <?php echo CheckX($reff01_apto, 'P'); ?> disabled="disabled" /><br /><span class="radioRequiredMsg">Seleccione...</span>
        <input type="hidden" name="reff01_apto" value="<?php echo $reff01_apto; ?>" /></td>
    </tr>
  </table>
  <div align="center"><span class="art-button-wrapper">
      <span class="art-button-l"> </span>
      <span class="art-button-r"> </span>
      <input type="submit" name="salvar" id="salvar" value="Guardar" class="readon art-button" />
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
<!-------------------------------------------------------------------------------------------------------------------------->
<script type="text/javascript">
  var input01_2 = new Spry.Widget.ValidationTextField("input01_2", "none", {
    validateOn: ["blur", "change"]
  });
  var input02_2 = new Spry.Widget.ValidationTextField("input02_2", "none", {
    validateOn: ["blur", "change"]
  });
  var input03_2 = new Spry.Widget.ValidationTextField("input03_2", "none", {
    validateOn: ["blur", "change"]
  });
  var input04_2 = new Spry.Widget.ValidationTextField("input04_2", "none", {
    validateOn: ["blur", "change"]
  });
  var input05_2 = new Spry.Widget.ValidationTextField("input05_2", "none", {
    validateOn: ["blur", "change"]
  });
  var input06_2 = new Spry.Widget.ValidationTextField("input06_2", "none", {
    validateOn: ["blur", "change"]
  });
  var input07_2 = new Spry.Widget.ValidationTextField("input07_2", "none", {
    validateOn: ["blur", "change"]
  });
  var input08_2 = new Spry.Widget.ValidationTextField("input08_2", "none", {
    validateOn: ["blur", "change"]
  });
  var input09_2 = new Spry.Widget.ValidationTextField("input09_2", "none", {
    validateOn: ["blur", "change"],
    isRequired: false
  });
  var input10_2 = new Spry.Widget.ValidationTextField("input10_2", "none", {
    validateOn: ["blur", "change"],
    isRequired: false
  });
  var input11_2 = new Spry.Widget.ValidationTextField("input11_2", "none", {
    validateOn: ["blur", "change"],
    isRequired: false
  });
  var input12_2 = new Spry.Widget.ValidationTextField("input12_2", "none", {
    validateOn: ["blur", "change"],
    isRequired: false
  });
  var input13_2 = new Spry.Widget.ValidationTextField("input13_2", "none", {
    validateOn: ["blur", "change"]
  });
  var input14_2 = new Spry.Widget.ValidationTextField("input14_2", "none", {
    validateOn: ["blur", "change"]
  });
  var input15_2 = new Spry.Widget.ValidationTextField("input15_2", "none", {
    validateOn: ["blur", "change"]
  });
  var input16_2 = new Spry.Widget.ValidationTextField("input16_2", "none", {
    validateOn: ["blur", "change"]
  });
  var input17_2 = new Spry.Widget.ValidationTextField("input17_2", "none", {
    validateOn: ["blur", "change"],
    isRequired: false
  });
  var input18_2 = new Spry.Widget.ValidationTextField("input18_2", "none", {
    validateOn: ["blur", "change"],
    isRequired: false
  });
  var input19_2 = new Spry.Widget.ValidationTextField("input19_2", "none", {
    validateOn: ["blur", "change"],
    isRequired: false
  });
  var input20_2 = new Spry.Widget.ValidationTextField("input20_2", "none", {
    validateOn: ["blur", "change"],
    isRequired: false
  });
  var input21_2 = new Spry.Widget.ValidationTextField("input21_2", "none", {
    validateOn: ["blur", "change"],
    isRequired: false
  });
  var input22_2 = new Spry.Widget.ValidationTextField("input22_2", "none", {
    validateOn: ["blur", "change"],
    isRequired: false
  });
  var input23_2 = new Spry.Widget.ValidationTextField("input23_2", "none", {
    validateOn: ["blur", "change"],
    isRequired: false
  });
  var input24_2 = new Spry.Widget.ValidationTextField("input24_2", "none", {
    validateOn: ["blur", "change"],
    isRequired: false
  });

  /////
  var input25_2 = new Spry.Widget.ValidationTextField("input25_2", "none", {
    validateOn: ["blur", "change"]
  });
  var input26_2 = new Spry.Widget.ValidationTextField("input26_2", "none", {
    validateOn: ["blur", "change"]
  });
  var input27_2 = new Spry.Widget.ValidationTextField("input27_2", "none", {
    validateOn: ["blur", "change"]
  });
  var input28_2 = new Spry.Widget.ValidationTextField("input28_2", "none", {
    validateOn: ["blur", "change"]
  });
  /////
  var radio01_2 = new Spry.Widget.ValidationRadio("radio01_2", {
    validateOn: ["change", "blur"]
  });
  var radio02_2 = new Spry.Widget.ValidationRadio("radio02_2", {
    validateOn: ["change", "blur"]
  });
  var radio03_2 = new Spry.Widget.ValidationRadio("radio03_2", {
    validateOn: ["change", "blur"]
  });
  var radio04_2 = new Spry.Widget.ValidationRadio("radio04_2", {
    validateOn: ["change", "blur"]
  });
  var radio05_2 = new Spry.Widget.ValidationRadio("radio05_2", {
    validateOn: ["change", "blur"]
  });
  ////
  var radio06_2 = new Spry.Widget.ValidationRadio("radio06_2", {
    validateOn: ["change", "blur"]
  });
  ////
  var textarea01_2 = new Spry.Widget.ValidationTextarea("textarea01_2", {
    maxChars: 255,
    validateOn: ["blur", "change"],
    counterType: "chars_count",
    counterId: "Counterror_mess01_2",
    useCharacterMasking: false,
    isRequired: false
  });
  var textarea02_2 = new Spry.Widget.ValidationTextarea("textarea02_2", {
    maxChars: 255,
    validateOn: ["blur", "change"],
    counterType: "chars_count",
    counterId: "Counterror_mess02_2",
    useCharacterMasking: false,
    isRequired: false
  });
  var textarea03_2 = new Spry.Widget.ValidationTextarea("textarea03_2", {
    maxChars: 255,
    validateOn: ["blur", "change"],
    counterType: "chars_count",
    counterId: "Counterror_mess03_2",
    useCharacterMasking: false,
    isRequired: false
  });
  var textarea04_2 = new Spry.Widget.ValidationTextarea("textarea04_2", {
    maxChars: 255,
    validateOn: ["blur", "change"],
    counterType: "chars_count",
    counterId: "Counterror_mess04_2",
    useCharacterMasking: false,
    isRequired: false
  });
  var textarea05_2 = new Spry.Widget.ValidationTextarea("textarea05_2", {
    maxChars: 255,
    validateOn: ["blur", "change"],
    counterType: "chars_count",
    counterId: "Counterror_mess05_2",
    useCharacterMasking: false,
    isRequired: false
  });
  var textarea06_2 = new Spry.Widget.ValidationTextarea("textarea06_2", {
    maxChars: 255,
    validateOn: ["blur", "change"],
    counterType: "chars_count",
    counterId: "Counterror_mess06_2",
    useCharacterMasking: false,
    isRequired: false
  });
  var textarea07_2 = new Spry.Widget.ValidationTextarea("textarea07_2", {
    maxChars: 255,
    validateOn: ["blur", "change"],
    counterType: "chars_count",
    counterId: "Counterror_mess07_2",
    useCharacterMasking: false,
    isRequired: false
  });
  var textarea08_2 = new Spry.Widget.ValidationTextarea("textarea08_2", {
    maxChars: 255,
    validateOn: ["blur", "change"],
    counterType: "chars_count",
    counterId: "Counterror_mess08_2",
    useCharacterMasking: false,
    isRequired: false
  });
  var textarea09_2 = new Spry.Widget.ValidationTextarea("textarea09_2", {
    maxChars: 255,
    validateOn: ["blur", "change"],
    counterType: "chars_count",
    counterId: "Counterror_mess09_2",
    useCharacterMasking: false,
    isRequired: false
  });
  var textarea10_2 = new Spry.Widget.ValidationTextarea("textarea10_2", {
    maxChars: 255,
    validateOn: ["blur", "change"],
    counterType: "chars_count",
    counterId: "Counterror_mess10_2",
    useCharacterMasking: false,
    isRequired: false
  });
  var textarea11_2 = new Spry.Widget.ValidationTextarea("textarea11_2", {
    maxChars: 255,
    validateOn: ["blur", "change"],
    counterType: "chars_count",
    counterId: "Counterror_mess11_2",
    useCharacterMasking: false,
    isRequired: false
  });
  var textarea12_2 = new Spry.Widget.ValidationTextarea("textarea12_2", {
    maxChars: 255,
    validateOn: ["blur", "change"],
    counterType: "chars_count",
    counterId: "Counterror_mess12_2",
    useCharacterMasking: false,
    isRequired: false
  });


  /////////////////////////

  var textarea13_2 = new Spry.Widget.ValidationTextarea("textarea13_2", {
    maxChars: 255,
    validateOn: ["blur", "change"],
    counterType: "chars_count",
    counterId: "Counterror_mess13_2",
    useCharacterMasking: false,
    isRequired: false
  });
  var textarea14_2 = new Spry.Widget.ValidationTextarea("textarea14_2", {
    maxChars: 255,
    validateOn: ["blur", "change"],
    counterType: "chars_count",
    counterId: "Counterror_mess14_2",
    useCharacterMasking: false,
    isRequired: false
  });
  /////////////////////////
  var fecha01_2 = new Spry.Widget.ValidationTextField("fecha01_2", "date", {
    format: "dd-mm-yyyy",
    hint: "DD-MM-AAAA",
    validateOn: ["blur", "change"],
    useCharacterMasking: true,
    isRequired: false
  });
  var fecha02_2 = new Spry.Widget.ValidationTextField("fecha02_2", "date", {
    format: "dd-mm-yyyy",
    hint: "DD-MM-AAAA",
    validateOn: ["blur", "change"],
    useCharacterMasking: true,
    isRequired: false
  });
  var fecha03_2 = new Spry.Widget.ValidationTextField("fecha03_2", "date", {
    format: "dd-mm-yyyy",
    hint: "DD-MM-AAAA",
    validateOn: ["blur", "change"],
    useCharacterMasking: true,
    isRequired: false
  });
  var fecha04_2 = new Spry.Widget.ValidationTextField("fecha04_2", "date", {
    format: "dd-mm-yyyy",
    hint: "DD-MM-AAAA",
    validateOn: ["blur", "change"],
    useCharacterMasking: true,
    isRequired: false
  });
</script>