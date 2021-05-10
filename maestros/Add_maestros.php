<?php
$metodo = $_GET['metodo'];
$titulo = $_GET['titulo'];
$tabla   = $_GET['tb'];
$archivo = $_GET['archivo'];
$archivo2 = "../inicio.php?area=maestros/Cons_$archivo&Nmenu=" . $_GET['Nmenu'] . "&mod=" . $_GET['mod'] . "";

if ($metodo == 'modificar') {
  $codigo = $_GET['codigo'];
  $bd = new DataBase();
  if ($tabla == 'cargos') {
    $sql = " SELECT $tabla.codigo, $tabla.descripcion,
    $tabla.campo01, $tabla.campo02, $tabla.campo03, $tabla.campo04,	               
    $tabla.status, $tabla.planificable, $tabla.cod_tipo, tipos_cargo.descripcion tipo
    FROM $tabla, tipos_cargo 
    WHERE $tabla.cod_tipo = tipos_cargo.codigo 
    AND $tabla.codigo = '$codigo' ";
    $sql_tipos = "SELECT codigo, descripcion FROM tipos_cargo WHERE status = 'T';";
    $query_tipos = $bd->consultar($sql_tipos);
  } else {
    if ($tabla == 'documentos_cl') {
      $sql = " SELECT $tabla.codigo, $tabla.descripcion, $tabla.orden,
	                $tabla.campo01, $tabla.campo02, $tabla.campo03, $tabla.campo04,	               
				    $tabla.status
             FROM $tabla WHERE codigo = '$codigo' ";
    } else if ($tabla == 'ficha_egreso_motivo') {
      $sql = " SELECT $tabla.codigo, $tabla.motivo, $tabla.descripcion,
	                $tabla.campo01, $tabla.campo02, $tabla.campo03, $tabla.campo04,	$tabla.status
             FROM $tabla WHERE codigo = '$codigo' ";
    } else {
      $sql = " SELECT $tabla.codigo, $tabla.descripcion,
	                $tabla.campo01, $tabla.campo02, $tabla.campo03, $tabla.campo04,	               
				    $tabla.status
             FROM $tabla WHERE codigo = '$codigo' ";
    }
  }
  $query = $bd->consultar($sql);
  $result = $bd->obtener_fila($query, 0);

  $codigo      = $result['codigo'];
  $codigo_onblur = "";
  $descripcion = $result['descripcion'];
  $campo01     = $result['campo01'];
  $campo02     = $result['campo02'];
  $campo03     = $result['campo03'];
  $campo04     = $result['campo04'];
  $status      = $result['status'];
  if ($tabla == 'cargos') {
    $planificable      = $result['planificable'];
  }
  if ($tabla == 'documentos_cl') {
    $orden      = $result['orden'];
  }
  if ($tabla == 'ficha_egreso_motivo') {
    $motivo      = $result['motivo'];
  }
  $readonly = 'readonly="readonly"';
} else {
  $readonly = '';
  $codigo      = '';
  $codigo_onblur = "Add_ajax_maestros(this.value, 'ajax/validar_maestros.php', 'Contenedor', '$tabla')";
  $descripcion = '';
  $orden = '';
  $campo01     = '';
  $campo02     = '';
  $campo03     = '';
  $campo04     = '';
  $status      = 'T';
}
?>
<div id="Contenedor" class="mensaje"></div>
<input type="hidden" name="codigos" value="<?php echo $codigo; ?>">
<fieldset class="fieldset">
  <legend>DATOS BASICOS <?php echo $titulo; ?> </legend>
  <table width="80%" align="center">
    <tr>
      <td class="etiqueta">C&oacute;digo:</td>
      <td id="input01"><input type="text" name="codigo" maxlength="11" style="width:120px" value="<?php echo $codigo; ?>" onblur="<?php echo $codigo_onblur; ?>" <?php echo $readonly; ?> />
        Activo: <input name="activo" type="checkbox" <?php echo statusCheck("$status"); ?> value="T" />
        <?php
        if ($tabla == 'cargos') {
          echo 'Planificable: <input name="planificable" type="checkbox" ' . statusCheck("$planificable") . ' value="T"/>';
        }
        ?>
        <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Descripci&oacute;n: </td>
      <td id="input02"><input type="text" name="descripcion" maxlength="60" style="width:250px" value="<?php echo $descripcion; ?>" /><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <?php
    if ($tabla == 'ficha_egreso_motivo') {
      echo  '<tr>
          <td class="etiqueta">Motivo:</td>
          <td id="radio01_5" class="texto">
            Renuncia <input type="radio" name="motivo" value="R" style="width:auto"' .  CheckX($motivo, 'R') . ' />
            Despido <input type="radio" name="motivo" value="D" style="width:auto"' .  CheckX($motivo, 'D') . ' /><br />
            <span class="radioRequiredMsg">Debe seleccionar un Campo.</span>
          </td>
        </tr>';
    }
    if ($tabla == 'cargos') {
      echo '<tr>
            <td class="etiqueta">Tipo:</td> 
            <td>
            <select id="tipo" name="tipo" style="width:200px" required>
            <option value="' . $result["cod_tipo"] . '">' . $result["tipo"] . ' </option>';
      while ($datos = $bd->obtener_fila($query_tipos)) {
        if ($datos[0] != $result["cod_tipo"]) {
          echo '<option value="' . $datos[0] . '">' . $datos[1] . ' </option>';
        }
      }
      echo '</select>
            </td>    
          </tr>';
    }
    if ($tabla == 'documentos_cl') {
      echo '<tr>
            <td class="etiqueta">Orden:</td> 
            <td>
            <input type="number" name="orden" style="width:250px" value="' . $orden . '" /><br />
            <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
            </td>    
          </tr>';
    }
    ?>
    <tr>
      <td height="8" colspan="2" align="center">
        <hr>
      </td>
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
  <input name="metodo" id="metodo" type="hidden" value="<?php echo $metodo; ?>" />
  <input name="tabla" id="tabla" type="hidden" value="<?php echo $tabla; ?>" />
  <input name="usuario" id="usuario" type="hidden" value="<?php echo $usuario; ?>" />
  <input name="href" type="hidden" value="<?php echo $archivo2; ?>" />
</fieldset>
<script type="text/javascript">
  var input01 = new Spry.Widget.ValidationTextField("input01", "none", {
    validateOn: ["blur", "change"]
  });
  var input02 = new Spry.Widget.ValidationTextField("input02", "none", {
    validateOn: ["blur", "change"]
  });
  var radio01_5 = new Spry.Widget.ValidationRadio("radio01_5", {
    validateOn: ["change", "blur"]
  });
</script>