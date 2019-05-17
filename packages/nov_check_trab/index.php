<?php
$mod     =  $_GET['mod'];
$metodo = "agregar";
$titulo  = strtoupper($metodo) . " REGISTRO CHECK LIST";

$archivo = "packages/nov_check_trab/views/get_data.php";

if ($metodo == "agregar") {
    $cedula = "1777288";
}

if (isset($_SESSION['usuario_cod'])) {
    //require_once('autentificacion/aut_verifica_menu.php');
    $us = $_SESSION['usuario_cod'];
} else {
    $us = $_POST['usuario'];
}

?>

<div align="center" class="etiqueta_title"> <?php echo $titulo; ?></div>
<br />
<?php require "views/cons_inicio.php";?>
