<?php
include_once('../autentificacion/aut_config.inc.php');
include_once('../funciones/funciones.php');
mysql_select_db($bd_cnn, $cnn);

$id       =  $_POST['id'];	
$usuario  = $_POST['usuario'];
$filtro   = $_POST['filtro'];
$i        = 0; 

	if($filtro == "TODOS"){
	$query03 = mysql_query("SELECT clientes.co_cli, clientes.cli_des, clientes_ubicacion.id, clientes_ubicacion.descripcion
							  FROM clientes, clientes_ubicacion
							 WHERE clientes.co_cli =  clientes_ubicacion.co_cli 
							   AND clientes.inactivo =  'false' 
							   AND clientes_ubicacion.status =  '1'
							 ORDER BY clientes.cli_des ASC",$cnn)or die
									 ('<br><h3>Error Consulta # 1:</h3> '.mysql_error().'<br>');					 
	}else{	
	$query03 = mysql_query("SELECT clientes.co_cli, clientes.cli_des, clientes_ubicacion.id, clientes_ubicacion.descripcion
							  FROM clientes, clientes_ubicacion
							 WHERE clientes.co_cli =  clientes_ubicacion.co_cli 
							   AND clientes.inactivo =  'false' 
							   AND clientes_ubicacion.id_region = '$filtro'
							   AND clientes_ubicacion.status =  '1'
							 ORDER BY clientes.cli_des ASC",$cnn)or die
									 ('<br><h3>Error Consulta # 1:</h3> '.mysql_error().'<br>');	 				 
	}
echo'<table width="96%" align="center">';
	while($row03=mysql_fetch_array($query03)){
	 $campo_id = $row03[2];										  
	  $i++;
	  $query04 = mysql_query("SELECT id_usuario FROM usuario_cliente
							   WHERE id_usuario = '$usuario'
								 AND codigo     = '$campo_id'
								 AND tipo       ='C'", $cnn) or die
								 ('<br><h3>Error Consulta # 4:</h3> '.mysql_error().'<br>');
							 
		  if (mysql_num_rows($query04)!=0){
				echo'
					<tr>
						<td class="texto">'.$row03[1].'&nbsp;&nbsp;'.$row03[3].'</td>
						<td><input type="checkbox" name="check'.$row03[2].'" id="check'.$i.'"  value="S" style="width:auto" checked="checked"/>
						</td>
				   </tr>';
		  }else{

				echo'
					<tr>
						<td class="texto">'.$row03[1].'&nbsp;&nbsp;'.$row03[3].'</td>
						<td><input type="checkbox" name="check'.$row03[2].'" id="check'.$i.'"  value="S" style="width:auto"/>
						</td>
				   </tr>';
/*
	  $query05 = mysql_query("SELECT id_usuario FROM usuario_cliente
							   WHERE codigo     = '$campo_id'
								 AND tipo       ='C'", $cnn) or die
								 ('<br><h3>Error Consulta # 5:</h3> '.mysql_error().'<br>');
							 
			  if (mysql_num_rows($query05)==0){			  
				echo'
					<tr>
						<td class="texto">'.$row03[1].'&nbsp;&nbsp;'.$row03[3].'</td>
						<td><input type="checkbox" name="check'.$row03[2].'" id="check'.$i.'"  value="S" style="width:auto"/>
						</td>
				   </tr>';
			  }

*/
		  }	
	}
	
echo '<tr>
            <td  colspan="2"><input name="archivo" type="hidden"  value="clientes"/>
							 <input name="filtro" type="hidden"  value="'.$filtro.'"/>
							 <input id="n_incr" type="hidden"  value="'.$i.'"/></td>
	   </tr></table>';	 
mysql_close($cnn); 	  
?>