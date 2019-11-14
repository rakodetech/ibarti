<?php
	$Nmenu = '323';
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "nov_clasif";
	$bd = new DataBase();
	$archivo = "nov_clasif";
	$titulo = " NOVEDADES CLASIFICACION ";
	$vinculo = "inicio.php?area=pestanas_maestro/$archivo&Nmenu=$Nmenu&mod=".$_GET['mod']."&titulo=$titulo&tb=$tabla&archivo=$archivo";

	require_once('autentificacion/aut_verifica_menu.php');
require_once('carnet.php');
?>
