<?php
require "../modelo/marcaje_modelo.php";
require "../../../../" . Leng;

$marcaje   = new Marcaje;
$result = array();
$codigo     = $_POST['codigo'];
$result  =  $marcaje->get_observaciones($codigo);

foreach ($result as  $datos) {
       echo '<tr>
       <td width="15%">' . $datos["codigo"] . '</td>
       <td width="85%">' . $datos["observacion"] . '</td>
      </tr>';
}
