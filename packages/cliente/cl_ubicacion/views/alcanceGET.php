<?php
define("SPECIALCONSTANT", true);
require("../../../../autentificacion/aut_config.inc.php");
require_once("../../../../".class_bdI);
$bd = new DataBase();
$result = array();

$typing     = $_GET['q'];

$sql = "SELECT productos.codigo, productos.descripcion, 
CONCAT(productos.descripcion,' (',productos.item,') ') descripcionFull, productos.item              
FROM productos 
WHERE (LOCATE('$typing', productos.codigo) OR LOCATE('$typing', productos.descripcion))         
ORDER BY 2 DESC";
$query = $bd->consultar($sql);
while ($datos=$bd->obtener_fila($query,0)){
    array_push($result, $datos);
}
print_r(json_encode($result));
return json_encode($result);
?>