<?php

require "../model/dotacion_modelo.php";

$listado      = new dotaciones;

$cantidad = $listado->obtener_procesos('almacen');
$titulo = "Lotes"
//echo json_encode($cantidad);
?>

<div align="center" class="etiqueta_title"> Consulta De <?php echo $titulo;?> </div> <hr />
<div class="tabla_sistema listar"><table width="100%" border="0" align="center">
  <tr>
    <th width="12%">Codigo</th>
    <th width="12%">Fecha</th>
    <th width="32%">Usuario Mod.</th>
    <th width="22%">Status</th>
    <th width="14%" >Anulado</th>
   <th width="6%" align="center"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="cons_inicio('vista_dotacion', 'agregar')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>
  </tr>
  <?php
    foreach ($cantidad as  $datos) {
      echo '<tr title="Seleccione para ver detalles" onclick="llenar_consulta(\''.$datos["codigo"].'\',\'vista_dotacion\', \'\')">
              <td>'.$datos["codigo"].'</td>
              <td>'.$datos["fecha"].'</td>
              <td>'.$datos["nombre"].'</td>
              <td>'.$datos["estatus"].'</td>
              <td>'.$datos["anulado"].'</td>
              <td></td>';
        }
  	?>
    </table>
</div>
