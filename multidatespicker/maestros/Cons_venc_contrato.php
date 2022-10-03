<?php 
	$Nmenu = '362'; 
	require_once('autentificacion/aut_verifica_menu.php');
	$bd = new DataBase();
	$archivo = "venc_contrato";
	$titulo = " VENCIMINETO DE CONTRATO ";
	$vinculo = "inicio.php?area=maestros/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&archivo=$archivo";
?>
<div align="center" class="etiqueta_title"> CONSULTA <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="95%" border="0" align="center">
		<tr class="fondo00">
			<th width="15%" class="etiqueta">Codigo</th>
			<th width="30%" class="etiqueta">Descripcion</th>
			<th width="15%" class="etiqueta">Vencimiento</th>
   			<th width="15%" class="etiqueta">Dias</th>
            <th width="15%" class="etiqueta">Activo</th>
		    <th width="10%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" width="30px" height="30px" border="null"/></a></th> 
		</tr>
    <?php       
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT ficha_n_contracto.codigo, ficha_n_contracto.descripcion,
                    Valores(ficha_n_contracto.vencimiento) AS vencimiento, ficha_n_contracto.dias,
                    ficha_n_contracto.`status`
               FROM ficha_n_contracto ORDER BY 2 ASC ";

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
                  <td class="texto">'.longitud($datos["descripcion"]).'</td>
                  <td class="texto">'.longitud($datos["vencimiento"]).'</td>
				  <td class="texto">'.longitud($datos["dias"]).'</td>
				  <td class="texto">'.statuscal($datos["status"]).'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td> 
            </tr>'; 
        }     
	?>
    </table>   
</div>