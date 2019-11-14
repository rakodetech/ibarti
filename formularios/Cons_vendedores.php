<?php 
	$Nmenu = '437'; 
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "vendedores";
	$bd = new DataBase();
	$archivo = "vendedores";
	$titulo = " VENDEDORES ";
	$vinculo = "inicio.php?area=formularios/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&titulo=$titulo&tb=$tabla&archivo=$archivo";
?>
<div align="center" class="etiqueta_title"> CONSULTA <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="15%" class="etiqueta">Codigo</th>
			<th width="30%" class="etiqueta">Nombre</th>
            <th width="30%" class="etiqueta">Tipo Vendedor</th>
            <th width="15%" class="etiqueta">Activo</th>
		    <th width="10%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Detalle" title="Detalle Registro" width="30px" height="30px" border="null"/></a></th> 
		</tr>
    <?php       
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT vendedores.codigo, vendedores.cod_vend_tipo, vendedor_tipos.descripcion AS vend_tipo, 
                    vendedores.cedula, vendedores.nombre,
                    vendedores.telefono, vendedores.direccion,
                    vendedores.email, vendedores.vendedor,
                    vendedores.cobrador, vendedores.coms_vent,
                    vendedores.coms_cob, vendedores.campo01,
                    vendedores.campo02, vendedores.campo03,
                    vendedores.campo04, vendedores.cod_us_ing,
                    vendedores.fec_us_ing, vendedores.cod_us_mod,
                    vendedores.fec_us_mod, vendedores.status                   
               FROM vendedores , vendedor_tipos
              WHERE vendedores.cod_vend_tipo = vendedor_tipos.codigo 
			   ORDER BY nombre ASC ";

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
                  <td class="texto">'.$datos["nombre"].'</td>
				   <td class="texto">'.$datos["vend_tipo"].'</td>
				  <td class="texto">'.statuscal($datos["status"]).'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td> 
            </tr>'; 
        }     
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>   
</div>