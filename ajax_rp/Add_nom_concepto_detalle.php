<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$concepto        = $_POST['concepto'];
$categoria       = $_POST['categoria'];
$rol             = $_POST['rol'];
$status          = $_POST['status'];

	$where = "WHERE concepto_det.codigo = conceptos.codigo
				AND concepto_det.cod_rol = roles.codigo
				AND concepto_det.cod_categoria = concepto_categoria.codigo ";

	if($concepto != "TODOS"){
		$where  .= " AND conceptos.codigo = '$concepto' ";
	}

	if($categoria != "TODOS"){
		$where  .= " AND concepto_det.cod_categoria = '$categoria' ";
	}

	if($rol != "TODOS"){
		$where  .= " AND roles.codigo = '$rol' ";
	}

	if($status != "TODOS"){

	}elseif($status == "T"){

		$where  .= " AND conceptos.`status` = '$status' ";
	}elseif($status == "T"){

		$where  .= " AND conceptos.`status` = '$status' ";
	}

	// QUERY A MOSTRAR //
		$sql = "SELECT concepto_categoria.descripcion AS categoria, roles.descripcion AS rol,
                       concepto_det.codigo , conceptos.abrev,
					   conceptos.descripcion AS concepto, concepto_det.cod_concepto AS aplicar,
					   concepto_det.cantidad
                  FROM concepto_det, conceptos, concepto_categoria, roles
					   $where
			 ORDER BY categoria, rol,  concepto_det.codigo ASC";

?><table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="20%" class="etiqueta">Categoria</th>
             <th width="20%" class="etiqueta"><?php echo $leng['rol']?> </th>
            <th width="10%" class="etiqueta">Cod. <?php echo $leng['concepto']?></th>
		    <th width="10%" class="etiqueta">Abrev.</th>
            <th width="20%" class="etiqueta"><?php echo $leng['concepto']?></th>
            <th width="10%" class="etiqueta">Aplicar</th>
            <th width="10%" class="etiqueta">Cantidad</th>
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
				 <td class="texto">'.longitud($datos["categoria"]).'</td>
				 <td class="texto">'.longitud($datos["rol"]).'</td>
				 <td class="texto">'.longitud($datos["codigo"]).'</td>
                 <td class="texto">'.$datos["abrev"].'</td>
				 <td class="texto">'.longitud($datos["concepto"]).'</td>
				 <td class="texto">'.$datos["aplicar"].'</td>
				 <td class="texto">'.$datos["cantidad"].'</td>';
        };?>
    </table>
