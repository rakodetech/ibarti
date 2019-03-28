<?php
	include_once('../funciones/funciones.php');
	require "../autentificacion/aut_config.inc.php";
	require "../".class_bd;
	require "../".Leng;
	$bd = new DataBase();

	$periodo   = $_POST["codigo"];
	$cliente   = $_POST["cliente"];
	$ubicacion = $_POST["ubicacion"];
	$turno     = $_POST["turno"];
	$horario   = $_POST["horario"];
	$dia       = $_POST["dia"];
	$usuario   = $_POST["usuario"];
	$pag       = 1;


$where = "  WHERE a.cod_apertura = '$periodo'
	            AND a.cod_cliente   = '$cliente'
	            AND a.cod_ubicacion = '$ubicacion'
	            AND a.cod_cargo = cargos.codigo
	            AND a.cod_turno = turno.codigo ";


							$sql_trab = "SELECT a.*, CONCAT(ficha.apellidos,' ',ficha.nombres) trab_ap,
						 clientes.abrev, clientes.nombre, clientes_ubicacion.descripcion ubicacion,
							rotacion.descripcion  rotacion,
							(a.rotacion_inicio +1) rotacion_n
							FROM pl_trabajador a , ficha , rotacion, clientes, clientes_ubicacion
							WHERE a.cod_apertura  = '$periodo'
							AND a.cod_ficha = ficha.cod_ficha
							AND a.cod_cliente = '$cliente'
							AND a.cod_ubicacion = '$ubicacion'
							AND a.cod_rotacion = rotacion.codigo
						  AND a.cod_cliente = clientes.codigo
						  AND a.cod_ubicacion = clientes_ubicacion.codigo
							ORDER BY
							1 ASC ";

if($horario != "TODOS"){
	$where .= " AND turno.cod_horario = '$horario' ";  // cambie AND asistencia.co_cont = '$contracto'

	$sql_trab = "SELECT a.*, CONCAT(ficha.apellidos,' ',ficha.nombres) trab_ap, clientes.abrev,
	 clientes.nombre, clientes_ubicacion.descripcion ubicacion,
	rotacion.descripcion rotacion, (a.rotacion_inicio +1) rotacion_n
	FROM pl_trabajador a , pl_trabajador_det b, ficha , rotacion, clientes, clientes_ubicacion
	WHERE a.cod_apertura = '$periodo' AND a.cod_ficha = ficha.cod_ficha
	AND a.cod_cliente = '$cliente' AND a.cod_ubicacion = '$ubicacion' AND a.cod_rotacion = rotacion.codigo
	AND a.cod_cliente = clientes.codigo AND a.cod_ubicacion = clientes_ubicacion.codigo
	AND a.codigo = b.cod_pl_trab
	AND b.fecha = '2018-01-12'
	AND b.cod_horario = '$horario'
	ORDER BY 1 ASC ";

}

	$sql_cl = " SELECT a.*, cargos.descripcion cargo, turno.descripcion turno
	              FROM pl_cliente a, cargos, turno
	            $where
	  	       ORDER BY 1 ASC ";
						?>

						<div class="tab">
						  <button class="tablinks" onclick="openTap(0)">Planificacion De Cliente</button>
						  <button class="tablinks" onclick="openTap(1)">Planificacion De Trabajador</button>
						</div>
						<!-- ***************** PLANIFICACION DE CLIENTES    ************ -->
						<div class="tabcontent" id="tab_cont01">
							<table width="100%" border="0" align="center">
 						 <tr class="fondo00">
 							<th width="24%" class="etiqueta">Cargo</th>
 							<th width="28%" class="etiqueta">Turno</th>
 							<th width="10%" class="etiqueta">Excepcion</th>
 							<th width="10%" class="etiqueta">Fecha Incio</th>
 							<th width="10%" class="etiqueta">Fecha Fin</th>
 							<th width="10%" class="etiqueta">Servicios</th>
 							<th width="8%" class="imgLink"><img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" onClick="PlanClienteEvento('', 'agregar')" width="25px" height="25px" border="null"/></th>
 						 </tr>
 						 <?php
 						 $query = $bd->consultar($sql_cl);
 						 $valor = 1;
 						 $i     = 0;
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
 										<td class="texto">'.longitud($datos["cargo"]).'</td>
 										<td class="texto">'.longitud($datos["turno"]).'</td>
 										<td class="texto">'.valorF($datos["excepcion"]).'</td>
 										<td class="texto">'.$datos["fecha_inicio"].'</td>
 										<td class="texto">'.$datos["fecha_fin"].'</td>
 										<td class="texto">'.$datos["cantidad"].'</td>
 										<td align="center" class="imgLink"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Modificar Registro"
 												border="null" width="20px" height="20px" onclick="PlanClienteEvento(\''.$datos["codigo"].'\',\'modificar\' )"
 												/>&nbsp;<img src="imagenes/borrar.bmp" alt="Borrar" title="Borrar Registro"  width="20px" height="20px"
												 onclick="PlanClienteBorrar(\''.$datos["codigo"].'\', \''.$datos["fecha_inicio"].'\', \''.$datos["fecha_fin"].'\')"/></td>
 									</tr>'; }?>

 						 </table>
						</div>
						<!-- ***************** PLANIFICACION DE TRABAJADORES   ************ -->
						<div class="tabcontent" id="tab_cont02">
						<?php
							$query = $bd->consultar($sql_trab);
						  $valor = 1;
						  $i     = 0;

						 echo '<table width="100%" border="0" align="center">
						 			 <tr class="fondo00 etiqueta">
									 	<th width="22%">'.$leng["trabajador"].'</th>
										 <th width="30%">'.$leng["cliente"].' - '.$leng["ubicacion"].' </th>
						 				 <th width="20%">Fecha: Inicio - Fin</th>
						 				 <th width="20%">Rotacion - Posicion</th>
						 				 <th width="8%" align="center" class="imgLink"><img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" onClick="PlanTrabajadorEvento(\'\',\'agregar\')" width="25px" height="25px" border="null"/></th>
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
						  echo'<tr class="texto '.$fondo.'">
									 <td>'.longitud($datos["trab_ap"]).'</td>
						 			 <td>'.longitud($datos["abrev"]).' -'.longitud($datos["ubicacion"]).' </td>
						 			 <td>'.$datos["fecha_inicio"].' - '.$datos["fecha_fin"].'</td>
						 			 <td>'.$datos["rotacion"].' - ('.$datos["rotacion_n"].')</td>
						 			 <td align="center" class="imgLink"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Modificar Registro"
						 					 border="null" width="20px" height="20px"  onclick="PlanTrabajadorEvento(\''.$datos["codigo"].'\',\'modificar\' )"
						 					 />&nbsp;<img src="imagenes/borrar.bmp" alt="Borrar" title="Borrar Registro"  width="20px" height="20px"
											 onclick="PlanTrabajadorBorrar(\''.$datos["codigo"].'\', \''.$datos["fecha_inicio"].'\', \''.$datos["fecha_fin"].'\')"/></td>
						 			 </tr>'; }?>
						 		 </table>

						</div>
