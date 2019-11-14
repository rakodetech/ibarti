<?php
include_once "../../funciones/funciones.php";
require"../../autentificacion/aut_config.inc.php";
require "../../".class_bd;
require "../../".Leng;
$bd = new DataBase();
$titulo = $leng['turno'];

$sql = " SELECT turno.codigo, turno.abrev,
                turno.descripcion, turno.`status`
           FROM turno
      ORDER BY 2 ASC ";
?>

<div align="center" class="etiqueta_title"> Consulta De <?php echo $titulo;?> </div> <hr />
<div class="tabla_sistema"><table width="100%" border="0" align="center">
		<tr>
			<th width="10%">Codigo</th>
  		<th width="15%">Abrev</th>
			<th width="25%">Nombre</th>
      <th width="45%" class="etiqueta">Status</th>
  		<th width="5%" align="center"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="Cons_turno('', 'agregar')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>
		</tr>
    <?php

   $query = $bd->consultar($sql);
		while ($datos=$bd->obtener_fila($query,0)){

        echo '<tr>
           <td>'.$datos["codigo"].'</td>
           <td>'.$datos["abrev"].'</td>
				   <td>'.longitud($datos["descripcion"]).'</td>
					  <td>'.statuscal($datos["status"]).'</td>
				  <td><img src="imagenes/actualizar.bmp" onclick="Cons_turno(\''.$datos[0].'\', \'modificar\')" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="Borrar_turno(\''.$datos[0].'\')"/></td></tr>';
        }
  	?>
    </table>
</div>
