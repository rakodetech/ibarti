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
$vinculo    = "reportes/rp_nov_check_list_printer.php?Nmenu=$Nmenu&mod=$mod";



$vinculo = "inicio.php?area=maestros/Add_$archivo&Nmenu=$Nmenu&mod=$mod&titulo=$titulo&archivo=$archivo";
$novedades       = $_POST['novedades'];
$clasif          = $_POST['clasif'];
$tipo            = $_POST['tipo'];
$check_list      = $_POST['check_list'];

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
?><table width="100%" align="center">  	
   <tr class="fondo00">
			<th width="8%" class="etiqueta">codigo</th>
			<th width="18%" class="etiqueta">Clasificacion</th>
       		<th width="18%" class="etiqueta">Tipo</th>
            <th width="25%" class="etiqueta">Novedad</th>
            <th width="8%" class="etiqueta">Orden</th>
            <th width="8%" class="etiqueta">Status</th>
            <th width="7%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" width="30px" height="30px" border="null"/></a></th> 
	   </tr>
    <?php       
	$valor = 0;
		while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}

	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'"> 
                  <td class="texo">'.$datos[0].'</td> 
                  <td class="texo">'.longitudMin($datos[2]).'</td>
				  <td class="texo">'.longitudMin($datos[3]).'</td>
				  <td class="texo">'.longitudMax($datos[4]).'</td>
				  <td class="texo">'.longitudMin($datos[5]).'</td>
				  <td class="texo">'.$datos[6].'</td>
				   <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td> 
				  
            </tr>'; 
        } 
     mysql_free_result($query);?></table>