<?php 
	$Nmenu = '3403'; 
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "nov_valores_clasif";
	$bd = new DataBase();
	$archivo = "nov_valores_clasif";
	$titulo = "  NOVEDADES VALORES CLASIFICACION";
	$vinculo = "inicio.php?area=maestros/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&titulo=$titulo&tb=$tabla&archivo=$archivo";
?>
<div align="center" class="etiqueta_title"> CONSULTA <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="10%" class="etiqueta">Codigo</th>
			
            <th width="30%" class="etiqueta">Descripci&oacute;n</th>			
            
            <th width="15%" class="etiqueta">Activo</th>
		    <th width="8%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" width="30px" height="30px" border="null"/></a></th> 
		</tr>
    <?php       
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT nov_valores_clasif.codigo,
                    nov_valores_clasif.descripcion,
                    nov_valores_clasif.campo01, nov_valores_clasif.campo02,
                    nov_valores_clasif.campo03, nov_valores_clasif.campo04,
                    nov_valores_clasif.cod_us_ing, nov_valores_clasif.fec_us_ing,
                    nov_valores_clasif.cod_us_mod, nov_valores_clasif.fec_us_mod,
                    nov_valores_clasif.`status`
               FROM nov_valores_clasif
              ORDER BY 1 ASC ";

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
                  <td class="texto">'.longitudMax($datos["descripcion"]).'</td>
				  <td class="texto">'.statuscal($datos["status"]).'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td> 
            </tr>'; 
        }     
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>   
</div>