<?php
	$Nmenu = '304';
	require_once('autentificacion/aut_verifica_menu.php');
	$bd = new DataBase();
	$archivo = "concepto";
	$titulo = "".$leng['concepto']."";
	$tabla = "conceptos";
	$vinculo = "inicio.php?area=maestros/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&titulo=$titulo&archivo=$archivo";

?>
<div align="center" class="etiqueta_title">Consulta <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="10%" class="etiqueta">C&oacute;digo</th>
			<th width="32%" class="etiqueta">Descripci&oacute;n</th>
			<th width="10%" class="etiqueta">Abrev.</th>

		    <th width="10%" class="etiqueta">Asistencia <br />Diaria</th>
			<th width="10%" class="etiqueta">Asistecia <br />Perfecta</th>
            <th width="10%" class="etiqueta">Valor</th>
            <th width="10%" class="etiqueta">Status</th>
			<th width="12%"><a href="<?php echo $vinculo.'&metodo=agregar';?>"><img src="imagenes/nuevo.bmp" alt="Agregar Registro" width="25" height="25" title="Agregar Registro" border="null" /></a></th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = "  SELECT conceptos.codigo, conceptos.descripcion AS concepto,
	                 conceptos.abrev,
                     Valores(conceptos.asist_perfecta) AS asist_perfecta, Valores(conceptos.asist_diaria) AS asist_diaria,
					 conceptos.`status`, conceptos.valor
                FROM conceptos
            ORDER BY conceptos.status DESC ";

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
                  <td class="texto">'.longitudMax($datos["concepto"]).'</td>
				  <td class="texto">'.$datos["abrev"].'</td>
				  <td class="texto">'.$datos["asist_diaria"].'</td>
				  <td class="texto">'.$datos["asist_perfecta"].'</td>
				  <td class="texto">'.$datos["valor"].'</td>
				  <td class="texto">'.$datos["status"].'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/><a href="inicio.php?area=maestros/Cons_concepto_det&codigo='.$datos[0].'&Nmenu='.$Nmenu.'&categoria="><img src="imagenes/detalle.bmp" alt="Detalle" title="Detalle Registro" width="20px" height="20px" border="null"/></a></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
