<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
define("SPECIALCONSTANT",true);
require("../autentificacion/aut_config.inc.php");

require("../".Funcion);
require "../".class_bdI;
// require "../".Leng;
$bd = new DataBase();



$matriz         = $_POST['asistencia'];
$cod_apertura = $_POST['cod_apertura'];
$co_cont      = $_POST['co_cont'];

$href     = $_POST['href'];
$usuario  = $_POST['usuario'];
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];


 foreach ($matriz as $valorX){

$ficha     =  $_POST['ficha_'.$valorX.''];
$cliente   = $_POST['cliente_'.$valorX.''];
$ubicacion = $_POST['ubicacion_'.$valorX.''];
$concepto  = $_POST['concepto_'.$valorX.''];

if($concepto != "indefinido"){
$sql = "INSERT INTO asistencia (cod_as_apertura, cod_ficha, cod_cliente, cod_ubicacion,
                                cod_concepto, aplicacion, hora_extra, hora_extra_n,
                                vale, feriado , no_laboral,
                                cod_us_ing, fec_us_ing, cod_us_mod, fec_us_mod)
                        VALUES ($cod_apertura, '$ficha', '$cliente', '$ubicacion',
                                '$concepto', 'ch', '', '',
                                '', 0, 0,
                                '$usuario', current_date, '$usuario', current_date) ON DUPLICATE KEY UPDATE
		                            cod_concepto        = '$concepto',     cod_us_mod   = '$usuario',
                       fec_us_mod = current_date; ";
// echo $sql, "<br />";
   $query = $bd->consultar($sql);

   }

 }
 require_once('../funciones/sc_direccionar.php');
?>
