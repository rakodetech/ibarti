<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
require_once('../bd/class_mysql2.php');

	$bd = new DataBase();
	$bd2 = new DataBase2(); 

	$proced  = "p_ficha_huella";

		$sql_ch = "	SELECT ch_inout2.codigo, ch_inout2.huella_asc FROM ch_inout2
	                 WHERE ch_inout2.evento = 'NEW_TEMPLATE' AND ch_inout2.checks = 'F' ";
		  // WHERE SUBSTR(v_ch_inout_identify.fecha,1,10) = CURRENT_DATE
		$query_ch  = $bd2->consultar($sql_ch) or die ("error ch");
		while ($datos_ch=$bd2->obtener_fila($query_ch,0)){
			$codigo      = $datos_ch['codigo'];		
			$huella_asc  = $datos_ch['huella_asc'];		
			$matris = explode(":", $huella_asc);
			 $ci     = $matris[0];
			 $huella = $matris[1];		
			
			$sql = "SELECT COUNT(cedula) FROM ficha_huella
					       WHERE ficha_huella.cedula = '$ci' AND ficha_huella.huella = '$huella' ";
			$query  = $bd->consultar($sql);
			$datos=$bd->obtener_fila($query,0);
			$cantida    = $datos[0];	
			
			if($cantida ==0){				
				$sql = "$SELECT $proced('agregar', '$ci', '$ci', '$huella', '$huella', '$usuario')";	
				$query  = $bd->consultar($sql);	 
			}else{
				$sql = " UPDATE ch_inout2 SET ch_inout2.checks = 'T'  WHERE ch_inout2.codigo = '$codigo' ";				  
				$query  = $bd2->consultar($sql) or die ("error");				
			}			
		}
mysql_free_result($query_ch);?>