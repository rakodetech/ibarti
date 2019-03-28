<?php 
	$Nmenu = '3402'; 
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "nov_valores";
	$bd = new DataBase();
	$archivo = "nov_valores";
	$titulo = "  NOVEDADES VALORES";
	$vinculo = "inicio.php?area=maestros/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&titulo=$titulo&tb=$tabla&archivo=$archivo";
?>
<div align="center" class="etiqueta_title"> CONSULTA <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="10%" class="etiqueta">Codigo</th>
			<th width="22%" class="etiqueta">Abreviatura</th>
            <th width="30%" class="etiqueta">Descripci&oacute;n</th>			
            <th width="15%" class="etiqueta">Factor</th>
            <th width="15%" class="etiqueta">Activo</th>
		    <th width="8%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" width="30px" height="30px" border="null"/></a></th> 
		</tr>
    <?php       
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT nov_valores.codigo, nov_valores.abrev,
                    Valores(nov_valores.factor) AS factor, nov_valores.descripcion,
                    nov_valores.campo01, nov_valores.campo02,
                    nov_valores.campo03, nov_valores.campo04,
                    nov_valores.cod_us_ing, nov_valores.fec_us_ing,
                    nov_valores.cod_us_mod, nov_valores.fec_us_mod,
                    nov_valores.`status`
               FROM nov_valores
              ORDER BY 1 DESC ";

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
				  <td class="texto">'.$datos["abrev"].'</td> 
                  <td class="texto">'.longitudMax($datos["descripcion"]).'</td>
                  <td class="texto">'.longitud($datos["factor"]).'</td>
				  <td class="texto">'.statuscal($datos["status"]).'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td> 
            </tr>'; 
        }     
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>   
</div>