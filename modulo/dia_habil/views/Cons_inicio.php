<?php
include_once "../../../funciones/funciones.php";
require"../../../autentificacion/aut_config.inc.php";
require "../../../".class_bd;
require "../../../".Leng;
$bd = new DataBase();

$titulo = $leng['horario'];

$sql = " SELECT  * FROM dias_habiles ORDER BY 2 ASC ";
?>

<div align="center" class="etiqueta_title"> Consulta De <?php echo $titulo;?> </div> <hr />
<div class="tabla_sistema"><table width="80%" border="0" align="center">
		<tr>
			<th width="15%">Codigo</th>
			<th width="50%">Nombre</th>
      <th width="20%" class="etiqueta">Status</th>
      <th width="15%" align="center"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="Cons_dia_habil('', 'agregar')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>
	</tr>
    <?php

   $query = $bd->consultar($sql);
		while ($datos=$bd->obtener_fila($query,0)){

        echo '<tr>
           <td>'.$datos["codigo"].'</td>
				   <td>'.longitud($datos["descripcion"]).'</td>
				  <td>'.statuscal($datos["status"]).'</td>
				  <td><img src="imagenes/actualizar.bmp" onclick="Cons_dia_habil(\''.$datos[0].'\', \'modificar\')" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="Borrar_dia_habil(\''.$datos[0].'\')"/></td></tr>';
        }
  	?>
    </table>
</div>
