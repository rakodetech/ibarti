<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 
//require_once('../autentificacion/aut_config.inc.php'); 
//include_once('../funciones/mensaje_error.php');	
	
$rol       = $_POST['rol'];
$region    = $_POST['region'];
$estado    = $_POST['estado'];
$contrato  = $_POST['contrato'];
$cargo     = $_POST['cargo'];
$cliente   = $_POST['cliente'];
$ubicacion = $_POST['ubicacion'];
$usuario   = $_POST['usuario'];

	$where = "  WHERE v_ficha.cod_ficha_status = control.ficha_activo 
      			  AND v_ficha.cod_ficha = v_ficha.cod_ficha ";				

	if($rol != "TODOS"){		
		$where .= " AND v_ficha.cod_rol = '$rol' ";  
	}		

	if($region != "TODOS"){		
		$where .= " AND v_ficha.cod_region = '$region' ";
	}		

	if($estado != "TODOS"){		
		$where .= " AND v_ficha.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}	


	if($contrato != "TODOS"){
		$where  .= " AND v_ficha.cod_contracto = '$contrato' ";
	}	
	
	if($cargo != "TODOS"){
		$where  .= " AND v_ficha.cod_cargo = '$cargo' ";
	}	

	if($cliente != "TODOS"){
		$where  .= " AND v_ficha.cod_cliente = '$cliente' ";
	}	

	if($ubicacion != "TODOS"){
		$where  .= " AND v_ficha.cod_ubicacion = '$ubicacion' ";
	}	


	$sql01 = " SELECT clientes.codigo, clientes.nombre
			     FROM control , clientes
			    WHERE control.oesvica = clientes.codigo ";
   $query01      = $bd->consultar($sql01);
	$row01       = $bd->obtener_fila($query01,0);
    $cod_cliente = $row01[0];
    $cliente     = $row01[1];
$sql = " SELECT v_ficha.cod_ficha, v_ficha.cedula, v_ficha.ap_nombre
           FROM v_ficha, control
		 $where         
       ORDER BY 3 ASC ";
   $query = $bd->consultar($sql);
?>
<table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="8%" class="etiqueta">Ficha</th>
            <th width="8%" class="etiqueta">Cedula</th>
		    <th width="30%" class="etiqueta">Trabajador </th>
            <th width="16%" class="etiqueta">Cliente </th>
            <th width="17%" class="etiqueta">Ubicacion </th>
            <th width="3%"  class="etiqueta">L</th>
            <th width="3%"  class="etiqueta">M</th>
            <th width="3%"  class="etiqueta">M</th>
            <th width="3%" class="etiqueta">J</th>
            <th width="3%" class="etiqueta">V</th>
            <th width="3%" class="etiqueta">S</th>
            <th width="3%" class="etiqueta">D</th>
		</tr>
    <?php   
	$valor = 0;
   $query = $bd->consultar($sql);

		while ($datos=$bd->obtener_fila($query,0)){    
		 $valor = 0;
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}			
		    $checkX        = '';
            $ficha         = $datos["cod_ficha"];

			$sql_cliente = "SELECT DISTINCT  ficha_dl.cod_cliente, clientes.nombre AS cliente,
                                   ficha_dl.cod_ubicacion , clientes_ubicacion.descripcion AS ubicacion
                              FROM ficha_dl , clientes, clientes_ubicacion 
                             WHERE ficha_dl.cod_ficha = '$ficha'          
                               AND ficha_dl.cod_cliente = clientes.codigo                      
                               AND ficha_dl.cod_ubicacion = clientes_ubicacion.codigo";	   
	   				$query03 = $bd->consultar($sql_cliente); 			
					$row03=$bd->obtener_fila($query03,0);
                  if($row03[0] == ""){
					$cod_cliente_x = $cod_cliente;
					$cliente_x     = $cliente;
					$cod_ubicacion = "";
					$ubicacion     = "Seleccione...";
					  
				 }else{
					$cod_cliente_x = $row03[0];
					$cliente_x     = $row03[1];
					$cod_ubicacion = $row03[2];
					$ubicacion     = $row03[3];
				 }


	   $aj = "Add_cliente(this.value, '".$ficha."', 'ajax/Add_pl_ubicacion.php', 'ubic_".$ficha."')";
        echo '<tr class="'.$fondo.'"> 
				  <td class="texto">'.$ficha.'</td>
				  <td class="texto">'.$datos["cedula"].'</td>
				  <td class="texto">'.$datos["ap_nombre"].'</td>
				  <td class="texto"><select name="cliente_'.$ficha.'" id="cliente_'.$ficha.'" 
				                            style="width:160px;" onchange="'.$aj.'">	 
						   <option value="'.$cod_cliente_x.'">'.$cliente_x.'</option>';	

	$sql_cliente = "SELECT clientes_ubicacion.cod_cliente, clientes.nombre AS cliente
				      FROM usuario_clientes ,  clientes_ubicacion , clientes
			         WHERE usuario_clientes.cod_usuario = '$usuario'
				       AND usuario_clientes.cod_ubicacion = clientes_ubicacion.codigo  
				       AND clientes_ubicacion.`status` = 'T'
				       AND clientes_ubicacion.cod_cliente = clientes.codigo
				       AND clientes.`status` = 'T'
					   AND clientes.codigo <> '$cod_cliente_x'
			      GROUP BY clientes_ubicacion.cod_cliente
			      ORDER BY 2 ASC";

	   				$query03 = $bd->consultar($sql_cliente); 			
						   while($row03=$bd->obtener_fila($query03,0)){
						   echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
						   }
			echo'</select></td>
				  <td class="texto" id="ubic_'.$ficha.'"><select name="ubicacion_'.$ficha.'" style="width:160px;"> 
							   <option value="'.$cod_ubicacion.'">'.$ubicacion.'</option>';
		$sql_ubicacion = "SELECT clientes_ubicacion.codigo, clientes_ubicacion.descripcion
                            FROM clientes_ubicacion
                           WHERE clientes_ubicacion.cod_cliente = '$cod_cliente' 
						     AND clientes_ubicacion.`status` = 'T'
                        ORDER BY 2 ASC "; 
							$query06 = $bd->consultar($sql_ubicacion); 					
							 while($row06=$bd->obtener_fila($query06,0)){
							echo '<option value="'.$row06[0].'">'.$row06[1].'</option>';
							}	
					echo'</select></td>';
			
			$sql03 = "SELECT turno_dias.dia, turno_dias.descripcion, 
			                 IFNULL(ficha_dl.cod_turno_dia, 'SI') AS vacio
                        FROM turno_dias LEFT JOIN ficha_dl ON ficha_dl.cod_turno_dia = turno_dias.dia 
                         AND ficha_dl.cod_ficha = '$ficha'
                       WHERE turno_dias.tipo = 'SEM'
                    ORDER BY orden	 ";
			$query03  = $bd->consultar($sql03);

			while($row03=$bd->obtener_fila($query03,0)){
				if ($row03[2]=='SI'){			
				$checkX   = '';
				}else{
				$checkX        = 'checked="checked"';
				}
				echo '<td class="texto"><input name="trabajador[]" type="checkbox" 
		                  value="'.$row03[0].'-'.$ficha.'" style="width:auto" '.$checkX.' /></td>';
			}							 
        };mysql_free_result($query);?>
    </table>   
