<?php
require "../modelo/marcaje_modelo.php";
require "../../../../" . Leng;

$marcaje   = new Marcaje;
$result = array();
$codigo     = $_POST['codigo'];
$result  =  $marcaje->get_participantes($codigo);
$disabled = "";

foreach ($result as  $datos) {
       echo '<tr><td>' . $datos["cod_ficha"] . '</td>
      <td>' . $datos["ap_nombre"] . '</td>
             <td>' . $datos["cargo"] . '</td>
       <td>' . $datos["fecha"] . '</td>
       <td> <img class="imgLink" src="imagenes\ico_borrar.ico" alt="Eliminar Participante" title="Eliminar Participante" onclick="addParticipante(\'eliminar\', ' . $datos["codigo"] . ',' . $datos["cod_ficha"] . ' )" width="15px" height="15px"></td></tr>';
}
