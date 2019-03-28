	
<?php

require "../modelo/clientes_rp_modelo.php";
$cliente = $_POST['cliente'];
$estado = $_POST['estado'];
$ciudad = $_POST['ciudad'];


	$region      = new clientes_reporte;
	$datos = $region->llenar_ubicacion($cliente,$estado,$ciudad);
	echo json_encode($datos);
	


?>

