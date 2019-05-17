<?php
include_once('../../../funciones/funciones.php');
require("../../../autentificacion/aut_config.inc.php");
require_once("../../../" . class_bd);
$bd = new DataBase();


$clasificacion = $_POST['clasif'];
$tipo = $_POST['tipo'];
$cedula = $_POST['codigo_trabajador'];
$ficha = $_POST['codigo_supervisor'];
$observacion = $_POST['observacion'];
$respuesta = '';
$usuario = $_POST['usuario'];
$fecha = date("Y-m-d");
$hora = date("H:i:s");
$valores = $_POST['valores'];
$obs = $_POST['obs'];


$sql = "CALL p_nov_check_list_trab('agregar','$clasificacion','$tipo','$ficha','$cedula','$observacion','$respuesta','$usuario','$usuario','01')";
$query01 = $bd->consultar($sql);


$sql = "SELECT MAX(codigo) from nov_check_list_trab";
$query01 = $bd->consultar($sql);
while ($row01 = $bd->obtener_fila($query01, 0)) {
    $codigo = $row01[0];
}

foreach ($valores as $novedad => $valor) {
    $sql = "CALL p_nov_check_list_trab_det('agregar','$codigo','$novedad','$valor','$obs[$novedad]')";
    $query01 = $bd->consultar($sql);
}
?>