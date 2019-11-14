<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 
//require_once('../autentificacion/aut_config.inc.php'); 
//include_once('../funciones/mensaje_error.php');
//			
$rol       = $_POST['rol'];
$region    = $_POST['region'];
$estado    = $_POST['estado'];
$contrato  = $_POST['contrato'];
$cargo     = $_POST['cargo'];
$cliente   = $_POST['cliente'];

$fecha_D   = conversion($_POST['fecha_desde']);
$fecha_H   = conversion($_POST['fecha_hasta']);

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

	if($cargo != "TODOS"){
		$where  .= " AND v_ficha.cod_cargo = '$cargo' ";
	}	

	if($contrato != "TODOS"){
		$where  .= " AND v_ficha.cod_contracto = '$contrato' ";
	}	

	if($cliente != "TODOS"){
		$where  .= " AND v_ficha.cod_cliente = '$cliente' ";
	}	

$sql = " SELECT v_ficha.cod_ficha, v_ficha.cedula, v_ficha.nombres, v_ficha.cod_cliente,
                v_ficha.cliente, v_ficha.cod_ubicacion, v_ficha.ubicacion
           FROM v_ficha, control
		 $where         
       ORDER BY 3 ASC ";

   $query = $bd->consultar($sql);
?>
<table width="100%" border="0" align="center">
		<tr class="fondo00">
  			<th width="5%" class="etiqueta">Check</th>
            <th width="10%" class="etiqueta">Ficha</th>
            <th width="15%" class="etiqueta">Cedula</th>
		    <th width="34%" class="etiqueta">Trabajador</th>
            <th width="18%" class="etiqueta">Cliente</th>
            <th width="18%" class="etiqueta">Ubicaci&oacute;n</th> 
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
		
	// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
	   $aj = "Add_ajax01('".$datos['cod_ficha']."', 'ajax/add_ubicacion.php', 'ajax/add_ubicacion.php')";
        echo '<tr class="'.$fondo.'"> 
			      <td class="texto"><input name="trabajador[]" type="checkbox" 
				                           value="'.$datos["cod_ficha"].'" style="width:auto" /></td>
				  <td class="texto">'.$datos["cod_ficha"].'</td>
				  <td class="texto">'.$datos["cedula"].'</td>
				  <td class="texto">'.$datos["nombres"].'</td>
				  <td class="texto"><select name="cliente" id="cliente" style="width:160px;" onchange="'.$aj.'">	 
						   <option value="'.$datos["cod_cliente"].'">'.$datos["cliente"].'</option>';	
			$sql_cliente = "SELECT clientes.codigo, clientes.nombre FROM clientes
             		         WHERE clientes.`status` = 'T' 
                    		   AND clientes.codigo <> ".$datos["cod_cliente"]."
          				  ORDER BY 2 ASC";	   
	   				$query03 = $bd->consultar($sql_cliente); 			
						   while($row03=$bd->obtener_fila($query03,0)){
						   echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
						   }
			echo'</select></td>
				  <td class="texto"><select id="ubicacion'.$i.'" style="width:150px;" onchange="spryValidarSelect(this.id)"> 
							   <option value="'.$datos["cod_ubicacion"].'">'.$datos["ubicacion"].'</option>';
		$sql_ubicacion = "SELECT usuario_clientes.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion
                            FROM usuario_clientes , clientes_ubicacion
                           WHERE usuario_clientes.cod_usuario = '$usuario' 
                             AND usuario_clientes.cod_ubicacion = clientes_ubicacion.codigo  
                             AND clientes_ubicacion.cod_cliente = '".$datos["cod_cliente"]."'
                             AND clientes_ubicacion.`status` = 'T'
                        ORDER BY 2 ASC "; 
							$query06 = $bd->consultar($sql_ubicacion); 					
							 while($row06=$bd->obtener_fila($query06,0)){
							echo '<option value="'.$row06[0].'">'.$row06[1].'</option>';
							}	
					echo'</select></td>
            </tr>'; 
        };mysql_free_result($query);?>
    </table>   
