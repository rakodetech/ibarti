<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$tabla    = 'usuarios';
$tabla_id = 'cedula';

$codigo	  = $_POST['codigo'];	
$href     = $_POST['href'];

$usuario  = $_POST['usuario']; 
$metodo   = $_POST['metodo'];

	if (isset($_POST['metodo'])) {
	$i=$_POST['metodo'];
		switch ($i) {
  			   	
		case 'actualizar':

		$sql = "SELECT ficha.cod_ficha
                  FROM ficha, control 
                 WHERE ficha.cod_ficha_status = control.ficha_activo";						  
		$query = $bd->consultar($sql);	 
		$n = 0;

		while($row=mysql_fetch_array($query)){
		echo $a[$n]= $row[0]; 
		$n++;
		}
		 $cantidad = count($a);
		
		for ($x=0; $x<=$cantidad; $x++){	
		  $check_id = $a[$x];	 
		  $chec = 'check'.$check_id.''; //aqui
		  $check = $_POST[$chec];

		$sql01 = "DELETE FROM trab_roles WHERE cod_ficha = '$check_id' AND cod_rol = '$codigo'";						  
		$query = $bd->consultar($sql01);	 
		
			  if($check == 'S'){
				  
  		$sql02 = "INSERT INTO trab_roles (cod_ficha, cod_rol)			
						          VALUES ('$check_id', '$codigo')";						  
		$query = $bd->consultar($sql02);	 
			}
		}			
		break;					

		}        
	}
		require_once('../funciones/sc_direccionar.php');  
?>