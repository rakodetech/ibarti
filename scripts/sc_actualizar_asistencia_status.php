<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
mysql_select_db($bd_cnn, $cnn);

$tabla     = 'asistencia';
$tabla_id  = 'cedula';
$usuario   = $_POST['usuario'];						

$nomina = $_POST['nomina'];
$href   = $_POST['href'];
$valido = 'SI'; 

	$fecha_N    = explode("-", $date); // 2010-03-15
	$fecha_MKT    = mktime(0,0,0,$fecha_N[1],$fecha_N[2],$fecha_N[0]);	
 ////////////// CALCULO LA FECHA  /////////////////
/////////////////////////////////////////////////
	
$i=$_GET['metodo'];

if (isset($_GET['metodo'])) {
	switch ($i) {

	case cod_cont: 
	     $query02 = mysql_query("SELECT DISTINCT asistencia.cod_emp, trabajadores.co_cont
								   FROM asistencia, trabajadores
								  WHERE asistencia.cod_emp =  trabajadores.cod_emp", $cnn);
	
	while ($row02 = mysql_fetch_array($query02)){
		echo $cod_cont = $row02[1],'</br>';
		echo $usuario  = $row02[0],'</br>';
	
		  mysql_query("UPDATE asistencia SET co_cont = '$cod_cont'
					WHERE asistencia.cod_emp = '$usuario'",$cnn)or die('<br><h3>Error Consulta # 1:</h3> '.mysql_error().'<br>'); 		
		}
	break;
	case asistencia_status: 

	     $query02 = mysql_query("SELECT DISTINCT asistencia.fecha, asistencia.id_usuario, asistencia.co_cont
								   FROM asistencia ORDER BY asistencia.fecha ASC", $cnn);
	
	while ($row02 = mysql_fetch_array($query02)){
		echo $fecha    = $row02[0],'</br>';
		echo $usuario  = $row02[1],'</br>';			
		echo $cod_cont = $row02[2],'</br>';
		echo $nomina   = '2010-03-01';
		
	 mysql_query("INSERT INTO asistencia_status
							 (fecha_nomina, fecha_ingreso, fecha_cierre, id_usuario, co_cont,  status)
					  VALUES ('$nomina', '$fecha', '$date', '$usuario', '$cod_cont',  2)",$cnn) or die
								 ('<br><h3>Error Consulta # 3:</h3> '.mysql_error().'<br>');   
		}
		
 // asistencia activa	
		     $query03 = mysql_query("SELECT Max(asistencia_status.fecha_ingreso), asistencia_status.id_usuario 
	                                   FROM asistencia_status GROUP BY asistencia_status.id_usuario", $cnn);
	
	while ($row03 = mysql_fetch_array($query03)){
		echo $fecha   = $row03[0],'</br>';
		echo $usuario = $row03[1],'</br>';
	
		  mysql_query("UPDATE asistencia_status SET asistencia_status.status = '1'
					    WHERE fecha_ingreso = '$fecha'
						  AND id_usuario = '$usuario'",$cnn)or die('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>'); 		
		}	
 
	break;		 
	}        
}
/*
	if (mysql_errno($cnn)==0){
	
	echo $mensaje;
	mensajeria($mensaje);

//	commit();	

     echo '<script language="javascript">
	       location.href="'.$href.'";
	       </script>';		    

	
	 }else{

	 	$Nerror = mysql_errno($cnn);
		$Derror = mysql_error($cnn);

		mensajeria("".Errror_Ms($Nerror, $Merror)."");
//		rollback();

     echo '<script language="javascript">
	       location.href="'.$href.'";
	       </script>';		    		   
	 }
*/
mysql_close($cnn); 		 				
?>