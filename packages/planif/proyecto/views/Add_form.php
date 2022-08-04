<script language="javascript">
  $("#add_proyecto").on('submit', function(evt) {
    evt.preventDefault();
    save_proyecto();
  });
</script>
<?php
require "../modelo/proyecto_modelo.php";
require "../../../../" . Leng;
$horario = new Proyecto;
$metodo = $_POST['metodo'];

if ($metodo == 'modificar') {
  $codigo   = $_POST['codigo'];
  $titulo   = "Modificar Proyecto";
  $rot      =  $horario->editar("$codigo");
} else {
  $titulo    = "Agregar Proyecto";
  $rot      =  $horario->inicio();
}

$sql_areas = "SELECT codigo, descripcion FROM area_proyecto WHERE status = 'T';";
?>
<form action="" method="post" name="add_proyecto" id="add_proyecto">
  <fieldset class="fieldset">
    <legend><?php echo $titulo; ?> </legend>
    <table width="95%" align="center">
      <tr>
        <td width="15%" class="etiqueta">C&oacute;digo:</td>
        <td width="35%"><input type="text" id="r_codigo" readonly value="<?php echo $rot["codigo"]; ?>" />
          Activo: <input id="r_status" type="checkbox" <?php echo statusCheck($rot["status"]); ?> value="T" />
        </td>
        <td width="15%" class="etiqueta">Area de Aplicación:</td>
        <td width="35%">
          <select name="area" id="area_proyecto" style="width:300px;">
            <option value="<?php echo $rot["cod_area"]; ?>"><?php echo $rot["area"]; ?></option>
              <?php 
              $query01 = $bd->consultar($sql_areas);		
            while($row01=$bd->obtener_fila($query01,0)){							   							
              echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
            }?>
          </select>
       </td>
      </tr>
      <tr>
      <td width="15%" class="etiqueta">Abrev:</td>
        <td width="35%"><input type="text" id="r_abrev" minlength="2" maxlength="16" required value="<?php echo $rot["abrev"]; ?>" /></td>
        <td class="etiqueta">Nombre: </td>
        <td colspan="2"><input type="text" id="r_nombre" minlength="4" maxlength="60" required style="width:300px" value="<?php echo $rot["descripcion"]; ?>" /></td>
      </tr>
    </table>
    <div id="Cont_detalleR" class="tabla_sistema"></div><br><br>
    <div align="center" class="etiqueta_title">Cargos a los que aplica</div>
    <div id="Cont_cargosR" class="tabla_sistema"></div><br><br>
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
        <input type="button" id="volver" value="Volver" onClick="Cons_proyecto_inicio()" class="readon art-button" />
      </span>

      <input name="metodo" id="h_metodo" type="hidden" value="<?php echo $metodo; ?>" />
    </div>
  </fieldset>
</form>