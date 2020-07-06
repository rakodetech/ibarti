<?php
define("SPECIALCONSTANT", true);
require("../../../../autentificacion/aut_config.inc.php");
require_once("../../../../".class_bdI);
$bd = new DataBase();
$result = array();

$typing     = $_GET['q'];
$sql = "SELECT prod_sub_lineas.codigo, prod_sub_lineas.descripcion            
FROM prod_sub_lineas, control
WHERE (LOCATE('$typing', prod_sub_lineas.codigo) OR LOCATE('$typing', prod_sub_lineas.descripcion))   
AND prod_sub_lineas.cod_linea = control.control_uniforme_linea      
ORDER BY 2 DESC";
$query = $bd->consultar($sql);
while ($datos=$bd->obtener_fila($query,0)){
    array_push($result, $datos);
}
print_r(json_encode($result));
return json_encode($result);
?>