<?php
define("SPECIALCONSTANT", true);
require("../../../../autentificacion/aut_config.inc.php");
require_once("../../../../" . class_bdI);
$bd = new DataBase();
$result = array();

$data = array();
if(isset($_POST['motivo'])){
	$motivo = $_POST['motivo'];
	if ($motivo == "set_contactos") {
	
		$codigos					= $_POST['cliente'];
		$arreglo_codigos = $_POST['codigos'];
		$arreglo_nombres = $_POST['nombres'];
		$arreglo_cargos = $_POST['cargos'];
		$arreglo_telefonos = $_POST['telefonos'];
		$arreglo_correos = $_POST['correos'];
		$arreglo_observaciones = $_POST['observacion'];
	
		$sql = 'DELETE FROM clientes_contactos where clientes_contactos.cod_cliente = "' . $codigos . '"';
		$query = $bd->consultar($sql);
		$sql = '';
		foreach ($arreglo_codigos as $clave => $valorX) {
			if ($clave == 0) {
				$sql .= "INSERT INTO clientes_contactos(documento,cod_cliente,nombres,cargo,telefono,correo,observacion)
							VALUES ('" . $valorX . "','" . $codigos . "','" . $arreglo_nombres[$clave] . "','" . $arreglo_cargos[$clave] . "','" . $arreglo_telefonos[$clave] . "','" . $arreglo_correos[$clave] . "','" . $arreglo_observaciones[$clave] . "')";
			} else {
				$sql .= ",('" . $valorX . "','" . $codigos . "','" . $arreglo_nombres[$clave] . "','" . $arreglo_cargos[$clave] . "','" . $arreglo_telefonos[$clave] . "','" . $arreglo_correos[$clave] . "','" . $arreglo_observaciones[$clave] . "')";
			}
		}
		try {
			$query = $bd->consultar($sql);
			$result['sql'] = $sql;
		} catch (Exception $e) {
			$error =  $e->getMessage();
			$result['error'] = true;
			$result['mensaje'] = $error;
		}
	
		print_r(json_encode($result));
		return json_encode($result);
	} else {
		
		if ($motivo == "get_contactos") {
			$codigos					= $_POST['cliente'];
			$sql = 'SELECT 
			documento as doc,
			nombres as nombres,
			cargo as cargo,
			telefono as tel,
			correo as correo,
			observacion as observacion
			 FROM clientes_contactos WHERE clientes_contactos.cod_cliente = "' . $codigos . '"';
			$query = $bd->consultar($sql);
			while ($datos = $bd->obtener_fila($query)) {
				$data[] = $datos;
			}
			print_r(json_encode($data));
			return json_encode($data);
		} 
	}
	
}else {
	
	foreach ($_POST as $nombre_campo => $valor) {
		$variables = "\$" . $nombre_campo . "='" . $valor . "';";
		eval($variables);
	}

	$codigo  = htmlentities($codigo);

	if (isset($_POST['proced'])) {

		try {

			$sql    = "$SELECT $proced('$metodo', '$codigo', '$cl_tipo', '$vendedor',
																 '$region', '$abrev', '$rif', '$nit',
									 '$nombre', '$telefono', '$fax', '$direccion',
									 '$dir_entrega', '$email', '$website',
									 '$observ',
									 '$juridico', '$contrib', '$lunes', '$martes',
									 '$miercoles', '$jueves', '$viernes', '$sabado',
									 '$domingo', '$limite_cred', '$plazo_pago', '$desc_global',
									 '$desc_p_pago',
									 '$campo01', '$campo02', '$campo03', '$campo04', '$usuario',  '$activo')";
			$query = $bd->consultar($sql);

			$result['sql'] = $sql;
		} catch (Exception $e) {
			$error =  $e->getMessage();
			$result['error'] = true;
			$result['mensaje'] = $error;
			$bd->log_error("Aplicacion", "sc_horario.php",  "$usuario", "$error", "$sql");
		}
	}
	print_r(json_encode($result));
	return json_encode($result);
}
