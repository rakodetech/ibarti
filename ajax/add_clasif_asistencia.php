<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../" . class_bd);
$bd = new DataBase();

$codigo  = $_POST['codigo'];
$usuario = $_POST['usuario'];
$i       = $_POST['i'];

$sql = "SELECT
          asistencia_clasif.codigo,
          asistencia_clasif.descripcion AS clasif
          FROM
          asistencia_clasif,
          asistencia_clasif_concepto
          WHERE
          asistencia_clasif.codigo = asistencia_clasif_concepto.cod_asistencia_clasif
          AND asistencia_clasif.`status` = 'T'
          AND asistencia_clasif_concepto.cod_concepto = '$codigo'
          ORDER BY 2 ASC";

$query = $bd->consultar($sql);

echo '<select name="clasif_asistencia" id="clasif_asistencia' . $i . '" style="width:120px" required>';
$options = '';
while ($row02 = $bd->obtener_fila($query, 0)) {
     $options .= '<option value="' . $row02[0] . '">' . $row02[1] . '</option>';
}
if ($options == '') {
     echo '<option value="9999">N/A</option>';
} else {
     echo '<option value="">Seleccione</option>';
     echo $options;
}
echo '</select>';
