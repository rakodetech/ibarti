<?php
	$Nmenu = '436';
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "clientes";
	$bd = new DataBase();
	$archivo = "clientes";
	$vinculo = "inicio.php?area=pestanas/add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&archivo=$archivo";

?>
<div align="center" class="etiqueta_title"> Consulta De  <?php echo $leng['cliente'];?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar" class="tabla_sistema"><table width="100%">
		<tr>
			<th width="15%">Codigo</th>
			<th width="32%">Nombre</th>
  		<th width="30%"><?php echo $leng['region'];?></th>
      <th width="15%" >Activo</th>
		  <th width="8%"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp"  alt="Detalle" title="Agregar Registro" width="25px" height="25px" border="null"/></a></th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT clientes.codigo, clientes.cod_cl_tipo, clientes_tipos.descripcion AS cl_tipo,
                  clientes.cod_vendedor, vendedores.nombre AS vendedor, clientes.cod_region,
                  regiones.descripcion AS region, clientes.abrev, clientes.rif,
					        clientes.nit, clientes.nombre, clientes.telefono,
					        clientes.fax, clientes.direccion, clientes.dir_entrega,
				        	clientes.email, clientes.website, clientes.contacto,
					        clientes.juridico, clientes.contribuyente, clientes.lunes,
					        clientes.martes, clientes.miercoles,  clientes.jueves,
					        clientes.viernes, clientes.sabado, clientes.domingo,
					        clientes.limite_cred, clientes.plazo_pago, clientes.desc_global,
					        clientes.desc_p_pago,
					        clientes.campo01, clientes.campo02, clientes.campo03,
					        clientes.campo04,  clientes.cod_us_ing, clientes.fec_us_ing,
					        clientes.cod_us_mod, clientes.fec_us_mod, clientes.status
			       FROM clientes, clientes_tipos, vendedores, regiones
			      WHERE clientes.cod_cl_tipo = clientes_tipos.codigo
			        AND clientes.cod_vendedor = vendedores.codigo
			        AND clientes.cod_region = regiones.codigo
		     ORDER BY nombre ASC ";

   $query = $bd->consultar($sql);

		while ($datos=$bd->obtener_fila($query,0)){

			// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr>
                <td>'.$datos["codigo"].'</td>
                <td>'.$datos["nombre"].'</td>
				        <td>'.$datos["region"].'</td>
				        <td>'.statuscal($datos["status"]).'</td>
				        <td><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar&pagina=2"><img src="imagenes/detalle.bmp" alt="Detalle" title="Detalle Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" /></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
