<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');

$tabla     = 'sub_menu';
$tabla_id  = 'modulo';
$tabla_id2 = 'id_menu';
$href      = $_POST['href'];      
$menu      = $_POST['menu'];  
$id        = $_POST['id'];

	if (isset($_POST['archivo'])) {
	$i=$_POST['archivo'];
		switch ($i) {
		case 'modificar':    	 
		$query01 = mysql_query ("DELETE FROM $tabla WHERE $tabla_id = '$id'",$cnn);	
	
			 foreach ($menu as $valorX){
	
				 mysql_query("INSERT INTO $tabla
							 (modulo, id_menu)			
					  VALUES ($id, $valorX)",$cnn);       			 
			 }
		 break;
		}        
	}

	if (mysql_errno($cnn)==0){
	
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
mysql_close($cnn);	 
?>