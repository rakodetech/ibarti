<?php 
	session_start();
    // $fechaGuardada = $_SESSION["ultimoAcceso"];
    $ahora = date("Y-n-j H:i:s");
    // $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));
    //comparamos el tiempo transcurrido
	
    $_SESSION["ultimoAcceso"] = $ahora;
   ?>