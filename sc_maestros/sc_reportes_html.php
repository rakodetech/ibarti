<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
//include_once('../funciones/mensaje_error.php');

$codigo      = htmlentities($_POST['codigo']);
$modulo      = $_POST["modulo"];
$descripcion = $_POST["descripcion"];			
$doc_html    = htmlentities($_POST["doc_html"]);			
$orden       = $_POST["orden"];			

$activo      = statusbd($_POST['activo']);
$proced      = $_POST['proced'];
$metodo      = $_POST["metodo"];
$cp01        = "";
$cp02        = "";
$cp03        = "";
$cp04        = "";
$href        = $_POST['href'];
$usuario     = $_POST['usuario']; 

  $sql    = ''.$SELECT.' '.$proced.'("'.$metodo.'", "'.$codigo.'", "'.$modulo.'", "'.$descripcion.'", 
                             "'.$doc_html.'",  "'.$orden.'",
							  "'.$cp01.'", "'.$cp02.'", "'.$cp03.'", "'.$cp04.'",  "'.$usuario.'", "'.$activo.'")';						  

  $query = $bd->consultar($sql);	  	
  
 require_once('../funciones/sc_direccionar.php');  
?>
