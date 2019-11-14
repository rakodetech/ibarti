<?php
define("SPECIALCONSTANT",true);
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bdI;
require "../".Leng;
$bd = new DataBase();

$contrato        = $_POST['contrato'];
$rol             = $_POST['rol'];

	$where = "WHERE asistencia_cierre.`status` = 'T'
                AND asistencia_cierre.cod_as_apertura =  asistencia_apertura.codigo
                AND asistencia_cierre.cod_rol = roles.codigo
				AND roles.status = 'T'
                AND asistencia_cierre.cod_contracto = contractos.codigo ";

	if($contrato != "TODOS"){
		$where   .= " AND contractos.codigo = '$contrato' ";
	}
	if($rol != "TODOS"){
		$where  .= " AND roles.codigo = '$rol' ";
	}

	// QUERY A MOSTRAR //
		$sql = "SELECT Min(asistencia_apertura.fec_diaria) AS fec_diaria,
                       DATE_ADD(asistencia_apertura.fec_diaria, INTERVAL -1 DAY) AS fecha_cierre,
                       DATEDIFF(CURDATE(), (DATE_ADD(asistencia_apertura.fec_diaria, INTERVAL -1 DAY))) AS dias,
                       asistencia_cierre.cod_rol, roles.descripcion AS rol,
                       asistencia_cierre.cod_contracto, contractos.descripcion AS contrato
                  FROM asistencia_cierre, asistencia_apertura, roles, contractos
					   $where
              GROUP BY asistencia_cierre.cod_rol, roles.descripcion,
                       asistencia_cierre.cod_contracto, contractos.descripcion
          	  ORDER BY 1 ASC";
?><table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="20%" class="etiqueta">Fecha Cierre</th>
             <th width="20%" class="etiqueta">Dias De Atrasos </th>
            <th width="30%" class="etiqueta"><?php echo $leng['rol']?></th>
		    <th width="30%" class="etiqueta"><?php echo $leng['contrato']?></th>
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
				 <td class="texto">'.$datos["fecha_cierre"].'</td>
				 <td class="texto">'.$datos["dias"].'</td>
				 <td class="texto">'.longitud($datos["rol"]).'</td>
                 <td class="texto">'.$datos["contrato"].'</td>';
        };?>
    </table>
