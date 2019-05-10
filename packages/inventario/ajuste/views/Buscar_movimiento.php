<?php
$data = $_POST['data'];


require "../modelo/ajuste_modelo.php";
$ajuste    = new Ajuste;
$lista     = $ajuste->buscar($data);

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
