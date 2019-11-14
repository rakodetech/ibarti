
<script language="javascript">

$("#cl_puesto_form").on('submit', function(evt){
	 evt.preventDefault();
	 save_puesto();
});


	</script>
<?php


define("SPECIALCONSTANT", true);
include_once('../../../funciones/funciones.php');
require("../../../autentificacion/aut_config.inc.php");
require_once("../../../".class_bdI);

	$proced      = "p_clientes_ubic";
  $codigo      = $_POST['codigo'];
	$metodo      = $_POST['metodo'];
if($metodo == 'modificar'){
$titulo = "Modificar Puesto De Trabajo";
	$bd = new DataBase();
	$sql = " SELECT a.*, clientes.nombre cliente, clientes.abrev, clientes_ubicacion.descripcion ubic
FROM clientes_ub_puesto a, clientes, clientes_ubicacion
            WHERE  a.cod_cliente = clientes.codigo
AND a.cod_cl_ubicacion  = clientes_ubicacion.codigo
AND a.codigo =  '$codigo'";

	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);


	$nombre       = $result["nombre"];
	$actividades  = $result["actividades"];
	$observ       = $result["observ"];
	$activo       = $result["status"];

	}else{
	$titulo = "Agregar Puesto De Trabajo";
	$codigo       = '';
	$nombre       = '';
	$actividades  = '';
	$observ       = '';
	$activo      = 'T';

	}
?>

<form id="cl_puesto_form" name="cl_puesto_form" method="post">
<fieldset class="fieldset">
  <legend>Datos <?php echo $titulo;?></legend>
     <table width="90%" align="center">
    <tr>
      <td width="15%" class="etiqueta">C&oacute;digo:</td>
      <td width="35%"><input type="text" id="p_codigo"  maxlength="11" size="15" value="<?php echo $codigo;?>" readonly  />
               Activo: <input id="p_activo" name="p_activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" />
      </td>

      <td width="15%" class="etiqueta">Nombre: </td>
      <td width="35%"><input type="text" id="p_nombre" maxlength="30" size="30" required value="<?php echo $nombre;?>"/>
      </td>
    </tr>

    <tr>
      <td class="etiqueta">Actividades:</td>
      <td id="textarea03"><textarea  id="p_actividades" cols="36" rows="4"><?php echo $actividades;?></textarea>
        <span id="Counterror_mess3" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 300.</span></td>

      <td class="etiqueta">Observación:</td>
      <td id="textarea04"><textarea  id="p_observ" cols="36" rows="4"><?php echo $observ;?></textarea>
        <span id="Counterror_mess4" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 300.</span></td>
    </tr>
	 <tr>
         <td height="8" colspan="4" align="center"><hr></td>
     </tr>

  </table>
	<div align="center"><br/>
		 <span class="art-button-wrapper">
		 			 <span class="art-button-l"> </span>
		 			 <span class="art-button-r"> </span>
		 			<input type="submit" name="salvar"  id="salvar" value="Guardar" class="readon art-button" />
		 	 </span>&nbsp;

		<span class="art-button-wrapper">
				 <span class="art-button-l"> </span>
				 <span class="art-button-r"> </span>
		 <input type="button" id="volver" value="volver" onClick="Cons_puesto_inicio()" class="readon art-button" />
		 </span>
	</div>
	 <input name="metodo" id="p_metodo" type="hidden"  value="<?php echo $metodo;?>" />

  </fieldset>
</form>

<script type="text/javascript">
var textarea01 = new Spry.Widget.ValidationTextarea("textarea03", {maxChars:300, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess3", useCharacterMasking:false ,isRequired:false});
var textarea02 = new Spry.Widget.ValidationTextarea("textarea04", {maxChars:300, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess4", useCharacterMasking:false ,isRequired:false});
</script>


<?php /*

<script language="javascript">
$("#add_horario").on('submit', function(evt){
	 evt.preventDefault();
	 save_horario();
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
  $titulo = "Modificar Horario";
	$codigo = $_POST['codigo'];
	$bd = new DataBase();
	$sql = " SELECT horarios.codigo, horarios.nombre,
                    horarios.cod_concepto, conceptos.descripcion AS concepto,
					conceptos.abrev,
                    horarios.hora_entrada, horarios.hora_salida,
                    horarios.inicio_marc_entrada, horarios.fin_marc_entrada,
                    horarios.inicio_marc_salida, horarios.fin_marc_salida,
                    horarios.dia_trabajo, horarios.minutos_trabajo,
                    horarios.`status`
               FROM horarios, conceptos
			  WHERE horarios.codigo = '$codigo'
                AND horarios.cod_concepto = conceptos.codigo ";

	$query = $bd->consultar($sql);
	$result = $bd->obtener_fila($query,0);

	$nombre           = $result["nombre"];
	$cod_concepto     = $result["cod_concepto"];
	$concepto         = $result["concepto"].' ('.$result["abrev"].')' ;
	$hora_entrada     = $result["hora_entrada"];
	$hora_salida      = $result["hora_salida"];
	$inicio_m_entrada = $result["inicio_marc_entrada"];
	$fin_m_entrada    = $result["fin_marc_entrada"];
	$inicio_m_salida  = $result["inicio_marc_salida"];
	$fin_m_salida     = $result["fin_marc_salida"];
	$dia_trabajo      = Dec2($result["dia_trabajo"]);
	$minutos_trabajo  = $result["minutos_trabajo"];
	$activo     = $result["status"];

	}else{
  $titulo = "Agregar Horario";
	$codigo           = '';
	$nombre           = '';
	$cod_concepto     = '';
	$concepto         = 'Seleccione...';
	$abrev            = '';
	$hora_entrada     = '';
	$hora_salida      = '';
	$inicio_m_entrada = '';
	$fin_m_entrada    = '';
	$inicio_m_salida  = '';
	$fin_m_salida     = '';
	$dia_trabajo      = '';
	$minutos_trabajo  = '';

	$activo     = 'T';
	}
?>
<form action="" method="post" name="add_horario" id="add_horario">
  <fieldset class="fieldset">
  <legend><?php echo $titulo;?> </legend>
     <table width="90%" align="center">
    <tr>
      <td width="15%" class="etiqueta">C&oacute;digo:</td>
      <td width="35%"><input type="text" name="codigo" id="h_codigo" minlength="2" maxlength="11" required value="<?php echo $codigo;?>" />
               Activo: <input name="activo" id="activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" />
      </td>

      <td width="15%" class="etiqueta"><?php echo $leng['concepto']?>:</td>
      <td width="35%"><select name="concepto" id="h_concepto" style="width:200px" required>
  							<option value="<?php echo $cod_concepto;?>"><?php echo $concepto;?></option>
            <?php  	$sql = " SELECT codigo, descripcion, abrev FROM conceptos
  		                      WHERE status = 'T'
  							    AND codigo <> '$cod_concepto'
  							    AND conceptos.asist_diaria = 'T' ORDER BY 2 ASC ";
  		            $query = $bd->consultar($sql);
              		while($datos=$bd->obtener_fila($query,0)){
  		  ?>
            <option value="<?php echo $datos[0];?>"><?php echo $datos[1].' ( '.$datos[2].')';?></option>
            <?php }?>
          </select></td>

	 </tr>
    <tr>
      <td class="etiqueta">Nombre: </td>
      <td colspan="3"><input type="text" name="nombre" id="h_nombre" minlength="4" maxlength="60" required style="width:300px"
                              value="<?php echo $nombre;?>"/>
		  <br /><span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Hora Entrada: </td>
      <td><input type="time" name="h_entrada" id="h_entrada" required value="<?php echo $hora_entrada;?>"/></td>

      <td class="etiqueta">Hora Salida: </td>
      <td><input type="time" name="h_salida" id="h_salida" required value="<?php echo $hora_salida;?>"/></td>
    </tr>
    <tr>
      <td class="etiqueta">Inicio Marcaje Entrada: </td>
      <td><input type="time" name="inicio_m_entrada" id="inicio_m_entrada" required  value="<?php echo $inicio_m_entrada;?>"/></td>

      <td class="etiqueta">Fin Marcaje Entrada: </td>
      <td><input type="time" name="fin_m_entrada" id="fin_m_entrada" required  value="<?php echo $fin_m_entrada;?>"/></td>
    </tr>
    <tr>
      <td class="etiqueta">Inicio Marcaje Salida: </td>
      <td><input type="time" name="inicio_m_salida" id="inicio_m_salida" required  value="<?php echo $inicio_m_salida;?>"/></td>

      <td class="etiqueta">Fin Marcaje Salida: </td>
      <td><input type="time" name="fin_m_salida" id="fin_m_salida" required value="<?php echo $fin_m_salida;?>"/></td>
    </tr>
    <tr>
      <td class="etiqueta">Dias De Trabajo: </td>
      <td id="input03">
				<input type="number" name="dia_trabajo" id="dia_trabajo"  max="3" required value="<?php echo $dia_trabajo;?>"  />
      </td>
      <td class="etiqueta">Minutos De Trabajo: </td>
      <td><input type="number" name="minutos_trabajo" id="minutos_trabajo" required max="4320"   value="<?php echo $minutos_trabajo;?>">
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
                <input type="button" id="volver" value="Volver" onClick="Cons_horario_inicio()" class="readon art-button" />
                </span>

  		    <input name="metodo" id="h_metodo" type="hidden"  value="<?php echo $metodo;?>" />
             </div>
  </fieldset>
  </form>


*/ ?>
