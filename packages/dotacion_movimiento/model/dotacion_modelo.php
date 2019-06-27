<?php
define("SPECIALCONSTANT", true);
require  "../../../autentificacion/aut_config.inc.php";
require_once "../../../" . Funcion;
require_once  "../../../" . class_bdI;

class dotaciones
{
    private $datos;
    private $bd;


    function __construct()
    {
        $this->datos   = array();

        $this->bd = new Database;
    }


    public function obtener_procesos($tipo)
    {
        $tabla = ($tipo == "almacen") ? 'dotacion_proceso' : 'dotacion_recepcion';

        try {
            $sql = " SELECT
                            dotacion_proceso.codigo,
                            dotacion_proceso.fec_us_mod fecha,
                            CONCAT(men_usuarios.nombre,' ',men_usuarios.apellido) nombre,
                            dotacion_status.descripcion estatus,
                        
                        IF (
                            dotacion_proceso.anulado = 'T',
                            'SI',
                            'NO'
                        ) anulado
                        FROM
                            dotacion_proceso,
                            dotacion_status,
                            men_usuarios
                        WHERE
                            men_usuarios.codigo = dotacion_proceso.cod_us_mod
                        AND dotacion_status.codigo = dotacion_proceso.`status`";
            $result['sql'][] = $sql;
            $query        = $this->bd->consultar($sql);
            while ($datos = $this->bd->obtener_fila($query, 0)) {
                $this->datos[] = $datos;
            }
            return $this->datos;
            //code...
        } catch (Exception $e) {
            $error =  $e->getMessage();
            $result['error'] = true;
            $result['mensaje'][] = $error;
            if ($result['error'] = true) {
                //echo $result['mensaje'];
                $result['confirmacion'] = false;
            }
        }
    }
    public function comprobar_status($cod)
    {
        $this->datos   = array();
        $sql = "SELECT codigo, status sta,anulado FROM dotacion_proceso WHERE codigo='$cod'";

        $query        = $this->bd->consultar($sql);
        while ($datos = $this->bd->obtener_fila($query, 0)) {
            $this->datos[] = $datos;
        }
        return $this->datos;
    }


    public function get_listado_existente($cod)
    {
        $this->datos   = array();
        $sql = "SELECT a.fec_us_mod fecha,
                a.codigo cod_dotacion,
                c.cod_ficha cod_ficha,
                concat(c.nombres,' ',c.apellidos) nombres,
                d.anulado,
                d.codigo cod_proceso,
                CURRENT_DATE() fecha_actual
                FROM prod_dotacion a
                INNER JOIN dotacion_proceso_det b ON a.codigo = b.cod_dotacion
                INNER JOIN dotacion_proceso d ON d.codigo = b.cod_dotacion_proceso
                INNER JOIN ficha c on c.cod_ficha = a.cod_ficha
                WHERE d.codigo = '$cod'";

        $query        = $this->bd->consultar($sql);
        while ($datos = $this->bd->obtener_fila($query, 0)) {
            $this->datos[] = $datos;
        }
        return $this->datos;
    }
    public function get_listado_dotacion($obmitir, $fecha_d, $fecha_h)
    {
        $this->datos   = array();
        $where = "";
        if ($fecha_d != "" && $fecha_h != "") {
            $where .= "AND a.fec_us_ing BETWEEN '$fecha_d' AND '$fecha_h'";
        }
        if (count($obmitir) > 0) {
            foreach ($obmitir as $indice => $value) {
                $where .= "AND a.codigo <> '$value'";
            }
        }

        $sql = "SELECT
        a.fec_us_mod fecha,
        a.codigo cod_dotacion,
        c.cod_ficha,
        concat(c.nombres, ' ', c.apellidos) nombres
        FROM
            prod_dotacion a
        LEFT JOIN dotacion_proceso_det b ON a.codigo = b.cod_dotacion
        INNER JOIN ficha c ON c.cod_ficha = a.cod_ficha
        WHERE
            a.anulado <> 'T'
        AND (
            SELECT
                COUNT(
                    dotacion_proceso.codigo
                )
            FROM
                dotacion_proceso_det,
                dotacion_proceso
            WHERE
                dotacion_proceso.codigo = dotacion_proceso_det.cod_dotacion_proceso
            AND
                dotacion_proceso_det.cod_dotacion = a.codigo
            AND 
                dotacion_proceso.anulado = 'F'
        ) = 0
    

		" . $where . "    GROUP BY a.codigo";

        $query        = $this->bd->consultar($sql);
        while ($datos = $this->bd->obtener_fila($query, 0)) {
            $this->datos[] = $datos;
        }
        return $this->datos;
    }
}
