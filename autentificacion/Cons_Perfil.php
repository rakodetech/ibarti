<?php 
	$Nmenu = '03'; 
	require_once('autentificacion/aut_verifica_menu.php');
	$archivo = "Perfil&Nmenu=".$Nmenu."";
	$tabla = "men_perfiles";
	$bd = new DataBase();
	$titulo = "PERFIL";
	$vinculo = "inicio.php?area=autentificacion/Add_perfil&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."";
?>
<div align="center" class="etiqueta_title"> CONSULTA GENERAL <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="92%" border="0" align="center">
		<tr class="fondo00">
			<th width="20%" class="etiqueta">Codigo</th>
			<th width="50%" class="etiqueta">Perfil</th>
            <th width="15%" class="etiqueta">Status</th>
		    <th width="15%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" width="30px" height="30px" border="null"/></a></th> 
		</tr>
    <?php       
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT men_perfiles.codigo, men_perfiles.descripcion, men_perfiles.status
               FROM men_perfiles ORDER BY 2 ASC ";
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
                  <td>'.$datos[0].'</td> 
                  <td>'.$datos[1].'</td>
				  <td>'.statuscal($datos[2]).'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<a href="inicio.php?area=autentificacion/Mod_Menu_Perfil&Nmenu='.$_GET['Nmenu'].'&mod='.$_GET['mod'].'&codigo='.$datos[0].'"><img src="imagenes/detalle.bmp" alt="Detalle" title="Detalle Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td> 
            </tr>'; 
        }     
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>   
</div>