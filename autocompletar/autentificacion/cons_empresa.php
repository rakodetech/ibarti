<?php 
	$archivo = "empresa&Nmenu=".$Nmenu."";
	$tabla = "empresa";
	$bd = new DataBase();
	$titulo = "EMPRESA";
	$vinculo = "inicio.php?area=autentificacion/Add_empresa&Nmenu=".$_GET['Nmenu']."";
?>
<div align="center" class="etiqueta_title"> CONSULTA GENERAL <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar">
	<table width="95%" border="0" align="center">
		<tr bgcolor="#CCCCCC">
			<th width="20%" class="etiqueta">Codigo</th>
			<th width="60%" class="etiqueta">Empresa</th>
		    <th width="20%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Detalle" title="Detalle Registro" width="20px" height="20px" border="null"/></a></th> 
		</tr>
    <?php       
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT empresa.codigo, empresa.descripcion
               FROM empresa ORDER BY empresa.descripcion ASC ";

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
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/detalle.bmp" alt="Detalle" title="Detalle Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" 
                 border="null" onclick="'.$Borrar.'" class="imgLink"/></td> 
            </tr>'; 
        }     
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
   
</div>
