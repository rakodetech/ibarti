<?php
require "../modelo/stock_ubic_alcance_modelo.php";

$fecha_desde = conversion($_POST['fecha_desde']);
$fecha_hasta = conversion($_POST['fecha_hasta']);
$tipo_mov = $_POST['tipo_mov'];
$proveedor = $_POST['proveedor'];
$referencia = $_POST['referencia'];

$stock_ubic_alcance    = new stock_ubic_alcance;
$lista     = $stock_ubic_alcance->buscar($fecha_desde,$fecha_hasta,$tipo_mov,$proveedor,$referencia);

foreach ($lista as  $datos) {
 echo '<tr onclick="Form_stock_ubic_alcance(\''.$datos["codigo"].'\', \'modificar\',\''.$datos["cod_tipo"].'\',\''.$datos["anulado"].'\')">
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
