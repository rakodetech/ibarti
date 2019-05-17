<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$tabla    = 'asistencia';

$apertura       = $_POST['apertura'];
$contracto      = $_POST['contracto'];
$trabajador     = $_POST['trabajador'];
$cliente        = $_POST['cliente'];
$ubicacion      = $_POST['ubicacion'];
$ubicacion_old  = $_POST['ubicacion_old'];
$concepto       = $_POST['concepto'];
$concepto_old   = $_POST['concepto_old'];
$horaD          = $_POST['horaD'];
$horaN          = $_POST['horaN'];
$vale           = $_POST['vale'];
$feriado        = $_POST['feriado'];
$NL             = $_POST['NL'];

$href     = $_POST['href'];
$usuario  = $_POST['usuario'];
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];

$i = $_POST['metodo'];

//  PROBLEMAS CON LA FECHA EN APERTURA DE FECHA

if (isset($_POST['metodo'])) {
	switch ($i) {
    case 'agregar':
	case 'modificar':
	case 'borrar':
//	 	 begin();


 	$sql    = "$SELECT $proced('$metodo', '$apertura', '$trabajador',  '$cliente',
                               '$ubicacion', '$ubicacion_old', '$concepto', '$concepto_old',
							   '$horaD', '$horaN', '$vale', '$feriado',
							   '$NL', '$usuario')";

	 $query = $bd->consultar($sql);

   	 $sql = "SELECT v_ficha.nombres, conceptos.descripcion
               FROM v_ficha, conceptos
              WHERE v_ficha.cod_ficha = '$trabajador'
                AND conceptos.codigo = '$concepto'";

   	$query = $bd->consultar($sql);
    $row = $bd->obtener_fila($query,0);
	echo	$mensaje = 'Se Actualizo: &nbsp; '.$row[0].', ('.$trabajador.'), Concepto:  '.$row[1].'';

	break;
	}
}
require_once('../funciones/sc_direccionar.php');
?>
