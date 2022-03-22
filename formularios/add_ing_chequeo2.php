<?php
require_once('autentificacion/aut_verifica_menu.php');
$cedula = $_GET['codigo'];
$bdC = new DataBase();
$sql1 = "SELECT
chequeos_trab.cedula,
chequeos.tipo,
chequeos.codigo,
chequeos.descripcion,
chequeos_trab.fecha,
IFNULL(chequeos_trab.status, 'R') status,
chequeos_trab.observacion 
FROM
chequeos
LEFT JOIN chequeos_trab ON chequeos.codigo = chequeos_trab.codigo AND chequeos_trab.cedula = $cedula
WHERE chequeos.tipo = 1";
$sql2 = "SELECT
chequeos_trab.cedula,
chequeos.tipo,
chequeos.codigo,
chequeos.descripcion,
chequeos_trab.fecha,
IFNULL(chequeos_trab.status, 'R') status,
chequeos_trab.observacion 
FROM
chequeos
LEFT JOIN chequeos_trab ON chequeos.codigo = chequeos_trab.codigo AND chequeos_trab.cedula = $cedula
WHERE chequeos.tipo = 2";
$sql3 = "SELECT
chequeos_trab.cedula,
chequeos.tipo,
chequeos.codigo,
chequeos.descripcion,
chequeos_trab.fecha,
IFNULL(chequeos_trab.status, 'R') status,
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
              <td class="etiqueta">Fecha <?php echo $datos["descripcion"];?>:</td>
              <td>
                <input type="text" name="fec_<?php echo $datos["codigo"];?>" id="fec_<?php echo $datos["codigo"];?>" value="<?php echo $datos["fecha"];?>" size="9" border="0" width="17px"></td>
              </td>
          </tr>
          <tr>
              <td class="etiqueta">Chequeo <?php echo $datos["descripcion"];?>:</td>
              <td class="texto"> &nbsp;&nbsp; <?php echo $leng["aprobado"];?>
              <input name="status_<?php echo $datos["codigo"];?>" type="radio"  value="A" style="width:auto" <?php echo CheckX($hoja_vida_apto, 'A');?> />&nbsp;&nbsp; <?php echo $leng["reprobado"];?>
              <input name="status_<?php echo $datos["codigo"];?>"  type="radio" value="R" style="width:auto" <?php echo CheckX($hoja_vida_apto, 'R');?> />
              <span class="radioRequiredMsg">Seleccione...</span>
              <input type="hidden" name="codigo_<?php echo $datos["codigo"];?>" value="<?php echo $datos["codigo"];?>" />
              </td>
          </tr>
          <tr>
              <td class="etiqueta">Observación <?php echo $datos["descripcion"];?>:</td>
              <td id="textarea03_3"><textarea  name="observacion_<?php echo $datos["codigo"];?>" cols="40" rows="2"><?php echo $datos["observacion"];?></textarea>
                <span id="Counterror_mess03_3" class="texto">&nbsp;</span><br />
                <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 120.</span></td>
          </tr>
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
              <td class="etiqueta">Fecha <?php echo $datos["descripcion"];?>:</td>
              <td>
                <input type="text" name="fec_<?php echo $datos["codigo"];?>" id="fec_<?php echo $datos["codigo"];?>" value="<?php echo $datos["fecha"];?>"  size="9" border="0" width="17px"></td>
              </td>
          </tr>
          <tr>
              <td class="etiqueta">Chequeo <?php echo $datos["descripcion"];?>:</td>
              <td class="texto"> &nbsp;&nbsp; <?php echo $leng["aprobado"];?>
              <input name="status_<?php echo $datos["codigo"];?>" type="radio"  value="A" style="width:auto" <?php echo CheckX($datos["status"], 'A');?> />&nbsp;&nbsp; <?php echo $leng["reprobado"];?>
              <input name="status_<?php echo $datos["codigo"];?>"  type="radio" value="R" style="width:auto" <?php echo CheckX($datos["status"], 'R');?> />
              <span class="radioRequiredMsg">Seleccione...</span>
              <input type="hidden" name="codigo_<?php echo $datos["codigo"];?>" value="<?php echo $datos["codigo"];?>" />
              </td>
          </tr>
          <tr>
              <td class="etiqueta">Observación <?php echo $datos["descripcion"];?>:</td>
              <td id="textarea03_3"><textarea  name="observacion_<?php echo $datos["codigo"];?>" cols="40" rows="2"><?php echo $datos["observacion"];?></textarea>
                <span id="Counterror_mess03_3" class="texto">&nbsp;</span><br />
                <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 120.</span></td>
          </tr>
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
                  <td class="etiqueta">Fecha <?php echo $datos["descripcion"];?>:</td>
                  <td>
                    <input type="text" name="fec_<?php echo $datos["codigo"];?>" id="fec_<?php echo $datos["codigo"];?>" value="<?php echo $datos["fecha"];?>"  size="9" border="0" width="17px"></td>
                  </td>
              </tr>
              <tr>
                  <td class="etiqueta">Chequeo <?php echo $datos["descripcion"];?>:</td>
                  <td class="texto"> &nbsp;&nbsp; <?php echo $leng["aprobado"];?>
                  <input name="status_<?php echo $datos["codigo"];?>" type="radio"  value="A" style="width:auto" <?php echo CheckX($datos["status"], 'A');?> />&nbsp;&nbsp; <?php echo $leng["reprobado"];?>
                  <input name="status_<?php echo $datos["codigo"];?>"  type="radio" value="R" style="width:auto" <?php echo CheckX($datos["status"], 'R');?> />
                  <span class="radioRequiredMsg">Seleccione...</span>
                  <input type="hidden" name="codigo_<?php echo $datos["codigo"];?>" value="<?php echo $datos["codigo"];?>" />
                  </td>
              </tr>
              <tr>
                  <td class="etiqueta">Observación <?php echo $datos["descripcion"];?>:</td>
                  <td id="textarea03_3"><textarea  name="observacion_<?php echo $datos["codigo"];?>" cols="40" rows="2"><?php echo $datos["observacion"];?></textarea>
                    <span id="Counterror_mess03_3" class="texto">&nbsp;</span><br />
                    <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 120.</span></td>
              </tr>
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
