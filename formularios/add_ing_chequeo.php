<?php
require_once('autentificacion/aut_verifica_menu.php');
?>
  <fieldset class="fieldset">
  <legend>Chequeo <?php echo $leng["trabajador"];?>  </legend>
     <table width="90%" align="center">
    <tr>
      <td width="30%" class="etiqueta"><?php echo $leng["psic_fec"];?>:</td>
      <td width="70%"><span id="fecha01_3"><input type="text" name="fec_psi" value="<?php echo $fec_psic;?>" size="12"/></span></td>
	</tr>
  <tr>
      <td class="etiqueta"><?php echo $leng["psic_desc"];?>:</td>
      <td class="texto">
			<span id="radio01_3">&nbsp;&nbsp; <?php echo $leng["aprobado"];?>
			<input name="psi_apto" type="radio" value="A" style="width:auto" <?php echo CheckX($psic_apto, 'A');?>
                   disabled="disabled"/>&nbsp;&nbsp; <?php echo $leng["reprobado"];?>
			<input name="psi_apto" type="radio" value="R" style="width:auto" <?php echo CheckX($psic_apto, 'R');?>
                   disabled="disabled"/>&nbsp;&nbsp; <?php echo $leng["condiccional"];?>
			<input name="psi_apto" type="radio" value="C" style="width:auto" <?php echo CheckX($psic_apto, 'C');?>
                   disabled="disabled" />&nbsp;&nbsp;<?php echo $leng["indefinido"];?>
           <input name="psi_apto" type="radio" value="I" style="width:auto" <?php echo CheckX($psic_apto, 'I');?>
                   disabled="disabled" />
      			</span><input type="hidden" name="psi_apto" value="<?php echo $psic_apto;?>" />
	  </td>
    </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng["psic_observ"];?>:</td>
      <td id="textarea01_3"><textarea  name="psic_observacion" cols="40" rows="2"><?php echo $psic_observacion;?></textarea>
        <span id="Counterror_mess01_3" class="texto">&nbsp;</span><br />
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 120.</span></td>
    </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng["pol_fec"];?>:</td>
      <td><span id="fecha02_3"><input type="text" name="fec_pol" value="<?php echo $fec_pol;?>" readonly="true" size="12"/></span>
      </td>
	</tr>
    <tr>
      <td class="etiqueta"><?php echo $leng["pol_desc"];?>:</td>
      <td class="texto">
			<span id="radio02_3">&nbsp;&nbsp; <?php echo $leng["aprobado"];?>
			<input name="pol_apto" type="radio"  value="A" style="width:auto" <?php echo CheckX($pol_apto, 'A');?>
                   disabled="disabled"/>&nbsp;&nbsp; <?php echo $leng["reprobado"];?>
			<input name="pol_apto"  type="radio" value="R" style="width:auto" <?php echo CheckX($pol_apto, 'R');?>
                   disabled="disabled" />&nbsp;&nbsp; <?php echo $leng["indefinido"];?>
			<input name="pol_apto"  type="radio" value="I" style="width:auto" <?php echo CheckX($pol_apto, 'I');?>
                   disabled="disabled" />
			<span class="radioRequiredMsg">Seleccione...</span>
			</span>
             <input type="hidden" name="pol_apto" value="<?php echo $pol_apto;?>" />
      </td>
    </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng["pol_observ"];?>:</td>
      <td id="textarea02_3"><textarea  name="pol_observacion" cols="40" rows="2"><?php echo $pol_observacion;?></textarea>
        <span id="Counterror_mess02_3" class="texto">&nbsp;</span><br />
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 120.</span></td>
    </tr>
     <tr>
      <td class="etiqueta"><?php echo $leng["pre_emp_fec"];?>:</td>
      <td><span id="fecha03_3"><input type="text" name="fec_pre_emp" value="<?php echo $fec_pre_emp;?>" readonly="true" size="12"/></span>
      </td>
  </tr>
  <tr>
      <td class="etiqueta"><?php echo $leng["pre_emp_desc"];?>:</td>
      <td class="texto">
      <span id="radio03_3">&nbsp;&nbsp; <?php echo $leng["aprobado"];?>
      <input name="pre_emp_apto" type="radio"  value="A" style="width:auto" <?php echo CheckX($pre_emp_apto, 'A');?> disabled="disabled"/>&nbsp;&nbsp; <?php echo $leng["reprobado"];?>
      <input name="pre_emp_apto"  type="radio" value="R" style="width:auto" <?php echo CheckX($pre_emp_apto, 'R');?> disabled="disabled"/>&nbsp;&nbsp; <?php echo $leng["indefinido"];?>
      <input name="pre_emp_apto"  type="radio" value="I" style="width:auto" <?php echo CheckX($pre_emp_apto, 'I');?> disabled="disabled"/>
      <span class="radioRequiredMsg">Seleccione...</span>
      </span>
      <input type="hidden" name="pre_emp_apto" value="<?php echo $pre_emp_apto;?>" />
      </td>
    </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng["pre_emp_observ"];?>:</td>
      <td id="textarea03_3"><textarea  name="pre_emp_observacion" cols="40" rows="2"><?php echo $pre_emp_observacion;?></textarea>
        <span id="Counterror_mess03_3" class="texto">&nbsp;</span><br />
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 120.</span></td>
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
<script language="javascript" type="text/javascript">

var fecha01_3 = new Spry.Widget.ValidationTextField("fecha01_3", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA",
    validateOn:["blur", "change"], useCharacterMasking:true});
var fecha02_3 = new Spry.Widget.ValidationTextField("fecha02_3", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA",
    validateOn:["blur", "change"], useCharacterMasking:true});

var fecha03_3 = new Spry.Widget.ValidationTextField("fecha03_3", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA",
    validateOn:["blur", "change"], useCharacterMasking:true});

var radio01_3 = new Spry.Widget.ValidationRadio("radio01_3", { validateOn:["change", "blur"]});
var radio02_3 = new Spry.Widget.ValidationRadio("radio02_3", { validateOn:["change", "blur"]});
var radio03_3 = new Spry.Widget.ValidationRadio("radio03_3", { validateOn:["change", "blur"]});


var textarea01_3 = new Spry.Widget.ValidationTextarea("textarea01_3", {maxChars:120, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess01_3", useCharacterMasking:false , isRequired:false});
var textarea02_3 = new Spry.Widget.ValidationTextarea("textarea02_3", {maxChars:120, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess02_3", useCharacterMasking:false , isRequired:false});
var textarea03_3 = new Spry.Widget.ValidationTextarea("textarea03_3", {maxChars:120, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess03_3", useCharacterMasking:false , isRequired:false});
</script>
