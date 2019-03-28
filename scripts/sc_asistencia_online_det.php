<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
define("SPECIALCONSTANT",true);
require("../autentificacion/aut_config.inc.php");

require("../".Funcion);
require "../".class_bdI;
// require "../".Leng;
$bd = new DataBase();

$cod_apertura   = $_POST['cod_apertura'];
$co_cont        = $_POST['co_cont'];
$rol            = $_POST['rol'];
$cliente        = $_POST['cliente'];
$ubicacion      = $_POST['ubicacion'];

$archivo        = "asistencia_online";
$Nmenu          = $_POST['Nmenu'];
$mod            = $_POST['mod'];

$vinculo = "inicio.php?area=formularios/add_$archivo&Nmenu=$Nmenu&mod=$mod";

$sql = "SELECT 	asistencia_apertura.fec_diaria 	FROM 	asistencia_apertura
WHERE 	asistencia_apertura.codigo = $cod_apertura ";
$query = $bd->consultar($sql);
$datos=$bd->obtener_name($query);

$fecha = $datos["fec_diaria"];


//	$FROM    = " FROM v_ch_inout ";
 $FROM    = " FROM v_ch_inout LEFT JOIN
                  pl_trabajador ON  pl_trabajador.fecha =  DATE_FORMAT(v_ch_inout.fecha, '%Y-%m-%d')
              AND v_ch_inout.cod_ficha = pl_trabajador.cod_ficha
              AND v_ch_inout.cod_ubicacion = pl_trabajador.cod_ubicacion ";

	// OJO TIENE QUE SER LA FECHA que selecciono
//		$WHERE   = " WHERE  DATE_FORMAT(v_ch_inout.fecha, '%Y-%m-%d') = CURDATE() ";
	$WHERE   = " WHERE  DATE_FORMAT(v_ch_inout.fecha, '%Y-%m-%d') = '$fecha' ";
	if($rol != "TODOS"){
		$WHERE .= " AND  v_ch_inout.cod_rol  = '$rol' ";
	}

	if($cliente != "TODOS"){
		$WHERE .= " AND  v_ch_inout.cod_cliente  = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$WHERE .= " AND  v_ch_inout.cod_ubicacion  = '$ubicacion' ";
	}


$sql = " CREATE TEMPORARY TABLE v_ch_proceso
        SELECT v_ch_inout.*, pl_trabajador.cod_horario
			      $FROM
            $WHERE
			      ORDER BY 3 DESC";
    $query = $bd->consultar($sql);

 $sql = "SELECT v_ch_proceso.*, IFNULL(horarios.cod_concepto, 'indefinido') cod_concepto,
               horarios.inicio_marc_entrada, horarios.fin_marc_entrada,
							 horarios.inicio_marc_salida, horarios.fin_marc_salida,
							 clientes.abrev, clientes.nombre AS cliente,
               CONCAT(ficha.apellidos, ' ',ficha.nombres) ap_nombre
  FROM v_ch_proceso LEFT JOIN horarios ON v_ch_proceso.cod_horario = horarios.codigo
     , clientes, ficha
WHERE v_ch_proceso.cod_cliente = clientes.codigo
AND v_ch_proceso.cod_ficha = ficha.cod_ficha";

  $query = $bd->consultar($sql);

		while ($datos=$bd->obtener_name($query)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}

 $abrev = $datos["cod_concepto"];
 $marcaje = 'invalido';

		if ($abrev != "indefinido"){
 	$marcaje = 'valido';

			$sql = "SELECT conceptos.abrev FROM conceptos WHERE conceptos.codigo = '$abrev' ";
			$query02 = $bd->consultar($sql);
			$datos02=$bd->obtener_name($query02);

			if(check_range($datos["inicio_marc_entrada"], $datos["fin_marc_entrada"], $datos["hora"]) == true){
				$marcaje = "Entrada";
        $marcaje_v = "true";
			}elseif (check_range($datos["inicio_marc_salida"], $datos["fin_marc_salida"], $datos["hora"]) == true){
				$marcaje = "Salidad";
        $marcaje_v = "true";
			}else{
				$marcaje = "indefinido";
        $marcaje_v = "false";
			} ;
		  $abrev = ''.$datos02["abrev"].' - '.$datos["hora"].' - '.$marcaje;
//		  $abrev = ''.$datos02["abrev"].' - '.$datos["inicio_marc_entrada"].' - '.$datos["fin_marc_entrada"];
		 // $abrev = $datos02["abrev"];
// verifico entrada o salidad
//
		}

	$checkX = CheckX($marcaje_v, 'true');

// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
//	   $Borrar = "Borrar01('".$datos[0]."')";

	    echo '<tr class="'.$fondo.'">
							  <td>'.$datos["cod_ficha"].'</td>
			          <td>'.longitud($datos["ap_nombre"]).'</td>
								<td>'.longitud($datos["abrev"]).'</td>
								<td>'.longitud($datos["ubicacion"]).'</td>
								<td>'.$abrev.'</td>
								<td><input type="checkbox" name="ch.asitencia[]"value="'.$datos['cod_ficha'].'" style="width:auto" '.$checkX.'/></td>
            </tr>';
        }	?>
    </table>
