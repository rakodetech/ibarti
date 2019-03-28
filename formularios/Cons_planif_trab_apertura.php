<?php
	$Nmenu = '445';
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "turnos";
	$bd = new DataBase();
	$archivo = "planif_trab_apertura";
	$titulo = " Apertura de Planificacion ".$leng['trabajador']." ";
	$vinculo = "inicio.php?area=formularios/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&archivo=$archivo";
?>
<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="98%" border="0" align="center">
		<tr class="fondo00">
			<th width="12%" class="etiqueta">Codigo.</th>
			<th width="20%" class="etiqueta">Usuario Ingreso</th>
			<th width="15%" class="etiqueta">Fecha Ingreso</th>
			<th width="22%" class="etiqueta">Usuario Modifico</th>
			<th width="15%" class="etiqueta">Fecha Cierre</th>
			<th width="10%" class="etiqueta">Status</th>
      	<th width="	6%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Detalle" title="Detalle Registro" width="30px" height="30px" border="null"/></a></th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = "SELECT pl_trab_apertura.codigo, pl_trab_apertura.fecha_inicio,
                pl_trab_apertura.fecha_fin,
                CONCAT(a.apellido, ' ', a.nombre) us_ing, pl_trab_apertura.fec_us_ing,
                CONCAT(b.apellido, ' ', b.nombre) us_mod, pl_trab_apertura.fec_us_mod,
StatusD(pl_trab_apertura.`status`) `status`
FROM pl_trab_apertura LEFT JOIN men_usuarios a ON pl_trab_apertura.cod_us_ing = a.codigo LEFT JOIN men_usuarios b ON pl_trab_apertura.cod_us_mod = b.codigo
ORDER BY 1 DESC;";

   $query = $bd->consultar($sql);
		while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}
				echo '<tr class="'.$fondo.'">
                <td class="texto">'.$datos["codigo"].'</td>
       			    <td class="texto">'.longitud($datos["us_ing"]).'</td>
       				  <td class="texto">'.$datos["fec_us_ing"].'</td>
								<td class="texto">'.longitud($datos["us_mod"]).'</td>
								<td class="texto">'.$datos["fec_us_mod"].'</td>
								<td class="texto">'.$datos["status"].'</td>
				  <td align="center"></td>
          </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
