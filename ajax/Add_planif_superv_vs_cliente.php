<?php
define("SPECIALCONSTANT", true);
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require_once "../" . class_bdI;
require_once "../" . Leng;
$bd = new DataBase();
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];
$estado  = $_POST['estado'];
$region  = $_POST['region'];
$fecha_D    = conversion($_POST['fecha_desde']);
$fecha_H    = conversion($_POST['fecha_hasta']);

$WHERE = " WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\" ";

if ($region != "TODOS") {
    $WHERE .= " AND a.cod_region = '$region' ";
}

if ($estado != "TODOS") {
    $WHERE .= " AND a.cod_estado = '$estado' ";
}

if ($cliente != "TODOS") {
    $WHERE .= " AND a.cod_cliente = '$cliente' ";
}

if ($ubicacion != "TODOS") {
    $WHERE .= " AND a.cod_ubicacion = '$ubicacion' ";
}


// QUERY A MOSTRAR //
$sql = "SELECT fecha, region, estado, cliente, ubicacion, cantidad, contratacion, diff FROM v_semaforo_supervision a
        $WHERE  ";
?>
<table width="100%" border="0" align="center">
    <tr class="fondo00">
        <th width="15%" class="etiqueta">Fecha</th>
        <th width="15%" class="etiqueta"><?php echo $leng['region'] ?></th>
        <th width="15%" class="etiqueta"><?php echo $leng['estado'] ?></th>
        <th width="20%" class="etiqueta"><?php echo $leng['cliente'] ?></th>
        <th width="20%" class="etiqueta"><?php echo $leng['ubicacion'] ?></th>
        <th width="5%" class="etiqueta">Cantidad</th>
        <th width="5%" class="etiqueta">Contratación</th>
        <th width="5%" class="etiqueta">Diferencia</th>
    </tr>
    <?php
    $valor = 0;
    $query = $bd->consultar($sql);

    while ($datos = $bd->obtener_fila($query, 0)) {
        if ($datos["diff"] == 0) {
            $fondo = 'fondo01';
        } else if ($datos["diff"] < 0) {
            $fondo = 'fondo03';
        } else if ($datos["diff"] > 0) {
            $fondo = 'fondo02';
        }
        echo '<tr class="' . $fondo . '">
			<td class="texto" id="center">' . $datos["fecha"] . '</td>
			<td class="texto" id="center">' . $datos["region"] . '</td>
			<td class="texto" id="center">' . $datos["estado"] . '</td>
			<td class="texto" id="center">' . $datos["cliente"] . '</td>
            <td class="texto" id="center">' . $datos["ubicacion"] . '</td>
            <td class="texto" id="center">' . $datos["cantidad"] . '</td>
            <td class="texto" id="center">' . $datos["contratacion"] . '</td>
            <td class="texto" id="center">' . $datos["diff"] . '</td>
			</tr>';
    }; ?>
</table>
<br>