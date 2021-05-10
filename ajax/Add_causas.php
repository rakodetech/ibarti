<?php
define("SPECIALCONSTANT", true);
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../" . class_bdI);
$bd = new DataBase();

$motivo   = $_POST['motivo'];
$sql = "  SELECT codigo, descripcion 
FROM ficha_egreso_motivo  WHERE status = 'T' AND motivo = '$motivo' AND ficha_egreso_motivo.codigo <> '$cod_motivo_egreso' ORDER BY 2 ASC";
$query = $bd->consultar($sql);
echo '<option value="">Seleccione</option>';
while ($datos = $bd->obtener_fila($query)) {
	echo '<option value="' . $datos[0] . '">' . $datos[1] . '</option>';
};
