<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once('../sql/sql_report_t.php');
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
$rotacion  = $_POST['rotacion'];
$trabajador = $_POST['trabajador'];

$usuario   = $_POST['usuario'];

	$where = "  WHERE v_ficha.cod_ficha_status = control.ficha_activo
                  AND v_ficha.cod_cliente = clientes.codigo
                  AND v_ficha.cod_ubicacion = clientes_ubicacion.codigo
                  AND v_ficha.cod_rotacion = rotacion.codigo ";

	if($rol != "TODOS"){
		$where .= " AND v_ficha.cod_rol = '$rol' ";
	}

	if($region != "TODOS"){
		$where .= " AND v_ficha.cod_region = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND v_ficha.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($contrato != "TODOS"){
		$where  .= " AND v_ficha.cod_contracto = '$contrato' ";
	}

	if($cargo != "TODOS"){
		$where  .= " AND v_ficha.cod_cargo = '$cargo' ";
	}

	if($cliente != "TODOS"){
		$where  .= " AND v_ficha.cod_cliente = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where  .= " AND v_ficha.cod_ubicacion = '$ubicacion' ";
	}

	if($rotacion != "TODOS"){
		$where  .= " AND v_ficha.cod_rotacion = '$rotacion' ";
	}


	if($trabajador != "TODOS"){
		$where  .= " AND v_ficha.cod_ficha = '$trabajador' ";
	}

	 $sql = "  SELECT v_ficha.cod_ficha, v_ficha.cedula,
	                  v_ficha.ap_nombre, v_ficha.cod_cliente,
					  clientes.nombre AS cliente,  v_ficha.cod_ubicacion,
					  clientes_ubicacion.descripcion AS ubicacion, v_ficha.cod_rotacion,
					  rotacion.descripcion AS rotacion, v_ficha.n_rotacion
                 FROM v_ficha , control , clientes, clientes_ubicacion, rotacion
  		       $where
       ORDER BY 3 ASC ";
   $query = $bd->consultar($sql);
?>
<table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="8%" class="etiqueta"><?php echo $leng['ficha']?></th>
            <th width="10%" class="etiqueta"><?php echo $leng['ci']?></th>
		    <th width="23%" class="etiqueta"><?php echo $leng['trabajador']?> </th>
            <th width="17%" class="etiqueta"><?php echo $leng['cliente']?> </th>
            <th width="17%" class="etiqueta"><?php echo $leng['ubicacion']?> </th>
            <th width="14%" class="etiqueta"> Rotacion </th>
            <th width="12%" class="etiqueta"> Posicion </th>
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
		$ficha = $datos["cod_ficha"];

	   $aj = "Add_cliente(this.value, '".$ficha."', 'ajax/Add_pl_ubicacion.php', 'ubic_".$ficha."')";
        echo '<tr class="'.$fondo.'">
				  <td class="texto">'.$ficha.' <input type="hidden" name="trabajador[]" value="'.$ficha.'" /></td>
				  <td class="texto">'.$datos["cedula"].'</td>
				  <td class="texto">'.$datos["ap_nombre"].'</td>
				  <td class="texto"><select name="cliente_'.$ficha.'" id="cliente_'.$ficha.'"
				                            style="width:150px;" onchange="'.$aj.'">
						   <option value="'.$datos["cod_cliente"].'">'.$datos["cliente"].'</option>';

	$sql_cliente = "SELECT clientes_ubicacion.cod_cliente, clientes.nombre AS cliente
				      FROM usuario_clientes ,  clientes_ubicacion , clientes
			         WHERE usuario_clientes.cod_usuario = '$usuario'
				       AND usuario_clientes.cod_ubicacion = clientes_ubicacion.codigo
				       AND clientes_ubicacion.`status` = 'T'
				       AND clientes_ubicacion.cod_cliente = clientes.codigo
				       AND clientes.`status` = 'T'
					   AND clientes.codigo <> '".$datos["cod_cliente"]."'
			      GROUP BY clientes_ubicacion.cod_cliente
			      ORDER BY 2 ASC";

	   				$query03 = $bd->consultar($sql_cliente);
						   while($row03=$bd->obtener_fila($query03,0)){
						   echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
						   }
			echo'</select></td>
				  <td class="texto" id="ubic_'.$ficha.'"><select name="ubicacion_'.$ficha.'" style="width:150px;">
							   <option value="'.$datos["cod_ubicacion"].'">'.$datos["ubicacion"].'</option>';
		$sql_ubicacion = "SELECT clientes_ubicacion.codigo, clientes_ubicacion.descripcion
                            FROM clientes_ubicacion
                           WHERE clientes_ubicacion.cod_cliente = '".$datos["cod_cliente"]."'
						     AND clientes_ubicacion.`status` = 'T'
                        ORDER BY 2 ASC ";
							$query06 = $bd->consultar($sql_ubicacion);
							 while($row06=$bd->obtener_fila($query06,0)){
							echo '<option value="'.$row06[0].'">'.$row06[1].'</option>';
							}
							$ajax2 =  "Add_ajax02('$ficha', this.value, 'ajax/Add_rotacion_trab_n.php', 'listar_X_".$ficha."')";
					echo'</select></td>
				  <td class="texto" id="rotacion_'"><select name="rotacion_'.$ficha.'" style="width:120px;"
				      onchange="'.$ajax2.'">
							   <option value="'.$datos["cod_rotacion"].'">'.$datos["rotacion"].'</option>';

							$query06 = $bd->consultar($sql_rotacion);
							 while($row06=$bd->obtener_fila($query06,0)){
							echo '<option value="'.$row06[0].'">'.$row06[1].'</option>';
							}
					$n_rot =  $datos["n_rotacion"]+1;
					echo'</select></td>
				  <td class="texto" id="posicion_'.$ficha.'"><div id="listar_X_'.$ficha.'"><select name="posicion_'.$ficha.'" style="width:60px;">
							   <option value="'.$datos["n_rotacion"].'">'.$n_rot.'</option>';
							$query06 = $bd->consultar("SELECT Count(rotacion_det.codigo)
                                                         FROM rotacion_det
                                                        WHERE rotacion_det.cod_rotacion = ".$datos['cod_rotacion']."");
							 $row06=$bd->obtener_fila($query06,0);
							 $cantidad =$row06[0];
							for ($i = 0; $i < $cantidad; $i++) {
								$x = $i+1;
							echo '<option value="'.$i.'">'.$x.'</option>';
							}
					echo'</select></div></td></tr>';
        };?>
    </table>
