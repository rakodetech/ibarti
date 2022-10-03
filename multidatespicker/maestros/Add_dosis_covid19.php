<?php
$Nmenu = '380';
require_once('autentificacion/aut_verifica_menu.php');
$metodo = $_GET['metodo'];
$archivo = $_GET['archivo'];
$titulo =  "VENCIMIENTOS DE COVID-19";
$proced      = "p_dosis_covid19";
$archivo2 = "../inicio.php?area=maestros/Cons_$archivo&Nmenu=" . $_GET['Nmenu'] . "&mod=" . $_GET['mod'] . "";

if ($metodo == 'modificar') {
  $codigo = $_GET['codigo'];
  $bd = new DataBase();
  $sql = " SELECT ficha_dosis_covid19.codigo, ficha_dosis_covid19.descripcion,
                    ficha_dosis_covid19.vencimiento, ficha_dosis_covid19.dias,
					ficha_dosis_covid19.campo01, ficha_dosis_covid19.campo02,
					ficha_dosis_covid19.campo03,ficha_dosis_covid19.campo04, 
                    ficha_dosis_covid19.`status`
               FROM ficha_dosis_covid19			   
			  WHERE ficha_dosis_covid19.codigo = '$codigo'";
  $query = $bd->consultar($sql);
  $result = $bd->obtener_fila($query, 0);

  $titulo      = "MODIFICAR DATOS $titulo";
  $codigo_onblur = "";

  $descripcion  = $result["descripcion"];
  $vencimiento  = $result["vencimiento"];
  $dias         = $result["dias"];
  $campo01      = $result["campo01"];
  $campo02      = $result["campo02"];
  $campo03      = $result["campo03"];
  $campo04      = $result["campo04"];
  $activo       = $result["status"];
} else {
  $codigo      = "";
  $codigo_onblur = "Add_ajax_maestros(this.value, 'ajax/validar_maestros.php', 'Contenedor', '$tabla')";
  $titulo      = "AGREGAR $titulo";
  $tipo_mov      = "";
  $descripcion = "";
  $campo01     = "";
  $campo02     = "";
  $campo03     = "";
  $campo04     = "";
  $activo      = 'T';
} ?>
<div id="Contenedor" class="mensaje"></div>
<form action="sc_maestros/sc_<?php echo $archivo; ?>.php" method="post" name="add" id="add">
  <fieldset class="fieldset">
    <legend> <?php echo $titulo; ?> </legend>
    <table width="80%" align="center">
      <tr>
        <td class="etiqueta">C&oacute;digo:</td>
        <td id="input01"><input type="text" name="codigo" maxlength="11" style="width:120px" value="<?php echo $codigo; ?>" onblur="<?php echo $codigo_onblur; ?>" />
          Activo: <input name="activo" type="checkbox" <?php echo statusCheck("$activo"); ?> value="T" /><br />
          <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
        </td>
      </tr>
      <tr>
        <td class="etiqueta">Descripcion: </td>
        <td id="input02"><input type="text" name="descripcion" maxlength="60" style="width:300px" value="<?php echo $descripcion; ?>" /><br />
          <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
        </td>
      </tr>
      <tr>
        <td class="etiqueta">Vencimineto:</td>
        <td id="radio01" class="texto">SI
          <input type="radio" name="vencimiento" value="T" style="width:auto" <?php echo CheckX($vencimiento, 'T') ?> />
          NO <input type="radio" name="vencimiento" value="F" style="width:auto" <?php echo CheckX($vencimiento, 'F') ?> />
          <span class="radioRequiredMsg">Debe seleccionar un Campo.</span>
        </td>
      </tr>
      <tr>
        <td class="etiqueta">Dias Continuo: </td>
        <td id="input03"><input type="text" name="dias" maxlength="60" style="width:120px" value="<?php echo $dias; ?>" /><br />
          <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
        </td>
      </tr>
      <tr>
        <td height="8" colspan="2" align="center">
          <hr>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center">
          <span class="art-button-wrapper">
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
        </td>
      </tr>
    </table>
    <input name="campo01" type="hidden" value="<?php echo $campo01; ?>" />
    <input name="campo02" type="hidden" value="<?php echo $campo02; ?>" />
    <input name="campo03" type="hidden" value="<?php echo $campo03; ?>" />
    <input name="campo04" type="hidden" value="<?php echo $campo04; ?>" />

    <input name="metodo" id="metodo" type="hidden" value="<?php echo $metodo; ?>" />
    <input name="proced" id="proced" type="hidden" value="<?php echo $proced; ?>" />
    <input name="tabla" id="tabla" type="hidden" value="<?php echo $tabla; ?>" />
    <input name="usuario" id="usuario" type="hidden" value="<?php echo $usuario; ?>" />
    <input name="href" type="hidden" value="<?php echo $archivo2; ?>" />
  </fieldset>
</form>
<script type="text/javascript">
  var input01 = new Spry.Widget.ValidationTextField("input01", "none", {
    validateOn: ["blur", "change"]
  });
  var input02 = new Spry.Widget.ValidationTextField("input02", "none", {
    validateOn: ["blur", "change"]
  });

  var input03 = new Spry.Widget.ValidationTextField("input03", "currency", {
    format: "comma_dot",
    validateOn: ["blur", "change"],
    useCharacterMasking: true
  });
  var radio01 = new Spry.Widget.ValidationRadio("radio01", {
    validateOn: ["change", "blur"]
  });
</script>