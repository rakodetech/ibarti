<?php
include_once('../autentificacion/aut_config.inc.php');
include_once('../funciones/funciones.php');
	mysql_select_db($bd_cnn, $cnn);

		$codigo    = $_POST['codigo'];
					
			echo '<table width="80%" border="0">
			    <tr>
      				<td class="etiqueta">VARIABLES:</td>
					<td class="etiqueta">VALOR:</td>
					<td class="etiqueta">&nbsp;</td>
    			</tr>';
				
			$query= mysql_query("SELECT productos.codigo, productos.descripcion, productos.existencia
                                      FROM productos 
									 WHERE productos.`status` = 1 
									   AND productos.cod_prod_clasif = '$codigo'
									 ORDER BY 2 ASC ",$cnn) or die
				 ('<br><h3>Error Consulta # 1:</h3> '.mysql_error().'<br>');
			while($row03=mysql_fetch_array($query)){
							
										
					echo'<tr>
							<td width="60%" class="texto">'.$row03[0].' - '.$row03[1].'</td>
							<td width="15%" class="texto"><input type="text" name="'.$row03[0].'" id="'.$row03[0].'" maxlength="10" 
							    onclick="spryValidarDec(this.id)" style="width:100px" value="'.$row03[2].'"/></td>
							<td width="25%">&nbsp;</td>
						</tr>';
					}	
echo '</table>';
mysql_free_result($query);
mysql_close($cnn); 	  
?>