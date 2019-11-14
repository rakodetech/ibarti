<?php
define("SPECIALCONSTANT",true);
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bdI;
require "../".Leng;
$bd = new DataBase();

$fecha_D   = conversion($_POST['fecha_desde']);
$fecha_H   = conversion($_POST['fecha_hasta']);

$rol       = $_POST['rol'];
$region    = $_POST['region'];
$estado    = $_POST['estado'];
$ciudad    = $_POST['ciudad'];
$cliente   = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];
$contrato  = $_POST['contrato'];
$trabajador = $_POST['trabajador'];

		$where = " WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                     AND asistencia_apertura.codigo = v_asistencia.cod_as_apertura
				     AND v_asistencia.cod_ficha = ficha.cod_ficha
                     AND ficha.cod_ficha = trab_roles.cod_ficha
                     AND ficha.cod_contracto = contractos.codigo
                     AND trab_roles.cod_rol = roles.codigo
                     AND ficha.cod_estado = estados.codigo
                     AND ficha.cod_ciudad = ciudades.codigo ";

	if($rol != "TODOS"){
		$where  .= " AND roles.codigo = '$rol' ";
	}
	if($region != "TODOS"){
		$where .= " AND v_asistencia.cod_region = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND ficha.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$where  .= " AND v_asistencia.cod_ciudad = '$ciudad' ";
	}

	if($cliente != "TODOS"){
		$where  .= " AND v_asistencia.cod_cliente = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where  .= " AND v_asistencia.cod_ubicacion = '$ubicacion' ";
	}

	if($contrato != "TODOS"){
		$where  .= " AND ficha.cod_contracto = '$contrato' ";
	}
	if($trabajador != NULL){
		$where  .= " AND v_asistencia.cod_ficha = '$trabajador' ";
	}

             $sql = " SELECT asistencia_apertura.fec_diaria, roles.descripcion AS rol ,
			          v_asistencia.region,  estados.descripcion AS estado,
					  ciudades.descripcion AS ciudad,  v_asistencia.cliente,
					  v_asistencia.cl_abrev, v_asistencia.ubicacion,
					  contractos.descripcion AS contractos, v_asistencia.cod_ficha,
                      ficha.cedula, CONCAT(ficha.apellidos,' ',ficha.nombres) AS trabajador,
					  v_asistencia.cod_concepto, v_asistencia.abrev,
                      v_asistencia.concepto
                 FROM asistencia_apertura , v_asistencia, ficha, contractos,
				      trab_roles, roles, estados, ciudades
               $where
			 ORDER BY 1 ASC ";

?><table width="100%" border="0" align="center">
		<tr class="fondo00">
  			<th width="8%" class="etiqueta">Fecha</th>
        <th width="20%" class="etiqueta"><?php echo $leng['rol']?></th>
		    <th width="15%" class="etiqueta"><?php echo $leng['cliente']?></th>
        <th width="18%" class="etiqueta"><?php echo $leng['ubicacion']?></th>
        <th width="8%" class="etiqueta"><?php echo $leng['ficha']?></th>
        <th width="25%" class="etiqueta"><?php echo $leng['trabajador']?></th>
        <th width="6%" class="etiqueta">Abrev </th>
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
			      <td class="texto">'.$datos["fec_diaria"].'</td>
				  <td class="texto">'.longitud($datos["rol"]).'</td>
				  <td class="texto">'.$datos["cl_abrev"].'</td>
				  <td class="texto">'.longitud($datos["ubicacion"]).'</td>
				  <td class="texto">'.$datos["cod_ficha"].'</td>
				  <td class="texto">'.longitud($datos["trabajador"]).'</td>
				  <td class="texto">'.$datos["abrev"].'</td>
           </tr>';
        };?>
    </table>
