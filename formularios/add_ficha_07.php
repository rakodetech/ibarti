<?php
//	require_once('autentificacion/aut_verifica_menu.php');
	$proced      = "p_fichas_07";
    $metodo    = "agregar";
//	$archivo = "pestanas/add_ficha&Nmenu=".$Nmenu."&codigo=".$codigo."&mod=$mod&pagina=2&metodo=modificar";




	$sql01 =	"SELECT  IFNULL((SELECT ADDDATE((b.fec_fin), INTERVAL 1 DAY) FROM ficha_historial b WHERE b.codigo = MAX(ficha_historial.codigo)), ficha.fec_ingreso) AS fec_inicio
	             FROM ficha LEFT JOIN  ficha_historial  ON ficha.cod_ficha = ficha_historial.cod_ficha
	            WHERE ficha.cod_ficha = '$codigo' ";
	$query = $bd->consultar($sql01);
	$datos=$bd->obtener_fila($query,0);
	$fec_inicio = conversion($datos[0]);

   $sql01 =	"SELECT ficha_historial.codigo,
                    ficha_historial.fec_inicio, ficha_historial.fec_fin,
                    ficha_n_contracto.descripcion AS contrato, ficha_historial.fec_us_ing,
                    CONCAT(men_usuarios.apellido,' ', men_usuarios.nombre) AS usuario, ficha_historial.observacion
               FROM ficha_historial
							  LEFT JOIN men_usuarios ON ficha_historial.cod_us_ing = men_usuarios.codigo ,
                     ficha_n_contracto
               WHERE ficha_historial.cod_ficha =  '$codigo'
                 AND ficha_historial.cod_n_contrato = ficha_n_contracto.codigo
								 ORDER BY codigo DESC  ";
      ?>
<script language="javascript">

function Historial(metodo){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //

	var codigo           = $( "#codigo_hist").val();
	var cod_ficha        = $( "#codigo").val();
	var fecha            = $( "#fecha_hist").val();
	var contrato         = $( "#contrato_hist").val();
	var observacion      = $( "#observacion_hist").val();
	var Nmenu       = $( "#Nmenu").val();
	var mod         = $( "#mod").val();
	var archivo     = $( "#archivo").val();
	var usuario     = $( "#usuario").val();

	var error = 0;
  var errorMessage = ' ';

if(contrato == '') {
var error = error+1;
 errorMessage = errorMessage + ' \n Debe Seleccionar un contrato ';
}
 if(observacion == '') {
	 var error = error+1;
	  errorMessage = errorMessage + ' \n Debe Ingresar una observacion ';
	}

	if(error == 0){


	  var parametros = {
						"codigo" : codigo,  			  "cod_ficha" : cod_ficha,
						"fecha" : fecha,						"observacion" : observacion,
						"contrato" : contrato,			"metodo" : metodo,
						"Nmenu" : Nmenu,						"mod" : mod,
						"archivo": archivo,					"usuario": usuario,
						"proced": 'p_fichas_07'
				};
				$.ajax({
						data:  parametros,
						url:   'scripts/sc_ficha_07.php',
						type:  'post',
						beforeSend: function () {
							$("#button_historial").remove();
							$("#cont_button_07").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
							},
						success:  function (response) {
								location.reload();
						},

					error: function (xhr, ajaxOptions, thrownError) {
       				alert(xhr.status);
        			alert(thrownError);}
				});

		}else{
			alert(errorMessage);
		}
}

</script>
<div align="center" class="etiqueta_title"> HISTORIAL DE CONTRATO</div>
<hr />
<div id="Contenedor07"  class="mensaje"></div>
<form id="add_07" name="add_07" action="scripts/sc_ficha_07.php" method="post">
	<table width="100%" border="0" align="center">
		<tr>
			<td width="15%" class="etiqueta">Fecha Inicio </td>
			<td width="30%" class="etiqueta" id="fecha01_7"><input type="text" name="fecha_hist" id="fecha_hist" size="12" value="<?php echo $fec_inicio;?>" /></td>
			<td width="15%" class="etiqueta">Contrato</td>
			<td width="30%" class="etiqueta" id="select01_7"><select name="contrato_hist" id="contrato_hist" style="width:150px">
							<option value="">Seleccione...</option>
					<?php // 	$sql = " SELECT codigo, descripcion FROM parentescos WHERE status = 'T' ORDER BY 2 ASC ";
								$query = $bd->consultar($sql_n_contracto);
								while($datos=$bd->obtener_fila($query,0)){
			?>
					<option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
					<?php }?>
				</select> </td>
		   <td width="10%"><img src="imagenes/loading2.gif"  width="20" height="20" title="" border="null"/></th>
	</tr>
	<tr>
			<td class="etiqueta">Observación</td>
		<td colspan="2" class="etiqueta" id="textarea01_7" ><textarea name="observacion_hist" id="observacion_hist" cols="60" rows="1"></textarea>  </td>
		 <td width="10%"><span class="art-button-wrapper">
									 <span class="art-button-l"> </span>
									 <span class="art-button-r"> </span>
									 	<id="cont_button_07"><input type="button" name="submit" id="button_historial" value="Ingresar" onclick="Historial('agregar')"  class="readon art-button"  /> </span>
							<input type="hidden" name="codigo_hist" id="codigo_hist" value="0"   />
							 </span></th>
</tr>
</table>
<hr />

<table width="100%" border="0" align="center">
<tr class="fondo00">
	<th width="20%" class="etiqueta">Fecha </th>
	<th width="20%" class="etiqueta">Cotrato </th>
	<th width="32%" class="etiqueta">Observacion</th>
	<th width="28%" class="etiqueta">Usuario Ingreso </th>
</tr>
    <?php
        $query = $bd->consultar($sql01);
        $i =0;
        $valor = 0;
  		while($datos=$bd->obtener_fila($query,0)){
		$i++;
			if ($valor == 0){
				$fondo = 'fondo01';
				$valor = 1;
			}else{
				 $fondo = 'fondo02';
				 $valor = 0;
			}
        $us_ing =  $datos['fec_us_ing']." - ".$datos['usuario'];

			$borrar = 	 "'".$datos[0]."'";
        echo '<tr class="'.$fondo.'">
									<td>'.conversion($datos['fec_inicio']).' al '.conversion($datos['fec_fin']).' </td>
									<td>'.longitud($datos['contrato']).'</td>
				  				<td>'.$datos['observacion'].'</td>
           	      <td>'.longitudMax($us_ing).'<td>
								</tr>';
        }
	?>
	</table>
	 <input name="href" type="hidden" value="../inicio.php?area=<?php echo $archivo ?>"/>
    <input name="metodo" type="hidden"  value="<?php echo $metodo;?>" />
    <input name="proced" id="proced" type="hidden"  value="<?php echo $proced;?>" />
    <input name="pestana" type="hidden"  value="familia" />
	<input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario;?>"/>
	<input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo;?>"/>
	<input type="hidden"  id="i" value="<?php echo $i;?>"/>
</form>
<br/>
<br />
<script language="javascript" type="text/javascript">

var select01_7 = new Spry.Widget.ValidationSelect("select01_7", {validateOn:["blur", "change"]});

var fecha01_7 = new Spry.Widget.ValidationTextField("fecha01_7", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA",
    validateOn:["blur", "change"], useCharacterMasking:true});

var textarea01_7 = new Spry.Widget.ValidationTextarea("textarea01_7", {maxChars:255, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess1", useCharacterMasking:false});

</script>
