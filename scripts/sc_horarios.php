<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$tabla    = 'ficha';

$codigo           = $_POST['codigo']; 
$nombre           = htmlentities($_POST['nombre']);
$concepto         = $_POST['concepto'];
$h_entrada        = $_POST['h_entrada'];
$h_salida         = $_POST['h_salida'];
$inicio_m_entrada = $_POST['inicio_m_entrada'];
$fin_m_entrada    = $_POST['fin_m_entrada'];
$inicio_m_salida  = $_POST['inicio_m_salida'];
$fin_m_salida     = $_POST['fin_m_salida'];

$dia_trabajo     = $_POST['dia_trabajo'];
$minutos_trabajo = $_POST['minutos_trabajo'];


$status   = $_POST['activo']; 
$href     = $_POST['href'];
$usuario  = $_POST['usuario']; 
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];

$href     = $_POST['href'];

if(isset($_POST['proced'])){
    $sql    = "$SELECT $proced('$metodo', '$codigo', '$nombre',  '$concepto',
                               '$h_entrada', '$h_salida', '$inicio_m_entrada', '$fin_m_entrada',
							   '$inicio_m_salida', '$fin_m_salida', '$dia_trabajo', '$minutos_trabajo',
					   	       '$usuario', '$status')";						  
	 $query = $bd->consultar($sql);	 

	}
	require_once('../funciones/sc_direccionar.php');  	 
?>