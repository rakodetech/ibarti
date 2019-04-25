<?php 
require("../autentificacion/aut_config.inc.php");
// Inicio la sesi�n
session_start();
header("Cache-control: private"); // Arregla IE 6
 // descoloco todas la variables de la sesi�n
 session_unset();

 // Destruyo la sesi�n
 session_destroy();
  $sitio    = Sitio;
  $carpeta = Carpeta;
 //Y me voy al inicio
 header("Location: ".$sitio."/".$carpeta."/");
     echo "<html></html>";
//   exit;

?> 