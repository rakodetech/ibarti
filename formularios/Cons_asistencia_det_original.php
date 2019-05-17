<script language="JavaScript" type="text/javascript">
function Actualizar01(idX, campo01){
var Contenedor = "ubicacionX"+campo01+"";
var usuario = document.getElementById('usuario').value;
var valor = "ajax/add_ubicacion.php"; 
		ajax=nuevoAjax();
			ajax.open("POST", valor, true);
			ajax.onreadystatechange=function(){ 
				if (ajax.readyState==4){
		        document.getElementById(Contenedor).innerHTML = ajax.responseText;
				// window.location.reload();				
				} 
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("codigo="+idX+"&usuario="+usuario+"&i="+campo01+"");
	}
	
function Actualizar02(idX){
var Contenedor = "ubicacionX";

var valor  = "ajax/add_ubicacion.php"; 
var usuario = document.getElementById('usuario').value;
		ajax=nuevoAjax();
			ajax.open("POST", valor, true);
			ajax.onreadystatechange=function()  
			{ 
				if (ajax.readyState==4){					
		        document.getElementById(Contenedor).innerHTML = ajax.responseText;
				//window.location.href=""+href+"";
				}
			} 
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("codigo="+idX+"&usuario="+usuario+"&i=");
}
					
function Replicar(){	
	if (confirm("¿ Esta Seguro Replicar La Informacion Con EL Dia Anterior ?")) {
	var valor     = "scripts/sc_asistencia_proc.php";
	var apertura  = document.getElementById("apertura").value;	
	var rol       = document.getElementById("rol").value;
	var contracto = document.getElementById("contracto").value;
	var usuario   = document.getElementById("usuario").value;

	ajax=nuevoAjax();
	ajax.open("POST", valor, true);
		ajax.onreadystatechange=function(){ 
			if (ajax.readyState==4){
			document.getElementById("Contendor01").innerHTML = ajax.responseText;
			setInterval(alert(""+document.getElementById("mensaje_aj").value+""), Reload(), 1000);
			}
		} 
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("apertura="+apertura+"&rol="+rol+"&contracto="+contracto+"&usuario="+usuario+"&metodo=replicar&proced=p_asistecia_proc&href=");	
     } else{
       return false;
    }
}	

function ValidarSubmit(auto){
	var apertura      = document.getElementById("apertura").value;	
	var contracto     = document.getElementById("contracto").value;
	var usuario       = document.getElementById("usuario").value;
	var proced        = document.getElementById("proced").value;
	var trab          = document.getElementById("trabajadores"+auto+"").value;
	var trab_old      = document.getElementById("trabajadores_old"+auto+"").value;		
	var cliente       = document.getElementById("cliente"+auto+"").value;
	var ubicacion     = document.getElementById("ubicacion"+auto+"").value;
	var ubicacion_old = document.getElementById("ubicacion_old"+auto+"").value;
	var concepto      = document.getElementById("concepto"+auto+"").value;
	var concepto_old  = document.getElementById("concepto_old"+auto+"").value;
	var horaS         = document.getElementById("horaS"+auto+"").value;	
	var vale          = document.getElementById("vale"+auto+"").value;		
	var campo01 = 1; 
 //alert(concepto+concepto_old); 		

	 var errorMessage = 'Debe Seleccionar Todo Los Campos';

     if(ubicacion=='') {
	 var campo01 = campo01+1; 
     }  

	if(campo01 == 1){
		var valor = "scripts/sc_asistencia.php"; 
		ajax=nuevoAjax();
	ajax.open("POST", valor, true);
	ajax.onreadystatechange=function(){ 
		if (ajax.readyState==4){
		document.getElementById("Contendor01").innerHTML = ajax.responseText;		
		//window.location.href=""+href+"";									 	
		}
	} 
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

ajax.send("apertura="+apertura+"&contracto="+contracto+"&trabajador="+trab+"&trabajador_old="+trab_old+"&cliente="+cliente+"&ubicacion="+ubicacion+"&ubicacion_old="+ubicacion_old+"&concepto="+concepto+"&concepto_old="+concepto_old+"&horaS="+horaS+"&vale="+vale+"&href=&usuario="+usuario+"&proced="+proced+"&metodo=modificar");

	 }else{
	alert(errorMessage);
	 }
}


function Ingresar(){		
	var apertura      = document.getElementById("apertura").value;	
	var contracto     = document.getElementById("contracto").value;
	var usuario       = document.getElementById("usuario").value;
	var proced        = document.getElementById("proced").value;
	var trab          = document.getElementById("trabajador").value;
	var cliente       = document.getElementById("cliente").value;
	var ubicacion     = document.getElementById("ubicacion").value;
	var concepto      = document.getElementById("concepto").value;
	var horaS         = document.getElementById("horaS").value;	
	var vale          = document.getElementById("vale").value;		
	var campo01 = 1; 
    var errorMessage = 'Debe Seleccionar Todo Los Campos';

     if(trab=='') {
	 var campo01 = campo01+1; 
	}  
     if(cliente=='') {
	 var campo01 = campo01+1; 
	}  
     if(ubicacion=='') {
	 var campo01 = campo01+1; 
	}  
     if(concepto=='') {
	 var campo01 = campo01+1; 
	}  

	if(campo01 == 1){
		var valor = "scripts/sc_asistencia.php"; 
		ajax=nuevoAjax();
	ajax.open("POST", valor, true);
	ajax.onreadystatechange=function(){ 
		if (ajax.readyState==4){
		document.getElementById("Contendor01").innerHTML = ajax.responseText;		
		 window.location.reload();										 	
		}
	} 
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

ajax.send("apertura="+apertura+"&contracto="+contracto+"&trabajador="+trab+"&trabajador_old=&cliente="+cliente+"&ubicacion="+ubicacion+"&ubicacion_old=&concepto="+concepto+"&concepto_old=&horaS="+horaS+"&vale="+vale+"&href=&usuario="+usuario+"&proced="+proced+"&metodo=agregar");
	 }else{
	alert(errorMessage);
	 }
}
	function Borrar_Campo(auto){

	if (confirm("¿ Esta Seguro De Borrar Este Registro?")) {
		var apertura      = document.getElementById("apertura").value;	
		var usuario       = document.getElementById("usuario").value;
		var trab_old      = document.getElementById("trabajadores_old"+auto+"").value;
     	var ubicacion_old = document.getElementById("ubicacion_old"+auto+"").value;		
		var concepto_old  = document.getElementById("concepto_old"+auto+"").value;
		var proced  = document.getElementById("proced").value;
		var valor = "scripts/sc_asistencia.php"; 
		ajax=nuevoAjax();
			ajax.open("POST", valor, true);
			ajax.onreadystatechange=function() { 
				if (ajax.readyState==4){
				  document.getElementById("Contendor01").innerHTML = ajax.responseText;
				 window.location.reload();
				}
			} 
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
ajax.send("apertura="+apertura+"&contracto=''&trabajador=''&trabajador_old="+trab_old+"&cliente=''&ubicacion=''&ubicacion_old="+ubicacion_old+"&concepto=''&concepto_old="+concepto_old+"&horaS=''&vale=''&href=''&usuario="+usuario+"&proced="+proced+"&metodo=borrar");			
     } else{
       return false;
    }
}

function CerrarDia(){
	if (confirm("¿ Esta Seguro De Cerrar Este Fecha?")) {

	var valor     = "scripts/sc_asistencia_proc.php";
	var apertura  = document.getElementById("apertura").value;	
	var rol       = document.getElementById("rol").value;
	var contracto = document.getElementById("contracto").value;
	var usuario   = document.getElementById("usuario").value;

	ajax=nuevoAjax();
	ajax.open("POST", valor, true);
		ajax.onreadystatechange=function(){ 
			if (ajax.readyState==4){
			document.getElementById("Contendor01").innerHTML = ajax.responseText;
			setInterval(alert(""+document.getElementById("mensaje_aj").value+""), Reload(), 1000);
			}
		} 
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("apertura="+apertura+"&rol="+rol+"&contracto="+contracto+"&usuario="+usuario+"&metodo=cerrar_as&proced=p_asistecia_proc&href=");	
     } else{
       return false;
    }
}	

function TrabReportar(){
	if (confirm("¿ Esta Seguro De Cerrar Este Fecha?")) {

	var valor     = "scripts/sc_asistencia_proc.php";
	var apertura  = document.getElementById("apertura").value;	
	var rol       = document.getElementById("rol").value;
	var contracto = document.getElementById("contracto").value;
	var usuario   = document.getElementById("usuario").value;

	ajax=nuevoAjax();
	ajax.open("POST", valor, true);
		ajax.onreadystatechange=function(){ 
			if (ajax.readyState==4){
			document.getElementById("Contendor01").innerHTML = ajax.responseText;
			setInterval(alert(""+document.getElementById("mensaje_aj").value+""), Reload(), 1000);
			}
		} 
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("apertura="+apertura+"&rol="+rol+"&contracto="+contracto+"&usuario="+usuario+"&metodo=trab_reportar&proced=p_asistecia_proc&href=");	
     } else{
       return false;
    }
}	

function FiltarRol(ValorN){
	var contracto = document.getElementById("contracto").value;	
	var Nmenu = document.getElementById("Nmenu").value;
	var href = "inicio.php?area=formularios/Cons_asistencia&Nmenu="+Nmenu+"&co_cont="+contracto+"&rol="+ValorN+"";
	window.location.href=""+href+"";		
//	alert(href);
}				

function FiltarNomina(ValorN){
	var rol = document.getElementById("rol").value;	
	var Nmenu = document.getElementById("Nmenu").value;
	var href = "inicio.php?area=formularios/Cons_asistencia&Nmenu="+Nmenu+"&co_cont="+ValorN+"&rol="+rol+"";
	window.location.href=""+href+"";		
	//alert(href);
}		
</script>
<?php 	
$Nmenu = '405'; 
require_once('autentificacion/aut_verifica_menu.php');
$co_cont     = $_POST['co_cont'];
$cod_rol     = $_POST['rol'];

$href= "formularios/Cons_asistencia&Nmenu=$Nmenu&co_cont=$co_cont&rol=$cod_rol";

if (!isset($co_cont) || !isset($cod_rol) ){
exit();
}		

$bd = new DataBase();			
	$sql04 = "SELECT Min(asistencia_apertura.fec_diaria) AS fec_diaria, asistencia_apertura.fec_cierre,
					 asistencia_apertura.codigo, contractos.descripcion AS contracto, roles.descripcion AS rol
				FROM asistencia_apertura , asistencia_cierre , contractos, roles
			   WHERE asistencia_apertura.`status` = 'T' 
				 AND asistencia_apertura.cod_contracto = '$co_cont' 
				 AND asistencia_apertura.cod_contracto = asistencia_cierre.cod_contracto 
				 AND asistencia_cierre.cod_rol = '$cod_rol'
				 AND asistencia_apertura.codigo = asistencia_cierre.cod_as_apertura 
				 AND asistencia_cierre.`status` = 'T'
				 AND asistencia_apertura.cod_contracto = contractos.codigo
				 AND roles.codigo = '$cod_rol'";
	   $query04 = $bd->consultar($sql04);

	 $row04=$bd->obtener_fila($query04,0);											
	 $fec_nomina  = $row04['fec_cierre'];
	 $fec_diaria  = $row04['fec_diaria'];
     $contracto   = $row04['contracto'];
	 $roles   = $row04['rol'];
	 $cod_apertura = $row04['codigo'];
	if ($fec_diaria == '' ){
	mensajeria("No Hay Fecha Activa Para Este Contracto");	
	exit();
	}	

	  $fecha_N = explode("-", $fec_diaria);
			$year2   = $fecha_N[0]; 
			$mes2    = $fecha_N[1]; 
			$dia2    = $fecha_N[2];
	   $fecha_x    = mktime(0,0,0,$mes2,$dia2,$year2);
	   $fech_LV  = date("w", $fecha_x); 

//////  SQL CLIENTES Y NOMINA    //////////

 		 $SQL_TRAB = "SELECT ficha.cod_ficha, CONCAT( preingreso.apellidos,' ', preingreso.nombres) AS nombres, 
		                     ficha.cedula
                       FROM  ficha , control, preingreso, trab_roles
                       WHERE ficha.cod_ficha_status = ficha_activo
                         AND ficha.cedula        = preingreso.cedula                         
                         AND ficha.cod_ficha     = trab_roles.cod_ficha
                         AND trab_roles.cod_rol  =  '$cod_rol' 
						 AND ficha.cod_contracto = '$co_cont'
					ORDER BY 2 ASC ";						 

	// $optionN = '<option value="'.$region.'">'.$row02[1].'</option><option value="TODAS">TODAS</option>';
	$SQL_PAG = "SELECT asistencia.cod_ficha, ficha.cedula, 
					   CONCAT(preingreso.apellidos, ' ', preingreso.nombres) AS trabajador,
					   asistencia.cod_cliente, clientes.nombre AS cliente,
					   asistencia.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion,
					   asistencia.cod_concepto, conceptos.descripcion AS concepto,
					   conceptos.abrev, asistencia.hora_extra,
					   asistencia.vale
				  FROM asistencia , ficha,  preingreso, trab_roles, clientes ,
				       clientes_ubicacion , conceptos
			     WHERE asistencia.cod_as_apertura = '$cod_apertura'         
				   AND asistencia.cod_ficha = ficha.cod_ficha
			       AND ficha.cedula = preingreso.cedula	          
			       AND ficha.cod_ficha = trab_roles.cod_ficha
			       AND asistencia.cod_cliente = clientes.codigo 
				   AND asistencia.cod_ubicacion = clientes_ubicacion.codigo 
				   AND asistencia.cod_concepto = conceptos.codigo
				   AND trab_roles.cod_rol = '$cod_rol'
			  ORDER BY 3 ASC";

   // TODO LOS CLIENTES
	$sql_cliente = "SELECT clientes_ubicacion.cod_cliente, clientes.nombre AS cliente
				      FROM usuario_clientes ,  clientes_ubicacion , clientes
			         WHERE usuario_clientes.cod_usuario = '$usuario'
				       AND usuario_clientes.cod_ubicacion = clientes_ubicacion.codigo  
				       AND clientes_ubicacion.`status` = 'T'
				       AND clientes_ubicacion.cod_cliente = clientes.codigo
				       AND clientes.`status` = 'T'
			      GROUP BY clientes_ubicacion.cod_cliente
			      ORDER BY 2 ASC";

				if($fech_LV == 0){						
				/*	$sql04 = "SELECT conceptos.codigo, conceptos.descripcion, conceptos.abrev
					            FROM conceptos
							   WHERE conceptos.`status` = 'T'
							     AND conceptos.cod_concep_semana <> 'L_S'
							   ORDER BY 2 ASC";*/
				
					$sql_conceptos = "SELECT conceptos.codigo, conceptos.descripcion, conceptos.abrev 
					                    FROM conceptos 
									   WHERE conceptos.`status` = 'T'
                                         AND conceptos.asist_diaria = 'S'
						            ORDER BY 3 ASC";
					}else{
					$sql_conceptos = "SELECT conceptos.codigo, conceptos.descripcion, conceptos.abrev 
					                    FROM conceptos
								       WHERE conceptos.`status` = 'T'
								         AND conceptos.asist_diaria = 'S'
						            ORDER BY 3 ASC";											
					}?>


<div align="center" class="etiqueta_title"> ASISTENCIA NOMINA: <?php echo $row04['contracto'].'   '.conversion($fec_nomina).'';?> 
<br /> <br /> FECHA DIARIA:&nbsp;<?php echo conversion($fec_diaria); ?> </div> 
<!--<hr />-->
<div id="Contendor01" class="mensaje"></div>
<fieldset>
<legend>Filtros:</legend>
	<table width="98%">
		<tr><td width="10%">Nomina: </td>
			<td width="40%"><select  id="nomina" style="width:235px;" onchange="FiltarNomina(this.value)">
					<option value="<?php echo $co_cont?>"><?php echo $contracto; ?></option> 
					<?php 
				$sql03 = "SELECT contractos.codigo, contractos.descripcion AS contracto, asistencia_apertura.fec_diaria
                            FROM usuario_roles , trab_roles, ficha, contractos , asistencia_apertura, asistencia_cierre
						   WHERE usuario_roles.cod_usuario = '$usuario' 
							 AND usuario_roles.cod_rol = trab_roles.cod_rol 
							 AND trab_roles.cod_ficha = ficha.cod_ficha 
							 AND ficha.cod_contracto = contractos.codigo
						 	 AND asistencia_apertura.`status` = 'T' 
							 AND contractos.codigo = asistencia_apertura.cod_contracto 
							 AND asistencia_apertura.codigo = asistencia_cierre.cod_as_apertura
							 AND usuario_roles.cod_rol = asistencia_cierre.cod_rol
							 AND contractos.codigo = asistencia_cierre.cod_contracto
							 AND asistencia_cierre.`status` = 'T'
							 AND contractos.codigo <> '$co_cont'
						GROUP BY contractos.codigo
					    ORDER BY 2 ASC";
	   			$query03 = $bd->consultar($sql03);		
		 		while($row03=$bd->obtener_fila($query03,0)){							   							
					 echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';						   		
			   }?></select></td>
			<td width="10%"> Roles: </td>
			<td width="40%"><select id="roles" style="width:235px;" onchange="FiltarRol(this.value)"> 
<?php  echo '<option value="'.$cod_rol.'">'.$roles.'</option>';
	$sql03 = "SELECT DISTINCT roles.codigo, roles.descripcion AS rol
               FROM asistencia_apertura , asistencia_cierre , usuario_roles,  roles
              WHERE asistencia_apertura.`status` = 'T' 
			    AND asistencia_apertura.cod_contracto = '$co_cont' 
			    AND asistencia_apertura.codigo = asistencia_cierre.cod_as_apertura 
				AND asistencia_apertura.cod_contracto = asistencia_cierre.cod_contracto 
				AND usuario_roles.cod_usuario = '$usuario'
				AND usuario_roles.cod_rol = roles.codigo
				AND asistencia_cierre.cod_rol = roles.codigo
           ORDER BY 2 ASC";
			$query03 = $bd->consultar($sql03);			   
				while($row03=$bd->obtener_fila($query03,0)){		 					
					 echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';						   		
			   }?></select>&nbsp;&nbsp;</td>

</tr>
</table>
</fieldset>
<div align="right"><span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                    <input type="button" id="Dia_Anterior"  value="Replicar Dia Anterior" class="readon art-button" onclick="Replicar()" />
                </span><br /></div>
<div id="listar"><form id="asistencia_01" name="asistencia_01" action="scripts/sc_asistencia.php"
                       method="post"><table width="100%" border="0" align="center">	
		<tr class="fondo00">			
            <th width="8%" class="etiqueta">Codigo</th>
            <th width="30%" class="etiqueta">Trabajador</th>		
			<th width="20%" class="etiqueta">Cliente</th>			
   			<th width="20%" class="etiqueta">Ubicacion</th>
			<th width="8%" class="etiqueta">Concepto</th>
			<th width="6%" class="etiqueta">Hora<br />Sobre<br />Tiempo</th>
            <th width="6%" class="etiqueta">Vale</th>	
			<th width="6%"><img src="imagenes/loading2.gif" width="40px" height="40px"/></th> 
		</tr> 
     <?php	echo '<tr class="fondo01"><td>&nbsp;</td>
             	 <td><select name="trabajador" id="trabajador" style="width:220px;"> 
							   <option value="">seleccione...</option>';
							   	$query03 = $bd->consultar($SQL_TRAB); 
							   while($row03=$bd->obtener_fila($query03,0)){
									 echo '<option value="'.$row03[0].'">'.$row03[1].'&nbsp;('.$row03[0].')</option>';
							   } echo'</select></td> 				
				<td><select name="cliente" id="cliente" style="width:160px;" 
							onchange="Actualizar02(this.value)">	 
						   <option value="">Seleccione...</option>';	
	   				$query03 = $bd->consultar($sql_cliente); 			
						   while($row03=$bd->obtener_fila($query03,0)){
						   echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
						   }
			echo'</select></td>
			  <td id="ubicacionX"><select name="ubicacion" id="ubicacion" style="width:150px;" onchange="spryValidarSelect(this.id)">	 
						   <option value="">seleccione...</option>';
				echo'</select></td> 
			  <td><select name="concepto" id="concepto" style="width:75px"><option value="">Selec...</option>';			
					$query04 = $bd->consultar($sql_conceptos); 	
					   while($row04=$bd->obtener_fila($query04,0)){	echo '<option value="'.$row04[0].'">'.$row04[2].'</option>';
					   }echo'</select></td>
			  <td><input type="text" name="horaS" id="horaS" style="width:45px" maxlength="3"/></td>
  			  <td><input type="text" name="vale" id="vale" style="width:45px" value="0"/></td>'; ?>				  
			  <td align="center"><span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                 <input type="button" name="submit" id="submit" value="Ingresar" class="readon art-button" onclick="Ingresar()" />	
                </span></td>  
		</tr> 
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
		 $fechaX  = conversion($fecha);
		 $campo_id = $datos[0];
        echo '<tr class="'.$fondo.'"><td>'.$datos["cod_ficha"].'</td>
		                 <td><select id="trabajadores'.$i.'" style="width:220px;" 
						        onchange="spryValidarSelect(this.id)">	 
							  <option value="'.$datos["cod_ficha"].'">'.$datos["trabajador"].'&nbsp;('.$datos["cod_ficha"].')</option>';
							$query03 = $bd->consultar($SQL_TRAB);
							   while($row03=$bd->obtener_fila($query03,0)){
							   		echo '<option value="'.$row03[0].'">'.$row03[1].'&nbsp;('.$row03[0].')</option>';				   		
							   }
				echo'</select><input type="hidden" id="trabajadores_old'.$i.'" value="'.$datos["cod_ficha"].'"/></td> 
				  <td> <select id="cliente'.$i.'" style="width:160px;"
						        onchange="Actualizar01(this.value, '.$i.')">	 
							   <option value="'.$datos["cod_cliente"].'">'.$datos["cliente"].'</option>';							   
			
							$query03 = $bd->consultar($sql_cliente); 					
						   while($row03=$bd->obtener_fila($query03,0)){
						   echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
						   }echo'</select> </td>
				  <td id="ubicacionX'.$i.'"><select id="ubicacion'.$i.'" style="width:150px;" onchange="spryValidarSelect(this.id)"> 
							   <option value="'.$datos["cod_ubicacion"].'">'.$datos["ubicacion"].'</option>';
		$sql_ubicacion = "SELECT usuario_clientes.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion
                            FROM usuario_clientes , clientes_ubicacion
                           WHERE usuario_clientes.cod_usuario = '$usuario' 
                             AND usuario_clientes.cod_ubicacion = clientes_ubicacion.codigo  
                             AND clientes_ubicacion.cod_cliente = '".$datos["cod_cliente"]."'
                             AND clientes_ubicacion.`status` = 'T'
                        ORDER BY 2 ASC "; 
							$query06 = $bd->consultar($sql_ubicacion); 					
							 while($row06=$bd->obtener_fila($query06,0)){
							echo '<option value="'.$row06[0].'">'.$row06[1].'</option>';
							}	
					echo'</select></td> 
           	      <td><select id="concepto'.$i.'" style="width:75px;" onchange="spryValidarSelect(this.id)">	 
							   <option value="'.$datos["cod_concepto"].'">'.$datos["abrev"].'</option>';			
							$query04 = $bd->consultar($sql_conceptos);    
						   while($row04=$bd->obtener_fila($query04,0)){
						   echo '<option value="'.$row04[0].'">'.$row04[2].'</option>';}echo'</select><input type="hidden" id="ubicacion_old'.$i.'"  value="'.$datos["cod_ubicacion"].'"/><input type="hidden" id="concepto_old'.$i.'"  value="'.$datos["cod_concepto"].'"/></td>				
	   		    <td><input type="text" id="horaS'.$i.'" style="width:45px" value="'.$datos["hora_extra"].'" maxlength="3" /></td>
	   		    <td><input type="text" id="vale'.$i.'" style="width:45px" value="'.$datos["vale"].'" /></td>				
			    <td align="center"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Actualizar Registro" border="null" width="20px" height="20px" class="imgLink" id="'.$i.'" onclick="ValidarSubmit(this.id)" />&nbsp;<img src="imagenes/borrar.bmp" alt="Borrar" title="Borrar Registro" border="null" class="imgLink" width="20px" height="20px" id="'.$i.'" onclick="Borrar_Campo(this.id)"/></td> 					
			</tr>'; 
        }?>          
    <tr>   <td colspan="7"><input type="hidden" id="apertura" name="apertura" value="<?php echo $cod_apertura;?>" /><input 
                               type="hidden" id="contracto" name="contracto" value="<?php echo $co_cont;?>" /><input 
                               type="hidden" id="Nmenu" name="Nmenu" value="<?php echo $Nmenu;?>" /><input 
                               type="hidden" id="rol" name="rol" value="<?php echo $cod_rol;?>" /><input 
                               type="hidden" name="href"  value="../inicio.php?area=<?php echo $href;?>"/><input 
                               type="hidden" name="metodo" value="agregar"/><input 
                               type="hidden" name="usuario" id="usuario" value="<?php echo $usuario;?>"/><input 
                               type="hidden"  id="i" value="<?php echo $i;?>"/><input 
                               type="hidden" name="trabajador_old" value=""/><input type="hidden"
                                name="ubicacion_old" value=""/><input type="hidden" name="concepto_old" value=""/><input 
                                type="hidden" name="proced" id="proced" value="p_asistencia"/></td>  
		</tr>         
	</table>
</form>	
</div>
<div align="center"><br/>
        <span class="art-button-wrapper">
            <span class="art-button-l"> </span>
            <span class="art-button-r"> </span>
        <input type="button" name="salir" id="salir" value="Salir" onclick="Vinculo('inicio.php?area=formularios/index')" 
               class="readon art-button">
        </span>&nbsp; 
		<span class="art-button-wrapper">
            <span class="art-button-l"> </span>
            <span class="art-button-r"> </span>
            <input type="button" name="cerrar" id="cerrar" value="Cerrar Dia" onclick="CerrarDia()" class="readon art-button">  
        </span>&nbsp;
		<span class="art-button-wrapper">
            <span class="art-button-l"> </span>
            <span class="art-button-r"> </span>
            <input type="button" name="trab_reportar" id="trab_reportar" value="Trab. Por Reportar" onclick="TrabReportar()" 
                   class="readon art-button" >
        </span>         
</div>
<script language="javascript" type="text/javascript">
var trabajadores = new Spry.Widget.ValidationSelect('trabajador', {validateOn:["blur", "change"]});
var cliente      = new Spry.Widget.ValidationSelect('cliente', {validateOn:["blur", "change"]});
var concepto     = new Spry.Widget.ValidationSelect('concepto', {validateOn:["blur", "change"]});
var horaS_XY     = new Spry.Widget.ValidationTextField("horaSalida", "currency", {format:"comma_dot",validateOn:["blur"], useCharacterMasking:true, minValue:"0", maxValue:"12" ,isRequired:false});
var Vvale    = new Spry.Widget.ValidationTextField("vale", "currency", {format:"comma_dot",validateOn:["blur"], useCharacterMasking:true, minValue:"0", maxValue:"6" ,isRequired:false});
// VALIDAR HORA
	var incX = document.getElementById("i").value;	
	var 	inc =	++incX;
	for (i = 1; i < inc; i++){	
		var ValorN = "horaS"+i+"";
		var Vvale  = "vale"+i+"";

	var ValorN = new Spry.Widget.ValidationTextField(ValorN, "currency", {format:"comma_dot",validateOn:["blur"], useCharacterMasking:true, minValue:"0", maxValue:"12"});
	var Vale   = new Spry.Widget.ValidationTextField(Vvale, "currency", {format:"comma_dot",validateOn:["blur"], useCharacterMasking:true, minValue:"0", maxValue:"6"});
	}

function spryValidarSelect(ValorN){
 var ValorN = new Spry.Widget.ValidationSelect(ValorN, {validateOn:["blur", "change"]});
}
</script>