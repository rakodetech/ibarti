<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 574;
require("../autentificacion/aut_config.inc.php");
include_once('../'.Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$clasif = $_POST['clasif'];

$sql = "SELECT codigo,descripcion FROM nov_valores where cod_clasif_val ='".$clasif."'";
$query01  = $bd->consultar($sql);
while ($row01 = $bd->obtener_num($query01)){
    echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
}
?>