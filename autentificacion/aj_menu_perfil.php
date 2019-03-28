<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd       = new DataBase();
$codigo   = $_POST['codigo']; // menu
$menu     = $_POST['menu'];
$modulo   = $_POST['modulo'];

$i        = 0;

	$sql = " SELECT men_menu.codigo, men_menu.descripcion, IFNULL(a.cod_menu, 0) AS cantida ,  IFNULL(a.consultar, 'false') AS consultar ,
                     IFNULL(a.agregar, 'false') AS agregar,  IFNULL(a.modificar, 'false') AS modificar, IFNULL(a.eliminar, 'false') AS eliminar  
               FROM men_menu_modulos LEFT JOIN men_perfil_menu AS a 
			                         ON men_menu_modulos.cod_menu = a.cod_menu AND men_menu_modulos.cod_men_principal = a.cod_men_principal  
									 AND a.cod_men_perfil = '$codigo' AND men_menu_modulos.cod_menu_modulo = a.cod_menu_modulo ,
					men_menu 
              WHERE men_menu_modulos.cod_men_principal = '$menu' 
                AND men_menu_modulos.cod_menu_modulo   = '$modulo'                         
                AND men_menu_modulos.cod_menu = men_menu.codigo 
				AND men_menu.status = 'T'
				AND men_menu.codigo != '435'
				AND men_menu.codigo != '444'
              ORDER BY 2 ASC ";
		   
   $query = $bd->consultar($sql);
	echo'<table width="90%" align="center">
			<tr class="fondo01">
				<td class="etiqueta" width="30%" >MENU</td>
			    <td width="5%"><img src="imagenes/consultar.png" width="20" height="20" alt="Consultar" class="imgLink" title="Consultar"/></td>
				<td width="5%"><img src="imagenes/nuevo.bmp" width="20" height="20" alt="Agregar" class="imgLink" title="Agregar"/></td>
				<td width="5%"><img src="imagenes/actualizar.bmp" width="20" height="20" class="imgLink" alt="Modificar" title="Modificar"/></td>
				<td width="5%"><img src="imagenes/borrar.bmp" width="20" height="20" class="imgLink" alt="Borrar" title="Borrar"/></td>
			</tr>';
	$valor = 0;

    while($row03=$bd->obtener_fila($query,0)){
	$i++;
		if ($valor == 0){
			$fondo = 'fondo02';
		$valor = 1;
		}else{
			$fondo = 'fondo01';
			$valor = 0;
		}
		if($row03['cantida'] != '0'){ 

		$con = CheckX("".$row03['consultar']."", "true");
		$add = CheckX("".$row03['agregar']."", "true");
		$mod = CheckX("".$row03['modificar']."", "true");
		$eli = CheckX("".$row03['eliminar']."", "true");
			echo'
				<tr class="'.$fondo.'">
					<td class="texto" >'.$row03[1].'</td>
					<td><input type="checkbox" name="menu_cons[]" value="'.$row03['codigo'].'" style="width:auto" '.$con.' /></td>
					<td><input type="checkbox" name="menu_add[]" value="'.$row03['codigo'].'" style="width:auto" '.$add.' /></td>
					<td><input type="checkbox" name="menu_mod[]" value="'.$row03['codigo'].'" style="width:auto" '.$mod.' /></td>
					<td><input type="checkbox" name="menu_eli[]" value="'.$row03['codigo'].'" style="width:auto" '.$eli.'/></td>
			   </tr>';
		  }else{	

			echo'
				<tr class="'.$fondo.'">
					<td class="texto">'.$row03[1].'</td>
					<td><input type="checkbox" name="menu_cons[]" value="'.$row03['codigo'].'" style="width:auto"/></td>
					<td><input type="checkbox" name="menu_add[]" value="'.$row03['codigo'].'" style="width:auto"/></td>
					<td><input type="checkbox" name="menu_mod[]" value="'.$row03['codigo'].'" style="width:auto"/></td>
					<td><input type="checkbox" name="menu_eli[]" value="'.$row03['codigo'].'" style="width:auto"/></td>					
			   </tr>';
		  }}
		  mysql_free_result($query);?>

