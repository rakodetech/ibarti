<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
// require_once('../sql/sql_report_t.php');
require_once("../".class_bd);
$bd = new DataBase(); 
//require_once('../autentificacion/aut_config.inc.php'); 
//include_once('../funciones/mensaje_error.php');	
	
$fecha      = $_POST['fecha'];
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];
$trabajador = $_POST['trabajador'];
$usuario    = $_POST['usuario'];

	$sql = " SELECT preingreso.cedula,
                    CONCAT(preingreso.apellidos,' ', preingreso.nombres) AS ap_nomb,
	                pl_trab_mensual.cod_cliente, clientes.abrev,
					clientes.nombre AS cliente, pl_trab_mensual.cod_ubicacion,
					clientes_ubicacion.descripcion AS ubicacion,
					pl_trab_mensual.cod_horario, horarios.nombre AS horario,
					pl_trab_mensual.nivel
               FROM pl_trab_mensual , clientes, clientes_ubicacion, horarios, 
			        ficha, preingreso
			  WHERE pl_trab_mensual.fecha =  \"$fecha\"
				AND pl_trab_mensual.cod_ficha = '$trabajador'
				AND pl_trab_mensual.cod_cliente = clientes.codigo
				AND pl_trab_mensual.cod_ubicacion = clientes_ubicacion.codigo
				AND pl_trab_mensual.cod_horario = horarios.codigo 
				AND ficha.cod_ficha = pl_trab_mensual.cod_ficha
                AND ficha.cedula = preingreso.cedula  ";
   $query = $bd->consultar($sql);
	$datos =$bd->obtener_fila($query,0);   
   
  	$sql_cliente = "SELECT clientes_ubicacion.cod_cliente, clientes.nombre AS cliente
				      FROM usuario_clientes ,  clientes_ubicacion , clientes
			         WHERE usuario_clientes.cod_usuario = '$usuario'
				       AND usuario_clientes.cod_ubicacion = clientes_ubicacion.codigo  
				       AND clientes_ubicacion.`status` = 'T'
				       AND clientes_ubicacion.cod_cliente = clientes.codigo
				       AND clientes.`status` = 'T'
					   AND clientes.codigo <> '$cliente'
			      GROUP BY clientes_ubicacion.cod_cliente
			      ORDER BY 2 ASC";

	$sql_ubicacion = "SELECT clientes_ubicacion.codigo, clientes_ubicacion.descripcion
		                FROM clientes_ubicacion
	                   WHERE clientes_ubicacion.cod_cliente = '$cliente'
		                 AND clientes_ubicacion.`status` = 'T'
                  	ORDER BY 2 ASC "; 

$sql_horario       = " SELECT horarios.codigo, horarios.nombre
                         FROM horarios
                        WHERE horarios.`status` = 'T'	
						AND horarios.codigo <> ".$datos['cod_horario']." 
				        ORDER BY 2 ASC";	
	   $nivel =  $datos['nivel'];
   	   $aj_cl = "Add_cliente(this.value, '".$trabajador."', 'ajax/Add_pl_ubicacion.php', 'ubic_x')";
	   $actualizar = "ActualizarTrab('".$fecha."', '".$trabajador."', '".$nivel."')";
	   
?><div align="center" class="etiqueta_title">Modificar Planificacion Trabajador</div> 
<table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th class="etiqueta"v colspan="4"><?php echo "Fecha: $fecha,  Trabajador: ".$datos['ap_nomb'].", Horario: ".$datos['horario']."";?></th>
		</tr>        
		<tr class="fondo01">
       

            <th width="20%" class="etiqueta">Cliente:</th>
            <th width="30%" class="etiqueta"><select name="cliente" id="cliente" style="width:150px;" 
                                                     onchange="<?php echo $aj;?>">	 
						   <option value="<?php echo $datos["cod_cliente"];?>"><?php echo $datos["cliente"];?></option>	
					<?php 						   
	   				$query03 = $bd->consultar($sql_cliente); 			
						   while($row03=$bd->obtener_fila($query03,0)){
						   echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
						   }
					?>	   
			</select></th>
		    <th width="20%" class="etiqueta">Ubicacion:</th>
            <th width="30%" class="etiqueta" id="ubic_x"><select name="ubicacion" id="ubicacion" style="width:150px;"> 
							   <option value="<?php echo $datos["cod_ubicacion"];?>"><?php echo $datos["ubicacion"];?></option>
                  <?php 
							$query06 = $bd->consultar($sql_ubicacion); 					
							 while($row06=$bd->obtener_fila($query06,0)){
							echo '<option value="'.$row06[0].'">'.$row06[1].'</option>';
							}
				?>
				</select> </th>
		</tr>        
		<tr class="fondo00">
            <th class="etiqueta">Horario:</th>
            <th class="etiqueta"><select name="horario" id="horario" style="width:150px;"> 
							   <option value="<?php echo $datos["cod_horario"];?>"><?php echo $datos["horario"];?></option>
                  <?php 
							$query06 = $bd->consultar($sql_horario); 					
							 while($row06=$bd->obtener_fila($query06,0)){
							echo '<option value="'.$row06[0].'">'.$row06[1].'</option>';
							}
				?>
				</select></th>
		    <th class="etiqueta">&nbsp;</th>
            <th class="etiqueta">
             <span class="art-button-wrapper">
            <span class="art-button-l"> </span>
            <span class="art-button-r"> </span>
        <input type="button" id="Guardar" value="Actualizar" onClick="<?php echo $actualizar;?>" class="readon art-button">
        </span>&nbsp; 
              </th>
		</tr>
    </table>  