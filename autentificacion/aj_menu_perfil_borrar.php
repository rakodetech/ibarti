<?php
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

	$codigo = $_POST['codigo'];
	$modulo = $_POST['modulo'];
	
	/*
	
	SELECT men_menu_modulos.cod_menu, men_menu.descripcion
FROM men_menu_modulos, men_menu
 WHERE cod_menu_modulo = '002' 
AND men_menu_modulos.cod_men_principal = '04' 
AND men_menu_modulos.cod_menu = men_menu.codigo
ORDER BY 2 ASC

*/
	
?><table width="800px" border="0" align="center">	
	<tr> <?php 
		$sql = " SELECT codigo, descripcion FROM men_principal 
				  WHERE status = 't'  AND codigo != '02' ORDER BY orden ASC ";
		$query01 = $bd->consultar($sql);
			while($row01=$bd->obtener_fila($query01,0)){
			echo'<td class="etiqueta" width="25%" valign="top">'.$row01[1].'';
				$campo_id = $row01[0];

        	$sql = " SELECT men_menu.codigo, men_menu.descripcion
                       FROM men_menu_modulos, men_menu 
                      WHERE men_menu_modulos.cod_men_principal = '$campo_id' 
                        AND men_menu_modulos.cod_menu_modulo = '$modulo'                         
                        AND men_menu_modulos.cod_menu = men_menu.codigo 
						AND men_menu.status = 'T'";			
				
		$query = $bd->consultar($sql);
		$valor = 0;
			while($row03=$bd->obtener_fila($query,0)){

			$cod_menu = $row03[0];
			$sql = " SELECT cod_menu FROM men_perfil_menu   
					  WHERE cod_menu = '$cod_menu' AND cod_men_perfil  = '$codigo' ";
			$query02 = $bd->consultar($sql);
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}

			if ($bd->num_fila($query02)==0){	
			$checkX ='';
			}else{
			$checkX = 'checked="checked"';
			}			

			echo'<table width="100%" border="0" align="center" id="Checkbox'.$campo_id.'" > 		
				<tr valign="top" class="'.$fondo.'">
					<td width="80%" class="texto">'.$row03[1].'</td>
					<td width="15%"><input name="menu[]" type="checkbox" value="'.$row03[0].'" style="width:auto" '.$checkX.'/></td>	
			        <td width="5%">&nbsp;</td>
				</tr></table>';
				}	
			echo '</td>';
			}			
	 ?></tr></table>	
     
     
     