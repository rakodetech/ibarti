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
$ped       = $movimiento->inicio();
$codigo    = 0;

$reng       = $movimiento->get_mov_reng($codigo);
?>

<div>
  <table width="95%" align="center">
    <tr>
      <td height="8" colspan="6" align="center"><hr></td>
    </tr>
     <tr>
      <td width="25%" class="etiqueta">Buscar <?php echo $leng['producto'];?></td>
      <td width="5%"></td>
      <td width="40%" class="etiqueta"><?php echo $leng['producto'];?></td>
      <td width="20%" class="etiqueta">Cantidad</td>
      <td width="10%" class="etiqueta" id="add_renglon_etiqueta">Agregar</td>
    </tr>
    <tr>
      <td>       
        <input type="text"id="ped_filtro_producto" value="" placeholder="Ingrese Dato del <?php echo $leng['producto'];?>" style="width:220px"/>
      </td>
      <td>
        <img border="null" width="25px" height="25px" src="imagenes/buscar.bmp" onclick="buscar_producto();" id="buscarProducto" title="Buscar Producto"/>
        <input type="submit"  hidden="">
      </td>
    </td>
    <td>
      <select id="ped_producto" onchange="Selec_producto(this.value)" style="width:300px">
        <option value="">Seleccione...</option>
      </select>
    </td>
    <td>
     <input type="number" id="ped_cantidad" style="width:100px"  disabled  value="0" min="0"   placeholder="">
   </td>
      <td align="center">
    <img  border="null" width="20px" height="20px" src="imagenes/ico_agregar.ico" id="add_renglon" onclick="Agregar_renglon()" disabled title="Agregar renglon" />
    <img  border="null" width="20px" height="20px" src="imagenes/borrar.bmp" id="canc_renglon" onclick="Cancelar_renglon()" hidden title="Cancelar renglon" />
    <img  border="null" width="20px" height="20px" src="imagenes/actualizar.bmp"  id="update_renglon" onclick="Actualizar_renglon()" hidden title="Actualizar renglon" />
  </td>
   </tr>
  </table>

  <table width="95%" class="tabla_sistema">
  <thead>
    <tr>
      <th width="10%">N.</th>
      <th width="50%">Producto</th>
      <th width="30%">Cantidad</th>
      <th width="10%"></th>
    </tr>
  </thead>
  <tbody id="listar_movimiento">
    <?php
    foreach ($reng as  $datos) {
      /*echo '
      <tr id="tr_'.$datos["reng_num"].'">
      <td><input type="text" id="items_'.$datos["reng_num"].'" value="'.$datos["reng_num"].'" readonly style="width:100px"></td>
      <td><input type="text" id="prod_'.$datos["reng_num"].'" value="'.$datos["producto"].'" readonly style="width:200px"></td>
      <td><input type="text" id="alm_'.$datos["reng_num"].'" value="'.$datos["almacen"].'" readonly style="width:120px"></td>
      <td><input type="text" id="cant_'.$datos["reng_num"].'" value="'.$datos["cantidad"].'" readonly style="width:100px"></td>
      <td><input type="text" id="costo_'.$datos["reng_num"].'" value="'.$datos["costo"].'" readonly style="width:100px"></td>
      <td><input type="text" id="neto_'.$datos["reng_num"].'" value="'.$datos["neto"].'" readonly style="width:150px"></td>';
      if($metodo == "agregar"){
        echo '<td><img class="imgLink" border="null" width="20px" height="20px" src="imagenes/actualizar.bmp"  id="update_renglon" onclick="Modificar_renglon('.$datos["reng_num"].')" title="Modificar Registro />&nbsp; <img class="imgLink" border="null" width="20px" height="20px" src="imagenes/borrar.bmp" id="canc_renglon" onclick="Borrar_renglon('.$datos["reng_num"].')" title="Borrar Registro" /></tr>';
      }
    */} ?>
  </tbody>
</table>
<br>
<div style="width: 95%" align="right">
  Total:
  <input id="ped_total" type="text" value="<?php echo $ped['total'];?>" class="text-right" readonly>
</div>
 <br>
    <div align="center">
       <span class="art-button-wrapper">
       <span class="art-button-l"> </span>
       <span class="art-button-r"> </span>
       <input  type="submit" title="Guardar Registro" class="readon art-button" value="Guardar" />
       </span>

       <span class="art-button-wrapper">
       <span class="art-button-l"> </span>
       <span class="art-button-r"> </span>
       <input type="reset" title="Restaurar Valores" class="readon art-button"  value="Restaurar" />
       </span>';

    <!--<span class="art-button-wrapper">
      <span class="art-button-l"> </span>
      <span class="art-button-r"> </span>
      <input type="button"  title="Volver a la página anterior" onclick="Cons_ajuste()" class="readon art-button"  value="Volver" />
    </span>-->
  </div>