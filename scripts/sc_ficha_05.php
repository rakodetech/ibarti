<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$tabla    = 'ficha';

$codigo          = $_POST['codigo'];
$fec_egreso      = conversion($_POST['fec_egreso']);
$motivo          = $_POST['motivo'];
$color          = $_POST['color'];
$preaviso        = $_POST['preaviso'];
$p_fec_inicio    = conversion($_POST['p_fec_inicio']);
$p_fec_culminacion = conversion($_POST['p_fec_culminacion']);
$d_p_laboral     = $_POST['d_p_laboral'];
$d_p_cumplido    = $_POST['d_p_cumplido'];
$calculo         = $_POST['calculo'];
$calculo_status  = $_POST['calculo_status'];

$fec_calculo     = conversion($_POST['fec_calculo']);
$fec_posible_pago= conversion($_POST['fec_posible_pago']);
$fec_pago        = conversion($_POST['fec_pago']);
$cheque          = $_POST['cheque'];
$banco           = $_POST['banco'];
$importe         = $_POST['importe'];
$entrega_uniforme = $_POST['entrega_uniforme'];
$observacion     = htmlspecialchars($_POST['observacion']);
$observacion2    = htmlspecialchars($_POST['observacion2']);
$status          = $_POST['status'];
if($p_fec_inicio == ''){
	$p_fec_inicio='0000-00-00';
}
if($p_fec_culminacion == ''){
	$p_fec_culminacion='0000-00-00';
}
if($d_p_laboral == ''){
	$d_p_laboral='0';
}
if($d_p_cumplido == ''){
	$d_p_cumplido='0';
}
if($importe == ''){
	$importe='0';
}
if($fec_calculo == 'AAAA-MM-DD'){
	$fec_calculo='0000-00-00';
}
if($fec_posible_pago == 'AAAA-MM-DD'){
	$fec_posible_pago='0000-00-00';
}
if($fec_pago == 'AAAA-MM-DD'){
	$fec_pago='0000-00-00';
}


$href     = $_POST['href'];
$usuario  = $_POST['usuario'];
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];

if(isset($_POST['proced'])){
 $sql    = "$SELECT $proced('$metodo', '$codigo', '$fec_egreso', '$motivo',
                            '$color', '$preaviso','$p_fec_inicio','$p_fec_culminacion',
							'$d_p_laboral', '$d_p_cumplido','$calculo', '$calculo_status',
							'$fec_calculo', '$fec_posible_pago', '$fec_pago', '$cheque',
							'$banco','$importe','$entrega_uniforme', '$observacion',
							'$observacion2', '$usuario', '$status')";

 $query = $bd->consultar($sql);
	}
require_once('../funciones/sc_direccionar.php');
?>
