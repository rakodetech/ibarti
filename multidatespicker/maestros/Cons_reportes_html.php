<?php 
	$Nmenu = '307'; 
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "ciudades";
	$bd = new DataBase();
	$archivo = "reportes_html";
	$titulo = "REPORTES HTML";
	$vinculo = "inicio.php?area=maestros/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&titulo=$titulo&tb=$tabla&archivo=$archivo";
?>
<div align="center" class="etiqueta_title"> CONSULTA <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="95%" border="0" align="center">
		<tr class="fondo00">
			<th width="10%" class="etiqueta">Codigo</th>
			<th width="25%" class="etiqueta">Modulo</th>
  			<th width="40%" class="etiqueta">Descripcion</th>
            <th width="15%" class="etiqueta">Status</th>
		    <th width="10%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" width="30px" height="30px" border="null"/></a></th> 
		</tr>
    <?php       
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT men_reportes_html.codigo, men_reportes_html.descripcion,
                    men_reportes_html.cod_modulo, men_modulos.descripcion AS modulo,
                    men_reportes_html.html, men_reportes_html.`status`
               FROM men_reportes_html , men_modulos
              WHERE men_reportes_html.cod_modulo = men_modulos.codigo
              ORDER BY modulo, descripcion DESC ";

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
                  <td class="texto">'.$datos["modulo"].'</td>
				  <td class="texto">'.$datos["descripcion"].'</td>
				  <td class="texto">'.statuscal($datos["status"]).'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a></td> 
            </tr>'; 
        }     
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>   
</div>