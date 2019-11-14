

<?php

require "../modelo/save_pass.php";

$cod = $_POST['cod'];
$old = $_POST['old'];
$new = md5($_POST['new']);
$save      = new save_pass;
$data = $save->set_data_pass($cod,$old,$new);

echo json_encode($data);
?>
