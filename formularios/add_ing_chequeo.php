<?php
require_once('autentificacion/aut_verifica_menu.php');
$cedula = $_GET['codigo'];
$bdC = new DataBase();
$sql1 = "SELECT
chequeos_trab.cedula,
chequeos.tipo,
chequeos.codigo,
chequeos.requerido,
chequeos.visita,
chequeos.descripcion,
chequeos_trab.fecha,
chequeos_trab.status,
chequeos_trab.observacion 
FROM
chequeos
LEFT JOIN chequeos_trab ON chequeos.codigo = chequeos_trab.codigo AND chequeos_trab.cedula = $cedula
WHERE chequeos.tipo = 1";
$sql2 = "SELECT
chequeos_trab.cedula,
chequeos.tipo,
chequeos.codigo,
chequeos.requerido,
chequeos.visita,
chequeos.descripcion,
chequeos_trab.fecha,
chequeos_trab.status,
chequeos_trab.observacion 
FROM
chequeos
LEFT JOIN chequeos_trab ON chequeos.codigo = chequeos_trab.codigo AND chequeos_trab.cedula = $cedula
WHERE chequeos.tipo = 2";
$sql3 = "SELECT
chequeos_trab.cedula,
chequeos.tipo,
chequeos.codigo,
chequeos.requerido,
chequeos.visita,
chequeos.descripcion,
chequeos_trab.fecha,
chequeos_trab.status,
chequeos_trab.observacion 
FROM
chequeos
LEFT JOIN chequeos_trab ON chequeos.codigo = chequeos_trab.codigo AND chequeos_trab.cedula = $cedula
WHERE chequeos.tipo = 3";
?>
  <fieldset class="fieldset">
  <legend> ANTECEDENTES DEL TRABAJADOR (TH) </legend>
     <table width="90%" align="center">
       <?php

        $query1 = $bdC->consultar($sql1);
        while($datos=$bdC->obtener_fila($query1,0)){
          ?>
          <tr>
              <td class="etiqueta" rowspan="2"><?php echo $datos["descripcion"];?>:</td>
              <td>
                <span class="etiqueta">Fecha </span><input class="fechaC" type="text" name="fec_<?php echo $datos["codigo"];?>" id="fec_<?php echo $datos["codigo"];?>" value="<?php echo $datos["fecha"];?>" readonly="true" size="9" border="0" width="17px"></td>
              </td>
              <td>
                <span class="etiqueta">Chequeo</span>
                &nbsp;&nbsp; <?php echo $leng["aprobado"];?>
              <input name="status_<?php echo $datos["codigo"];?>" type="radio"  value="A" style="width:auto" <?php echo CheckX($datos["status"], 'A');?> disabled="disabled"/>&nbsp;&nbsp; 
              <?php echo $leng["reprobado"];?>
              <input name="status_<?php echo $datos["codigo"];?>"  type="radio" value="R" style="width:auto" <?php echo CheckX($datos["status"], 'R');?> disabled="disabled"/>
              <?php
              if($datos["requerido"] == 'F'){
                ?>
                &nbsp;&nbsp; <?php echo $leng["indefinido"];?>
                <input name="satus_<?php echo $datos["codigo"];?>"  type="radio" value="I" style="width:auto" <?php echo CheckX($datos["status"], 'I');?> disabled="disabled"/>
                <?php
              }
              ?>
              <span class="radioRequiredMsg">Seleccione...</span>
              <input type="hidden" name="codigo_<?php echo $datos["codigo"];?>" value="<?php echo $datos["codigo"];?>" />
              <input type="hidden" name="requerido_<?php echo $datos["codigo"];?>" value="<?php echo $datos["requerido"];?>" />
              <input type="hidden" name="visita_<?php echo $datos["codigo"];?>" value="<?php echo $datos["visita"];?>" />
              </td>
          </tr>
          <tr>
            <td></td>
              <td ><span class="etiqueta">Observación:</span>
             <textarea  name="observacion_<?php echo $datos["codigo"];?>" cols="40" rows="2"><?php echo $datos["observacion"];?></textarea>
                <span id="Counterror_mess03_3" class="texto">&nbsp;</span><br />
                <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 120.</span>
                </td>
          </tr>
          <tr><td colspan="3"> <br></td></tr>
         
      <?php
        }
       ?>

  </table>
</fieldset>
  <fieldset class="fieldset">
  <legend> DOCUMENTOS OCUPACIONALES (TH) </legend>
    <table width="90%" align="center">
      <?php
        $query2 = $bdC->consultar($sql2);
        while($datos=$bdC->obtener_fila($query2,0)){
          ?>
          <tr>
              <td class="etiqueta" rowspan="2"><?php echo $datos["descripcion"];?>:</td>
              <td>
                <span class="etiqueta">Fecha </span><input class="fechaC" type="text" name="fec_<?php echo $datos["codigo"];?>" id="fec_<?php echo $datos["codigo"];?>" value="<?php echo $datos["fecha"];?>" readonly="true" size="9" border="0" width="17px"></td>
              </td>
              <td>
                <span class="etiqueta">Chequeo</span>
                &nbsp;&nbsp; <?php echo $leng["aprobado"];?>
              <input name="status_<?php echo $datos["codigo"];?>" type="radio"  value="A" style="width:auto" <?php echo CheckX($datos["status"], 'A');?> disabled="disabled"/>&nbsp;&nbsp; <?php echo $leng["reprobado"];?>
              <input name="status_<?php echo $datos["codigo"];?>"  type="radio" value="R" style="width:auto" <?php echo CheckX($datos["status"], 'R');?> disabled="disabled"/>
              <?php
              if($datos["requerido"] == 'F'){
                ?>
                &nbsp;&nbsp; <?php echo $leng["indefinido"];?>
                <input name="satus_<?php echo $datos["codigo"];?>"  type="radio" value="I" style="width:auto" <?php echo CheckX($datos["status"], 'I');?> disabled="disabled"/>
                <?php
              }
              ?>
              <span class="radioRequiredMsg">Seleccione...</span>
              <input type="hidden" name="codigo_<?php echo $datos["codigo"];?>" value="<?php echo $datos["codigo"];?>" />
              <input type="hidden" name="requerido_<?php echo $datos["codigo"];?>" value="<?php echo $datos["requerido"];?>" />
              <input type="hidden" name="visita_<?php echo $datos["codigo"];?>" value="<?php echo $datos["visita"];?>" />
              </td>
          </tr>
          <tr>
            <td></td>
              <td ><span class="etiqueta">Observación:</span>
             <textarea  name="observacion_<?php echo $datos["codigo"];?>" cols="40" rows="2"><?php echo $datos["observacion"];?></textarea>
                <span id="Counterror_mess03_3" class="texto">&nbsp;</span><br />
                <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 120.</span>
                </td>
          </tr>
          <tr><td colspan="3"> <br></td></tr>
        <?php
        }
        ?>
    </table>
  </fieldset>
  <fieldset class="fieldset">
  <legend> DOCUMENTOS DE SELECCIÓN (OP) </legend>
    <table width="90%" align="center">
      <?php
            $query3 = $bdC->consultar($sql3);
            while($datos=$bdC->obtener_fila($query3,0)){
              ?>
          <tr>
              <td class="etiqueta" rowspan="2"><?php echo $datos["descripcion"];?>:</td>
              <td>
                <span class="etiqueta">Fecha </span><input class="fechaC" type="text" name="fec_<?php echo $datos["codigo"];?>" id="fec_<?php echo $datos["codigo"];?>" value="<?php echo $datos["fecha"];?>" readonly="true" size="9" border="0" width="17px"></td>
              </td>
              <td>
                <span class="etiqueta">Chequeo</span>
                &nbsp;&nbsp; <?php echo $leng["aprobado"];?>
              <input name="status_<?php echo $datos["codigo"];?>" type="radio"  value="A" style="width:auto" <?php echo CheckX($datos["status"], 'A');?> disabled="disabled"/>&nbsp;&nbsp; <?php echo $leng["reprobado"];?>
              <input name="status_<?php echo $datos["codigo"];?>"  type="radio" value="R" style="width:auto" <?php echo CheckX($datos["status"], 'R');?> disabled="disabled"/>
              <?php
              if($datos["requerido"] == 'F'){
                ?>
                &nbsp;&nbsp; <?php echo $leng["indefinido"];?>
                <input name="satus_<?php echo $datos["codigo"];?>"  type="radio" value="I" style="width:auto" <?php echo CheckX($datos["status"], 'I');?> disabled="disabled"/>
                <?php
              }
              ?>
              <span class="radioRequiredMsg">Seleccione...</span>
              <input type="hidden" name="codigo_<?php echo $datos["codigo"];?>" value="<?php echo $datos["codigo"];?>" />
              <input type="hidden" name="requerido_<?php echo $datos["codigo"];?>" value="<?php echo $datos["requerido"];?>" />
              <input type="hidden" name="visita_<?php echo $datos["codigo"];?>" value="<?php echo $datos["visita"];?>" />
              </td>
          </tr>
          <tr>
            <td></td>
              <td ><span class="etiqueta">Observación:</span>
             <textarea  name="observacion_<?php echo $datos["codigo"];?>" cols="40" rows="2"><?php echo $datos["observacion"];?></textarea>
                <span id="Counterror_mess03_3" class="texto">&nbsp;</span><br />
                <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 120.</span>
                </td>
          </tr>
          <tr><td colspan="3"> <br></td></tr>
            <?php
            }
        ?>
    </table>
  </fieldset>
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
$(document).ready(function(){
    $(".fieldset .fechaC").each(function(a, i){
    var fecha01 = new Spry.Widget.ValidationTextField($(this).attr('id'), "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAA", 
    validateOn:["blur", "change"], useCharacterMasking:true});
        	});
        });

</script>