<?php
	$Nmenu = '438';
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "proveedores";
	$bd = new DataBase();
	$archivo = "proveedores";
	$titulo = " PROVEEDORES ";
	$vinculo = "inicio.php?area=pestanas/add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&titulo=$titulo&tb=$tabla&archivo=$archivo";
?>
<div align="center" class="etiqueta_title"> CONSULTA GENERAL <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="98%" border="0" align="center">
		<tr class="fondo00 etiqueta">
			<th width="15%">Codigo</th>
			<th width="30%">Nombre</th>
            <th width="30%">Zona</th>
            <th width="15%">Activo</th>
		    <th width="10%" align="center" class="imgLink"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Detalle" title="Detalle Registro" width="30px" height="30px" border="null"/></a></th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = "  SELECT proveedores.codigo, proveedores.cod_prov_tipo,
	                 prov_tipos.descripcion AS prov_tipo, proveedores.cod_zona,
	                 zonas.descripcion AS zona,  proveedores.cod_estado,
					 estados.descripcion AS estados, proveedores.cod_ciudad,
					 ciudades.descripcion AS ciudad, proveedores.rif,
					 proveedores.nit, proveedores.nacional,
					 proveedores.nombre, proveedores.telefono,
					 proveedores.fax, proveedores.direccion,
					 proveedores.email, proveedores.website,
					 proveedores.contacto, proveedores.dias_credito,
					 proveedores.lim_credito, proveedores.plazo_pago,
					 proveedores.desc_pago, proveedores.desc_global,
					 proveedores.campo01, proveedores.campo02,
					 proveedores.campo03, proveedores.campo04,
					 proveedores.status
                FROM proveedores , prov_tipos,  zonas , estados , ciudades
			   WHERE proveedores.cod_prov_tipo = prov_tipos.codigo
				 AND proveedores.cod_zona = zonas.codigo
				 AND proveedores.cod_estado = estados.codigo
				 AND proveedores.cod_ciudad = ciudades.codigo ";

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
        echo '<tr class="texto '.$fondo.'">
                  <td>'.$datos["codigo"].'</td>
                  <td>'.$datos["nombre"].'</td>
				   <td>'.$datos["zona"].'</td>
				  <td>'.statuscal($datos["status"]).'</td>
				  <td align="center" class="imgLink"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'"/></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
