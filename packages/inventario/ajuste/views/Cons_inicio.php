<?php
require "../modelo/ajuste_modelo.php";
require "../../../../".Leng;
$titulo     = "Movimiento";
$ajuste  = new Ajuste;
$listar  =  $ajuste->get();
?>

<div align="center" class="etiqueta_title"><?php echo $titulo;?></div>

<form name="bus_ajuste" id="bus_ajuste" style="float: right;">
  <label>Buscar ajuste </label>
  <input type="text"id="data_buscar_ajuste" class="form-control"  placeholder="Ingrese dato del ajuste" />
  <input type="submit" name="buscarHorario" id="buscarHorario" hidden="">
  <span class="art-button-wrapper">
   <img border="null" width="25px" height="25px" src="imagenes/buscar.bmp" title="Buscar Registro" onclick="buscar_ajuste(true);"/> 
 </span>
 <span class="art-button-wrapper">
   <img border="null" width="25px" height="25px" src="imagenes/ico_agregar.ico" id="agregar_mascota" onclick="Form_ajuste('','agregar')" title="Agregar Registro"/>
 </span>
</form>

<div class="tabla_sistema listar">
  <table  width="100%" border="0" align="center">
    <thead>
      <tr>
        <th>N. Ajuste</th>
        <th>Fecha</th>
        <th>Tipo</th>
        <th>Descripcion</th>
        <th>Monto</th>
      </tr>
    </thead>
    <tbody id="listar_ajuste">
      <?php
      foreach ($listar as  $datos) {

        echo '
        <tr onclick="Form_ajuste(\''.$datos["codigo"].'\', \'modificar\',\''.$datos["cod_tipo"].'\',\''.$datos["anulado"].'\')">
        <td>'.$datos["codigo"].'</td>
        <td>'.$datos["fecha"].'</td>
        <td>'.$datos["tipo"].'</td>
        <td>'.$datos["motivo"].'</td>
        <td>'.$datos["total"].'</td>
        </tr>';
      } ?>

    </tbody>
  </table>
</div>
