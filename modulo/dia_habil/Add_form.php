<script language="javascript">
$("#add_dia_habil").on('submit', function(evt){
	 evt.preventDefault();
	 save_dia_habil();
});

</script>

<?php
include_once('../../funciones/funciones.php');
require("../../autentificacion/aut_config.inc.php");
require "../../".class_bd;
require "../../".Leng;

 $metodo = $_POST['metodo'];
 $archivo = "horarios";

$proced  = 'p_horarios';

if($metodo == 'modificar'){
  $titulo = "Modificar Día Hábil ";
	$codigo = $_POST['codigo'];
	$bd = new DataBase();
	$sql = " SELECT a.codigo, a.cod_dias_tipo, b.descripcion dias_tipo,  a.descripcion,
                  a.cod_us_ing, a.fec_us_ing, a.cod_us_mod, a.fec_us_mod,
                  a.`status`
             FROM dias_habiles a  LEFT JOIN dias_tipo b ON b.dia = a.cod_dias_tipo
						 WHERE a.codigo = '$codigo' ";

	$query = $bd->consultar($sql);
	$result = $bd->obtener_fila($query,0);

	$descripcion   = $result["descripcion"];
	$cod_dias_tipo = $result["cod_dias_tipo"];
	$dias_tipo     = $result["dias_tipo"] ;
	$activo        = $result["status"];


	}else{
  $titulo = "Agregar Día Hábil";
	$codigo          = '';
	$descripcion     = '';
	$cod_dias_tipo   = '';
	$dias_tipo       = 'Seleccione...';
	$activo          = 'T';
	}
?>
<form action="" method="post" name="add_dia_habil" id="add_dia_habil">
  <fieldset class="fieldset">
  <legend><?php echo $titulo;?> </legend>
     <table width="90%" align="center">
    <tr>
      <td width="15%" class="etiqueta">C&oacute;digo:</td>
      <td width="35%"><input type="text" name="codigo" id="dh_codigo" maxlength="11" readonly  value="<?php echo $codigo;?>" />
               Activo: <input name="activo" id="activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" />
      </td>

			<td width="15%" class="etiqueta">descripcion: </td>
			<td width="35%"><input type="text" name="descripcion" id="dh_descripcion" minlength="2" maxlength="60" required style="width:300px"
															value="<?php echo $descripcion;?>"/>

			</td>
		</tr>

	 	<tr>
      <td class="etiqueta">Clasificación:</td>
      <td><select name="clasif" id="dh_clasif" style="width:200px" required onchange="Add_dh_det(this.value)">
  							<option value="<?php echo $cod_dias_tipo ;?>"><?php echo $dias_tipo ;?></option>
            <?php   	$sql = " SELECT dias_tipo.dia, dias_tipo.descripcion
	                   					 FROM dias_tipo WHERE dias_tipo.tipo = 'TIPO'
															 	AND dias_tipo.dia  <> '$cod_dias_tipo'
															  ORDER BY dias_tipo.orden ASC";
  		            $query = $bd->consultar($sql);
              		while($datos=$bd->obtener_fila($query,0)){
  		  ?>
            <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
            <?php }?>
          </select></td>
  </tr>
		<td colspan="4" id="Cont_dh_det">
			<?php
	if($metodo == "modificar"){


	 $sql_dias  = "SELECT a.* ,  IFNULL(b.cod_dias_tipo, 'FALSE') existe
                  FROM turno_dias a LEFT JOIN dias_habiles_det b ON b.`cod_dias_habiles` = '$codigo'
                   AND b.cod_dias_tipo = a.dia
                 WHERE a.tipo = '$cod_dias_tipo' AND a.`status` = 'T'
                 ORDER BY a.orden ASC";
		$query = $bd->consultar($sql_dias);
 				 	echo'<table width="100%" align="center">

						<tr>
			         <td height="8" colspan="4" align="center"><hr></td>
			     </tr>
 						<tr>
 							<td class="etiqueta" width="15%">Fecha Diaria</td>
 							<td class="etiqueta" width="35%" align="left">Apertura</td>
							<td class="etiqueta" width="15%">Fecha Diaria</td>
 							<td class="etiqueta" width="35%" align="left">Apertura</td>
 		       </tr>';

					 $x = 0;
 					while($row02=$bd->obtener_fila($query,0)){

						if ($x == 0){
						echo '<tr>
									<td>'.$row02[2].'</td>
									<td><input type="checkbox" name="DIAS[]" value="'.$row02[0].'" style="width:auto" '.CheckX("$row02[0]", "$row02[5]").' /></td>';
							$x = 1;
						}else {
							$x = 0;
							echo '
							<td>'.$row02[2].'</td>
							<td><input type="checkbox" name="DIAS[]" value="'.$row02[0].'" style="width:auto" '.CheckX("$row02[0]", "$row02[5]").' /></td>
						 </tr>';
						}

					}

					if($x == 1){
						echo '<tr>';
					}
			}
			echo '</table>';
				?>
		</td>
	<tr>

	</tr>

	 	<tr>
         <td height="8" colspan="4" align="center"><hr></td>
     </tr>
  </table>

<div align="center"><span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="submit" name="salvar"  id="salvar" value="Guardar" class="readon art-button" />
                </span>&nbsp;
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="reset" id="limpiar" value="Restablecer" class="readon art-button" />
                </span>&nbsp;
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="button" id="volver" value="Volver" onClick="Cons_dia_habil_inicio()" class="readon art-button" />
                </span>

  		    <input name="metodo" id="h_metodo" type="hidden"  value="<?php echo $metodo;?>" />
             </div>
  </fieldset>
  </form>
