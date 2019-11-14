<?php
include_once('../funciones/funciones.php');
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();


$rol       = $_POST['rol'];
$region    = $_POST['region'];
$estado    = $_POST['estado'];
$contrato  = $_POST['contrato'];
$cargo     = $_POST['cargo'];
$cliente   = $_POST['cliente'];
$ubicacion = $_POST['ubicacion'];
$turno     = $_POST['turno'];

$Nmenu   = $_POST['Nmenu'];
$mod     = $_POST['mod'];
$archivo = "planif_trabajador2";
$vinculo = "inicio.php?area=formularios/Add_$archivo&Nmenu=$Nmenu&mod=$mod";

	$where = "  WHERE pl_trabajador.cod_turno = turno.codigo
			      AND pl_trabajador.codigo = pl_trabajador_det.cod_pl_trabajador
				  AND pl_trabajador_det.cod_rol = roles.codigo
				  AND pl_trabajador_det.cod_region = regiones.codigo
				  AND pl_trabajador_det.cod_estado = estados.codigo
				  AND pl_trabajador_det.cod_contrato = contractos.codigo
				  AND pl_trabajador_det.cod_cargo = cargos.codigo
				  AND pl_trabajador_det.cod_cliente = clientes.codigo
				  AND pl_trabajador_det.cod_ubicacion = clientes_ubicacion.codigo
                  AND pl_trabajador_det.cod_ficha = ficha.cod_ficha
                  AND ficha.cedula = preingreso.cedula ";

	if($rol != "TODOS"){
		$where .= " AND roles.codigo = '$rol' ";
	}
	if($region != "TODOS"){
		$where .= " AND regiones.codigo = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND estados.codigo = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($contrato != "TODOS"){
		$where  .= " AND contractos.codigo = '$contrato' ";
	}
	if($cargo != "TODOS"){
		$where  .= " AND cargos.codigo = '$cargo' ";
	}

	if($cliente != "TODOS"){
		$where  .= " AND clientes.codigo = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where  .= " AND pl_trabajador_det.cod_ubicacion = '$ubicacion' ";
	}

	if($turno != "TODOS"){
		$where  .= " AND turno.codigo = '$turno' ";
	}

 $sql = "SELECT pl_trabajador.fecha, turno.abrev AS turno_abrev,
	            pl_trabajador.cod_turno, turno.descripcion AS turno,
                roles.descripcion AS rol,
                regiones.descripcion AS region, estados.descripcion AS estado,
                contractos.descripcion AS contrato, cargos.descripcion AS cargo,
                clientes.nombre AS cliente, clientes.abrev,
				pl_trabajador_det.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion,
				pl_trabajador_det.cod_ficha, CONCAT(preingreso.apellidos,' ',preingreso.nombres) AS trabajador
           FROM pl_trabajador , turno , pl_trabajador_det , roles,  regiones ,
                estados , contractos , cargos , clientes ,
                clientes_ubicacion, ficha, preingreso
          $where
         ORDER BY 1 DESC
         LIMIT 0, 50";

   $query = $bd->consultar($sql);
?>
<table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="8%" class="etiqueta">Fecha</th>
            <th width="20%" class="etiqueta">Cliente</th>
		    <th width="22%" class="etiqueta">Ubicacion</th>
            <th width="16%" class="etiqueta">Turno</th>
            <th width="8%" class="etiqueta">Ficha </th>
            <th width="26%" class="etiqueta">Trabajador </th>
  	</tr>
    <?php
	$valor = 0;
   $query = $bd->consultar($sql);

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
				 <td class="texto">'.$datos["fecha"].'</td>
				  <td class="texto">'.$datos["abrev"].'</td>
				  <td class="texto">'.$datos["ubicacion"].'</td>
				  <td class="texto">'.$datos["turno_abrev"].'</td>
				  <td class="texto">'.$datos["cod_ficha"].'</td>
				  <td class="texto">'.$datos["trabajador"].'</td>
           </tr>';
        }; mysql_free_result($query);?>
    </table>
