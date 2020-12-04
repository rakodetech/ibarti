<?php
require "../modelo/stock_ubic_alcance_modelo.php";
require "../../../../".Leng;
$model = new stock_ubic_alcance;
$stock_ubic_alcance = $_POST['stock_ubic_alcance'];
$renglon = $_POST['renglon'];
$eans   = $model->get_aj_reng_eans($stock_ubic_alcance,$renglon);
print_r(json_encode($eans));
return json_encode($eans);
?>
