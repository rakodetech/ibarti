<?php
define("SPECIALCONSTANT", true);
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../" . class_bdI);
$bd = new DataBase();

//require_once('../autentificacion/aut_config.inc.php'); 
//include_once('../funciones/mensaje_error.php');
$codigo   = $_POST['codigo'];
$WHERE = ' WHERE planif_actividad.participantes = "T" ';
if ($codigo != 'TODOS' && $codigo != '') {
	$WHERE .= " AND cod_proyecto = '$codigo' ";
}
$sql = " SELECT
	planif_actividad.codigo,
	planif_actividad.descripcion
FROM
	planif_actividad
$WHERE
ORDER BY
	2 ASC";
$query = $bd->consultar($sql);

echo '<option value="TODOS">TODOS</option>';
while ($datos = $bd->obtener_fila($query)) {
	echo '<option value="' . $datos[0] . '">' . $datos[1] . '</option>';
};
