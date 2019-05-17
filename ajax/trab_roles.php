<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$codigo       =  $_POST['codigo'];	// rol
$i        = 0;

    $sql = "SELECT ficha.cod_ficha, preingreso.nombres, preingreso.cedula , IFNULL(trab_roles.cod_rol, 'NO') AS rol
		      FROM ficha LEFT JOIN trab_roles on (ficha.cod_ficha = trab_roles.cod_ficha), control, preingreso
			 WHERE ficha.cod_ficha_status = control.ficha_activo
               AND ficha.cedula = preingreso.cedula
			 ORDER BY preingreso.nombres  ASC";
   $query = $bd->consultar($sql);
	echo'<table width="90%" align="center">';

    while($row03=$bd->obtener_fila($query,0)){

	 $campo_id = $row03[0];
	 $i++;

		if($row03['rol'] == $codigo){
			echo'
				<tr>
					<td class="etiqueta">'.$row03[1].'</td>
					<td><input type="checkbox" name="check'.$row03[0].'" id="check'.$i.'" value="S" style="width:auto" checked="checked"/>
					</td>
			   </tr>';
		  }elseif($row03['rol'] == 'NO'){

			echo'
				<tr>
					<td class="etiqueta">'.$row03[1].' - ('.$row03[0].')</td>
					<td><input type="checkbox" name="check'.$row03[0].'" id="check'.$i.'" value="S" style="width:auto"/>
					</td>
			   </tr>';
		  }else{

		  }
 	}
echo '<tr>
            <td  colspan="2"><input name="archivo" type="hidden"  value="trabajadores"/>
							 <input id="n_incr" type="hidden"  value="'.$i.'"/></td>
	   </tr></table>';
	   mysql_free_result($query);?>
