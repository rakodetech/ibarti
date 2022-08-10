<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$Nmenu      = $_POST['Nmenu'];
$mod        = $_POST['mod'];
$archivo    = $_POST['archivo']."&Nmenu=$Nmenu&mod=$mod";
$vinculo    = "reportes/rp_nov_check_list_printer.php?Nmenu=$Nmenu&mod=$mod";

$novedades       = $_POST['novedades'];
$clasif          = $_POST['clasif'];
$tipo            = $_POST['tipo'];
$check_list      = $_POST['check_list'];
$valores         = $_POST['valores'];
$status          = $_POST['status'];

	$where = "  WHERE novedades.cod_nov_clasif = nov_clasif.codigo
                  AND novedades.cod_nov_tipo = nov_tipo.codigo ";

	$where02 = "  WHERE novedades.cod_nov_clasif = nov_clasif.codigo
                    AND novedades.cod_nov_tipo = nov_tipo.codigo
                    AND novedades.codigo = nov_valores_det.cod_novedades
                    AND nov_valores_det.cod_valores = nov_valores.codigo ";


	if($novedades != "TODOS"){
		$where  .= " AND novedades.codigo = '$novedades' ";
		$where02 .= " AND novedades.codigo = '$novedades' ";
	}

	if($clasif != "TODOS"){
		$where .= " AND nov_clasif.codigo = '$clasif' ";
 		$where02 .= " AND nov_clasif.codigo = '$clasif' ";
	}

	if($check_list != "TODOS"){
		$where  .= " AND nov_clasif.campo04 = '$check_list' ";
		$where02  .= " AND nov_clasif.campo04 = '$check_list' ";
	}

	if($tipo != "TODOS"){
		$where  .= " AND nov_tipo.codigo = '$tipo' ";
		$where02  .= " AND nov_tipo.codigo = '$tipo' ";
	}
	if($status != "TODOS"){
		$where  .= " AND novedades.`status` = '$status' ";
		$where02  .= " AND novedades.`status` = '$status' ";
	}

	// QUERY A MOSTRAR //
		  	$sql = "SELECT novedades.codigo,   Valores(nov_clasif.campo04) AS check_list,
                           nov_clasif.descripcion AS clasif,  nov_tipo.descripcion AS tipo,
  			               novedades.descripcion AS novedades, Valores(novedades.`status`) AS `status`
                      FROM novedades , nov_clasif, nov_tipo
                    $where
                  ORDER BY  novedades.orden, 3 ASC ";


		  	$sql02 = "SELECT novedades.codigo, Valores(nov_clasif.campo04) AS check_list,
                             nov_clasif.descripcion AS clasif, nov_tipo.descripcion AS tipo,
                             novedades.descripcion AS novedades, Valores(novedades.`status`) AS `status`,
                             nov_valores.abrev, nov_valores.descripcion AS valores,
                             nov_valores.factor, nov_valores_det.valor
                        FROM novedades , nov_clasif , nov_tipo , nov_valores_det ,
                             nov_valores
                    $where02
                  ORDER BY  novedades.orden, 3 ASC ";

if ($valores == "F"){
   $query = $bd->consultar($sql);
?><table width="100%" align="center">
   <tr class="fondo00">
			<th width="10%" class="etiqueta">codigo</th>
  			<th width="15%" class="etiqueta">Check List</th>
			<th width="20%" class="etiqueta">Clasificacion</th>
       		<th width="20%" class="etiqueta">Tipo</th>
            <th width="25%" class="etiqueta">Novedad</th>
            <th width="10%" class="etiqueta">Status</th>
	   </tr>
    <?php
	$valor = 0;
		while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}

	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'">
                  <td class="texo">'.$datos[0].'</td>
				  <td class="texo">'.longitudMin($datos[1]).'</td>
                  <td class="texo">'.longitudMin($datos[2]).'</td>
				  <td class="texo">'.longitudMin($datos[3]).'</td>
				  <td class="texo">'.longitudMax($datos[4]).'</td>
				  <td class="texo">'.$datos[5].'</td>
            </tr>';
        }
	}elseif($valores == "T"){

   $query = $bd->consultar($sql02);
?><table width="100%" align="center">
   <tr class="fondo00">
			<th width="10%" class="etiqueta">codigo</th>
			<th width="20%" class="etiqueta">Clasificacion</th>
       		<th width="20%" class="etiqueta">Tipo</th>
            <th width="25%" class="etiqueta">Novedad</th>
  			<th width="15%" class="etiqueta">Abreviatura</th>
            <th width="10%" class="etiqueta">Valor</th>
	   </tr>
    <?php
	$valor = 0;
		while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}

	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'">
                  <td class="texo">'.$datos[0].'</td>
				  <td class="texo">'.longitudMin($datos[1]).'</td>
                  <td class="texo">'.longitudMin($datos[2]).'</td>
				  <td class="texo">'.longitudMin($datos[3]).'</td>
				  <td class="texo">'.longitudMax($datos[6]).'</td>
				  <td class="texo">'.$datos[9].'</td>
            </tr>';
		}
	}?>
     </table>
