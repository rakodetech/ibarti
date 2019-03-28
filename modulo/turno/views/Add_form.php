<script language="javascript">
$("#add_turno").on('submit', function(evt){
	 evt.preventDefault();
	 save_turno();
});
</script>
<?php
include_once('../../../funciones/funciones.php');
require("../../../autentificacion/aut_config.inc.php");
require "../../../".class_bd;
require "../../../".Leng;

$metodo = $_POST['metodo'];

if($metodo == 'modificar'){
  $titulo = "Modificar ".$leng['turno'];
	$codigo    = $_POST['codigo'];

	$sql = " SELECT turno.abrev, turno.descripcion AS turno,
                  turno.cod_horario, horarios.nombre AS horario,
	 							  turno.cod_dia_habil, dias_habiles.descripcion AS dia_habil,
                  turno.factor, turno.trab_cubrir,
					        turno.`status`
             FROM turno , horarios, dias_habiles
            WHERE turno.codigo = '$codigo'
		          AND turno.cod_horario = horarios.codigo
							AND turno.cod_dia_habil = dias_habiles.codigo
		     ORDER BY 2 ASC ";

	$query         = $bd->consultar($sql);
	$result        = $bd->obtener_fila($query,0);

  $cod_d_habil   = $result['cod_dia_habil'];
  $d_habil       = $result['dia_habil'];
	$abrev         = $result['abrev'];
	$nombre        = $result['turno'];
	$cod_horario   = $result['cod_horario'];
	$horario       = $result['horario'];
  $factor        = $result['factor'];
	$trab_cubrir   = $result['trab_cubrir'];
	$activo        = $result['status'];

	}else{

  $titulo        = "Agregar ".$leng['turno'];
	$codigo        = '';
	$abrev         = '';
	$nombre        = '';
	$cod_d_habil   = "";
  $d_habil       = "Seleccione...";
	$cod_horario   = '';
	$horario       = 'Seleccione...';
  $factor        = '';
	$trab_cubrir   = '';
	$activo        = 'T';
}
?>
<form action="" method="post" name="add_turno" id="add_turno">
  <fieldset class="fieldset">
  <legend><?php echo $titulo;?> </legend>
     <table width="95%" align="center">
    <tr>
      <td width="15%" class="etiqueta">C&oacute;digo:</td>
      <td width="35%"><input type="text" name="codigo" id="t_codigo" minlength="2" maxlength="11" required value="<?php echo $codigo;?>" />
               Activo: <input name="activo" id="activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" />
      </td>
      <td width="15%" class="etiqueta">Abrev:</td>
      <td width="35%"><input type="text" name="abrev" id="t_abrev"minlength="2" maxlength="16" required value="<?php echo $abrev;?>" /></td>
	 </tr>
    <tr>
      <td class="etiqueta">Nombre: </td>
      <td colspan="2"><input type="text" name="nombre" id="t_nombre" minlength="4" maxlength="60" required style="width:300px" value="<?php echo $nombre;?>"/></td>
<td></td>
		</tr>
			<tr>
			<td class="etiqueta">Días Hábiles:</td>
			<td><select name="d_habil" id="t_d_habil" style="width:220px;" required>
						<option value="<?php echo $cod_d_habil;?>"><?php echo $d_habil;?></option>
				<?php  	$sql = "SELECT dias_habiles.codigo, dias_habiles.descripcion
													FROM dias_habiles WHERE dias_habiles.`status` = 'T'
													 AND dias_habiles.codigo <> '$cod_d_habil' ORDER BY 2 ASC ";
							$query = $bd->consultar($sql);
							while($row02=$bd->obtener_fila($query,0)){
					echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
				}?></select><img class="imgLink" src="imagenes\ico_agregar.ico" alt="Agregar Día Hábil" title="Agregar Día Hábil"  onclick="B_d_habil()"  width="20px" height="20px">

	</td>
				<td class="etiqueta">Horas:</td>
				<td><select name="horario" id="t_horario" style="width:220px;" required>
							<option value="<?php echo $cod_horario;?>"><?php echo $horario;?></option>
					<?php  	$sql = "SELECT horarios.codigo, horarios.nombre
													  FROM horarios WHERE horarios.`status` = 'T'
									           AND horarios.codigo <> '$cod_horario' ORDER BY 2 ASC ";
								$query = $bd->consultar($sql);
								while($row02=$bd->obtener_fila($query,0)){
						echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
					}?></select><img class="imgLink" src="imagenes\ico_agregar.ico" alt="Agregar Horas" title="Agregar Horas"  onclick="B_hora()"  width="20px" height="20px">
		</td>
    </tr>
		<tr>
      <td class="etiqueta">Factor:</td>
      <td class="texto">Aumentar (+)<input type = "radio" name="t_factor" value ="aum" required
                                                        style="width:auto" <?php echo CheckX($factor, 'aum');?> />
                                     Dismininuir (-)<input type = "radio" name="t_factor" required
                                                           value = "dis" style="width:auto" <?php echo CheckX($factor, 'dis');?> />
            </td>

      <td class="etiqueta"><?php echo $leng['trabajador']?> Necesario Para Cubrir:</td>
      <td><input type="text" name="trab_cubrir" id="t_trab_cubrir" maxlength="6" style="width:120px" value="<?php echo $trab_cubrir;?>" />
      </td>
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
                <input type="button" id="volver" value="Volver" onClick="Cons_turno_inicio()" class="readon art-button" />
                </span>

  		    <input name="metodo" id="h_metodo" type="hidden"  value="<?php echo $metodo;?>" />
             </div>
  </fieldset>
  </form>
