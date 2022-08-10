<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$id       =  $_POST['id'];	
$usuario  = $_POST['usuario'];
$filtro   = $_POST['filtro'];
$i        = 0; 
if($filtro == "TODOS"){
		$sql = " SELECT trabajadores.cod_emp, trabajadores.nombres, trabajadores.ci, trabajadores.co_cont
				   FROM trabajadores
				  WHERE trabajadores.status =  'A'
				  ORDER BY trabajadores.nombres ASC";

}else{	
		$sql = "SELECT trabajadores.cod_emp, a.nombres, trabajadores.ci, trabajadores.co_cont
				  FROM trabajadores 
				 WHERE trabajadores.status =  'A'
				   AND trabajadores.id_region = '$filtro' 
				 ORDER BY trabajadores.nombres ASC";
}

   $query = $bd->consultar($sql);
echo'<table width="90%" align="center">';

    while($row03=$bd->obtener_fila($query,0)){

	 $campo_id = $row03[0];										  
	 $i++;
		/////   CHECKED ///

		$sql04 = "SELECT id_usuario FROM usuario_cliente
							   WHERE id_usuario = '$usuario'
								 AND codigo     = '$campo_id'
								 AND tipo       ='T'";
   $query04 = $bd->consultar($sql04);
					 
		  if ($bd->Obtener_fila($query04)!=0){
			echo'
				<tr>
					<td class="etiqueta">'.$row03[1].'</td>
					<td><input type="checkbox" name="check'.$row03[0].'" id="check'.$i.'" value="S" style="width:auto" checked="checked"/>
					</td>
			   </tr>';
		  }else{
			  
			  	$sql05 = "SELECT id_usuario FROM usuario_cliente
									   WHERE codigo     = '$campo_id'
										 AND tipo       ='T'";
				$query05 = $bd->consultar($sql05);
			  if ($bd->Obtener_fila($query05)!=0){
			 
			echo'
				<tr>
					<td class="etiqueta">'.$row03[1].'</td>
					<td><input type="checkbox" name="check'.$row03[0].'" id="check'.$i.'" value="S" style="width:auto"/>
					</td>
			   </tr>';
			  } 
		  }		
 	}	
echo '<tr>
            <td  colspan="2"><input name="archivo" type="hidden"  value="trabajadores"/>
							 <input name="filtro" type="hidden"  value="'.$filtro.'"/>
							 <input id="n_incr" type="hidden"  value="'.$i.'"/></td>
	   </tr></table>';	 
?>