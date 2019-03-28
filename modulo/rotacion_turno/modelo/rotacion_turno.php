<?php
define("SPECIALCONSTANT", true);

include_once('../../../funciones/funciones.php');
require("../../../autentificacion/aut_config.inc.php");
require_once("../../../".class_bdI);
$bd = new DataBase();
$result = array();

  $codigo          = $_POST['codigo'];
  $abrev           = $_POST['abrev'];
  $nombre          = htmlentities($_POST['nombre']);

  $status          = $_POST['activo'];
  $usuario         = $_POST['usuario'];
  $proced          = $_POST['proced'];
  $metodo          = $_POST['metodo'];

	if(isset($_POST['proced'])){

	try {
    if($metodo == "agregar"){
      $sql = "INSERT INTO rotacion (codigo, abrev, descripcion,
                                    cod_us_ing, fec_us_ing, cod_us_mod, fec_us_mod, `status`)
                            VALUES (NULL, '$abrev', '$nombre',
                                    '$usuario', current_date, '$usuario', current_date, '$status')";
    }else{
      $sql = "UPDATE rotacion SET
             abrev          = '$abrev',     descripcion    = '$nombre',
             cod_us_mod     = current_date, fec_us_mod     = '$usuario',
             `status`       = '$status'
        WHERE codigo         = '$codigo'";
    }

	 $query   = $bd->consultar($sql);


 		}catch (Exception $e) {
       $error =  $e->getMessage();
       $result['error'] = true;
       $result['mensaje'] = $error;

       $bd->log_error("Aplicacion", "sc_turnos.php",  "$usuario", "$error", "$sql");
   }

	}
	print_r(json_encode($result));
	return json_encode($result);

?>
