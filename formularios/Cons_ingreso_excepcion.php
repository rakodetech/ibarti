<?php
	$Nmenu = '443';
	require 'autentificacion/aut_verifica_menu.php';
	$bd = new DataBase();
	$tabla = "ingreso";
	$archivo = "ingreso_excepcion";
	$titulo = " INGRESO EXCEPCION ";
	$vinculo = "inicio.php?area=formularios/add_$archivo&Nmenu=$Nmenu&mod=$mod&archivo=$archivo&metodo=modificar";
?>
<script language="JavaScript" type="text/javascript">
function FiltarStatus(ValorN){
	var mod = document.getElementById("mod").value;
	var Nmenu = document.getElementById("Nmenu").value;
	var href = "inicio.php?area=formularios/Cons_ingreso2&Nmenu="+Nmenu+"&mod="+mod+"&cod_status="+ValorN+"";
	window.location.href=""+href+"";
	//alert(href);
}
</script>
<div align="center" class="etiqueta_title"> CONSULTA <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="25%" class="etiqueta"><?php echo $leng["estado"];?></th>
			<th width="10%" class="etiqueta"><?php echo $leng["ci"];?></th>
			<th width="30%" class="etiqueta">Nombre</th>
  			<th width="15%" class="etiqueta">Fecha Sistema</th>
            <th width="10%" class="etiqueta">Status</th>
		    <th width="10%" align="center"><img src="imagenes/loading2.gif" alt="Agregar Registro" title="Agregar Registro"
                                                 width="25px" height="25px" border="null"/></th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT preingreso.cod_estado, estados.descripcion AS estados,
	                preingreso.cedula, preingreso.cod_cargo, cargos.descripcion AS cargo,
	                CONCAT(preingreso.apellidos, '', preingreso.nombres) AS nombres,  preingreso.fec_nacimiento,
                    preingreso.sexo, preingreso.telefono,
					preingreso.fec_psic, preingreso.psic_apto,
					preingreso.fec_pol, preingreso.pol_apto,
					preingreso.fec_us_ing,
					preingreso.`status` AS cod_status, preing_status.descripcion AS status
               FROM preingreso , estados, cargos , preing_status, control
              WHERE preingreso.cod_estado = estados.codigo
			    AND  preingreso.cod_cargo = cargos.codigo
                AND preingreso.`status` = preing_status.codigo
                AND preingreso.`status` = control.preingreso_rechazado
		   ORDER BY fec_us_ing DESC";

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
  		          <td>'.$datos["estados"].'</td>
                  <td>'.$datos["cedula"].'</td>
                  <td>'.$datos["nombres"].'</td>
				  <td>'.$datos["fec_us_ing"].'</td>
				  <td>'.$datos["status"].'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos["cedula"].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
