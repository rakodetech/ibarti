<script language="JavaScript" type="text/javascript">

function Borrar_Campo(cod, fecha_desde, fecha_hasta){
	var proced        = $("#proced").val();
	var usuario       = $("#usuario").val();
	var cliente      = $("#cliente").val();
	var ubicacion    = $("#ubicacion").val();

	if (confirm("� Esta Seguro De Borrar Este Registro?")) {
	 	var valor = "scripts/sc_pl_cliente.php";
		ajax=nuevoAjax();
		ajax.open("POST", valor, true);
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4){
			document.getElementById("Mensaje").innerHTML = ajax.responseText;
			 Planificacion_Det(cliente, ubicacion);
			}
		}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  ajax.send("codigo="+cod+"&periodo=''&fecha_desde="+fecha_desde+"&fecha_hasta="+fecha_hasta+"&cliente=''&ubicacion=''&cargo=''&turno=''&excepcion=''&cantidad=''&usuario="+usuario+"&proced="+proced+"&metodo=borrar");

     } else{
       return false;
    }
}

function Planificacion_Det(cliente, ubicacion){
	var usuario    = $("#usuario").val();
	var valor      = "ajax/Add_pl_cliente.php";

	ajax=nuevoAjax();
	ajax.open("POST", valor, true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			document.getElementById("contenedor_listar").innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("cliente="+cliente+"&ubicacion="+ubicacion+"&usuario="+usuario+"");
}


function Filtrar_ubicacion(idX,  name, Contenedor, px, evento){

		var valor  = "ajax/Add_ubicacion_evento.php";
		var usuario    = $("#usuario").val();

		ajax=nuevoAjax();
		ajax.open("POST", valor, true);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4){
			document.getElementById(Contenedor).innerHTML = ajax.responseText;
			document.getElementById("contenedor_listar").innerHTML = "";
			}
		}

		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("codigo="+idX+"&usuario="+usuario+"&name="+name+"&tamano="+px+"&evento="+evento+"");
	}


function FiltrarCl(){
	var cliente      = $("#cliente").val();
	var ubicacion    = $("#ubicacion").val();
	var error = false;
  var errorMessage = '';

	if(cliente=='') {
		var error = true;
	  var errorMessage = 'Debe Seleccionar el Cliente \n';
	}
	if((ubicacion=='' ) ||(ubicacion=='TODOS' ))  {
	 var error = true;
	 var errorMessage = 'Debe Seleccionar la Ubicacion \n';
	}

	if(error == false){
		Planificacion_Det(cliente, ubicacion);
	}else{
		alert(errorMessage);
	}

}

function Metodo(cod, metodo){

	var usuario    = $("#usuario").val();
	var Contenedor = "contenedor_listar";
	var valor  = "ajax/Add_pl_cliente_mod.php";

	var cliente      = $("#cliente").val();
	var ubicacion    = $("#ubicacion").val();
	var error = false;
  var errorMessage = '';

	if(cliente=='') {
		var error = true;
	  var errorMessage = 'Debe Seleccionar el Cliente \n';
	}
	if((ubicacion=='' ) ||(ubicacion=='TODOS' ))  {
	 var error = true;
	 var errorMessage = 'Debe Seleccionar la Ubicacion \n';
	}

	if(error == false){

		ajax=nuevoAjax();
		ajax.open("POST", valor, true);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4){
			document.getElementById(Contenedor).innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("codigo="+cod+"&usuario="+usuario+"&metodo="+metodo+"");
	}else{
		alert(errorMessage);
	}
}



function ActualizarCl(){

	var Nmenu         = $("#Nmenu").val();
  var mod           = $("#mod").val();
	var proced        = $("#proced").val();
	var metodo        = $("#metodo").val();
	var usuario       = $("#usuario").val();
	var fecha_desde  = $("#fecha_desde").val();
	var fecha_hasta  = $("#fecha_hasta").val();

	var codigo       = $("#codigo").val();
	var periodo      = $("#periodo").val();
	var cliente      = $("#cliente").val();
	var ubicacion    = $("#ubicacion").val();
	var cargo        = $("#cargo").val();
	var turno        = $("#turno").val();
  var excepcion      = $('input[name=excepcion]:checked', '#form_mod').val();
	var cantidad     = $("#cantidad").val();

	var error = false;
  var errorMessage = '';

	if( (fecha_desde ==  "") || (fecha_hasta == "")){
		var errorMessage = errorMessage + 'Campos De Fecha Incorrectas  \n ';
		var error = true;
 }

  if(cliente=='') {
	 var error = true;
	  var errorMessage =  errorMessage + 'Debe Seleccionar el Cliente \n';
	}
	if((ubicacion=='' ) ||(ubicacion=='TODOS' ))  {
	 var error = true;
	 var errorMessage =  errorMessage + 'Debe Seleccionar el Ubicacion \n';
	}

	if (typeof(excepcion) == "undefined"){
		 var errorMessage =  errorMessage + 'Debe Seleccionar Una Excepcion \n';
	 	 var error = true;
	}

	if((cantidad =='') || (cantidad ==0)) {
	 var error = true;
	 var errorMessage =  errorMessage + 'Debe Ingresar Una Cantidad \n';
	}

	if(error == false){

	var valor = "scripts/sc_pl_cliente.php";
		ajax=nuevoAjax();
	ajax.open("POST", valor, true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			document.getElementById("Mensaje").innerHTML = ajax.responseText;
			Planificacion_Det(cliente, ubicacion);
	  	$("#turno").val("");
   		$("#cantidad").val(0);
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  ajax.send("codigo="+codigo+"&periodo="+periodo+"&fecha_desde="+fecha_desde+"&fecha_hasta="+fecha_hasta+"&cliente="+cliente+"&ubicacion="+ubicacion+"&cargo="+cargo+"&turno="+turno+"&excepcion="+excepcion+"&cantidad="+cantidad+"&usuario="+usuario+"&proced="+proced+"&metodo="+metodo+"");
	 }else{
		 alert(errorMessage);
	 }
}
</script>
<?php
	$Nmenu   = '441';
	$mod     = $_GET['mod'];
	$metodo  = $_GET['metodo'];
	$proced  = "p_pl_cliente";
	require_once('autentificacion/aut_verifica_menu.php');

	$href= "formularios/Cons_pl_cliente&Nmenu";

if($metodo == 'modificar'){

	$cod_cliente   = $_GET['cod_cliente'];
	$cod_ubicacion = $_GET['cod_ubicacion'];
}else{
	$cod_cliente   = "";
	$cod_ubicacion = "";
}

$bd = new DataBase();
	$sql04 = "SELECT pl_cliente_apertura.codigo, pl_cliente_apertura.fecha_inicio,
	                 pl_cliente_apertura.fecha_fin, IFNULL(clientes.nombre, 'Seleccione...' ) cliente,
                                                  IFNULL(clientes_ubicacion.descripcion , 'Seleccione...') ubicacion
					    FROM pl_cliente_apertura  LEFT JOIN clientes ON clientes.codigo = '$cod_cliente'
              LEFT JOIN clientes_ubicacion ON clientes_ubicacion.codigo = '$cod_ubicacion'
             WHERE pl_cliente_apertura.`status` = 'T'";

 	$query04 = $bd->consultar($sql04);

	 $row04=$bd->obtener_fila($query04,0);
	 $periodo     = $row04[0];
	 $fec_inicio  = $row04[1];
	 $fec_fin     = $row04[2];
	 $cliente     = $row04[3];
 	 $ubicacion   = $row04[4];

$SQL_PAG = "SELECT pl_cliente.*, cargos.descripcion cargo, turno.descripcion turno
		          FROM pl_cliente_apertura, pl_cliente, cargos, turno
					   WHERE pl_cliente_apertura.`status` = 'T'
						   AND pl_cliente_apertura.codigo = pl_cliente.cod_apertura
		           AND pl_cliente.cod_cliente   = '$cod_cliente'
							 AND pl_cliente.cod_ubicacion = '$cod_ubicacion'
		           AND pl_cliente.cod_cargo = cargos.codigo
		           AND pl_cliente.cod_turno = turno.codigo
		     		 ORDER BY 1 ASC ";

	$sql_cliente = "SELECT clientes_ubicacion.cod_cliente, clientes.nombre AS cliente
				      FROM usuario_clientes ,  clientes_ubicacion , clientes
			         WHERE usuario_clientes.cod_usuario = '$usuario'
				       AND usuario_clientes.cod_ubicacion = clientes_ubicacion.codigo
				       AND clientes_ubicacion.`status` = 'T'
				       AND clientes_ubicacion.cod_cliente = clientes.codigo
							  AND clientes_ubicacion.cod_cliente != '$cod_cliente'
				       AND clientes.`status` = 'T'
			      GROUP BY clientes_ubicacion.cod_cliente
			      ORDER BY 2 ASC";

	$sql_ubicacion = "SELECT usuario_clientes.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion
											FROM usuario_clientes , clientes_ubicacion
										 WHERE usuario_clientes.cod_usuario = '$usuario'
											 AND usuario_clientes.cod_ubicacion = clientes_ubicacion.codigo
											 AND clientes_ubicacion.cod_cliente = '$cod_cliente'
											 AND clientes_ubicacion.codigo != '$cod_ubicacion'
											 AND clientes_ubicacion.`status` = 'T'
									ORDER BY 2 ASC ";

		$sql_cargo = "SELECT cargos.codigo, cargos.descripcion FROM cargos
									 WHERE cargos.`status` = 'T'
							  ORDER BY 2 ASC";

		$sql_turno = "SELECT turno.codigo, turno.descripcion FROM turno
	           WHERE turno.`status` = 'T'
			     ORDER BY 2 ASC";

$title = "Planificacion de Cliente, Periodo ($periodo), Desde :".conversion($fec_inicio).", Hasta ".conversion($fec_fin)."";
		?>
<div align="center" class="etiqueta_title"> <?php echo $title?></div>
<div id="Mensaje" class="mensaje"></div>
<hr />
	<table width="98%">
		<tr><td width="15%" class="etiqueta"><?php echo $leng["cliente"];?>: </td>
			 <td width="25%"><select  id="cliente" name="cliente" style="width:180px;"
				 onchange="Filtrar_ubicacion(this.value,'ubicacion', 'ubicacionX', '180px', 'FiltrarCl()')">
					<option value="<?php echo $cod_cliente?>"><?php echo $cliente; ?></option>
					<?php

	   			$query03 = $bd->consultar($sql_cliente);
		 		while($row03=$bd->obtener_fila($query03,0)){
					 echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
			   }?></select></td>
				 <td width="15%" class="etiqueta"><?php echo $leng["ubicacion"];?>: </td>
				 	 <td width="25%" id="ubicacionX"><select  id="ubicacion" name="ubicacion" style="width:180px;" onchange="FiltrarCl()">
                           <option value="<?php echo $cod_ubicacion;?>"><?php echo $ubicacion;?></option>
				 			<?php

				 			$query03 = $bd->consultar($sql_ubicacion);
				 		while($row03=$bd->obtener_fila($query03,0)){
				 			 echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
				 		 }?></select></td>
						 <td align="center">
						 	<img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" onClick="Metodo('','agregar')" class="imgLink" width="20px" height="20px" border="null"/>
						 	<img src="imagenes/detalle.bmp" alt="Detalle" title="Detalle Registro" onclick="FiltrarCl()" class="imgLink" width="20px" height="20px" border="null"/>
							<input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario;?>"/>
							<input type="hidden" name="proced" id="proced" value="<?php echo $proced ;?>"/>
							 </span></td>

</tr>
</table>
<form id="form_01" name="form_01" action="" method="post">
<table width="100%" border="0" align="center">

<tr class="fondo00">
	<th width="20%" class="etiqueta">Cargo</th>
	<th width="20%" class="etiqueta">Turno</th>
	<th width="14%" class="etiqueta">Excepcion</th>
	<th width="14%" class="etiqueta">Fecha Incio</th>
	<th width="14%" class="etiqueta">Fecha Fin</th>
	<th width="12%" class="etiqueta">Servicios</th>
	<th width="6%"><img src="imagenes/loading2.gif" width="15px" height="15px"/></th>
</tr>
</table>
</form>
<div id="listar"><div id="contenedor_listar"><table width="100%" border="0" align="center">
	<?php
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
		echo'<tr class="'.$fondo.'">
						<td width="23%" class="texto">'.longitud($datos["cargo"]).'</td>
						<td width="23%" class="texto">'.longitud($datos["turno"]).'</td>
						<td width="14%" class="texto">'.valorF($datos["excepcion"]).'</td>
						<td width="12%" class="texto">'.$datos["fecha_inicio"].'</td>
						<td width="12%" class="texto">'.$datos["fecha_fin"].'</td>
						<td width="10%" class="texto">'.$datos["cantidad"].'</td>
						<td width="6%" align="center"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Modificar Registro"
						    border="null" width="20px" height="20px" class="imgLink"  onclick="Metodo(\''.$datos["codigo"].'\', \'modificar\')"
							  />&nbsp;<img src="imagenes/borrar.bmp" alt="Borrar" title="Borrar Registro"  class="imgLink"
							  width="20px" height="20px" onclick="Borrar_Campo(\''.$datos["codigo"].'\', \''.$datos["fecha_inicio"].'\', \''.$datos["fecha_fin"].'\')"/></td>
					</tr>'; }?>

	</table></div></div>
<div align="center"><br/>
	<span class="art-button-wrapper">
				 <span class="art-button-l"> </span>
				 <span class="art-button-r"> </span>
		 <input type="button" id="volver" value="Volver" onClick="history.back(-1);" class="readon art-button" />
		 </span>
		</div>
