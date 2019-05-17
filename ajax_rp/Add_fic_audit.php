<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../" . class_bd;
require "../" . Leng;
$bd = new DataBase();
$where = "";
$f_d = $_POST["fecha_desde"];
$f_h = $_POST["fecha_hasta"];
$ficha = $_POST["ficha"];
$usuario = $_POST["user"];
$cod_accion = $_POST["accion"];
$campo = $_POST['campo'];
if ($f_d != "" && $f_h != "") {
    $where .= " AND audit_ficha.fecha BETWEEN '$f_d' AND '$f_h'";
}

if ($ficha != "") {
    $where .= " AND audit_ficha.cod_ficha = '$ficha'";
}

if ($usuario != "") {
    $where .= " AND men_usuarios.codigo = '$usuario'";
}

if ($cod_accion != "") {
    $where .= " AND acciones.codigo = '$cod_accion'";
}

if ($campo != "") {
    $where .= " AND audit_ficha_det.campo = '$campo'";
}

$sql =
    "SELECT
        audit_ficha.fecha,
        audit_ficha.hora,
        CONCAT(
            men_usuarios.nombre,
            ' ',
            men_usuarios.apellido
        ) usuario,
        audit_ficha.cod_ficha,
        acciones.descripcion accion,
        audit_ficha_det.campo,
        audit_ficha_det.valor_ant,
        audit_ficha_det.valor_new
    FROM
        audit_ficha,
        men_usuarios,
        acciones,
        audit_ficha_det
    WHERE audit_ficha.cod_us_ing = men_usuarios.codigo
    AND audit_ficha.cod_accion = acciones.codigo
    AND audit_ficha_det.cod_audit = audit_ficha.codigo
    " . $where;

//echo $sql;

?>
<table width="100%" border="0" >
    
    <tr class="fondo00">
        <th width="10%" class="etiqueta">Fecha</th>
        <th width="10%" class="etiqueta">Hora</th>
        <th width="15%" class="etiqueta">Usuario</th>
        <th width="5%" class="etiqueta">Ficha</th>
        <th width="20%" class="etiqueta">Accion</th>
        <th width="15%" class="etiqueta">Campo</th>
        <th width="10%" class="etiqueta">Valor Anterior</th>
        <th width="10%" class="etiqueta">Valor Actual</th>
    </tr><?php
            $valor = 0;
            $query = $bd->consultar($sql);

            while ($datos = $bd->obtener_fila($query, 0)) {
                if ($valor == 0) {
                    $fondo = 'fondo01';
                    $valor = 1;
                } else {
                    $fondo = 'fondo02';
                    $valor = 0;
                }
                echo '<tr class="' . $fondo . '" >
        <td class="texto" style="text-align:center;" >' . $datos["fecha"] . '</p></td>
        <td class="texto" style="text-align:center;" >' . $datos["hora"] . '</td>
        <td class="texto" style="text-align:center;">' . $datos["usuario"] . '</td>
        <td class="texto" style="text-align:center;">' . $datos["cod_ficha"] . '</td>
        <td class="texto" style="text-align:center;">' . $datos["accion"] . '</td>
        <td class="texto" style="text-align:center;">' . $datos["campo"] . '</td>
        <td class="texto" style="text-align:center;">' . $datos["valor_ant"] . '</td>
        <td class="texto" style="text-align:center;">' . $datos["valor_new"] . '</td>
    </tr>';
            }; ?>
          
</table>