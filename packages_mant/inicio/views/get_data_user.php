

<?php
session_start();
require "../modelo/save_pass.php";

$usuario = $_POST['usuario'];
$save      = new save_pass;
$data = $save->get_data_pass($usuario);

echo json_encode($data);
?>
