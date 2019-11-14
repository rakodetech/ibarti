<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

if(($_POST['fecha_desde'] == "" or $_POST['fecha_hasta'] == "")){
	exit;
}

$fecha_D   = conversion($_POST['fecha_desde']);
$fecha_H   = conversion($_POST['fecha_hasta']);

$categoria  = $_POST['categoria'];
$contrato   = $_POST['contrato'];
$rol        = $_POST['rol'];
$estado     = $_POST['estado'];
$ciudad     = $_POST['ciudad'];

$trabajador = $_POST['trabajador'];
	$where01 = " "; // feriado

	if($categoria == '01'){ // NOMINA

	$where = "   WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                 AND asistencia_apertura.codigo = asistencia.cod_as_apertura
								 AND asistencia.feriado = '0'
				         AND asistencia.cod_ficha = ficha.cod_ficha
                 AND asistencia.cod_ficha = trab_roles.cod_ficha
                 AND trab_roles.cod_rol =  concepto_det.cod_rol
                 AND concepto_det.cod_categoria = '$categoria'
				         AND asistencia.cod_concepto = concepto_det.codigo ";
// feriados 04
 	 	$where01 = "  WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
	                  AND asistencia_apertura.codigo = asistencia.cod_as_apertura
										 AND asistencia.feriado = '1'
	 				          AND asistencia.cod_ficha = ficha.cod_ficha
	                  AND asistencia.cod_ficha = trab_roles.cod_ficha
	                  AND trab_roles.cod_rol =  concepto_det.cod_rol
	                  AND concepto_det.cod_categoria = '04'
	 				          AND asistencia.cod_concepto = concepto_det.codigo ";

	}elseif ($categoria == '02'){  // CESTATICKET

	$where = "   WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                 AND asistencia_apertura.codigo = asistencia.cod_as_apertura
				 AND asistencia.cod_ficha = ficha.cod_ficha
                 AND asistencia.cod_ficha = trab_roles.cod_ficha
                 AND trab_roles.cod_rol =  concepto_det.cod_rol
                 AND concepto_det.cod_categoria = '$categoria'
				 AND asistencia.cod_concepto = concepto_det.codigo
                 AND trab_roles.cod_rol = roles.codigo";

	}elseif($categoria == '03'){ // HORA EXTRAS

	$where = " WHERE a.cod_ficha = ficha.cod_ficha
		           AND a.cod_ficha = trab_roles.cod_ficha
		           AND trab_roles.cod_rol = roles.codigo
	           	 AND ficha.cod_contracto = contractos.codigo ";

	}elseif($categoria == '04'){ // FERIADOS

	$where = " WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                 AND asistencia_apertura.codigo = asistencia.cod_as_apertura
				 AND asistencia.feriado = '1'
				 AND asistencia.cod_ficha = ficha.cod_ficha
                 AND asistencia.cod_ficha = trab_roles.cod_ficha
                 AND trab_roles.cod_rol =  concepto_det.cod_rol
                 AND concepto_det.cod_categoria = '$categoria'
				 AND asistencia.cod_concepto = concepto_det.codigo
				 AND concepto_det.cod_concepto = conceptos.codigo
                 AND trab_roles.cod_rol = roles.codigo ";

	}elseif($categoria == '05'){ // NO LABORAL

	$where = " WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                 AND asistencia_apertura.codigo = asistencia.cod_as_apertura
				 AND  asistencia.no_laboral= '1'
				 AND asistencia.cod_ficha = ficha.cod_ficha
                 AND asistencia.cod_ficha = trab_roles.cod_ficha
                 AND trab_roles.cod_rol =  concepto_det.cod_rol
                 AND concepto_det.cod_categoria = '$categoria'
				 AND asistencia.cod_concepto = concepto_det.codigo
				 AND concepto_det.cod_concepto = conceptos.codigo
                 AND trab_roles.cod_rol = roles.codigo ";

	}elseif($categoria == '06'){ // VALES

	$where = "  WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                  AND asistencia_apertura.codigo = asistencia.cod_as_apertura
				  AND asistencia.cod_ficha = ficha.cod_ficha
                  AND asistencia.cod_ficha = trab_roles.cod_ficha
		          AND trab_roles.cod_rol = roles.codigo ";
	}

	if($rol != "TODOS"){
		$where  .= " AND trab_roles.cod_rol  = '$rol' ";
		$where01  .= " AND trab_roles.cod_rol  = '$rol' ";
	}

	if($estado != "TODOS"){
		$where .= " AND ficha.cod_estado = '$estado' ";
		$where01 .= " AND ficha.cod_estado = '$estado' ";
	}

	if($ciudad != "TODOS"){
		$where  .= " AND ficha.cod_ciudad = '$ciudad' ";
		$where01  .= " AND ficha.cod_ciudad = '$ciudad' ";
	}

	if($contrato != "TODOS"){
		$where  .= " AND ficha.cod_contracto = '$contrato' ";
		$where01  .= " AND ficha.cod_contracto = '$contrato' ";
	}

	if($trabajador != NULL){
		$where  .= " AND ficha.cod_ficha = '$trabajador' ";
		$where01  .= " AND ficha.cod_ficha = '$trabajador' ";
	}

	if($categoria == '01'){ // NOMINA

 		$sql = "CREATE TEMPORARY TABLE temp_asistencia AS
              SELECT trab_roles.cod_rol, ficha.cod_ficha,
                      concepto_det.cod_concepto, SUM(concepto_det.cantidad) cantidad
                 FROM asistencia_apertura, asistencia, ficha, trab_roles, concepto_det
               $where
                GROUP BY ficha.cod_ficha, concepto_det.cod_concepto
            UNION ALL
						SELECT trab_roles.cod_rol, ficha.cod_ficha,
										 concepto_det.cod_concepto, SUM(concepto_det.cantidad) cantidad
								FROM asistencia_apertura, asistencia, ficha, trab_roles, concepto_det
							$where01
							 GROUP BY ficha.cod_ficha, concepto_det.cod_concepto ";

   $query = $bd->consultar($sql);

	$sql = "SELECT roles.descripcion rol,  a.cod_ficha, ficha.cedula,
                 CONCAT(ficha.apellidos, ' ',ficha.nombres) trabajador,
                 a.cod_concepto, SUM(a.cantidad) cantidad
            FROM temp_asistencia a, ficha, roles
           WHERE a.cod_ficha = ficha.cod_ficha
             AND a.cod_rol = roles.codigo
        GROUP BY a.cod_ficha, a.cod_concepto
          HAVING SUM(a.cantidad) > 0 ";

 $query = $bd->consultar($sql);

?><table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="20%" class="etiqueta"><?php echo $leng['rol']?></th>
            <th width="12%" class="etiqueta"><?php echo $leng['ficha']?></th>
            <th width="12%" class="etiqueta"><?php echo $leng['ci']?></th>
            <th width="30%" class="etiqueta"><?php echo $leng['trabajador']?></th>
            <th width="16%" class="etiqueta"><?php echo $leng['concepto']?></th>
            <th width="10%" class="etiqueta">Valor</th>
  	</tr>
    <?php
	$valor = 0;
   $query = $bd->consultar($sql);

		while($datos=$bd->obtener_fila($query,0)){
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
				      <td class="texto">'.$datos["cedula"].'</td>
				      <td class="texto">'.longitud($datos["trabajador"]).'</td>
				      <td class="texto">'.longitud($datos["cod_concepto"]).'</td>
				      <td class="texto">'.longitud($datos["cantidad"]).'</td>
           </tr>';
        };
    echo '</table>';

	}elseif($categoria == '02'){ // CESTATIKET


		$sql = "SELECT roles.descripcion AS rol,
                     ficha.cod_ficha,  ficha.cedula,
 					CONCAT(ficha.apellidos, ' ',ficha.nombres) AS trabajador,
 					concepto_det.cod_concepto,     SUM(concepto_det.cantidad) AS cantidad
                FROM asistencia_apertura, asistencia, ficha, trab_roles,
 			        concepto_det, roles
 					$where
            GROUP BY  ficha.cod_ficha, concepto_det.cod_concepto
 	       ORDER BY trabajador ASC ";

    $query = $bd->consultar($sql);

 ?><table width="100%" border="0" align="center">
 		<tr class="fondo00">
             <th width="20%" class="etiqueta"><?php echo $leng['rol']?></th>
             <th width="12%" class="etiqueta"><?php echo $leng['ficha']?></th>
             <th width="12%" class="etiqueta"><?php echo $leng['ci']?></th>
             <th width="30%" class="etiqueta"><?php echo $leng['trabajador']?></th>
             <th width="16%" class="etiqueta"><?php echo $leng['concepto']?></th>
             <th width="10%" class="etiqueta">Valor</th>
   	</tr>
     <?php
 	$valor = 0;
    $query = $bd->consultar($sql);

 		while($datos=$bd->obtener_fila($query,0)){
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
 				  <td class="texto">'.$datos["cedula"].'</td>
 				  <td class="texto">'.longitud($datos["trabajador"]).'</td>
 				  <td class="texto">'.longitud($datos["cod_concepto"]).'</td>
 				  <td class="texto">'.longitud($datos["cantidad"]).'</td>
            </tr>';
         };
     echo '</table>';

	}elseif($categoria == '03'){ // HORA EXTRAS

	// QUERY A MOSTRAR //

	$sql = " CREATE TEMPORARY TABLE temp_hora_extra AS
           SELECT asistencia.cod_ficha, asistencia.hora_extra hora_extra_d, 0 AS hora_extra_n
             FROM asistencia_apertura , asistencia
            WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
              AND asistencia_apertura.codigo = asistencia.cod_as_apertura
              AND asistencia.hora_extra > 0
				UNION ALL
				   SELECT asistencia.cod_ficha,  0 AS hora_extra, asistencia.hora_extra_n
             FROM asistencia_apertura , asistencia
            WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
              AND asistencia_apertura.codigo = asistencia.cod_as_apertura
              AND asistencia.hora_extra_n > 0 ";

	$query  = $bd->consultar($sql);

 	$sql = " SELECT roles.descripcion AS rol, contractos.descripcion contrato,
				           a.cod_ficha, ficha.cedula, CONCAT(ficha.apellidos, ' ',ficha.nombres) trabajador,
                	SUM(a.hora_extra_d) hora_extra_d, SUM(a.hora_extra_n) hora_extra_n
	           FROM temp_hora_extra a, ficha, trab_roles,	roles,
						      contractos
             $where
	           GROUP BY a.cod_ficha ASC";

	$query  = $bd->consultar($sql);



?><table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="20%" class="etiqueta"><?php echo $leng['rol']?></th>
				    <th width="20%" class="etiqueta"><?php echo $leng['contrato']?></th>
            <th width="14%" class="etiqueta"><?php echo $leng['ficha']?></th>
            <th width="26%" class="etiqueta"><?php echo $leng['trabajador']?></th>
            <th width="10%" class="etiqueta">HORA EXTRA </br> DIURNA</th>
            <th width="10%" class="etiqueta">HORA EXTRA </br> NOTURNA</th>

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
									<td class="texto">'.longitud($datos["contrato"]).'</td>
								  <td class="texto">'.$datos["cod_ficha"].'</td>
								  <td class="texto">'.longitud($datos["trabajador"]).'</td>
								  <td class="texto">'.$datos["hora_extra_d"].'</td>
								  <td class="texto">'.$datos["hora_extra_n"].'</td>
           </tr>';
        };?>
    </table>
<?php

	}elseif($categoria == '04'){ // FERIADOS
	 $sql = "SELECT roles.descripcion AS rol, ficha.cod_ficha,
				    ficha.cedula, CONCAT(ficha.apellidos, ' ',ficha.nombres) trabajador,
					asistencia.cod_concepto, conceptos.codigo,
					conceptos.abrev, conceptos.descripcion concepto,
                    SUM(concepto_det.cantidad) cantidad
               FROM asistencia_apertura, asistencia, ficha, trab_roles,
			        concepto_det, conceptos, roles
					$where
           GROUP BY trabajador, conceptos.codigo
					HAVING SUM(concepto_det.cantidad) > 0
           ORDER BY 5 ASC ";

   $query = $bd->consultar($sql);

?><table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="25%" class="etiqueta"><?php echo $leng['rol']?></th>
            <th width="10%" class="etiqueta"><?php echo $leng['ficha']?></th>
            <th width="10%" class="etiqueta"><?php echo $leng['ci']?></th>
            <th width="30%" class="etiqueta"><?php echo $leng['trabajador']?></th>
            <th width="15%" class="etiqueta"><?php echo $leng['concepto']?></th>
            <th width="10%" class="etiqueta">VALOR </th>
  	</tr>
    <?php
	$valor = 0;
   $query = $bd->consultar($sql);

		while($datos=$bd->obtener_fila($query,0)){
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
				  <td class="texto">'.$datos["cedula"].'</td>
				  <td class="texto">'.longitud($datos["trabajador"]).'</td>
				  <td class="texto">'.longitud($datos["codigo"]).'</td>
				  <td class="texto">'.longitud($datos["cantidad"]).'</td>
           </tr>';
        };?>
    </table>
<?php

	}elseif($categoria == '05'){ // NO LABORAL

	 $sql = "SELECT roles.descripcion AS rol, ficha.cod_ficha,
				    ficha.cedula, CONCAT(ficha.apellidos, ' ',ficha.nombres) AS trabajador,
					asistencia.cod_concepto, conceptos.codigo,
					conceptos.abrev, conceptos.descripcion AS concepto,
                    SUM(concepto_det.cantidad) AS cantidad
               FROM asistencia_apertura, asistencia, ficha, trab_roles,
			        concepto_det, conceptos, roles
			 $where
           GROUP BY ficha.cod_ficha, conceptos.codigo
           ORDER BY  trabajador ASC ";

   $query = $bd->consultar($sql);

?><table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="20%" class="etiqueta"><?php echo $leng['rol']?></th>
            <th width="15%" class="etiqueta"><?php echo $leng['ficha']?></th>
            <th width="15%" class="etiqueta"><?php echo $leng['ci']?></th>
            <th width="25%" class="etiqueta"><?php echo $leng['trabajador']?></th>
            <th width="15%" class="etiqueta"><?php echo $leng['concepto']?></th>
            <th width="10%" class="etiqueta">VALOR </th>
  	</tr>
    <?php
	$valor = 0;
   $query = $bd->consultar($sql);

		while($datos=$bd->obtener_fila($query,0)){
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
				  <td class="texto">'.$datos["cedula"].'</td>
				  <td class="texto">'.longitud($datos["trabajador"]).'</td>
				  <td class="texto">'.longitud($datos["codigo"]).'</td>
				  <td class="texto">'.longitud($datos["cantidad"]).'</td>
           </tr>';
        };?>
    </table>

	<?php

	}elseif($categoria == '06'){ // VALE
	// QUERY A MOSTRAR //
	 $sql = "SELECT roles.descripcion AS rol, ficha.cod_ficha,
				    ficha.cedula, CONCAT(ficha.apellidos,' ',ficha.nombres) AS trabajador,
                    control.vale_concepto AS cod_vale, SUM(asistencia.vale) AS cantidad
               FROM asistencia_apertura, asistencia, ficha, trab_roles,
			        roles, control
             $where
           GROUP BY ficha.cod_ficha
		   HAVING cantidad > 0
           ORDER BY trabajador ASC";

   $query = $bd->consultar($sql);
?><table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="25%" class="etiqueta"><?php echo $leng['rol']?></th>
            <th width="15%" class="etiqueta"><?php echo $leng['ficha']?></th>
            <th width="30%" class="etiqueta"><?php echo $leng['trabajador']?></th>
            <th width="15%" class="etiqueta">COD VALE </th>
            <th width="15%" class="etiqueta">VALOR </th>
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
				  <td class="texto">'.longitud($datos["trabajador"]).'</td>
				  <td class="texto">'.$datos["cod_vale"].'</td>
				  <td class="texto">'.$datos["cantidad"].'</td>
           </tr>';
        };?>
    </table>
<?php
	}?>
