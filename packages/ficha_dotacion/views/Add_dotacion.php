<?php
require "../modelo/ficha_dotacion_modelo.php";
$dot = new FichaDotacion;
$codigo = $_POST["codigo"];
$reng       = $dot->get_dot_reng($codigo);
$valor = 0;
foreach ($reng as  $datos) {
  $valor++;
  echo '
  <tr>
  <td>'.$datos[1].' ('.$datos[0].')</td>
  <td><input type="text" value="'.$datos[2].'" id="cant_'.$valor.'" style="width:100px"/></td>
  <td>
   <img  border="null" width="20px" height="20px" src="imagenes/actualizar.bmp" id="modificar_renglon" onclick="Modificar_renglon(\''.$datos[0].'\',\''.$datos[3].'\','.$valor.')" disabled title="Modificar renglon"  />
      <img  border="null" width="20px" height="20px" src="imagenes/borrar.bmp" id="eliminar_renglon" onclick="eliminar_renglon(\''.$datos[0].'\',\''.$datos[3].'\')" title="Modificar renglon" /
  </td>
  </tr>';
}
?>