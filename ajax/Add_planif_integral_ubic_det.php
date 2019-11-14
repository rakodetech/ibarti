<?php
	include_once('../funciones/funciones.php');
	require "../autentificacion/aut_config.inc.php";
	require "../".class_bd;
	require "../".Leng;
	$bd = new DataBase();

	$periodo = $_POST["codigo"];
	$cliente   = $_POST["cliente"];
	$ubicacion = $_POST["ubicacion"];
	$usuario   = $_POST["usuario"];
	$pag       = 1;


	$sql_trab = "SELECT a.*, CONCAT(ficha.apellidos,' ',ficha.nombres) trab_ap,
	rotacion.descripcion  rotacion,
	(a.rotacion_inicio +1) rotacion_n
	FROM pl_trabajador a , ficha , rotacion
	WHERE a.cod_apertura  = '$periodo'
	AND a.cod_ficha = ficha.cod_ficha
	AND a.cod_cliente = '$cliente'
	AND a.cod_ubicacion = '$ubicacion'
	AND a.cod_rotacion = rotacion.codigo
	ORDER BY
	1 ASC ";

	$sql_cl = " SELECT a.*, cargos.descripcion cargo, turno.descripcion turno
	              FROM pl_cliente a, cargos, turno
				       WHERE a.cod_apertura = '$periodo'
	               AND a.cod_cliente   = '$cliente'
						     AND a.cod_ubicacion = '$ubicacion'
	               AND a.cod_cargo = cargos.codigo
	               AND a.cod_turno = turno.codigo
	     		 ORDER BY 1 ASC ";

					 $query = $bd->consultar($sql_cl);
					 $valor = 1;
					 $i     = 0;
/*
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
					 					border="null" width="20px" height="20px" class="imgLink"  onclick="Modificar(\''.$datos["codigo"].'\')"
					 					/>&nbsp;<img src="imagenes/borrar.bmp" alt="Borrar" title="Borrar Registro"  class="imgLink"
					 					width="20px" height="20px" onclick="Borrar_Campo(\''.$datos["codigo"].'\', \''.$datos["fecha_inicio"].'\', \''.$datos["fecha_fin"].'\')"/></td>
					 		</tr>';

						}
*/
						?>
<!-- </table> -->
					<div class="TabbedPanels" id="tp1">
				 	 <ul class="TabbedPanelsTabGroup">
				 		<li class="TabbedPanelsTab">Planificacion De Cliente</li>
						<li class="TabbedPanelsTab">Detalle Planificacion De Trabajador</li>
						<li class="TabbedPanelsTab">Planificacion De Trabajador</li>
				 	 </ul>
				 	  <div class="TabbedPanelsContentGroup">
				 	  	 <div class="TabbedPanelsContent">
							 <table width="100%" border="0" align="center">
							 <tr class="fondo00">
							 	<th width="20%" class="etiqueta">Cargo</th>
							 	<th width="20%" class="etiqueta">Turno</th>
							 	<th width="14%" class="etiqueta">Excepcion</th>
							 	<th width="14%" class="etiqueta">Fecha Incio</th>
							 	<th width="14%" class="etiqueta">Fecha Fin</th>
							 	<th width="12%" class="etiqueta">Servicios</th>
							 	<th width="6%"><img src="imagenes/loading2.gif" width="15px" height="15px"/></th>
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
							</div>
							 <!-- Detalle	 Planificacion De Trabajador -->

							 <div class="TabbedPanelsContent">
								 HOLA DETALLE
							 </div>

							 <!-- Planificacion De Trabajador -->
				   	  	 <div class="TabbedPanelsContent">
									 <?php
									 echo '<table width="100%" border="0" align="center">
														<tr class="fondo00">
														 <th width="15%" class="etiqueta">'.$leng["trabajador"].'</th>
													   <th width="25%" class="etiqueta">Fecha: Inicio - Fin</th>
														 <th width="20%" class="etiqueta">Rotacion</th>
														 <th width="12%" class="etiqueta">posicion</th>
														 <th width="8%" align="center"><img src="imagenes/nuevo.bmp" class="imgLink" alt="Agregar" title="Agregar Registro" onClick="Metodo(\'\',\'agregar\')" width="25px" height="25px" border="null"/></th>
													 </tr>';


											$valor = 1;
											$i     = 0;
											$query = $bd->consultar($sql_trab);
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
											 					<td class="texto">'.longitud($datos["trab_ap"]).'</td>
											 					<td class="texto">'.$datos["fecha_inicio"].' - '.$datos["fecha_fin"].'</td>
											 					<td class="texto">'.$datos["rotacion"].'</td>
											           <td class="texto">'.$datos["rotacion_n"].'</td>
											 					<td align="center"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Modificar Registro"
											 					    border="null" width="20px" height="20px" class="imgLink"  onclick="Metodo(\''.$datos["codigo"].'\',\'modificar\' )"
											 						  />&nbsp;<img src="imagenes/borrar.bmp" alt="Borrar" title="Borrar Registro"  class="imgLink"
											 						  width="20px" height="20px" onclick="Borrar_Campo(\''.$datos["codigo"].'\', \''.$datos["fecha_inicio"].'\', \''.$datos["fecha_fin"].'\')"/></td>
											 					</tr>'; }?>
											 				</table>



								 </div>
				 	  </div>
				  </div>


					<script language="JavaScript" type="text/javascript">
						var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab:<?php echo $pag;?>});
						var TabbedPanels = new Spry.Widget.TabbedPanels("TabbedPanels");
				    </script>
