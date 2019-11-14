<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$rol        = $_POST['rol'];
$contrato   = $_POST['contrato'];
$estado     = $_POST['estado'];
$ciudad     = $_POST['ciudad'];
$huellas    = $_POST['huellas'];

$trabajador = $_POST['trabajador'];


$where = " WHERE v_ficha.cod_ficha = v_ficha.cod_ficha ";
/*
 v_ficha.cod_cargo,  v_ficha.cod_ciudad,  v_ficha.cod_region,
*/
	if($rol != "TODOS"){
		$where .= " AND v_ficha.cod_rol  = '$rol' ";
	}

	if($contrato != "TODOS"){
		$where   .= " AND v_ficha.cod_contracto = '$contrato' ";
	}

	if($estado != "TODOS"){
		$where  .= " AND v_ficha.cod_estado = '$estado' ";
	}

	if($ciudad != "TODOS"){
		$where  .= " AND v_ficha.cod_ciudad = '$ciudad' ";
	}

	if($trabajador != NULL){
		$where   .= " AND  v_ficha.cod_ficha = '$trabajador' ";
	}

	// having
	if($huellas != "TODOS"){
		if($huellas == "SI"){
		$where .= "HAVING huella <> 'NO' ";
		}elseif($huellas == "NO"){
		$where .= "HAVING huella = 'NO' ";
		}
	}

	 $sql = "SELECT v_ficha.rol,  v_ficha.contracto, v_ficha.estado,  v_ficha.ciudad,
	                v_ficha.cod_ficha, v_ficha.cedula, v_ficha.ap_nombre, IFNULL(ficha_huella.huella, 'NO') AS huella
               FROM v_ficha LEFT JOIN ficha_huella ON v_ficha.cedula =  ficha_huella.cedula
             $where
  		   ORDER BY 1, 2 ASC ";
   $query = $bd->consultar($sql);
?><table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="20%" class="etiqueta"><?php echo $leng['rol']?></th>
            <th width="20%" class="etiqueta"><?php echo $leng['estado']?></th>
		    <th width="8%" class="etiqueta"><?php echo $leng['ficha']?></th>
		    <th width="8%" class="etiqueta"><?php echo $leng['ci']?></th>
            <th width="24%" class="etiqueta"><?php echo $leng['trabajador']?></th>
            <th width="20%" class="etiqueta">Huella </th>
  	</tr>
    <?php
	$valor = 0;


		while ($datos=$bd->obtener_fila($query,0)){
		 $valor = 0;
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}
        echo '<tr class="'.$fondo.'">
			      <td class="texto">'.$datos["rol"].'</td>
				  <td class="texto">'.longitudMin($datos["estado"]).'</td>
				  <td class="texto">'.longitudMin($datos["cod_ficha"]).'</td>
				  <td class="texto">'.longitudMin($datos["cedula"]).'</td>
				  <td class="texto">'.longitud($datos["ap_nombre"]).'</td>
				  <td class="texto">'.longitud($datos["huella"]).'</td>
           </tr>';
        };?>
    </table>
