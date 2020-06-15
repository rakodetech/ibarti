<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$fecha_D   = conversion($_POST['fecha_desde']);
$fecha_H   = conversion($_POST['fecha_hasta']);

$rango      = $_POST['rango'];
$rol        = $_POST['rol'];
$region     = $_POST['region'];
$estado     = $_POST['estado'];
$ciudad     = $_POST['ciudad'];
$contrato   = $_POST['contrato'];
$trabajador = $_POST['trabajador'];

	$where = " WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
				 AND asistencia_apertura.codigo = v_asistencia.cod_as_apertura
				 AND v_asistencia.cod_concepto = conceptos.codigo
				 AND conceptos.asist_perfecta = 'S'
				 AND v_asistencia.cod_ficha = ficha.cod_ficha
                 AND ficha.cod_ficha = trab_roles.cod_ficha
                 AND trab_roles.cod_rol = roles.codigo
                 AND ficha.cod_region = regiones.codigo
                 AND ficha.cod_contracto = contractos.codigo
                 AND ficha.cod_estado = estados.codigo
                 AND ficha.cod_ciudad = ciudades.codigo ";

	if($rol != "TODOS"){
		$where  .= " AND roles.codigo   = '$rol' ";
	}
	if($region != "TODOS"){
		$where .= " AND regiones.codigo = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND estados.codigo  = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$where  .= " AND ciudades.codigo = '$ciudad' ";
	}

	if($contrato != "TODOS"){
		$where  .= " AND ficha.cod_contracto = '$contrato' ";
	}

	if($trabajador != NULL){
		$where  .= " AND v_asistencia.cod_ficha = '$trabajador' ";
	}

	// QUERY A MOSTRAR //
	$sql = "SELECT roles.descripcion AS rol, regiones.descripcion AS region,
                   estados.descripcion AS estado, ciudades.descripcion AS ciudad,
                   contractos.descripcion AS contrato, v_asistencia.cod_ficha,
                   ficha.cedula, CONCAT(ficha.apellidos, ' ', ficha.nombres) AS trabajador,
                   COUNT(v_asistencia.cod_concepto) AS cantidad
              FROM asistencia_apertura , v_asistencia ,ficha, trab_roles,
			       roles, regiones, contractos, estados, ciudades, conceptos
                   $where
          GROUP BY roles.descripcion, regiones.descripcion,
                   estados.descripcion, ciudades.descripcion,
                   contractos.descripcion, v_asistencia.cod_ficha,
                   ficha.cedula
		    HAVING cantidad  >= '$rango'
          ORDER BY 1 ASC ";

?><table width="100%" border="0" align="center">
		<tr class="fondo00">

            <th width="20%" class="etiqueta"><?php echo $leng['rol']?></th>
		    <th width="20%" class="etiqueta"><?php echo $leng['estado']?></th>
            <th width="20%" class="etiqueta"><?php echo $leng['contrato']?></th>
            <th width="10%" class="etiqueta"><?php echo $leng['ficha']?></th>
            <th width="22%" class="etiqueta"><?php echo $leng['trabajador']?></th>
            <th width="8%" class="etiqueta">Cantidaddad</th>
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
				  <td class="texto">'.longitud($datos["estado"]).'</td>
				  <td class="texto">'.longitud($datos["contrato"]).'</td>
				  <td class="texto">'.$datos["cod_ficha"].'</td>
				  <td class="texto">'.longitud($datos["trabajador"]).'</td>
				  <td class="texto">'.longitud($datos["cantidad"]).'</td>
           </tr>';
        };?>
    </table>
