<?php
include_once('../autentificacion/aut_config.inc.php');
include_once('../funciones/funciones.php');
mysql_select_db($bd_cnn, $cnn);


$query02 = mysql_query("SELECT a.id, a.descripcion FROM regiones AS a WHERE a.status =  '1' ORDER BY 2 ASC ", $cnn);

	echo'<select id="trabjadores" style="width:200px" onchange="Actualizar03(this.value, this.id)">
			     <option value="TODOS">TODOS</option>';
			  	 while($row02=mysql_fetch_array($query02))
				 {
			echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
				}
		  echo' 
        </select>&nbsp;&nbsp;
<input type="checkbox" name="Check_ctr" id="Check_ctr" value="yes" onClick="Check()">';

/*
$query02 = mysql_query("SELECT a.co_cont, a.des_cont FROM nomina AS a WHERE a.status =  '1' AND a.tip_cont <> '4'", $cnn);
	echo'<select id="trabajadores" style="width:200px" onchange="Actualizar03(this.value, this.id)">
			     <option value="TODOS">TODOS</option>'; 
			  	 while($row02=mysql_fetch_array($query02))
				 {
			echo '<option value="'.$row02[0].'">'.$row02[1].'&nbsp;('.$row02[0].')</option>';
				}
		  echo' 
        </select>&nbsp;&nbsp;
<input type="checkbox" name="Check_ctr" id="Check_ctr" value="yes" onClick="Check()">';
*/
mysql_close($cnn); 	  
?>