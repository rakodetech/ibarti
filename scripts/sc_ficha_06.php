<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
define("SPECIALCONSTANT", true);
require "../autentificacion/aut_config.inc.php";
require "../".Funcion;
require "../".class_bdI;

$bd = new DataBase();

$data   = json_decode(file_get_contents("php://input"));
$result = array();



$cedula       =$_POST['cedula'];
$capta_huella =$_POST['capta_huella'];

$proced       =$_POST['proced'];
$usuario      = "999";

if(isset($_POST['proced'])){

try {

      $sql    = "$SELECT $proced($cedula,'$capta_huella')";
      $qry =    $bd->consultar($sql);


    } catch (Exception $e) {
        $error =  $e->getMessage();
        $result['error'] = true;
        $result['mensaje'] = $error;

        $bd->log_error("Aplicacion", "sc_ficha06.php",  "$usuario", "$error", "$sql");
    }

      print_r(json_encode($result));
      return json_encode($result);

}?>
