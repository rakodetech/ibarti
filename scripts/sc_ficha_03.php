<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$tabla    = 'ficha';

$codigo          = $_POST['codigo']; 
$codigo_fam      = $_POST['codigo_fam'];
$nombre_fam      = htmlspecialchars($_POST['nombre_fam']);
$fec_nac         = conversion($_POST['fec_nacimiento_fam']);
$sexo_fam        = $_POST['sexo_fam'];
$parentesco_fam  = htmlspecialchars($_POST['parentesco_fam']);

$href     = $_POST['href'];
$usuario  = $_POST['usuario']; 
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];

$href     = $_POST['href'];

if(isset($_POST['proced'])){
     $sql    = "$SELECT $proced('$metodo', '$codigo', '$codigo_fam', '$parentesco_fam',
                                '$nombre_fam', '$fec_nac', '$sexo_fam')";						  
	 $query = $bd->consultar($sql);	 

	}
	require_once('../funciones/sc_direccionar.php');  	 
?>