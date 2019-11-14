<?php
include_once('../funciones/funciones.php');
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();
//require_once('../autentificacion/aut_config.inc.php');
//include_once('../funciones/mensaje_error.php');
//
$codigo     = $_POST['codigo'];
$metodo     = $_POST['metodo'];
$rol        = $_POST['rol'];
$region     = $_POST['region'];
$estado     = $_POST['estado'];
$contrato   = $_POST['contrato'];
$cargo      = $_POST['cargo'];
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];
$rotacion   = $_POST['rotacion'];
// $turno      = $_POST['turno'];
$trabajador = $_POST['trabajador'];

// $fecha_D   = conversion($_POST['fecha_desde']);
// $fecha_H   = conversion($_POST['fecha_hasta']);

// $fecha_planif     = conversion($_POST['fecha_planif']);

	$where = " WHERE ficha.cod_ficha_status = control.ficha_activo
           	     AND ficha.cod_ficha = trab_roles.cod_ficha
                 AND ficha.cod_cliente = clientes.codigo
                 AND ficha.cod_ubicacion = clientes_ubicacion.codigo
                 AND ficha.cod_rotacion = rotacion.codigo
	             AND horarios.codigo = Rotacion(ficha.cod_ficha, ficha.cod_rotacion,  'F') ";

	if($rol != "TODOS"){
		$where .= " AND trab_roles.cod_rol = '$rol' ";
	}

	if($region != "TODOS"){
		$where .= " AND ficha.cod_region = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND ficha.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($contrato != "TODOS"){
		$where  .= " AND ficha.cod_contracto = '$contrato' ";
	}

	if($cargo != "TODOS"){
		$where  .= " AND ficha.cod_cargo = '$cargo' ";
	}

	if($cliente != "TODOS"){
		$where  .= " AND ficha.cod_cliente = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where  .= " AND ficha.cod_ubicacion = '$ubicacion' ";
	}

	if($trabajador != "TODOS"){
		$where  .= " AND ficha.cod_ficha = '$trabajador' ";
	}

 $sql = " SELECT ficha.cod_ficha, ficha.cedula,
                 CONCAT(ficha.apellidos,' ',ficha.nombres) AS ap_nombre, ficha.cod_cliente,
                 clientes.nombre AS cliente,  clientes.abrev AS cliente_abrev,
                 ficha.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion,
                 ficha.cod_rotacion, rotacion.descripcion  AS rotacion,
                (ficha.n_rotacion + 1) AS posicion, horarios.nombre AS horario
            FROM ficha , trab_roles, clientes, clientes_ubicacion,
		         rotacion,  horarios, control
                $where
	  ORDER BY 3 ASC  ";

   $query = $bd->consultar($sql);
?><table width="100%" border="0" align="center">
		<tr class="fondo00">
  			<th width="5%" class="etiqueta">Check</th>
            <th width="10%" class="etiqueta"><?php echo $leng['ficha']?></th>
            <th width="22%" class="etiqueta"><?php echo $leng['trabajador']?></th>
            <th width="15%" class="etiqueta">Rotacion Actual</th>
            <th width="16%" class="etiqueta">Posicion / Horario</th>
            <th width="16%" class="etiqueta"><?php echo $leng['cliente']?></th>
            <th width="16%" class="etiqueta"><?php echo $leng['ubicacion']?></th>
		</tr><?php
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
		    $checkX        = '';
            $ficha         = $datos["cod_ficha"];
			$cod_cliente   = $datos["cod_cliente"];
			$cl_abrev      = $datos["cliente_abrev"];
			$cliente       = $datos["cliente"];
			$cod_ubicacion = $datos["cod_ubicacion"];
			$ubicacion     = $datos["ubicacion"];

		$checkX        = 'checked="checked"';
	// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
	   $aj = "Add_cliente(this.value, '".$ficha."', 'ajax/Add_pl_ubicacion.php', 'ubic_".$ficha."')";
        echo '<tr class="'.$fondo.'">
			      <td class="texto"><input type="hidden" name="cod_det_'.$ficha.'" id="cod_det_'.$ficha.'" value="" /><input
				      name="trabajador[]" type="checkbox" value="'.$ficha.'" style="width:auto" '.$checkX.' /></td>
				  <td class="texto">'.longitudMin($ficha).'</td>
  			      <td class="texto">'.longitudMax($datos["ap_nombre"]).'</td>
				   <td class="texto"><input name="rotacion_'.$ficha.'" id"rotacion_'.$ficha.'" type="hidden"
		                  value="'.$datos["cod_rotacion"].'" size="12"/>'.longitud($datos["rotacion"]).'</td>
				<td>'.$datos["posicion"].' - ('.longitudMin($datos["horario"]).')</td>
				  <td class="texto"><select name="cliente_'.$ficha.'" id="cliente_'.$ficha.'"
				                            style="width:130px;" onchange="'.$aj.'">
						   <option value="'.$cod_cliente.'">('.$cl_abrev .') - '.$cliente.'</option>';
			$sql_cliente = "SELECT clientes.codigo, clientes.nombre FROM clientes
             		         WHERE clientes.`status` = 'T'
                    		   AND clientes.codigo <> ".$cod_cliente."
          				  ORDER BY 2 ASC";
	   				$query03 = $bd->consultar($sql_cliente);
						   while($row03=$bd->obtener_fila($query03,0)){
						   echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
						   }
			echo'</select></td>
				  <td class="texto" id="ubic_'.$ficha.'"><select name="ubicacion_'.$ficha.'" style="width:130px;">
							   <option value="'.$cod_ubicacion.'">'.$ubicacion.'</option>';
		$sql_ubicacion = "SELECT usuario_clientes.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion
                            FROM usuario_clientes , clientes_ubicacion
                           WHERE usuario_clientes.cod_usuario = '$usuario'
                             AND usuario_clientes.cod_ubicacion = clientes_ubicacion.codigo
                             AND clientes_ubicacion.cod_cliente = '".$cod_cliente."'
                             AND clientes_ubicacion.`status` = 'T'
                        ORDER BY 2 ASC ";
							$query06 = $bd->consultar($sql_ubicacion);
							 while($row06=$bd->obtener_fila($query06,0)){
							echo '<option value="'.$row06[0].'">'.$row06[1].'</option>';
							}
					echo'</select></td>
            </tr>';
        }; mysql_free_result($query);?>
    </table>
