<?php
require "../modelo/ajuste_modelo.php";

$fecha_desde = conversion($_POST['fecha_desde']);
$fecha_hasta = conversion($_POST['fecha_hasta']);
$tipo_mov = $_POST['tipo_mov'];
$proveedor = $_POST['proveedor'];

$ajuste    = new Ajuste;
$lista     = $ajuste->buscar($fecha_desde,$fecha_hasta,$tipo_mov,$proveedor);

foreach ($lista as  $datos) {
 echo '<tr onclick="Form_ajuste(\''.$datos["codigo"].'\', \'modificar\')">
                <td>'.$datos["codigo"].'</td>
                <td>'.$datos["referencia"].'</td>
                <td>'.$datos["proveedor"].'</td>
                <td>'.$datos["fecha"].'</td>
                <td>'.$datos["tipo"].'</td>
                <td>'.$datos["motivo"].'</td>
                <td>'.$datos["total"].'</td>
                <td></td>
              </tr>';
          }
?>
