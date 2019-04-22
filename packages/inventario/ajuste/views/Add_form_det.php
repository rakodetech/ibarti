 <?php
 require "../modelo/ajuste_modelo.php";
 require "../../../../".Leng;
 $ajuste = new Ajuste;
 $metodo = $_POST['metodo'];
 $cod_tipo   = $_POST['cod_tipo'];
 if($metodo == 'modificar')
 {
  $codigo   = $_POST['codigo'];
  $ped      =  $ajuste->editar("$codigo");
}else{
  $ped       = $ajuste->inicio();
  $codigo    = -1;
}
$aplicar = $ajuste->get_tipo_aplicar($cod_tipo);
$reng       = $ajuste->get_aj_reng($codigo);

if($metodo == "agregar"){
  ?>

  <table width="95%" align="center">
    <tr>
      <td width="30%" class="etiqueta"><?php echo $leng['producto'];?>
       <input type="hidden" name="trabajador" id="stdID" value=""/></td>
      <td width="30%" class="etiqueta">Almacen</td>
      <td width="10%" class="etiqueta">Cantidad</td>
      <td width="10%" class="etiqueta">Costo</td>
      <td width="10%" class="etiqueta">Neto</td>
      <td width="10%" class="etiqueta" id="add_renglon_etiqueta">Agregar</td>
    </tr>
    <tr>
      <td>       
        <input type="text"id="ped_producto" value="" placeholder="Ingrese Dato del <?php echo $leng['producto'];?>" style="width:250px"/>
      </td>

    <td>
      <select id="ped_almacen" onchange="Selec_almacen(this.value)"  style="width:250px" >
        <option value="">Seleccione...</option>
      </select>
    </td>
    <td>
     <input type="number" id="ped_cantidad" style="width:100px" onkeyup="Cal_prod_neto('cantidad', this.value)" onchange="Cal_prod_neto('cantidad', this.value)" disabled  value="0" min="0"   placeholder="">
   </td>
   <td>
     <input type="number" id="ped_costo" style="width:100px" onkeyup="Cal_prod_neto('costo', this.value)" onchange="Cal_prod_neto('costo', this.value)" disabled value="0" min="0" step="any" placeholder="">
   </td>
   <td>
     <input type="number" style="width:120px" id="ped_neto" value="0" step="any" placeholder="" readonly>
   </td>
   <td align="center">
    <img  border="null" width="20px" height="20px" src="imagenes/ico_agregar.ico" id="add_renglon" onclick="Agregar_renglon()" disabled title="Agregar renglon" />
    <img  border="null" width="20px" height="20px" src="imagenes/borrar.bmp" id="canc_renglon" onclick="Cancelar_renglon()" hidden title="Cancelar renglon" />
    <img  border="null" width="20px" height="20px" src="imagenes/actualizar.bmp"  id="update_renglon" onclick="Actualizar_renglon()" hidden title="Actualizar renglon" />
  </td>
</tr>
</table>
<?php }?>
<table width="95%" class="tabla_sistema">
  <thead>
    <tr>
      <th width="10%">N.</th>
      <th width="20%">N producto</th>
      <th width="15%">Almacen</th>
      <th width="10%">Cantidad</th>
      <th width="10%">Costo</th>
      <th width="15%">Neto</th>
      <?php if($metodo == "agregar"){?>
        <th width="20%"></th>
      <?php }?>
    </tr>
  </thead>
  <tbody id="listar_ajuste">
    <?php
    foreach ($reng as  $datos) {
      echo '
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
    } ?>
  </tbody>
</table>
<br>
<div style="width: 95%" align="right">
  Total:
  <input id="ped_total" type="text" value="<?php echo $ped['total'];?>" class="text-right" readonly>
</div>
<input id="ped_aplicar" type="hidden" value="<?php echo $aplicar[0];?>" class="text-right">


<script language="JavaScript" type="text/javascript">
  new Autocomplete("ped_producto", function() { 
    this.setValue = function(id) {
      $("#stdID").value = id;
      Selec_producto(id);
    }
    if (this.value.length < 1) return ;
    return "autocompletar/tb/producto_base_serial.php?q="+this.text.value +"&filtro=codigo"});
</script>