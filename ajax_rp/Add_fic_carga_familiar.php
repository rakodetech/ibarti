<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$region          = $_POST['region'];
$estado          = $_POST['estado'];
$rol             = $_POST['rol'];
$contrato       = $_POST['contrato'];
$parentesco      = $_POST['parentesco'];

$trabajador      = $_POST['trabajador'];

		$where = " WHERE v_ficha.cod_ficha_status = control.ficha_activo
                     AND v_ficha.cod_ficha = ficha_familia.cod_ficha
 			         AND ficha_familia.cod_parentesco = parentescos.codigo ";

	if($region != "TODOS"){
		$where .= " AND v_ficha.cod_region = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND v_ficha.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($rol != "TODOS"){
		$where .= " AND v_ficha.cod_rol = '$rol' ";
	}

	if($contrato != "TODOS"){
		$where  .= " AND v_ficha.cod_contracto = '$contrato' ";
	}

	if($parentesco != "TODOS"){
		$where .= " AND ficha_familia.cod_parentesco = '$parentesco' ";
	}

	if($trabajador != NULL){
		$where  .= " AND v_ficha.cod_ficha = '$trabajador' ";
	}
	// QUERY A MOSTRAR //
	   $sql = "SELECT  v_ficha.region, v_ficha.rol,
                        v_ficha.estado, v_ficha.ciudad,
                      	v_ficha.contracto, v_ficha.cod_ficha,
						v_ficha.cedula, v_ficha.ap_nombre,
					    ficha_familia.codigo, parentescos.descripcion AS parentescos,
                        ficha_familia.nombres AS familiar, ficha_familia.fec_nac,
						ficha_familia.sexo
                   FROM v_ficha, ficha_familia, parentescos, control
					    $where
			   ORDER BY 2 ASC";
			   
?><table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="20%" class="etiqueta"><?php echo $leng['region']?></th>
            <th width="10%" class="etiqueta"><?php echo $leng['ficha']?></th>
            <th width="30%" class="etiqueta"><?php echo $leng['trabajador']?></th>
            <th width="15%" class="etiqueta">Parentesco </th>
            <th width="25%" class="etiqueta">Familiar</th>
  	</tr>
    <?php
	$valor = 0;
   $query = $bd->consultar($sql);

		while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}
        echo '<tr class="'.$fondo.'">
			      <td class="texto">'.longitud($datos["rol"]).'</td>
				  <td class="texto">'.$datos["cod_ficha"].'</td>
				  <td class="texto">'.longitud($datos["ap_nombre"]).'</td>
				  <td class="texto">'.$datos["parentescos"].'</td>
				  <td class="texto">'.$datos["familiar"].'</td>
           </tr>';
        };?>
    </table>
