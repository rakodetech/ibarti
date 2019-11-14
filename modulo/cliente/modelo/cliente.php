<?php
define("SPECIALCONSTANT", true);

include_once('../../../funciones/funciones.php');
require("../../../autentificacion/aut_config.inc.php");
require_once("../../../".class_bdI);
$bd = new DataBase();
$result = array();


foreach($_POST as $nombre_campo => $valor){
  $variables = "\$".$nombre_campo."='".$valor."';";
  eval($variables);
}

$codigo  = htmlentities($codigo);

$lunes   = statusbd($lunes);
$martes   = statusbd($martes);
$miercoles = statusbd($miercoles);
$jueves  = statusbd($jueves);
$viernes = statusbd($viernes);
$sabado  = statusbd($sabado);
$domingo = statusbd($domingo);

	if(isset($_POST['proced'])){

		try {

      $sql    = "$SELECT $proced('$metodo', '$codigo', '$cl_tipo', '$vendedor',
   	                            '$region', '$abrev', '$rif', '$nit',
   								'$nombre', '$telefono', '$fax', '$direccion',
   								'$dir_entrega', '$email', '$website', '$contacto',
   								'$observ',
   								'$juridico', '$contrib', '$lunes', '$martes',
   								'$miercoles', '$jueves', '$viernes', '$sabado',
   								'$domingo', '$limite_cred', '$plazo_pago', '$desc_global',
   								'$desc_p_pago',
   								'$campo01', '$campo02', '$campo03', '$campo04', '$usuario',  '$activo')";
   	 $query = $bd->consultar($sql);

   $result['sql'] = $sql;

 		}catch (Exception $e) {
       $error =  $e->getMessage();
       $result['error'] = true;
       $result['mensaje'] = $error;
       $bd->log_error("Aplicacion", "sc_horario.php",  "$usuario", "$error", "$sql");
   }

	}
	print_r(json_encode($result));
	return json_encode($result);

?>
