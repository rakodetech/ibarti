<?php
$Nmenu = '427';
$mod  = $_GET['mod'];
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report.php');
$bd = new DataBase();
$titulo = 'ASISTENCIA ONLINE ';
?>
<script language="javascript">


function Nomina(codigo, archivo, contenido){
	var error = 0;
  var errorMessage = ' ';
  var usuario = $("#usuario").val();
	if(codigo == ""){
    var errorMessage = ' Debe Seleccionar una Nomina ';
		var error      = error+1;
	}
	if(error == 0){
		 $("#listar").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
	  var parametros = {"codigo": codigo, "usuario" : usuario
										 };
				$.ajax({
						data:  parametros,
						url:   archivo,
						type:  'post',
						success:  function (response) {
						$("#"+contenido+"").html(response);
						$("#listar").html("");
						Fecha();

						},
					error: function (xhr, ajaxOptions, thrownError) {
       				alert(xhr.status);
        			alert(thrownError);}
				});
		}else{
			alert(errorMessage);
		}
}



function Procesar(metodo){

	// alert(metodo);
	var usuario = $("#usuario").val();
	var asistencia  = $("#asistencia").val();
	var co_cont      = $("#co_cont").val();
	var rol          = $("#rol").val();
	var cod_apertura = $("#cod_apertura").val();
	var cliente      = $("#cliente").val();
	var ubicacion    = $("#ubicacion").val();
	var Nmenu        = $("#Nmenu").val();
	var mod          = $("#mod").val();

	var error = 0;
  var errorMessage = ' ';

	if(co_cont == ""){
    var errorMessage = ' Debe Seleccionar un contrato ';
	var error      = error+1;
	}

		if(cod_apertura == ""){
	    var errorMessage = ' Debe Seleccionar una Fecha ';
		var error      = error+1;
		}

	if(error == 0){
	$("#form_data").submit();

/*
$("#listar").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
var parametros = {"asistencia": asistencia, "usuario" : usuario
								};
	 $.ajax({
			 data:  parametros,
			 url:   'scripts/sc_asistencia_online.php',
			 type:  'post',
			 success:  function (response) {
			 $("#select03").html(response);
			 $("#listar").html("");
			 },
		 error: function (xhr, ajaxOptions, thrownError) {
				 alert(xhr.status);
				 alert(thrownError);}
	 });

*/
		}else{
			alert(errorMessage);
		}


}

function Fecha(){
	var error = 0;
  var errorMessage = ' ';
	var codigo = $("#co_cont").val();
  var usuario = $("#usuario").val();

	if(error == 0){
		 $("#listar").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
	  var parametros = {"codigo": codigo, "usuario" : usuario
										 };
				$.ajax({
						data:  parametros,
						url:   'ajax/Add_as_online_fecha_abiertas.php',
						type:  'post',
						success:  function (response) {
						$("#select03").html(response);
						$("#listar").html("");
						},
					error: function (xhr, ajaxOptions, thrownError) {
       				alert(xhr.status);
        			alert(thrownError);}
				});
		}else{
			alert(errorMessage);
		}
}

function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //
	var co_cont      = $("#co_cont").val();
	var rol          = $("#rol").val();
	var cod_apertura = $("#cod_apertura").val();
	var cliente      = $("#cliente").val();
	var ubicacion    = $("#ubicacion").val();
	var usuario      = $("#usuario").val();
	var Nmenu        = $("#Nmenu").val();
	var mod          = $("#mod").val();

	var error = 0;
  var errorMessage = ' ';

	if(co_cont == ""){
    var errorMessage = ' Debe Seleccionar un contrato ';
	var error      = error+1;
	}

		if(cod_apertura == ""){
	    var errorMessage = ' Debe Seleccionar una Fecha ';
		var error      = error+1;
		}

	if(error == 0){
	 	 $("#img_actualizar").remove();
		 $("#listar").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");

	var contenido = "Contenedor01";
	  var parametros = {"co_cont": co_cont,  "rol": rol,
						          "cliente": cliente,  "ubicacion": ubicacion,
					          	"cod_apertura": cod_apertura,
											"usuario": usuario,
											"Nmenu":Nmenu, "mod":mod
				};
				$.ajax({
						data:  parametros,
						url:   'formularios/Cons_asistencia_online_det.php',
						type:  'post',
						success:  function (response) {
						$("#listar").html(response);
						$("#divX").css("display", "block");
						$("#cont_img").html("<img class='imgLink' id='img_actualizar' src='imagenes/actualizar.png' border='0'                               onclick='Add_filtroX()'>");
						// document.form_reportes.submit();
						},
					error: function (xhr, ajaxOptions, thrownError) {
       				alert(xhr.status);
        			alert(thrownError);}
				});
		}else{
			$("#divX").css("display", "none");
			alert(errorMessage);
		}
}


function Capta_huella_cl(codigo){
	var error = 0;

	if(error == 0){
		 $("#listar").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
	  var parametros = {"cod": codigo};
				$.ajax({
						data:  parametros,
						url:   'ajax/Add_capta_huella_ubic.php',
						type:  'post',
						success:  function (response) {
						$("#contenido_ubic").html(response);
						$("#listar").html("");
						},
					error: function (xhr, ajaxOptions, thrownError) {
       				alert(xhr.status);
        			alert(thrownError);}
				});
		}
}

</script>
<div align="center" class="etiqueta_title"> GENERAR <?php echo $titulo;?> </div>
<div id="Contendor01" class="mensaje"></div>
<hr /><form name="form_reportes" id="form_reportes"  method="post">
	<table width="100%">
		<tr>
		<td width="10%" class="etiqueta"><?php echo $leng['nomina']?>: </td>
			<td width="20%" id="select01"><select  id="co_cont" style="width:150px;"n
				 onchange="Nomina(this.value, 'ajax/Add_as_online_rol.php', 'select02')"  >
					<option value="">Seleccione...</option>
					<?php
				$sql03 = "SELECT contractos.codigo, contractos.descripcion AS contracto
                            FROM usuario_roles , trab_roles, ficha , contractos
			               WHERE usuario_roles.cod_usuario = '$usuario'
			                 AND usuario_roles.cod_rol = trab_roles.cod_rol
				             AND trab_roles.cod_ficha = ficha.cod_ficha
				             AND ficha.cod_contracto = contractos.codigo
			            GROUP BY contractos.codigo
			            ORDER BY 2 ASC";
	   			$query03 = $bd->consultar($sql03);
		 		while($row03=$bd->obtener_fila($query03,0)){
					 echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
			   }?></select></td>

				 <td width="10%" class="etiqueta">Fecha: </td>
				  <td width="20%" id="select03"><select name="cod_apertura" id="cod_apertura" style="width:150px">
				 						<option value="">Seleccione...</option></select>
				  </td>

			<td width="10%" class="etiqueta" ><?php echo $leng['rol']?>: </td>
			<td width="20%" id="select02"><select id="rol" style="width:120px;">
																		<option value="TODOS">TODOS</option>
																		</select>&nbsp;&nbsp;</td>

    <td width="10%" id="cont_img"><img class="imgLink" id="img_actualizar" src="imagenes/actualizar.png" border="0"
                                  onclick="Add_filtroX()" ></td>
</tr>

<tr>
	<td class="etiqueta" > <?php echo $leng['cliente']?>: </td>
	<td><select id="cliente" style="width:120px;" onchange="Capta_huella_cl(this.value)">
	            <option value="TODOS">TODOS</option>
<?php
			$query03 = $bd->consultar($sql_cliente_ch);
				while($row03=$bd->obtener_fila($query03,0)){
					 echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
			   }?></select>&nbsp;&nbsp;</td>
			<td class="etiqueta"><?php echo $leng['ubicacion']?>: </td>
			<td id="contenido_ubic"><select name="ubicacion" id="ubicacion" style="width:120px;">
					                        <option value="TODOS">TODOS</option>
                                    </select></td>


		<td colspan="2"><div id="divX" style="display:none;"><span class="art-button-wrapper">
            <span class="art-button-l"> </span>
            <span class="art-button-r"> </span>
            <input  type="button" name="procesar" id="procesar" onclick="Procesar(this.id)" value="Procesar" class="readon art-button">
        </span>
				<span class="art-button-wrapper">
								<span class="art-button-l"> </span>
								<span class="art-button-r"> </span>
								<input  type="butto" name="procesar" id="desprocesar" onclick="Procesar(this.id)" value="Desprocesar" class="readon art-button">
						</span><div></td>
</tr>
</table>



</form>


<hr /><div id="listar"><table width="98%" border="0" align="center">
		<tr class="fondo00">
            <th width="8%" class="etiqueta"><?php echo $leng['ficha']?></th>
            <th width="30%" class="etiqueta"><?php echo $leng['trabajador']?></th>
			      <th width="20%" class="etiqueta"><?php echo $leng['cliente']?></th>
   		    	<th width="20%" class="etiqueta"><?php echo $leng['ubicacion']?></th>
			      <th width="14%" class="etiqueta">Horario</th>
            <th width="8%" class="etiqueta">Ckeck</th>
		</tr></table></div>
      <input type="hidden" id="usuario" value="<?php echo $usuario;?>"/>
			<input type="hidden" id="Nmenu" value="<?php echo $Nmenu;?>"/>
			<input type="hidden" id="mod" value="<?php echo $mod;?>"/>


<div align="center"><br/>
        <span class="art-button-wrapper">
            <span class="art-button-l"> </span>
            <span class="art-button-r"> </span>
        <input type="button" name="salir" id="salir" value="Salir" onclick="Vinculo('inicio.php?area=formularios/index')"
               class="readon art-button">
        </span>&nbsp;
		

        <input type="submit" name="procesar" id="procesar" hidden="hidden">
		<input type="text" name="reporte" id="reporte" hidden="hidden">
									
		<img class="imgLink" id="img_pdf" src="imagenes/pdf.gif" border="0"
		onclick="{$('#reporte').val('pdf');$('#procesar').click();}" width="25px" title="imprimir a pdf">

		<img class="imgLink" id="img_excel" src="imagenes/excel.gif" border="0"
		onclick="{$('#reporte').val('excel');$('#procesar').click();}" width="25px" title="imprimir a excel">

</div>