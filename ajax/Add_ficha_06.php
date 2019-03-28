<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);

$bd     = new DataBase();
$cedula = $_POST["codigo"];

	$sql06 = " SELECT ficha_huella.cedula, ficha_huella.huella, ficha_huella.fec_us_ing
               FROM ficha_huella
              WHERE cedula = '$cedula'
           ORDER BY 3 DESC ";

?><table width="80%" border="0" align="center"><tr class="fondo01">
			<th width="25%" class="etiqueta">Fecha </th>
   			<th width="60%" class="etiqueta">Huella</th>
		    <th width="15%"><span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                    <input type="button" name="verificar" id="verificar" value="Verificar Huella"
                    onClick="ActualizarDet('<?php echo $cedula;?>')" class="readon art-button" /></span></th></tr>

    <?php
        $query = $bd->consultar($sql06);
        $i     = 0;
        $valor = 0;
  		while($datos=$bd->obtener_fila($query,0)){
		$i++;
			if ($valor == 0){
				$fondo = 'fondo01';
				$valor = 1;
			}else{
				 $fondo = 'fonddo02';
				 $valor = 0;
			}

			$borrar = 	 "'".$datos[0]."'";
			$modificar = 	 "'modificar', '".$i."'";
			$borrar    = 	 "'eliminar', '".$i."'";
        echo '<tr class="'.$fondo.'">
                  <td>'.$datos['fec_us_ing'].'</td>
                  <td><input type="text" id="huella'.$i.'" style="width:350px" maxlength="64"
				       value="'.$datos['huella'].'"/><input type="hidden" id="huella_old'.$i.'" maxlength="64" value="'.$datos['huella'].'"/>
		  </td><td align="center"><img src="imagenes/borrar.bmp" alt="Detalle" title="Borrar Registro" width="20px" height="20px" border="null"
			   onclick="Borrar('.$borrar.')" class="imgLink" /></td>
	</tr>';
        }mysql_free_result($query);?>
	</table>
