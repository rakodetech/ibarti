<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 

//require_once('../autentificacion/aut_config.inc.php'); 
//include_once('../funciones/mensaje_error.php');

$Nmenu      = $_POST['Nmenu'];
$mod        = $_POST['mod'];
$titulo = "  NOVEDADES ";
$archivo = "novedades";
$novedades       = $_POST['novedades'];
$clasif          = $_POST['clasif'];
$tipo            = $_POST['tipo'];
$check_list      = $_POST['check_list'];
$reporte= $_POST['reporte'];

	$where = "  WHERE novedades.cod_nov_clasif = nov_clasif.codigo 
                  AND novedades.cod_nov_tipo = nov_tipo.codigo ";				 

	if($novedades != "TODOS"){
		$where  .= " AND novedades.codigo = '$novedades' ";
	}

	if($clasif != "TODOS"){		
		$where .= " AND nov_clasif.codigo = '$clasif' ";  // cambie AND asistencia.co_cont = '$contracto'
	}		

	if($check_list != "TODOS"){
		$where  .= " AND nov_clasif.campo04 = '$check_list' ";
	}

	if($tipo != "TODOS"){
		$where  .= " AND nov_tipo.codigo = '$tipo' ";
	}

	// QUERY A MOSTRAR //
		  	$sql = "SELECT novedades.codigo,   Valores(nov_clasif.campo04) AS check_list, 
                           nov_clasif.descripcion AS clasif,  nov_tipo.descripcion AS tipo, 
  			               novedades.descripcion AS novedades,  novedades.orden,
						   Valores(novedades.`status`) AS `status` 
                      FROM novedades , nov_clasif, nov_tipo                    
                    $where            	
                  ORDER BY 3, novedades.orden ASC ";
   $query = $bd->consultar($sql);

   if($reporte== 'excel'){
    echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

    $query01  = $bd->consultar($sql);
     echo "<table border=1>";

      echo '<thead><th width="8%" class="etiqueta">codigo</th>
      <th width="18%" class="etiqueta">Clasificacion</th>
         <th width="18%" class="etiqueta">Tipo</th>
      <th width="25%" class="etiqueta">Novedad</th>
      <th width="8%" class="etiqueta">Orden</th>
      <th width="8%" class="etiqueta">Status</th></thead><tbody>';

    
    while ($datos=$bd->obtener_fila($query,0)){
	  
        echo '<tr> 
                  <td class="texo">'.$datos[0].'</td> 
                  <td class="texo">'.longitudMin($datos[2]).'</td>
				  <td class="texo">'.longitudMin($datos[3]).'</td>
				  <td class="texo">'.longitudMax($datos[4]).'</td>
				  <td class="texo">'.longitudMin($datos[5]).'</td>
				  <td class="texo">'.$datos[6].'</td>
				  
				  
            </tr>'; 
        }
     echo "</tbody></table>";
    }
  ?>