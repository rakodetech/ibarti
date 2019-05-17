<?php
define("SPECIALCONSTANT", true);
require  "../../../autentificacion/aut_config.inc.php";
require_once "../../../".Funcion;
require_once  "../../../".class_bdI;

class novedades_promedio
{
	private $datos;
	private $bd;
	

	function __construct()
	{
		$this->datos   = array();
		
		$this->bd = new Database;
	}

    public function obtener_dias_perfil($fecha_desde,$fecha_hasta){
        $where="";
        if($fecha_desde=="" || $fecha_hasta==""){
            $select = "DATE_SUB(CURDATE(),INTERVAL 1 MONTH) desde, CURDATE() hasta";
            $where.= "and nov_procesos.fec_us_mod >= DATE_SUB(CURDATE(),INTERVAL 0 MONTH)";
        }else{
            $select =  $select = "'".$fecha_desde."' desde, '".$fecha_hasta."' hasta";
            $where.= "and nov_procesos.fec_us_mod BETWEEN '".$fecha_desde."' and '".$fecha_hasta."'";
        }

        $sql = 
        "SELECT ".$select.",nov_procesos.observacion problematica,  nov_procesos.codigo codigo_proceso ,nov_procesos.fec_us_ing, nov_procesos.fec_us_mod,novedades.codigo cod_nov ,novedades.descripcion novedad,nov_clasif.codigo cod_clasif, nov_clasif.descripcion descripcion_clasif,men_perfiles.codigo codigo_perfil,  men_perfiles.descripcion perfil, DATEDIFF(nov_procesos.fec_us_mod,nov_procesos.fec_us_ing) dias_respuesta, nov_status.descripcion, novedades.dias_vencimiento
        from nov_procesos,novedades,nov_clasif,nov_status,nov_perfiles,men_perfiles
        where nov_procesos.cod_novedad = novedades.codigo
        
        and novedades.cod_nov_clasif = nov_perfiles.cod_nov_clasif
        and nov_perfiles.cod_nov_clasif = nov_clasif.codigo
        and nov_perfiles.respuesta = 'T'
        and nov_perfiles.cod_perfil = men_perfiles.codigo
        and men_perfiles.`status` ='T'
        and nov_clasif.campo04 = 'F'
        and novedades.`status` = 'T'
        and nov_status.control_notificaciones_res = 'T'
        
        and nov_procesos.cod_nov_status  = nov_status.codigo
        ".$where."
        ORDER BY nov_procesos.codigo ASC";

        $query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
    }


}





?>
