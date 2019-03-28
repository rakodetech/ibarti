<?php
/* ********************* */
/* Conexion a PostgreSQL   Y MYSQL */
/* ********************* */
	define("Sitio", "http://c122.gconex.com");
//	define("Sitio", "http://www.ibarti.com.ve");
	define("Carpeta", "oesvica");

$bd = "mysql";
if($bd == "mysql"){
	define("class_bd", "bd/class_mysql.php");
	
	$SELECT = "CALL";
}elseif($bd == "postgre"){	

	define("class_bd", "bd/class_postgresql.php");
    
	$SELECT = "SELECT ";	
/*
	$conf_cnn = "dbname=$bd_cnn user=$usuario host=$host password=$password port=$port";
	$cnn = pg_connect($conf_cnn)or die ('NO SE PUDO CONECTAR CON LA BASE DE DATOS POSTGRE:'.pg_last_error());
*/
}else{
/*
	define("class_bd", "bd/class_mysql.php");
	echo "Bases de Datos Indefinida";	
*/
} 
?>