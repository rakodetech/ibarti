<link rel="stylesheet" href="css/modal.css" type="text/css" media="screen" />
<script type="text/javascript" src="modulo/rotacion_turno/funcion.js"></script>

<?php
	$Nmenu = '3001';
	require_once('autentificacion/aut_verifica_menu.php');
?>

<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="CloseModal()" >&times;</span>
      <span id="modal_titulo">Titulo</span>
    </div>
    <div class="modal-body">
			<div id="modal_contenido">Contenido</div>
    </div>
    </div>
</div>
<div id="Cont_rotacion">
</div>
<input name="usuario" id="usuario" type="hidden"  value="<?php echo $_SESSION['usuario_cod'];?>" />
<?php

/*
	$Nmenu = '3001';
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "rotacion";
	$bd = new DataBase();
	$archivo = "rotacion";
	$titulo = " ROTACION ";
	$vinculo = "inicio.php?area=maestros/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&archivo=$archivo";
?>
<div align="center" class="etiqueta_title"> CONSULTA <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar" class="tabla_sistema"><table width="80%" border="0" align="center">
		<tr>
			<th width="15%">Codigo</th>
			<th width="20%">Abrev</th>
            <th width="45%">Descripcion</th>
            <th width="15%">Status</th>
  		    <th width="5%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Detalle" title="Detalle Registro" width="30px" height="30px" border="null"/></a></th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT rotacion.codigo, rotacion.abrev, rotacion.descripcion, rotacion.cod_us_ing,
                    rotacion.`status`
               FROM rotacion
		   ORDER BY 2 ASC ";

   $query = $bd->consultar($sql);

		while ($datos=$bd->obtener_fila($query,0)){


	// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr>
                  <td>'.$datos["codigo"].'</td>
                  <td>'.$datos["abrev"].'</td>
				  <td>'.$datos["descripcion"].'</td>
				  <td>'.statuscal($datos["status"]).'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'"/></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
*/ ?>
