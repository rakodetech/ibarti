<?php
require "../modelo/ficha_dotacion_modelo.php";
require "../../../".Leng;
$codigo   = $_POST['codigo'];

$pag = 0;
$ficha_dot = new FichaDotacion;
$proced   = "p_ficha_dotacion";
$lineas  =  $ficha_dot->get_lineas();
?>

<table width="95%" align="center">
  <tr>
    <td width="25%" class="etiqueta">Linea</td>
    <td width="25%" class="etiqueta">Sub Linea</td>
    <td width="25%" class="etiqueta" id="talla_etiqueta" style="display: none;">Talla</td>
    <td width="10%" class="etiqueta">Cantidad</td>
    <td width="15%" class="etiqueta" id="add_renglon_etiqueta">Agregar</td>
  </tr>
  <tr>
    <td>
      <select id="dot_linea" onchange="get_sub_lineas(this.value)" style="width:210px">
        <option value="">Seleccione...</option>
         <?php 
        foreach ($lineas as  $datos) {
          echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
        }
        ?>        
      </select>
    </td>
    <td id="sub_lineas">
      <select id="dot_sub_linea" style="width:210px" >
        <option value="">Seleccione...</option>
      </select>
    </td>
    <td id="talla" style="display: none;">
    </td>
     <td>
     <input type="number" id="dot_cantidad" style="width:75px" value="0" min="1" placeholder="">
   </td>
    <td align="center">
      <img  border="null" width="20px" height="20px" src="imagenes/ico_agregar.ico" id="add_renglon" onclick="agregar_renglon()" disabled title="Agregar renglon" />
    </td>
  </tr>
</table>
<table class="tabla_sistema"  width="95%">
  <thead>
    <tr class="fondo00">
      <th>Linea</th>
      <th>SubLinea</th>
      <th>Talla</th>
      <th>Cantidad</th>
      <th></th>
    </tr>
  </thead>
  <tbody id="ficha_dotacion_det">
  </tbody>
</table>