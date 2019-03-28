<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<?php
	$Nmenu = '422';
	$mod   = $_GET['mod'];

	require_once('autentificacion/aut_verifica_menu.php');
//	require_once('bd/class_mysql2.php');
	require_once('sql/sql_report_t.php');

	$bd   = new DataBase();
//	$bd2  = new DataBase2();
//	$bdp = new DataBaseP();
	$archivo = "reportes/rp_capta_huella_det.php?Nmenu=$Nmenu&mod=$mod";
	$tabla   = "ficha";
	$titulo  = " MARCAJE ONLINE ";
	$proced  = "p_ficha_huella";
	$vinculo = " inicio.php?area=pestanas/add_$archivo&Nmenu=$Nmenu&mod=$mod ";
/*
		$sql_ch = "	SELECT v_ch_identify.codigo,
		                   IFNULL(ficha.cedula, 'SIN CEDULA') cedula ,  IFNULL(ficha.cod_ficha, 'SIN FICHA') ficha,
                       IFNULL(CONCAT(ficha.apellidos,' ',ficha.nombres), 'v_ch_identify.huella') trab_nombre ,
                       v_ch_identify.cod_dispositivo, clientes_ubicacion.descripcion ubicacion,
                       clientes.nombre cliente, v_ch_identify.fechaserver,
                       v_ch_identify.fecha, v_ch_identify.hora
                  FROM v_ch_identify LEFT JOIN ficha ON v_ch_identify.cedula = ficha.cedula AND ficha.cod_ficha_status = 'A',
                       clientes_ub_ch, clientes_ubicacion, clientes
                 WHERE v_ch_identify.cod_dispositivo = clientes_ub_ch.cod_capta_huella
                   AND clientes_ub_ch.cod_cl_ubicacion = clientes_ubicacion.codigo
                   AND clientes_ubicacion.cod_cliente = clientes.codigo
                   AND DATE_FORMAT(v_ch_identify.fecha, '%Y-%m-%d') = CURDATE()
              ORDER BY fecha DESC  ";
		  // WHERE SUBSTR(v_ch_inout_identify.fecha,1,10) = CURRENT_DATE

		$query_ch  = $bd->consultar($sql_ch) or die ("error ch");

		while ($datos_ch=$bd2->obtener_fila($query_ch,0)){
			$codigo      = $datos_ch['codigo'];
			$huella_asc  = $datos_ch['huella_asc'];
			$matris = explode(":", $huella_asc);
			 $ci     = $matris[0];
			 $huella = $matris[1];

			$sql = "SELECT COUNT(cedula) FROM ficha_huella
					       WHERE ficha_huella.cedula = '$ci' AND ficha_huella.huella = '$huella' ";
			$query  = $bd->consultar($sql);
			$datos=$bd->obtener_fila($query,0);
			$cantida    = $datos[0];

			if($cantida ==0){
				$sql = "$SELECT $proced('agregar', '$ci', '$ci', '$huella', '$huella', '$usuario')";
				$query  = $bd->consultar($sql);
			}else{
				$sql = " UPDATE ch_inout2 SET ch_inout2.checks = 'T'  WHERE ch_inout2.codigo = '$codigo' ";
				$query  = $bd2->consultar($sql) or die ("error");
			}
		}
*/
		?>
<script language="JavaScript" type="text/javascript">
function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //

	var fecha_desde  = $("#fecha_desde").val();
	var fecha_hasta  = $("#fecha_hasta").val();
	var cliente      = $("#cliente").val();
	var capta_huella = $("#capta_huella").val();
	var trabajador  = $("#stdID").val();
	var Nmenu       = $("#Nmenu").val();
	var mod         = $("#mod").val();
	var archivo     = $("#archivo").val();

	var error = 0;
    var errorMessage = ' ';

	if( fechaValida(fecha_desde) !=  true || fechaValida(fecha_hasta) != true){
    var errorMessage = ' Campos De Fecha Incorrectas ';
	var error      = error+1;
	}

	if(error == 0){
	 $("#img_actualizar").remove();
	 $("#listar").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
	var contenido = "listar";
	  var parametros = {
						"fecha_desde": fecha_desde,  "fecha_hasta": fecha_hasta,
						"trabajador": trabajador,  	 "capta_huella":capta_huella,
						"cliente":cliente,
						"Nmenu" : Nmenu,  	 		 "mod" : mod,
						"archivo": archivo
				};
				$.ajax({
						data:  parametros,
						url:   'ajax/Add_capta_huella.php',
						type:  'post',

						success:  function (response) {
								$("#listar").html(response);
								$("#cont_img").html("<img class='imgLink' id='img_actualizar' src='imagenes/actualizar.png' border='0'                               onclick='Add_filtroX()'>");

						},
					error: function (xhr, ajaxOptions, thrownError) {
       				alert(xhr.status);
        			alert(thrownError);}
				});
		}else{
			alert(errorMessage);
		}
}

	function Capta_huella_cl(valor){

	if(valor=='') {
	 	var valor = "TODOS";
	}

		var links = "ajax/Add_capta_huella_ubic.php";
		ajax=nuevoAjax();
			ajax.open("POST", links, true);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4){
				  document.getElementById("capta_huella").innerHTML = ajax.responseText;
				}
			}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("cod="+valor+"");
}
</script><div align="center" class="etiqueta_title"> CONSULTA <?php echo $titulo;?> </div>
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>" method="post" target="_blank">
<hr /><table width="100%" class="etiqueta">
		<tr><td width="10%">Fecha Desde:</td>
		 <td width="14%" id="fecha01"><input type="text" name="fecha_desde" id="fecha_desde" size="10"  onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');" value="<?php echo $fecha;?>">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');" border="0" width="17px"></td>
        <td width="10%">Fecha Hasta:</td>
		 <td width="14%" id="fecha02"><input type="text" name="fecha_hasta" id="fecha_hasta" size="10"  onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');" value="<?php echo $fecha ;?>">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');" border="0" width="17px"></td>
            <td width="10%">&nbsp;</td>
			<td width="14%">&nbsp;</td>
         <td width="24%">&nbsp;</td>
                       <!-- <option value="pdf">PDF</option> -->
               </select></td>
      <td width="4%" id="cont_img"><img class="imgLink" id="img_actualizar" src="imagenes/actualizar.png" border="0"
                                        onclick=" Add_filtroX()" ></td>
   </tr>
   <tr>
        <td><?php echo $leng["cliente"];?>:</td>
			<td><select name="cliente" id="cliente" style="width:120px;"onchange="Capta_huella_cl(this.value)">
					    <option value="TODOS">TODOS</option>
					<?php
				$sql01 = "SELECT DISTINCT clientes.codigo, clientes.nombre
		                    FROM clientes, clientes_ubicacion, clientes_ub_ch
                           WHERE clientes.`status` = 'T'
                             AND clientes.codigo = clientes_ubicacion.cod_cliente
                             AND clientes_ubicacion.codigo = clientes_ub_ch.cod_cl_ubicacion
                           ORDER BY 2 ASC";
	   			$query01 = $bd->consultar($sql01);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
      <td class="etiqueta">Capta Huella:</td>
			<td id="contenido_ubic"><select name="capta_huella" id="capta_huella" style="width:120px">
						   <option value="TODOS">Seleccione...</option>
                          </select></td>

                          <td>Filtro <?php echo $leng["trabajador"];?>.:</td>
		<td id="select01">
			<select id="paciFiltro" onchange="EstadoFiltro(this.value)" style="width:120px">
				<option value="TODOS"> TODOS</option>
				<option value="codigo"> <?php echo $leng["ficha"];?> </option>
				<option value="cedula"> <?php echo $leng["ci"];?></option>
				<option value="trabajador"> <?php echo $leng["trabajador"];?> </option>
                <option value="nombres"> Nombre </option>
                <option value="apellidos"> Apellido </option>
		</select></td>
		<td><?php echo $leng["trabajador"];?>:</td>
		<td colspan="2" ><input  id="stdName" type="text" style="width:150px" disabled="disabled" />
         <input type="hidden" name="trabajador" id="stdID" value=""/>
          <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
          <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
            <input type="hidden" name="archivo" id="archivo" value="<?php echo $archivo;?>" /></td>
      </tr>
</table><hr /><div id="listar"><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="12%" class="etiqueta">Fecha</th>
    		<th width="22%" class="etiqueta"><?php echo $leng["cliente"];?></th>
            <th width="26%" class="etiqueta"><?php echo $leng["ubicacion"];?></th>
            <th width="10%" class="etiqueta"><?php echo $leng["ficha"];?></th>
			<th width="30%" class="etiqueta"><?php echo $leng["trabajador"];?></th>
	</tr>
    <?php
	 $valor = 0;


/*
ALTER TABLE `ch_inout2`
MODIFY COLUMN `huella`  varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Huella alfa numerico' AFTER `codigo`;


*/
$sql_ch = "	SELECT v_ch_identify.codigo,
									 IFNULL(ficha.cedula, 'SIN CEDULA') cedula ,  IFNULL(ficha.cod_ficha, 'SIN FICHA') cod_ficha,
									 IFNULL(CONCAT(ficha.apellidos,' ',ficha.nombres), v_ch_identify.huella) ap_nombre ,
									 v_ch_identify.cod_dispositivo, clientes_ubicacion.descripcion ubicacion,
									 clientes.nombre cliente, v_ch_identify.fechaserver,
									 v_ch_identify.fecha, v_ch_identify.hora
							FROM v_ch_identify LEFT JOIN ficha ON v_ch_identify.cedula = ficha.cedula AND ficha.cod_ficha_status = 'A',
									 clientes_ub_ch, clientes_ubicacion, clientes
						 WHERE DATE_FORMAT(v_ch_identify.fecha, '%Y-%m-%d') = CURDATE()
						   AND v_ch_identify.cod_dispositivo = clientes_ub_ch.cod_capta_huella
							 AND clientes_ub_ch.cod_cl_ubicacion = clientes_ubicacion.codigo
							 AND clientes_ubicacion.cod_cliente = clientes.codigo
							 group by ap_nombre
					ORDER BY fecha ASC  ";
//  AND DATE_FORMAT(v_ch_identify.fecha, '%Y-%m-%d') = CURDATE()
		$query_ch  = $bd->consultar($sql_ch) or die ("error ch");
		while ($datos=$bd->obtener_fila($query_ch,0)){

	//		$fecha     = $datos_ch['fecha_dispositivo'];
	//		$huella    = $datos_ch['huella_asc'];
	//		$dispotivo = $datos_ch['cod_dispositivo'];

/*
			$sql01 = "SELECT COUNT(clientes_ub_ch.cod_capta_huella) AS cantidad_ub, IFNULL(clientes.nombre, 'C.H.')  AS cliente,
		                     IFNULL(clientes_ubicacion.descripcion, '$dispotivo') AS ubicacion, ficha_huella.huella AS cantidad_trab,
						     v_ficha.rol, IFNULL(v_ficha.ap_nombre, '$huella') AS ap_nombre,
						     IFNULL(v_ficha.cod_ficha, 'cod_ficha') AS cod_ficha, IFNULL(v_ficha.cedula, 'CI') AS cedula
                        FROM clientes_ub_ch ,  clientes_ubicacion , clientes,
						     ficha_huella, v_ficha
                 	   WHERE clientes_ub_ch.cod_cl_ubicacion =  clientes_ubicacion.codigo
                         AND clientes.codigo = clientes_ubicacion.cod_cliente
					     AND ficha_huella.cedula = v_ficha.cedula
						 AND ficha_huella.huella =  '$huella'
			             AND clientes_ub_ch.cod_capta_huella = '$dispotivo' ";

	   	$query01 = $bd->consultar($sql01);
		$datos = $bd->obtener_fila($query01,0);
*/
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}
	// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'">
                  <td>'.$datos["fecha"].'</td>
				  <td>'.longitudMin($datos["cliente"]).'</td>
				  <td>'.longitud($datos["ubicacion"]).'</td>
				  <td>'.longitud($datos["cod_ficha"]).'</td>
                  <td>'.longitudMax($datos["ap_nombre"]).'</td>
            </tr>';
        }
//	 $bd2->close();
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
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
</form>
<script type="text/javascript">
	filtroId = document.getElementById("paciFiltro");
	filtroIndice = filtroId.selectedIndex;
	filtroValue  = filtroId.options[filtroIndice].value;

    new Autocomplete("stdName", function() {
        this.setValue = function(id) {
            document.getElementById("stdID").value = id;
						 // document.getElementsByName("stdID")[0].value = id;
        }
        if (this.isModified) this.setValue("");
        if (this.value.length < 1) return ;
          return "autocompletar/tb/ficha.php?q="+this.text.value +"&filtro="+filtroValue+""});
</script>
