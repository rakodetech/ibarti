<?php
	$Nmenu = '31202';
		require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "cl_puesto";
	$bd = new DataBase();
	$archivo = "cl_puestos";
	$archivo = "cl_actividades";
	$cod = $_GET['codigo'];
	$titulo = "  ACTIVIDADES EN PUESTO DE CLIENTES ";
	$vinculo = "inicio.php?area=maestros/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&cod=$cod&archivo=$archivo";
	$vinculo2 = "inicio.php?area=maestros/Cons_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&cod=$cod&archivo=$archivo";
?>
<div align="center" class="etiqueta_title"> CONSULTA <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="95%" border="0" align="center">
		<tr class="fondo00">
			<th width="15%" class="etiqueta">Codigo</th>
			<th width="25%" class="etiqueta">Puesto</th>
			<th width="35%" class="etiqueta">Actividad</th>
            <th width="15%" class="etiqueta">Activo</th>
		    <th width="10%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" width="30px" height="30px" border="null"/></a></th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT cl_actividades.codigo, cl_actividades.descripcion,
                  cl_actividades.observacion, cl_puesto.descripcion  puesto,
                  cl_actividades.cod_us_ing, cl_actividades.fec_us_ing,
                  cl_actividades.cod_us_mod, cl_actividades.fec_us_mod,
                  cl_actividades.`status`
             FROM cl_actividades, cl_puesto
            WHERE cl_puesto.codigo = '$cod'
              AND cl_puesto.codigo = cl_actividades.cod_puesto ";

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
                  <td class="texto">'.longitudMax(utf8_decode($datos["puesto"])).'</td>
	              <td class="texto">'.longitudMax(utf8_decode($datos["descripcion"])).'</td>
				  <td class="texto">'.statuscal(utf8_decode($datos["status"])).'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
