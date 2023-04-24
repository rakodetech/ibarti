<?php
	$Nmenu = '006';
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "control_rfid";
	$bd = new DataBase();
	$archivo = "controlrfid";
	$titulo = "CONTROl RFID";
	$href = "inicio.php?area=autentificacion/Cons_$archivo&Nmenu=$Nmenu&mod=$mod";
	$vinculo = "inicio.php?area=maestros/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&titulo=$titulo&tb=$tabla&archivo=$archivo";
?>
<div align="center" class="etiqueta_title">Consulta <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="15%" class="etiqueta">Vienen</th>
			<th width="30%" class="etiqueta">Planificacion</th>
			<th width="30%" class="etiqueta">Feriado</th>
            <th width="15%" class="etiqueta">Registro</th>
		    <th width="30%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" width="30px" height="30px" border="null"/></a></th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql ="SELECT DISTINCT T1.codigo,T2.descripcion vienen, T3.descripcion planificacion,T1.feriado Feriado, t4.descripcion registro FROM control_rfid T1 INNER JOIN conceptos T2 ON T1.cod_concepto_viene = T2.codigo INNER JOIN conceptos t3 on T1.cod_concepto_planif=T3.codigo INNER JOIN conceptos T4 ON T1.cod_concepto_registro = T4.codigo where T1.codigo>0 GROUP by T1.codigo ";

   $query = $bd->consultar($sql);

		while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}

	   $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
	  
	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'">
                  <td class="texto">'.$datos["vienen"].'</td>
                  <td class="texto">'.$datos["planificacion"].'</td>
                  <td class="texto">'.$datos["Feriado"].'</td>
				 <td class="texto">'.$datos["registro"].'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>