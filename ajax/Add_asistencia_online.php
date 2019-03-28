<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
// require_once('../bd/class_mysql2.php');

$bd  = new DataBase();
// $bd2 = new DataBase2();

$fecha_D  = conversion($_POST['fecha_desde']);
$co_cont      = $_POST['co_cont'];
$rol          = $_POST['rol'];
$cliente      = $_POST['cliente'];
$ubicacion    = $_POST['ubicacion'];
$status       = $_POST['status'];
$horario      = $_POST['horario'];

$where = " WHERE pl_trab_mensual.fecha = '$fecha_D'
             AND pl_trab_mensual.cod_horario = horarios.codigo
             AND pl_trab_mensual.cod_ficha = ficha.cod_ficha
             AND pl_trab_mensual.cod_ficha = trab_roles.cod_ficha
             AND ficha.cod_contracto = ficha.cod_contracto ";
$having = "";

	if($co_cont != "TODOS"){
		$where .= " AND ficha.cod_contracto = '$co_cont' ";
	}

	if($rol != "TODOS"){
		$where .= " AND trab_roles.cod_rol = '$rol' ";
	}

	if($cliente != "TODOS"){
		$where  .= " AND pl_trab_mensual.cod_cliente = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where  .= " AND pl_trab_mensual.cod_ubicacion = '$ubicacion' ";
	}
	if($horario != "TODOS"){
		$where  .= " AND pl_trab_mensual.cod_horario = '$horario' ";
	}

	if($status != "TODOS"){
		if($status == "AS"){
	 	  $having  = " HAVING hora <> 'NO' ";
		}
		if($status == "FI"){
	 	  $having  = " HAVING hora = 'NO' ";
		}

		if($status == "RT"){
	 	  $having  = " HAVING hora = 'NO' ";
		}
	}

?><table width="98%" border="0" align="center">
		<tr class="fondo00">
            <th width="8%" class="etiqueta">Codigo</th>
            <th width="30%" class="etiqueta">Trabajador</th>
			<th width="20%" class="etiqueta">Cliente</th>
   			<th width="20%" class="etiqueta">Ubicacion</th>
			<th width="14%" class="etiqueta">Horario</th>
            <th width="8%" class="etiqueta">Status</th>
		</tr><?php
	$valor = 0;
echo	$SQL_PAG = " SELECT pl_trab_mensual.cod_ficha,  CONCAT(ficha.apellidos,' ',ficha.nombres) AS ap_nombre,
                        pl_trab_mensual.cod_cliente, pl_trab_mensual.cod_ubicacion,
                        horarios.nombre  AS horario, IFNULL(v_ch_inout.hora, 'NO') AS hora,
						Marcaje(IFNULL(v_ch_inout.hora, 'NO')) AS status
                   FROM pl_trab_mensual LEFT JOIN v_ch_inout ON  pl_trab_mensual.fecha =  date_format(v_ch_inout.fecha,'%Y-%m-%d')
                                       AND pl_trab_mensual.cod_ficha = v_ch_inout.cod_ficha
                                       AND pl_trab_mensual.cod_ubicacion = v_ch_inout.cod_ubicacion
                       , horarios, ficha, trab_roles
                 $where
			      GROUP BY pl_trab_mensual.cod_ficha
                 $having
                  ORDER BY ap_nombre ASC ";

   $query = $bd->consultar($SQL_PAG);

		while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}
	 	$ficha         = $datos['cod_ficha'];
		$ap_nombre     = $datos['ap_nombre'];
		$cod_ubicacion = $datos['cod_ubicacion'];
		$cod_cliente   = $datos['cod_cliente'];
		$concepto      = $datos['horario'];
		$status       = $datos['status'];

	$sql02 = "SELECT clientes.nombre AS cliente, clientes_ubicacion.descripcion AS ubicacion
                FROM clientes , clientes_ubicacion
               WHERE clientes.codigo = '$cod_cliente'
                 AND clientes_ubicacion.codigo = '$cod_ubicacion' ";
	$query02 = $bd->consultar($sql02);

	 $row02      = $bd->obtener_fila($query02,0);
     $cliente    = $row02['cliente'];	 $ubicacion  = $row02['ubicacion'];

	// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'">
 				<td class="texto">'.$ficha.'</td>
           		<td class="texto">'.longitudMax($ap_nombre).'</td>
				<td class="texto">'.longitudMin($cliente).'</td>
   				<td class="texto">'.longitudMin($ubicacion).'</td>
				<td class="texto">'.longitudMin($concepto).'</td>
				<td class="texto">'.longitudMin($status).'</td>
            </tr>';
        }
	mysql_free_result($query);
	?></table>
