<?php
	$Nmenu = '402';
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "pres_rol";
	$bd = new DataBase();
	$archivo = "trab_roles";
	$titulo = " ".$leng['trabajador']." ".$leng['rol']." ";
	$vinculo = "inicio.php?area=formularios/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&titulo=$titulo&tb=$tabla&archivo=$archivo";
?>
<div align="center" class="etiqueta_title"> Consulta <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="98%" border="0" align="center">
		<tr class="fondo00">
			<th width="15%" class="etiqueta"><?php echo $leng['ficha']?></th>
			<th width="15%" class="etiqueta"><?php echo $leng['ci']?></th>
            <th width="35%" class="etiqueta"><?php echo $leng['trabajador']?></th>
            <th width="25%" class="etiqueta"><?php echo $leng['rol']?></th>
		    <th width="10%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=actualizar";?>"><img src="imagenes/nuevo.bmp" alt="Detalle" title="Detalle Registro" width="30px" height="30px" border="null"/></a></th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT ficha.cod_ficha, ficha.cedula, preingreso.nombres,
                    roles.codigo,
					roles.descripcion AS rol
               FROM ficha, trab_roles, roles, preingreso
              WHERE ficha.cod_ficha = trab_roles.cod_ficha
                AND trab_roles.cod_rol = roles.codigo
                AND ficha.cedula = preingreso.cedula
              ORDER BY 4, 3 ASC ";

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
                  <td class="texto">'.$datos["cod_ficha"].'</td>
                  <td class="texto">'.$datos["cedula"].'</td>
				  <td class="texto">'.$datos["nombres"].'</td>
				  <td class="texto">'.$datos["rol"].'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=actualizar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20px" height="20px" border="null"/></a></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
