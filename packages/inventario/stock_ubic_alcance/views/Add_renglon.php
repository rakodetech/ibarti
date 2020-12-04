<?php
require "../modelo/stock_ubic_alcance_modelo.php";
require "../../../../".Leng;
$stock_ubic_alcance = new stock_ubic_alcance;
$codigo = $_POST['codigo'];
$reng   = $stock_ubic_alcance->get_aj_reng($codigo);
print_r(json_encode($reng));
return json_encode($reng);
?>
