<?php 
require("../autentificacion/aut_config.inc.php");
// Inicio la sesión
session_start();
header("Cache-control: private"); // Arregla IE 6
 // descoloco todas la variables de la sesión
 session_unset();

 // Destruyo la sesión
 session_destroy();
  $sitio    = Sitio;
  $carpeta = Carpeta;
 //Y me voy al inicio
 header("Location: ".$sitio."/".$carpeta."/");
     echo "<html></html>";
//   exit;
?> 