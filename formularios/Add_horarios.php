<?php
$Nmenu = 301;
require_once('autentificacion/aut_verifica_menu.php');

$metodo = $_GET['metodo'];
$archivo = $_GET['archivo'];

$titulo = "HORARIOS";
$proced  = 'p_horarios';
$archivo2 = "../inicio.php?area=formularios/Cons_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."";

if($metodo == 'modificar'){
	$codigo = $_GET['codigo'];
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
<form action="scripts/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add">
  <fieldset class="fieldset">
  <legend>DATOS <?php echo $titulo;?> </legend>
     <table width="80%" align="center">
    <tr>
      <td class="etiqueta">C&oacute;digo:</td>
      <td id="input01"><input type="text" name="codigo" maxlength="11" style="width:120px" value="<?php echo $codigo;?>" />
               Activo: <input name="activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" />
          <br /><span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
	 </tr>
    <tr>
      <td class="etiqueta">Nombre: </td>
      <td id="input02"><input type="text" name="nombre" maxlength="60" style="width:300px"
                              value="<?php echo $nombre;?>"/>
		  <br /><span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
		<td class="etiqueta"><?php echo $leng['concepto']?>:</td>
      	<td id="select01"><select name="concepto" style="width:200px">
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
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    <tr>
      <td class="etiqueta">Hora Entrada: </td>
      <td id="time01"><input type="text" name="h_entrada" maxlength="12" style="width:100px"
                             value="<?php echo $hora_entrada;?>"/>
		  <br /><span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Hora Salida: </td>
      <td id="time02"><input type="text" name="h_salida" maxlength="12" style="width:100px"
                              value="<?php echo $hora_salida;?>"/>
		  <br /><span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Inicio Marcaje Entrada: </td>
      <td id="time03"><input type="text" name="inicio_m_entrada" maxlength="12" style="width:100px"
                              value="<?php echo $inicio_m_entrada;?>"/>
		  <br /><span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Fin Marcaje Entrada: </td>
      <td id="time04"><input type="text" name="fin_m_entrada" maxlength="12" style="width:100px"
                              value="<?php echo $fin_m_entrada;?>"/>
		  <br /><span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Inicio Marcaje Salida: </td>
      <td id="time05"><input type="text" name="inicio_m_salida" maxlength="12" style="width:100px"
                              value="<?php echo $inicio_m_salida;?>"/>
		  <br /><span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Fin Marcaje Salida: </td>
      <td id="time06"><input type="text" name="fin_m_salida" maxlength="12" style="width:100px"
                              value="<?php echo $fin_m_salida;?>"/>
		  <br /><span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Dias De Trabajo: </td>
      <td id="input03"><input type="text" name="dia_trabajo" maxlength="12" style="width:100px"
                              value="<?php echo $dia_trabajo;?>"/>
		  <br /><span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Minutos De Trabajo: </td>
      <td id="input04"><input type="text" name="minutos_trabajo" maxlength="120" style="width:100px"
                              value="<?php echo $minutos_trabajo;?>"/>
		  <br /><span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>

	 <tr>
         <td height="8" colspan="2" align="center"><hr></td>
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
                <input type="button" id="volver" value="Volver" onClick="history.back(-1);" class="readon art-button" />
                </span>

  		    <input name="metodo" id="metodo" type="hidden"  value="<?php echo $metodo;?>" />
             <input name="proced" id="proced" type="hidden"  value="<?php echo $proced;?>" />
            <input name="usuario" id="usuario" type="hidden"  value="<?php echo $usuario;?>" />
	        <input name="href" type="hidden" value="<?php echo $archivo2;?>"/>
                 </div>
  </fieldset>
  </form>
  <script type="text/javascript">
var input01  = new Spry.Widget.ValidationTextField("input01", "none", {validateOn:["change"]});
var input02  = new Spry.Widget.ValidationTextField("input02", "none", {validateOn:["change"]});


var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});

//var input03  = new Spry.Widget.ValidationTextField("input03", "currency", {format:"comma_dot", validateOn:["change"],useCharacterMasking:true , isRequired:false});

var currency = new Spry.Widget.ValidationTextField("input03", "currency", {format:"comma_dot",validateOn:["blur"], useCharacterMasking:true});

var input04  = new Spry.Widget.ValidationTextField("input04","currency", {format:"comma_dot", validateOn:["change"], useCharacterMasking:false , isRequired:false});

var time01 = new Spry.Widget.ValidationTextField("time01", "time", {format:"HH:mm:ss", hint:'HH:mm:ss', useCharacterMasking:true, validateOn:["change"],isRequired:true});
var time02 = new Spry.Widget.ValidationTextField("time02", "time", {format:"HH:mm:ss", hint:'HH:mm:ss', useCharacterMasking:true, validateOn:["change"],isRequired:true});
var time03 = new Spry.Widget.ValidationTextField("time03", "time", {format:"HH:mm:ss", hint:'HH:mm:ss', useCharacterMasking:true, validateOn:["change"],isRequired:true});
var time04 = new Spry.Widget.ValidationTextField("time04", "time", {format:"HH:mm:ss", hint:'HH:mm:ss', useCharacterMasking:true, validateOn:["change"],isRequired:true});
var time05 = new Spry.Widget.ValidationTextField("time05", "time", {format:"HH:mm:ss", hint:'HH:mm:ss', useCharacterMasking:true, validateOn:["change"],isRequired:true});
var time06 = new Spry.Widget.ValidationTextField("time06", "time", {format:"HH:mm:ss", hint:'HH:mm:ss', useCharacterMasking:true, validateOn:["change"],isRequired:true});
</script>
