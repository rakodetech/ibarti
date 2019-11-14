<?php
	$Nmenu = '423';
	$mod   = $_GET['mod'];
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "ficha";
	$bd = new DataBase();
	$archivo = "ficha_sin_ficha";
	$titulo = " RRHH ACTIVO SIN FICHA ";
	$vinculo = "inicio.php?area=pestanas/add_$archivo&Nmenu=$Nmenu&mod=$mod";
?>
<div align="center" class="etiqueta_title"> CONSULTA <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="20%" class="etiqueta"><?php echo $leng["estado"];?></th>
			<th width="10%" class="etiqueta"><?php echo $leng["ci"];?></th>
			<th width="30%" class="etiqueta">Nombre</th>
            <th width="11%" class="etiqueta">Fec. Ingreso</th>
            <th width="11%" class="etiqueta">Fecha Ult. <br />Actualizacion</th>
            <th width="10%" class="etiqueta">Status</th>
		    <th width="8%" align="center">&nbsp;</th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT preingreso.cedula, estados.descripcion AS estados,
                    IFNULL(v_ficha_sin_eventuales.cod_ficha, 'S') AS valor,
                    CONCAT(preingreso.apellidos, ' ',preingreso.nombres) AS nombres,  preingreso.fec_preingreso,
                    preingreso.fec_us_ing, preingreso.fec_us_mod,
                    preingreso.`status` AS cod_status, preing_status.descripcion AS `status`
               FROM preingreso LEFT JOIN v_ficha_sin_eventuales ON preingreso.cedula = v_ficha_sin_eventuales.cedula,
			        control, estados,  preing_status
              WHERE preingreso.`status` = control.preingreso_aprobado
                AND preingreso.cod_estado = estados.codigo
                AND preingreso.`status` = preing_status.codigo
                AND IFNULL(v_ficha_sin_eventuales.cod_ficha, 'S') = 'S'
           ORDER BY 4 DESC ";

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
                <td>'.longitud($datos["estados"]).'</td>
				  <td>'.$datos["cedula"].'</td>
                  <td>'.longitud($datos["nombres"]).'</td>
				  <td>'.$datos["fec_preingreso"].'</td>
			      <td>'.$datos["fec_us_mod"].'</td>
				  <td>'.$datos["status"].'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=agregar"><img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" width="20" height="20" border="null"/></a></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
