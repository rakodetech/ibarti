<?php
define("SPECIALCONSTANT",true);
require "../../../../autentificacion/aut_config.inc.php";
include_once('../../../../funciones/funciones.php');
require_once "../../../../".class_bdI;
require_once "../../../../".Leng;
$bd = new DataBase();

$reporte      = $_POST['reporte'];
$archivo = "reporte_perfil";
$titulo       = "Reporte Perfil VS Menu ";

if(isset($reporte)){
    echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: filename=\"$archivo.xls\";");

    echo "<table border=1>";
    echo $_POST['reporte'];
    echo "</table>";

  
}

?>
