<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$codigo       =  $_POST['codigo'];	// rol
$i        = 0; 

    $sql = "SELECT men_perfiles.codigo, men_perfiles.descripcion,
	               IFNULL(nov_perfiles.cod_nov_clasif, 'NO') AS existe 
              FROM men_perfiles LEFT JOIN nov_perfiles 
			    ON men_perfiles.codigo = nov_perfiles.cod_perfil AND nov_perfiles.cod_nov_clasif = '$codigo'
             WHERE men_perfiles.`status` = 'T'
	         ORDER BY 2 ASC ";
   $query = $bd->consultar($sql);
    
	echo'<table width="100%" align="center">
			<tr>
				<td width="75%" class="etiqueta"> PERFIL</td>
				<td width="25%">CHECK</td>
		   </tr>
	<tr> 
            <td height="8" colspan="2" align="center"><hr></td>
     </tr>';

    while($row03=$bd->obtener_fila($query,0)){

	 $campo_id = $row03[0];										  
	 $i++;

		if($row03['existe'] != 'NO'){ 
		$check = 'checked="checked"';
		}else{
		$check = '';	
		}
		echo'
			<tr>
				<td class="etiqueta">'.$row03[1].'</td>
				<td><input type="checkbox" name="perfil[]" id="check'.$i.'" value="'.$row03[0].'" style="width:auto" '.$check.' />
				</td>
		   </tr>';		  		
 	}	
	echo'</table>';	 
	mysql_free_result($query);?>