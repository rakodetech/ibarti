<?php
require "../modelo/puesto_modelo.php";
require "../../../../".Leng;
$titulo = "Puesto de Trabajo";
$cliente = $_POST['cliente'];
$ubicacion = $_POST['ubicacion'];
$ub_puesto = new Ub_puesto;
$matriz    = $ub_puesto->get($cliente, $ubicacion);
?>

<div align="center" class="etiqueta_title"> Consulta De <?php echo $titulo;?> </div> <hr />
<div class="tabla_sistema"><table width="100%" border="0" align="center">
  <tr>
    <th width="20%">Codigo</th>
    <th width="50%">Nombre</th>
    <th width="20%" >Status</th>
    <th width="10%"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="Cons_puesto('', 'agregar')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>
  </tr>
  <?php
    foreach ($matriz as  $datos) {
      echo '<tr>
      <td>'.$datos["codigo"].'</td>
      <td>'.longitudMax($datos["nombre"]).'</td>
      <td>'.statuscal($datos["status"]).'</td>
    				  <td><img src="imagenes/actualizar.bmp" onclick="Cons_puesto(\''.$datos[0].'\', \'modificar\')" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="Borrar_puesto(\''.$datos[0].'\')"/></td></tr>';
    }?>
    </table>
</div>
