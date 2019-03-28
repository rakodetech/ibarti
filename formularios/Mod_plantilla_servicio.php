<?php 
$bd = new DataBase();

$Nmenu    = 424; 
$mod      = $_GET['mod'];
$codigo   = $_GET['codigo'];
$fecha   = $_GET['fecha'];
$region   = $_GET['region'];
$titulo   = " PLANTILLA DE HOMBRES PRODUCTOS POR MES: ".conversion($fecha)."";
$archivo = $_GET['archivo'];
$archivo2  = "$archivo&Nmenu=Nmenu";
$proced      = "p_plantilla_servicio"; 
require_once('autentificacion/aut_verifica_menu.php');
	
$sql = " SELECT clientes.nombre AS cliente, plantilla_mensual.cod_apertura, 
                plantilla_mensual.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion, 
				plantilla_mensual.diurno_LV, plantilla_mensual.diurno_S,
				plantilla_mensual.diurno_D, plantilla_mensual.mixto_LV,
				plantilla_mensual.mixto_S, plantilla_mensual.mixto_D,
				plantilla_mensual.noturno_LV, plantilla_mensual.noturno_S,
				plantilla_mensual.noturno_D, plantilla_mensual.24_LV,
				plantilla_mensual.24_S,plantilla_mensual.24_D
		   FROM plantilla_mensual_apertura, plantilla_mensual , clientes , clientes_ubicacion 
          WHERE plantilla_mensual_apertura.fec_diaria = '$fecha' 
            AND plantilla_mensual_apertura.`status` = 'T'
            AND plantilla_mensual_apertura.codigo = plantilla_mensual.cod_apertura
            AND plantilla_mensual.cod_ubicacion = clientes_ubicacion.codigo 
            AND clientes_ubicacion.cod_cliente = clientes.codigo 
            AND clientes_ubicacion.cod_region = '$region' ORDER BY 1, 2 ASC  ";

	$sql01 = "SELECT regiones.descripcion FROM  regiones WHERE  regiones.codigo = '$region' ORDER BY 1 ASC";
	$query  = $bd->consultar($sql01);
	$row01 = $bd->obtener_fila($query,0);
?>
<br>
<div align="center" class="etiqueta_title"> <?php echo $titulo, '<br /> REGION: '.$row01[0];?></div> 
<hr />
<fieldset>
<legend>Filtro: <?php  echo $row01[0];?></legend>
<table border="0" width="100%">
<tr><td width="14%">Region:</td>
<td width="20%"><select id="REGION" style="width:200px;" onchange="Add_filtroX(this.value, this.id, 'listar')"> 
<option value="">Seleccione...</option>
<?php  		   
	$sql01 ="SELECT clientes_ubicacion.cod_region  , regiones.descripcion AS region
               FROM plantilla_mensual_apertura , clientes_ubicacion, regiones 
              WHERE plantilla_mensual_apertura.`status` = 'T'       
                AND plantilla_mensual_apertura.cod_cliente = clientes_ubicacion.cod_cliente
                AND clientes_ubicacion.cod_region = regiones.codigo
                AND plantilla_mensual_apertura.fec_diaria = '$fecha'
		   GROUP BY clientes_ubicacion.cod_region  ORDER BY 2 ASC";
	$query  = $bd->consultar($sql01);	
		   while($row02 = $bd->obtener_fila($query,0)){							
					 echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';						   		
			   }?>
			</select></td>
<td width="13%">Estado:</td>
<td width="20%"><select id="ESTADO" style="width:200px;" onchange="Add_filtroX(this.value, this.id, 'listar')"> 
<option value="">Seleccione...</option>
<?php  		   
	$sql01 ="SELECT estados.codigo , estados.descripcion AS estados
               FROM plantilla_mensual_apertura , clientes_ubicacion, estados
              WHERE plantilla_mensual_apertura.`status` = 'T'       
                AND plantilla_mensual_apertura.cod_cliente = clientes_ubicacion.cod_cliente
                AND clientes_ubicacion.cod_estado = estados.codigo
                AND plantilla_mensual_apertura.fec_diaria = '$fecha'
		   GROUP BY estados.codigo ORDER BY 2 ASC";
	$query  = $bd->consultar($sql01);
	
		   while($row02 = $bd->obtener_fila($query,0)){							
					 echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';						   		
			   }?></select></td>
<td width="13%">Clientes:</td>
<td width="20%"><select  id="CLIENTE" style="width:200px;" onchange="Add_filtroX(this.value, this.id, 'listar')"> 
<option value="">Seleccione...</option>
<?php  		   
	$sql01 ="SELECT clientes.codigo,clientes.nombre AS cliente
               FROM plantilla_mensual_apertura , clientes
              WHERE plantilla_mensual_apertura.`status` = 'T'       
                AND plantilla_mensual_apertura.cod_cliente = clientes.codigo
                AND plantilla_mensual_apertura.fec_diaria = '$fecha'
		   GROUP BY 1 ORDER BY 2 ASC";
	$query  = $bd->consultar($sql01);
	
		   while($row02 = $bd->obtener_fila($query,0)){							
					 echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';						   		
			   }?>
			</select></td>
            <td width="33%">&nbsp;</td>
</tr>
</table>
</fieldset>
<div id="Contenedor01" class="mensaje"></div>
<div id="listar"><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="28%" class="etiqueta">Cliente </th>
			<th width="25%" class="etiqueta">Ubicacion</th>
			<th width="10%" class="etiqueta">Diurno <br /> L-V &nbsp;&nbsp; S &nbsp;&nbsp; D </th>
			<th width="10%" class="etiqueta">Nocturno<br /> L-V &nbsp;&nbsp; S &nbsp;&nbsp; D </th>
			<th width="10%" class="etiqueta">Mixto<br /><br /> L-V &nbsp;&nbsp; S &nbsp;&nbsp; D </th>		
        	<th width="10%" class="etiqueta">24 Hora<br /> L-V &nbsp;&nbsp; S &nbsp;&nbsp; D </th>
		    <th width="7%"><a href="inicio.php?area=formularios/add_plantilla_servicio2&Nmenu=<?php echo $Nmenu."&codigo=".$fecha."&mod=$mod";?>"><img src="imagenes/nuevo.bmp" alt="Agregar Registro" width="25px" height="25px" title="Agregar Registro" border="null" /></a></th> 
		</tr>
    <?php   
	   $query = $bd->consultar($sql);
        $i = 0;
		$valor = 0;
		while ($datos=$bd->obtener_fila($query,0)){
		$i++;
		
		if ($valor == 0){
			$fondo = 'fondo01';
			$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;		
		}		
	   $conf = "Actualizar('".$i."', '".$datos['cod_apertura']."', '".$datos['cod_ubicacion']."')";
        echo '<tr class="'.$fondo.'"> 
				  <td class="texto">'.utf8_decode($datos['cliente']).'</td>
				  <td class="texto">'.utf8_decode($datos['ubicacion']).'</td>
			      <td class="texto"><input type="text" id="diurno_LV'.$i.'" name="diurno_LV'.$i.'" style="width:22px" 
				         value="'.$datos['diurno_LV'].'" maxlength="2" />&nbsp;<input type="text" id="diurno_S'.$i.'" 
						 name="diurno_S'.$i.'" style="width:22px" value="'.$datos['diurno_S'].'" onclick="spryValidarInput(this.id)"
						 maxlength="2" />&nbsp;<input type="text" id="diurno_D'.$i.'" name="diurno_D'.$i.'" style="width:22px" 
				         value="'.$datos['diurno_D'].'" maxlength="2" /></td>
			      <td class="texto"><input type="text" id="noturno_LV'.$i.'" name="noturno_LV'.$i.'" style="width:22px" 
					       value="'.$datos['noturno_LV'].'"  onclick="spryValidarInput(this.id)" 
						 maxlength="2" />&nbsp;<input type="text" id="noturno_S'.$i.'" 
						   name="noturno_S'.$i.'" style="width:22px"  
					       value="'.$datos['noturno_S'].'" onclick="spryValidarInput(this.id)"
						   maxlength="2"  />&nbsp;<input type="text" id="noturno_D'.$i.'" name="noturno_D'.$i.'" style="width:22px" 
					       value="'.$datos['noturno_D'].'" onclick="spryValidarInput(this.id)" maxlength="2" /></td>
			      <td class="texto"><input type="text" id="mixto_LV'.$i.'" name="mixto_LV'.$i.'" style="width:22px" 
					       value="'.$datos['mixto_LV'].'" onclick="spryValidarInput(this.id)" maxlength="2" />&nbsp;<input type="text" id="mixto_S'.$i.'" name="mixto_S'.$i.'" style="width:22px" 
					       value="'.$datos['mixto_S'].'" onclick="spryValidarInput(this.id)" maxlength="2" />&nbsp;<input type="text" id="mixto_D'.$i.'" name="mixto_D'.$i.'" style="width:22px" 
					       value="'.$datos['mixto_D'].'" onclick="spryValidarInput(this.id)"  maxlength="2" /></td>
				  <td class="texto"><input type="text" id="h24_LV'.$i.'" name="h24_LV'.$i.'" style="width:22px" 
					       value="'.$datos['24_LV'].'" onclick="spryValidarInput(this.id)" maxlength="2" />&nbsp;<input type="text" id="h24_S'.$i.'" name="h24_S'.$i.'" style="width:22px" 
					       value="'.$datos['24_S'].'" onclick="spryValidarInput(this.id)" maxlength="2" />&nbsp;<input type="text" id="h24_D'.$i.'" name="h24_D'.$i.'" style="width:22px" 
					       value="'.$datos['24_D'].'" onclick="spryValidarInput(this.id)" maxlength="2" /></td>
			      <td align="center"><img src="imagenes/actualizar.bmp" alt="Modificar"title="Modificar Registro" width="25px" 
				       height="25px" border="null" class="imgLink" onclick="'.$conf.'"/></td> 								
            </tr>'; 
	    }  
	?>	
	</table>	
    
  </div><div><input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo;?>" />
   	<input type="hidden" name="fecha" id="fecha" value="<?php echo $fecha;?>" />
    <input type="hidden" name="fecha2" id="fecha2" value="<?php echo Rconversion($fecha);?>" />
	<input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario;?>" />
	<input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
    <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
    <input type="hidden" name="archivo" id="archivo" value="<?php echo $archivo;?>" />
    <input type="hidden" name="proced" id="proced" value="<?php echo $proced;?>" />
</div> 
<br />
<script language="javascript" type="text/javascript">


function Add_filtroX(codigo, filtro, contenido){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO//

	 if((codigo!='') || (filtro !='')){

	 	var fecha = document.getElementById("fecha").value; 
		ajax=nuevoAjax();
			ajax.open("POST", "ajax/Add_plantilla_servicio.php", true);
			ajax.onreadystatechange=function(){ 
				if (ajax.readyState==4){
		        document.getElementById(contenido).innerHTML = ajax.responseText;					
				}
			} 
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("codigo="+codigo+"&filtro="+filtro+"&fecha="+fecha+"");
	}else{
		 	alert("Debe de Seleccionar Un Campo ");
	 }
}


	function spryValidarInput(ValorN){
		var ValorN = new Spry.Widget.ValidationTextField(ValorN, "real", {validateOn:["blur", "change"], useCharacterMasking:true});
	}

function Actualizar(auto, apertura, ubicacion){
	var fecha         = document.getElementById("fecha").value; 
	var proced         = document.getElementById("proced").value;
	var usuario        = document.getElementById("usuario").value;
	
	var diurno_LV      = document.getElementById("diurno_LV"+auto+"").value;
	var diurno_S       = document.getElementById("diurno_S"+auto+"").value;
	var diurno_D       = document.getElementById("diurno_D"+auto+"").value;
	var noturno_LV     = document.getElementById("noturno_LV"+auto+"").value;
	var noturno_S      = document.getElementById("noturno_S"+auto+"").value;
	var noturno_D      = document.getElementById("noturno_D"+auto+"").value;
	var mixto_LV       = document.getElementById("mixto_LV"+auto+"").value;
	var mixto_S        = document.getElementById("mixto_S"+auto+"").value;
	var mixto_D        = document.getElementById("mixto_D"+auto+"").value;
	var h24_LV         = document.getElementById("h24_LV"+auto+"").value;
	var h24_S          = document.getElementById("h24_S"+auto+"").value;
	var h24_D          = document.getElementById("h24_D"+auto+"").value;

	var valor = "scripts/sc_plantilla_servicio.php"; 
	ajax=nuevoAjax();
		ajax.open("POST", valor, true);
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==4){
			document.getElementById("Contenedor01").innerHTML = ajax.responseText;
			//window.location.href=""+href+"";							 	
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("codigo="+apertura+"&fecha="+fecha+"&ubicacion="+ubicacion+"&diurno_LV="+diurno_LV+"&diurno_S="+diurno_S+"&diurno_D="+diurno_D+"&noturno_LV="+noturno_LV+"&noturno_S="+noturno_S+"&noturno_D="+noturno_D+"&mixto_LV="+mixto_LV+"&mixto_S="+mixto_S+"&mixto_D="+mixto_D+"&h24_LV="+h24_LV+"&h24_S="+h24_S+"&h24_D="+h24_D+"&usuario="+usuario+"&proced="+proced+"&metodo=modificar&href=&status=T");
}   		
</script>