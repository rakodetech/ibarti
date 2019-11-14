<?php
include_once "../../../funciones/funciones.php";
require"../../../autentificacion/aut_config.inc.php";
require "../../../".class_bd;
require "../../../".Leng;
$bd = new DataBase();

$titulo = $leng['zona'];

$sql = " SELECT zonas.*, CONCAT(men_usuarios.apellido,' ' ,men_usuarios.nombre) us_mod
           FROM zonas LEFT JOIN men_usuarios ON zonas.cod_us_mod = men_usuarios.codigo
          ORDER BY 2 DESC ";
?>

<div align="center" class="etiqueta_title"> Consulta De <?php echo $titulo;?> </div> <hr />
<div class="tabla_sistema"><table width="100%" border="0" align="center">
  <tr>
    <th width="10%">Codigo</th>
    <th width="36%">Descripcion</th>
		<th width="10%">Fecha Ultima Modificacion</th>
		<th width="26%">Usuario Ultima Modificacion</th>
		<th width="10%" >Status</th>
    <th width="10%"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="Cons_zona('', 'agregar')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>
  </tr>

  <?php
   $query = $bd->consultar($sql);
		while ($datos=$bd->obtener_fila($query,0)){
      echo '<tr>
      <td>'.$datos["codigo"].'</td>
      <td>'.longitudMax($datos["descripcion"]).'</td>
			<td>'.$datos["fec_us_mod"].'</td>
			<td>'.$datos["us_mod"].'</td>
			<td>'.statuscal($datos["status"]).'</td>
    				  <td><img src="imagenes/actualizar.bmp" onclick="Cons_zona(\''.$datos[0].'\', \'modificar\')" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="Borrar_zona(\''.$datos[0].'\')"/></td></tr>';
        }
  	?>
    </table>
</div>
