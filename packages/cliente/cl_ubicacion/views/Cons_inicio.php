<?php
require "../modelo/ubicacion_modelo.php";
require "../../../../".Leng;
$titulo    = $leng['ubicacion'];
$cliente   = $_POST['cliente'];
$ubicacion = new Ubicacion;
$matriz    = $ubicacion->get($cliente);
?>

<div align="center" class="etiqueta_title"> Consulta De <?php echo $titulo;?> </div> <hr />
<div class="tabla_sistema"><table width="100%" border="0" align="center">
  <tr>
    <th width="20%">Sucursal</th>
    <th width="20%"><?php echo $leng['estado']?></th>
    <th width="20%"><?php echo $leng['ciudad']?></th>
    <th width="20%">Calendario</th>
    <th width="10%" >Status</th>
    <th width="10%"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="Cons_ubic('', 'agregar', 'Agregar <?php echo $leng['ubicacion'];?>')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>
  </tr>
  <?php
    foreach ($matriz as  $datos) {
      echo '<tr>
      <td>'.longitudMax($datos["descripcion"]).'</td>
      <td>'.longitudMax($datos["estado"]).'</td>
      <td>'.longitudMax($datos["ciudad"]).'</td>
      <td>'.longitudMax($datos["calendario"]).'</td>
      <td>'.statuscal($datos["status"]).'</td>
    	<td><img src="imagenes/actualizar.bmp" onclick="Cons_ubic(\''.$datos[0].'\', \'modificar\', \'Modificar '.$leng["ubicacion"].'\')" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="Borrar_ubic(\''.$datos[0].'\')"/></td></tr>';
        }
  	?>
    </table>
</div>
