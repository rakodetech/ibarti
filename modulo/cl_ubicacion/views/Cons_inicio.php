<?php
include_once "../../../funciones/funciones.php";
require"../../../autentificacion/aut_config.inc.php";
require "../../../".class_bd;
require "../../../".Leng;
$bd = new DataBase();

$titulo = $leng['ubicacion'];
$cliente = $_POST['cliente'];

$sql = " SELECT clientes_ubicacion.codigo,
                clientes_ubicacion.cod_estado, estados.descripcion AS estado,
        clientes_ubicacion.cod_ciudad, ciudades.descripcion AS ciudad,
                  clientes_ubicacion.cod_region, regiones.descripcion AS region,
                  clientes_ubicacion.cod_calendario, nom_calendario.descripcion AS calendario,
                  clientes_ubicacion.descripcion, clientes_ubicacion.direccion,
                  clientes_ubicacion.contacto, clientes_ubicacion.telefono,
                  clientes_ubicacion.email,
        clientes_ubicacion.campo01, clientes_ubicacion.campo02,
        clientes_ubicacion.campo03, clientes_ubicacion.campo04,
        clientes_ubicacion.`status`
             FROM clientes_ubicacion, estados,  ciudades , regiones, nom_calendario
            WHERE clientes_ubicacion.cod_estado = estados.codigo
        AND clientes_ubicacion.cod_ciudad = ciudades.codigo
        AND clientes_ubicacion.cod_region = regiones.codigo
              AND clientes_ubicacion.cod_calendario = nom_calendario.codigo
      AND clientes_ubicacion.cod_cliente = '$cliente'
      ORDER BY 5, 3 DESC ";
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
   $query = $bd->consultar($sql);
		while ($datos=$bd->obtener_fila($query,0)){
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
