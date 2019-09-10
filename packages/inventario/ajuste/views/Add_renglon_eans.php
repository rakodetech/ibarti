<?php
require "../modelo/ajuste_modelo.php";
require "../../../../".Leng;
$model = new Ajuste;
$ajuste = $_POST['ajuste'];
$renglon = $_POST['renglon'];
$eans   = $model->get_aj_reng_eans($ajuste,$renglon);
print_r(json_encode($eans));
return json_encode($eans);
?>
