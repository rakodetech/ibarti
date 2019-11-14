<?php
include_once('../funciones/funciones.php');
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$usuario    = $_POST['usuario'];
$trab       = $_POST['trab'];


$sql = "SELECT pl_trabajador.*,   clientes.abrev, clientes.nombre,
               clientes_ubicacion.descripcion ubicacion, rotacion.descripcion rotacion,
               (pl_trabajador.rotacion_inicio +1) rotacion_n
          FROM pl_trab_apertura, pl_trabajador, clientes, clientes_ubicacion, rotacion
			   WHERE pl_trab_apertura.`status` = 'T'
           AND pl_trab_apertura.codigo = pl_trabajador.cod_apertura
           AND pl_trabajador.cod_ficha =  '$trab'
           AND pl_trabajador.cod_cliente = clientes.codigo
           AND pl_trabajador.cod_ubicacion = clientes_ubicacion.codigo
           AND pl_trabajador.cod_rotacion = rotacion.codigo
			   ORDER BY 1 ASC ";

	  $query = $bd->consultar($sql);
		$valor = 1;
		$i     = 0;

	echo '<table width="100%" border="0" align="center">
          <tr class="fondo00">
      			<th width="15%" class="etiqueta">'.$leng["cliente"].'</th>
      			<th width="20%" class="etiqueta">'.$leng["ubicacion"].'</th>
      			<th width="25%" class="etiqueta">Fecha: Inicio - Fin</th>
      			<th width="20%" class="etiqueta">Rotacion</th>
      			<th width="12%" class="etiqueta">posicion</th>
            <th width="8%" align="center"><img src="imagenes/nuevo.bmp" class="imgLink" alt="Agregar" title="Agregar Registro" onClick="Metodo(\'\',\'agregar\')" width="25px" height="25px" border="null"/></th>
      		</tr>';


		while ($datos=$bd->obtener_fila($query,0)){
		$i++;
		if ($valor == 0){
			$fondo = 'fondo01';
			$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}
    // 	<td width="14%" class="texto">'.valorF($datos["excepcion"]).'</td>
		echo'<tr class="'.$fondo.'">
					<td class="texto">'.longitud($datos["abrev"]).'</td>
					<td class="texto">'.longitud($datos["ubicacion"]).'</td>
					<td class="texto">'.$datos["fecha_inicio"].' - '.$datos["fecha_fin"].'</td>
					<td class="texto">'.$datos["rotacion"].'</td>
          <td class="texto">'.$datos["rotacion_n"].'</td>
					<td align="center"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Modificar Registro"
					    border="null" width="20px" height="20px" class="imgLink"  onclick="Metodo(\''.$datos["codigo"].'\',\'modificar\' )"
						  />&nbsp;<img src="imagenes/borrar.bmp" alt="Borrar" title="Borrar Registro"  class="imgLink"
						  width="20px" height="20px" onclick="Borrar_Campo(\''.$datos["codigo"].'\', \''.$datos["fecha_inicio"].'\', \''.$datos["fecha_fin"].'\')"/></td>
					</tr>'; }?>
				</table>
