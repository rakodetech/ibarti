<script language="javascript">
  $("#add_movimiento_form").on('submit', function(evt){
    evt.preventDefault();
    save_movimiento();
  });
</script>
<?php
require "../modelo/movimiento_modelo.php";
require "../../../../".Leng;
$movimiento = new Movimiento;

$titulo   = "Traslado Entre Almacenes";

$alm       = $movimiento->get_almacenes();
?>
<div>
  <div align="center" class="etiqueta_title"><?php echo $titulo;?></div>

  <form name="add_movimiento" id="add_movimiento_form">

   <table width="95%" align="center">
    <tr>
      <td height="8" colspan="4" align="center"><hr></td>
    </tr>
    <tr>
     <td width="30%" class="etiqueta">Almacen Origen:</td>
     <td width="30%" class="etiqueta">Almacen Destino:</td>
     <td width="40%" class="etiqueta">Descripcion:</td>
   </tr>
   <tr>
    <tr>
    <td> <select id="alm_origen" class="form-control" required onchange="habilitar_destino(this.value)">
      <option value="">Seleccione...</option>
      <?php
      foreach ($alm as  $datos) {
        echo '<option value="'.$datos["codigo"].'">'.$datos["descripcion"].'</option>';
      }?>
    </select>
  </td>

  <td> <select id="alm_destino" class="form-control" onchange="cargar_detalle(this.value);" required>
    <option value="">Seleccione...</option>
    <?php
    foreach ($alm as  $datos) {
      echo '<option value="'.$datos["codigo"].'">'.$datos["descripcion"].'</option>';
    }?>
  </select></td>
  <td>  <textarea id="ped_descripcion"  cols="60" rows="2"></textarea></td>
</tr>

</table>

<div id="detalle">

</div>
</form>
</div>