<?php
include_once('../funciones/funciones.php');
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$usuario    = $_POST['usuario'];
$cliente   = $_POST['cliente'];
$ubicacion = $_POST['ubicacion'];

$sql = "SELECT pl_cliente.*, cargos.descripcion cargo, turno.descripcion turno
          FROM pl_cliente_apertura, pl_cliente, cargos, turno
			   WHERE pl_cliente_apertura.`status` = 'T'
           AND pl_cliente_apertura.codigo = pl_cliente.cod_apertura
           AND pl_cliente.cod_cliente   = '$cliente'
					 AND pl_cliente.cod_ubicacion = '$ubicacion'
           AND pl_cliente.cod_cargo = cargos.codigo
           AND pl_cliente.cod_turno = turno.codigo
     		 ORDER BY 1 ASC ";

	  $query = $bd->consultar($sql);
		$valor = 1;
		$i     = 0;

		echo '<table width="100%" border="0" align="center">';
		while ($datos=$bd->obtener_fila($query,0)){
		$i++;
		if ($valor == 0){
			$fondo = 'fondo01';
			$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}
		echo'<tr class="'.$fondo.'">
						<td width="23%" class="texto">'.longitud($datos["cargo"]).'</td>
						<td width="23%" class="texto">'.longitud($datos["turno"]).'</td>
						<td width="14%" class="texto">'.valorF($datos["excepcion"]).'</td>
						<td width="12%" class="texto">'.$datos["fecha_inicio"].'</td>
						<td width="12%" class="texto">'.$datos["fecha_fin"].'</td>
						<td width="10%" class="texto">'.$datos["cantidad"].'</td>
						<td width="6%" align="center"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Modificar Registro"
						    border="null" width="20px" height="20px" class="imgLink"  onclick="Metodo(\''.$datos["codigo"].'\',\'modificar\' )"
							  />&nbsp;<img src="imagenes/borrar.bmp" alt="Borrar" title="Borrar Registro"  class="imgLink"
							  width="20px" height="20px" onclick="Borrar_Campo(\''.$datos["codigo"].'\', \''.$datos["fecha_inicio"].'\', \''.$datos["fecha_fin"].'\')"/></td>
					</tr>'; }?>
				</table>
