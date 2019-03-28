<?php
	$Nmenu = '404';
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "turnos";
	$bd = new DataBase();
	$archivo = "planif_trabajador";
	$titulo = " Planificacion De ".$leng['trabajador']." ";
	$vinculo = "inicio.php?area=formularios/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&archivo=$archivo";
?>
<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="98%" border="0" align="center">
		<tr class="fondo00">
			<th width="30%" class="etiqueta"><?php echo $leng['trabajador'];?></th>
			<th width="25%" class="etiqueta"> <?php echo $leng['ubicacion'];?></th>
			<th width="24%" class="etiqueta">fecha</th>
			<th width="15%" class="etiqueta">Cargo</th>
      	<th width="	6%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Detalle" title="Detalle Registro" width="30px" height="30px" border="null"/></a></th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;

	$sql = " SELECT pl_trabajador.cod_apertura, pl_trabajador.cod_ficha,
	         CONCAT('(',pl_trabajador.cod_ficha,') - ', ficha.apellidos,' ', ficha.nombres) trab, clientes.nombre cliente,
					 clientes.abrev,
					 clientes_ubicacion.descripcion ubicacion, pl_trabajador.fecha_inicio, pl_trabajador.fecha_fin,
           rotacion.descripcion rotacion
      FROM pl_trabajador, pl_trab_apertura , ficha, clientes, clientes_ubicacion, rotacion
	   WHERE pl_trab_apertura.`status` = 'T'
		   AND pl_trab_apertura.codigo = pl_trabajador.cod_apertura
		 	 AND pl_trabajador.cod_ficha = ficha.cod_ficha
		   AND pl_trabajador.cod_cliente = clientes.codigo
		   AND pl_trabajador.cod_ubicacion = clientes_ubicacion.codigo
	     AND pl_trabajador.cod_rotacion = rotacion.codigo
		 ORDER BY pl_trabajador.fec_us_ing, 3 DESC";



   $query = $bd->consultar($sql);
		while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}
			$cl =''.$datos["abrev"].' -'.$datos["ubicacion"].'';
				echo '<tr class="'.$fondo.'">
                	<td class="texto">'.longitudMax($datos["trab"]).'</td>
									<td class="texto">'.$cl.'</td>
									<td class="texto">'.$datos["fecha_inicio"].' - '.$datos["fecha_fin"].'</td>
									<td class="texto">'.longitud($datos["rotacion"]).'</td>
					  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar&cod_cliente='.$datos[1].'&cod_ubicacion='.$datos[2].'"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
