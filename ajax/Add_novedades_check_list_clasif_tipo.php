<?php 
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 

//require_once('../autentificacion/aut_config.inc.php'); 
//include_once('../funciones/mensaje_error.php');
$ubicacion = $_POST['codigo'];
$perfil    = $_POST['perfil'];
?><table width="100%">
		<tr><td class="etiqueta" width="15%">CLASIFICACION:</td>
            <td width="25%" id="select04"><select  name="clasif" id="clasif" style="width:150px;" onchange="Add_filtroX()">
					<option value="">Seleccione...</option> 
		<?php 					 
				$sql01    = "SELECT nov_clasif.codigo, nov_clasif.descripcion
                               FROM nov_cl_ubicacion , novedades, nov_clasif, nov_perfiles
                              WHERE nov_cl_ubicacion.cod_cl_ubicacion = '$ubicacion' 
								AND nov_perfiles.cod_perfil = '$perfil'
                                AND nov_perfiles.cod_nov_clasif = novedades.cod_nov_clasif
                                AND nov_cl_ubicacion.cod_novedad = novedades.codigo 
                                AND novedades.cod_nov_clasif = nov_clasif.codigo
								AND nov_clasif.campo04 = 'T'
                           GROUP BY novedades.cod_nov_clasif ORDER BY 2 ASC";
	   			$query01 = $bd->consultar($sql01);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select> </td>
			<td class="etiqueta">TIPO:</td>
            <td id="select05"><select  name="tipo" id="tipo" style="width:150px;" onchange="Add_filtroX()">
                	<option value="">Seleccione...</option>
					<?php 
				$sql01    = "SELECT nov_tipo.codigo, nov_tipo.descripcion
                               FROM nov_cl_ubicacion , novedades, nov_tipo
                              WHERE nov_cl_ubicacion.cod_cl_ubicacion = '$ubicacion' 
                                AND nov_cl_ubicacion.cod_novedad = novedades.codigo 
                                AND novedades.cod_nov_tipo = nov_tipo.codigo
                           GROUP BY novedades.cod_nov_tipo ORDER BY 2 ASC";					
					
					$query01 = $bd->consultar($sql01);		
					while($row01=$bd->obtener_fila($query01,0)){							   							
						 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
					} ?></select> </td>
        </tr></table>