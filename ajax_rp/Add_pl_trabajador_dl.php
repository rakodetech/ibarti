<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$rol             = $_POST['rol'];
$region          = $_POST['region'];
$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];
$cargo           = $_POST['cargo'];
$contrato        = $_POST['contrato'];
$cliente         = $_POST['cliente'];
$ubicacion       = $_POST['ubicacion'];


	$where = " WHERE cod_ficha_status = control.ficha_activo
                 AND ficha_dl.cod_ficha = v_ficha.cod_ficha
                 AND ficha_dl.cod_turno_dia = turno_dias.dia
                 AND ficha_dl.cod_cliente = clientes.codigo
                 AND ficha_dl.cod_ubicacion = clientes_ubicacion.codigo ";

	if($rol != "TODOS"){
		$where .= " AND v_ficha.cod_rol = '$rol' ";
	}

	if($region != "TODOS"){
		$where .= " AND v_ficha.cod_region = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND v_ficha.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$where  .= " AND v_ficha.cod_ciudad = '$ciudad' ";
	}

	if($cargo != "TODOS"){
		$where  .= " AND v_ficha.cod_cargo = '$cargo' ";
	}

	if($contrato != "TODOS"){
		$where  .= " AND v_ficha.cod_contracto = '$contrato' ";
	}

	if($cliente != "TODOS"){
		$where  .= " AND ficha_dl.cod_cliente = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where  .= " AND ficha_dl.cod_ubicacion = '$ubicacion' ";
	}

	// QUERY A MOSTRAR //
	    $sql = "SELECT v_ficha.rol, v_ficha.region,
                       v_ficha.estado, v_ficha.ciudad,
                       v_ficha.cod_ficha, v_ficha.cedula,
                       v_ficha.nombres,  v_ficha.cargo,
                       v_ficha.contracto AS contrato, turno_dias.descripcion AS dl,
					   clientes.nombre AS cliente, clientes_ubicacion.descripcion AS ubicacion
                  FROM v_ficha, control, ficha_dl, turno_dias, clientes, clientes_ubicacion
				  $where
			  ORDER BY 6 ASC";
?>
<table width="100%" border="0" align="center">
		<tr class="fondo00">

            <th width="18%" class="etiqueta"><?php echo $leng['rol']?></th>
            <th width="18%" class="etiqueta"><?php echo $leng['cliente']?></th>
            <th width="8%" class="etiqueta"><?php echo $leng['ficha']?></th>
		    <th width="28%" class="etiqueta"><?php echo $leng['trabajador']?></th>
            <th width="18%" class="etiqueta"><?php echo $leng['contrato']?></th>
            <th width="10%" class="etiqueta">DL </th>
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
  				  <td class="texto">'.longitud($datos["cliente"]).'</td>
				  <td class="texto">'.$datos["cod_ficha"].'</td>
			      <td class="texto">'.longitud($datos["nombres"]).'</td>
				  <td class="texto">'.longitud($datos["contrato"]).'</td>
				  <td class="texto">'.longitud($datos["dl"]).'</td>';
        };?>
    </table>
