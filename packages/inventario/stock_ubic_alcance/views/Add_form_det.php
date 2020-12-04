 <?php
  require "../modelo/stock_ubic_alcance_modelo.php";
  require "../../../../" . Leng;
  $stock_ubic_alcance = new stock_ubic_alcance;
  $metodo = $_POST['metodo'];
  $cod_tipo   = $_POST['cod_tipo'];
  $cliente   = $_POST['cliente'];
  if ($metodo == 'modificar') {
    $codigo   = $_POST['codigo'];
    $ped      =  $stock_ubic_alcance->editar($codigo);
  } else {
    $ped       = $stock_ubic_alcance->inicio();
    $codigo    = -1;
  }
  $ubicaciones = $stock_ubic_alcance->get_ubicaciones($cliente);
  $aplicar = $stock_ubic_alcance->get_tipo_aplicar($cod_tipo);
  $reng       = $stock_ubic_alcance->get_aj_reng($codigo);
  if ($metodo == "agregar") {
  ?>
   <table width="95%" align="center">
     <tr>
       <td width="40%" class="etiqueta">Ubicación</td>
       <td width="30%" class="etiqueta"><?php echo $leng['producto']; ?>
         <input type="hidden" name="trabajador" id="stdID" value="" /></td>
       <td width="20%" class="etiqueta">Cantidad</td>
       <td width="10%" class="etiqueta" id="add_renglon_etiqueta">Opciones</td>
     </tr>
     <tr>
       <td>
         <select id="ped_ubicacion" onchange="Selec_ubicacion(this.value)" style="width:300px">
           <option value="">Seleccione...</option>
           <?php
            foreach ($ubicaciones as  $datos) {
              echo '<option value="' . $datos["codigo"] . '">' . $datos["descripcion"] . '</option>';
            } ?>
         </select>
       </td>
       <td>
         <input type="text" id="ped_producto" value="" placeholder="Buscar <?php echo $leng['producto']; ?> en el alcance de la ubicación" disabled="true" style="width:250px" />
       </td>
       <td>
         <input type="number" id="ped_cantidad" style="width:100px" value="0" min="0" placeholder="">
       </td>
       <td align="center">
         <img border="null" width="20px" height="20px" src="imagenes/ico_agregar.ico" id="add_renglon" onclick="Agregar_renglon()" disabled title="Agregar renglon" />
         <img border="null" width="20px" height="20px" src="imagenes/borrar.bmp" id="canc_renglon" onclick="Cancelar_renglon()" hidden title="Cancelar renglon" />
         <img border="null" width="20px" height="20px" src="imagenes/actualizar.bmp" id="update_renglon" onclick="Actualizar_renglon()" hidden title="Actualizar renglon" />
       </td>
     </tr>
   </table>
 <?php } ?>
 <table width="95%" class="tabla_sistema">
   <thead>
     <tr>
       <th width="10%">N.</th>
       <th width="35%">N producto</th>
       <th width="25%">Ubicación</th>
       <th width="10%">Cantidad</th>
       <th width="20%"></th>
     </tr>
   </thead>
   <tbody id="listar_stock_ubic_alcance">
     <?php
      foreach ($reng as  $datos) {
        echo '
      <tr id="tr_' . $datos["reng_num"] . '">
      <td><input type="text" id="items_' . $datos["reng_num"] . '" value="' . $datos["reng_num"] . '" readonly style="width:100px"></td>
      <td><input type="hidden" id="prod_' . $datos["reng_num"] . '" value="' . $datos["producto"] . ' ' . $datos["serial"] . '">
      ' . $datos["producto"] . ' (' . $datos["serial"] . ')</td>
      <td><input type="hidden" id="ubicacion_' . $datos["reng_num"] . '" value="' . $datos["ubicacion"] . '">' . $datos["ubicacion"] . '</td>
      <td><input type="text" id="cant_' . $datos["reng_num"] . '" value="' . $datos["cantidad"] . '" readonly style="width:100px"></td>';
        if ($metodo == "agregar") {
          echo '<td><img class="imgLink" border="null" width="20px" height="20px" src="imagenes/actualizar.bmp"  id="update_renglon" onclick="Modificar_renglon(' . $datos["reng_num"] . ')" title="Modificar Registro />&nbsp; <img class="imgLink" border="null" width="20px" height="20px" src="imagenes/borrar.bmp" id="canc_renglon" onclick="Borrar_renglon(' . $datos["reng_num"] . ')" title="Borrar Registro" /></td></tr>';
        } else {
          echo "<td></td></tr>";
        }
      } ?>
   </tbody>
 </table>
 <br>

 <input id="ped_aplicar" type="hidden" value="<?php echo $aplicar[0]; ?>" class="text-right">


 <script language="JavaScript" type="text/javascript">
   new Autocomplete("ped_producto", function() {
     this.setValue = function(id) {
       $("#stdID").val(id);
       Selec_producto(id);
     }
     if (this.value.length < 1) return;
     ubic = $("#ped_ubicacion").val();
     return "autocompletar/tb/producto_base_serial_alcance.php?q=" + this.text.value + "&filtro=codigo&ubic=" + ubic + "";
   });
 </script>