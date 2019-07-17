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


    public function obtener_procesos($tipo, $vista, $fecha_d, $fecha_h, $cod, $status)
    {
        $where = "";
        $tabla = ($tipo == "almacen") ? 'dotacion_proceso' : 'dotacion_recepcion';

        if ($vista == "clo" || $vista == "cla") {
            $where .= "AND " . $tabla . ".anulado <> 'T' AND dotacion_status.codigo <> '01'";
        }
        if ($fecha_d != "" && $fecha_h != "") {
            $where .= "AND " . $tabla . ".fec_us_ing BETWEEN '$fecha_d' AND '$fecha_h'";
        }

        if ($cod != "") {
            $where .= "AND " . $tabla . ".codigo = '$cod'";
        }
        if ($status != "") {
            $where .= "AND dotacion_status.codigo = '$status'";
        }
        try {
            $sql = " SELECT
                            " . $tabla . ".codigo,
                            " . $tabla . ".fec_us_mod fecha,
                            " . $tabla . ".observacion descripcion,
                            CONCAT(men_usuarios.nombre,' ',men_usuarios.apellido) nombre,
                            dotacion_status.descripcion estatus,
                        
                        IF (
                            " . $tabla . ".anulado = 'T',
                            'SI',
                            'NO'
                        ) anulado
                        
                        FROM
                            " . $tabla . ",
                            dotacion_status,
                            men_usuarios
                        WHERE
                            men_usuarios.codigo = " . $tabla . ".cod_us_mod
                        
                        AND dotacion_status.codigo = " . $tabla . ".`status` " . $where;
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
    public function comprobar_status($cod, $vista)
    {
        $this->datos   = array();
        if ($vista == "vista_dotacion" || $vista == "clo") {
            $tabla = "dotacion_proceso";
        }
        if ($vista == "vista_recepcion" || $vista == "cla") {
            $tabla = "dotacion_recepcion";
        }
        //$tabla = ($vista=="vista_dotacion")?'dotacion_proceso':($vista=="vista_recepcion")?'dotacion_recepcion':'';
        $sql = "SELECT codigo, status sta,anulado FROM " . $tabla . " WHERE codigo='$cod'";
        $query        = $this->bd->consultar($sql);
        while ($datos = $this->bd->obtener_fila($query, 0)) {
            $this->datos[] = $datos;
        }
        return $this->datos;
    }

    public function get_listado_existente($cod, $vista)
    {
        $this->datos   = array();
        $sql = "";
        switch ($vista) {
            case 'vista_dotacion';
                $sql = "SELECT 
                 a.fec_us_mod fecha,
                a.codigo cod_dotacion,
                c.cod_ficha cod_ficha,
                concat(c.nombres,' ',c.apellidos) nombres,
                d.anulado,
                b.status estado_detalle,
                IF(a.anulado='T','SI','NO') dotacion_anulado,
                CURRENT_DATE() fecha_actual,
                d.observacion obs
                FROM prod_dotacion a
                INNER JOIN dotacion_proceso_det b ON a.codigo = b.cod_dotacion
                INNER JOIN dotacion_proceso d ON d.codigo = b.cod_dotacion_proceso
                INNER JOIN ficha c on c.cod_ficha = a.cod_ficha
                WHERE d.codigo = '$cod'";
                break;
            case 'clo':
                $sql = "SELECT 
                a.fec_us_mod fecha,
                a.codigo cod_dotacion,
                c.cod_ficha cod_ficha,
                concat(c.nombres,' ',c.apellidos) nombres,
                d.anulado,
                b.status estado_detalle,
                IF(a.anulado='T','SI','NO') dotacion_anulado,
                CURRENT_DATE() fecha_actual,
                d.observacion obs,
                    (
                    SELECT
                        COUNT(e.codigo)
                    FROM
                        dotacion_recepcion_det e,
                        dotacion_recepcion f
                    WHERE
                        e.cod_dotacion_recepcion = f.codigo
                    AND e.cod_dotacion = a.codigo
                    AND e.cod_dotacion_proceso = d.codigo
                    AND f.anulado = 'F'
                ) existe
   
                FROM prod_dotacion a
                INNER JOIN dotacion_proceso_det b ON a.codigo = b.cod_dotacion
                INNER JOIN dotacion_proceso d ON d.codigo = b.cod_dotacion_proceso
                INNER JOIN ficha c on c.cod_ficha = a.cod_ficha
                WHERE d.codigo = '$cod'";
                break;
            case 'cla':
                $sql = "SELECT 
                a.fec_us_mod fecha,
                a.codigo cod_dotacion,
                c.cod_ficha cod_ficha,
                concat(c.nombres,' ',c.apellidos) nombres,
                d.anulado,
                b.status estado_detalle,
                IF(a.anulado='T','SI','NO') dotacion_anulado,
                CURRENT_DATE() fecha_actual,
                d.observacion obs
                FROM prod_dotacion a
                INNER JOIN dotacion_recepcion_det b ON a.codigo = b.cod_dotacion
                INNER JOIN dotacion_recepcion d ON d.codigo = b.cod_dotacion_recepcion
                INNER JOIN ficha c on c.cod_ficha = a.cod_ficha
                WHERE d.codigo = '$cod'";
                break;
            case 'vista_recepcion':
                $sql = "SELECT
                prod_dotacion.fec_us_mod,
                prod_dotacion.codigo cod_dotacion,
                ficha.cod_ficha cod_ficha,
                concat(ficha.nombres, ' ', ficha.apellidos) nombres,
                dotacion_recepcion.anulado,
                dotacion_recepcion_det.status estado_detalle,
                IF (prod_dotacion.anulado = 'T', 'SI', 'NO') dotacion_anulado,
                CURRENT_DATE () fecha_actual,
                dotacion_recepcion.observacion obs
                FROM
                    ficha,
                    prod_dotacion,
                    dotacion_recepcion_det,
                    dotacion_recepcion
                WHERE
                
                    dotacion_recepcion.codigo  =dotacion_recepcion_det.cod_dotacion_recepcion
                AND prod_dotacion.codigo = dotacion_recepcion_det.cod_dotacion
                AND ficha.cod_ficha = prod_dotacion.cod_ficha
                AND dotacion_recepcion.codigo = '$cod'            
                ";
                break;
        }



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

    public function get_listado_recepcion($obmitir, $fecha_d, $fecha_h)
    {
        $this->datos   = array();
        $where = "";
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
        ficha.cod_ficha,
        concat(ficha.nombres, ' ', ficha.apellidos) nombres
    FROM
        prod_dotacion a,
        ficha,
        dotacion_proceso_det,
        dotacion_proceso b
    WHERE
        b.codigo = dotacion_proceso_det.cod_dotacion_proceso
    AND a.codigo = dotacion_proceso_det.cod_dotacion
    AND a.cod_ficha = ficha.cod_ficha
    AND dotacion_proceso_det.`status` = '05'
    AND a.codigo NOT IN (
        SELECT
            dotacion_recepcion_det.cod_dotacion
        FROM
            dotacion_recepcion,
            dotacion_recepcion_det
        WHERE
            dotacion_recepcion.codigo = dotacion_recepcion_det.cod_dotacion_recepcion
        
        AND
            dotacion_recepcion_det.cod_dotacion = a.codigo
        AND
            dotacion_recepcion.anulado = 'F'
    )

        " . $where . "
    GROUP BY a.codigo";

        $query        = $this->bd->consultar($sql);
        while ($datos = $this->bd->obtener_fila($query, 0)) {
            $this->datos[] = $datos;
        }
        return $this->datos;
    }


    ///////////////////////////////////////////////////////77
    public function llenar_dotaciones_procesadas($fecha_desde, $fecha_hasta)
    {
        $this->datos   = array();
        $where1 = "";
        $where2 = "";
        if ($fecha_desde != "" && $fecha_hasta != "") {
            $where1 = "WHERE a.fec_us_ing BETWEEN '$fecha_desde' AND '$fecha_hasta' ";
            $where2 = "WHERE e.fec_us_ing BETWEEN '$fecha_desde' AND '$fecha_hasta' ";
        }
        //$tabla = ($vista=="vista_dotacion")?'dotacion_proceso':($vista=="vista_recepcion")?'dotacion_recepcion':'';
        $sql = "
                SELECT
            b.cod_dotacion cod_dotacion,
            '01' cod_status,
            a.fec_us_ing fecha,
            a.cod_us_ing cod_us_ing,
            d.cod_ficha
        FROM
            dotacion_proceso a
        INNER JOIN dotacion_proceso_det b ON b.cod_dotacion_proceso = a.codigo
        AND a.anulado = 'F' 
        INNER JOIN prod_dotacion d ON b.cod_dotacion = d.codigo 
        " . $where1 . "
        

        UNION
        
        SELECT
        IFNULL(c.cod_dotacion,b.cod_dotacion) cod_dotacion,
        IFNULL(c.cod_status,b.`status`) cod_status,
        IFNULL(c.fecha,b.fec_us_mod) fecha,
        IFNULL(c.cod_us_ing,b.cod_us_mod) cod_us_ing,
        d.cod_ficha
    FROM
        dotacion_proceso a
    INNER JOIN dotacion_proceso_det b ON b.cod_dotacion_proceso = a.codigo
    AND a.anulado = 'F' 
    LEFT JOIN dotacion_proceso_status c ON c.cod_dotacion = b.cod_dotacion
    AND c.cod_proceso = a.codigo
    INNER JOIN prod_dotacion d ON b.cod_dotacion = d.codigo 
    " . $where1 . "
    UNION 
    
    SELECT
        IFNULL(c.cod_dotacion,b.cod_dotacion) cod_dotacion,
        IFNULL(c.cod_status,b.`status`) cod_status,
        IFNULL(c.fecha,b.fec_us_mod) fecha,
        IFNULL(c.cod_us_ing,b.cod_us_mod) cod_us_ing,
    d.cod_ficha
    FROM
        dotacion_recepcion a
    INNER JOIN dotacion_recepcion_det b ON b.cod_dotacion_recepcion = a.codigo
    AND a.anulado = 'F' 
    LEFT JOIN dotacion_recepcion_status c ON c.cod_dotacion = b.cod_dotacion
    AND c.cod_recepcion = a.codigo
		INNER JOIN dotacion_proceso e ON e.codigo = c.cod_dotacion OR b.cod_dotacion_proceso = e.codigo
    INNER JOIN prod_dotacion d ON b.cod_dotacion = d.codigo
		 " . $where2;
        $query        = $this->bd->consultar($sql);
        while ($datos = $this->bd->obtener_fila($query, 0)) {
            $this->datos[] = $datos;
        }

        return $this->datos;
    }

    public function llenar_status_proceso($tipo)
    {
        $this->datos   = array();
        $tipo = isset($tipo) ? $tipo : 'O';
        //$tabla = ($vista=="vista_dotacion")?'dotacion_proceso':($vista=="vista_recepcion")?'dotacion_recepcion':'';
        $sql = "SELECT codigo,abr,descripcion  from dotacion_status WHERE tipo = '$tipo'  ORDER BY codigo ASC";
        $query        = $this->bd->consultar($sql);
        while ($datos = $this->bd->obtener_fila($query, 0)) {
            $this->datos[] = $datos;
        }
        return $this->datos;
    }
}
