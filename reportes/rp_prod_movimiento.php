<?php
    define("SPECIALCONSTANT", true);
    require "../autentificacion/aut_config.inc.php";
    include "../".Funcion;
    require "../".class_bdI;
    require "../".Leng;
    $bd = new DataBase();
    require_once('../'.ConfigDomPdf);

$codigo = $_POST['codigo'];

    $sql = "SELECT prod_movimiento.cod_producto, productos.descripcion AS producto,
                    prod_movimiento.cod_ficha, v_ficha.cedula,
                    v_ficha.ap_nombre AS trabajador,
                    productos.cod_linea, prod_lineas.descripcion AS linea,
                    productos.cod_linea, prod_sub_lineas.descripcion AS sub_linea,
                    productos.item AS serial,
                    clientes_ubicacion.cod_estado, estados.descripcion AS estado,
                    productos.campo01 AS n_porte, productos.campo02 AS fec_venc_permiso,
                    prod_movimiento.cod_cliente, clientes.nombre AS cliente,
                    clientes.rif,
                    prod_movimiento.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion,
                    prod_movimiento.fecha, prod_movimiento.hora,
                    prod_movimiento.cod_mov_tipo, prod_mov_tipo.descripcion AS mov_tipo,
                    prod_movimiento.observacion,
                    prod_movimiento.campo01, prod_movimiento.campo02,
                    prod_movimiento.campo03, prod_movimiento.campo04,
                    prod_movimiento.`status`
               FROM prod_movimiento, productos, clientes_ubicacion, clientes,
                    estados, prod_mov_tipo, prod_lineas, prod_sub_lineas, v_ficha
              WHERE prod_movimiento.cod_producto = productos.codigo
                AND prod_movimiento.cod_cliente = clientes.codigo
                AND prod_movimiento.cod_ubicacion = clientes_ubicacion.codigo
                AND clientes_ubicacion.cod_estado = estados.codigo
                AND prod_movimiento.cod_mov_tipo = prod_mov_tipo.codigo
                AND productos.cod_linea = prod_lineas.codigo
                AND productos.cod_sub_linea = prod_sub_lineas.codigo
                AND prod_movimiento.cod_ficha = v_ficha.cod_ficha
                AND prod_movimiento.codigo =  '$codigo'";

$query = $bd->consultar($sql);

$dompdf= new DOMPDF();

ob_start();
$titulo= ' PRODUCTO MOVIMIENTO ';
require_once('../'.PlantillaDOM.'/unicas/prod_movimiento_ibarti.php');

    $dompdf->load_html(ob_get_clean(),'UTF-8');
    $dompdf->render();
    $pdf=$dompdf->output();
    $dompdf->stream('prod_dotacion_ibarti.pdf', array('Attachment' => 0));?>
