<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$result = array();
$ficha   = $_POST['ficha'];
$producto    = $_POST['producto'];
$cod_talla    = $_POST['cod_talla'];

 $sql = "SELECT ficha_dotacion.cod_talla cod_talla
    FROM ficha_dotacion,productos 
WHERE productos.item = '$producto' 
AND ficha_dotacion.cod_ficha = '$ficha'
AND ficha_dotacion.cod_sub_linea = productos.cod_sub_linea
AND ficha_dotacion.cod_talla ='$cod_talla'";
 $query = $bd->consultar($sql);
$result = $bd->obtener_fila($query,0);
echo json_encode($result);
mysql_free_result($query);
?>
