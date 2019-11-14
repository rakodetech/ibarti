<?php
	$Nmenu = '31202';
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "cl_puesto";
	$bd = new DataBase();
	$archivo = "cl_puestos";
	$archivo2 = "cl_actividades";
	$titulo = "  PUESTO DE CLIENTES ";
	$vinculo = "inicio.php?area=maestros/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&titulo=$titulo&tb=$tabla&archivo=$archivo";
	$vinculo2 = "inicio.php?area=maestros/Cons_$archivo2&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."";
?>
<div align="center" class="etiqueta_title"> CONSULTA <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="95%" border="0" align="center">
		<tr class="fondo00">
			<th width="15%" class="etiqueta">Codigo</th>
			<th width="30%" class="etiqueta">Puesto</th>
			<th width="30%" class="etiqueta">Clasificacion</th>
            <th width="15%" class="etiqueta">Activo</th>
		    <th width="10%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" width="30px" height="30px" border="null"/></a></th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT cl_puesto.codigo, cl_puesto.cod_clasif_puesto,
                    cl_clasif_puesto.descripcion clasif, cl_puesto.descripcion,
                    cl_puesto.cod_us_ing, cl_puesto.fec_us_ing,
                    cl_puesto.cod_us_mod, cl_puesto.fec_us_mod,
                    cl_puesto.`status`
               FROM cl_puesto, cl_clasif_puesto
              WHERE cl_puesto.cod_clasif_puesto = cl_clasif_puesto.codigo
              ORDER BY 2 ASC ";

   $query = $bd->consultar($sql);

		while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}

	// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'">
                  <td class="texto">'.utf8_decode($datos["codigo"]).'</td>
                  <td class="texto">'.utf8_decode($datos["descripcion"]).'</td>
	              <td class="texto">'.utf8_decode($datos["clasif"]).'</td>
				  <td class="texto">'.statuscal(utf8_decode($datos["status"])).'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<a href="'.$vinculo2.'&codigo='.$datos[0].'"><img src="imagenes/detalle.bmp" alt="Detalle" title="Detalle Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
