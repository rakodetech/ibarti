<?php
$Nmenu = '403';
require_once('autentificacion/aut_verifica_menu.php');
$tabla = "asistencia usuarios";
$bd = new DataBase();
$archivo = "asig_cliente_rol";
$titulo = " Asignacion Usuario (" . $leng['cliente'] . " Y " . $leng['rol'] . ") ";
$vinculo = "inicio.php?area=formularios/Add_$archivo&Nmenu=$Nmenu&mod=" . $_GET['mod'] . "&titulo=$titulo&tb=$tabla&archivo=$archivo";
$vinculo1 = "inicio.php?area=formularios/Add_usuarios_clientes&Nmenu=$Nmenu&mod=" . $_GET['mod'] . "&titulo=$titulo&tb=$tabla&archivo=$archivo";
$vinculo2 = "inicio.php?area=formularios/Add_usuarios_roles&Nmenu=$Nmenu&mod=" . $_GET['mod'] . "&titulo=$titulo&tb=$tabla&archivo=$archivo";
?>
<div align="center" class="etiqueta_title"> Consulta <?php echo $titulo; ?> </div>
<hr />
<div id="Contenedor01"></div>
<div class="listar">
	<table width="90%" border="0" align="center">
		<tr class="fondo00">
			<th width="20%" class="etiqueta"><?php echo $leng['ci'] ?></th>
			<th width="40%" class="etiqueta">Nombre</th>
			<th width="25%" class="etiqueta">Perfil</th>
			<th width="15%" align="center"><img src="imagenes/seguridad.jpg" width="25px" height="25px" border="null" /></th>
		</tr>
		<?php
		$usuario = $_SESSION['usuario_cod'];
		$valor = 0;
		$sql = " SELECT men_usuarios.codigo, men_usuarios.cedula,
					 men_usuarios.nombre, men_usuarios.apellido,
					 men_perfiles.descripcion AS perfil
				FROM men_usuarios , men_perfiles
			   WHERE men_usuarios.cod_perfil = men_perfiles.codigo
				 AND men_usuarios.`status` = 'T'
			   ORDER BY apellido ASC ";
		$query = $bd->consultar($sql);

		while ($datos = $bd->obtener_fila($query, 0)) {
			if ($valor == 0) {
				$fondo = 'fondo01';
				$valor = 1;
			} else {
				$fondo = 'fondo02';
				$valor = 0;
			}
			// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
			$Borrar = "Borrar01('" . $datos[0] . "')";
			echo '<tr class="' . $fondo . '">
                  <td class="texo">' . $datos["cedula"] . '</td>
                  <td class="texo">' . $datos["apellido"] . '&nbsp;' . $datos["nombre"] . '</td>
				  <td class="texo">' . $datos["perfil"] . '</td>
				  <td align="center"><a href="' . $vinculo1 . '&codigo=' . $datos[0] . '&metodo=usuarios_clientes"> <img src="imagenes/clientes.jpg" alt="Clientes" title="' . $leng["cliente"] . '" width="25px" height="25px" border="null"/></a>&nbsp; <a href="' . $vinculo2 . '&codigo=' . $datos[0] . '&metodo=usuarios_roles"><img src="imagenes/usuario02.gif  " alt="' . $leng['rol'] . '" title="Roles" width="25px" height="25px" border="null"/></a></td>
            </tr>';
		}
		echo '<input type="hidden" name="tabla" id="tabla" value="' . $tabla . '"/>';
		?>
	</table>
</div>