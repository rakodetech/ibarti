<?php 
	$Nmenu = '05'; 
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "men_menu";
	$bd = new DataBase();
	$archivo = "menu";
	$titulo = " MENU ";
	$vinculo = "inicio.php?area=maestros/Add_maestro&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&titulo=$titulo&tb=$tabla&archivo=$archivo";
?>
<div align="center" class="etiqueta_title"> CONSULTA GENERAL <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar">
	<table width="98%" border="0" align="center">
		<tr bgcolor="#CCCCCC">
			<th width="10%" class="etiqueta">Codigo</th>
			<th width="30%" class="etiqueta">Descripcion</th>
            <th width="10%" class="etiqueta">Orden</th>
            <th width="40%" class="etiqueta">Link</th>
            <th width="10%" class="etiqueta">Status</th>
		     
		</tr>
    <?php       
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT men_menu.codigo, men_menu.descripcion, men_menu.orden, men_menu.link,
                    men_menu.`status` 
               FROM men_menu		      
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
                  <td>'.utf8_decode($datos[0]).'</td> 
                  <td>'.utf8_decode($datos[1]).'</td>
				  <td>'.utf8_decode($datos[2]).'</td>
				  <td>'.utf8_decode($datos[3]).'</td>
				  <td>'.statuscal(utf8_decode($datos[4])).'</td>
			   </tr>'; 
        }     
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>   
</div>