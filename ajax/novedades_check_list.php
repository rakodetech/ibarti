<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 
//require_once('../autentificacion/aut_config.inc.php'); 
//include_once('../funciones/mensaje_error.php');	
$fecha_D   = conversion($_POST['fecha_desde']);
$fecha_H   = conversion($_POST['fecha_hasta']);
	
$Nmenu      = $_POST['Nmenu'];
$mod        = $_POST['mod'];
$archivo    = $_POST['archivo']."&Nmenu=$Nmenu&mod=$mod";
$vinculo    = "inicio.php?area=formularios/Add_$archivo";

$novedad    = $_POST['novedad'];
$clasif     = $_POST['clasif'];
$cliente    = $_POST['cliente'];
$status     = $_POST['status'];

	$where = " WHERE nov_procesos.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"	
				AND nov_procesos.cod_novedad = novedades.codigo 
				AND nov_procesos.cod_cliente = clientes.codigo
				AND novedades.cod_nov_clasif = nov_clasif.codigo
				AND nov_procesos.cod_nov_status = nov_status.codigo
				AND nov_procesos.cod_ficha = ficha.cod_ficha
				AND ficha.cedula = preingreso.cedula";				

	if($novedad != "TODOS"){		
		$where .= " AND novedades.codigo  = '$novedad' ";  
	}		

	if($clasif != "TODOS"){		
		$where .= " AND nov_clasif.codigo = '$clasif' ";  
	}		

	if($cliente != "TODOS"){		
		$where .= " AND clientes.codigo = '$cliente' ";
	}		

	if($status != "TODOS"){		
		$where .= " AND nov_status.codigo = '$status' ";  
	}	

$sql = " SELECT nov_procesos.codigo, nov_procesos.fecha, 
                novedades.descripcion AS novedades,  ficha.cod_ficha, 
				CONCAT(preingreso.nombres, ' ',preingreso.apellidos) AS trabajador, nov_clasif.descripcion AS clasif,
				clientes.nombre AS cliente,  nov_status.descripcion  AS status
           FROM nov_procesos , novedades , clientes , nov_clasif ,
                nov_status , ficha, preingreso
          $where
       ORDER BY nov_procesos.fecha DESC ";
   $query = $bd->consultar($sql);

	  echo '<table width="100%" border="0" class="fondo00">
			<tr>
            <th width="7%" class="etiqueta">Fecha</th>
			<th width="18%" class="etiqueta">Novedad</th>
            <th width="20%" class="etiqueta">Trabajador</th>
			<th width="18%" class="etiqueta">Clasificacion</th>
  			<th width="20%" class="etiqueta">Cliente</th>
            <th width="10%" class="etiqueta">Status</th>
			<td width="7%"><a href="inicio.php?area=formularios/Add_'.$archivo.'&metodo=agregar"><img src="imagenes/nuevo.bmp" 
		alt="Agregar Registro" width="25px" height="25px" title="Agregar Registro" border="null" /></a></td> 
			</tr>';
				 $valor = 0;		
	    while($row02=$bd->obtener_fila($query,0)){
		
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}								
					echo'<tr class="'.$fondo.'">
							<td class="texto">'.$row02["fecha"].'</td>
							<td class="texto">'.longitud($row02["novedades"]).'</td>
							<td class="texto">'.longitud($row02["trabajador"]).'</td>
							<td class="texto">'.longitud($row02["clasif"]).'</td>
							<td class="texto">'.longitud($row02["cliente"]).'</td>
							<td class="texto">'.$row02["status"].'</td>
							<td class="texto"><a href="inicio.php?area=formularios/Add_'.$archivo.'&codigo='.$row02['codigo'].'&metodo=modificar"><img src="imagenes/detalle.bmp" alt="Modificar" title="Modificar Registro" width="20px" height="20px" border="null"/></a></td>
							</td>
						</tr>';
					}	
echo '</table>'; 
mysql_free_result($query);?>