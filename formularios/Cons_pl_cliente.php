<?php
	$Nmenu = '441';
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "turnos";
	$bd = new DataBase();
	$archivo = "pl_cliente";
	$titulo = " Planificacion De ".$leng['cliente']." ";
	$vinculo = "inicio.php?area=formularios/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&archivo=$archivo";
?>
<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="98%" border="0" align="center">
		<tr class="fondo00">
			<th width="10%" class="etiqueta">Fecha mod.</th>
			<th width="30%" class="etiqueta"><?php echo $leng['cliente'];?> - <?php echo $leng['ubicacion'];?></th>
			<th width="22%" class="etiqueta">Cargo</th>
			<th width="22%" class="etiqueta">Turno</th>
			<th width="10%" class="etiqueta">Servicios</th>
      	<th width="	6%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Detalle" title="Detalle Registro" width="30px" height="30px" border="null"/></a></th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;

/*
SELECT pl_cliente_det.fecha, pl_cliente_det.cod_cliente,
       SUM(pl_cliente_det.cantidad) cantidad
FROM pl_cliente_apertura , pl_cliente_det
WHERE pl_cliente_apertura.`status` = 'T'
AND pl_cliente_apertura.codigo = pl_cliente_det.perido
GROUP BY pl_cliente_det.fecha, pl_cliente_det.cod_cliente


*/

	$sql = " SELECT pl_cliente_apertura.fecha_inicio, pl_cliente.cod_cliente, pl_cliente.cod_ubicacion,
                	pl_cliente_apertura.fecha_fin, pl_cliente.codigo,
                  pl_cliente.cod_apertura,  MAX(pl_cliente.fec_us_mod) fec_us_mod,
									CONCAT (men_usuarios.apellido, ' ', men_usuarios.nombre) us, clientes.abrev cl_abrev,
                  clientes.nombre cliente,
									clientes_ubicacion.descripcion ubicacion, pl_cliente.cantidad,
                  turno.descripcion turno, cargos.descripcion cargo

            FROM pl_cliente LEFT JOIN men_usuarios ON pl_cliente.cod_us_mod = men_usuarios.codigo,
                 pl_cliente_apertura, clientes, clientes_ubicacion,  cargos, turno
           WHERE pl_cliente_apertura.`status` = 'T'
             AND pl_cliente_apertura.codigo = pl_cliente.cod_apertura
             AND pl_cliente.cod_cliente = clientes.codigo
             AND pl_cliente.cod_cargo = cargos.codigo
             AND pl_cliente.cod_turno = turno.codigo
        GROUP BY pl_cliente.cod_cliente , pl_cliente.cod_ubicacion";

   $query = $bd->consultar($sql);
		while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;



		}
			$cl =''.$datos["cl_abrev"].' -'.$datos["ubicacion"].'';
				echo '<tr class="'.$fondo.'">
                  <td class="texto">'.conversion($datos["fec_us_mod"]).'</td>
         			    <td class="texto">'.longitudMax($cl).'</td>
         				  <td class="texto">'.longitud($datos["cargo"]).'</td>
									<td class="texto">'.longitud($datos["turno"]).'</td>
									<td class="texto">'.longitud($datos["cantidad"]).'</td>
					  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar&cod_cliente='.$datos[1].'&cod_ubicacion='.$datos[2].'"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
