<script language="javascript">
$("#cl_contratacion_det_form").on('submit', function(evt){
	 evt.preventDefault();
	 save_contratacion_det("", "agregar");
});
	</script>
<?php
include_once('../../../funciones/funciones.php');
require("../../../autentificacion/aut_config.inc.php");
require "../../../".class_bd;
require "../../../".Leng;

$codigo     = $_POST['contratacion'];
$cliente    = $_POST['cliente'];

$sql_ubic   = " SELECT clientes_ubicacion.codigo, clientes_ubicacion.descripcion
                  FROM clientes_ubicacion
                 WHERE clientes_ubicacion.cod_cliente = '$cliente'
                   AND clientes_ubicacion.`status` = 'T'
				      ORDER BY 2 ASC ";

$sql_turno  = " SELECT turno.codigo, turno.descripcion
                  FROM turno WHERE turno.`status` = 'T'
				         ORDER BY 2 ASC ";

$sql_cargo  = " SELECT cargos.codigo, cargos.descripcion
                  FROM cargos WHERE cargos.`status` = 'T'
       				   ORDER BY 2 ASC ";

$sql_det = " SELECT a.codigo, a.cod_contracion,
                    a.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion,
                    a.cod_ub_puesto, clientes_ub_puesto.nombre AS puesto,
                    a.cod_turno, turno.descripcion turno,
                    a.cod_cargo, cargos.descripcion cargo,
                    a.cantidad, a.cod_us_ing,
                    a.fec_us_ing, a.cod_us_mod,
                    a.fec_us_mod
               FROM clientes_contratacion_det a , clientes_ubicacion ,
                    clientes_ub_puesto, turno, cargos
              WHERE a.cod_contracion = '$codigo'
                AND a.cod_ubicacion = clientes_ubicacion.codigo
                AND a.cod_ub_puesto = clientes_ub_puesto.codigo
                AND a.cod_turno = turno.codigo
                AND a.cod_cargo = cargos.codigo ";
?>
	<form id="cl_contratacion_det_form" name="cl_contratacion_det_form" method="post">
		 <table width="100%" border="0" align="center">
       <tr>
            </br>
            <td colspan="6"></hr></td>
            </br>
       </tr>
      	<tr>
						<th width="20%"><?php echo $leng["ubicacion"];?></th>
						<th width="20%">Puesto Trabajo</th>
				    <th width="20%">Turno:</th>
            <th width="20%">Cargo:</th>
            <th width="12%">Cantidad:</th>
				    <th width="8%"><img src="imagenes/loading2.gif" width="30px" height="30px"/></th>
				</tr>
				<tr>
					<td><select id="cont_ubicacion" required style="width:160px;" onchange="Cargar_puesto(this.value, 'SelecPuestoX', 'cont_puesto', '160px', '')">
					    <option  value="">Seleccione...</option>
  					<?php
  					$query03 = $bd->consultar($sql_ubic);
    					while($row03=$bd->obtener_fila($query03,0)){
                echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
              }
  					?>
					</select></td>
					<td id="SelecPuestoX"><select id="cont_puesto" style="width:160px;">
					                      <option  value="">Seleccione...</option>
										            </select></td>
          <td><select id="cont_turno" required style="width:160px;">
          <option  value="">Seleccione...</option>
          <?php
          $query03 = $bd->consultar($sql_turno);
          while($row03=$bd->obtener_fila($query03,0)){
            echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
          }
          ?>
          </select></td>
          <td><select id="cont_cargo" required style="width:160px;">
          <option  value="">Seleccione...</option>
          <?php
          $query03 = $bd->consultar($sql_cargo);
          while($row03=$bd->obtener_fila($query03,0)){
            echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
          }?>
          </select></td>
          <td><input type="number" id="cont_cantidad" required  style="width:80px;" min="1"></td>

					  <td align="center"><span class="art-button-wrapper">
		                    <span class="art-button-l"> </span>
		                    <span class="art-button-r"> </span>
		                 <input type="submit"  id="Ingresar_det" value="Ingresar" class="readon art-button" />
		                </span></td>
				</tr>
        <?php
        $i     = 0;
        $query = $bd->consultar($sql_det);
          while ($datos=$bd->obtener_fila($query,0)){
            	$i++;
             $cod_det     = $datos['codigo'];
					 $sql_ubic   = " SELECT a.codigo, a.descripcion
						                   FROM clientes_ubicacion a
						                  WHERE a.cod_cliente = '$cliente'
						                    AND a.`status` = 'T'
																AND a.codigo <> '".$datos['cod_ubicacion']."'
						 				      ORDER BY 2 ASC ";

					$sql_puesto = " SELECT a.codigo, a.nombre
					                  FROM clientes_ub_puesto a
					                 WHERE a.cod_cl_ubicacion = '".$datos['cod_ubicacion']."'
													 AND a.codigo <> '".$datos['cod_ub_puesto']."'
					              ORDER BY 2 ASC";

         $sql_turno = " SELECT a.codigo, a.descripcion
                         FROM turno a
                        WHERE a.`status` = 'T'
                          AND a.codigo <> '".$datos['cod_turno']."'
                        ORDER BY 2 ASC";

					$sql_cargo = " SELECT a.codigo, a.descripcion
                          FROM cargos a
                         WHERE a.`status` = 'T'
                           AND a.codigo <> '".$datos['cod_cargo']."'
                         ORDER BY 2 ASC";

      echo '<tr>
    					<td><select id="cont_ubicacion'.$cod_det.'"  style="width:160px;" onchange="Cargar_puesto(this.value, \'SelecPuestoX\', \'cont_puesto'.$cod_det.'\', \'160px\', \'\')">
							    <option  value="">'.$datos["ubicacion"].'</option>';
		  						$query03 = $bd->consultar($sql_ubic);
		    					while($row03=$bd->obtener_fila($query03,0)){
		                echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
		              }
		  				echo '
							</select></td>

							<td id="SelecPuestoX'.$cod_det.'"><select id="cont_puesto'.$cod_det.'" style="width:160px;">
							                      <option  value="'.$datos["cod_ub_puesto"].'">'.$datos["puesto"].'</option>';
										$query03 = $bd->consultar($sql_puesto);
											while($row03=$bd->obtener_fila($query03,0)){
												echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
											}
										echo '</select></td>
							<td><select id="cont_turno'.$cod_det.'" style="width:160px;">
							     	<option  value="'.$datos["cod_turno"].'">'.$datos["turno"].'</option>';
										$query03 = $bd->consultar($sql_turno);
											while($row03=$bd->obtener_fila($query03,0)){
												echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
											}
										echo '</select></td>
							<td><select id="cont_cargo'.$cod_det.'" style="width:160px;">
							     	<option  value="'.$datos["cod_cargo"].'">'.$datos["cargo"].'</option>';
										$query03 = $bd->consultar($sql_cargo);
											while($row03=$bd->obtener_fila($query03,0)){
												echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
											}
										echo '</select></td>
								<td><input type="number" id="cont_cantidad'.$cod_det.'" style="width:80px;" value="'.$datos["cantidad"].'" min="1"></td>
    		        <td align="center"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Actualizar Registro" border="null" width="20px" height="20px" class="imgLink" onclick="save_contratacion_det(\''.$cod_det.'\',\'modificar\')" />&nbsp;<img src="imagenes/borrar.bmp" alt="Borrar" title="Borrar Registro" border="null" class="imgLink" width="20px" height="20px" onclick="save_contratacion_det(\''.$cod_det.'\',\'borrar\')"/></td>
                </td>

    				</tr>';
          }
         ?>
		</table>
  </form>
