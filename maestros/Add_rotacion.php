<script language="JavaScript" type="text/javascript">

function Ingresar_Det(metodo){

	var codigo      = $( "#codigo").val();
	var abrev       = $( "#abrev").val();
	var descripcion = $( "#descripcion").val();
	var activo      = $( "#activo").val();
	var cod_det     = $( "#cod_det").val();
	var turno       = $( "#turno").val();
	var horario     = $( "#horario").val();

	var Nmenu       = $( "#Nmenu").val();
	var mod         = $( "#mod").val();
	var archivo     = $( "#archivo").val();
	var href        = "";
	var usuario     = $( "#usuario").val();

	var proced      =  $( "#proced").val();
	var proced2     = $( "#proced2").val();

	var error       = 0;
    var errorMessage = ' ';

	if(error == 0){

	  var parametros = { "codigo" : codigo, 			          "abrev" : abrev,
					             "descripcion" : descripcion, 			"activo" : activo,
					             "cod_det" : cod_det,         			"horario" : horario,
						           "metodo" : metodo, 	 			        "detalle" : "SI",
	       	             "cod_det" : cod_det,               "turno" : turno,
						           "proced" : proced,        			   	"proced2" : proced2,
						           "usuario" : usuario,    						"Nmenu" : Nmenu,
					             "mod" : mod,
						           "href" : href, 						        "archivo": archivo };
				$.ajax({
						data:  parametros,
						url:   'sc_maestros/sc_rotacion.php',
						type:  'post',
						beforeSend: function () {
							 $("#Contenedor01").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
							},
						success:  function (response) {
								$("#Contenedor01").html(response);
								listar_Det();
						},
					error: function (xhr, ajaxOptions, thrownError) {
       				alert(xhr.status);
        			alert(thrownError);}
				});

		}else{
			alert(errorMessage);
		}
	}

function Rotacion_Det(metodo, campo_x){



	var codigo      = $( "#codigo").val();
	var abrev       = $( "#abrev").val();
	var descripcion = $( "#descripcion").val();
	var activo      = $( "#activo").val();
	var cod_det     = campo_x;
	var horario     = $( "#horario_"+campo_x+"").val();
	var turno       = $( "#turno_"+campo_x+"").val();

	var Nmenu       = $( "#Nmenu").val();
	var mod         = $( "#mod").val();
	var archivo     = $( "#archivo").val();
	var href        = "";
	var usuario     = $( "#usuario").val();
	var proced      =  $( "#proced").val();
	var proced2     = $( "#proced2").val();
	var error       = 0;
  var errorMessage = ' ';

	if(error == 0){
	  var parametros = {"codigo" : codigo, 						 "abrev" : abrev,
						          "descripcion" : descripcion, 	 "activo" : activo,
					           	"cod_det" : cod_det,  				 "horario" : horario,
						          "metodo" : metodo, 		 				 "detalle" : "SI",
	       		          "cod_det" : cod_det,           "turno"   : turno,
           						"proced" : proced, 						 "proced2" : proced2,
						          "usuario" : usuario, 					 "Nmenu" : Nmenu,
						          "mod" : mod, 						       "href" : href,
						          "archivo": archivo };
				$.ajax({
						data:  parametros,
						url:   'sc_maestros/sc_rotacion.php',
						type:  'post',
						beforeSend: function () {
							 $("#contenedor_listar").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
							},
						success:  function (response) {
								$("#contenedor_listar").html(response);
								listar_Det();
						},
					error: function (xhr, ajaxOptions, thrownError) {
       				alert(xhr.status);
        			alert(thrownError);}
				});

		}else{
			alert(errorMessage);
		}
	}

	function listar_Det(){
		var codigo      = $( "#codigo").val();

	  var parametros = {
						"codigo" : codigo
				};
				$.ajax({
						data:  parametros,
						url:   'ajax/Add_rotacion_det.php',
						type:  'post',
						beforeSend: function () {
							 $("#contenedor_listar").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
							},
						success:  function (response) {
								$("#contenedor_listar").html(response);
						},
					error: function (xhr, ajaxOptions, thrownError) {
       				alert(xhr.status);
        			alert(thrownError);}
				});
	}


	// FILTRAR HORARIO
	function Filtrar_horario(idX, name, Contenedor, px, evento){
		if(idX !=""){
			var valor  = "ajax/Add_select_turno_horario.php";
			var usuario    = $("#usuario").val();

			ajax=nuevoAjax();
			ajax.open("POST", valor, true);
			ajax.onreadystatechange=function()
			{
				if (ajax.readyState==4){
				document.getElementById(Contenedor).innerHTML = ajax.responseText;

				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("codigo="+idX+"&name="+name+"&usuario="+usuario+"&tamano="+px+"&evento="+evento+"");
		}
	}
</script>
<?php
$Nmenu = 3001;
$titulo = " ROTACION ";
$archivo = "rotacion";
$archivo2 = "../inicio.php?area=maestros/Cons_$archivo&Nmenu=$Nmenu&mod=".$_GET['mod']."";
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report_t.php');
//$bd = new DataBase();

$codigo    = $_GET['codigo'];
$metodo    = $_GET['metodo'];

$proced    = "p_rotacion";
$proced2    = "p_rotacion_det";
if($metodo == 'modificar'){

	$bd = new DataBase();
	$sql = " SELECT rotacion.codigo, rotacion.abrev, rotacion.descripcion, rotacion.cod_us_ing,
                    rotacion.`status`
               FROM rotacion WHERE rotacion.codigo = '$codigo'";

	$query  = $bd->consultar($sql);
	$result = $bd->obtener_fila($query,0);

	$read_cod      = 'readonly="readonly"';
	$codigo        = $result['codigo'];
	$abrev         = $result['abrev'];
	$descripcion   = $result['descripcion'];
	$activo        = $result['status'];


	 $SQL_PAG = " SELECT rotacion_det.codigo, rotacion_det.cod_horario,
	 										horarios.nombre AS horario, rotacion_det.cod_turno,
	 										turno.descripcion turno
	 							 FROM rotacion_det, horarios, turno
	 							WHERE rotacion_det.cod_horario = horarios.codigo
	 								AND rotacion_det.cod_turno = turno.codigo
	 								AND rotacion_det.cod_rotacion = '$codigo'
	 					 ORDER BY 1 ASC";

	}elseif($metodo == "agregar"){

	$read_cod      = '';
	$codigo        = '';
	$abrev         = '';
	$descripcion   = '';

	$activo        = 'T';
	$SQL_PAG = "";
}
?>
<br>
<div align="center" class="etiqueta_title"> <?php echo $titulo;?> </div>
<div id="Contenedor01" class="mensaje"></div>
<br/>
<form name="form01_apertura" id="form01_apertura" action="sc_maestros/sc_<?php echo $archivo;?>.php" method="post">
    <table width="750px" border="0" align="center">
	<tr>
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>
    <tr>
      <td class="etiqueta" width="25%">codigo:</td>
      <td id="input01" width="75%"><input type="text" id="codigo" name="codigo" maxlength="12" size="14" <?php echo $read_cod;?>
                              value="<?php echo $codigo;?>" />
                               Activo: <input name="activo" id="activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" /><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta">Abreviatura:</td>
      <td id="input02"><input type="text" name="abrev" id="abrev" maxlength="16" style="width:120px" value="<?php echo $abrev;?>" /><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Descripcion:</td>
      <td id="input03"><input type="text" name="descripcion" id="descripcion" maxlength="60" size="30" value="<?php echo $descripcion;?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span></td>
     </tr>
   <tr>
        <td id="Contenedor_Fec" colspan="2">
		</td>
      </tr>
	 <tr>
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>
   	 <tr>
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>
    <tr>
    	<td colspan="2">
        <div id="contenedor_listar"><?php if($metodo != "agregar"){?><table width="95%" border="0" align="center">
		<tr class="fondo00">
            <th width="10%" class="etiqueta">Item</th>
            <th width="20%" class="etiqueta">Codigo</th>
								<th width="30%" class="etiqueta">Turno</th>
			<th width="30%" class="etiqueta">Horario</th>
			<th width="10%"><img src="imagenes/loading2.gif" width="40px" height="40px"/></th>
		</tr><?php	echo '<tr class="fondo01">
			<td>&nbsp;</td>
			<td><input type="text" id="cod_det" name="cod_det" maxlength="16" size="14" '.$read_cod.' /></td>
			<td><select name="turno" id="turno" style="width:160px;" onchange="Filtrar_horario(this.value, \'horario\', \'horarioX\', \'160px\',\'\')">
			<option value="">Seleccione...</option>';
			$query03 = $bd->consultar($sql_turno);
			while($row03=$bd->obtener_fila($query03,0)){
			echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
			}
			echo'</select></td>

          <td id="horarioX"><select name="horario" id="horario" style="width:160px;">
          			<option value="">Seleccione Un Turno</option>
								</select>'; ?>
				</td>
			  <td align="center"><span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                 <input type="button" name="submit" id="submit" value="Ingresar" class="readon art-button"
                        onclick="Ingresar_Det('agregar_det')" />
                </span></td>
		</tr><?php
		$query = $bd->consultar($SQL_PAG);
		$valor = 1;
		$i     = 0;
		while ($datos=$bd->obtener_fila($query,0)){
		$i++;
		if ($valor == 0){
		 $fondo = 'fondo01';
		$valor = 1;
		}else{
		 $fondo = 'fondo02';
		 $valor = 0;
		}
		$cod_det     = $datos['codigo'];
		$mod_det     = "Rotacion_Det('modificar_det', '".$cod_det."')";
		$borrar_det  = "Rotacion_Det('borrar_det', '".$cod_det."')";

		$fechaX  = conversion($fecha);
		$campo_id = $datos[0];
			 echo '<tr class="'.$fondo.'"><td>'.$i.'</td>
		<td><input type="text" id="cod_det_'.$datos["codigo"].'" name="cod_det" maxlength="16"
							size="14" value="'.$datos["codigo"].'" '.$read_cod.' /></td>
		<td><select id="turno_'.$cod_det.'" style="width:160px;" onchange="Filtrar_horario(this.value, \'horario_'.$cod_det.'\', \'horarioX_'.$cod_det.'\', \'160px\',\'\')">
					<option value="'.$datos["cod_turno"].'">'.$datos["turno"].'</option>';
			 $query03 = $bd->consultar($sql_turno);
				while($row03=$bd->obtener_fila($query03,0)){
				echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
				}echo'</select> </td>
				 <td id="horarioX_'.$cod_det.'"> <select id="horario_'.$cod_det.'" style="width:160px;">
								<option value="'.$datos["cod_horario"].'">'.$datos["horario"].'</option>
						 </select> </td>

				 <td align="center"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Actualizar Registro" border="null" width="20px" height="20px" class="imgLink" onclick="'.$mod_det.'" />&nbsp;<img src="imagenes/borrar.bmp" alt="Borrar" title="Borrar Registro" border="null" class="imgLink" width="20px" height="20px" onclick="'.$borrar_det.'"/></td>
		 </tr>';
        }?><tr>
		</tr>
	</table>
<?php } ?>
    </div>
        </td>
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
                 <input name="metodo" id="metodo" type="hidden" value="<?php echo $metodo;?>"/>
								 <input name="detalle" id="detalle" type="hidden" value="NO"/>
								 <input name="proced" id="proced" type="hidden" value="<?php echo $proced;?>"/>
                 <input name="proced2" id="proced2" type="hidden" value="<?php echo $proced2;?>"/>
</div>
</form>
<br />
<div align="center">
</div>
<script type="text/javascript">
var input01  = new Spry.Widget.ValidationTextField("input01", "none", {validateOn:["blur", "change"]});
var input02  = new Spry.Widget.ValidationTextField("input02", "none", {validateOn:["blur", "change"]});
var input03  = new Spry.Widget.ValidationTextField("input03", "none", {validateOn:["blur", "change"]});

</script>
