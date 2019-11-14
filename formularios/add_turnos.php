<script language="JavaScript" type="text/javascript">
function Actualizar_01(valor, Contenedor){
	var codigo     = document.getElementById('codigo').value;
	var horario    = document.getElementById('horario').value;
	var turno_tipo = document.getElementById('turno_tipo').value;
	var usuario    = document.getElementById('usuario').value;
	   if( (codigo != '') && (horario != '') &&(turno_tipo != '')){
		ajax=nuevoAjax();
			ajax.open("POST", valor, true);
			ajax.onreadystatechange=function(){
			if (ajax.readyState==4){
				document.getElementById(Contenedor).innerHTML = ajax.responseText;
				// window.location.reload();
			}
		}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("horario="+horario+"&turno_tipo="+turno_tipo+"&usuario="+usuario+"");
		}else{
			document.getElementById(Contenedor).innerHTML = "";
		}
	}
</script>
<?php
$Nmenu = 302;
$titulo = " TURNOS ";
$archivo = "turnos";
$archivo2 = "../inicio.php?area=formularios/Cons_$archivo&Nmenu=$Nmenu&mod=".$_GET['mod']."";
require_once('autentificacion/aut_verifica_menu.php');
$bd = new DataBase();

$codigo    = $_GET['codigo'];
$metodo    = $_GET['metodo'];

$proced    = "p_turno";
$proced2    = "p_turno_det";
if($metodo == 'modificar'){

	$sql = " SELECT turno.codigo, turno.abrev, turno.descripcion AS turno,
                    turno.cod_turno_tipo, turno_tipo.descripcion AS turno_tipo,
                    turno.cod_horario, horarios.nombre AS horario,
                    turno.fec_inicio, turno.fec_fin,
					turno.factor, turno.trab_cubrir,
					turno.`status`
               FROM turno , turno_tipo , horarios
              WHERE turno.codigo = '$codigo'
			    AND turno.cod_turno_tipo = turno_tipo.codigo
                AND turno.cod_horario = horarios.codigo
		   ORDER BY 2 ASC";

	$query  = $bd->consultar($sql);
	$result = $bd->obtener_fila($query,0);

	$codigo        = $result['codigo'];
	$abrev         = $result['abrev'];
	$nombre        = $result['turno'];
	$fec_inic      = conversion($result['fec_inicio']);
	$fec_fin       = conversion($result['fec_fin']);
	$cod_turno_tipo = $result['cod_turno_tipo'];
	$turno_tipo    = $result['turno_tipo'];
	$cod_horario   = $result['cod_horario'];
	$horario       = $result['horario'];
    $factor        = $result['factor'];
	$trab_cubrir   = $result['trab_cubrir'];
	$activo        = $result['status'];

	}else{

	$codigo        = '';
	$abrev         = '';
	$nombre        = '';
	$fec_inic      = conversion($date);
	$fec_fin       = conversion($date);
	$cod_turno_tipo = '';
	$turno_tipo    = 'Seleccione...';
	$cod_horario   = '';
	$horario       = 'Seleccione...';
    $factor        = '';
	$trab_cubrir   = '';
	$activo        = 'T';
}?>
<br>
<div align="center" class="etiqueta_title"> <?php echo $titulo;?> </div>
<div id="Contendor01" class="mensaje"></div>
<br/>
<form name="form01_apertura" id="form01_apertura" action="scripts/sc_<?php echo $archivo;?>.php" method="post">
    <table width="750px" border="0" align="center">
	<tr>
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>
    <tr>
      <td class="etiqueta" width="25%">codigo:</td>
      <td id="input01" width="75%"><input type="text" id="codigo" name="codigo" maxlength="12" size="14"
                              value="<?php echo $codigo;?>"  onchange="Actualizar_01('ajax/add_turnos.php','Contenedor_Fec')"/>
                               Activo: <input name="activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" /><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta">Abreviatura:</td>
      <td id="input02"><input type="text" name="abrev" maxlength="16" style="width:120px" value="<?php echo $abrev;?>" /><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Nombre:</td>
      <td id="input03"><input type="text" id="nombre" name="nombre" maxlength="60" size="30" value="<?php echo $nombre;?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span></td>
     </tr>
     <tr>
        <td class="etiqueta">Turno Tipo:</td>
		<td  id="select01"><select name="turno_tipo" id="turno_tipo" style="width:250px;"
                                               onchange="Actualizar_01('ajax/add_turnos.php','Contenedor_Fec')">
     				   <option value="<?php echo $cod_turno_tipo;?>"><?php echo $turno_tipo;?></option>
          <?php  	$sql = " SELECT turno_tipo.codigo, turno_tipo.descripcion
                               FROM turno_tipo
                              WHERE turno_tipo.`status` = 'T'
							  AND turno_tipo.codigo <> '$cod_turno_tipo' ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($row02=$bd->obtener_fila($query,0)){
	 					echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
					}
		   ?></select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span>
		</td>
     </tr>
     <tr>
        <td class="etiqueta">Horario:</td>
		<td  id="select02"><select name="horario" id="horario" style="width:250px;"
                                               onchange="Actualizar_01('ajax/add_turnos.php','Contenedor_Fec')">
     				   <option value="<?php echo $cod_horario;?>"><?php echo $horario;?></option>
          <?php  	$sql = " SELECT horarios.codigo, horarios.nombre
                               FROM horarios
                              WHERE horarios.`status` = 'T'
							    AND horarios.codigo <> '$cod_horario' ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($row02=$bd->obtener_fila($query,0)){
	 					echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
					}
		   ?></select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span>
		</td>
     </tr>
    <tr>
      <td class="etiqueta">Factor:</td>
      <td id="radio01" class="texto">Aumentar (+)<input type = "radio" name="factor" value ="aum"
                                                        style="width:auto" <?php echo CheckX($factor, 'aum');?> />
                                     Dismininuir (-)<input type = "radio" name="factor"
                                                           value = "dis" style="width:auto" <?php echo CheckX($factor, 'dis');?> />	<br />
            <span class="radioRequiredMsg">Debe seleccionar un Campo.</span></td>
      </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng['trabajador']?> Necesario Para Cubrir:</td>
      <td id="input04"><input type="text" name="trab_cubrir" maxlength="6" style="width:120px" value="<?php echo $trab_cubrir;?>" /><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
      </tr>
      <tr>
        <td id="Contenedor_Fec" colspan="2">
        <?php
		 if ($metodo == "modificar"){
		$sql = " SELECT turno_dias.dia, turno_dias.tipo,
						turno_dias.descripcion
				   FROM turno_dias
				  WHERE turno_dias.tipo = '$cod_turno_tipo'
					AND turno_dias.`status` = 'T'
			   ORDER BY 1 ASC ";

		 $query = $bd->consultar($sql);
				 	echo'<table width="100%" align="center">
						<tr>
							<td class="etiqueta" width="25%">Fecha Diaria</td>
							<td class="etiqueta" width="75%" align="left">Apertura</td>
		                </tr>';
					while($row02=$bd->obtener_fila($query,0)){

				$dia = $row02[0];
				$sql = " SELECT turno_det.dias FROM turno_det
                          WHERE turno_det.cod_turno = '$codigo'
						    AND turno_det.dias = '$dia' ";
			    $query03 = $bd->consultar($sql);

					if ($bd->num_fila($query03)==0){
					$checkX ='';
					}else{
					$checkX = 'checked="checked"';
					}
				echo '<tr>
						<td> '.$row02[2].'</td>
						<td><input type="checkbox" name="DIA[]"value="'.$row02[0].'" style="width:auto" '.$checkX.' /></td>
				   </tr>';
					}
		echo '</table>';
		 }
		?>
		</td>
      </tr>
	 <tr>
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>
    </table>
	 <br />
<div align="center">  <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="submit" name="salvar"  id="salvar" value="Siguiente"  class="readon art-button" />
                </span>&nbsp;
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="reset" id="limpiar" value="Restablecer" class="readon art-button" />
                </span>&nbsp;
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="button" id="volver" value="Volver" onClick="history.back(-1);" class="readon art-button" />
                </span>
                 <input name="href" type="hidden" value="<?php echo $archivo2;?>"/>
                 <input name="usuario" id="usuario" type="hidden" value="<?php echo $usuario;?>"/>
                 <input name="metodo" type="hidden" value="<?php echo $metodo;?>"/>
                 <input name="proced" type="hidden" value="<?php echo $proced;?>"/>
                 <input name="proced2" type="hidden" value="<?php echo $proced2;?>"/>
                 <input name="fec_inic" type="hidden" value="<?php echo $fec_inic;?>"/>
                 <input name="fec_fin" type="hidden" value="<?php echo $fec_fin;?>"/>
</div>
</form>
<br />
<div align="center">
</div>
<script type="text/javascript">
var input01  = new Spry.Widget.ValidationTextField("input01", "none", {validateOn:["blur", "change"]});
var input02  = new Spry.Widget.ValidationTextField("input02", "none", {validateOn:["blur", "change"]});
var input03  = new Spry.Widget.ValidationTextField("input03", "none", {validateOn:["blur", "change"]});

var input04 = new Spry.Widget.ValidationTextField("input04", "real", {validateOn:["blur", "change"], useCharacterMasking:true});

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});

var radio01 = new Spry.Widget.ValidationRadio("radio01", { validateOn:["change", "blur"]});
</script>
