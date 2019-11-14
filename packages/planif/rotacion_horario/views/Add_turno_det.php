<?php
require "../modelo/rotacion_modelo.php";
require "../../../../".Leng;
$codigo    = $_POST['codigo'];
$usuario   = $_POST['usuario'];
$rotacion   = new Rotacion;
  $turno_det =  $rotacion->get_turno_det($codigo);
  $result = "Horario: ".$turno_det[0].", Dia Habil: ".$turno_det[1]."";
print_r(json_encode($result));
return json_encode($result);
?>
