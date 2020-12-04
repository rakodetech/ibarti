<script language="javascript">
  $("#add_stock_ubic_alcance_form").on('submit', function(evt) {
    evt.preventDefault();
    save_stock_ubic_alcance();
  });
</script>

<?php
session_start();
require_once('../../../../sql/sql_report_t.php');
require "../modelo/stock_ubic_alcance_modelo.php";
require "../../../../" . Leng;
$stock_ubic_alcance = new stock_ubic_alcance;
$metodo = $_POST['metodo'];

if ($metodo == 'modificar') {
  $anulado   = $_POST['anulado'];
  $codigo   = $_POST['codigo'];
  $titulo   = "Modificar Movimiento";
  $ped      =  $stock_ubic_alcance->editar($codigo);
} else {
  $titulo    = "Agregar Movimiento";
  $ped       = $stock_ubic_alcance->inicio();
  $anulado   = "F";
  $codigo    = 0;
  $tipo       = $stock_ubic_alcance->get_tipo($ped["cod_tipo"]);
}
?>

<div id="add_stock_ubic_alcances">
  <span class="etiqueta_title"><?php echo $titulo; ?></span>

  <form name="add_stock_ubic_alcance" id="add_stock_ubic_alcance_form">

    <div style="float: right;" align="center">
      <img style="display: none;" border="null" width="25px" height="25px" src="imagenes/borrar.bmp" title="Borrar Registro" id="borrar_stock_ubic_alcance" onclick="Borrar_stock_ubic_alcance()" />
      <img style="display: none;" border="null" width="25px" height="25px" src="imagenes/nuevo.bmp" id="agregar_stock_ubic_alcance" title="Agregar Registro" onclick="Agregarstock_ubic_alcance()" />
      <img border="null" width="25px" height="25px" src="imagenes/buscar.bmp" title="Buscar Registro" id="buscar_producto_title" onclick="Cons_stock_ubic_alcance()" />
    </div>
    <table width="95%" align="center">
      <tr>
        <td height="8" colspan="5" align="center">
          <hr>
        </td>
      </tr>
      <tr>
        <td width="14%" class="etiqueta">N. Movimiento:</td>
        <td width="27%" class="etiqueta">Tipo de Movimiento:</td>
        <td width="27%" class="etiqueta">Cliente:</td>
        <td width="20%" class="etiqueta">Fecha</td>
      </tr>
      <tr>
        <td>
          <input type="text" id="ped_codigo" maxlength="160" title="Este codigo es generado por el sistema, al guardar el movimiento" placeholder="Código" value="<?php echo $ped['codigo']; ?>" required readonly>
        </td>
        <td> <input type="hidden" id="ped_cod_tipo" value="<?php echo $ped['cod_tipo']; ?>">
          <select id="ped_tipo" style="width:250px;" required onchange="Selec_tipo()">
            <option value="<?php echo $ped['cod_tipo']; ?>" style="width: 210px;"><?php echo $ped['tipo']; ?></option>
            <?php
            foreach ($tipo as  $datos) {
              echo '<option value="' . $datos["codigo"] . '">' . $datos["descripcion"] . '</option>';
            } ?>
          </select>
        </td>
        <td>
          <select id="ped_cliente" style="width:250px;" required onchange="Selec_tipo()">
            <option value="">Seleccione</option>
            <?php
            $query01 = $bd->consultar($sql_cliente);
            while ($row01 = $bd->obtener_fila($query01, 0)) {
              echo '<option value="' . $row01[0] . '">' . $row01[1] . '</option>';
            } ?>
          </select>
        </td>
        <td>
          <input type="date" id="ped_fecha" value="<?php echo $ped['fecha']; ?>" placeholder="Fecha de Emisión" required>
        </td>
      </tr>
      <tr>
        <td colspan="5" class="etiqueta">Descripcion</td>
      </tr>
      <tr>
        <td colspan="5">
          <textarea id="ped_descripcion" cols="100" rows="3"><?php echo $ped['motivo']; ?></textarea>
        </td>

      </tr>
      <tr>
        <td height="8" colspan="5" align="center">
          <hr>
        </td>
      </tr>
    </table>
    <div id="stock_ubic_alcance_det"></div>
    <br>
    <div align="center">
      <?php if ($metodo == "agregar") {
        echo '<span class="art-button-wrapper">
   <span class="art-button-l"> </span>
   <span class="art-button-r"> </span>
   <input  type="submit" title="Guardar Registro" class="readon art-button" value="Guardar" />
   </span>';
      } else {
        if ($anulado == "F") {;
          if (($ped['cod_tipo'] != "TRAS") && ($ped['cod_tipo'] != "TRAS-")) {
            echo '<span class="art-button-wrapper">
      <span class="art-button-l"> </span>
      <span class="art-button-r"> </span>
      <input type="button" title="Anular stock_ubic_alcance" class="readon art-button" id="anulador" value="Anular" onclick="anular_stock_ubic_alcance()" />
      </span>';
          }
        }
      } ?>
      <span class="art-button-wrapper">
        <span class="art-button-l"> </span>
        <span class="art-button-r"> </span>
        <input type="button" title="Volver a la página anterior" onclick="Cons_stock_ubic_alcance()" class="readon art-button" value="Volver" />
        <input id="ped_metodo" type="text" value="<?php echo $metodo; ?>" hidden>
      </span>
    </div>

  </form>
</div>