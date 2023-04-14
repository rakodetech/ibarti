<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$fila1  = $_POST['fila1'];
$fila2  = $_POST['fila2'];
$fila3  = $_POST['fila3'];
$fila4  = $_POST['fila4'];

if(isset($_POST['fila1'])){
   $sql = "INSERT INTO control_rfid (cod_concepto_viene,cod_concepto_planif,feriado,cod_concepto_registro) 
					   VALUES ('$fila1','$fila2','$fila3','$fila4')";
    $query = $bd->consultar($sql);
                
}

require_once('../funciones/sc_direccionar.php');
?>