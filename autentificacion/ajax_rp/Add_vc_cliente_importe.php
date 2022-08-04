<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$cliente         = $_POST['cliente'];
$cargo           = $_POST['cargo'];
$turno           = $_POST['turno'];

		$where = "WHERE clientes_importe.cod_cliente = clientes.codigo
	                AND clientes_importe.cod_ubicacion = clientes_ubicacion.codigo
                    AND clientes_importe.cod_cargo = cargos.codigo
                    AND clientes_importe.cod_turno = turno.codigo ";

	if($cliente != "TODOS"){
		$where .= " AND clientes.codigo = '$cliente' ";
	}

	if($cargo != "TODOS"){
		$where  .= " AND cargos.codigo = '$cargo' ";
	}

	if($turno != "TODOS"){
		$where  .= " AND turno.codigo = '$turno' ";
	}

	// QUERY A MOSTRAR //
		$sql = " SELECT clientes_importe.fecha, clientes.nombre AS cliente,
                            clientes.abrev AS cl_abrev, clientes_ubicacion.descripcion AS ubicacion,
						    cargos.descripcion AS cargo, turno.descripcion AS turno,
						    clientes_importe.importe, clientes_importe.observacion,
						    clientes_importe.fec_us_mod, clientes_importe.fec_us_ing
                       FROM clientes_importe , clientes , clientes_ubicacion, cargos , turno
                  $where
			    ORDER BY 1 ASC ";

?>
<table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="10%" class="etiqueta">Fecha </th>
            <th width="20%" class="etiqueta"><?php echo $leng['cliente']?></th>
            <th width="20%" class="etiqueta"><?php echo $leng['ubicacion']?></th>
            <th width="20%" class="etiqueta">Cargo</th>
		    <th width="20%" class="etiqueta">Horario </th>
            <th width="10%" class="etiqueta">Importe </th>
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
				  <td class="texto">'.$datos["fecha"].'</td>
				  <td class="texto">'.$datos["cl_abrev"].'</td>
				  <td class="texto">'.longitud($datos["ubicacion"]).'</td>
				  <td class="texto">'.longitud($datos["cargo"]).'</td>
				  <td class="texto">'.longitud($datos["turno"]).'</td>
				  <td class="texto">'.$datos["importe"].'</td>';
        };?>
    </table>
