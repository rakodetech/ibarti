<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$region    = $_POST['region'];
$estado    = $_POST['estado'];
$cliente   = $_POST['cliente'];
$turno     = $_POST['turno'];
$cargo     = $_POST['cargo'];
$cliente   = $_POST['cliente'];

$fecha_D   = conversion($_POST['fecha_desde']);
$fecha_H   = conversion($_POST['fecha_hasta']);

	$where = "  WHERE pl_cliente.fecha BETWEEN  \"$fecha_D\" AND \"$fecha_H\"
                  AND pl_cliente.codigo = pl_cliente_det.cod_pl_cliente
				  AND pl_cliente.cod_turno = turno.codigo
			      AND turno.cod_horario = horarios.codigo
				  AND pl_cliente_det.cod_region = regiones.codigo
			      AND pl_cliente_det.cod_estado = estados.codigo
                  AND pl_cliente_det.cod_cliente = clientes.codigo
                  AND pl_cliente_det.cod_cargo = cargos.codigo ";

	if($region != "TODOS"){
		$where .= " AND pl_cliente_det.cod_region = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND estados.codigo = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($turno != "TODOS"){
		$where  .= " AND turno.codigo = '$turno' ";
	}

	if($cargo != "TODOS"){
		$where  .= " AND cargos.codigo = '$cargo' ";
	}

	if($cliente != "TODOS"){
		$where  .= " AND clientes.codigo = '$cliente' ";
	}

 $sql = " SELECT  pl_cliente.fecha,  regiones.descripcion AS region,
                  estados.descripcion AS estado, clientes.abrev AS cl_abrev,
                  turno.abrev AS turno,   horarios.nombre AS horario,
				   cargos.descripcion AS cargo, SUM(pl_cliente_det.cantidad) AS cantidad,
				   (SUM(pl_cliente_det.cantidad) * turno.trab_cubrir) AS trab_necesario
             FROM pl_cliente , turno , horarios , pl_cliente_det ,
                  regiones , estados , clientes ,  cargos
            $where
          GROUP BY pl_cliente.fecha, regiones.descripcion,
                   estados.descripcion, clientes.nombre,
                   turno.descripcion, horarios.nombre,
                   cargos.descripcion
         ORDER BY 1 ASC ";

?>
<table width="100%" border="0" align="center">
		<tr class="fondo00">
  			<th width="10%" class="etiqueta">Fecha</th>
            <th width="20%" class="etiqueta"><?php echo $leng['estado']?></th>
            <th width="15%" class="etiqueta"><?php echo $leng['cliente']?></th>
            <th width="15%" class="etiqueta">Turno</th>
            <th width="25%" class="etiqueta">Cargo</th>
            <th width="5%" class="etiqueta">Cantidad </th>
            <th width="10%" class="etiqueta"><?php echo $leng['trabajador']?>. Nec. </th>

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
				  <td class="texto">'.longitud($datos["estado"]).'</td>
				  <td class="texto">'.longitud($datos["cl_abrev"]).'</td>
				  <td class="texto">'.longitud($datos["turno"]).'</td>
				  <td class="texto">'.longitud($datos["cargo"]).'</td>
				  <td class="texto">'.$datos["cantidad"].'</td>
				  <td class="texto">'.$datos["trab_necesario"].'</td>

           </tr>';
        };?>
    </table>
