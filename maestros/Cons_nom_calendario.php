<?php
	$Nmenu = '339';
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "vendedores";
	$bd = new DataBase();
	$archivo = "nom_calendario";
	$titulo = " CALENDARIO ";
	$vinculo = "inicio.php?area=maestros/Add_$archivo&Nmenu=$Nmenu&mod=".$_GET['mod']."&archivo=$archivo";
	$vinculo2 = "inicio.php?area=maestros/Add_".$archivo."_det&Nmenu=$Nmenu&mod=".$_GET['mod']."&archivo=$archivo";

?>
<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="90%" border="0" align="center">
		<tr class="fondo00">
			<th width="15%" class="etiqueta">Codigo</th>
		    <th width="35%" class="etiqueta">Nombre</th>
            <th width="20%" class="etiqueta">Tipo </th>
            <th width="20%" class="etiqueta">Activo</th>
		    <th width="10%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Detalle" title="Detalle Registro" width="30px" height="30px" border="null"/></a></th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT nom_calendario.codigo,  cod_calendario_nl  cod_det,
	                nom_calendario.descripcion, Valores(nom_calendario.tipo) AS tipo,
					        nom_calendario.cod_us_ing, nom_calendario.fec_us_ing,
                  nom_calendario.cod_us_mod, nom_calendario.fec_us_mod,
                  nom_calendario.`status`
             FROM nom_calendario
         ORDER BY 2 DESC ";

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
                  <td class="texto">'.$datos["codigo"].'</td>
				  <td class="texto">'.$datos["descripcion"].'</td>
				  <td class="texto">'.$datos["tipo"].'</td>
				  <td class="texto">'.statuscal($datos["status"]).'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp; <a href="'.$vinculo2.'&codigo='.$datos[0].'&cod_det='.$datos[1].'&metodo=modificar"><img src="imagenes/detalle.bmp" alt="Detalle" title="Detalle" width="20px" height="20px" border="null"/></a></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
