<?php 
	$Nmenu = '04'; 
	require_once('autentificacion/aut_verifica_menu.php');
	$archivo = "Perfil&Nmenu=$Nmenu";
	$tabla = "men_usuarios";
	$bd = new DataBase();
	$titulo = "USUARIOS DEL SISTEMA";
	$vinculo = "inicio.php?area=autentificacion/Add_usuarios&Nmenu=$Nmenu&mod=".$_GET['mod']."";
?>
<div align="center" class="etiqueta_title"> CONSULTA GENERAL <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div class="listar"><table width="98%" border="0" align="center">
		<tr class="fondo00">
			<th width="10%" class="etiqueta">Cedula</th>
			<th width="25%" class="etiqueta">Nombre</th>
            <th width="25%" class="etiqueta">Apellido</th>
            <th width="12%" class="etiqueta">login</th>
            <th width="18%" class="etiqueta">Perfil</th>
		    <th width="10%" align="center"><a href="<?php echo $vinculo."&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" width="30px" height="30px" border="null"/></a></th> 
		</tr>
    <?php       
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT men_usuarios.codigo, men_usuarios.cedula, men_usuarios.nombre, men_usuarios.apellido,
                    men_usuarios.login, men_usuarios.cod_perfil, men_perfiles.descripcion AS perfil, men_usuarios.pass,
                    men_usuarios.pass_old, men_usuarios.email, men_usuarios.status
               FROM men_usuarios , men_perfiles
              WHERE men_usuarios.cod_perfil = men_perfiles.codigo ORDER BY 2 ASC ";

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
                  <td>'.$datos['cedula'].'</td> 
                  <td>'.$datos['nombre'].'</td>
				  <td>'.$datos['apellido'].'</td>
				  <td>'.$datos['login'].'</td>
				  <td>'.$datos['perfil'].'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro"  border="null" onclick="'.$Borrar.'" class="imgLink"/></td> 
            </tr>'; 
        }     
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>   
</div>