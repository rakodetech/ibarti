
<?php

require "../modelo/nov_check_modelo.php";

$check      = new check_list;
$datos = $check->obtener_clasif_check();

echo '<option value="TODOS">TODOS</option>';
foreach ($datos as $valor){
  echo '<option value="'.$valor[0].'">'.$valor[1].'</option>';
}
?>