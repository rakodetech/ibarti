<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
mysql_select_db($bd_cnn, $cnn);

$tabla    = 'asistencia';
$tabla_id = 'cedula';
$usuario  = $_POST['usuario'];						

//$fecha_Nom      = $_POST['fecha_Nom'];
$fecha_D   = $_POST['fecha_D'];
$fecha_Apert    = $_POST['fecha_Apert'];
$usuario   = $_POST['usuario'];

$status         = $_POST['status'];			  
$href      = $_POST['href'];

$i=$_POST['metodo'];
if (isset($_POST['metodo'])) {
	switch ($i){

	case Apertura_Asistencia:    	 
	
		  mysql_query("UPDATE asistencia_status SET
						      asis_apertura = 'N'						  								  
					    WHERE asistencia_status.id_usuario = '$usuario'",$cnn)  or die
						 ('<br><h3>Error Consulta # 1:</h3> '.mysql_error().'<br>');    

			 foreach ($fecha_Apert  as $valorX){  // $valorX  fehcha_ingreso	

		  mysql_query("UPDATE asistencia_status SET
						      asis_apertura = 'S'						  								  
					    WHERE asistencia_status.fecha_ingreso = '$valorX'
                          AND asistencia_status.id_usuario = '$usuario'",$cnn)  or die
						 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');
		 	}

	/*
		  $query02 = mysql_query("SELECT asistencia_status.asis_apertura
                                FROM asistencia_status
                               WHERE asistencia_status.fecha_ingreso = '$campo_id'
                                 AND asistencia_status.id_usuario = '$id' 
                                 AND asistencia_status.asis_apertura = 'S'", $cnn) or die
								 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');
	*/
	
	
	/*
		$query01 = mysql_query ("DELETE FROM asistencia_apertura WHERE id_usuario = '$usuario'",$cnn)or die
								 ('<br><h3>Error Consulta # 1:</h3> '.mysql_error().'<br>');				 
	
			 foreach ($fecha_Apert  as $valorX){	
			 mysql_query("INSERT INTO asistencia_apertura (fecha_ingreso, id_usuario)			
				                              VALUES ('$valorX', '$usuario')",$cnn)or die
								 ('<br><h3>Error Consulta # 1:</h3> '.mysql_error().'<br>');		 
		 	}
		*/		
	break;	
	}
}	

	require_once('../funciones/sc_direccionar.php');  	 					
?>