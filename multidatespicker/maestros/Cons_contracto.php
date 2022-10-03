<?php

	$Nmenu = '313';
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "contracto";
	$bd = new DataBase();
	$archivo = "contracto";
	$titulo = " ".$leng['contrato']."";
	$vinculo = "inicio.php?area=maestros/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&titulo=$titulo&tb=$tabla&archivo=$archivo";

?>
<div align="center" class="etiqueta_title"> Consulta <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="98%" border="0" align="center">
			<tr class="fondo00">
            <th width="10%" class="etiqueta">C&oacute;digo</th>
			<th width="30%" class="etiqueta">Descripcion</th>
			<th width="20%" class="etiqueta">Tipo <?php echo $leng['contrato']?></th>
			<th width="10%" class="etiqueta">Fecha Culminacion</th>
            <th width="10%" class="etiqueta">Cestaticket</th>
            <th width="10%" class="etiqueta">Status</th>
		    <th width="10%"> <a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" width="30px" height="30px" border="null"/></a></th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT contractos.codigo, contractos.descripcion AS contracto,
		            contractos.fec_inicio, contractos.fec_ultimo,
			    	contracto_tipo.descripcion AS tipo_contracto,  contractos.cestaticket,
					contractos.`status`
 			   FROM contractos, contracto_tipo
              WHERE contractos.contracto_tipo = contracto_tipo.codigo
			  ORDER BY 7 DESC";

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
                  <td class="texto">'.$datos["contracto"].'</td>
				  <td class="texto">'.$datos["tipo_contracto"].'</td>
				  <td class="texto">'.$datos["fec_ultimo"].'</td>
				  <td class="texto">'.$datos["cestaticket"].'</td>
				  <td class="texto">'.statuscal($datos["status"]).'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
