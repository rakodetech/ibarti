<?php
define("SPECIALCONSTANT", true);
require "../autentificacion/aut_config.inc.php";
require "../".class_bdI;
require "../".Leng;
$bd = new DataBase();

$apertura = $_POST['codigo'];
$cliente  = $_POST['cliente'];
$result = array();
    $sql = "SELECT a.codigo, a.descripcion, a.fecha_inicio
              FROM clientes_contratacion a, planif_cliente b
             WHERE a.cod_cliente = '$cliente'
               AND b.codigo = '$apertura'
               AND a.fecha_inicio <= b.fecha_inicio
          ORDER BY a.fecha_inicio DESC
             LIMIT 0, 1";
	$qry  = $bd->consultar($sql);
    while($rows=$bd->obtener_name($qry)){
     $result[] = $rows;
   }
 print_r(json_encode($result));
return json_encode($result);
?>
