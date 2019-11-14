<?php
include_once "../../../funciones/funciones.php";
require"../../../autentificacion/aut_config.inc.php";
require "../../../".class_bd;
require "../../../".Leng;
$bd = new DataBase();

$titulo = $leng['cliente'];

$sql = " SELECT clientes.codigo, clientes.cod_cl_tipo, clientes_tipos.descripcion AS cl_tipo,
                clientes.cod_vendedor, vendedores.nombre AS vendedor, clientes.cod_region,
                regiones.descripcion AS region, clientes.abrev, clientes.rif,
                clientes.nit, clientes.nombre, clientes.telefono,
                clientes.status
           FROM clientes, clientes_tipos, vendedores, regiones
          WHERE clientes.cod_cl_tipo = clientes_tipos.codigo
            AND clientes.cod_vendedor = vendedores.codigo
            AND clientes.cod_region = regiones.codigo
       ORDER BY nombre ASC ";
?>

<div align="center" class="etiqueta_title"> Consulta De <?php echo $titulo;?> </div> <hr />
<div class="tabla_sistema listar"><table width="100%" border="0" align="center">

  <tr>
    <th width="12%">Codigo</th>
    <th width="12%"><?php echo $leng["rif"];?></th>
    <th width="32%">Nombre</th>
    <th width="22%"><?php echo $leng['region'];?></th>
    <th width="14%" >Activo</th>
   <th width="6%" align="center"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="Cons_cliente('', 'agregar')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>
  </tr>
  <?php
   $query = $bd->consultar($sql);
		while ($datos=$bd->obtener_fila($query,0)){
      echo '<tr>
              <td>'.$datos["codigo"].'</td>
              <td>'.$datos["rif"].'</td>
              <td>'.$datos["nombre"].'</td>
              <td>'.$datos["region"].'</td>
              <td>'.statuscal($datos["status"]).'</td>
    				  <td><img src="imagenes/actualizar.bmp" onclick="Cons_cliente(\''.$datos[0].'\', \'modificar\')" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="Borrar_cliente(\''.$datos[0].'\')"/></td></tr>';
        }
  	?>
    </table>
</div>
