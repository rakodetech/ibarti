<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 
$ubicacion   = $_POST['ubicacion'];
$fecha       = $_POST['fecha'];
$auto        = $_POST['auto'];

	$sql01 = " SELECT SUM(v_nom_calendario.FER) AS FER, SUM(v_nom_calendario.NL)  AS NL
				 FROM clientes_ubicacion, v_nom_calendario
				WHERE clientes_ubicacion.codigo = '$ubicacion'
				  AND clientes_ubicacion.cod_calendario = v_nom_calendario.cod_calendario
				  AND v_nom_calendario.fecha = \"$fecha\"
			 GROUP BY v_nom_calendario.cod_calendario, v_nom_calendario.fecha ";
			 
   $query = $bd->consultar($sql01);			 
	$row02=$bd->obtener_fila($query,0); 
	$fer = $row02[0]; 
	$nl  = $row02[1]; 

	$sql02 = " SELECT conceptos.codigo, conceptos.descripcion, conceptos.abrev 
				 FROM conceptos 
				WHERE conceptos.`status` = 'T'
				  AND conceptos.asist_diaria = 'T'
			 ORDER BY 3 ASC ";

   $query = $bd->consultar($sql02);
	echo'<select name="concepto'.$auto.'" id="concepto'.$auto.'" style="width:75px">
			     <option value="">Seleccione...</option>'; 
    while($row02=$bd->obtener_fila($query,0)){
				echo '<option value="'.$row02[0].'">'.$row02[2].Feriado_as($fer, "FER").Feriado_as($nl, "NL").'</option>';
				}
		echo'</select><br/><input type="hidden" style="width:0px" id="feriado'.$auto.'" name="feriado'.$auto.'" value="'.$fer.'" /><input type="hidden" style="width:0px"  id="NL'.$auto.'" name="NL'.$auto.'" value="'.$nl.'" />'; 
		mysql_free_result($query);?>